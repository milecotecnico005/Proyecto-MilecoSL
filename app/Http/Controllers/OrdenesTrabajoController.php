<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\NotificationOperarios;
use App\Models\Archivos;
use App\Models\Articulos;
use App\Models\Cita;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Operarios;
use App\Models\OrdenesTrabajo;
use App\Models\ordentrabajo_operarios;
use App\Models\Project;
use App\Models\Trabajos;
use App\Models\trabajos_archivos;
use App\Models\trabajos_has_ordentrabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\GoogleCalendarController;
use App\Models\citas_archivos;
use App\Models\PartesTrabajo;
use App\Models\Project_orden;
use App\Models\ProyectosPartes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdenesTrabajoController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trabajos  = Trabajos::all();
        $clientes  = Cliente::all();
        $citas     = Cita::Where('estado', 'pendiente')->get();
        $operarios = Operarios::all();

        $ordenes   = OrdenesTrabajo::orderBy('idOrdenTrabajo', 'desc')->with(
            'cliente',
            'trabajo',
            'operarios',
            'operarios.user',
            'cita',
            'archivos',
            'presupuesto',
            'partesTrabajo',
            'proyecto',
            'archivos.comentarios',
            'cliente.tipoCliente',
        )->get();
        $projects  = Project::all();
        $articulos = Articulos::all();

        // dd($ordenes[10]);

        return view('admin.ordenes-trabajo.index', compact('trabajos', 'clientes', 'citas', 'operarios', 'ordenes', 'projects', 'articulos'));
    }

    public function showApi(Request $request){

        try {
            
            $id = $request->ordenId;
            
            $orden = OrdenesTrabajo::with(
                'cliente',
                'cita',
                'trabajo',
                'operarios',
            )->findOrFail($id);

            $orden->archivos = trabajos_archivos::where('orden_id', $orden->idOrdenTrabajo)
            ->leftJoin('archivos', 'trabajos_archivos.archivo_id', '=', 'archivos.idarchivos')
            ->OrderBy('archivos.created_at', 'asc')
            ->get();

            return response()->json([
                'status' => true,
                'orden'  => $orden,
                'code'   => 200,
                'success' => true,
            ]);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 404);
        }    
    }

    public function store(Request $request){
        try {
            // Validar la solicitud
            $request->validate([
                'asunto'       => 'required',
                'fecha_alta'   => 'required',
                'estado'       => 'required',
                'cliente_id'   => 'required',
                'trabajo_id'   => 'required|array', // Asegúrate de que sea un arreglo
            ]);


            DB::beginTransaction();
            // Crear la orden de trabajo
            $orden = OrdenesTrabajo::create([
                'cita_id'       => $request->input('cita'),
                'Asunto'        => $request->input('asunto'),
                'FechaAlta'     => $request->input('fecha_alta'),
                'FechaVisita'   => $request->input('fecha_visita'),
                'Estado'        => $request->input('estado'),
                'cliente_id'    => $request->input('cliente_id'),
                'Departamento'  => $request->input('departamento'),
                'Observaciones' => $request->input('observaciones', ''), // Valor predeterminado en caso de que esté vacío
                'hora_inicio'   => $request->input('hora_inicio'),
                'hora_fin'      => $request->input('hora_fin'),
            ]);

            // Actualizar la cita correspondiente
            $citaModel = Cita::findOrFail($request->input('cita'));
            $citaModel->update([
                'estado' => $request->input('estado')
            ]);

            $folder = $orden->idOrdenTrabajo;

            // verificar si la cita tiene archivos
            $files_cita = $citaModel->archivos;

            // Manejar la carga de archivos
            $images = [];
            $comentarios = [];
            $media = [];

            $files = $request->file('file'); // Utilizar el método file para obtener los archivos

            if($files_cita && count($files_cita) > 0) {
                foreach ($files_cita as $key => $file) {
                    
                    $comentario = citas_archivos::where('archivo_id', $file->idarchivos)->first()->comentarioArchivo ?? 'Archivo de la cita';

                    // Ruta de destino donde copiarás los archivos
                    $path = public_path("/archivos/ordenestrabajo/$folder");

                    // Verificar si la carpeta de destino existe, si no, crearla
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    // Obtener el nombre del archivo sin espacios
                    $name = str_replace(' ', '_', $file->nameFile);

                    // Ruta de origen del archivo actual
                    $sourcePath = public_path($file->pathFile); // Asegúrate de que pathFile tenga la ruta completa en la BD

                    // Ruta de destino del archivo
                    $destinationPath = $path . "/" . $name;

                    // Copiar el archivo desde la ubicación original a la nueva ubicación
                    if (file_exists($sourcePath)) {
                        // copiar el archivo de la ruta de assets a la ruta de archivos
                        copy($sourcePath, $destinationPath);
                    }
                    
                    $destinationPath = "archivos/ordenestrabajo/$folder/$name";

                    // Crear registro en la tabla Archivos con la nueva ruta
                    $archivo = Archivos::create([
                        'nameFile' => $name,
                        'typeFile' => $file->typeFile,
                        'pathFile' => $destinationPath,
                    ]);

                    // Asociar el archivo con la orden de trabajo
                    trabajos_archivos::create([
                        'archivo_id' => $archivo->idarchivos,
                        'orden_id'   => $orden->idOrdenTrabajo,
                        'comentarioArchivo' => $comentario
                    ]);

                    // Verificar el tipo de archivo por la extensión
                    $extension = $file->typeFile;
                    $mediaType = '';

                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $mediaType = 'photo'; // Imagen
                    } elseif (in_array($extension, ['mp4', 'mov', 'avi'])) {
                        $mediaType = 'video'; // Video
                    } elseif (in_array($extension, ['mp3', 'wav', 'ogg'])) {
                        $mediaType = 'audio'; // Audio
                    } elseif (in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
                        $mediaType = 'document'; // Word, Excel, PDF
                    }

                    // Añadir la ruta de la imagen a la lista
                    $images[] = public_path($destinationPath);

                    // Guardar el archivo junto con su tipo y comentario
                    $media[] = [
                        'path' => public_path($destinationPath),
                        'type' => $mediaType,
                        'comment' => "Orden #" . $orden->idOrdenTrabajo . " --> " . $comentario
                    ];
                }
            }

            if ($files && is_array($files) && count($files) > 0) {
                $path = public_path("/archivos/ordenestrabajo/$folder");
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                foreach ($files as $key => $file) {
                    $name = str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move($path, $name);

                    $comentario = $request->comentario[$key] ?? 'Sin comentario';

                    $path = "archivos/ordenestrabajo/$folder";

                    $archivo = Archivos::create([
                        'nameFile' => $name,
                        'typeFile' => $file->getClientOriginalExtension(),
                        'pathFile' => $path . "/" . $name,
                    ]);

                    trabajos_archivos::create([
                        'archivo_id' => $archivo->idarchivos,
                        'orden_id'   => $orden->idOrdenTrabajo,
                        'comentarioArchivo' => $comentario
                    ]);

                    // Verificar el tipo de archivo por la extensión
                    $extension = $file->getClientOriginalExtension();
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

                    $images[] = public_path($path . "/" . $name);

                    // Guardar el archivo junto con su tipo y comentario
                    $media[] = [
                        'path' => public_path($path . "/" . $name),
                        'type' => $mediaType,
                        'comment' => "Orden #".$orden->idOrdenTrabajo."-->".$comentario
                    ];
                }
            }

            // Manejar datos del cliente
            $clienteData = Cliente::findOrFail($request->input('cliente_id'));
            $ciudad      = Ciudad::findOrFail($clienteData->ciudad_Id)->nameCiudad;

            $otherData = [
                'asunto'        => $request->input('asunto'),
                'fecha_alta'    => $request->input('fecha_alta'),
                'fecha_visita'  => $request->input('fecha_visita'),
                'estado'        => $request->input('estado'),
                'Cliente'       => $clienteData->NombreCliente . ' ' . $clienteData->ApellidoCliente,
                'direccion'     => $clienteData->Direccion,
                'codigo_postal' => $clienteData->CodPostalCliente,
                'ciudad'        => $ciudad,
                'email'         => $clienteData->EmailCliente,
                'telefono'      => $clienteData->telefonos->first()->telefono ?? '',
                'departamento'  => $request->input('departamento'),
                'observaciones' => $request->input('observaciones', ''),
                'start_time'    => $request->input('hora_inicio'),
                'end_time'      => $request->input('hora_fin'),
            ];


            $messageNotification = "N°ORDEN.:  #" . $orden->idOrdenTrabajo . "\n\n" .
                "F.VISITA.....: " . $request->input('fecha_visita') . "\n" .
                "H.CITA INICIO.......: " . $request->input('hora_inicio') . "\n" .
                "H.CITA FIN (Aprox).......: " . $request->input('hora_fin') . "\n" .
                "ÓPERARIO.....: ";

            // Asignar operarios a la orden de trabajo
            $operarios = $request->input('operario_id', []);
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

            // contar cuantos trabajos se han asignado
            $countTrabajos = count($request->input('trabajo_id', []));
            if ($countTrabajos > 1) {

                // verificar si el trabajo es un string o un número
                if( !is_numeric($request->trabajo_id[0]) ){
                    $trabajos = Trabajos::whereIn('nameTrabajo', $request->input('trabajo_id', []))->get();
                    $trabajosNames = $trabajos->pluck('nameTrabajo')->toArray();
                }else{
                    $trabajos = Trabajos::WHERE('idTrabajo', $request->trabajo_id[0])->first();
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
                if( !is_numeric($request->trabajo_id[0]) ){
                    $trabajos = Trabajos::whereIn('nameTrabajo', $request->input('trabajo_id', []))->get();
                    $trabajosNames = $trabajos->pluck('nameTrabajo')->toArray();
                }else{
                    $trabajos = Trabajos::WHERE('idTrabajo', $request->trabajo_id[0])->first();
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
                "ESTADO.......: " . $request->input('estado') . "\n" .
                "CLIENTE......: " . $clienteData->NombreCliente . " " . $clienteData->ApellidoCliente . "\n\n" .
                "ASUNTO.......: " . $request->input('asunto') . "\n" .
                "OBSERVACIONES: " . $request->input('observaciones', '') . "\n";

            
            // Asignar trabajos a la orden de trabajo
            foreach ($request->input('trabajo_id', []) as $trabajo) {
                trabajos_has_ordentrabajo::create([
                    'orden_id'   => $orden->idOrdenTrabajo,
                    'trabajo_id' => $trabajo
                ]);
            }

            // Enviar notificación a Telegram
            $telegramController = new NotificationsController();

            $chatIdAutomatico = $telegramController->getCurrentChatIdByConfig('avisos');

            $telegramController->sendMessageTelegram($chatIdAutomatico, $messageNotification, $media);

            // añadir al google calendar de los operarios
            //TODO: funciona bien pero se debe solucionar el problema de la autenticación
            // $googleCalendarController = new GoogleCalendarController();
            // $googleCalendarController->createEvent($operariosToCalendar, $otherData, $messageNotification);

            DB::commit();
            return redirect()->route('admin.ordenes.index')->with('success', 'Orden de trabajo creada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getLine(), $e->getFile(), $e->getTrace());
            return redirect()->route('admin.ordenes.index')->with('error', 'Error al crear la orden de trabajo ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'asunto'       => 'required',
                'fecha_alta'   => 'required',
                'cliente_id'   => 'required',
                'trabajo_id'   => 'required',
            ]);

            DB::beginTransaction();

            $orden = OrdenesTrabajo::FindOrFail($id);
            $citas = Cita::FindOrFail($orden->cita_id);

            if( !$request->estado ){
                // añaadir el estado de en proceso al request
                $request['estado'] = $orden->Estado;
            }

            // udpate cita
            $citas->update([
                'estado' => $request->estado
            ]);

            // verificar si tiene parte de trabajo y actualizarlo
            $parte = PartesTrabajo::find($orden->idOrdenTrabajo);
            
            if ($parte) {
                $estadoParte = $request->estado == 'Pendiente' ? 1 : ($request->estado == 'En proceso' ? 2 : 3);

                if ($estadoParte == 3) { // Si el estado es finalizado
                    $zipController = new ZipController();
                    $zipController->createZipWhenOrderStatusFinished($orden->idOrdenTrabajo);
                }

                $parte->update([
                    'Estado' => $estadoParte
                ]);
            }

            $orden->update([
                'Asunto'        => $request->asunto,
                'FechaAlta'     => $request->fecha_alta,
                'FechaVisita'   => $request->fecha_visita,
                'Estado'        => $request->estado,
                'cliente_id'    => $request->cliente_id,
                'Departamento'  => $request->departamento,
                'Observaciones' => $request->observaciones,
            ]);

            // Verificar si se han subido archivos
            $images         = [];
            $comentarios    = [];
            $media          = [];

            $files = $request->file('file'); // Utilizar el método file para obtener los archivos

            if ($files && is_array($files) && count($files) > 0) {
                $path = public_path("/archivos/ordenestrabajo/$orden->idOrdenTrabajo");
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                foreach ($files as $key => $file) {
                    $name = str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move($path, $name);

                    $path = "archivos/ordenestrabajo/$orden->idOrdenTrabajo";

                    $comentario = $request->comentario[$key] ?? 'Sin comentario';

                    $archivo = Archivos::create([
                        'nameFile' => $name,
                        'typeFile' => $file->getClientOriginalExtension(),
                        'pathFile' => $path . "/" . $name,
                    ]);

                    trabajos_archivos::create([
                        'archivo_id' => $archivo->idarchivos,
                        'orden_id'   => $orden->idOrdenTrabajo,
                        'comentarioArchivo' => $comentario
                    ]);

                    // Verificar el tipo de archivo por la extensión
                    $extension = $file->getClientOriginalExtension();
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

                }
            }

            // Actualizar los trabajos de la orden de trabajo
            trabajos_has_ordentrabajo::where('orden_id', $orden->idOrdenTrabajo)->delete();

            foreach ( $request->trabajo_id as $trabajo ) {

                if ( !is_numeric($trabajo) ) {
                    $trabajo = Trabajos::where('nameTrabajo', $trabajo)->first()->idTrabajo;
                }
                
                trabajos_has_ordentrabajo::create([
                    'orden_id'   => $orden->idOrdenTrabajo,
                    'trabajo_id' => $trabajo
                ]);

            }

            // Cargar todos los archivos de la orden de trabajo subidos previamente
            $archivos = trabajos_archivos::where('orden_id', $orden->idOrdenTrabajo)->get();

            if ($archivos && count($archivos) > 0) {
                foreach ($archivos as $archivo) {
                    $path = Archivos::findOrFail($archivo->archivo_id);

                    $comentario = $archivo->comentarioArchivo;

                    $pathDefinitivp = $path->pathFile; // /home/u657674604/domains/sebcompanyes.com/public_html/archivos/ordenestrabajo/botiquin.jpg

                    // formato de la ruta
                    $url = public_path($pathDefinitivp);

                    // Verificar el tipo de archivo por la extensión
                    $extension = $path->typeFile;
                    $mediaType = '';

                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $mediaType = 'photo'; // Imagen
                    } elseif (in_array($extension, ['mp4', 'mov', 'avi'])) {
                        $mediaType = 'video'; // Video
                    } elseif (in_array($extension, ['mp3', 'wav', 'ogg'])) {
                        $mediaType = 'audio'; // Audio
                    } elseif (in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
                        $mediaType = 'document'; // Word, Excel, PDF
                    }

                    if ($mediaType == 'photo' || $mediaType == 'document') {
                        $images[] = $url;
                    }

                    // Guardar el archivo junto con su tipo y comentario
                    $media[] = [
                        'path' => $url,
                        'type' => $mediaType,
                        'comment' => "Orden #" . $orden->idOrdenTrabajo . " --> " . $comentario
                    ];
                }
            }

            // Manejar datos del cliente
            $clienteData = Cliente::findOrFail($request->cliente_id);
            $ciudad      = Ciudad::findOrFail($clienteData->ciudad_Id)->nameCiudad;

            $otherData = [
                'asunto'        => $request->asunto,
                'fecha_alta'    => $request->fecha_alta,
                'fecha_visita'  => $request->fecha_visita,
                'estado'        => $request->estado,
                'Cliente'       => $clienteData->NombreCliente . ' ' . $clienteData->ApellidoCliente,
                'direccion'     => $clienteData->Direccion,
                'codigo_postal' => $clienteData->CodPostalCliente,
                'ciudad'        => $ciudad,
                'email'         => $clienteData->EmailCliente,
                'telefono'      => $clienteData->telefonos->first()->telefono ?? '',
                'departamento'  => $request->departamento,
                'observaciones' => $request->observaciones ?? '',
                'start_time'    => $request->hora_inicio,
                'end_time'      => $request->hora_fin,
            ];

            $messageNotification = "SE HA ACTUALIZADO LA ORDEN: #" . $orden->idOrdenTrabajo . "\n\n" .
                "F.VISITA.....: " . $request->fecha_visita . "\n" .
                "H.CITA INICIO.......: " . $request->hora_inicio . "\n" .
                "H.CITA FIN (Aprox).......: " . $request->hora_fin . "\n" .
                "ÓPERARIO.....: ";

            // Asignar operarios a la orden de trabajo
            $operarios = $request->input('operario_id', []);

            if ($operarios && is_array($operarios) && count($operarios) > 0) {
                $operariosToCalendar = Operarios::whereIn('idOperario', $operarios)->get()->toArray();
                $operarioNames = [];
                
                ordentrabajo_operarios::where('orden_id', $orden->idOrdenTrabajo)->delete();

                foreach ($operarios as $operario) {                

                    if ( !is_numeric($operario) ) {
                        $operario = Operarios::where('nameOperario', $operario)->first()->idOperario;
                    }

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

            // contar cuantos trabajos se han asignado
            $countTrabajos = count($request->input('trabajo_id', []));

            if ($countTrabajos > 1) {
                // Extraer los nombres de los trabajos
            
                // Verificar si el trabajo es un string o un número
                if (!is_numeric($request->trabajo_id[0])) {
                    $trabajos = Trabajos::whereIn('nameTrabajo', $request->input('trabajo_id', []))->get();
                    $trabajosNames = $trabajos->pluck('nameTrabajo')->toArray();
                } else {
                    $trabajos = Trabajos::WHERE('idTrabajo', $request->trabajo_id[0])->first();
                    $trabajosNames = [$trabajos->nameTrabajo]; // Convertir en array
                }
            
                $messageNotification .= 'TRABAJOS...: ' . implode(', ', $trabajosNames) . "\n";
            
            } else {
                // Extraer el nombre del trabajo
            
                // Verificar si el trabajo es un string o un número
                if (!is_numeric($request->trabajo_id[0])) {
                    $trabajos = Trabajos::whereIn('nameTrabajo', $request->input('trabajo_id', []))->get();
                    $trabajosNames = $trabajos->pluck('nameTrabajo')->toArray();
                } else {
                    $trabajos = Trabajos::WHERE('idTrabajo', $request->trabajo_id[0])->first();
                    $trabajosNames = [$trabajos->nameTrabajo]; // Convertir en array
                }
            
                $messageNotification .= 'TRABAJO...: ' . implode(', ', $trabajosNames) . "\n";
            }

            $messageNotification .= "\n" .
                "CIUDAD.......: " . $ciudad . "\n" .
                "DIRECCION....: " . $clienteData->Direccion . "\n" .
                "ESTADO.......: " . $request->estado . "\n" .
                "CLIENTE......: " . $clienteData->NombreCliente . " " . $clienteData->ApellidoCliente . "\n\n" .
                "ASUNTO.......: " . $request->asunto . "\n" .
                "OBSERVACIONES: " . $request->observaciones . "\n";


            // Enviar notificación a Telegram
            $telegramController = new NotificationsController();

            $chatIdAutomatico = $telegramController->getCurrentChatIdByConfig('avisos');

            $telegramController->sendMessageTelegram($chatIdAutomatico, $messageNotification, $media);

            DB::commit();
            return redirect()->route('admin.ordenes.index')->with('success', 'Orden de trabajo editada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getLine(), $e->getFile(), $e->getTrace());
            return redirect()->route('admin.ordenes.index')->with('error', 'Error al editar la orden de trabajo');
        }
    }

    public function createOrderByParte( Request $request ){
        try {
            // Validar la solicitud
            $request->validate([
                'asunto'       => 'required',
                'fecha_alta'   => 'required',
                'estado'       => 'required',
                'cliente_id'   => 'required',
                'trabajo_id'   => 'required|array', // Asegúrate de que sea un arreglo
            ]);
            
            DB::beginTransaction();
            $laOrdenTieneProyecto = false;

            // Obtener la orden de trabajo anterior
            $ordenAnterior = OrdenesTrabajo::findOrFail($request->orden_id);

            // validar si la orden de trabajo tiene un proyecto asociado
            $validateProject = Project_orden::where('orden_id', $ordenAnterior->idOrdenTrabajo)->first();
            
            if ( $validateProject ) {
                $laOrdenTieneProyecto = true;
                $project = Project::findOrFail($validateProject->proyecto_id);
            }

            // Obtener el parte de trabajo anterior
            $parte = PartesTrabajo::findOrFail($request->parte_id);

            // Creamos el proyecto asociado a la orden de trabajo
            $citaModel = Cita::findOrFail($ordenAnterior->cita_id);
            $nombreProyecto = 'Proyecto- ' . $citaModel->asunto;
            $descripcionProyecto = 'Proyecto creado a partir de la orden de trabajo #' . $ordenAnterior->idOrdenTrabajo. ' y parte de trabajo #' . $parte->idParteTrabajo;
            $start_date = $ordenAnterior->FechaVisita;
            $end_date = null;
            $status = 1;
            $user_id = Auth::user()->id;

            if( !$laOrdenTieneProyecto ){
                $project = Project::create([
                    'name'          => $nombreProyecto,
                    'description'   => $descripcionProyecto,
                    'start_date'    => $start_date,
                    'end_date'      => $end_date,
                    'status'        => $status,
                    'user_id'       => $user_id
                ]);

                // Asociar el proyecto con la orden de trabajo
                Project_orden::create([
                    'proyecto_id' => $project->idProyecto,
                    'orden_id'    => $ordenAnterior->idOrdenTrabajo
                ]);
    
                // Asoaciar el proyecto con la parte de trabajo
                ProyectosPartes::create([
                    'proyecto_id'       => $project->idProyecto,
                    'parteTrabajo_id'   => $parte->idParteTrabajo
                ]);
    
                // Actualizar Orden anterior
                $ordenAnterior->update([
                    'Asunto' => 'Proyecto-' . $ordenAnterior->Asunto
                ]);
            }

            // Crear la orden de trabajo
            $orden = OrdenesTrabajo::create([
                'cita_id'       => $ordenAnterior->cita_id,
                'Asunto'        => 'Proyecto-' . $request->asunto,
                'FechaAlta'     => $request->fecha_alta,
                'FechaVisita'   => $request->fecha_visita,
                'Estado'        => $request->estado,
                'cliente_id'    => $request->cliente_id,
                'Departamento'  => $request->departamento,
                'Observaciones' => $request->observaciones, // Valor predeterminado en caso de que esté vacío
                'hora_inicio'   => $request->hora_inicio,
                'hora_fin'      => $request->hora_fin,
            ]);

            // asocia la orden de trabajo con el proyecto
            Project_orden::create([
                'proyecto_id' => $project->idProyecto,
                'orden_id'    => $orden->idOrdenTrabajo
            ]);

            $nombreActualizado = "Proyecto$project->idProyecto- " . $citaModel->asunto;

            // Actualizar el nombre del proyecto
            $project->update([
                'name' => $nombreActualizado
            ]);

            // Actualizar la cita correspondiente
            $citaModel->update([
                'estado' => $request->estado
            ]);

            // Manejar la carga de archivos
            $images = [];
            $comentarios = [];
            $media = [];

            $files = $request->file('file'); // Utilizar el método file para obtener los archivos

            $nombreFolderFormated = formatFolderName($nombreProyecto);

            if ($files && is_array($files) && count($files) > 0) {
                $path = public_path("/archivos/ordenestrabajo/$nombreFolderFormated");
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                foreach ($files as $key => $file) {
                    $name = str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move($path, $name);

                    $comentario = $request->comentario[$key + 1] ?? 'Sin comentario';

                    $archivo = Archivos::create([
                        'nameFile' => $name,
                        'typeFile' => $file->getClientOriginalExtension(),
                        'pathFile' => $path . "/" . $name,
                    ]);

                    trabajos_archivos::create([
                        'archivo_id' => $archivo->idarchivos,
                        'orden_id'   => $orden->idOrdenTrabajo,
                        'comentarioArchivo' => $comentario
                    ]);

                    // Verificar el tipo de archivo por la extensión
                    $extension = $file->getClientOriginalExtension();
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

                    $images[] = $path . "/" . $name;

                    // Guardar el archivo junto con su tipo y comentario
                    $media[] = [
                        'path' => $path . "/" . $name,
                        'type' => $mediaType,
                        'comment' => "Orden #".$orden->idOrdenTrabajo."-->".$comentario
                    ];
                }
            }

            // Manejar datos del cliente
            $clienteData = Cliente::findOrFail($request->cliente_id);
            $ciudad      = Ciudad::findOrFail($clienteData->ciudad_Id)->nameCiudad;

            $otherData = [
                'asunto'        => $request->input('asunto'),
                'fecha_alta'    => $request->input('fecha_alta'),
                'fecha_visita'  => $request->input('fecha_visita'),
                'estado'        => $request->input('estado'),
                'Cliente'       => $clienteData->NombreCliente . ' ' . $clienteData->ApellidoCliente,
                'direccion'     => $clienteData->Direccion,
                'codigo_postal' => $clienteData->CodPostalCliente,
                'ciudad'        => $ciudad,
                'email'         => $clienteData->EmailCliente,
                'telefono'      => $clienteData->telefonos->first()->telefono ?? '',
                'departamento'  => $request->input('departamento'),
                'observaciones' => $request->input('observaciones', ''),
                'start_time'    => $request->input('hora_inicio'),
                'end_time'      => $request->input('hora_fin'),
            ];

            $messageNotification = "N°ORDEN.:  #" . $orden->idOrdenTrabajo . "\n\n" .
                "F.VISITA.....: " . $request->input('fecha_visita') . "\n" .
                "H.CITA INICIO.......: " . $request->input('hora_inicio') . "\n" .
                "H.CITA FIN (Aprox).......: " . $request->input('hora_fin') . "\n" .
                "ÓPERARIO.....: ";

            // Asignar operarios a la orden de trabajo
            $operarios = $request->input('operario_id', []);
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

            // contar cuantos trabajos se han asignado
            $countTrabajos = count($request->input('trabajo_id', []));
            if ($countTrabajos > 1) {
                $messageNotification .= 'TRABAJOS...: ' . $countTrabajos . "\n";
            } else {
                $messageNotification .= 'TRABAJO...: ' . $countTrabajos . "\n";
            }

            $messageNotification .= "\n" .
                "CIUDAD.......: " . $ciudad . "\n" .
                "DIRECCION....: " . $clienteData->Direccion . "\n" .
                "ESTADO.......: " . $request->input('estado') . "\n" .
                "CLIENTE......: " . $clienteData->NombreCliente . " " . $clienteData->ApellidoCliente . "\n\n" .
                "ASUNTO.......: " . $request->input('asunto') . "\n";

            
            // Asignar trabajos a la orden de trabajo
            foreach ($request->input('trabajo_id', []) as $trabajo) {
                trabajos_has_ordentrabajo::create([
                    'orden_id'   => $orden->idOrdenTrabajo,
                    'trabajo_id' => $trabajo
                ]);
            }

            // Enviar notificación a Telegram
            $telegramController = new NotificationsController();

            $chatIdAutomatico = $telegramController->getCurrentChatIdByConfig('avisos');

            $telegramController->sendMessageTelegram($chatIdAutomatico, $messageNotification, $media);

            // añadir al google calendar de los operarios
            //TODO: funciona bien pero se debe solucionar el problema de la autenticación
            // $googleCalendarController = new GoogleCalendarController();
            // $googleCalendarController->createEvent($operariosToCalendar, $otherData, $messageNotification);

            DB::commit();
            return redirect()->route('admin.ordenes.index')->with('success', 'Orden de trabajo creada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getLine(), $e->getFile());
            return redirect()->route('admin.ordenes.index')->with('error', 'Error al crear la orden de trabajo ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
