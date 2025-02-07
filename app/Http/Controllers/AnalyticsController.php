<?php

namespace App\Http\Controllers;

use App\Models\Articulos;
use App\Models\ArticulosCategorias;
use App\Models\Banco;
use App\Models\Cita;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Empresa;
use App\Models\lineasCompras;
use App\Models\Operarios;
use App\Models\OrdenesTrabajo;
use App\Models\PagosCompras;
use App\Models\PartesTrabajo;
use App\Models\PartesTrabajoLineas;
use App\Models\Presupuestos;
use App\Models\Project;
use App\Models\Proveedor;
use App\Models\Trabajos;
use App\Models\Ventas;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AnalyticsController extends Controller
{
    public function index(){

        // ventas
        $ventas = Ventas::JOIN('ventas_lineas_sl', 'ventas_sl.idVenta', '=', 'ventas_lineas_sl.venta_id')
            ->get();

        // Importaciones
        $projects = Project::all();
        $clientes = Cliente::all();
        $trabajos = Trabajos::all();
        $empresas = Empresa::all();
        $proveedores = Proveedor::all();
        $operarios = Operarios::all();
        $compras   = Compra::all();
        $articulos = Articulos::all();
        $partes = PartesTrabajo::all();
        $ordenes = OrdenesTrabajo::all();
        $citas = Cita::all();
        $categorias = ArticulosCategorias::all();
        $trazabilidades = lineasCompras::select('trazabilidad', 'compra_id')->distinct()->get();

        // Totalizadores del mes en curso
        $mesEnCurso = Carbon::now()->format('m');

        $totalVentas            = Ventas::WhereMonth('FechaVenta', $mesEnCurso)->sum('TotalFacturaVenta');
        $totalCompras           = Compra::WhereMonth('fechaCompra', $mesEnCurso)->sum('totalExacto');
        $totalPagos             = PagosCompras::WhereMonth('FechaPagosCompras', $mesEnCurso)->sum('Importe');
        $totalPartesSinFacturar = PartesTrabajo::Where('estadoVenta', 1)->WhereMonth('FechaAlta', $mesEnCurso)->sum('suma');
        $totalPartesSinFacturarCount = PartesTrabajo::Where('estadoVenta', 1)->WhereMonth('FechaAlta', $mesEnCurso)->count();
        $presupuestos           = Presupuestos::WhereMonth('FechaAlta', $mesEnCurso)->sum('suma');
        $presupuestosCount      = Presupuestos::WhereMonth('FechaAlta', $mesEnCurso)->count();
        $totalCobros            = Ventas::WhereMonth('FechaVenta', $mesEnCurso)->sum('Cobrado');

        $articulosMasVendidos = PartesTrabajoLineas::select(
            'articulo_id',
            DB::raw('SUM(cantidad) as total_cantidad'),
            DB::raw('COUNT(idMaterial) as total_uso')
        )
        ->with('articulo:idArticulo,nombreArticulo,categoria_id,TrazabilidadArticulos', 'articulo.compras.lineas', 'articulo.imagenes') // Relación con Artículos
        ->whereHas('articulo', function($query){
            $query->whereNotIn('categoria_id', [8, 9, 10]);
        })
        ->groupBy('articulo_id')
        ->orderByDesc('total_cantidad')
        ->get();

        // nombre corto del mes en curso
        $mesEnCurso = Carbon::now()->format('F');

        // acortar el nombre del mes
        $mesEnCurso = substr($mesEnCurso, 0, 3);

        $empresas = Empresa::all();
        $bancos   = Banco::all();
        $ciudades = Ciudad::all();

        return view('admin.analytics.index', compact(
            'totalVentas',
            'empresas',
            'bancos',
            'ciudades',
            'categorias',
            'totalCompras',
            'totalPagos',
            'totalPartesSinFacturar',
            'trazabilidades',
            'totalPartesSinFacturarCount',
            'presupuestos',
            'presupuestosCount',
            'mesEnCurso',
            'projects',
            'clientes',
            'trabajos',
            'empresas',
            'proveedores',
            'operarios',
            'compras',
            'articulos',
            'partes',
            'ordenes',
            'citas',
            'ventas',
            'totalCobros',
            'articulosMasVendidos'
        ));
    }

    public function obtenerResumen(Request $request){
        $empresaId = $request->get('empresa_id');
        $periodo = $request->get('periodo', 'mensual');

        // Determinar rango de fechas
        $fechaInicio = now();
        $fechaFin = now();

        switch ($periodo) {
            case 'trimestral':
                $fechaInicio = now()->subMonths(3);
                break;
            case 'anual':
                $fechaInicio = now()->subYear();
                break;
            default: // mensual
                $fechaInicio = now()->subMonth();
                break;
        }

        $filtros = [
            ['empresa_id', '=', $empresaId],
            ['created_at', '>=', $fechaInicio],
            ['created_at', '<=', $fechaFin],
        ];

        // Determinar formato de agrupación
        $groupFormat = '';
        switch ($periodo) {
            case 'mensual':
                $groupFormat = "DATE_FORMAT(created_at, '%Y-%m')";
                break;
            case 'trimestral':
                $groupFormat = "CONCAT(YEAR(created_at), '-', QUARTER(created_at))";
                break;
            case 'anual':
                $groupFormat = "YEAR(created_at)";
                break;
            default:
                throw new InvalidArgumentException("Período no válido: $periodo");
        }

        // Ventas agrupadas por período e IVA
        $ventas = Ventas::where($filtros)
            ->whereHas('ventaConfirm')
            ->selectRaw("
                SUM(ImporteVenta) as totalImporte,
                SUM(TotalIvaVenta) as totalIva,
                (SUM(ImporteVenta) + SUM(TotalIvaVenta)) as total,
                IvaVenta as porcentajeIVA,
                COUNT(*) as cantidad,
                $groupFormat as periodo
            ")
            ->groupByRaw("periodo, porcentajeIVA")
            ->get();

        $Albaranes = Ventas::where($filtros)
            ->whereDoesntHave('ventaConfirm')
            ->whereNotNull('ImporteVenta')
            ->whereNotNull('TotalIvaVenta')
            ->selectRaw("
                SUM(ImporteVenta) as totalImporte,
                SUM(TotalIvaVenta) as totalIva,
                (SUM(ImporteVenta) + SUM(TotalIvaVenta)) as total,
                IvaVenta as porcentajeIVA,
                COUNT(*) as cantidad,
                $groupFormat as periodo
            ")
            ->groupByRaw("periodo, porcentajeIVA")
            ->get();


        // Compras agrupadas por período e IVA
        $compras = Compra::where($filtros)
            ->selectRaw("
                SUM(Importe) as totalImporte,
                SUM(totalIva) as totalIva,
                (SUM(Importe) + SUM(totalIva)) as total,
                Iva as porcentajeIVA,
                COUNT(*) as cantidad,
                $groupFormat as periodo
            ")
            ->groupByRaw("periodo, porcentajeIVA")
            ->get();

        // Respuesta JSON
        return response()->json([
            'ventas' => $ventas,
            'compras' => $compras,
            'albaranes' => $Albaranes,
            'empresa_id' => $empresaId,
            'periodo' => $periodo,
        ]);
    }


    public function resumendetails(Request $request){
        try {
            
            $tipo = $request->tipo;
            $periodo = $request->selector;
            $empresaId = $request->empresa;
            $mes = $request->periodo;
            $iva = $request->iva;

            // Determinar rango de fechas
            switch ($periodo) {
                case 'trimestral':
                    $fechaInicio = now()->subMonths(3);
                    $fechaFin = now();
                    $filtros = [
                        ['empresa_id', '=', $empresaId],
                        ['created_at', '>=', $fechaInicio],
                        ['created_at', '<=', $fechaFin],
                    ];
                    break;
                case 'anual':
                    $fechaInicio = now()->subYear();
                    $fechaFin = now();
                    $filtros = [
                        ['empresa_id', '=', $empresaId],
                        ['created_at', '>=', $fechaInicio],
                        ['created_at', '<=', $fechaFin],
                    ];
                    break;
                default: // mensual
                    $fechaInicio    = Carbon::parse($mes)->startOfMonth();
                    $fechaFin       = Carbon::parse($mes)->endOfMonth();
                    $filtros = [
                        ['empresa_id', '=', $empresaId],
                        ['created_at', '>=', $fechaInicio],
                        ['created_at', '<=', $fechaFin],
                    ];
                    break;
            }

            switch ($tipo) {
                case 'venta':
                    $model = Ventas::with('cliente', 'empresa', 'plazo', 'ventaLineas', 'ventaConfirm')->whereHas('ventaConfirm');
                    $filtros[] = ['IvaVenta', '=', $iva];
                    break;
                case 'Albaran':
                    $model = Ventas::with('cliente', 'empresa', 'plazo', 'ventaLineas', 'ventaConfirm')->whereDoesntHave('ventaConfirm');
                    $filtros[] = ['IvaVenta', '=', $iva];
                    break;
                case 'compra':
                    $model = Compra::with('empresa', 'proveedor', 'plazos', 'archivos', 'plazos', 'lineas', 'pagosCompras');
                    $filtros[] = ['Iva', '=', $iva];
                    break;
                default:
                    throw new InvalidArgumentException("Tipo no válido: $tipo");
            }

            $resumen = $model->where($filtros)->get();
            $empresa = Empresa::with('tipo')->find($empresaId);

            return response()->json([
                'datos' => $resumen,
                'empresa' => $empresa,
                'periodo' => $periodo,
            ]);

        } catch (\Throwable $th) {
            throw new Exception("Error al obtener detalles del resumen: " . $th->getMessage());
        }
    }

    
}
