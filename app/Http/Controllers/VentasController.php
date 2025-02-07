<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\Modelo347;
use App\Models\Archivos;
use App\Models\Articulos;
use App\Models\Banco;
use App\Models\banco_detail;
use App\Models\Cita;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\Empresa;
use App\Models\LineasVentas;
use App\Models\Operarios;
use App\Models\OrdenesTrabajo;
use App\Models\PagosCompras;
use App\Models\PartesTrabajo;
use App\Models\partesTrabajoArchivos;
use App\Models\PartesTrabajoLineas;
use App\Models\PlazoCompra;
use App\Models\Project;
use App\Models\ProyectosPartes;
use App\Models\Trabajos;
use App\Models\trabajos_archivos;
use App\Models\User;
use App\Models\VentaConfirm;
use App\Models\Ventas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use ZipArchive;

class VentasController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $clientes = Cliente::all();
        $empresas = Empresa::all();
        $ventas   = Ventas::with(
            'cliente',
            'empresa',
            'plazo',
            'ventaLineas',
            'ventaConfirm'
        )->get();
        $bancos = Banco::all();
        $projects = Project::all();
        $operarios = Operarios::all();
        $trabajos = Trabajos::all();

        return view('admin.ventas.index', compact('clientes', 'empresas', 'ventas', 'bancos', 'projects', 'operarios', 'trabajos'));
    }


    public function store(Request $request)
    {
        
        try {
            
            $request->validate([
                'FechaVenta'            => 'required|date',
                'AgenteVenta'           => 'required',
                'EnviadoVenta'          => 'required',
                'cliente_id'            => 'required',
                'empresa_id'            => 'required',
                'FormaPago'             => 'required',
                'IvaVenta'              => 'required',
                "Plazos"                => 'required',
                "Cobrado"               => 'required',
                "PendienteVenta"        => 'required', 
                "NAsientoContable"      => 'required',
            ]);
            DB::beginTransaction();

            $venta = Ventas::create([
                'FechaVenta'             => $request->FechaVenta,
                'empresa_id'             => $request->empresa_id,
                'archivoId'              => null,
                'AgenteVenta'            => $request->AgenteVenta,
                'EnviadoVenta'           => $request->EnviadoVenta,
                'cliente_id'             => $request->cliente_id,
                'FormaPago'              => $request->FormaPago,
                'ImporteVenta'           => $request->ImporteVenta,
                'IvaVenta'               => $request->IvaVenta,
                'TotalIvaVenta'          => $request->TotalIvaVenta,
                'RetencionesVenta'       => $request->RetencionesVenta,
                'TotalRetencionesVenta'  => $request->TotalRetencionesVenta,
                'TotalFacturaVenta'      => $request->TotalFacturaVenta,
                'SuplidosVenta'          => $request->SuplidosVenta,
                'Plazos'                 => $request->Plazos,
                'Cobrado'                => $request->Cobrado,
                'PendienteVenta'         => $request->PendienteVenta,
                'NAsientoContable'       => $request->NAsientoContable,
                'Observaciones'          => $request->Observaciones,
                'created_at'             => Carbon::now(),
                'updated_at'             => Carbon::now(),
            ]);

            $cantidadPlazos = intval($request->Plazos);

            // crear la cantidad de cobros segun el valor de plazos
            for ( $i = 1; $i < $cantidadPlazos; $i++ ) {
                // calcular el siguiente mes de acuerdo a la cantidad de plazos
                $fechaPago = Carbon::now()->addMonths($i);
                PlazoCompra::create([
                    'frecuenciaPago' => $request->Plazos,
                    'fecha_pago'     => Carbon::now(),
                    'estadoPago'     => 1,
                    'proximoPago'    => $fechaPago,
                    'venta_id'       => $venta->idVenta,
                    'compra_id'      => null,
                    'userAction'     => Auth::user()->id,
                ]);

            }

            // obtener los partes de trabajos que no esten facturados en lineas de ventas
            $partes = PartesTrabajo::WHERE([ 
                'cliente_id'=> $venta->cliente_id,
                'estadoVenta'=> 1,
                'Estado'=> 3
            ])->get();

            $partesTrabajoController = new PartesTrabajoController();

            if ( count($partes) > 0 ) {
                foreach ($partes as $element) {

                    // verificar el iva del parte de trabajo
                    if( !$element->ivaParte ){
                        $partesTrabajoController->UpdateIvaDescuentoParte($element->idParteTrabajo);
                    }

                    $element["lineas"] = $element->partesTrabajoLineas;

                    if ( count($element["lineas"]) > 0 ) {
                        foreach ($element["lineas"] as $linea) {
                            $linea["articulo"] = $linea->articulo;
                            $linea["articulo"]["empresa"] = $linea->articulo->empresa;
                        }
                    }

    
                }
            }else{
                $partes = [];
            }

            // filtrar los partes de trabajo que tengan el mismo iva que la venta
            $partes = $partes->filter(function ($parte) use ($venta) {
                return $parte->ivaParte == $venta->IvaVenta;
            });

            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Venta creada correctamente',
                'venta'     => $venta,
                'ventaEmp'  => $venta->empresa_id,
                'articulos' => Articulos::all(),
                'ordenes'   => [],
                'partes'    => $partes,
                'proyectos' => Project::all(),
                'cliente'   => Cliente::find($venta->cliente_id),
                'code'      => 202
            ]);


        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage(), $th->getLine(), $th->getFile());
            throw new Exception($th->getMessage());
        }

    }

    public function storeLineas(Request $request){

        try {
            DB::beginTransaction();
            $venta = Ventas::FindOrFail($request->venta_id);
            $cliente = Cliente::FindOrFail($venta->cliente_id);
            $importeVenta = $venta->ImporteVenta;

            if ( is_array($request->articulo_id) ) {
                foreach ( $request->articulo_id as $parte ) {
                    $parteActualizar = PartesTrabajo::FindOrFail($parte);
                    $parteActualizar->estadoVenta = 2;
                    $parteActualizar->save();

                    $importeVenta += $parteActualizar->suma;
                    
                    $descripcionPersonalizada = ($parteActualizar->tituloParte) ? $parteActualizar->tituloParte : $parteActualizar->Asunto;

                    LineasVentas::create([
                        'Descripcion'    => $descripcionPersonalizada,
                        'Cantidad'       => 1,
                        'precioSinIva'   => $parteActualizar->suma,
                        'descuento'      => $request->descuento,
                        'total'          => $parteActualizar->suma,
                        'venta_id'       => $venta->idVenta,
                        'proyecto_id'    => null,
                        'orden_trabajo'  => ($parteActualizar->orden_id) ? $parteActualizar->orden_id : null,
                        'parte_trabajo'  => $parteActualizar->idParteTrabajo,
                        'tipo_orden'     => 'parte',
                        'observaciones'  => 'Venta realizada por el usuario: ' . Auth::user()->name,
                    ]);
                }

                $venta->ImporteVenta = $importeVenta;
                $venta->save();

                $lineas = LineasVentas::WHERE('venta_id', $venta->idVenta)->with('parteTrabajo')->get();

                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Linea de venta creada correctamente',
                    'venta'     => $venta,
                    'articulos' => Articulos::all(),
                    'ordenes'   => ( $request->tipo !== 'parte' ) ? OrdenesTrabajo::WHERE('cliente_id', $venta->cliente_id )->get() : PartesTrabajo::WHERE('cliente_id', $venta->cliente_id )->get(),
                    'cliente'   => $cliente,
                    'lineas'    => $lineas,
                    'code'      => 202
                ]);

            }

            if ( $request->tipo == 'parte' ) {
                $orden = PartesTrabajo::FindOrFail($request->orden_trabajo_id);
                $orden->estadoVenta = 2;
                $orden->save();

                $importeVenta += $orden->suma;

                $venta->ImporteVenta = $importeVenta;
                $venta->save();

                $descripcionPersonalizada = ($orden->tituloParte) ? $orden->tituloParte : $orden->Asunto;
            }else{
                $orden = OrdenesTrabajo::FindOrFail($request->orden_trabajo_id);
                $descripcionPersonalizada = ($orden->tituloParte) ? $orden->tituloParte : $orden->Asunto;
            }

            $linea = LineasVentas::create([
                'Descripcion'    => $descripcionPersonalizada,
                'Cantidad'       => $request->cantidad,
                'precioSinIva'   => $request->precioSinIva,
                'descuento'      => $request->descuento,
                'total'          => $request->total,
                'venta_id'       => $venta->idVenta,
                'proyecto_id'    => null,
                'orden_trabajo'  => ( $orden->orden_id ) ? $orden->orden_id : null,
                'parte_trabajo'  => $orden->idParteTrabajo,
                'tipo_orden'     => $request->tipo,
                'observaciones'  => 'Venta realizada por el usuario: ' . Auth::user()->name,
            ]);

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Linea de venta creada correctamente',
                'venta'     => $venta,
                'articulos' => Articulos::all(),
                'ordenes'   => ( $request->tipo !== 'parte' ) ? OrdenesTrabajo::WHERE('cliente_id', $venta->cliente_id )->get() : PartesTrabajo::WHERE('cliente_id', $venta->cliente_id )->get(),
                'cliente'   => $cliente,
                'linea'     => $linea,
                'code'      => 202
            ]);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage(), $th->getLine(), $th->getFile());
            throw new Exception($th->getMessage());
        }

    }

    public function updateLineas( $id, Request $request ){
        try {
            
            // buscar la venta y actualizar los valores
            $venta = Ventas::FindOrFail($id);

            $venta->TotalFacturaVenta = $request->totalFactura;
            $venta->TotalIvaVenta = $request->totalIva;
            $venta->SuplidosVenta = $request->suplidos;
            $venta->RetencionesVenta = $request->retenciones;
            $venta->TotalRetencionesVenta = $request->totalRetenciones;
            $venta->Cobrado = $request->cobrado;
            $venta->PendienteVenta = $request->pendiente;

            $venta->save();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Venta actualizada correctamente',
                'venta'     => $venta,
                'code'      => 202
            ]);

        } catch (\Throwable $th) {
            dd($th->getMessage(), $th->getLine(), $th->getFile());
            throw new Exception($th->getMessage());
        }
    }

    public function confirm( Request $request, $id ){

        try {

            dd($request->all(), $id);
            
        } catch (\Throwable $th) {
            dd($th->getMessage(), $th->getLine(), $th->getFile());
            throw new Exception($th->getMessage());
        }

    }

    public function show($id)
    {
        try {
            $venta = Ventas::with(['cliente', 'empresa', 'ventaLineas.articulo'])->findOrFail($id);
            return response()->json(['status' => 'success', 'venta' => $venta, 'code' => 200]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'code' => 400]);
        }
    }

    public function edit($id)
    {
        try {
            $venta = Ventas::with(['cliente', 'empresa', 'ventaLineas', 'ventaConfirm'])->findOrFail($id);
            $clientes = Cliente::all();
            $empresas = Empresa::all();
            $articulos = Articulos::all();
            $partes = PartesTrabajo::WHERE('cliente_id', $venta->cliente_id)->WHERE('estadoVenta', 1)->get();
            $proyectos = Project::all();

            return response()->json(
                [
                    'status' => 'success',
                    'venta' => $venta,
                    'clientes' => $clientes,
                    'empresas' => $empresas,
                    'articulos' => $articulos,
                    'partes' => $partes,
                    'proyectos' => $proyectos,
                    'articulos' => Articulos::all(),
                    'code' => 200
                ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'code' => 400]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'FechaVenta'            => 'required|date',
                'AgenteVenta'           => 'required',
                'EnviadoVenta'          => 'required',
                'cliente_id'            => 'required',
                'empresa_id'            => 'required',
                'FormaPago'             => 'required',
                'IvaVenta'              => 'required',
                "Plazos"                => 'required',
                "Cobrado"               => 'required',
                "PendienteVenta"        => 'required', 
                "NAsientoContable"      => 'required',
            ]);

            $venta = Ventas::findOrFail($id);
            $venta->update($request->all());

            // si la venta se actualiza a más plazos, se crean los plazos faltantes
            $cantidadPlazos = intval($request->Plazos);
            $plazos = PlazoCompra::where('venta_id', $id)->get();

            if ( count($plazos) < $cantidadPlazos ) {
                for ( $i = count($plazos); $i < $cantidadPlazos; $i++ ) {
                    // calcular el siguiente mes de acuerdo a la cantidad de plazos
                    $fechaPago = Carbon::now()->addMonths($i);
                    PlazoCompra::create([
                        'frecuenciaPago' => $request->Plazos,
                        'fecha_pago'     => Carbon::now(),
                        'estadoPago'     => 1,
                        'proximoPago'    => $fechaPago,
                        'venta_id'       => $venta->idVenta,
                        'compra_id'      => null,
                        'userAction'     => Auth::user()->id,
                    ]);
                }
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'Venta actualizada correctamente',
                'venta'     => $venta,
                'articulos' => Articulos::all(),
                'ordenes'   => OrdenesTrabajo::where('cliente_id', $venta->cliente_id)->get(),
                'partes'    => PartesTrabajo::where('cliente_id', $venta->cliente_id)->get(),
                'cliente'   => Cliente::find($venta->cliente_id),
                'code'      => 200
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'code' => 400]);
        }
    }

    public function generateAlbaran($id){
        try {
            // Obtiene los datos necesarios de la base de datos
            $venta = Ventas::with('cliente', 'ventaLineas', 'ventaConfirm')->findOrFail($id);
            $cliente = $venta->cliente;
            $lineasVenta = $venta->ventaLineas;
            $data = [];

            $data['venta'] = $venta;
            $data['cliente'] = $cliente;
            $data['lineasVenta'] = $lineasVenta;
            
            // Obtiene las 4 imágenes correspondientes a la orden de trabajo
            foreach ($lineasVenta as $key => $linea ) {

                $imagenes = partesTrabajoArchivos::where('parteTrabajo_id', $linea->parte_trabajo)
                ->JOIN('archivos', 'archivos.idarchivos', '=', 'partestrabajo_sl_has_archivos.archivo_id')
                ->orderBy('archivos.idarchivos', 'ASC')
                ->take(4)
                ->get();

                foreach ( $imagenes as $imagen ) {
                    $uri = str_replace('/home/u657674604/domains/sebcompanyes.com/public_html/', '', $imagen->pathFile);
                    $url = 'https://sebcompanyes.com/'.$uri;

                    // verificar si la imagen tiene un comentario en la base de datos

                    $comentarios = trabajos_archivos::where('archivo_id', $imagen->archivo_id)->first();

                    if ( $comentarios ) {
                        $imagen->comentarioArchivo = $comentarios->comentarioArchivo;
                    }

                    $imagen->pathFile = $url;
                }

                $materiales = PartesTrabajoLineas::where('parteTrabajo_id', $linea->parte_trabajo)
                ->join('articulos_sl', 'articulos_sl.idArticulo', 'materialesempleados_sl.articulo_id')
                ->select('materialesempleados_sl.*', 'articulos_sl.nombreArticulo')
                ->get();

                $parteTrabajo = PartesTrabajo::findOrFail($linea->parte_trabajo);

                $data["lineasVenta"][$key]['imagenes']   = $imagenes;
                $data["lineasVenta"][$key]['materiales'] = $materiales;
                $data["lineasVenta"][$key]['parteTrabajo'] = $parteTrabajo;
            }

            $fechaAhora = Carbon::now()->format('Y-m-d');

            // Genera el PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.albaran', [
                'venta' => $data['venta'],
                'cliente' => $data['cliente'],
                'lineasVenta' => $data['lineasVenta'],
                'imagenes' => $data['lineasVenta'],
                'fecha' => $fechaAhora,
                'id' => $id
            ])->setPaper('folio', 'landscape');;

            $nombreArchivo = 'albaran_'.$id.'_'.$cliente->NombreCliente.'_'.$fechaAhora.'.pdf';

            // Descarga el PDF
            return $pdf->download($nombreArchivo);

        } catch (\Throwable $th) {
            $res = [
                'status' => 'error',
                'message' => $th->getMessage(),
                'page'    => $th->getFile(),
                'line'    => $th->getLine(),
                'code' => 400
            ];
            throw new Exception(json_encode($res));
        }
    }

    public function generateFactura($id){
        try {
            DB::beginTransaction();
            // Obtiene los datos necesarios de la base de datos
            $venta = Ventas::with('cliente', 'ventaLineas', 'ventaConfirm')->findOrFail($id);
            $cliente = $venta->cliente;
            $lineasVenta = $venta->ventaLineas;
            $data = [];

            $data['venta'] = $venta;
            $data['cliente'] = $cliente;
            $data['lineasVenta'] = $lineasVenta;
            
            // Obtiene las 4 imágenes correspondientes a la orden de trabajo
            foreach ($lineasVenta as $key => $linea ) {

                $imagenes = partesTrabajoArchivos::where('parteTrabajo_id', $linea->parte_trabajo)
                ->JOIN('archivos', 'archivos.idarchivos', '=', 'partestrabajo_sl_has_archivos.archivo_id')
                ->orderBy('archivos.idarchivos', 'ASC')
                ->take(4)
                ->get();

                foreach ( $imagenes as $imagen ) {
                    $uri = str_replace('/home/u657674604/domains/sebcompanyes.com/public_html/', '', $imagen->pathFile);
                    $url = 'https://sebcompanyes.com/'.$uri;

                    // verificar si la imagen tiene un comentario en la base de datos

                    $comentarios = trabajos_archivos::where('archivo_id', $imagen->archivo_id)->first();

                    if ( $comentarios ) {
                        $imagen->comentarioArchivo = $comentarios->comentarioArchivo;
                    }

                    $imagen->pathFile = $url;
                }

                $materiales = PartesTrabajoLineas::where('parteTrabajo_id', $linea->parte_trabajo)
                ->join('articulos_sl', 'articulos_sl.idArticulo', 'materialesempleados_sl.articulo_id')
                ->select('materialesempleados_sl.*', 'articulos_sl.nombreArticulo')
                ->get();

                $parteTrabajo = PartesTrabajo::findOrFail($linea->parte_trabajo);

                $data["lineasVenta"][$key]['imagenes']   = $imagenes;
                $data["lineasVenta"][$key]['materiales'] = $materiales;
                $data["lineasVenta"][$key]['parteTrabajo'] = $parteTrabajo;
            }

            $fechaAhora = Carbon::now()->format('Y-m-d');

            // Genera el PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.factura', [
                'venta' => $data['venta'],
                'cliente' => $data['cliente'],
                'lineasVenta' => $data['lineasVenta'],
                'imagenes' => $data['lineasVenta'],
                'fecha' => $fechaAhora,
                'id' => $id
            ])->setPaper('folio', 'landscape');;

            $nombreArchivo = 'Factura_'.$id.'_'.$cliente->NombreCliente.'_'.$fechaAhora.'.pdf';

            // confirmar la venta
            VentaConfirm::create([
                'venta_id'  => $id,
                'estado'    => 'VENDIDO',
                'user_id'   => Auth::user()->id,
            ]);

            // guardar el archivo en el servidor
            $path = public_path("archivos/facturas/$id/$nombreArchivo");

            if (!file_exists(public_path("archivos/facturas/$id"))) {
                mkdir(public_path("archivos/facturas/$id"), 0777, true);
            }

            $pdf->save($path);

            $path = 'archivos/facturas/'.$id.'/'.$nombreArchivo;

            // guardar el archivo en la base de datos
            $archivo = Archivos::create([
                'nameFile' => $nombreArchivo,
                'typeFile' => 'pdf',
                'pathFile' => $path,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // actualizar la venta con el archivo generado
            $venta->archivoId = $archivo->idarchivos;
            $venta->save();

            DB::commit();

            // buscar el archivo generado
            $archivo = Archivos::findOrFail($venta->archivoId);

            // descargar el archivo
            return response()->download(public_path($archivo->pathFile, $archivo->nameFile));

        } catch (\Throwable $th) {
            DB::rollBack();
            $res = [
                'status' => 'error',
                'message' => $th->getMessage(),
                'page'    => $th->getFile(),
                'line'    => $th->getLine(),
                'code' => 400
            ];
            throw new Exception(json_encode($res));
        }
    }

    public function InformeModelo347($id, $trimestre, $year, $emp, $enviarEmail = false, $descargar = false, $descargarYEnviar = false){
        try {
            
            $limite = Configuracion::where('clave', 'modelo_347_limite')->value('valor');
            $limite = (int) $limite;
            
            $ventas = Ventas::where('cliente_id', $id)
                // ->whereRaw('QUARTER(FechaVenta) = ?', [$trimestre])
                ->whereRaw('YEAR(FechaVenta) = ?', [$year])
                ->where('empresa_id', $emp)
                ->selectRaw(
                    'QUARTER(ventas_sl.FechaVenta) as trimestre,
                    ventas_sl.cliente_id,
                    ventas_sl.empresa_id,
                    ventas_sl.tipo_movimiento,
                    ventas_sl.notasmodelo347,
                    ventas_sl.correo,
                    ventas_sl.agente,
                    SUM(ventas_sl.TotalFacturaVenta) as total'
                )
                ->groupBy(
                    'cliente_id',
                    'trimestre',
                    'empresa_id',
                    'tipo_movimiento',
                    'notasmodelo347',
                    'correo',
                    'agente'
                )
                ->havingRaw('SUM(ventas_sl.TotalFacturaVenta) >= ?', [$limite])
                ->get();

            if (!empty($enviarEmail) && $enviarEmail == '1') {
                // generar informe
                $cliente = Cliente::findOrFail($id);

                // EXTRAER EL EMAIL RECEPTOR DE VENTAS TENIENDO EN CUENTA QUE PUEDEN SER VARIOS EMAILS separados por comas
                $emails = [];

                foreach ($ventas as $venta) {
                    // $venta->correo viene con "," tengo que separarlos y meterlos en un array
                    // si no hay comas
                    if( strpos($venta->correo, ',') === false ){
                        $emails[] = $venta->correo;
                    }else{
                        $venta->correo = explode(',', $venta->correo);
                        foreach ($venta->correo as $email) {
                            $emails[] = $email;
                        }
                    }
                }

                $this->generateOnlyInforme($ventas, $year, true, $cliente, $emails);

                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Informe generado y enviado correctamente',
                    'code'      => 202
                ]);
            }

            if (!empty($descargar) && $descargar == '1') {
                // generar informe
                $cliente = Cliente::findOrFail($id);
                $file = $this->generateOnlyInforme($ventas, $year, false, $cliente, []);
                return response()->download($file);
            }

            if (!empty($descargarYEnviar) && $descargarYEnviar == '1') {
                // generar informe
                $cliente = Cliente::findOrFail($id);

                // EXTRAER EL EMAIL RECEPTOR DE VENTAS TENIENDO EN CUENTA QUE PUEDEN SER VARIOS EMAILS separados por comas
                $emails = [];

                foreach ($ventas as $venta) {
                    // $venta->correo viene con "," tengo que separarlos y meterlos en un array
                    // si no hay comas
                    if( strpos($venta->correo, ',') === false ){
                        $emails[] = $venta->correo;
                    }else{
                        $venta->correo = explode(',', $venta->correo);
                        foreach ($venta->correo as $email) {
                            $emails[] = $email;
                        }
                    }
                }
                $file = $this->generateOnlyInforme($ventas, $year, true, $cliente, $emails, true);
                return response()->download($file);
            }

        }catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public static function generateOnlyInforme($ventas, $year, $enviarEmail = false, $cliente, $emailReceptor, $enviarYDescargar = false){
        try {
            // Nombre del archivo
            $nombreArchivo = 'Modelo347_' . $year . "CIF" . $cliente->CIF . "_" . $cliente->NombreCliente . "_" . $cliente->ApellidoCliente . ".PDF";

            // Cliente
            $clienteFolder = $cliente->idClientes;

            // Ruta del archivo
            $path = public_path("archivos/modelo347/$year/$clienteFolder/$nombreArchivo");

            // Verificar si el archivo ya existe en el sistema de archivos
            if (!file_exists($path)) {
                // Crear directorio si no existe
                if (!file_exists(public_path("archivos/modelo347/$year/$clienteFolder"))) {
                    mkdir(public_path("archivos/modelo347/$year/$clienteFolder"), 0777, true);
                }
                // Generar el PDF con la vista 'pdf/modelo347'
                $pdf = Pdf::loadView('pdf.modelo347', [
                    'ventas' => $ventas,
                    'year' => $year,
                    'cliente' => $cliente,
                    'empresa' => Empresa::findOrFail($ventas[0]->empresa_id),
                ])->setPaper('folio', 'landscape');

                // Guardar el archivo en el servidor
                $pdf->save($path);

                // Registrar el archivo en la base de datos solo si no existe
                $existingFile = Archivos::where('pathFile', 'archivos/modelo347/' . $year . '/' . $clienteFolder . '/' . $nombreArchivo)->first();

                if (!$existingFile) {
                    Archivos::create([
                        'nameFile' => $nombreArchivo,
                        'typeFile' => 'pdf',
                        'pathFile' => 'archivos/modelo347/' . $year . '/' . $clienteFolder . '/' . $nombreArchivo,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }

            // Descargar el archivo
            if (!$enviarEmail) {
                $pathToDownload = public_path("archivos/modelo347/$year/$clienteFolder/$nombreArchivo");
                return $pathToDownload;
            }

            // Preparar el email
            $subject = "MilecoSL Modelo 347 - " . $year;

            $data = [
                'cliente' => $cliente,
                'year' => $year,
                'archivo' => $nombreArchivo,
                'trimestres' => $ventas,
            ];

            // Enviar el email
            foreach ($emailReceptor as $email) {
                if (empty($email)) {
                    continue;
                }
                Mail::to($email)->cc("sebastian11yt@gmail.com")->send(new Modelo347($subject, $data, $path, $nombreArchivo));
            }

            // Descargar y enviar
            if ($enviarYDescargar) {
                $pathToDownload = public_path("archivos/modelo347/$year/$clienteFolder/$nombreArchivo");
                return $pathToDownload;
            }

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), $th->getLine());
        }
    }

    public function ventasVarias( Request $request ){
        try {
            DB::beginTransaction();

            $partes_a_vender = $request->partes; // este es un array de ids partes de trabajo

            // $venta = Ventas::create([ // necesito recrear esto dentro del foreach
            //     'FechaVenta'             => $request->FechaVenta,
            //     'empresa_id'             => $request->empresa_id,
            //     'archivoId'              => null,
            //     'AgenteVenta'            => $request->AgenteVenta,
            //     'EnviadoVenta'           => $request->EnviadoVenta,
            //     'cliente_id'             => $request->cliente_id,
            //     'FormaPago'              => $request->FormaPago,
            //     'ImporteVenta'           => $request->ImporteVenta,
            //     'IvaVenta'               => $request->IvaVenta,
            //     'TotalIvaVenta'          => $request->TotalIvaVenta,
            //     'RetencionesVenta'       => $request->RetencionesVenta,
            //     'TotalRetencionesVenta'  => $request->TotalRetencionesVenta,
            //     'TotalFacturaVenta'      => $request->TotalFacturaVenta,
            //     'SuplidosVenta'          => $request->SuplidosVenta,
            //     'Plazos'                 => $request->Plazos,
            //     'Cobrado'                => $request->Cobrado,
            //     'PendienteVenta'         => $request->PendienteVenta,
            //     'NAsientoContable'       => $request->NAsientoContable,
            //     'Observaciones'          => $request->Observaciones,
            //     'created_at'             => Carbon::now(),
            //     'updated_at'             => Carbon::now(),
            // ]);

            foreach ($partes_a_vender as $index => $parte) {
                
                $parteAVender = PartesTrabajo::findOrFail($parte);

                $lineas = PartesTrabajoLineas::where('parteTrabajo_id', $parteAVender->idParteTrabajo)->get();
                $orden  = OrdenesTrabajo::findOrFail($parteAVender->orden_id);
                $cita   = Cita::findOrFail($orden->cita_id);
                $usuarioCreaCita = User::findOrFail($cita->user_id);

                $totalLineas    = 0;
                $iva            = 21;
                $totalIva       = 21;

                foreach ($lineas as $linea) {
                    $totalLineas += $linea->total;
                }

                $totalIva       = ($totalLineas * $totalIva) / 100;
                $fechaVenta     = Carbon::now()->format('Y-m-d');
                $AgenteVenta    = $usuarioCreaCita->name;
                $EnviadoVenta   = $usuarioCreaCita->email;
                $formaPago      = 2; // TODO: esto debería enviarse desde el front
                $cliente_id     = $orden->cliente_id;
                $suplidos       = 0;
                $retenciones    = 0;
                $plazos         = 0;
                $empresa        = 1; // TODO: esto debería enviarse desde el front
                $totalFactura   = $totalLineas + $totalIva;
                $cobrado        = $totalIva;         
                $pendiente      = $totalFactura - $cobrado;
                $nAsiento       = 0; //TODO: esto debería enviarse desde el front
                $observaciones  = 'Venta realizada por el usuario: ' . Auth::user()->name;

                $venta = Ventas::create([
                    'FechaVenta'             => $fechaVenta,
                    'empresa_id'             => $empresa,
                    'archivoId'              => null,
                    'AgenteVenta'            => $AgenteVenta,
                    'EnviadoVenta'           => $EnviadoVenta,
                    'cliente_id'             => $cliente_id,
                    'FormaPago'              => $formaPago,
                    'ImporteVenta'           => $totalLineas,
                    'IvaVenta'               => $iva,
                    'TotalIvaVenta'          => $totalIva,
                    'RetencionesVenta'       => $retenciones,
                    'TotalRetencionesVenta'  => 0,
                    'TotalFacturaVenta'      => $totalFactura,
                    'SuplidosVenta'          => $suplidos,
                    'Plazos'                 => $plazos,
                    'Cobrado'                => $cobrado,
                    'PendienteVenta'         => $pendiente,
                    'NAsientoContable'       => $nAsiento,
                    'Observaciones'          => $observaciones,
                    'created_at'             => Carbon::now(),
                    'updated_at'             => Carbon::now(),
                ]);

                foreach ($lineas as $linea) {
                    LineasVentas::create([
                        'Descripcion'    => 'Articulo utilizado en la orden #'.$parteAVender->idParteTrabajo." - ".$parteAVender->Asunto,
                        'Cantidad'       => $linea->cantidad,
                        'precioSinIva'   => $linea->precioSinIva,
                        'descuento'      => $linea->descuento,
                        'total'          => $linea->total,
                        'venta_id'       => $venta->idVenta,
                        'proyecto_id'    => null,
                        'orden_trabajo'  => ($parteAVender->orden_id) ? $parteAVender->orden_id : null,
                        'parte_trabajo'  => $parteAVender->idParteTrabajo,
                        'tipo_orden'     => 'parte',
                        'observaciones'  => 'Venta realizada por el usuario: ' . Auth::user()->name,
                    ]);
                }      

            }

            DB::commit();

            $message = count($partes_a_vender) . ' partes de trabajo vendidas correctamente';

            return response()->json([
                'success' => true,
                'message' => $message,
                'code' => 202
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'code' => 400,
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'trace' => $th->getTrace()
            ]);
        }

    }

    public function getPlazos($id){
        $venta = Ventas::with('cliente')->find($id);
        $plazos = PlazoCompra::with('banco', 'user', 'banco.banco_detail', 'banco.banco_detail.empresa')->where('venta_id', $id)->get();

        if (!$venta) {
            return response()->json(['error' => 'Venta no encontrada'], 404);
        }

        return response()->json([
            'plazos' => $plazos,
            'totalFactura' => $venta->TotalFacturaVenta,
            'venta' => $venta,
        ]);
    }

    public function registrarCobro(Request $request, $id){
        try {
            DB::beginTransaction();
            $plazo = PlazoCompra::find($id);
            $venta = Ventas::find($plazo->venta_id);

            if (!$plazo) {
                return response()->json(['error' => 'Plazo no encontrado'], 404);
            }

            $monto = $request->monto;
            $fecha = $request->fecha;
            $banco = $request->banco;

            $cobrado = $venta->Cobrado + $monto;
            $totalFactura = $venta->TotalFacturaVenta;

            if ($cobrado > $totalFactura) {
                return response()->json(['error' => 'El monto cobrado supera el total del plazo'], 400);
            }

            $venta->Cobrado = $cobrado;

            // restar el monto cobrado al pendiente de la venta
            $venta->PendienteVenta = $totalFactura - $cobrado;

            // Registrar el cobro del plazo
            $plazo->fecha_pago = $fecha;
            $plazo->estadoPago = 2;
            $plazo->banco_id = $banco;

            // obtener el usuario que registra el cobro
            $plazo->userAction = Auth::user()->id;

            // insertar detalle del cobro en el banco

            $obtenerSaldoBanco = banco_detail::where('banco_id', $banco)->orderBy('id_detail', 'DESC')->first();

            if ($obtenerSaldoBanco) {
                $saldo = $obtenerSaldoBanco->saldo;
            } else {
                $saldo = 0;
            }

            // calcular la fecha de valor
            $fechaValor = Carbon::parse($fecha)->format('Y-m-d');

            // si es viernes, sabado o domingo, sumar 2 dias
            if (Carbon::parse($fechaValor)->dayOfWeek == Carbon::FRIDAY) {
                $fechaValor = Carbon::parse($fechaValor)->addDays(2)->format('Y-m-d');
            } elseif (Carbon::parse($fechaValor)->dayOfWeek == Carbon::SATURDAY) {
                $fechaValor = Carbon::parse($fechaValor)->addDays(1)->format('Y-m-d');
            } elseif (Carbon::parse($fechaValor)->dayOfWeek == Carbon::SUNDAY) {
                $fechaValor = Carbon::parse($fechaValor)->addDays(1)->format('Y-m-d');
            }

            $plazo->save();
            $venta->save();

            banco_detail::create([
                'plazo_id' => $plazo->plazo_id,
                'fecha_operacion' => $fecha,
                'concepto' => 'Cobro de plazo de la venta #'.$venta->idVenta,
                'fecha_valor' => $fechaValor,
                'importe' => $monto,
                'saldo' => $saldo + $monto,
                'banco_id' => $banco,
                'empresa_id' => $venta->empresa_id,
                'venta_id' => $venta->idVenta,
                'fecha_altas' => Carbon::now()->format('Y-m-d'),
            ]);

            DB::commit();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Cobro registrado correctamente',
                    'code' => 202
                ]
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'code' => 400,
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'trace' => $th->getTrace()
            ]);
        }
    }

    public function generateAlbaranProyecto(Request $request, $id){
        try {
         
            DB::beginTransaction();
            // generar Albaran a partir de un proyecto
            // obtener el proyecto
            $proyecto = Project::with('usuario', 'partes', 'ordenes')->findOrFail($id);

            $usuarioGeneraAlbaran = User::findOrFail($proyecto->usuario->id);

            ini_set('memory_limit', '512M');
            set_time_limit(0);

            // Dividir los partes por tipo de IVA
            $partesPorIva = $proyecto->partes->groupBy('ivaParte');

            $partesController = new PartesTrabajoController();

            $ventas = []; // Almacenar las ventas generadas
            $pdfFiles = []; // Almacenar los archivos PDF generados

            foreach ($partesPorIva as $index => $parteIva) {

                $cliente = $parteIva[0]->cliente_id;

                // calcular el importe de la venta con los partes de trabajo
                $importeVenta = 0;
                $ivaVenta = 0;
                $totalIvaVenta = 0;
                $totalFacturaVenta = 0;
                $suplidosVenta = 0;
                $plazos = 0;
                $cobrado = 0;
                
                foreach ($parteIva as $parte) {
                    
                    // calcular el iva del parte de trabajo si los partes más del 50% son con 10% de iva el iva de la venta será 10% de lo contrario será 21%
                    $element = $partesController->UpdateIvaDescuentoParte($parte->idParteTrabajo);
    
                    if( !$parte->ivaParte ){
                        $parte->ivaParte = 21;
                        $parte->save();
                    }
    
                    $importeVenta += floatval($element['importe']);
                    $ivaVenta = floatval($element['iva']);
    
                    $totalIvaVenta = ($importeVenta * $ivaVenta) / 100;
                    $totalFacturaVenta = $importeVenta + $totalIvaVenta;
                    $suplidosVenta = 0;
                    $plazos = 0;
                    $cobrado = 0;
                }

                if ( $parteIva[0]->estadoVenta != 2 ) {

                    // generar una venta con los datos del proyecto
                    $venta = Ventas::create([
                        'FechaVenta'             => Carbon::now(),
                        'empresa_id'             => 1,
                        'archivoId'              => null,
                        'AgenteVenta'            => $usuarioGeneraAlbaran->name,
                        'EnviadoVenta'           => $usuarioGeneraAlbaran->email,
                        'cliente_id'             => $cliente,
                        'FormaPago'              => 2,
                        'ImporteVenta'           => $importeVenta,
                        'IvaVenta'               => $ivaVenta,
                        'TotalIvaVenta'          => $totalIvaVenta,
                        'RetencionesVenta'       => 0,
                        'TotalRetencionesVenta'  => 0,
                        'TotalFacturaVenta'      => $totalFacturaVenta,
                        'SuplidosVenta'          => $suplidosVenta,
                        'Plazos'                 => $plazos,
                        'Cobrado'                => $cobrado,
                        'PendienteVenta'         => $totalFacturaVenta,
                        'NAsientoContable'       => 0,
                        'Observaciones'          => 'Albarán generado por el usuario: ' . Auth::user()->name,
                        'created_at'             => Carbon::now(),
                        'updated_at'             => Carbon::now(),
                    ]);

                    $ventas[] = $venta;
        
                    // crear las lineas de venta con los partes de trabajo
                    foreach ($parteIva as $parte) {
                        $parte->estadoVenta = 2;
                        $parte->save();
        
                        $parte["lineas"] = $parte->partesTrabajoLineas;
        
                        if ( count($parte["lineas"]) > 0 ) {
                            foreach ($parte["lineas"] as $linea) {
                                $linea["articulo"] = $linea->articulo;
                                $linea["articulo"]["empresa"] = $linea->articulo->empresa;
                            }
                        }
        
                        $titulo = ($parte->tituloParte) ? $parte->tituloParte : $parte->Asunto;
        
                        LineasVentas::create([
                            'Descripcion'    => $titulo,
                            'Cantidad'       => 1,
                            'precioSinIva'   => $parte->suma,
                            'descuento'      => 0,
                            'total'          => $parte->totalParte,
                            'venta_id'       => $venta->idVenta,
                            'proyecto_id'    => $proyecto->idProyecto,
                            'orden_trabajo'  => ($parte->orden_id) ? $parte->orden_id : null,
                            'parte_trabajo'  => $parte->idParteTrabajo,
                            'tipo_orden'     => 'parte',
                            'observaciones'  => 'Venta realizada por el usuario: ' . Auth::user()->name,
                        ]);
                    }
                }else{
                    // obtener la venta previa
                    $venta = LineasVentas::where('parte_trabajo', $parteIva[0]->idParteTrabajo)
                    ->leftJoin('ventas_sl', 'ventas_sl.idVenta', 'ventas_lineas_sl.venta_id')
                    ->select('ventas_sl.*')
                    ->first();
    
                }

                // generar el PDF del albaran
                $cliente = Cliente::findOrFail($cliente);

                $lineasVenta = LineasVentas::where('venta_id', $venta->idVenta)->get();
                $data = [];

                $data['venta'] = $venta;
                $data['cliente'] = $cliente;
                $data['lineasVenta'] = $lineasVenta;
                
                // Obtiene las 4 imágenes correspondientes a la orden de trabajo
                foreach ($lineasVenta as $key => $linea ) {

                    $imagenes = partesTrabajoArchivos::where('parteTrabajo_id', $linea->parte_trabajo)
                    ->JOIN('archivos', 'archivos.idarchivos', '=', 'partestrabajo_sl_has_archivos.archivo_id')
                    ->orderBy('archivos.idarchivos', 'ASC')
                    ->take(4)
                    ->get();

                    foreach ( $imagenes as $imagen ) {
                        $uri = public_path($imagen->pathFile);

                        // verificar si la imagen tiene un comentario en la base de datos

                        $comentarios = trabajos_archivos::where('archivo_id', $imagen->archivo_id)->first();

                        if ( $comentarios ) {
                            $imagen->comentarioArchivo = $comentarios->comentarioArchivo;
                        }

                        $imagen->pathFile = $uri;
                    }

                    $materiales = PartesTrabajoLineas::where('parteTrabajo_id', $linea->parte_trabajo)
                    ->join('articulos_sl', 'articulos_sl.idArticulo', 'materialesempleados_sl.articulo_id')
                    ->select('materialesempleados_sl.*', 'articulos_sl.nombreArticulo')
                    ->get();

                    $parteTrabajo = PartesTrabajo::findOrFail($linea->parte_trabajo);

                    $data["lineasVenta"][$key]['imagenes']   = $imagenes;
                    $data["lineasVenta"][$key]['materiales'] = $materiales;
                    $data["lineasVenta"][$key]['parteTrabajo'] = $parteTrabajo;
                }

                $fechaAhora = Carbon::now()->format('Y-m-d');

                // Genera el PDF
                $pdf = Pdf::loadView('pdf.albaran', [
                    'venta' => $venta,
                    'cliente' => $cliente,
                    'lineasVenta' => $lineasVenta,
                    'imagenes' => $data['lineasVenta'],
                    'fecha' => $fechaAhora,
                    'id' => $venta->idVenta,
                    'iva' => $ivaVenta
                ])->setPaper('folio', 'landscape');

                // Habilitar conteo total de páginas
                // Obtener el conteo de páginas inicial
                $dompdf = $pdf->getDomPDF();
                $options = $dompdf->getOptions();
                $options->set('defaultFont', 'Comic Sans MS');
                $dompdf->render(); // Renderiza para calcular las páginas
                $totalPages = $dompdf->get_canvas()->get_page_count();

                $pdf = Pdf::loadView('pdf.albaran', [
                    'venta' => $venta,
                    'cliente' => $cliente,
                    'lineasVenta' => $lineasVenta,
                    'imagenes' => $data['lineasVenta'],
                    'fecha' => $fechaAhora,
                    'id' => $venta->idVenta,
                    'totalPages' => $totalPages,
                    'iva' => $ivaVenta
                ])->setPaper('folio', 'landscape');

                $nombreArchivo = 'albaran_'.$venta->idVenta.'_'.$cliente->NombreCliente.'_'.$fechaAhora.'_'.$index.'%'.'.pdf';

                $path = public_path("archivos/albaranes/$id");

                // si no existe el directorio, crearlo
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $pdf->save(public_path("archivos/albaranes/$id/$nombreArchivo"));

                $path = 'archivos/albaranes/'.$id.'/'.$nombreArchivo;

                $pdfFiles[] = public_path($path);

            }

            // si pdfFiles tiene más de un archivo, crear un archivo zip con todos los PDFs generados de lo contrario descargar el único archivo
            if ( count($pdfFiles) == 1 ) {
                // Descargar el archivo
                return response()->download($pdfFiles[0]);
            }

            $cliente = $proyecto->partes[0]->cliente_id;

            $cliente = Cliente::findOrFail($cliente);

            $cliente = $cliente->NombreCliente . ' ' . $cliente->ApellidoCliente;

            // Crear un archivo zip con todos los PDFs generados
            $zipFileName = "Albaranes_".$cliente."_.zip";

            // si no existe el directorio, crearlo
            if (!file_exists(storage_path('app/public'))) {
                mkdir(storage_path('app/public'), 0777, true);
            }

            $zipPath = storage_path("app/public/{$zipFileName}");

            if (file_exists($zipPath)) {
                unlink($zipPath);
            }

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                foreach ($pdfFiles as $file) {
                    $zip->addFile($file, basename($file));
                }
                $zip->close();
            }

            DB::commit();
            // Descargar el archivo zip
            return response()->download($zipPath)->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => $th->getMessage(),
                'code' => 400,
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ];
            throw new Exception(json_encode($response));
        }
    }

    public function ventaRapidaParte(Request $request, $id){
        try {
        
            DB::beginTransaction();
            // generar Albaran a partir de un proyecto
            // obtener el proyecto
            $parte = PartesTrabajo::with('cliente', 'orden')->findOrFail($id);

            $partesController = new PartesTrabajoController();
            $element = $partesController->UpdateIvaDescuentoParte($id);

            $userLogged = Auth::user();

            $usuarioGeneraAlbaran = User::findOrFail($userLogged->id);

            $cliente = $parte->cliente_id;

            // calcular el importe de la venta con los partes de trabajo
            $importeVenta = $element['importe'];
            $ivaVenta = $element['iva'];
            $totalIvaVenta = 0;
            $totalFacturaVenta = $element['precioVenta'];
            $suplidosVenta = 0;
            $plazos = 0;
            $cobrado = 0;

            // calcular el iva del parte de trabajo si los partes más del 50% son con 10% de iva el iva de la venta será 10% de lo contrario será 21%
            if( !$parte->ivaParte ){
                $parte->ivaParte = 21;
                $parte->save();
            }

            $ivaVenta = $element['iva'];

            $importeVenta   = floatval($element['importe']);
            $ivaVenta       = floatval($element['iva']);

            $totalIvaVenta      = ($importeVenta * $ivaVenta) / 100;
            $totalFacturaVenta  = $element['precioVenta'];

            $suplidosVenta = 0;
            $plazos = 0;
            $cobrado = 0;

            // verificar si el proyecto ya tiene una venta previa
            if ( $parte->estadoVenta != 2 ) {
                // generar una venta con los datos del proyecto
                $venta = Ventas::create([
                    'FechaVenta'             => Carbon::now(),
                    'empresa_id'             => 1,
                    'archivoId'              => null,
                    'AgenteVenta'            => $usuarioGeneraAlbaran->name,
                    'EnviadoVenta'           => $usuarioGeneraAlbaran->email,
                    'cliente_id'             => $cliente,
                    'FormaPago'              => 2,
                    'ImporteVenta'           => $importeVenta,
                    'IvaVenta'               => $ivaVenta,
                    'TotalIvaVenta'          => $totalIvaVenta,
                    'RetencionesVenta'       => 0,
                    'TotalRetencionesVenta'  => 0,
                    'TotalFacturaVenta'      => $totalFacturaVenta,
                    'suplidosVenta'          => $suplidosVenta,
                    'Plazos'                 => $plazos,
                    'Cobrado'                => $cobrado,
                    'PendienteVenta'         => $totalFacturaVenta,
                    'NAsientoContable'       => 0,
                    'Observaciones'          => 'Albarán generado por el usuario: ' . Auth::user()->name,
                    'created_at'             => Carbon::now(),
                    'updated_at'             => Carbon::now(),
                ]);

                // actualizar el estado de la venta
                $parte->estadoVenta = 2;
                $parte->save();

            }else{
                // obtener la venta previa
                $venta = LineasVentas::where('parte_trabajo', $parte->idParteTrabajo)
                ->leftJoin('ventas_sl', 'ventas_sl.idVenta', 'ventas_lineas_sl.venta_id')
                ->select('ventas_sl.*')
                ->first();

            }

            // crear las lineas de venta con los partes de trabajo
            $parte["lineas"] = $parte->partesTrabajoLineas;

            if ( count($parte["lineas"]) > 0 ) {
                foreach ($parte["lineas"] as $linea) {
                    $linea["articulo"] = $linea->articulo;
                    $linea["articulo"]["empresa"] = $linea->articulo->empresa;
                }
            }

            $titulo = ($parte->tituloParte) ? $parte->tituloParte : $parte->Asunto;

            LineasVentas::create([
                'Descripcion'    => $titulo,
                'Cantidad'       => 1,
                'precioSinIva'   => $parte->suma,
                'descuento'      => 0,
                'total'          => $parte->totalParte,
                'venta_id'       => $venta->idVenta,
                'proyecto_id'    => null,
                'orden_trabajo'  => ($parte->orden_id) ? $parte->orden_id : null,
                'parte_trabajo'  => $parte->idParteTrabajo,
                'tipo_orden'     => 'parte',
                'observaciones'  => 'Venta realizada por el usuario: ' . Auth::user()->name,
            ]);

            // generar el PDF del albaran

            $lineasVenta = LineasVentas::where('venta_id', $venta->idVenta)->get();
            $data = [];

            $data['venta'] = $venta;
            $data['cliente'] = $cliente;
            $data['lineasVenta'] = $lineasVenta;

            // Obtiene las 4 imágenes correspondientes a la orden de trabajo
            foreach ($lineasVenta as $key => $linea ) {

                $imagenes = partesTrabajoArchivos::where('parteTrabajo_id', $linea->parte_trabajo)
                ->JOIN('archivos', 'archivos.idarchivos', '=', 'partestrabajo_sl_has_archivos.archivo_id')
                ->orderBy('archivos.idarchivos', 'ASC')
                ->take(4)
                ->get();

                foreach ( $imagenes as $imagen ) {
                    $uri = public_path($imagen->pathFile);

                    // verificar si la imagen tiene un comentario en la base de datos

                    $comentarios = trabajos_archivos::where('archivo_id', $imagen->archivo_id)->first();

                    if ( $comentarios ) {
                        $imagen->comentarioArchivo = $comentarios->comentarioArchivo;
                    }

                    $imagen->pathFile = $uri;
                }

                $materiales = PartesTrabajoLineas::where('parteTrabajo_id', $linea->parte_trabajo)
                ->join('articulos_sl', 'articulos_sl.idArticulo', 'materialesempleados_sl.articulo_id')
                ->select('materialesempleados_sl.*', 'articulos_sl.nombreArticulo')
                ->get();

                $parteTrabajo = PartesTrabajo::findOrFail($linea->parte_trabajo);

                $data["lineasVenta"][$key]['imagenes']   = $imagenes;
                $data["lineasVenta"][$key]['materiales'] = $materiales;
                $data["lineasVenta"][$key]['parteTrabajo'] = $parteTrabajo;
            }

            $fechaAhora = Carbon::now()->format('Y-m-d');
            $cliente = Cliente::findOrFail($cliente);

            // Genera el PDF
            $pdf = Pdf::loadView('pdf.albaran', [
                'venta' => $venta,
                'cliente' => $cliente,
                'lineasVenta' => $lineasVenta,
                'imagenes' => $data['lineasVenta'],
                'fecha' => $fechaAhora,
                'id' => $venta->idVenta
            ])->setPaper('folio', 'landscape');

            // Habilitar conteo total de páginas
            // Obtener el conteo de páginas inicial
            $dompdf = $pdf->getDomPDF();
            $dompdf->render(); // Renderiza para calcular las páginas
            $totalPages = $dompdf->get_canvas()->get_page_count();
            
            $pdf = Pdf::loadView('pdf.albaran', [
                'venta' => $venta,
                'cliente' => $cliente,
                'lineasVenta' => $lineasVenta,
                'imagenes' => $data['lineasVenta'],
                'fecha' => $fechaAhora,
                'id' => $venta->idVenta,
                'totalPages' => $totalPages
            ])->setPaper('folio', 'landscape');

            $nombreArchivo = 'albaran_'.$venta->idVenta.'_'.$cliente->NombreCliente.'_'.$fechaAhora.'.pdf';

            DB::commit();

            // Descarga el PDF
            return $pdf->download($nombreArchivo);

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function downloadFactura ($id){
        try{

            $venta = Ventas::findOrFail($id);

            // buscar el archivo en la base de datos
            $archivo = Archivos::findOrFail($venta->archivoId);

            if (!$archivo) {
                throw new Exception('Archivo no encontrado');
            }

            $path = public_path($archivo->pathFile);

            return response()->download($path, $archivo->nameFile);

        }catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function crearPlazoVenta( Request $request ){
        try {
            
            DB::beginTransaction();

            $ventaId   = $request->idVenta;
            $monto     = $request->monto;
            $notas1    = $request->notas1;
            $fechaPago = $request->fechaPago;

            $venta = Ventas::findOrFail($ventaId);

            if (!$venta) {
                return response()->json(['error' => 'Venta no encontrada'], 404);
            }

            $plazo = PlazoCompra::create([
                'frecuenciaPago' => 1,
                'fecha_pago' => $fechaPago,
                'estadoPago' => 1,
                'proximoPago' => null,
                'venta_id' => $ventaId,
                'compra_id' => null,
                'userAction' => Auth::user()->id,
                'banco_id' => null,
                'notas1' => $notas1,
                'notas2' => null,
            ]);

            // insertar detalle del cobro en el banco

            $obtenerSaldoBanco = banco_detail::where('banco_id', $request->banco)->orderBy('id_detail', 'DESC')->first();

            if ($obtenerSaldoBanco) {
                $saldo = $obtenerSaldoBanco->saldo;
            } else {
                $saldo = 0;
            }

            // calcular la fecha de valor
            $fechaValor = Carbon::parse($fechaPago)->format('Y-m-d');

            // si es viernes, sabado o domingo, sumar 2 dias
            if (Carbon::parse($fechaValor)->dayOfWeek == Carbon::FRIDAY) {
                $fechaValor = Carbon::parse($fechaValor)->addDays(2)->format('Y-m-d');
            } elseif (Carbon::parse($fechaValor)->dayOfWeek == Carbon::SATURDAY) {
                $fechaValor = Carbon::parse($fechaValor)->addDays(1)->format('Y-m-d');
            } elseif (Carbon::parse($fechaValor)->dayOfWeek == Carbon::SUNDAY) {
                $fechaValor = Carbon::parse($fechaValor)->addDays(1)->format('Y-m-d');
            }

            banco_detail::create([
                'plazo_id' => $plazo->plazo_id,
                'fecha_operacion' => $fechaPago,
                'concepto' => 'Plazo de la venta #'.$ventaId,
                'fecha_valor' => $fechaValor,
                'importe' => $monto,
                'saldo' => $saldo + $monto,
                'banco_id' => $request->banco,
                'empresa_id' => $venta->empresa_id,
                'venta_id' => $ventaId,
                'fecha_altas' => Carbon::now()->format('Y-m-d'),
            ]);

            // actualizar venta
            $venta->Plazos = $venta->Plazos + 1;
            $venta->save();

            DB::commit();

            $plazos = PlazoCompra::with('banco', 'user', 'banco.banco_detail', 'banco.banco_detail.empresa')->where('venta_id', $ventaId)->get();

            return response()->json([
                'success' => true,
                'message' => 'Plazo de pago creado correctamente',
                'plazos' => $plazos,
                'code' => 202
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'code' => 400,
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'trace' => $th->getTrace()
            ], 500);
        }
    }

}
