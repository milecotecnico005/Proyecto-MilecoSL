<?php

namespace App\Http\Controllers;

use App\Exports\ParteTrabajoExport;
use App\Models\Archivos;
use App\Models\Articulos;
use App\Models\ordentrabajo_operarios;
use App\Models\PartesTrabajo;
use App\Models\partesTrabajoArchivos;
use App\Models\PartesTrabajoLineas;
use App\Models\Project;
use App\Models\ProyectosPartes;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ZipController extends Controller
{

    public static function generatePdParte( $id, $path ){
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

        //    // Calcular el porcentaje de descuento en base al precio de la mano de obra oficial
        //    if ($totalHorasTrabajadas > 0) {
        //        $descuento = (($totalHorasTrabajadas - $parte->precio_hora) / $totalHorasTrabajadas) * 100;
        //    } else {
        //        $descuento = 0;
        //    }
        
        //    // Si el precio es igual al total de horas trabajadas, el descuento es 0, si es 0 significa 100% descuento
        //    if ($parte->precio_hora == 0) {
        //        $descuento = 100;
        //    }

        //    if( $parte->precio_hora > 0 ){
        //        $data = [
        //            "nombreArticulo" => "M.Obra oficial mantenimiento.",
        //            "cantidad" => $horas_trabajadas,
        //            "precioSinIva" => $operario->operarios->salario->salario_hora,
        //            "total" => $parte->precio_hora,
        //            "descuento" => $descuento,
        //        ];
    
        //        $dataDesplazamiento = [
        //            "nombreArticulo" => "Desplazamiento",
        //            "cantidad" => 1,
        //            "precioSinIva" => $parte->desplazamiento,
        //            "total" => $parte->desplazamiento,
        //            "descuento" => 0,
        //        ];
    
        //        $parte["partesTrabajoLineas"][] = $data;
        //        $parte["partesTrabajoLineas"][] = $dataDesplazamiento;
        //     }


       $imagenes = partesTrabajoArchivos::where('parteTrabajo_id', $id)
       ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', 'archivos.idarchivos')
       ->where('comentarioArchivo', '!=', 'firma_digital_bd')
       ->WhereNotIn('archivos.typeFile', ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'mp4', 'avi', 'mov', 'mkv', 'flv', 'wmv', 'mpg', 'mpeg', '3gp', 'webm'])
       ->get();

        foreach ($imagenes as $imagen) {

            $img = $imagen->pathFile;

            $ruta = public_path("$img");

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

        $lineas = PartesTrabajoLineas::where('parteTrabajo_id', $id)->orderBy('order')->get();

        $partesController = new PartesTrabajoController();
        $elements = $partesController->UpdateIvaDescuentoParte($id);

        $iva = $elements['iva'];

       // Generar el PDF con la vista 'pdf/parte_trabajo'
       $pdf = Pdf::loadView('pdf.parte_trabajo', [
           'parte' => $parte,
           'firma' => $firma,
           'imagenes' => $imagenes,
           'responsable' => $responsablesString,
           'existeProyecto' => $existeProyecto,
           'iva' => $iva,
           'descuentoParte' => $parte->descuentoParte,
           'lineas' => $lineas,
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
           'descuentoParte' => $parte->descuentoParte,
           'lineas' => $lineas,
       ])->setPaper('folio', 'landscape');

        return $pdf->save($path);
    }

    public function createZip(Request $request, $id){

        // Obtener la información de la parte de trabajo
        $parteTrabajo = PartesTrabajo::with('cliente', 'partesTrabajoLineas')->findOrFail($id);
    
        $folderPath = public_path("archivos/partes_trabajo/comprimidos/$parteTrabajo->idParteTrabajo");
    
        // verificar si la carpeta existe
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
    
        // Obtener las imágenes a comprimir
        $images = partesTrabajoArchivos::where('parteTrabajo_id', $parteTrabajo->idParteTrabajo)
            ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', '=', 'archivos.idarchivos')
            ->get(['archivos.pathFile as path', 'partestrabajo_sl_has_archivos.comentarioArchivo as comentario', 'archivos.nameFile']);
    
        
        foreach ($images as $image) {
            // Obtener la carpeta donde se encuentra la imagen
            $folderImage = $image->path;
        
            // Ubicación de la imagen
            $imagePath = public_path("$folderImage");
            
            // Copiar la imagen a la carpeta temporal
            if (file_exists($imagePath)) {
                File::copy($imagePath, "$folderPath/$image->nameFile");
            }
        }
    
        // Generar la carpeta donde se almacenará el archivo temporal
        $docsPath = "public/archivos/partes_trabajo/comprimidos/{$parteTrabajo->idParteTrabajo}";
    
        // Crear la carpeta si no existe
        if (!Storage::exists($docsPath)) {
            Storage::makeDirectory($docsPath, 0755, true);
        }
    
        // Generar la ruta del archivo Excel
        $excelFilePath = "$docsPath/parte_trabajo_{$parteTrabajo->idParteTrabajo}.xlsx";

        $lineas = PartesTrabajoLineas::where('parteTrabajo_id', $parteTrabajo->idParteTrabajo)->orderBy('order')->get();
    
        // Almacenar el archivo Excel en la carpeta especificada usando el disco 'public'
        Excel::store(
            new ParteTrabajoExport(
                $parteTrabajo,
                $lineas, 
                "parte_trabajo_$parteTrabajo->idParteTrabajo"
            ), 
            $excelFilePath
        );
    
        // Generar el PDF
        $pdfFilePath = $folderPath . "/parte_trabajo_$parteTrabajo->idParteTrabajo.pdf";
        $this->generatePdParte($parteTrabajo->idParteTrabajo, $pdfFilePath);
    
        // Crear un nuevo archivo zip
        $zip            = new ZipArchive();
        $fechaHoy       = Carbon::now()->format('Y-m-d');
        $zipFileName    = "parte_trabajo_$parteTrabajo->idParteTrabajo-$fechaHoy.zip";
        $zipFilePath    = $folderPath . "/$zipFileName";
    
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            // agregar todos los archivos a la carpeta comprimida
            $files = File::files($folderPath);
            $excel = Storage::files($docsPath);

            $folderZipName = "parte_trabajo_$parteTrabajo->idParteTrabajo";
            $zip->addEmptyDir($folderZipName);

            // Agregar la carpeta $folderZipName 
            foreach ($files as $file) {
                if (basename($file) !== basename($zipFileName)) {
                    $zip->addFile($file, $folderZipName . '/' . basename($file));
                }
            }

            foreach ($excel as $file) {
                if (basename($file) !== basename($zipFileName)) {
                    $zip->addFile(storage_path("app/$file"), $folderZipName . '/' . basename($file));
                }
            }

            // cerrar el archivo zip
            $zip->close();
        } else {
            return response()->json([
                'message' => 'Error al crear el archivo zip'
            ], 500);
        }
    
        // Eliminar los archivos PDF y Excel después de agregarlos al ZIP
        File::delete($pdfFilePath);
        Storage::deleteDirectory($docsPath);
        // File::deleteDirectory($folderPath);
    
        // Descargar el archivo zip
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public static function createZipWhenOrderStatusFinished($id){
        try {
            // Obtener la información de la parte de trabajo
            $parteTrabajo = PartesTrabajo::with('cliente', 'partesTrabajoLineas')->findOrFail($id);
        
            $folderPath = public_path("archivos/partes_trabajo/comprimidos/$parteTrabajo->idParteTrabajo");
        
            // verificar si la carpeta existe
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
        
            // Obtener las imágenes a comprimir
            $images = partesTrabajoArchivos::where('parteTrabajo_id', $parteTrabajo->idParteTrabajo)
                ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', '=', 'archivos.idarchivos')
                ->get(['archivos.pathFile as path', 'partestrabajo_sl_has_archivos.comentarioArchivo as comentario', 'archivos.nameFile']);
        
            
            foreach ($images as $image) {
                // Obtener la carpeta donde se encuentra la imagen
                $folderImage = $image->path;

                // Ubicación de la imagen
                $imagePath = public_path($folderImage);
                
                // Copiar la imagen a la carpeta temporal
                if (file_exists($imagePath)) {
                    File::copy($imagePath, "$folderPath/$image->nameFile");
                }
            }
        
            // Generar la carpeta donde se almacenará el archivo temporal
            $docsPath = "public/archivos/partes_trabajo/comprimidos/{$parteTrabajo->idParteTrabajo}";
        
            // Crear la carpeta si no existe
            if (!Storage::exists($docsPath)) {
                Storage::makeDirectory($docsPath, 0755, true);
            }
        
            // Generar la ruta del archivo Excel
            $excelFilePath = "$docsPath/parte_trabajo_{$parteTrabajo->idParteTrabajo}.xlsx";
        
            // Almacenar el archivo Excel en la carpeta especificada usando el disco 'public'

            $lineas = PartesTrabajoLineas::where('parteTrabajo_id', $parteTrabajo->idParteTrabajo)->orderBy('order')->get();

            Excel::store(
                new ParteTrabajoExport(
                    $parteTrabajo,
                    $lineas, 
                    "parte_trabajo_$parteTrabajo->idParteTrabajo"
                ), 
                $excelFilePath
            );
        
            // Generar el PDF
            $pdfFilePath = $folderPath . "/parte_trabajo_$parteTrabajo->idParteTrabajo.pdf";
            Self::generatePdParte($parteTrabajo->idParteTrabajo, $pdfFilePath);
        
            // Crear un nuevo archivo zip
            $zip            = new ZipArchive();
            $fechaHoy       = Carbon::now()->format('Y-m-d');
            $zipFileName    = "parte_trabajo_$parteTrabajo->idParteTrabajo-$fechaHoy.zip";
            $zipFilePath    = $folderPath . "/$zipFileName";
        
            if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
                // agregar todos los archivos a la carpeta comprimida
                $files = File::files($folderPath);
                $excel = Storage::files($docsPath);

                $folderZipName = "parte_trabajo_$parteTrabajo->idParteTrabajo";
                $zip->addEmptyDir($folderZipName);

                // Agregar la carpeta $folderZipName 
                foreach ($files as $file) {
                    if (basename($file) !== basename($zipFileName)) {
                        $zip->addFile($file, $folderZipName . '/' . basename($file));
                    }
                }

                foreach ($excel as $file) {
                    if (basename($file) !== basename($zipFileName)) {
                        $zip->addFile(storage_path("app/$file"), $folderZipName . '/' . basename($file));
                    }
                }

                // cerrar el archivo zip
                $zip->close();
            } else {
                return response()->json([
                    'message' => 'Error al crear el archivo zip'
                ], 500);
            }

            $estadoParteMsg = ($parteTrabajo->Estado == 1) ? 'Pendiente' : (($parteTrabajo->Estado == 2) ? 'En proceso' : 'Finalizado');
            $nombreCompletoMsg = $parteTrabajo->cliente->NombreCliente . ' ' . $parteTrabajo->cliente->ApellidosCliente;

            $responsablesMsg   = ordentrabajo_operarios::where('orden_id', $parteTrabajo->idParteTrabajo)->with('operarios')->get();
            $operariosMsg = '';

            foreach ($responsablesMsg as $key => $responsable) {

                // verficar si es la ultima iteracion para no agregar la coma
                if ($key == count($responsablesMsg) - 1) {
                    $operariosMsg .= $responsable->operarios->nameOperario;
                } else {
                    $operariosMsg .= $responsable->operarios->nameOperario.', ';
                }

            }

            // formatear valores
            $parteTrabajo->suma = formatPrice(floatval($parteTrabajo->suma));

            $messageNotification = "Nuevo parte de trabajo Finalizado: #" . $parteTrabajo->idParteTrabajo."\n\n";
            $titulo = ($parteTrabajo->tituloParte) ? $parteTrabajo->tituloParte : $parteTrabajo->Asunto;

            $messageNotification .= "Asunto: " . $titulo . "\n";
            $messageNotification .= "Trabajo: " . $parteTrabajo->trabajo->nameTrabajo . "\n";
            $messageNotification .= "Fecha de alta: " . $parteTrabajo->FechaAlta . "\n";
            $messageNotification .= "Fecha de visita: " . $parteTrabajo->FechaVisita . "\n";
            $messageNotification .= "Estado: " . $estadoParteMsg . "\n\n";

            $messageNotification .= "Cliente: " . $nombreCompletoMsg . "\n";
            $messageNotification .= "Responsables: " . $operariosMsg . "\n\n";

            // verificar si el parte de trabajo tiene lineas de material
            $tieneLineas = PartesTrabajoLineas::where('parteTrabajo_id', $parteTrabajo->idParteTrabajo)->orderBy('order')->get();

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
                'path' => $zipFilePath,
                'type' => 'document',
                'comment' => $messageNotification
            ];

            $messageNotification = "";
            
            // enviar el archivo zip a un canal de telegram
            $telegramControler = new NotificationsController();

            $chatIdAutomatico = $telegramControler->getCurrentChatIdByConfig('partes');
            $telegramControler->sendMessageT($messageNotification, $chatIdAutomatico, $media);
   
            // Eliminar los archivos PDF y Excel después de agregarlos al ZIP
            File::delete($pdfFilePath);
            Storage::deleteDirectory($docsPath);

            // eliminar el zip después de enviarlo
            File::delete($zipFilePath);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage()." ".$th->getLine()." ".$th->getFile());
        }
    }

    public function createProjectZip(Request $request, $id){

        $proyecto = Project::findOrFail($id);
        $proyectosPartes = $proyecto->partes->pluck('idParteTrabajo')->toArray();

        $partesTrabajo = PartesTrabajo::with('cliente', 'partesTrabajoLineas')
            ->whereIn('idParteTrabajo', $proyectosPartes)
            ->get();

        $folderPath = storage_path("app/public/archivos/partes_trabajo/comprimidos/proyecto_$id");

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        $fechaHoy = Carbon::now()->format('Y-m-d');
        $zipFileName = "proyecto_$id-$fechaHoy.zip";
        $zipFilePath = "$folderPath/$zipFileName";

        ini_set('memory_limit', '512M');
        set_time_limit(0);

        $zip = new ZipArchive();

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($partesTrabajo as $parteTrabajo) {
                $folderZipName = "parte_trabajo_$parteTrabajo->idParteTrabajo";
                $zip->addEmptyDir($folderZipName);

                // **Procesar imágenes**
                $images = partesTrabajoArchivos::where('parteTrabajo_id', $parteTrabajo->idParteTrabajo)
                    ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', '=', 'archivos.idarchivos')
                    ->whereNotIn('archivos.typeFile', ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'mp4', 'avi', 'mov', 'mkv', 'flv', 'wmv', 'mpg', 'mpeg', '3gp', 'webm'])
                    ->get(['archivos.pathFile', 'archivos.nameFile', 'archivos.typeFile', 'archivos.idarchivos']);

                foreach ($images as $image) {
                    $imagePath = public_path($image->pathFile);

                    if (file_exists($imagePath)) {

                        // $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                        
                        // if ( $image->typeFile != 'jpg' || $extension != 'jpg' ) {
                        //     // obtener el nombre de la carpeta
                        //     $nombreFolder = explode('/', $image->pathFile);

                        //     // quitar el ultimo elemento del array
                        //     array_pop($nombreFolder);

                        //     // unir los elementos del array con /
                        //     $nombreFolder = implode('/', $nombreFolder);
                            
                        //     // convertir la imagen a JPG
                        //     $convertedImage = (new ImagesController())->convertAnyImageToJpg($imagePath, $nombreFolder);

                        //     $imagePath = public_path($convertedImage['relativePath']);

                        //     // ACTUALIZAR EN LA BASE DE DATOS
                        //     $archivo = Archivos::find($image->idarchivos);
                        //     $archivo->typeFile = 'jpg';
                        //     $archivo->pathFile = $convertedImage['relativePath'];
                        //     $archivo->save();
                        // }

                        $fileContent = file_get_contents($imagePath);
                        if ($fileContent !== false) {
                            $zip->addFromString("$folderZipName/{$image->nameFile}", $fileContent);
                        }
                    } else {
                        Log::warning("Archivo de imagen no encontrado: $imagePath");
                    }
                }

                $docsPath = "public/archivos/partes_trabajo/comprimidos/proyecto_{$id}";
                // Crear la carpeta si no existe
                if (!Storage::exists($docsPath)) {
                        Storage::makeDirectory($docsPath, 0755, true);
                    }
                
                    // Generar la ruta del archivo Excel
                    $excelFilePath = "$docsPath/parte_trabajo_{$parteTrabajo->idParteTrabajo}.xlsx";
                
                    // Almacenar el archivo Excel en la carpeta especificada usando el disco 'public'

                    $lineas = PartesTrabajoLineas::where('parteTrabajo_id', $parteTrabajo->idParteTrabajo)->orderBy('order')->get();

                    Excel::store(
                        new ParteTrabajoExport(
                            $parteTrabajo,
                            $lineas, 
                            "parte_trabajo_$parteTrabajo->idParteTrabajo"
                        ), 
                        $excelFilePath
                    );

                // verificar si el archivo existe
                if (file_exists(storage_path("app/$excelFilePath"))) {
                    $zip->addFile(storage_path("app/$excelFilePath"), "$folderZipName/" . basename($excelFilePath));
                }

                // **Crear y agregar PDF al ZIP**
                $pdfFilePath = "$folderPath/parte_trabajo_{$parteTrabajo->idParteTrabajo}.pdf";
                $this->generatePdParte($parteTrabajo->idParteTrabajo, $pdfFilePath);

                if (file_exists($pdfFilePath)) {
                    $zip->addFile($pdfFilePath, "$folderZipName/parte_trabajo_{$parteTrabajo->idParteTrabajo}.pdf");
                }
            }

            $zip->close();

            $finalZipPath = storage_path("app/public/archivos/$zipFileName");
            File::move($zipFilePath, $finalZipPath);

            File::deleteDirectory($folderPath);

            return response()->download($finalZipPath)->deleteFileAfterSend(true);
        }

        return response()->json(['message' => 'Error al crear el archivo zip'], 500);
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
    
}
