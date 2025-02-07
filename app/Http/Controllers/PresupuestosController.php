<?php

namespace App\Http\Controllers;

use App\Mail\NotificationOperarios;
use App\Models\Archivos;
use App\Models\Articulos;
use App\Models\ArticulosStock;
use App\Models\Cita;
use App\Models\citas_archivos;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Operarios;
use App\Models\OrdenesTrabajo;
use App\Models\ordentrabajo_operarios;
use App\Models\PartesTrabajo;
use App\Models\partesTrabajoArchivos;
use App\Models\PartesTrabajoLineas;
use App\Models\Presupuestos;
use App\Models\PresupuestosAnexos;
use App\Models\PresupuestosArchivos;
use App\Models\PresupuestosLineas;
use App\Models\PresupuestosPartes;
use App\Models\PresupuestosTrabajos;
use App\Models\Project;
use App\Models\Project_orden;
use App\Models\ProyectosPartes;
use App\Models\Trabajos;
use App\Models\trabajos_archivos;
use App\Models\trabajos_has_ordentrabajo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PresupuestosController extends Controller
{
    public function index()
    {

        $presupuestos = Presupuestos::all();
        $projects     = Project::all();
        $clientes     = Cliente::all();
        $trabajos     = Trabajos::all();
        $articulos    = Articulos::all();
        $operarios    = Operarios::all();


        return view('admin.presupuestos.index', compact('presupuestos', 'projects', 'clientes', 'trabajos', 'articulos', 'operarios'));
    }

    public function store(Request $request){
    try {
    
        $request->validate([
            'asunto' => 'required',
            'fecha_alta' => 'required',
            'cliente_id' => 'required',
            'trabajo_id' => 'required',
            'suma' => 'required',
        ]);

        DB::beginTransaction();

        // Convertir el array de anexos a un JSON string para almacenar en la base de datos        
        $presupuesto = Presupuestos::create([
            'Asunto' => $request->asunto,
            'FechaAlta' => $request->fecha_alta,
            'FechaVisita' => $request->fecha_visita,
            'Estado' => $request->estado,
            'cliente_id' => $request->cliente_id,
            'Departamento' => $request->departamento,
            'Observaciones' => $request->observaciones,
            'suma' => $request->suma,
            'orden_id' => ($request->orden_id) ? $request->orden_id : null,
            'condiciones_generales' => $request->condicionesgene,
        ]);

        $presupuesto->save();

        if ($request->anexos) {
            foreach ($request->anexos as $key => $anexo) {
                $key = $key + 1;
                $name = $key;
                $val  = $anexo;
                PresupuestosAnexos::create([
                    'presupuesto_id' => $presupuesto->idParteTrabajo,
                    'num_anexo' => $name,
                    'value_anexo' => $val
                ]);
            }
        }

        if ($request->trabajo_id) {
           foreach ($request->trabajo_id as $trabajo) {
               PresupuestosTrabajos::create([
                   'trabajo_id' => $trabajo,
                   'presupuesto_id' => $presupuesto->idParteTrabajo,
               ]);
           }
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Parte de trabajo creado correctamente',
            'partes_trabajo' => $presupuesto,
            'parteTrabajoId' => $presupuesto->idParteTrabajo,
            'articulos' => Articulos::all(),
            'status' => 200
        ]);

    }catch (\Throwable $th) {
        DB::rollBack();
        dd($th->getMessage(), $th->getLine(), $th->getFile());
        throw $th;
    }
}

    public function storeLineas(Request $request){
        try {
            $request->validate([
                'parteTrabajo_id' => 'required',
                'articulo_id' => 'required',
                'cantidad' => 'required',
                'precioSinIva' => 'required',
                'total' => 'required',
                'descuento' => 'required',
            ]);

            $partes_trabajo = Presupuestos::find($request->parteTrabajo_id);
            $articulo = Articulos::find($request->articulo_id);

            PresupuestosLineas::create([
                'parteTrabajo_id' => $request->parteTrabajo_id,
                'articulo_id'     => $request->articulo_id,
                'cantidad'        => $request->cantidad,
                'precioSinIva'    => $request->precioSinIva,
                'total'           => $request->total,
                'descuento'       => $request->descuento,
                'Trazabilidad'    => $articulo->TrazabilidadArticulos,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Linea de trabajo creada correctamente',
                'partes_trabajo' => $partes_trabajo,
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function storeParte(Request $request){
        try {
            DB::beginTransaction();

            // obtener el valor del cliente firmante
            $nombre_firmante = $request->nombre_firmante;

            // Imagen de la firma digital
            $firma = $request->signature;

            $desplazamiento = ( $request->desplazamiento ) ? $request->desplazamiento : 0;
            $precio_hora = ( $request->precio_hora ) ? $request->precio_hora : 0;

            $sumaParcial = $request->suma + $desplazamiento + $precio_hora;

            $partes_trabajo = PresupuestosPartes::create([
                'Asunto'            => $request->asunto,
                'FechaAlta'         => $request->fecha_alta,
                'FechaVisita'       => $request->fecha_visita,
                'Estado'            => $request->estado,
                'cliente_id'        => $request->cliente_id,
                'Departamento'      => $request->departamento,
                'Observaciones'     => $request->observaciones,
                'suma'              => $sumaParcial,
                'trabajo_id'        => $request->trabajo_id,
                'presupuesto_id'    => $request->presupuesto_id,
                'estadoVenta'       => 1,
                'solucion'          => $request->solucion,
                'hora_inicio'       => $request->hora_inicio,
                'hora_fin'          => $request->hora_fin,
                'horas_trabajadas'  => $request->horas_trabajadas,
                'precio_hora'       => $request->precio_hora,
                'desplazamiento'    => $request->desplazamiento ?? null,
                'nombre_firmante'   => $nombre_firmante ?? null,
            ]);

            if ( $request->hasFile('file') ) {
                // Manejar la carga de archivos
                $images = [];

                $files = $request->file('file'); // Utilizar el método file para obtener los archivos

                if ($files && is_array($files) && count($files) > 0) {
                    $nombreFolder = formatFolderName($partes_trabajo->idParteTrabajo);

                    $path = public_path("/archivos/presupuestos/$request->presupuesto_id/$nombreFolder");

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    foreach ($files as $key => $file) {
                        $name = str_replace(' ', '_', $file->getClientOriginalName());
                        $file->move($path, $name);

                        $archivo = Archivos::create([
                            'nameFile' => $name,
                            'typeFile' => $file->getClientOriginalExtension(),
                            'pathFile' => $path . "/" . $name,
                        ]);

                        PresupuestosArchivos::create([
                            'parteTrabajo_id' => $partes_trabajo->idParteTrabajo,
                            'archivo_id' => $archivo->idarchivos,
                            'comentarioArchivo' => $request->comentario[$key + 1] ?? ''
                        ]);

                        $images[] = $path . "/" . $name;
                    }
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Parte de trabajo creado correctamente',
                'partes_trabajo' => $partes_trabajo,
                'parteTrabajoId' => $partes_trabajo->idParteTrabajo,
                'articulos' => Articulos::all(),
                'total' => $sumaParcial,
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function partesDestroy(Request $request){
        try {
            $partes_trabajo = PresupuestosPartes::find($request->parte_id);
            $partes_trabajo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Parte de trabajo eliminado correctamente',
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function updateSum(Request $request){
        try {
            $partes_trabajo = Presupuestos::find($request->parteTrabajoId);
            $partes_trabajo->suma = $request->suma;
            $partes_trabajo->save();

            return response()->json([
                'success' => true,
                'message' => 'Suma actualizada correctamente',
                'partes_trabajo' => $partes_trabajo,
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function edit($id)
    {
        $parte_trabajo = Presupuestos::find($id);

        $parte_trabajo["partes_trabajo_lineas"] = PresupuestosLineas::where('parteTrabajo_id', $id)->get();
        $parte_trabajo["partes_trabajo_archivos"] = partesTrabajoArchivos::where('parteTrabajo_id', $id)->get();
        $parte_trabajo["cliente"] = Cliente::find($parte_trabajo->cliente_id);
        // $cita = ProyectosPartes::where('parteTrabajo_id', $id)->first();
        // $parte_trabajo["cita"] = Project::find($cita->proyecto_id);
        $trabajos = PresupuestosTrabajos::where('presupuesto_id', $id)->get();
        $parte_trabajo["trabajo"] = $trabajos;

        foreach ($parte_trabajo["partes_trabajo_lineas"] as $linea) {
            $linea["articulo"] = Articulos::find($linea->articulo_id);
        }
        
        return response()->json([
            'success' => true,
            'parte_trabajo' => $parte_trabajo
        ]);
    }

    public function editCabecera($id){
        try {
            
            $presupuesto = Presupuestos::with('cliente', 'trabajo', 'anexos', 'archivos', 'archivos.archivo')
            ->find($id);

            $presupuesto["partes"] = PresupuestosPartes::where('presupuesto_id', $id)->with('cliente', 'partesTrabajoLineas', 'partesTrabajoLineas.articulo')->get();

            $presupuesto["trabajos"] = PresupuestosTrabajos::where('presupuesto_id', $id)->get();

            return response()->json([
                'success' => true,
                'presupuesto' => $presupuesto,
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            
            $presupuesto = Presupuestos::find($id);

            $presupuesto->update([
                'Asunto' => $request->asunto,
                'FechaAlta' => $request->fecha_alta,
                'FechaVisita' => $request->fecha_visita,
                'Estado' => $request->estado,
                'cliente_id' => $request->cliente_id,
                'Departamento' => $request->departamento,
                'Observaciones' => $request->observaciones,
                'suma' => $request->suma,
                'condiciones_generales' => $request->condicionesgene,
            ]);

            if ($request->anexos) {

                // verificar si hay anexos eliminarlos y luego crearlos
                PresupuestosAnexos::where('presupuesto_id', $id)->delete();

                foreach ($request->anexos as $key => $anexo) {
                    $key = $key + 1;
                    $name = $key;
                    $val  = $anexo;
                    PresupuestosAnexos::create([
                        'presupuesto_id' => $presupuesto->idParteTrabajo,
                        'num_anexo' => $name,
                        'value_anexo' => $val
                    ]);
                }
            }

            // verificar si hay trabajos asociados al presupuesto
            if ($request->trabajo_id) {
                PresupuestosTrabajos::where('presupuesto_id', $id)->delete();
                foreach ($request->trabajo_id as $trabajo) {
                    PresupuestosTrabajos::create([
                        'trabajo_id' => $trabajo,
                        'presupuesto_id' => $presupuesto->idParteTrabajo,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Parte de trabajo actualizado correctamente',
                'presupuesto' => $presupuesto,
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function generarPDF( Request $request ){
        try {
            
            
            // obtener los presupuestos por su id
            $presupuestos = $request->presupuestos;
            $data = [];
            $totalIva = 21;
            $totalFactura = 0;
            $fechaDeHoy = Carbon::now()->format('d-m-Y');

            foreach ($presupuestos as $presupuesto) {
                
                $parte_trabajo = Presupuestos::find($presupuesto);
                $parte_trabajo["partes_trabajo_lineas"] = PresupuestosLineas::where('parteTrabajo_id', $presupuesto)->get();
                $parte_trabajo["partes_trabajo_archivos"] = PresupuestosArchivos::
                JOIN('archivos', 'presupuesto_sl_has_archivos.archivo_id', 'archivos.idarchivos')
                ->where('parteTrabajo_id', $presupuesto)->get();
                $parte_trabajo["cliente"] = Cliente::find($parte_trabajo->cliente_id);
                $trabajos = Trabajos::find($parte_trabajo->trabajo_id);
                $parte_trabajo["trabajo"] = $trabajos;

                foreach ($parte_trabajo["partes_trabajo_lineas"] as $linea) {
                    $linea["articulo"] = Articulos::find($linea->articulo_id);
                }

                $totalFactura += $parte_trabajo->suma;

                $data[] = $parte_trabajo;
            }

            $totalFactura = $totalFactura + ($totalFactura * $totalIva / 100);
            $impuestos = $totalFactura - $totalFactura / (1 + $totalIva / 100);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.presupuesto', [
                'presupuestos' => $data,
                'totalFactura' => $totalFactura,
                'totalIva' => $totalIva,
                'fechaDeHoy' => $fechaDeHoy,
                'impuestos' => $impuestos
            ])->setPaper('a4', 'landscape');;

            // el nombre de archivo debe tener el nombre del cliente y la fecha de hoy
            $nombreArchivo = 'presupuesto_' . $data[0]->cliente->NombreCliente . '_' . $fechaDeHoy . '.pdf';

            return $pdf->download($nombreArchivo);
            
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function generateOrden( Request $request ){
        try {

            DB::beginTransaction();

            // ------------------- OBTENER DATOS DEL PRESUPUESTO --------------------------------------
            $presupuesto = Presupuestos::find($request->parteInfo["idParteTrabajo"]);
            
            // verificar cuantos capitulos tiene el presupuesto
            $capitulos = PresupuestosPartes::where('presupuesto_id', $presupuesto->idParteTrabajo)->get();

            // ------------------- GENERAR CITA PARA ASOCIAR CON LA ORDEN DE TRABAJO -------------------
            $asuntoCita = $request->parteInfo["Asunto"].' - Presupuesto-Aceptado';

            $presupuesto = Presupuestos::find($request->parteInfo["idParteTrabajo"]);
            $presupuesto->update([
                'estadoVenta' => 2
            ]);

            $cita = Cita::create([
                'fechaDeAlta' => Carbon::now()->format('Y-m-d'),
                'asunto' => $asuntoCita,
                'tipoCita' => 'Whatsapp',
                'user_id' => Auth::user()->id,
                'estado' => 'En proceso',
                'cliente_id' => $presupuesto->cliente_id,
            ]);

            $crearProyecto = false;

            if ( count($capitulos) > 1 ) {
                $crearProyecto = true;
            }

            if ($crearProyecto) {

                // Crear un proyecto
                $proyecto = Project::create([
                    'name' => 'Proyecto - ' . $presupuesto->Asunto,
                    'description' => 'Proyecto generado a partir de un presupuesto',
                    'start_date' => Carbon::now()->format('Y-m-d'),
                    'end_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                    'status' => 1,
                    'user_id' => Auth::user()->id,
                ]);

                // actualizar el nombre del proyecto
                $proyecto->update([
                    'name' => 'Proyecto-' . $proyecto->idProyecto.'- '.$presupuesto->Asunto,
                ]);
            }


            foreach ($capitulos as $capitulo) {
                // ------------------- GENERAR ORDEN DE TRABAJO A PARTIR DE UN PRESUPUESTO -------------------
                $parte = PresupuestosPartes::find($capitulo->idParteTrabajo);

                // Crear la orden de trabajo
                $orden = OrdenesTrabajo::create([
                    'cita_id'       => $cita->idCitas,
                    'Asunto'        => $capitulo->Asunto,
                    'FechaAlta'     => Carbon::now()->format('Y-m-d'),
                    'FechaVisita'   => $request->parteInfo["FechaVisita"],
                    'Estado'        => 'En proceso',
                    'cliente_id'    => $request->cliente["idClientes"],
                    'Departamento'  => $request->parteInfo["Departamento"],
                    'Observaciones' => '- Presupuesto '.$capitulo->presupuesto_id,
                ]);

                $extraerKeys = $capitulo->archivos->pluck('archivo_id')->toArray();

                $files = Archivos::whereIn('idarchivos', $extraerKeys)
                ->leftJoin('presupuesto_sl_has_archivos', 'archivos.idarchivos', 'presupuesto_sl_has_archivos.archivo_id')
                ->select('archivos.*', 'presupuesto_sl_has_archivos.comentarioArchivo')
                ->get(); // Asegúrate de usar get() para obtener los resultados

                $images = [];
                $media = [];

                if ($files) {

                    foreach ($files as $key => $file) {
                        $name = $file->nameFile;
                        $path = $file->pathFile;

                        trabajos_archivos::create([
                            'archivo_id' => $file->idarchivos,
                            'orden_id'   => $orden->idOrdenTrabajo,
                            'comentarioArchivo' => ( $file->comentarioArchivo ) ? $file->comentarioArchivo : 'Sin Comentario'
                        ]);

                        $comentario = $file->comentarioArchivo ?? 'Sin Comentario';

                        // Verificar el tipo de archivo por la extensión
                        $extension = $file->typeFile;
                        $mediaType = '';

                        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                            $mediaType = 'photo'; // Imagen
                        } elseif (in_array($extension, ['mp4', 'mov', 'avi'])) {
                            $mediaType = 'video'; // Video
                        } elseif (in_array($extension, ['mp3', 'wav', 'ogg'])) {
                            $mediaType = 'audio'; // Audio
                        }elseif (in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
                            $mediaType = 'document'; // Word, Excel, PDF
                        }

                        $images[] = $path;

                        // Guardar el archivo junto con su tipo y comentario
                        $media[] = [
                            'path' => $path,
                            'type' => $mediaType,
                            'comment' => "Orden #".$orden->idOrdenTrabajo."-->".$comentario
                        ];

                    }
                }

                // Manejar datos del cliente
                $clienteData = Cliente::findOrFail($request->cliente["idClientes"]);
                $ciudad      = Ciudad::findOrFail($clienteData->ciudad_Id)->nameCiudad;

                $otherData = [
                    'asunto'        => $capitulo->Asunto,
                    'fecha_alta'    => $orden->FechaAlta,
                    'fecha_visita'  => $orden->FechaVisita,
                    'estado'        => $orden->Estado,
                    'Cliente'       => $clienteData->NombreCliente . ' ' . $clienteData->ApellidoCliente,
                    'direccion'     => $clienteData->Direccion,
                    'codigo_postal' => $clienteData->CodPostalCliente,
                    'ciudad'        => $ciudad,
                    'email'         => $clienteData->EmailCliente,
                    'telefono'      => $clienteData->telefonos->first()->telefono ?? '',
                    'departamento'  => $orden->Departamento,
                    'observaciones' => $capitulo->Observaciones.' - Presupuesto '.$capitulo->presupuesto_id,
                    'start_time'    => $orden->hora_inicio,
                    'end_time'      => $orden->hora_fin,
                ];

                // Construir mensaje de notificación
                $messageNotification = "N°ORDEN.:  #" . $orden->idOrdenTrabajo . "\n\n" .
                    "F.VISITA.....: " . $orden->FechaVisita . "\n" .
                    "H.CITA INICIO.......: " . $orden->hora_inicio . "\n" .
                    "H.CITA FIN (Aprox).......: " . $orden->hora_fin . "\n" .
                    "ÓPERARIO.....: ";

                // Asignar operarios a la orden de trabajo
                $operarios = $request->operarios;
                if ($operarios && is_array($operarios) && count($operarios) > 0) {
                    $operariosToCalendar = Operarios::whereIn('idOperario', $operarios)->get()->toArray();
                    $operarioNames = [];

                    foreach ($operarios as $operario) {
                        ordentrabajo_operarios::create([
                            'orden_id'    => $orden->idOrdenTrabajo,
                            'operario_id' => $operario
                        ]);

                        $getOperario = Operarios::findOrFail($operario);
                        $operarioNames[] = $getOperario->nameOperario; // Almacena los nombres de los operarios en un array

                        // Enviar correo a cada operario asignado
                        Mail::to($getOperario->emailOperario)->send(new NotificationOperarios($getOperario->nameOperario, $otherData, $images));
                    }

                    // Concatenar los nombres de los operarios con comas
                    $messageNotification .= implode(', ', $operarioNames) . "\n";
                } else {
                    $messageNotification .= "Sin operario asignado\n";
                }

                $trabajosArray = Trabajos::whereIn('idTrabajo', $capitulo->trabajo)->get()->pluck('idTrabajo')->toArray();

                // contar cuantos trabajos se han asignado
                $countTrabajos = count($trabajosArray);
                if ($countTrabajos > 1) {

                    // verificar si el trabajo es un string o un número
                    if( !is_numeric($trabajosArray[0]) ){
                        $trabajos = Trabajos::whereIn('nameTrabajo', $trabajosArray)->get();
                        $trabajosNames = $trabajos->pluck('nameTrabajo')->toArray();
                    }else{
                        $trabajos = Trabajos::WHERE('idTrabajo', $trabajosArray[0])->first();
                        $trabajosNames = $trabajos->nameTrabajo;
                    }

                    // verificar si es un array
                    if (is_array($trabajosNames)) {
                        $messageNotification .= 'TRABAJOS...: ' . implode(', ', $trabajosNames) . "\n";
                    }else{
                        $messageNotification .= 'TRABAJOS...: ' . $trabajosNames . "\n";
                    }

                } else {

                    // verificar si el trabajo es un string o un número
                    if( !is_numeric($trabajosArray[0]) ){
                        $trabajos = Trabajos::whereIn('nameTrabajo', $trabajosArray)->get();
                        $trabajosNames = $trabajos->pluck('nameTrabajo')->toArray();
                    }else{
                        $trabajos = Trabajos::WHERE('idTrabajo', $trabajosArray[0])->first();
                        $trabajosNames = $trabajos->nameTrabajo;
                    }

                    // verificar si $trabajosNames es un array
                    if (is_array($trabajosNames)) {
                        $messageNotification .= 'TRABAJO...: ' . implode(',', $trabajosNames) . "\n";
                    }else{
                        $messageNotification .= 'TRABAJO...: ' . $trabajosNames . "\n";
                    }

                }

                $messageNotification .= "\n" .
                    "CIUDAD.......: " . $ciudad . "\n" .
                    "DIRECCION....: " . $clienteData->Direccion . "\n" .
                    "ESTADO.......: " . $orden->Estado . "\n" .
                    "CLIENTE......: " . $clienteData->NombreCliente . " " . $clienteData->ApellidoCliente . "\n\n" .
                    "ASUNTO.......: " . $capitulo->Asunto . "\n" .
                    "OBSERVACIONES: " . $capitulo->Asunto. '- Presupuesto '. $capitulo->idParteTrabajo . "\n";

                
                // Asignar trabajos a la orden de trabajo
                foreach ($trabajosArray as $trabajo) {
                    trabajos_has_ordentrabajo::create([
                        'orden_id'   => $orden->idOrdenTrabajo,
                        'trabajo_id' => $trabajo
                    ]);
                }

                // ------------------- Generar parte de trabajo asociada a la orden anterior -------------------

                $partes_trabajo = PartesTrabajo::create([
                    'idParteTrabajo'    => $orden->idOrdenTrabajo,
                    'Asunto'            => $parte->Asunto,
                    'FechaAlta'         => $parte->FechaAlta,
                    'FechaVisita'       => $parte->FechaVisita,
                    'Estado'            => $parte->Estado,
                    'cliente_id'        => $parte->cliente_id,
                    'Departamento'      => $parte->Departamento,
                    'Observaciones'     => $parte->Observaciones,
                    'suma'              => $parte->suma,
                    'trabajo_id'        => $parte->trabajo_id,
                    'orden_id'          => $orden->idOrdenTrabajo,
                    'estadoVenta'       => 1,
                    'solucion'          => $parte->solucion,
                    'hora_inicio'       => $parte->hora_inicio,
                    'hora_fin'          => $parte->hora_fin,
                    'horas_trabajadas'  => $parte->horas_trabajadas,
                    'precio_hora'       => $parte->precio_hora,
                    'desplazamiento'    => $parte->desplazamiento,
                    'nombre_firmante'   => $parte->nombre_firmante,
                ]);

                // //almacenar los trabajos
                // ProyectosPartes::create([
                //     'proyecto_id' => $request->cita,
                //     'parteTrabajo_id' => $partes_trabajo->idParteTrabajo
                // ]);

                if ( $orden ) {
                    
                    // obtener los archivos de la orden
                    
                    foreach ($orden->archivos as $file) {

                        $comentario = trabajos_archivos::where('archivo_id', $file->idarchivos)->first();

                        // mover los archivos a la carpeta del parte de trabajo
                        $path = public_path("/archivos/partes_trabajo/$partes_trabajo->idParteTrabajo");

                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }

                        $name = $file->nameFile;
                        $archivoToMove = $file->pathFile;
                        $newPath = $path . "/" . $name;

                        copy($archivoToMove, $newPath);

                        $archivo = Archivos::create([
                            'nameFile' => $name,
                            'typeFile' => $file->typeFile,
                            'pathFile' => $newPath,
                        ]);
                    
                        partesTrabajoArchivos::create([
                            'parteTrabajo_id'   => $partes_trabajo->idParteTrabajo,
                            'archivo_id'        => $archivo->idarchivos,
                            'comentarioArchivo' => ( $comentario ) ? $comentario->comentarioArchivo : 'Sin Comentario',
                        ]);
                    }

                }

                // ------------------- GENERAR LINEAS DE MATERIALES A UTILIZAR PARA EL PARTE DE TRABAJO CREADO -------------------

                $lineas = $parte->partesTrabajoLineas;

                foreach ( $lineas as $linea ) {
                    
                    PartesTrabajoLineas::create([
                        'parteTrabajo_id' => $partes_trabajo->idParteTrabajo,
                        'articulo_id'     => $linea["articulo_id"],
                        'cantidad'        => $linea["cantidad"],
                        'precioSinIva'    => $linea["precioSinIva"],
                        'total'           => $linea["total"],
                        'descuento'       => $linea["descuento"],
                        'Trazabilidad'    => $linea["Trazabilidad"],
                    ]);
                }
                
                // ------------------- Verificar si es más de un capitulo -------------------

                if ($crearProyecto) {

                    // asociar la orden y el parte de trabajo al proyecto
                    ProyectosPartes::create([
                        'proyecto_id' => $proyecto->idProyecto,
                        'parteTrabajo_id' => $partes_trabajo->idParteTrabajo
                    ]);

                    Project_orden::create([
                        'proyecto_id' => $proyecto->idProyecto,
                        'orden_id'    => $orden->idOrdenTrabajo
                    ]);

                }

                // ------------------- Enviar notificaciones -------------------

                // añadir la lista de articulos a la notificación y con su respectivo stock al momento de la creación de la orden
            
                if ($lineas->count() > 0) {

                    $messageNotification .= "\n" .
                        "MATERIALES...: \n";
    
                    // AÑADIR AL MENSAJE LA FRASE "ESTE CONTEO DE STOCK ES AL MOMENTO DE LA CREACIÓN DE LA ORDEN"
                    $fechayHora = Carbon::now()->format('d-m-Y H:i:s');
                    $messageNotification .= "ESTE CONTEO DE STOCK ES AL MOMENTO DE LA CREACIÓN DE LA ORDEN: $fechayHora\n\n";
    
                    foreach ($lineas as $key => $linea) {
                        $key = $key + 1;
                        $articulo = Articulos::find($linea->articulo_id);
                        $stock = ArticulosStock::where('articulo_id', $articulo->idArticulo)->first();

                        $messageNotification .= $key."- ".$articulo->nombreArticulo . ' - ' . $linea->cantidad . ' unidades' . "\n";

                        // verificar si el stock es menor a la cantidad de la linea
                        if ($stock->cantidad < $linea->cantidad) {
                            $messageNotification .= 'Stock insuficiente para la orden, Stock actual: ' . $stock->cantidad . "\n\n";
                        }else{
                            $messageNotification .= 'Stock: ' . $stock->cantidad . ' unidades Disponibles' . "\n\n";
                        }
                    }
    
                    $messageNotification .= "\n" .
                        "TOTAL........: " . number_format($partes_trabajo->suma, 2, ',', '.') . " €\n";
                }

                // Enviar notificación a Telegram
                $telegramController = new NotificationsController();
                $chatIdAutomatico = $telegramController->getCurrentChatIdByConfig('avisos');

                $telegramController->sendMessageTelegram($chatIdAutomatico, $messageNotification, $media);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Orden de trabajo generada correctamente',
                'orden' => $orden,
                'parte_trabajo' => $partes_trabajo,
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function lineaspartes(Request $request){
        try {
            DB::beginTransaction();
            $partes_trabajo = PartesTrabajo::find($request->parteTrabajo_id);
            $articulo = Articulos::find($request->articulo_id);

            $stock = ArticulosStock::where('articulo_id', $articulo->idArticulo)->first();

            $material = PresupuestosLineas::create([
                'parteTrabajo_id' => $request->parteTrabajo_id,
                'articulo_id'     => $request->articulo_id,
                'cantidad'        => $request->cantidad,
                'precioSinIva'    => $request->precioSinIva,
                'total'           => $request->total,
                'descuento'       => $request->descuento,
                'Trazabilidad'    => $articulo->TrazabilidadArticulos ?? 'Sin trazabilidad',
            ]);

            $material["articulo"]   = $articulo;
            $stock["articulo"]      = $articulo;

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Linea de trabajo creada correctamente',
                'partes_trabajo' => $partes_trabajo,
                'linea' => $material,
                'status' => 200,
                'stock' => $stock
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    // funcion para actualizar el total del parte de trabajo correspondiente del presupuesto
    public function presupuestoPartes(Request $request){
        try {
            DB::beginTransaction();
            $partes_trabajo = PresupuestosPartes::find($request->parteTrabajoId);
            $partes_trabajo->suma = $request->suma;
            $partes_trabajo->save();

            // obtener el presiupuesto asociado a la parte de trabajo
            $presupuesto = Presupuestos::find($partes_trabajo->presupuesto_id);
            // sumarle el total a la suma del presupuesto
            $presupuesto->suma = $request->presupuesto;

            $presupuesto->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Suma actualizada correctamente',
                'partes_trabajo' => $partes_trabajo,
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function getParteInfo( Request $request, $id ){

        $parte_trabajo = PresupuestosPartes::find($id);

        $parte_trabajo["partes_trabajo_lineas"] = PresupuestosLineas::where('parteTrabajo_id', $id)->get();
        // $parte_trabajo["operarios"] = ordentrabajo_operarios::where('orden_id', $parte_trabajo->idParteTrabajo)->with('operarios', 'operarios.salario')->get();
        $parte_trabajo["operarios"] = [];
        $parte_trabajo["partes_trabajo_archivos"] = PresupuestosArchivos::where('parteTrabajo_id', $id)
        ->leftJoin('archivos', 'presupuesto_sl_has_archivos.archivo_id', 'archivos.idarchivos')
        ->select('archivos.*', 'presupuesto_sl_has_archivos.comentarioArchivo')
        ->get();

        $parte_trabajo["cliente"] = Cliente::find($parte_trabajo->cliente_id)->with('tipoCliente')->first();
        $cita = false;

        if ($cita) {
            $parte_trabajo["cita"] = Project::find($cita->proyecto_id);
        }

        $trabajos = Trabajos::find($parte_trabajo->trabajo_id);
        $parte_trabajo["trabajo"] = $trabajos;

        foreach ($parte_trabajo["partes_trabajo_lineas"] as $linea) {
            $linea["articulo"] = Articulos::find($linea->articulo_id);
        }
        
        return response()->json([
            'success' => true,
            'parte_trabajo' => $parte_trabajo
        ]);
    }

    public function anexosDestroy(Request $request){
        try {
            
            $anexo = PresupuestosAnexos::find($request->anexoId);
            $anexo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Anexo eliminado correctamente',
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function lineaspartesDestroy(Request $request){
        try {
            
            $linea = PresupuestosLineas::find($request->lineaId);
            $linea->delete();

            return response()->json([
                'success' => true,
                'message' => 'Linea eliminada correctamente',
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function lineasParteUpdate(Request $request, $id){
        try {
            $request->validate([
                'parteTrabajo_id' => 'required',
                'articulo_id' => 'required',
                'cantidad' => 'required',
                'precioSinIva' => 'required',
                'total' => 'required',
                'descuento' => 'required',
            ]);

            $partes_trabajo = PresupuestosPartes::find($request->parteTrabajo_id);
            $articulo = Articulos::find($request->articulo_id);

            $linea = PresupuestosLineas::find($id);
            $linea->update([
                'parteTrabajo_id' => $request->parteTrabajo_id,
                'articulo_id'     => $request->articulo_id,
                'cantidad'        => $request->cantidad,
                'precioSinIva'    => $request->precioSinIva,
                'total'           => $request->total,
                'descuento'       => $request->descuento,
                'Trazabilidad'    => $articulo->TrazabilidadArticulos,
            ]);

            $stock = ArticulosStock::where('articulo_id', $articulo->idArticulo)->first();
            $stock["articulo"] = $articulo;

            $linea["articulo"] = $articulo;

            return response()->json([
                'success' => true,
                'message' => 'Linea de trabajo actualizada correctamente',
                'partes_trabajo' => $partes_trabajo,
                'linea' => $linea,
                'status' => 200,
                'stock' => $stock
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function generatePdf( Request $request, $id ){
        try {
            
            $parte_trabajo = Presupuestos::find($id);

            $parte_trabajo["partes_trabajo_lineas"] = PresupuestosLineas::where('parteTrabajo_id', $request->parte_id)->get();
            $parte_trabajo["partes_trabajo_archivos"] = PresupuestosArchivos::where('parteTrabajo_id', $request->parte_id)->get();
            $parte_trabajo["cliente"] = Cliente::find($parte_trabajo->cliente_id);
            // $cita = ProyectosPartes::where('parteTrabajo_id', $request->parte_id)->first();
            // $parte_trabajo["cita"] = Project::find($cita->proyecto_id);
            $trabajos = Trabajos::find($parte_trabajo->trabajo_id);
            $parte_trabajo["trabajo"] = $trabajos;

            foreach ($parte_trabajo["partes_trabajo_lineas"] as $linea) {
                $linea["articulo"] = Articulos::find($linea->articulo_id);
            }

            $images = PresupuestosArchivos::where('parteTrabajo_id', $request->parte_id)
            ->leftjoin('archivos', 'presupuesto_sl_has_archivos.archivo_id', 'archivos.idarchivos')
            ->whereNotIn('archivos.typeFile', ['pdf', 'docx', 'doc', 'xlsx', 'xls', 'pptx', 'ppt', 'txt', 'mp4', 'mp3', 'avi', 'mov', 'mkv', 'zip', 'rar', 'ogg', 'webm', 'wav', 'flac', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'bmp', 'tiff', 'ico', 'webp'])
            ->get();

            $condicionesGenerales = preg_replace('/(\d+-)/', '<br>$1', $parte_trabajo->condiciones_generales);
            $nombreArchivo = '';

            if ( $request->query('formato') === 'corto') {
                $nombreArchivo = 'presupuesto_c' . $parte_trabajo->cliente->NombreCliente . '_' . Carbon::now()->format('d-m-Y') . '.pdf';
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.presupuesto', [
                    'parte' => $parte_trabajo,
                    'images' => $images,
                    'condicionesGenerales' => $condicionesGenerales
                ])->setPaper('a4');;
            }else{
                $nombreArchivo = 'presupuesto_l' . $parte_trabajo->cliente->NombreCliente . '_' . Carbon::now()->format('d-m-Y') . '.pdf';
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.presupuestoLargo', [
                    'parte' => $parte_trabajo,
                    'images' => $images,
                    'condicionesGenerales' => $condicionesGenerales
                ])->setPaper('a4', 'landscape');;
            }

            // el nombre de archivo debe tener el nombre del cliente y la fecha de hoy
            return $pdf->download($nombreArchivo);
            
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function storeArticuloPresu(Request $request){
        try {

            DB::beginTransaction();
            // debemos crear un articulo nuevo pero con trazabilidad que diga "Proviene_Presupuesto_No_Facturado"
            $articulo = Articulos::create([
                'nombreArticulo' => $request->nombre,
                'ptsCosto' => $request->ptsCosto,
                'ptsVenta' => $request->total,
                'Beneficio' => $request->Beneficio,
                'Observaciones' => 'Este articulo ha sido fichado desde presupuestos, no tiene stock ni trazabilidad, tampoco tiene proveedor asignado',
                'TrazabilidadArticulos' => 'Proviene_Presupuesto_No_Facturado',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'categoria_id' => 9,
            ]);

            // crearle un stock vacio al articulo
            ArticulosStock::create([
                'articulo_id' => $articulo->idArticulo,
                'stock' => 0,
                'stockMinimo' => 0,
                'stockMaximo' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Articulo creado correctamente',
                'articulo' => $articulo,
                'id'       => $articulo->idArticulo,
                'nombre'   => $articulo->nombreArticulo,
                'precio'   => $articulo->ptsVenta,
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }

    }

    public function updatefile(Request $request){
        try {

            $archivo = Archivos::findOrFail($request->archivoId);

            // buscar el archivo en la tabla de partes_trabajo_archivos
            $partes_archivos = PresupuestosArchivos::where('archivo_id', $archivo->idarchivos)->first();

            if ($partes_archivos) {
                $partes_archivos->where('archivo_id', $archivo->idarchivos)->update([
                    'comentarioArchivo' => $request->comentario
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Comentario actualizado correctamente',
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function getStock(string $id)
    {
        $stock = ArticulosStock::where('articulo_id', $id)
        ->with('articulo')->first();
    
        return response()->json([
            'success' => true,
            'stock' => $stock,
            'status' => 200
        ]);
    }

    public function updateParte(Request $request, $id){
        try {

            $parte_trabajo = PresupuestosPartes::find($id);
            $parte_trabajo->update([
                'Asunto'            => $request->asunto,
                'FechaAlta'         => $request->fecha_alta,
                'FechaVisita'       => $request->fecha_visita,
                'Estado'            => $request->estado,
                'cliente_id'        => $request->cliente_id,
                'Departamento'      => $request->departamento,
                'Observaciones'     => $request->observaciones,
                'suma'              => $request->suma,
                'trabajo_id'        => $request->trabajo_id,
                'estadoVenta'       => $parte_trabajo->estadoVenta,
                'solucion'          => $request->solucion,
                'hora_inicio'       => $request->hora_inicio,
                'hora_fin'          => $request->hora_fin,
                'horas_trabajadas'  => $request->horas_trabajadas,
                'precio_hora'       => $request->precio_hora,
                'desplazamiento'    => $request->desplazamiento,
                'nombre_firmante'   => $request->nombre_firmante,
            ]);

            // subir archivos
            if ( $request->hasFile('file') ) {
                // Manejar la carga de archivos
                $images = [];

                $files = $request->file('file'); // Utilizar el método file para obtener los archivos

                if ($files && is_array($files) && count($files) > 0) {
                    $nombreFolder = formatFolderName($parte_trabajo->idParteTrabajo);

                    $path = public_path("/archivos/presupuestos/$request->presupuesto_id/$nombreFolder");

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    foreach ($files as $key => $file) {
                        $name = str_replace(' ', '_', $file->getClientOriginalName());
                        $file->move($path, $name);

                        $archivo = Archivos::create([
                            'nameFile' => $name,
                            'typeFile' => $file->getClientOriginalExtension(),
                            'pathFile' => $path . "/" . $name,
                        ]);

                        PresupuestosArchivos::create([
                            'parteTrabajo_id' => $parte_trabajo->idParteTrabajo,
                            'archivo_id' => $archivo->idarchivos,
                            'comentarioArchivo' => $request->comentario[$key + 1] ?? ''
                        ]);

                        $images[] = $path . "/" . $name;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Parte de trabajo actualizado correctamente',
                'partes_trabajo' => $parte_trabajo,
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

}
