<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Archivos;
use App\Models\Banco;
use App\Models\Cita;
use App\Models\citas_archivos;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Operarios;
use App\Models\OrdenesTrabajo;
use App\Models\PartesTrabajo;
use App\Models\TipoCliente;
use App\Models\Trabajos;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitasController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){

        $citas = Cita::JOIN('users', 'citas.user_id', '=', 'users.id')
            ->select('citas.*', 'users.name')
            ->orderBy('citas.idCitas', 'desc')
            ->get();

        $clientes = Cliente::all();
        $trabajos = Trabajos::all();
        $operarios = Operarios::all();
        $ciudades = Ciudad::all();
        $tiposClientes = TipoCliente::all();
        $bancos = Banco::all();
        $users = User::all();

        foreach ($citas as $cita) {
            $cita->archivos = citas_archivos::JOIN('archivos', 'citas_archivos.archivo_id', '=', 'archivos.idarchivos')
                ->where('citas_archivos.cita_id', $cita->idCitas)
                ->select('archivos.*')
                ->get();
        }

        // renombrar las columnas de la tabla
        foreach ($citas as $cita) {

            $nombreCompleto = Cliente::find($cita->cliente_id)->NombreCliente." ".Cliente::find($cita->cliente_id)->ApellidoCliente;
            $cliente = Cliente::find($cita->cliente_id);

            $cita->ID           = $cita->idCitas;
            $cita->Orden        = $cita->ordenes[0]->idOrdenTrabajo ?? null;
            $cita->FechaAlta    = $cita->fechaDeAlta;
            $cita->Cliente      = $nombreCompleto;
            $cita->Encargado    = $cita->name;
            $cita->Estado       = $cita->estado;
            $cita->Canal        = $cita->tipoCita;
            $cita->Asunto       = $cita->asunto;
            $cita->ciudad       = Ciudad::find($cliente->ciudad_id);
            $cita->tipoCliente  = TipoCliente::find($cliente->tipoCliente_id);
            $cita->banco        = Banco::find($cliente->banco_id);
            $cita->usuario      = User::find($cita->user_id);
            $cita->cliente      = $cita->cliente;

        }

        // dd($citas);
                
        return view('admin.citas.index', compact('citas', 'clientes', 'trabajos', 'operarios', 'ciudades', 'tiposClientes', 'bancos', 'users'));
    }

    public function store( Request $request ){
        try {

            $request->validate([
                'fechaCita'              => 'required',
                'asunto'                 => 'required',
                'tipoCita'               => 'required',
                'user_id'                => 'required',
                'estado'                 => 'required',
            ]);

            DB::beginTransaction();
            $cita = Cita::create([
                'fechaDeAlta'   => Carbon::parse($request->fechaCita)->format('Y-m-d'),
                'asunto'        => $request->asunto,
                'tipoCita'      => $request->tipoCita,
                'user_id'       => $request->user_id,
                'estado'        => $request->estado,
                'enlaceDoc'     => $request->enlaceDoc,
                'cliente_id'    => $request->cliente_id
            ]);

            // almacenar archivos en el servidor, con un nombre,id quitar espacios al nombre del archivo
            // pueden ser varios archivos, se debe validar si es un array o un solo archivo
            // validar si ya existe la carpeta, si no existe crearla

            // puede que no se suban archivos
            
            if(!$request->inputparasubirarchivos){
                DB::commit();
                return redirect()->route('admin.citas.index')->with('success', 'Cita creada correctamente');
            }
            
            $path = public_path()."/archivos/citas/$cita->idCitas";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            if(is_array($request->inputparasubirarchivos)){
                foreach ($request->inputparasubirarchivos as $index => $file) {

                    $key = $index + 1;
                    $comentario = isset($request->comentario[$key]) ? $request->comentario[$key] : null;
                    
                    $name = str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move($path, str_replace(' ', '_', $file->getClientOriginalName()));

                    $path = "archivos/citas/$cita->idCitas";
                    
                    $archivo = Archivos::create([
                        'nameFile' => str_replace(' ', '', $file->getClientOriginalName()),
                        'typeFile' => $file->getClientOriginalExtension(),
                        'pathFile' => $path."/".$name,
                    ]);

                    citas_archivos::create([
                        'archivo_id' => $archivo->idarchivos,
                        'cita_id'    => $cita->idCitas,
                        'comentarioArchivo' => $comentario
                    ]);

                }


            }else{
                $name = str_replace(' ', '', $request->inputparasubirarchivos->getClientOriginalName());
                $request->inputparasubirarchivos->move($path, str_replace(' ', '', $request->inputparasubirarchivos->getClientOriginalName()));
                
                $archivo = Archivos::create([
                    'nameFile' => str_replace(' ', '', $request->inputparasubirarchivos->getClientOriginalName()),
                    'typeFile' => $request->inputparasubirarchivos->getClientOriginalExtension(),
                    'pathFile' => $path."/".$name
                ]);

                citas_archivos::create([
                    'archivo_id' => $archivo->idarchivos,
                    'cita_id'    => $cita->idCitas
                ]);

            }
      
            DB::commit();
            return redirect()->route('admin.citas.index')->with('success', 'Cita creada correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.citas.index')->with('error', 'Error al crear la cita');
        }
    }

    public function update( Request $request, $id ){
        try {
            $request->validate([
                'fechaCita'              => 'required',
                'asunto'                 => 'required',
                'tipoCita'               => 'required',
                'user_id'                => 'required',
            ]);

            DB::beginTransaction();
            $cita = Cita::find($id);
            $cita->fechaDeAlta  = Carbon::parse($request->fechaCita)->format('Y-m-d');
            $cita->asunto       = $request->asunto;
            $cita->tipoCita     = $request->tipoCita;
            $cita->user_id      = $request->user_id;
            $cita->estado       = $request->estado ?? $cita->estado;
            $cita->enlaceDoc    = $request->enlaceDoc;
            $cita->cliente_id   = $request->cliente_id;

            $cita->save();

            // Verificar si la cita ya tiene una orden de trabajo asociada
            $orden = OrdenesTrabajo::where('cita_id', $cita->idCitas)->first();

            if ( $orden ) {
                $orden->cliente_id  = $request->cliente_id;
                $orden->save();

                // verificar si la orden tiene un parte de trabajo
                $parteTrabajo = PartesTrabajo::where('orden_id', $orden->idOrdenTrabajo)->first();

                if ( $parteTrabajo ) {
                    $parteTrabajo->cliente_id = $request->cliente_id;
                    $parteTrabajo->save();
                }

                // verificar si el parte de trabajo pertenece a un proyecto y actualizar todos los partes de trabajo asociados al proyecto
                

            }

            // almacenar archivos en el servidor, con un nombre,id quitar espacios al nombre del archivo
            // pueden ser varios archivos, se debe validar si es un array o un solo archivo
            // validar si ya existe la carpeta, si no existe crearla

            if( $request->inputparasubirarchivos ){

                $path = public_path()."/archivos/citas/$cita->idCitas";

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
    
                if( is_array( $request->inputparasubirarchivos )){
                    foreach ($request->inputparasubirarchivos as $file) {
                        
                        $name = str_replace(' ', '_', $file->getClientOriginalName());
                        $file->move($path, str_replace(' ', '_', $file->getClientOriginalName()));

                        $path = "archivos/citas/$cita->idCitas";
                        
                        $archivo = Archivos::create([
                            'nameFile' => str_replace(' ', '', $file->getClientOriginalName()),
                            'typeFile' => $file->getClientOriginalExtension(),
                            'pathFile' => $path."/".$name,
                        ]);
    
                        citas_archivos::create([
                            'archivo_id' => $archivo->idarchivos,
                            'cita_id'    => $cita->idCitas
                        ]);
    
                    }
                
                }else{
                    $name = str_replace(' ', '', $request->inputparasubirarchivos->getClientOriginalName());
                    $request->inputparasubirarchivos->move($path, str_replace(' ', '', $request->inputparasubirarchivos->getClientOriginalName()));

                    $path = "/archivos/citas/$cita->idCita";
                    
                    $archivo = Archivos::create([
                        'nameFile' => str_replace(' ', '', $request->inputparasubirarchivos->getClientOriginalName()),
                        'typeFile' => $request->inputparasubirarchivos->getClientOriginalExtension(),
                        'pathFile' => $path."/".$name
                    ]);
    
                    citas_archivos::create([
                        'archivo_id' => $archivo->idarchivos,
                        'cita_id'    => $cita->idCitas
                    ]);
    
                }
            }
            
            DB::commit();
            return redirect()->route('admin.citas.index')->with('success', 'Cita actualizada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.citas.index')->with("error", "Error al actualizar la cita, {$e->getMessage()}");
        }
    }

    public function download($id){
        try{
            // Buscar el archivo relacionado con la cita
            $archivo = Archivos::JOIN('citas_archivos', 'archivos.idarchivos', '=', 'citas_archivos.archivo_id')
            ->where('citas_archivos.archivo_id', $id)
            ->select('archivos.*')
            ->first();

            // Verificar si el archivo existe en la base de datos
            if (!$archivo) {
                return redirect()->back()->with('error', 'Archivo no encontrado.');
            }

            // Construir la ruta completa del archivo
            $filePath = asset($archivo->pathFile);

            // Verificar si el archivo existe en el sistema de archivos
            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'Archivo no encontrado en el sistema.');
            }
            
            // Devolver el archivo para descarga
            return response()->download($filePath, $archivo->nameFile, [
                'Content-Type' => mime_content_type($filePath)
            ]);

        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Error al descargar el archivo.');
        }
    }

    public function showApi($id){

        try {
            $cita = Cita::find($id);
            $cita->cliente = Cliente::find($cita->cliente_id);
            $cita->usuario = User::find($cita->user_id);
            $cita->archivos = citas_archivos::JOIN('archivos', 'citas_archivos.archivo_id', '=', 'archivos.idarchivos')
                ->where('citas_archivos.cita_id', $cita->idCitas)
                ->select('archivos.*', 'citas_archivos.comentarioArchivo')
                ->get();

            return response()->json([
                'cita' => $cita,
                'userCita' => $cita->user,
                'archivos' => $cita->archivos,
                'orden' => $cita->ordenes[0] ?? null,
                'success' => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

}
