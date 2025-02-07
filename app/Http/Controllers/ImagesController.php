<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use Dotenv\Dotenv;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

use Imagick;

class ImagesController extends Controller
{
    protected $cloudconvert;

    public function __construct()
    {
        $this->middleware('auth');
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->load();
    }

    public static function convertHeicToJpg($inputPath, $nombreFolder){
        try {
            // Verifica que el archivo HEIC exista
            if (!file_exists($inputPath)) {
                throw new \Exception("El archivo HEIC no existe.");
            }

            // Cargar la imagen HEIC
            $manager = new ImageManager(new Driver());
            $image = $manager->read($inputPath);
            
            // Convertir la imagen a JPG
            $encoded = $image->toJpeg(60); // Puedes ajustar la calidad a tu necesidad
            
            // Crear la carpeta si no existe
            $path = public_path('/archivos/partes_trabajo/' . $nombreFolder);

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // extraer nombre del archivo
            $nombreArchivo = explode('/', $inputPath);
            $nombreArchivo = end($nombreArchivo);
            $nombreArchivo = explode('.', $nombreArchivo);
            $nombreArchivo = $nombreArchivo[0];

            $nombreArchivo = str_replace(' ', '_', $nombreArchivo);

            // Guardar la imagen convertida en el archivo de salida
            $encoded->save($path . '/' . $nombreArchivo . '.jpg');

            return [
                'path' => $path,
                'extension' => 'jpg',
                'nombreArchivo' => $nombreArchivo
            ];
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al convertir la imagen: ' . $e->getMessage(),
            ], 500);
        }
    }

    public static function convertAnyImageToJpg($inputPath, $folderSavePath){
        try {
            // Verifica que el archivo exista
            if (!file_exists($inputPath)) {
                throw new \Exception("El archivo no existe.");
            }

            // Cargar la imagen HEIC
            $manager = new ImageManager(new Driver());
            $image = $manager->read($inputPath);
            
            // Convertir la imagen a JPG
            $encoded = $image->toJpeg(60); // Puedes ajustar la calidad a tu necesidad
            
            // Crear la carpeta si no existe
            $path = public_path($folderSavePath);

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // extraer nombre del archivo
            $nombreArchivo = explode('/', $inputPath);
            $nombreArchivo = end($nombreArchivo);
            $nombreArchivo = explode('.', $nombreArchivo);
            $nombreArchivo = $nombreArchivo[0];

            $nombreArchivo = str_replace(' ', '_', $nombreArchivo);

            // eliminar la imagen original
            try {
                unlink($inputPath);
            } catch (\Throwable $th) {
                Log::info('Error al eliminar la imagen original: ' . $th->getMessage());
            }   

            // Guardar la imagen convertida en el archivo de salida
            $encoded->save($path . '/' . $nombreArchivo . '.jpg');

            return [
                'path' => $path,
                'extension' => 'jpg',
                'nombreArchivo' => $nombreArchivo,
                'relativePath' => $folderSavePath . '/' . $nombreArchivo . '.jpg'
            ];
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al convertir la imagen: ' . $e->getMessage(). ' - ' . $e->getLine(),
            ], 500);
        }
    }

}

