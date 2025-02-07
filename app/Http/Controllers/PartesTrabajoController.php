<?php

namespace App\Http\Controllers;

use App\Exports\ParteTrabajoExport;
use App\Exports\TechniciansReportExport;
use App\Http\Controllers\Controller;
use App\Models\Archivos;
use App\Models\Articulos;
use App\Models\ArticulosStock;
use App\Models\Cita;
use App\Models\citas_archivos;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\LineasVentas;
use App\Models\Operarios;
use App\Models\OrdenesTrabajo;
use App\Models\ordentrabajo_operarios;
use App\Models\PartesTrabajo;
use App\Models\partesTrabajoArchivos;
use App\Models\PartesTrabajoLineas;
use App\Models\Project;
use App\Models\Project_orden;
use App\Models\Proveedor;
use App\Models\ProyectosPartes;
use App\Models\Trabajos;
use App\Models\trabajos_archivos;
use App\Models\User;
use App\Models\Ventas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

use claviska\SimpleImage;

class PartesTrabajoController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $partes_trabajo = PartesTrabajo::
        with(
            'cliente',
            'trabajo',
            'orden.operarios',
            'orden.operarios.user',
            'archivos',
            'orden',
            'proyectoNMN.proyecto',
            'archivos.archivo',
            'cliente.tipoCliente',
            'partesTrabajoLineas',
            'partesTrabajoLineas.user',
            'partesTrabajoLineas.articulo',
        )
        ->orderBy('idParteTrabajo', 'desc')->get();
        $projects = Project::where('status', 1)->get();
        $clientes = Cliente::all();
        $trabajos = Trabajos::all();

        $articulos = Articulos::whereHas('stock', function($query){
            $query->where('cantidad', '>', 0);
        })
        ->WHERE('TrazabilidadArticulos', '!=', 'Proviene_Presupuesto_No_Facturado')
        ->WHERE('categoria_id', '!=', 9)
        ->get();

        $articulosTodos = Articulos::all();

        $operarios = Operarios::all();
        $citas     = Cita::all();
        
        // obtener los usuarios que tengan el rol de tecnico
        $users = User::whereHas('roles', function($query){
            $query->where('name', 'tecnico')->orWhere('name', 'admin');
        })->get();

        $isAdmin = Auth::user()->id;
        $isAdmin = User::find($isAdmin)->isAdmin();

        // dd($partes_trabajo[10]);
        
        return view('admin.partes_trabajo.index', compact('partes_trabajo', 'projects', 'clientes', 'trabajos', 'articulos', 'operarios', 'citas', 'users', 'isAdmin', 'articulosTodos'));
    }


    public function store(Request $request){
        try {
            
            $request->validate([
                'asunto'        => 'required',
                'fecha_alta'    => 'required',
                'fecha_visita'  => 'required',
                'estado'        => 'required',
                'cliente_id'    => 'required',
                'departamento'  => 'required',
                'trabajo_id'    => 'required',
                'suma'          => 'required',
            ]);
            
            DB::beginTransaction();

            // obtener el valor del cliente firmante
            $nombre_firmante = $request->nombre_firmante;

            // Imagen de la firma digital
            $firma = $request->signature;

            
            $desplazamiento = ( $request->desplazamiento ) ? $request->desplazamiento : 0;
            $precio_hora = ( $request->precio_hora ) ? $request->precio_hora : 0;

            $sumaParcial = $request->suma + $desplazamiento + $precio_hora;

            $partes_trabajo = PartesTrabajo::create([
                'idParteTrabajo'    => intval($request->orden_id),
                'Asunto'            => $request->asunto,
                'FechaAlta'         => $request->fecha_alta,
                'FechaVisita'       => $request->fecha_visita,
                'Estado'            => $request->estado,
                'cliente_id'        => $request->cliente_id,
                'Departamento'      => $request->departamento,
                'Observaciones'     => $request->observaciones,
                'descuentoParte'    => $request->descuento,
                'suma'              => $sumaParcial,
                'trabajo_id'        => $request->trabajo_id,
                'orden_id'          => ( $request->orden_id ) ? $request->orden_id : null,
                'estadoVenta'       => 1,
                'solucion'          => $request->solucion,
                'hora_inicio'       => $request->hora_inicio,
                'hora_fin'          => $request->hora_fin,
                'horas_trabajadas'  => $request->horas_trabajadas,
                'precio_hora'       => $precio_hora,
                'desplazamiento'    => $desplazamiento,
                'nombre_firmante'   => $nombre_firmante,
            ]);

            if( $request->cita ){
                //almacenar los trabajos
                ProyectosPartes::create([
                    'proyecto_id' => $request->cita,
                    'parteTrabajo_id' => $partes_trabajo->idParteTrabajo
                ]);
            }

            if ( $nombre_firmante && $firma ) {
                // Eliminar la cabecera 'data:image/png;base64,' de la cadena de la firma para obtener solo la imagen
                $firma = str_replace('data:image/png;base64,', '', $firma);
                $firma = str_replace(' ', '+', $firma);
    
                // Decodificar la imagen
                $firma = base64_decode($firma);

                // Crear el nombre de la imagen
                $nombre_firmante_img = 'firma_' . time() . '.png';

                // Guardar la imagen en la carpeta publica en la ruta
                $nombreFolder = formatFolderName($partes_trabajo->idParteTrabajo);
                $path = public_path('/archivos/partes_trabajo/' . $nombreFolder . '/' . $nombre_firmante_img);

                // Crear la carpeta si no existe
                if (!file_exists(public_path('/archivos/partes_trabajo/' . $nombreFolder))) {
                    mkdir(public_path('/archivos/partes_trabajo/' . $nombreFolder), 0777, true);
                }

                // Guardar la imagen en el servidor
                file_put_contents($path, $firma);

                // Guardar la imagen en la base de datos
                $archivo = Archivos::create([
                    'nameFile' => $nombre_firmante_img,
                    'typeFile' => 'png',
                    'pathFile' => $path,
                ]);

                // Guardar la relación entre el parte de trabajo y la firma
                partesTrabajoArchivos::create([
                    'parteTrabajo_id' => $partes_trabajo->idParteTrabajo,
                    'archivo_id' => $archivo->idarchivos,
                    'comentarioArchivo' => 'firma_digital_bd',
                ]);

            }

            if ( $request->orden_id ) {
                
                // obtener los archivos de la orden
                $orden = OrdenesTrabajo::find($request->orden_id);
                
                foreach ($orden->archivos as $file) {

                    $comentario = trabajos_archivos::where('archivo_id', $file->idarchivos)->first();
    
                    partesTrabajoArchivos::create([
                        'parteTrabajo_id'   => $partes_trabajo->idParteTrabajo,
                        'archivo_id'        => $file->idarchivos,
                        'comentarioArchivo' => ( $comentario ) ? $comentario->comentarioArchivo : 'Sin Comentario',
                    ]);
                }

                if ( $request->hasFile('file') ) {
                    // Manejar la carga de archivos
                    $images = [];
    
                    $files = $request->file('file'); // Utilizar el método file para obtener los archivos
    
                    if ($files && is_array($files) && count($files) > 0) {
                        $nombreFolder = formatFolderName($partes_trabajo->idParteTrabajo);
                    
                        $path = public_path('/archivos/partes_trabajo/' . $nombreFolder);
                    
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }

                        $imagesController = new ImagesController();
                    
                        foreach ($files as $key => $file) {
                            $name = str_replace(' ', '_', $file->getClientOriginalName());
                    
                            // Obtener la extensión del archivo
                            $extension = strtolower($file->getClientOriginalExtension());
                    
                            // Validar y convertir si es necesario
                            $validExtensions = [
                                'jpg',
                                'jpeg',
                                'png',
                                'webp',
                                'mov',
                                'mp4',
                                'avi',
                                'wav',
                                'mp3',
                                'pdf',
                                'doc',
                                'docx',
                                'xls',
                                'xlsx',
                                'ppt',
                                'pptx',
                                'txt',
                                'MOV',
                                'MP4',
                                'AVI',
                                'WAV',
                                'MP3',
                                'PDF',
                                'DOC',
                                'DOCX',
                                'XLS',
                                'XLSX',
                                'PPT',
                                'PPTX',
                                'TXT'
                            ];
                            if (!in_array($extension, $validExtensions)) {

                                $file->move($path, $name);

                                $imageSavedPath = $path . '/' . $name; 
                                $image = $imagesController->convertHeicToJpg($imageSavedPath, $nombreFolder);

                                $name = $image['nombreArchivo'] . '.' . $image['extension'];
                                $extension = $image['extension'];
                                $path = $image['path'];
                                
                            } else {
                                // Mover el archivo sin conversión
                                $file->move($path, $name);
                            }

                            $path = "archivos/partes_trabajo/".$nombreFolder;

                            // Guardar información en la base de datos
                            $archivo = Archivos::create([
                                'nameFile' => $name,
                                'typeFile' => $extension,
                                'pathFile' => $path . "/" . $name,
                            ]);
                    
                            partesTrabajoArchivos::create([
                                'parteTrabajo_id' => $partes_trabajo->idParteTrabajo,
                                'archivo_id' => $archivo->idarchivos,
                                'comentarioArchivo' => $request->comentario[$key + 1] ?? 'Sin comentario'
                            ]);

                            $images[] = public_path($path . "/" . $name);
                        }
                    }
                }

            }

            $articulos = Articulos::whereHas('stock', function($query){
                $query->where('cantidad', '>', 0);
            })
            ->WHERE('TrazabilidadArticulos', '!=', 'Proviene_Presupuesto_No_Facturado')
            ->WHERE('categoria_id', '!=', 9)
            ->get();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Parte de trabajo creado correctamente',
                'partes_trabajo' => $partes_trabajo,
                'parteTrabajoId' => $partes_trabajo->idParteTrabajo,
                'articulos' => $articulos,
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage(), $th->getLine(), $th->getFile());
            throw $th->getMessage();
        }
    }

    public static function UpdateIvaDescuentoParte($parte, $suma = 0){
        try {
            DB::beginTransaction();

            $parte = PartesTrabajo::FindOrFail($parte);

            if($suma > 0){
                $parte->suma = $suma;
            }

            $manoObra = 0;
            $materiales = 0;

            foreach ($parte->partesTrabajoLineas as $linea) {
                $articulo = Articulos::find($linea->articulo_id);

                if ($articulo->categoria_id == 10) { // Categoría de mano de obra
                    // Descuento del 100% no se considera como mano de obra
                    if ($linea->descuento == 100) {
                        $materiales++;
                        continue;
                    }

                    // Calcular el valor ajustado de la mano de obra después del descuento
                    $valorManoObra = floatval($linea->cantidad) * (1 - ($linea->descuento / 100));
                    
                    // Si el valor ajustado es mayor a 0, sumarlo a mano de obra
                    if ($valorManoObra > 0) {
                        $manoObra += $valorManoObra;
                    }
                } else { // Categoría de materiales
                    $materiales += floatval($linea->cantidad);
                }
            }

            // Calcular el IVA en función de la proporción de mano de obra y materiales
            $iva = 21; // IVA por defecto
            $total = $manoObra + $materiales;

            if ($total > 0) {
                $porcentajeManoObra = ($manoObra * 100) / $total;
                $porcentajeMateriales = ($materiales * 100) / $total;

                // Si la proporción de mano de obra es mayor, aplicar 10% de IVA
                if ($manoObra > $materiales) {
                    $iva = 10;
                }
            }

            $diferencia = [
                'manoObra'   => round($porcentajeManoObra ?? 0, 2),
                'materiales' => round($porcentajeMateriales ?? 0, 2)
            ];

            // calcular el precioVenta segun el descuento y el iva
            $precioVenta = $parte->suma;
            $descuento = 0;

            $descuento = $precioVenta * ($parte->descuentoParte / 100); 
            $precioVenta = $precioVenta - $descuento;

            // calcular el iva
            $precioIva = $precioVenta * ($iva / 100);
            
            $precioVenta = $precioVenta + $precioIva;

            $parte->update([
                'descuentoParte' => $parte->descuentoParte,
                'ivaParte' => $iva,
                'totalParte' => $precioVenta,
            ]);

            $parte->save();

            DB::commit();

            return [
                'success' => true,
                'message' => 'Iva y descuento actualizado correctamente',
                'importe' => $parte->suma,
                'iva' => $iva,
                'descuento' => $descuento,
                'precioVenta' => $precioVenta,
                'diferencia' => $diferencia,
                'status' => 200
            ];

        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
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
            DB::beginTransaction();
            $partes_trabajo = PartesTrabajo::find($request->parteTrabajo_id);
            $articulo = Articulos::find($request->articulo_id);

            $stock = ArticulosStock::where('articulo_id', $articulo->idArticulo)->first();
  
            if ($stock->cantidad < $request->cantidad) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'No hay suficiente stock para el articulo seleccionado',
                    'status' => 400
                ]);
            }

            $stock->cantidad = $stock->cantidad - $request->cantidad;
            $stock->save();

            $material = PartesTrabajoLineas::create([
                'parteTrabajo_id' => $request->parteTrabajo_id,
                'articulo_id'     => $request->articulo_id,
                'cantidad'        => $request->cantidad,
                'precioSinIva'    => $request->precioSinIva,
                'total'           => $request->total,
                'descuento'       => $request->descuento,
                'Trazabilidad'    => $articulo->TrazabilidadArticulos,
                'user_create'     => Auth::user()->id,
            ]);

            $material["articulo"] = $articulo;
            $stock["articulo"] = $articulo;

            DB::commit();

            $this->UpdateIvaDescuentoParte($request->parteTrabajo_id);

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

    public function updateSum(Request $request){
        try {
            DB::beginTransaction();
            $partes_trabajo = PartesTrabajo::find($request->parteTrabajoId);
            $partes_trabajo->suma = $request->suma;
            $partes_trabajo->save();
            DB::commit();

            $this->UpdateIvaDescuentoParte($request->parteTrabajoId);

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

    public function edit($id)
    {
        $parte_trabajo = PartesTrabajo::find($id);

        $parte_trabajo["partes_trabajo_lineas"]     = PartesTrabajoLineas::where('parteTrabajo_id', $id)->orderBy('order')->get();
        $parte_trabajo["operarios"]                 = ordentrabajo_operarios::where('orden_id', $parte_trabajo->idParteTrabajo)->with('operarios', 'operarios.salario')->get();

        $parte_trabajo["partes_trabajo_archivos"]   = partesTrabajoArchivos::where('parteTrabajo_id', $id)
        ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', 'archivos.idarchivos')
        ->select('archivos.*', 'partestrabajo_sl_has_archivos.comentarioArchivo')
        ->get();

        $parte_trabajo["cliente"]                   = Cliente::find($parte_trabajo->cliente_id)->with('tipoCliente')->first();
        $cita = ProyectosPartes::where('parteTrabajo_id', $id)->first();

        if ($cita) {
            $parte_trabajo["cita"]                  = Project::find($cita->proyecto_id);
        }
        
        $trabajos                   = Trabajos::find($parte_trabajo->trabajo_id);
        $parte_trabajo["trabajo"]   = $trabajos;
        $parte_trabajo["proyecto"]  = ProyectosPartes::where('parteTrabajo_id', $id)->with('proyecto')->first();

        foreach ($parte_trabajo["partes_trabajo_lineas"] as $linea) {
            $linea["articulo"] = Articulos::find($linea->articulo_id);
        }
        
        return response()->json([
            'success' => true,
            'parte_trabajo' => $parte_trabajo
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'asunto' => 'required',
                'fecha_alta' => 'required',
                'fecha_visita' => 'required',
                'estado' => 'required',
                'cliente_id' => 'required',
                'departamento' => 'required',
                'trabajo_id' => 'required',
                'suma' => 'required',
            ]);

            DB::beginTransaction();
            $partes_trabajo = PartesTrabajo::find($id);
            $partes_trabajo->update([
                'Asunto' => $request->asunto,
                'FechaAlta' => $request->fecha_alta,
                'FechaVisita' => $request->fecha_visita,
                'Estado' => $request->estado,
                'cliente_id' => $request->cliente_id,
                'Departamento' => $request->departamento,
                'Observaciones' => $request->observaciones,
                'descuentoParte' => $request->descuento,
                'suma' => $request->suma,
                'trabajo_id' => $request->trabajo_id,
                'estadoVenta' => 1,
                'solucion' => $request->solucion,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'horas_trabajadas' => $request->horas_trabajadas,
                'precio_hora' => $request->precio_hora,
                'desplazamiento' => $request->desplazamiento,
            ]);

            if ($request->estado == 3) { // Si el estado es finalizado
                $zipController = new ZipController();
                $zipController->createZipWhenOrderStatusFinished($partes_trabajo->idParteTrabajo);
            }

            // Actualizar el estado y cliente, la hora de inicio y fin de la orden de trabajo y de la cita solo el estado y cliente
            $orden = OrdenesTrabajo::find($partes_trabajo->idParteTrabajo);

            if ($orden) {
                $estadoActualizar = ($request->estado == 1) ? 'Pendiente' : (($request->estado == 2) ? 'En proceso' : 'Finalizado');

                $orden->update([
                    'FechaVisita' => $request->fecha_visita,
                    'Estado' => $estadoActualizar,
                    'cliente_id' => $request->cliente_id,
                    'Observaciones' => $request->observaciones,
                    'hora_inicio' => $request->hora_inicio,
                    'hora_fin' => $request->hora_fin,
                ]);

                
                // actualizar cita
                $cita = Cita::find($orden->cita_id);

                if ($cita) {
                    $cita->update([
                        'estado' => $estadoActualizar,
                        'cliente_id' => $request->cliente_id,
                    ]);
                }

                // verificar si el parte pertenece a un proyecto
                $proyectos = ProyectosPartes::where('parteTrabajo_id', $partes_trabajo->idParteTrabajo)->first();

                if ($proyectos) {
                    $partes_proyectos = ProyectosPartes::where('proyecto_id', $proyectos->proyecto_id)->get();
                    $ordenes_Proyectos = Project_orden::where('proyecto_id', $proyectos->proyecto_id)->get();
                    foreach ($partes_proyectos as $proyecto) {
                        $parte = PartesTrabajo::find($proyecto->parteTrabajo_id);
                        $parte->update([
                            'cliente_id' => $request->cliente_id,
                        ]);
                    }
                    foreach ($ordenes_Proyectos as $orden) {
                        $orden = OrdenesTrabajo::find($orden->orden_id);
                        $orden->update([
                            'cliente_id' => $request->cliente_id,
                        ]);
                    }
                }

            }

            // Subir las imagenes al servidor y guardar en la base de datos
            if ($request->hasFile('file')) {
                // Manejar la carga de archivos
                $images = [];

                $files = $request->file('file'); // Utilizar el método file para obtener los archivos

                if ($files && is_array($files) && count($files) > 0) {
                    $nombreFolder = formatFolderName($partes_trabajo->idParteTrabajo);
                
                    $path = public_path('/archivos/partes_trabajo/' . $nombreFolder);
                
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                
                    if ($files && is_array($files) && count($files) > 0) {
                        $nombreFolder = formatFolderName($partes_trabajo->idParteTrabajo);
                    
                        $path = public_path('/archivos/partes_trabajo/' . $nombreFolder);
                    
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }

                        $imagesController = new ImagesController();
                    
                        foreach ($files as $key => $file) {
                            $name = str_replace(' ', '_', $file->getClientOriginalName());
                    
                            // Obtener la extensión del archivo
                            $extension = strtolower($file->getClientOriginalExtension());
                    
                            // Validar y convertir si es necesario
                            $validExtensions = [
                                'jpg',
                                'jpeg',
                                'png',
                                'webp',
                                'mov',
                                'mp4',
                                'avi',
                                'wav',
                                'mp3',
                                'pdf',
                                'doc',
                                'docx',
                                'xls',
                                'xlsx',
                                'ppt',
                                'pptx',
                                'txt',
                                'MOV',
                                'MP4',
                                'AVI',
                                'WAV',
                                'MP3',
                                'PDF',
                                'DOC',
                                'DOCX',
                                'XLS',
                                'XLSX',
                                'PPT',
                                'PPTX',
                                'TXT'
                            ];
                            if (!in_array($extension, $validExtensions)) {

                                $file->move($path, $name);

                                $imageSavedPath = $path . '/' . $name; 
                                $image = $imagesController->convertHeicToJpg($imageSavedPath, $nombreFolder);

                                $name = $image['nombreArchivo'] . '.' . $image['extension'];
                                $extension = $image['extension'];
                                $path = $image['path'];
                                
                            } else {
                                // Mover el archivo sin conversión
                                $file->move($path, $name);
                            }

                            $path = "archivos/partes_trabajo/".$nombreFolder;

                            // Guardar información en la base de datos
                            $archivo = Archivos::create([
                                'nameFile' => $name,
                                'typeFile' => $extension,
                                'pathFile' => $path . "/" . $name,
                            ]);
                    
                            partesTrabajoArchivos::create([
                                'parteTrabajo_id' => $partes_trabajo->idParteTrabajo,
                                'archivo_id' => $archivo->idarchivos,
                                'comentarioArchivo' => $request->comentario[$key + 1] ?? 'Sin comentario'
                            ]);

                            $images[] = public_path($path . "/" . $name);
                        }
                    }
                }
            }

            // Subir la firma al servidor y guardar en la base de datos
            if ($request->signature) {
                // Eliminar la cabecera 'data:image/png;base64,' de la cadena de la firma para obtener solo la imagen
                $firma = str_replace('data:image/png;base64,', '', $request->signature);
                $firma = str_replace(' ', '+', $firma);

                // Decodificar la imagen
                $firma = base64_decode($firma);

                // Crear el nombre de la imagen
                $nombre_firmante_img = 'firma_' . time() . '.png';

                // Guardar la imagen en la carpeta publica en la ruta
                $nombreFolder = formatFolderName($partes_trabajo->idParteTrabajo);
                $path = public_path('/archivos/partes_trabajo/' . $nombreFolder . '/' . $nombre_firmante_img);

                // Crear la carpeta si no existe
                if (!file_exists(public_path('/archivos/partes_trabajo/' . $nombreFolder))) {
                    mkdir(public_path('/archivos/partes_trabajo/' . $nombreFolder), 0777, true);
                }

                // Guardar la imagen en el servidor
                file_put_contents($path, $firma);

                $path = "archivos/partes_trabajo/".$nombreFolder."/".$nombre_firmante_img;

                // Guardar la imagen en la base de datos
                $archivo = Archivos::create([
                    'nameFile' => $nombre_firmante_img,
                    'typeFile' => 'png',
                    'pathFile' => $path,
                ]);

                // Guardar la relación entre el parte de trabajo y la firma
                partesTrabajoArchivos::create([
                    'parteTrabajo_id' => $partes_trabajo->idParteTrabajo,
                    'archivo_id' => $archivo->idarchivos,
                    'comentarioArchivo' => 'firma_digital_bd',
                ]);
            }

            // Agregar firmante al parte de trabajo
            if ($request->name) {
                $partes_trabajo->update([
                    'nombre_firmante' => $request->name,
                ]);
            }


            DB::commit();
            
            $this->UpdateIvaDescuentoParte($id);

            return response()->json([
                'success' => true,
                'message' => 'Parte de trabajo actualizado correctamente',
                'parte_trabajo' => $partes_trabajo,
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            $message = $th->getMessage()." ".$th->getLine()." ".$th->getFile();
            throw new \Exception($message);
        }
    }

    public function updateLineas(Request $request, $id){
        try {

            DB::beginTransaction();
            $partes_trabajo = PartesTrabajo::find($request->parteTrabajo_id);
            $articulo = Articulos::find($request->articulo_id);

       
            // regresar el stock al articulo
            $linea = PartesTrabajoLineas::find($id);
            $stock = ArticulosStock::where('articulo_id', $linea->articulo_id)->first();
            $stock->cantidad = $stock->cantidad + $linea->cantidad;
            $stock->save();

            // descontar el stock del articulo
            $stock = ArticulosStock::where('articulo_id', $articulo->idArticulo)->first();
  
            if ($stock->cantidad < $request->cantidad) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'No hay suficiente stock para el articulo seleccionado',
                    'status' => 400
                ]);
            }

            $stock->cantidad = $stock->cantidad - $request->cantidad;
            $stock->save();


            $linea->parteTrabajo_id = $request->parteTrabajo_id;
            $linea->articulo_id = $request->articulo_id;
            $linea->cantidad = $request->cantidad;
            $linea->precioSinIva = $request->precioSinIva;
            $linea->total = $request->total;
            $linea->descuento = $request->descuento;
            $linea->Trazabilidad = $articulo->TrazabilidadArticulos;

            $linea->save();

            DB::commit();

            $linea->articulo["stock"] = $stock;
            $stock["articulo"] = $articulo;

            $this->UpdateIvaDescuentoParte($request->parteTrabajo_id);

            return response()->json([
                'success' => true,
                'message' => 'Linea de trabajo creada correctamente',
                'partes_trabajo' => $partes_trabajo,
                'linea' => $linea,
                'articuloInfo' => $linea->articulo->with('stock')->first(),
                'status' => 200,
                'stock' => $stock
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function destroyLineas( Request $request ){
        try {
            DB::beginTransaction();
            $articulo   = Articulos::FindOrFail($request->articulo_id);
            $stock      = ArticulosStock::where('articulo_id', $articulo->idArticulo)->first();
            $cantidad   = $request->cantidad;

            $stock->cantidad = $stock->cantidad + $cantidad;
            $stock->save();

            // buscar el parte de acuerdo a la linea
            $linea = PartesTrabajoLineas::find($request->lineaId);
            $parte = PartesTrabajo::find($linea->parteTrabajo_id);

            PartesTrabajoLineas::destroy($request->lineaId);

            DB::commit();

            $this->UpdateIvaDescuentoParte($parte->idParteTrabajo);

            return response()->json([
                'success' => true,
                'message' => 'Linea de trabajo eliminada correctamente, se ha devuelto el stock al articulo',
                'status' => 200
            ]);

        } catch (\Exception $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'status' => 400,
                'lineaId' => $request->lineaId,
                'parteTrabajo_id' => $request->parteTrabajo_id,
                'trace' => $th->getTrace(),
                'file' => $th->getFile(),
            ]);
        }
    }

    public static function verifyOrientationImage($imagePath) {

        // verificar si la imagen existe
        if (!file_exists($imagePath)) {
            return $imagePath;
        }

        // Verificar la extensión del archivo
        $imageInfo = getimagesize($imagePath);
        if ($imageInfo === false) {
            return $imagePath;
        }
    
        // Obtener el tipo de imagen
        $mimeType = $imageInfo['mime'];
        
        // Crear la imagen a partir del archivo según el tipo
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($imagePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($imagePath);
                break;
            default:
                throw new Exceptions('Formato de imagen no soportado.');
        }
    
        // Leer datos EXIF y ajustar la orientación
        $exif = @exif_read_data($imagePath);
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($image, -90, 0);
                    break;
                case 8:
                    $image = imagerotate($image, 90, 0);
                    break;
            }
        }
    
        // Guardar la imagen corregida según su tipo
        switch ($mimeType) {
            case 'image/jpeg':
                imagejpeg($image, $imagePath);
                break;
            case 'image/png':
                imagepng($image, $imagePath);
                break;
            case 'image/gif':
                imagegif($image, $imagePath);
                break;
        }
    
        // Liberar memoria
        imagedestroy($image);
    
        return $imagePath; // Retorna la ruta de la imagen corregida
    }

    public function generarPdf($id){
        // Obtener los datos del parte de trabajo
        $parte = PartesTrabajo::with('cliente', 'partesTrabajoLineas')->findOrFail($id);
        $firma = $parte->archivos()
        ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', 'archivos.idarchivos')
        ->where('comentarioArchivo', 'firma_digital_bd')->first();

        // redondear las horas trabajadas si 1.5 hacia arriba 2.5 = 3, 3.5 = 4, 4.3 = 4.5
        $horas_trabajadas = round($parte->horas_trabajadas * 2) / 2;
        
        // obtener el precio de la mano de obra oficial
        $operario = ordentrabajo_operarios::where('orden_id', $parte->orden_id)->with('operarios')->first();

        $totalHorasTrabajadas = $horas_trabajadas * $operario->operarios->salario->salario_hora;

        // Validar si $parte->precio hora es mayor a $totalHorasTrabajadas debemos buscar el numero que multiplicado por $operario->operarios->salario->salario_hora sea igual a $parte->precio_hora
        if ($parte->precio_hora > $totalHorasTrabajadas) {
            $horas_trabajadas = $parte->precio_hora / $operario->operarios->salario->salario_hora;
        }

        // verificar si el $parte->precio_hora puede ser 1.5 cantidad de horas trabajadas
        if ($parte->precio_hora % $operario->operarios->salario->salario_hora == 0) {
            $horas_trabajadas = $parte->precio_hora / $operario->operarios->salario->salario_hora;
        }

        $totalHorasTrabajadas = $horas_trabajadas * $operario->operarios->salario->salario_hora;

        $responsablesString = '';

        $responsables = ordentrabajo_operarios::where('orden_id', $parte->orden_id)->with('operarios')->get();

        foreach ($responsables as $key => $res) {
            // verificar si es la ultima iteracion para no agregar la coma
            if ($key == count($responsables) - 1) {
                $responsablesString .= $res->operarios->nameOperario;
            } else {
                $responsablesString .= $res->operarios->nameOperario.', ';
            }
        }

        // Calcular el porcentaje de descuento en base al precio de la mano de obra oficial
        if ($totalHorasTrabajadas > 0) {
            $descuento = (($totalHorasTrabajadas - $parte->precio_hora) / $totalHorasTrabajadas) * 100;
        } else {
            $descuento = 0;
        }
        
        // Si el precio es igual al total de horas trabajadas, el descuento es 0, si es 0 significa 100% descuento
        if ($parte->precio_hora == 0) {
            $descuento = 100;
        }

        if( $parte->precio_hora > 0 ){
            $data = [
                "nombreArticulo" => "M.Obra oficial mantenimiento.",
                "cantidad" => $horas_trabajadas,
                "precioSinIva" => $operario->operarios->salario->salario_hora,
                "total" => $parte->precio_hora,
                "descuento" => $descuento,
            ];
    
            $dataDesplazamiento = [
                "nombreArticulo" => "Desplazamiento",
                "cantidad" => 1,
                "precioSinIva" => $parte->desplazamiento,
                "total" => $parte->desplazamiento,
                "descuento" => 0,
            ];
    
            $parte["partesTrabajoLineas"][] = $data;
            $parte["partesTrabajoLineas"][] = $dataDesplazamiento;
        }


        $imagenes = partesTrabajoArchivos::where('parteTrabajo_id', $id)
        ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', 'archivos.idarchivos')
        ->where('comentarioArchivo', '!=', 'firma_digital_bd')
        ->WhereNotIn('archivos.typeFile', ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'mp4', 'avi', 'mov', 'mkv', 'flv', 'wmv', 'mpg', 'mpeg', '3gp', 'webm'])
        ->get();

        foreach ($imagenes as $imagen) {

            $img = $imagen->pathFile;

            $nombreArchivo = explode('/', $img);
            $nombreArchivo = end($nombreArchivo);

            $ruta = public_path("/archivos/partes_trabajo/$id/$nombreArchivo");

            $img = self::verifyOrientationImage($ruta);

            $imagen->pathFile = $img;
        }

        // verificar si el parte pertenece a un proyecto
        $proyecto = ProyectosPartes::where('parteTrabajo_id', $id)->first();
        $existeProyecto = false;

        if ( isset($proyecto) && !empty($proyecto) ) {
            $proyecto = Project::findOrFail($proyecto->proyecto_id);
            $parte->project     = $proyecto->name;
            $parte->proyecto_id = $proyecto->idProyecto;
            $existeProyecto = true;
        }

        // para calcular el iva del parte del trabajo necesito obtener de las lineas las categorias manos de obra y contrastarlas con los articulos si son más manos de obra el iva es 10% si son más materiales el iva es 21%
        $manoObra = 0;
        $materiales = 0;

        $lineas = PartesTrabajoLineas::where('parteTrabajo_id', $id)->orderBy('order')->get();

        $elements = $this->UpdateIvaDescuentoParte($id);

        $iva = $elements['iva'];

        // Generar el PDF con la vista 'pdf/parte_trabajo'
        $pdf = Pdf::loadView('pdf.parte_trabajo', [
            'parte' => $parte,
            'firma' => $firma,
            'imagenes' => $imagenes,
            'responsable' => $responsablesString,
            'existeProyecto' => $existeProyecto,
            'iva' => $iva,
            'lineas' => $lineas,
            'descuentoParte' => $parte->descuentoParte,
        ])->setPaper('folio', 'landscape');

        // Habilitar conteo total de páginas
        // Obtener el conteo de páginas inicial
        $dompdf = $pdf->getDomPDF();
        $dompdf->render(); // Renderiza para calcular las páginas
        $totalPages = $dompdf->get_canvas()->get_page_count();

        $pdf = Pdf::loadView('pdf.parte_trabajo', [
            'parte' => $parte,
            'firma' => $firma,
            'imagenes' => $imagenes,
            'responsable' => $responsablesString,
            'existeProyecto' => $existeProyecto,
            'totalPages' => $totalPages,
            'iva' => $iva,
            'lineas' => $lineas,
            'descuentoParte' => $parte->descuentoParte,
        ])->setPaper('folio', 'landscape');

        // Descargar el archivo PDF generado
        return $pdf->download('parte_trabajo_'.$parte->idParteTrabajo.'.pdf');
    }

    public function generateExcel($id){
        try{
            $parte = PartesTrabajo::with('cliente', 'partesTrabajoLineas')->findOrFail($id);

            $folderName = formatFolderName("parte_trabajo_$parte->idParteTrabajo");

            $lineas = PartesTrabajoLineas::where('parteTrabajo_id', $id)->orderBy('order')->get();

            return Excel::download(new ParteTrabajoExport($parte, $lineas, $folderName), 'parte_trabajo_'.$parte->idParteTrabajo.'.xlsx');

        }catch(\Throwable $th){
            throw new \Exception($th->getMessage());
        }
    }

    public function SoloUnCampo(Request $request){
        try {

            $table = $request->name;

            if ($table == 'Modelo347') {
                // Obtener los datos del request
                $payload = $request->payload;
                $year = $payload['year'];
                $trimestre = $payload['trimestre'];
            
                // Concatenar el año y trimestre para formar el identificador único
                $yearTrimestre = $year . $trimestre;  // Ejemplo: '20241' para el primer trimestre de 2024

                // buscar el id de la empresa correspondiente con el nombre
                $empresa = Empresa::where('EMP', $payload['empresa_id'])->first();
            
                // Comenzar la transacción
                DB::beginTransaction();
            
                // Actualizar los registros en la tabla 'Ventas' basados en los filtros
                $ventas = Ventas::where('cliente_id', $payload['cliente_id'])
                    ->where('empresa_id', $empresa->idEmpresa)
                    ->whereRaw("CONCAT(SUBSTRING(ventas_sl.FechaVenta, 1, 4), QUARTER(ventas_sl.FechaVenta)) = ?", [$yearTrimestre])->get();

                foreach ($ventas as $venta) {
                    $venta->agente          = $payload['agente'];
                    $venta->correo          = $payload['correo'];
                    $venta->notasmodelo347  = $payload['notasmodelo347'];
                    $venta->save();
                }

                $data = 'Modelo 347 actualizado correctamente';
        
                // Confirmar la transacción si todo es correcto
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'data' => $data,
                    'status' => 200,
                    'updatedValue' => $request->value,
                ]);
               
            }

            DB::beginTransaction();

            $model = "App\Models\\$table";
            
            // inicializar el modelo
            $model = new $model;
            $data = $model->find($request->id);

            if ($data) {

                if ($request->fieldName == 'proyecto_id') {
                    
                    // buscar el proyecto en la tabla de proyectos por el nombre
                    $proyecto = Project::where('name', $request->value)->first();

                    if (empty($proyecto)) {
                        
                        // verificar si tiene proyecto y eliminarlo
                        $proyecto_orden = Project_orden::where('orden_id', $request->id)->first();

                        if ($proyecto_orden) {
                            $proyecto_orden->delete();
                        }

                        $proyecto_orden = ProyectosPartes::where('parteTrabajo_id', $request->id)->first();

                        if ($proyecto_orden) {
                            $proyecto_orden->delete();
                        }

                        return response()->json([
                            'success' => true,
                            'data' => $data,
                            'status' => 200,
                            'updatedValue' => $request->value,
                        ]);

                    }

                    $item = '';

                    if ($table == 'OrdenesTrabajo') {

                        $proyecto_orden = Project_orden::where([
                            'orden_id' => $request->id,
                            'proyecto_id' => $proyecto->idProyecto
                        ])->first();

                    }else if ($table == 'PartesTrabajo') {
                        $proyecto_orden = ProyectosPartes::where([
                            'parteTrabajo_id' => $request->id,
                            'proyecto_id' => $proyecto->idProyecto
                        ])->first();
                    }

                    // buscar si existe el registro en la tabla intermedia

                    if (!$proyecto_orden) {

              
                        $item = Project_orden::create([
                            'orden_id' => $request->id,
                            'proyecto_id' => $proyecto->idProyecto
                        ]);
                    
                        $item = ProyectosPartes::create([
                            'parteTrabajo_id' => $request->id,
                            'proyecto_id' => $proyecto->idProyecto
                        ]);
                        
                        DB::commit();

                        return response()->json([
                            'success' => true,
                            'data' => $item,
                            'status' => 200,
                            'updatedValue' => $request->value,
                        ]);
                    }

                    
                    $proyecto_orden->update([
                        'proyecto_id' => $proyecto->idProyecto
                    ]);

                    // actualizar el proyecto en la tabla de partes_trabajo
                    $partes = ProyectosPartes::where('parteTrabajo_id', $request->id)->first();

                    if ($partes) {
                        $partes->update([
                            'proyecto_id' => $proyecto->idProyecto
                        ]);
                    }

                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'data' => $item,
                        'status' => 200,
                        'updatedValue' => $request->value,
                    ]);

                }

                // verificar si estoy actualizando cliente_id ya que estoy enviando el label cliente_id pero en la tabla es cliente
                if ($request->fieldName == 'cliente_id') {
                    // Intentar encontrar al cliente usando el valor completo
                    $cliente = Cliente::whereRaw("CONCAT(NombreCliente, ' ', ApellidoCliente) = ?", [$request->value])->first();

                    if (!$cliente) {
                        // Manejar el caso donde el cliente no existe
                        return response()->json([
                            'success' => false,
                            'message' => 'Cliente no encontrado en la base de datos.'
                        ], 404);
                    }
                
                    // Asignar el ID del cliente encontrado al request
                    $request["value"] = $cliente->idClientes; // Asegúrate de que el campo de ID esté correcto
                }

                // verificar si estoy actualizando el campo proveedor_id ya que estoy enviando el label proveedor_id pero en la tabla es proveedor
                if ($request->fieldName == 'proveedor_id') {
                    // Intentar encontrar al proveedor usando el valor completo
                    $proveedor = Proveedor::WHERE("nombreProveedor", [$request->value])->first();

                    if (!$proveedor) {
                        // Manejar el caso donde el proveedor no existe
                        return response()->json([
                            'success' => false,
                            'message' => 'Proveedor no encontrado en la base de datos.'
                        ], 404);
                    }
                
                    // Asignar el ID del proveedor encontrado al request
                    $request["value"] = $proveedor->idProveedor; // Asegúrate de que el campo de ID esté correcto
                }

                // verificar si estoy actualizando el modelo de PartesTrabajo
                if ($table == 'PartesTrabajo') {
                    // verificar si estoy actualizando el campo trabajo_id ya que estoy enviando el label trabajo_id pero en la tabla es trabajo
                    if ($request->fieldName == 'tituloParte') {
                        
                        // verificar si el parte ya está vendido o está en Ventas_lineas
                        $parte = PartesTrabajo::find($request->id);

                        if ($parte->estadoVenta == 2) {
                            
                            // actualizar el titulo del parte en la tabla de ventas_lineas
                            $venta_linea = LineasVentas::where('parte_trabajo', $parte->idParteTrabajo)->first();

                            if ($venta_linea) {
                                $venta_linea->update([
                                    'Descripcion' => $request->value
                                ]);
                            }

                        }

                        
                    }
                }

                $data->update([
                    $request->fieldName => $request->value
                ]);
            }else{
                throw new \Exception('No se encontró el registro');
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $data,
                'status' => 200,
                'updatedValue' => $request->value,
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function getProjectDetails(Request $request){
        try {

            if ($request->table == 'Project') {
                $proyecto = Project::with(
                    'partes',
                    'ordenes',
                    'ordenes.cliente',
                    'partes.partesTrabajoLineas',
                    'partes.partesTrabajoLineas.articulo',
                    'partes.partesTrabajoLineas.articulo.compras'
                )->findOrFail($request->projectid);

                return response()->json([
                    'success' => true,
                    'proyecto' => $proyecto,
                    'status' => 200
                ]);
            }

            // obtener la orden
            $orden = OrdenesTrabajo::FindOrFail($request->projectid);

            // buscar el proyecto
            $ordenProyecto = Project_orden::where('orden_id', $orden->idOrdenTrabajo)->first();

            $proyecto = Project::with(
                'partes',
                'ordenes',
                'ordenes.cliente',
                'partes.partesTrabajoLineas',
                'partes.partesTrabajoLineas.articulo',
                'partes.partesTrabajoLineas.articulo.compras'
            )->findOrFail($ordenProyecto->proyecto_id);

            return response()->json([
                'success' => true,
                'proyecto' => $proyecto,
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function deletefile(Request $request){
        try {

            $archivo = Archivos::findOrFail($request->archivoId);

            // buscar archivo en la tabla de partes_trabajo_archivos
            $partes_archivos = partesTrabajoArchivos::where('archivo_id', $archivo->idarchivos)->first();
            
            // buscar si el archivo está en la orden
            $orden = trabajos_archivos::where('archivo_id', $archivo->idarchivos)->first();

            // buscar el archivo si está en la cita
            $citas_archivos = citas_archivos::where('archivo_id', $archivo->idarchivos)->first();

            if ($citas_archivos) {
                $citas_archivos->where('archivo_id', $archivo->idarchivos)->delete();
            }

            if ($orden) {
                $orden->where('archivo_id', $archivo->idarchivos)->delete();
            }

            if ($partes_archivos) {
                $partes_archivos->where('archivo_id', $archivo->idarchivos)->delete();
            }

            $archivo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Archivo eliminado correctamente',
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function updatefile(Request $request){
        try {

            $archivo = Archivos::findOrFail($request->archivoId);

            // buscar el archivo en la tabla de partes_trabajo_archivos
            $partes_archivos = partesTrabajoArchivos::where('archivo_id', $archivo->idarchivos)->first();

            // buscar el archivo si está en la orden
            $orden = trabajos_archivos::where('archivo_id', $archivo->idarchivos)->first();

            // buscar el archivo si está en la cita
            $cita  = citas_archivos::where('archivo_id', $archivo->idarchivos)->first();

            if ($orden) {
                $orden->where('archivo_id', $archivo->idarchivos)->update([
                    'comentarioArchivo' => $request->comentario
                ]);
            }

            if ($partes_archivos) {
                $partes_archivos->where('archivo_id', $archivo->idarchivos)->update([
                    'comentarioArchivo' => $request->comentario
                ]);
            }

            if ($cita) {
                $cita->where('archivo_id', $archivo->idarchivos)->update([
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

    public function sendMessageTelegramStore(Request $request){

        try {
            
            $partes_trabajo = PartesTrabajo::findOrFail($request->parteId);

            $chatTelegramId = '-4531180601';

            $estadoParteMsg = ($partes_trabajo->Estado == 1) ? 'Pendiente' : (($partes_trabajo->Estado == 2) ? 'En proceso' : 'Finalizado');
            $nombreCompletoMsg = $partes_trabajo->cliente->NombreCliente . ' ' . $partes_trabajo->cliente->ApellidosCliente;

            $responsablesMsg   = ordentrabajo_operarios::where('orden_id', $partes_trabajo->idParteTrabajo)->with('operarios')->get();
            $operariosMsg = '';

            foreach ($responsablesMsg as $key => $responsable) {

                // verficar si es la ultima iteracion para no agregar la coma
                if ($key == count($responsablesMsg) - 1) {
                    $operariosMsg .= $responsable->operarios->nameOperario;
                } else {
                    $operariosMsg .= $responsable->operarios->nameOperario.', ';
                }

            }

            $imagenes = partesTrabajoArchivos::where('parteTrabajo_id', $partes_trabajo->idParteTrabajo)
            ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', 'archivos.idarchivos')
            ->where('comentarioArchivo', '!=', 'firma_digital_bd')
            ->WhereNotIn('archivos.typeFile', ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'mp4', 'avi', 'mov', 'mkv', 'flv', 'wmv', 'mpg', 'mpeg', '3gp', 'webm'])
            ->get();

            // verficar si tiene firma
            $firma = partesTrabajoArchivos::where('parteTrabajo_id', $partes_trabajo->idParteTrabajo)
            ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', 'archivos.idarchivos')
            ->where('comentarioArchivo', 'firma_digital_bd')
            ->first();

            // verificar si el parte pertenece a un proyecto
            $proyecto = ProyectosPartes::where('parteTrabajo_id', $partes_trabajo->idParteTrabajo)->first();
            $existeProyecto = false;

            if ($proyecto) {
                $proyecto = Project::findOrFail($proyecto->proyecto_id);
                $partes_trabajo->project = $proyecto->name;
                $partes_trabajo->proyecto_id = $proyecto->idProyecto;
                $existeProyecto = true;
            }

            $pdfDirectory = public_path('archivos/partes_trabajo/' . $partes_trabajo->idParteTrabajo);

            // Verificar y crear el directorio si no existe
            if (!file_exists($pdfDirectory)) {
                mkdir($pdfDirectory, 0755, true); // Crea el directorio con permisos adecuados
            }

            $pdfPath = $pdfDirectory . '/parte_trabajo_' . $partes_trabajo->idParteTrabajo . '.pdf';

            // para calcular el iva del parte del trabajo necesito obtener de las lineas las categorias manos de obra y contrastarlas con los articulos si son más manos de obra el iva es 10% si son más materiales el iva es 21%
            $manoObra = 0;
            $materiales = 0;

            foreach ($partes_trabajo->partesTrabajoLineas as $index => $linea) {
                $articulo = Articulos::find($linea->articulo_id);
                if ($articulo->categoria_id == 10) {
                    $manoObra++;
                } else {
                    $materiales++;
                }
            }

            $iva = 0;

            if ($manoObra > $materiales) {
                $iva = 10;
            } else {
                $iva = 21;
            }

            $lineas = PartesTrabajoLineas::where('parteTrabajo_id', $partes_trabajo->idParteTrabajo)->get();

            // Generar el PDF con la vista 'pdf/parte_trabajo'
            $pdf = Pdf::loadView('pdf.parte_trabajo', [
                'parte' => $partes_trabajo,
                'firma' => $firma,
                'imagenes' => $imagenes,
                'responsable' => $operariosMsg,
                'existeProyecto' => $existeProyecto,
                'iva' => $iva,
                'descuentoParte' => $partes_trabajo->descuentoParte,
                'lineas' => $lineas,
            ])->setPaper('folio', 'landscape');

            // Habilitar conteo total de páginas
            // Obtener el conteo de páginas inicial
            $dompdf = $pdf->getDomPDF();
            $dompdf->render(); // Renderiza para calcular las páginas
            $totalPages = $dompdf->get_canvas()->get_page_count();

            $pdf = Pdf::loadView('pdf.parte_trabajo', [
                'parte' => $partes_trabajo,
                'firma' => $firma,
                'imagenes' => $imagenes,
                'responsable' => $operariosMsg,
                'existeProyecto' => $existeProyecto,
                'totalPages' => $totalPages,
                'iva' => $iva,
                'descuentoParte' => $partes_trabajo->descuentoParte,
                'lineas' => $lineas,
            ])->setPaper('folio', 'landscape');


            $pdf->save($pdfPath);

            // formatear valores
            $partes_trabajo->suma = formatPrice(floatval($partes_trabajo->suma));

            $messageNotification = "Nuevo parte de trabajo creado: #" . $partes_trabajo->idParteTrabajo."\n\n";
            $titulo = ($partes_trabajo->tituloParte) ? $partes_trabajo->tituloParte : $partes_trabajo->Asunto;

            $messageNotification .= "Asunto: " . $titulo . "\n";
            $messageNotification .= "Trabajo: " . $partes_trabajo->trabajo->nameTrabajo . "\n";
            $messageNotification .= "Fecha de alta: " . $partes_trabajo->FechaAlta . "\n";
            $messageNotification .= "Fecha de visita: " . $partes_trabajo->FechaVisita . "\n";
            $messageNotification .= "Estado: " . $estadoParteMsg . "\n\n";

            $messageNotification .= "Cliente: " . $nombreCompletoMsg . "\n";
            $messageNotification .= "Departamento: " . $partes_trabajo->Departamento . "\n";
            $messageNotification .= "C.P: " . $partes_trabajo->cliente->CodPostalCliente . "\n";
            $messageNotification .= "Ciudad: " . $partes_trabajo->cliente->ciudad->nameCiudad . "\n";
            
            $messageNotification .= "Responsables: " . $operariosMsg . "\n\n";

            // verificar si el parte de trabajo tiene lineas de material
            $tieneLineas = PartesTrabajoLineas::where('parteTrabajo_id', $partes_trabajo->idParteTrabajo)->get();

            if (count($tieneLineas) > 0) {
        
                $messageNotification .= "-------- LINEAS DE MATERIAL ------- \n";

                foreach ($tieneLineas as $index => $linea) { 
                    $key = $index + 1;
                    // LINEA 1 : ENCARGADO DE LA LINEA
                    $user_create = User::Find($linea->user_create)->name ?? Auth::user()->name;
                    $messageNotification .= "LINEA $key : " . $user_create . "\n";
                }
                
            }

            $media = [];

            $media[] = [
                'path' => $pdfPath,
                'type' => 'document',
                'comment' => $messageNotification
            ];

            $messageNotification = "";

            // esperar 6 segundos para que el archivo se pueda enviar
            sleep(2);

            // Enviar notificación a Telegram
            $telegramController = new NotificationsController();
            $chatIdAutomatico = $telegramController->getCurrentChatIdByConfig('partes');

            $telegramController->sendMessageTelegram($chatIdAutomatico, $messageNotification, $media);

            // esperar 6 segundos para que el archivo se pueda enviar
            sleep(3);

            // Eliminar el archivo PDF
            unlink($pdfPath);

            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente',
                'status' => 200
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'status' => 400
            ], 500);
        }
        
    }

    public function generateReport(Request $request){
        try {

            $request->validate([
                'fechaInicio' => 'required|date',
                'fechaFin' => 'required|date',
                'users_id' => 'required|array',
            ]);
    
            $fechaInicio = $request->fechaInicio;
            $fechaFin = $request->fechaFin;
            $userIds = $request->users_id;
            $fechaYHoraHoy = Carbon::now()->format('Y-m-d H:i:s');

            $nombreFile = 'Informe_Tecnicos_'.$fechaInicio.'_'.$fechaFin.'_Generado_'.$fechaYHoraHoy.'.xlsx';
        
            return Excel::download(
                new TechniciansReportExport($fechaInicio, $fechaFin, $userIds),
                $nombreFile
            );

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function getInforIva(Request $request, $id){
        try{
            
            $suma = $request->suma;
            $elements = $this->UpdateIvaDescuentoParte($id, $suma);
            

            $mensaje = "Calculado Correctamente";

            $mensaje .= "\n\n";

            $mensaje .= "Importe: ".formatPrice($elements['importe']);
            $mensaje .= "\n\n";
            $mensaje .= "Descuento: ".$elements['descuento']."%";
            $mensaje .= "\n\n";
            $mensaje .= "IVA: ".$elements['iva']."%";
            $mensaje .= "\n\n";
            $mensaje .= "Total: ".formatPrice($elements['precioVenta']);

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'totalSuma' => floatval($elements['importe']),
                'iva' => $elements['iva'],
                'descuento' => $elements['descuento'],
                'precioVenta' => floatval($elements['precioVenta']),
                'diferencia' => $elements['diferencia'],
                'status' => 200
            ]);

        }catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function reorderLineas(Request $request){
        try {
            
            $newOrder = $request->newOrder;

            foreach ($newOrder as $index => $linea) {
                PartesTrabajoLineas::where('idMaterial', $linea['idMaterial'])
                    ->update(['order' => $linea['order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Orden actualizado correctamente',
                'status' => 200
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

}
