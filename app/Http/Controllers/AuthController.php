<?php

namespace App\Http\Controllers;

use App\Mail\NotificationOperarios;
use App\Models\Archivos;
use App\Models\Articulos;
use App\Models\ArticulosStock;
use App\Models\Cita;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Operarios;
use App\Models\OrdenesTrabajo;
use App\Models\ordentrabajo_operarios;
use App\Models\PartesTrabajo;
use App\Models\partesTrabajoArchivos;
use App\Models\PartesTrabajoLineas;
use App\Models\PositionOrder;
use App\Models\Project;
use App\Models\ProyectosPartes;
use App\Models\trabajos_archivos;
use App\Models\trabajos_has_ordentrabajo;
use App\Models\User;
use App\Models\UserTokens;
use App\Notifications\AllOrderNotification;
use Carbon\Carbon;
use Google\Service\ServiceControl\Auth;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

// Firebase
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class AuthController extends Controller
{
    public function loginApi(Request $request)
    {
    
        $email      = $request->email;
        $password   = $request->password;
        $fmc        = $request->fmc;

        $user = User::where('email', $email)->first();

        if( $user->userState != 1){
            return response()->json([
                'status' => false,
                'message' => 'Usuario deshabilitado',
            ]);
        }

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email o contraseña incorrectos',
            ]);
        }else{

            if ($user->hasRole('tecnico') || $user->hasRole('operario')) {
                $operarioId = Operarios::where('user_id', $user->id)->first()->idOperario;
                $user->operarioId = $operarioId;
            }else{
                $operarioId = null;
            }

            // verificar si el usuario es un tecnico

            $verifyOperario = Operarios::where('user_id', $user->id)->first();

            if ( $verifyOperario ) {
                $user->operarioId = $verifyOperario->idOperario;
            }

            // verificar si el usuario no tiene un token asignado

            $verifyToken = UserTokens::where('users_id', $user->id)->first();

            if ( !$verifyToken ) {
                $token = ( string ) Str::uuid( $user->email ."-". $user->id );
                $token = Hash::make($token);
                DB::beginTransaction();
                UserTokens::create([
                    'users_id' => $user->id,
                    'loged_token' => $token,
                    'firebase_token' => $fmc
                ]);

            }else{
                DB::beginTransaction();
                // actualizar el token de firebase
                $verifyToken->update([
                    'firebase_token' => $fmc
                ]);

                $token = $verifyToken->loged_token;

            }

            $user['token'] = $token;
            $user['fmc'] = $fmc;

            // Retornamos el token y toda la informacion del user
            // $user->token = $token;
            
            DB::commit();
            return response()->json([
                'status'    => true,
                'data'      => $user,
                'role'      => $user->getRoleNames(),
                'token'     => $token,
                'fmctoken'  => $fmc,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Credenciales invalidas',
        ]);
    }

    public function verifyLogin( Request $request ){
        $token = $request->header('Authorization');
        $fmc   = $request->fmc;
        
        return response()->json([
            'status' => 'pending',
            'fmc'   => $fmc,
            'token' => $token
        ]);

        $token = str_replace('Bearer ', '', $token);
        
        $userToken = UserTokens::where('loged_token', $token)->first();

        if ( !$userToken ) {
            return response()->json([
                'status' => false,
                'message' => 'Token no valido'
            ]);
        }

        $user = User::find($userToken->users_id);

        // verificar si el usuario está deshabilitado

        if( $user->userState != 1){
            return response()->json([
                'status' => false,
                'message' => 'Usuario deshabilitado',
            ]);
        }

        // verificar si el usuario es un tecnico

        $verifyOperario = Operarios::where('user_id', $user->id)->first();

        if ( $verifyOperario ) {
            $user->operarioId = $verifyOperario->idOperario;
        }

        return response()->json([
            'status' => true,
            'message' => 'Token valido',
            'data' => $user,
            'role' => $user->getRoleNames(),
            'token'=> $token,
            'fmctoken' => $fmc
        ]);
    }

    public function registerApi(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ])->assignRole('tecnico');

        return response()->json([
            'status' => true,
            'data' => $user,
        ]);
    }

    public function getOrdersByOperario($id, Request $request)
    {

        // obtener el token de la cabecera

        $token = $request->header('Authorization');

        // limpiar el token

        $token = str_replace('Bearer ', '', $token);

        // buscar el token en la base de datos

        $userToken = UserTokens::where('loged_token', $token)->first();

        if ( !$userToken ) {
            return response()->json([
                'status' => false,
                'message' => 'Token no valido'
            ]);
        }

        $ordenes = OrdenesTrabajo::with('operarios')
        ->whereHas('operarios', function($query) use ($id) {
            $query->where('operario_id', $id); // Filtrar por el operario específico
        })
        ->orderBy('idOrdenTrabajo', 'DESC')
        ->get();
        
        foreach ( $ordenes as $orden ) {
            
            $orden["cliente"]       = $orden->cliente;
            $orden["telefonos"]     = $orden->telefonosClientes;
            $orden["trabajos"]      = $orden->trabajo;
            $orden["operarios"]     = ordentrabajo_operarios::where('orden_id', $orden->idOrdenTrabajo)
                                        ->join('operarios', 'ordentrabajo_operarios.operario_id', '=', 'operarios.idOperario')->get();
            $orden["cita"]          = $orden->cita;
            $orden["presupuesto"]   = $orden->presupuesto;
            $orden["archivos"]      = $orden->archivos;
            $orden["partesTrabajo"] = $orden->partesTrabajo;
            
        }

        return response()->json([
            'status' => true,
            'data' => $ordenes
        ]);
    }

    public function getOrderById($id, Request $request){
        try {

            // obtener el token de la cabecera

            $token = $request->header('Authorization');

            // limpiar el token

            $token = str_replace('Bearer ', '', $token);

            // buscar el token en la base de datos

            $userToken = UserTokens::where('loged_token', $token)->first();

            if ( !$userToken ) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token no valido'
                ]);
            }
            
            $order = OrdenesTrabajo::join('clientes', 'ordentrabajo.cliente_id', '=', 'clientes.idClientes')
            ->join('telefonosclientes', 'clientes.idClientes', '=', 'telefonosclientes.Clientes_idClientes')
            ->leftJoin('ordentrabajo_operarios', 'ordentrabajo.idOrdenTrabajo', '=', 'ordentrabajo_operarios.orden_id')
            ->leftJoin('operarios', 'ordentrabajo_operarios.operario_id', '=', 'operarios.idOperario')
            ->select(
                'ordentrabajo.*',
                'clientes.NombreCliente',
                'clientes.ApellidoCliente',
                'clientes.Direccion',
                'telefonosclientes.telefono',
                'operarios.idOperario',
                'operarios.nameOperario',
                'operarios.telefonoOperario',
            )
            ->find($id);

            if ( $order ) {
                $order["Archivos"] = trabajos_archivos::where('orden_id', $id)->join('archivos', 'trabajos_archivos.archivo_id', '=', 'archivos.idarchivos')->get();
            }

            // verificar si la orden tiene parte/s de trabajo
            $trabajos = PartesTrabajo::where('orden_id', $id)->get();

            if ( $trabajos ) {
                foreach ($trabajos as $trabajo) {
                    $trabajo["lineas"] = $trabajo->partesTrabajoLineas;
                    $trabajo["archivos"] = partesTrabajoArchivos::where('parteTrabajo_id', $trabajo->idParteTrabajo)
                    ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', '=', 'archivos.idarchivos')
                    ->get();
                }
                $order["Trabajos"] = $trabajos;
            }

            return response()->json([
                'status' => true,
                'data' => $order
            ]);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getOrdersByClient( $id, Request $request ){
        try {
           
            // obtener el token de la cabecera

            $token = $request->header('Authorization');

            // limpiar el token

            $token = str_replace('Bearer ', '', $token);

            // buscar el token en la base de datos

            $userToken = UserTokens::where('loged_token', $token)->first();

            if ( !$userToken ) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token no valido'
                ]);
            }

            $cliente = Cliente::where('user_id', $id)->first();

            $ordenes = OrdenesTrabajo::where('cliente_id', $cliente->idClientes)
            ->with('operarios', 'trabajo', 'cita', 'archivos', 'partesTrabajo', 'cliente')
            ->get();

            return response()->json([
                'status' => true,
                'data' => $ordenes,
                'message' => 'Ordenes encontradas para el cliente ' . $cliente->NombreCliente . ' ' . $cliente->ApellidoCliente
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getAllOrdersPending( Request $request ){

        try {

            // obtener el token de la cabecera

            $token = $request->header('Authorization');

            // limpiar el token

            $token = str_replace('Bearer ', '', $token);

            // buscar el token en la base de datos

            $userToken = UserTokens::where('loged_token', $token)->first();

            if ( !$userToken ) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token no valido',
                    'token' => $token
                ]);
            }
            

            $ordenes = OrdenesTrabajo::with('cliente', 'trabajo')
            ->get();

            return response()->json([
                'status' => true,
                'data' => $ordenes
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }

    }

    public function getAllOrders( Request $request ){

        try {
            
            // obtener el token de la cabecera

            $token = $request->header('Authorization');

            // limpiar el token

            $token = str_replace('Bearer ', '', $token);

            // buscar el token en la base de datos

            $userToken = UserTokens::where('loged_token', $token)->first();

            if ( !$userToken ) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token no valido'
                ]);
            }

            $ordenes = OrdenesTrabajo::with('cliente', 'trabajo')->get();

            return response()->json([
                'status' => true,
                'data' => $ordenes
            ]);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'trace' => $th->getTrace()
            ]);
        }

    }

    public function updateStatusOrder( Request $request, $id ){
        try{
            DB::beginTransaction();

            $obtenerOrden = OrdenesTrabajo::findOrFail($id);

            $obtenerOrden->Estado = $request->status;
            $obtenerOrden->save();
            
            
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Estado de la orden actualizado correctamente',
                'newStatus' => $request->status
            ]);

            
        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'trace' => $th->getTrace()
            ]);
        }
    }

    public function getAllprojects( Request $request )
    {

        // obtener el token de la cabecera

        $token = $request->header('Authorization');

        // limpiar el token

        $token = str_replace('Bearer ', '', $token);

        // buscar el token en la base de datos

        $userToken = UserTokens::where('loged_token', $token)->first();

        if ( !$userToken ) {
            return response()->json([
                'status' => false,
                'message' => 'Token no valido'
            ]);
        }

        $projects = Project::all();

        return response()->json([
            'status' => true,
            'data' => $projects
        ]);
    }

    public function getAllproducts( Request $request ){

        // obtener el token de la cabecera

        $token = $request->header('Authorization');

        // limpiar el token

        $token = str_replace('Bearer ', '', $token);

        // buscar el token en la base de datos

        $userToken = UserTokens::where('loged_token', $token)->first();

        if ( !$userToken ) {
            return response()->json([
                'status' => false,
                'message' => 'Token no valido'
            ]);
        }

        $products = Articulos::with('categoria', 'stock', 'empresa', 'proveedor')->get();

        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }

    public function getTrabajosOfOrden($id, Request $request){

        // obtener el token de la cabecera

        $token = $request->header('Authorization');

        // limpiar el token

        $token = str_replace('Bearer ', '', $token);

        // buscar el token en la base de datos

        $userToken = UserTokens::where('loged_token', $token)->first();

        if ( !$userToken ) {
            return response()->json([
                'status' => false,
                'message' => 'Token no valido'
            ]);
        }

        $trabajos = trabajos_has_ordentrabajo::where('orden_id', $id)
        ->join('trabajos', 'trabajos.idTrabajo', 'trabajos_has_ordentrabajo.trabajo_id')->get();

        return response()->json([
            'status' => true,
            'data' => $trabajos
        ]);
    }

    public function storeOrdenesApi( Request $request ){
        try {
            DB::beginTransaction();

            // obtener el token de la cabecera

            $token = $request->header('Authorization');

            // limpiar el token

            $token = str_replace('Bearer ', '', $token);

            // buscar el token en la base de datos

            $userToken = UserTokens::where('loged_token', $token)->first();

            if ( !$userToken ) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Token no valido'
                ]);
            }
           
            if( $request->hasFile('images') ){

                $partes_trabajo = PartesTrabajo::create([
                    'Asunto'        => $request->asunto,
                    'FechaAlta'     => $request->fechaAlta,
                    'FechaVisita'   => $request->fechaVisita,
                    'Estado'        => 2,
                    'cliente_id'    => $request->cliente_id,
                    'Departamento'  => $request->Departamento,
                    'Observaciones' => $request->observaciones,
                    'suma'          => $request->suma,
                    'trabajo_id'    => $request->trabajo,
                    'orden_id'      => ( $request->idOrdenTrabajo ) ? $request->idOrdenTrabajo : null,
                ]);

                $position = $request->position;

                $positionFormated = json_encode([$position]);

                // Guardar en la base de datos en el formato requerido
                $positionOrder = PositionOrder::create([
                    'parte_id' => $partes_trabajo->idParteTrabajo,
                    'position_parte' => $positionFormated, // Asegurarse de que se almacene como un JSON array
                ]);

                if ( $request->idOrdenTrabajo ) {
            
                    // obtener los archivos de la orden
                    $orden = OrdenesTrabajo::find($request->idOrdenTrabajo);
                    
                    foreach ($orden->archivos as $file) {
    
                        $comentario = trabajos_archivos::where('archivo_id', $file->idarchivos)->first();
        
                        partesTrabajoArchivos::create([
                            'parteTrabajo_id'   => $partes_trabajo->idParteTrabajo,
                            'archivo_id'        => $file->idarchivos,
                            'comentarioArchivo' => ( $comentario ) ? $comentario->comentarioArchivo : 'Sin Comentario',
                        ]);
                    }
    
                }

                // imagenes
                $images = [];

                foreach ($request->file('images') as $key => $imagen) {

                    $name = str_replace(' ', '_', $imagen->getClientOriginalName());
                    // formatear asunto para quitar espacios y caracteres especiales y cambiar por guiones bajos
                    $nameFolder = formatFolderName($request->asunto);
                    $imagen->move(public_path('/archivos/ordenes_trabajo/' . $nameFolder), $name);

                    $archivo = Archivos::create([
                        'nameFile' => $name,
                        'typeFile' => $imagen->getClientOriginalExtension(),
                        'pathFile' => public_path('/archivos/ordenes_trabajo/' . $nameFolder) . "/" . $name,
                    ]);

                    partesTrabajoArchivos::create([
                        'parteTrabajo_id'   => $partes_trabajo->idParteTrabajo,
                        'archivo_id'        => $archivo->idarchivos,
                        'comentarioArchivo' => ($request->comments[$key]) ? $request->comments[$key] : 'Sin Comentario' 
                    ]);

                    $images[] = public_path('/archivos/ordenes_trabajo/' . $nameFolder) . "/" . $name;

                }

                // Crear lineas de trabajo

                foreach ( $request->lineas as $linea ) {
                   
                    $articulo = Articulos::find($linea["articulo_id"]);

                    $stock = ArticulosStock::where('articulo_id', $linea["articulo_id"])->first();

                    if ( $stock->cantidad < $linea["cantidad"] ) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'No hay suficiente stock para el articulo ' . $articulo->nombreArticulo,
                            'status' => 400
                        ]);
                    }

                    $stock->cantidad = $stock->cantidad - $linea["cantidad"];
                    $stock->save();

                    PartesTrabajoLineas::create([
                        'parteTrabajo_id' => $partes_trabajo->idParteTrabajo,
                        'articulo_id'     => $linea["articulo_id"],
                        'cantidad'        => $linea["cantidad"],
                        'precioSinIva'    => $linea["precioSinIva"],
                        'total'           => $linea["total"],
                        'descuento'       => $linea["descuento"],
                        'Trazabilidad'    => $articulo->TrazabilidadArticulos,
                    ]);

                }

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Parte de trabajo creado correctamente con ' . count($images) . ' imagenes y ' . count($request->lineas) . ' lineas de trabajo',
                    'status' => 200
                ]);

            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'No se han subido imagenes',
                    'status' => 400
                ]);
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'trace' => $th->getTrace()
            ]);
        }
    }

    public function generateOrderForOperario( Request $request ){
        try{
            DB::beginTransaction();


            // obtener el token de la cabecera

            $token = $request->header('Authorization');

            // limpiar el token

            $token = str_replace('Bearer ', '', $token);

            // buscar el token en la base de datos

            $userToken = UserTokens::where('loged_token', $token)->first();

            if ( !$userToken ) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Token no valido'
                ]);
            }

            $asunto         = $request->Asunto;
            $departamento   = $request->Departamento;
            $Estado         = $request->Estado;
            $fecha_alta     = $request->FechaAlta;
            $fecha_visita   = $request->FechaVisita;
            $observaciones  = $request->Observaciones;
            $cita           = $request->cita_id;
            $cliente_id     = $request->cliente_id;
            $hora_inicio    = $request->hora_inicio;
            $hora_fin       = $request->hora_fin;
            $operario_id    = $request->operario_id;
            $position       = $request->position;
            $presupuesto_id = $request->presupuesto_id;
            $trabajo_id     = $request->trabajo_id;
            $orden_id       = $request->idOrdenTrabajo;

            // formatear las horas de inicio y fin y fecha de visita y alta con carbon
            // las horas vienen en este formato 16\/09\/2024, 14:00:00

            Carbon::setLocale('es');
            $fecha_alta = Carbon::parse($fecha_alta)->format('Y-m-d');
            $fecha_visita = Carbon::parse($fecha_visita)->format('Y-m-d');
            
            // EXTRAER LA HORA DE INICIO Y FIN
            $hora_inicio = explode(',', $hora_inicio);
            $hora_fin = explode(',', $hora_fin);

            $hora_inicio = Carbon::parse($hora_inicio[1])->format('H:i:s');
            $hora_fin = Carbon::parse($hora_fin[1])->format('H:i:s');
            

            $orden = OrdenesTrabajo::find($orden_id)->update([
                'cita_id'       => $cita,
                'Asunto'        => $asunto,
                'FechaAlta'     => $fecha_alta,
                'FechaVisita'   => $fecha_visita,
                'Estado'        => $Estado,
                'cliente_id'    => $cliente_id,
                'Departamento'  => $departamento,
                'Observaciones' => $observaciones, // Valor predeterminado en caso de que esté vacío
                'hora_inicio'   => $hora_inicio,
                'hora_fin'      => $hora_fin,
            ]);

            // guardar la ubicación del operario en la orden
            // postition es un objeto, necesito pasarlo a un array y guardarlo en la tabla

            $positionFormated = json_encode([$position]);

            // Guardar en la base de datos en el formato requerido
            $positionOrder = PositionOrder::create([
                'orden_id' => $orden_id,
                'position' => $positionFormated, // Asegurarse de que se almacene como un JSON array
            ]);

            $orden = OrdenesTrabajo::find($orden_id); 

            // Actualizar la cita correspondiente
            $citaModel = Cita::findOrFail($cita);
            $citaModel->update([
                'estado' => $Estado
            ]);

            // Manejar la carga de archivos
            $images = [];

            if ( $request->hasFile('file') ) {
                $files = $request->file('file'); // Utilizar el método file para obtener los archivos
    
                if ($files && is_array($files) && count($files) > 0) {
                    $folder = formatFolderName($asunto);
                    $path = public_path("/archivos/ordenestrabajo/$folder");
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
    
                        trabajos_archivos::create([
                            'archivo_id' => $archivo->idarchivos,
                            'orden_id'   => $orden->idOrdenTrabajo,
                            'comentarioArchivo' => ( $request('comentarioArchivo') ) ? $request('comentarioArchivo')[$key] : 'Sin comentario'
                        ]);
    
                        $images[] = $path . "/" . $name;
                    }
                }
            }


            // Manejar datos del cliente
            $clienteData = Cliente::findOrFail($cliente_id);
            $ciudad      = Ciudad::findOrFail($clienteData->ciudad_Id)->nameCiudad;

            $otherData = [
                'asunto'        => $asunto,
                'fecha_alta'    => $fecha_alta,
                'fecha_visita'  => $fecha_visita,
                'estado'        => $Estado,
                'Cliente'       => $clienteData->NombreCliente . ' ' . $clienteData->ApellidoCliente,
                'direccion'     => $clienteData->Direccion,
                'codigo_postal' => $clienteData->CodPostalCliente,
                'ciudad'        => $ciudad,
                'email'         => $clienteData->EmailCliente,
                'telefono'      => $clienteData->telefonos->first()->telefono ?? '',
                'departamento'  => $departamento,
                'observaciones' => $observaciones,
                'start_time'    => $hora_inicio,
                'end_time'      => $hora_fin,
            ];

            // Construir mensaje de notificación
            $messageNotification = 'Se ha Actualizado la orden #'. $orden->idOrdenTrabajo .' de trabajo con el asunto ' . $asunto . ' para el cliente ' . $clienteData->NombreCliente . ' ' . $clienteData->ApellidoCliente . ' en la ciudad de ' . $ciudad . ' con fecha de visita ' . $fecha_visita . ' y estado ' . $Estado . ' y asignada ';
            $chatTelegramId = "-1002178106030";

            // Asignar operarios a la orden de trabajo
            $operarios = Operarios::whereIn('idOperario', [$operario_id])->get()->toArray();

            foreach($operarios as $operario){
                ordentrabajo_operarios::create([
                    'orden_id'    => $orden->idOrdenTrabajo,
                    'operario_id' => $operario["idOperario"]
                ]);

                $getOperario = Operarios::findOrFail($operario["idOperario"]);
                $username = $getOperario->nameOperario;

                $messageNotification .= ' al operario ' . $username;

                Mail::to($getOperario->emailOperario)->send(new NotificationOperarios($username, $otherData, $images));
            }
            
            // $operarios = $request('operario_id', []);
            // if ( $operarios && is_array($operarios) && count($operarios) > 0 ) {
            //     $operariosToCalendar = Operarios::whereIn('idOperario', $operarios)->get()->toArray();
            //     foreach ($operarios as $operario) {
            //         ordentrabajo_operarios::create([
            //             'orden_id'    => $orden->idOrdenTrabajo,
            //             'operario_id' => $operario
            //         ]);
    
            //         $getOperario = Operarios::findOrFail($operario);
            //         $username = $getOperario->nameOperario;
    
            //         if (count($operarios) > 1) {
            //             // Validar si es el último operario para no concatenar la coma
            //             if ($operario == end($operarios)) {
            //                 $messageNotification .= ' y al operario ' . $username;
            //             } else {
            //                 $messageNotification .= 'a, ' . $username;
            //             }
            //         } else {
            //             $messageNotification .= ' al operario ' . $username;
            //         }
    
            //         Mail::to($getOperario->emailOperario)->send(new NotificationOperarios($username, $otherData, $images));
            //     }
            // }

            $trabajosHaRealizar = trabajos_has_ordentrabajo::where('orden_id', $orden->idOrdenTrabajo)
            ->Join('trabajos', 'trabajos_has_ordentrabajo.trabajo_id', 'trabajos.idTrabajo')
            ->get();

            // contar cuantos trabajos se han asignado
            $countTrabajos = count($trabajosHaRealizar);

            if ($countTrabajos > 1) {
                $messageNotification .= ' y se han asignado un proyecto de ' . $countTrabajos . ' trabajos: ';
                foreach ($trabajosHaRealizar as $trabajo) {
                    $messageNotification .= $trabajo->nameTrabajo. ', ';
                }
            } else {
                $messageNotification .= ' y se ha asignado ' . $countTrabajos . ' trabajo';
                $messageNotification .= ' ' . $trabajosHaRealizar->first()->nameTrabajo;
            }

            $messageNotification .= ' Con hora de inicio ' . $hora_inicio . ' y hora de fin ' . $hora_fin;

            // Enviar notificación a Telegram
            $telegramController = new NotificationsController();
            $chatIdAutomatico = $telegramController->getCurrentChatIdByConfig('avisos');

            $telegramController->sendMessageTelegram($chatIdAutomatico, $messageNotification);

            // añadir al google calendar de los operarios
            //TODO: funciona bien pero se debe solucionar el problema de la autenticación
            // $googleCalendarController = new GoogleCalendarController();
            // $googleCalendarController->createEvent($operariosToCalendar, $otherData, $messageNotification);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Orden de trabajo actualizada correctamente',
                'data' => $orden
            ]);

        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'trace' => $th->getTrace()
            ]);
        }
    }

    public static function send( $user = null, $users = null, $messageData = null, $title = null, $screen = null ){
 
        $filePath = config('firebase.credentials.file');
        // Cargar la instancia de Firebase
        $factory = (new Factory)->withServiceAccount($filePath);

        // Crear la instancia de messaging
        $messaging = $factory->createMessaging();

        // if ( $screen ) {

        //     // Crear el mensaje de la notificación
        //     $message = CloudMessage::withTarget('token', 'dxj1SPp-T86M3nnmK4VRja:APA91bHesArNTQmhLEDlV_pkgB5I0ZW0YVWhF3Mu4VX4urInf5kAjrTO4JqwofY0m6D5rM1rR5O7Vg_PotriS5gmCvrtmZJpFBQfsVCVtzilOnDXW2U9sf5jD3dV-tDzg0p73gntKVZh')
        //     ->withNotification(Notification::create($messageData["title"], $messageData["body"]))
        //     ->withData([
        //         'screen' => $screen  // Nombre de la pantalla a la que deseas redirigir
        //     ]);

        // }else{

        //     $message = CloudMessage::withTarget('token', $user->device_token)
        //     ->withNotification(Notification::create($messageData["title"], $messageData["body"]));

        // }

        $message = CloudMessage::withTarget('token', 'e3WaUfHhT1anDmHFunl_ow:APA91bE_wqq1r9IK_j7qlQvrv0o-sFSj_RbXwmTWykWBF1qE0xRbd4eiui9bhWd8jHpEiu6n4ZzsN1Lk7_sCJ3w-o-QFxcmwVfbALvLI7v22YuF3p-NysF8br5gEr0X6xuvKWIS2neam')
        ->withNotification(Notification::create('prueba', 'prueba'));
    
        // Enviar el mensaje
        $messaging->send($message);
            
        dd('Mensaje enviado correctamente');
    }
    
}
