<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller{

    private function generateBreadcrumbs($folder){
        $breadcrumbs = [];
        $segments = explode('/', $folder);

        $currentPath = '';
        foreach ($segments as $segment) {
            $currentPath .= $segment . '/';
            $breadcrumbs[] = [
                'name' => $segment,
                'path' => route('admin.filemanager.index', ['folder' => rtrim($currentPath, '/')]),
                'icon' => 'folder',
            ];
        }

        return $breadcrumbs;
    }

    public function index(Request $request){

        
        // detectar si las carpetas son de la aplicación laravel
        if ($request->get('laravelPath') == 'laravelPath') {

            $folder = base_path();
            $folderToSearch = $request->get('folder', '');
            dd($folder."/".$folderToSearch);
            $directories = File::directories($folder."/".$folderToSearch);
            dd($directories);
            $files = File::files($folder);
            $breadcrumbs = $this->generateBreadcrumbs('app');

            $laravelDirectories = $directories;
            $laravelFiles = $files;

            return view('admin.static.index', compact('directories', 'files', 'folder', 'breadcrumbs', 'laravelFiles', 'laravelDirectories'));
        }

        // Obtener la carpeta actual (si está presente en la URL)
        $folder = $request->get('folder', '');
        $path = $folder ? public_path('' . $folder) : public_path('');

        // Verificar si la carpeta existe en storage_path o public_path
        if (!File::exists($path)) {
            // Si no existe, intentamos en public_path
            $path = public_path('/' . $folder);
        }

        // Obtener las carpetas y archivos
        $directories = File::directories($path);
        $files = File::files($path);

        // archivos de la aplicación laravel
        $laravelFiles = File::files(base_path());
        $laravelDirectories = File::directories(base_path());

        // Generar las migas de pan
        $breadcrumbs = $this->generateBreadcrumbs($folder);

        return view('admin.static.index', compact('directories', 'files', 'folder', 'breadcrumbs', 'laravelFiles', 'laravelDirectories'));
    }

    public function upload(Request $request){
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $file = $request->file('file');
        $folder = $request->get('folder', '');

        // Guardar el archivo en el directorio correcto
        $file->storeAs('public/' . $folder, $file->getClientOriginalName());

        return back()->with('success', 'Archivo subido exitosamente');
    }

    public function deleteFile($file, $folder){
        $filePath = storage_path('app/public/' . $folder . '/' . $file);

        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        return back()->with('success', 'Archivo eliminado exitosamente');
    }

    public function deleteFolder($folder){
        $folderPath = storage_path('app/public/' . $folder);

        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath);
        }

        return back()->with('success', 'Carpeta eliminada exitosamente');
    }

    public function download($folder = null, $file = null){
        
        $folder = $_GET['folder'];
        $file = $_GET['file'];

        // Verifica si ambos parámetros son válidos
        if (!$folder || !$file) {
            return redirect()->route('filemanager.index')->with('error', 'Parámetros de archivo o carpeta inválidos.');
        }

        // Construye la ruta completa del archivo
        $filePath = public_path('' . $folder . '/' . $file);

        // Verifica si el archivo existe
        if (File::exists($filePath)) {
            return response()->download($filePath);
        }

        // Si no existe el archivo, regresa al formulario con un mensaje de error
        return back()->with('error', 'El archivo solicitado no existe');
    }

    // Método para mostrar el archivo en un editor
    public function edit(Request $request){

        $folder = $request->get('folder', '');
        $file = $request->get('file', '');

        if ($request->get('laravelApp') == 'laravelApp') {
            $folder = base_path();
            $file = $request->get('file', '');

            $filePath = $folder . '/' . $file;

            if (File::exists($filePath)) {
                $content = File::get($filePath);

                return view('admin.static.edit', compact('folder', 'file', 'content'));
            }

            return back()->with('error', 'El archivo no existe');
        }

        // Decodificar los valores de las carpetas y archivos
        $folder = urldecode($folder);
        $file = urldecode($file);

        // Ruta completa del archivo
        $filePath = public_path('' . $folder . '/' . $file);

        // Verificar si el archivo existe
        if (File::exists($filePath)) {
            // Leer el contenido del archivo
            $content = File::get($filePath);

            // Retornar la vista con el contenido del archivo
            return view('admin.static.edit', compact('folder', 'file', 'content'));
        }

        return back()->with('error', 'El archivo no existe');
    }
 
    // Método para guardar los cambios realizados en el archivo
    public function save(Request $request, $folder, $file){

        // Decodificar los valores de las carpetas y archivos
        $folder = urldecode($folder);
        $file = urldecode($file);

        // Validar el contenido del archivo
        $request->validate([
            'content' => 'required|string',
        ]);

        // Ruta completa del archivo
        $filePath = public_path('' . $folder . '/' . $file);

        // Verificar si el archivo existe
        if (File::exists($filePath)) {

            // Guardar el nuevo contenido en el archivo
            File::put($filePath, $request->input('content'));

            // Redirigir con mensaje de éxito
            return redirect()->route('admin.filemanager.index')->with('success', "El archivo $file ha sido actualizado correctamente");
        }

        return back()->with('error', 'El archivo no existe');
    }

}
