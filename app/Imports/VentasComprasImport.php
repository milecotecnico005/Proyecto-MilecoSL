<?php

namespace App\Imports;

use App\Models\Compra;
use App\Models\LineasCompras;
use App\Models\LineasVentas;
use App\Models\PlazoCompra;
use App\Models\Ventas;
use App\Models\PartesTrabajo;
use App\Models\PlazoVenta;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class VentasComprasImport implements ToModel, WithHeadingRow{

    public function model(array $row){

        $user = Auth::user();

        DB::transaction(function () use ($row, $user) {

            if (isset($row['cliente_id'])) {
                // buscar el cliente por nif y colocar el id en la variable
                $cliente = DB::table('clientes')->where('CIF', $row['cliente_id'])->first();

                if ($cliente) {
                    $row['cliente_id'] = $cliente->idClientes;
                } else {
                    $row['cliente_id'] = -999;
                }
            }else if( isset($row["proveedor_id"]) ){
                // buscar el proveedor por nif y colocar el id en la variable
                $proveedor = DB::table('proveedores')->where('cifProveedor', $row['proveedor_id'])->first();

                if ($proveedor) {
                    $row['proveedor_id'] = $proveedor->idProveedor;
                } else {
                    $row['proveedor_id'] = -999;
                }
            }

            if ($row['tipo_movimiento'] === 'Venta') {
                // calcular el total del iva
                $totalIvaVenta      = $row['importeventa'] * ($row['ivaventa'] / 100);
                $suplidos           = $row['suplidosventa'];
                $totalFacturaVenta  = $row['totalfacturaventa'] + $totalIvaVenta + $suplidos;
                $retenciones        = $row['totalfacturaventa'] - $totalFacturaVenta;

                $totalFinal = $row['totalfacturaventa'] + $totalIvaVenta + $suplidos - $retenciones;

                // calcular el cobrado segun el total de la factura y el pendiente
                $cobrado = $row['totalfacturaventa'] - $row['pendienteventa'];

                $venta = Ventas::create([
                    'FechaVenta' => $row['fechaventa'],
                    'empresa_id' => $row['empresa_id'],
                    'cliente_id' => $row['cliente_id'],
                    'FormaPago' => $row['formapago'],
                    'ImporteVenta' => $row['importeventa'],
                    'IvaVenta' => $row['ivaventa'],
                    'TotalIvaVenta' => $totalIvaVenta,
                    'TotalFacturaVenta' => $row['totalfacturaventa'],
                    'Plazos' => $row['plazos'],
                    'RetencionesVenta' => $row['retencionesventa'],
                    'Cobrado' => $cobrado,
                    'TotalRetencionesVenta' => $retenciones,
                    'SuplidosVenta' => $row['suplidosventa'],
                    'observaciones' => "Importado desde excel. ".$row['observaciones'],
                    'notas1' => $row['notas1'],
                    'notas2' => "Total Calculado por la app: $totalFinal. ".$row['notas2'],
                    'AgenteVenta' => $user->name,
                    'EnviadoVenta' => $user->email,
                    'PendienteVenta' => $row['pendienteventa'],
                    'NAsientoContable' => 1,
                    'tipo_doc' => $row['documento'],
                    'num_fac'  => $row['num_fac'],
                ]);

                // Crear líneas genéricas
                LineasVentas::create([
                    'venta_id' => $venta->idVenta,
                    'Descripcion' => 'Artículos Varios',
                    'Cantidad' => 1,
                    'precioSinIva' => $venta->ImporteVenta,
                    'total' => $venta->TotalFacturaVenta,
                    'descuento' => 0,
                    'observaciones' => 'Venta Importada desde Excel',
                    'userAction' => $user->id
                ]);

                // Crear plazos
                $this->crearPlazos(null, $row['plazos'], $venta->TotalFacturaVenta, $venta->idVenta);
            } elseif ($row['tipo_movimiento'] === 'Compra') {
                // calcular el total del iva
                $totalIvaCompra = $row['importe'] * ($row['iva'] / 100);
                $totalFacturaCompra = $row['totalfactura'] + $totalIvaCompra + $row['suplidoscompras'];
                $retenciones = $row['totalfactura'] - $totalFacturaCompra;

                $totalFinal = $row['totalfactura'] + $totalIvaCompra + $row['suplidoscompras'] - $retenciones;

                $compra = Compra::create([
                    'fechaCompra' => $row['fechacompra'],
                    'empresa_id' => $row['empresa_id'],
                    'NFacturaCompra' => $row['nfacturacompra'],
                    'proveedor_id' => $row['proveedor_id'],
                    'formaPago' => $row['formapago'],
                    'Importe' => $row['importe'],
                    'Iva' => $row['iva'],
                    'retencionesCompras' => $row['retencionescompras'],
                    'suplidosCompras' => $row['suplidoscompras'],
                    'totalFactura' => $totalFinal,
                    'totalExacto' => $row['totalexacto'],
                    'Plazos' => $row['plazos'],
                    'notas1' => $row['notas1'],
                    'notas2' => "Total Calculado por la app: $totalFinal. ".$row['notas2'],
                    'totalIva' => $totalIvaCompra,
                    'NAsientoContable' => 1,
                    'ObservacionesCompras' => $row['observacionescompras'],
                    'tipo_doc' => $row['documento'],
                ]);

                // Crear líneas genéricas
                LineasCompras::create([
                    'compra_id' => $compra->idCompra,
                    'descripcion' => 'Artículos Varios',
                    'cantidad' => 1,
                    'precioSinIva' => $compra->Importe,
                    'total' => $compra->totalFactura,
                    'proveedor_id' => $compra->proveedor_id,
                    'trazabilidad' => 'Compra Importada desde Excel',
                    'userAction' => $user->id
                ]);

                // Crear plazos
                $this->crearPlazos($compra->idCompra, $row['plazos'], $compra->totalFactura);
            }
        });
    }

    private function crearPlazos($id, $plazos, $total, $venta_id = null){
        if ($plazos > 0) {
            $montoPorPlazo = $total / $plazos;
            $user = Auth::user();

            for ($i = 1; $i <= $plazos; $i++) {
                PlazoCompra::create([
                    'compra_id' => $id,
                    'frecuenciaPago' => "Mensual",
                    'fecha_pago' => now()->addMonths($i),
                    'estadoPago' => '2',
                    'notas1' => "Plazo $i de $plazos",
                    'total' => $montoPorPlazo,
                    'userAction' => $user->id,
                    'venta_id' => $venta_id,
                ]);
            }
        }
    }
}
