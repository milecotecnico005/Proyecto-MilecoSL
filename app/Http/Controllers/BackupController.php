<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\Session;
use Normalizer;

class BackupController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->load();
    }

    public function index(){

        // obtener la cantidad de tablas de la base de datos
        $tables = DB::select('SHOW TABLES');

        $tables = array_map('current', $tables);

        $tables = count($tables);

        return view('admin.backups.index', compact('tables'));
    }

    public function generate(){
        try {
            $dbUser = env('DB_USERNAME', 'root');
            $dbPassword = env('DB_PASSWORD', '');
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbPort = env('DB_PORT', '3306');
            $dbName = env('DB_DATABASE', 'nombre_de_tu_base');
            $backupPath = storage_path('app/backup-' . date('Y-m-d') . '.sql');

            // verficar si estoy en entorno de desarrollo

            $isEnviromenDev = env('APP_ENV') === 'local';

            if ($isEnviromenDev) {
                $mysqldumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
        
                $passwordSegment = $dbPassword ? "--password={$dbPassword}" : '';
                $command = "{$mysqldumpPath} --user={$dbUser} {$passwordSegment} --host={$dbHost} --port={$dbPort} {$dbName} > {$backupPath}";
            }else{
                $passwordSegment = $dbPassword ? "-p{$dbPassword}" : '';
                $command = "mysqldump -u {$dbUser} {$passwordSegment} -h {$dbHost} -P {$dbPort} {$dbName} > {$backupPath}";
            }

    
            // Ejecutar el comando
            $result = null;
            $output = [];
            exec($command, $output, $result);
    
            if ($result !== 0) {
                Log::error("Error al ejecutar mysqldump: " . implode("\n", $output));
                return response()->json(['error' => 'Error al generar la copia de seguridad'], 500);
            }
    
            return response()->download($backupPath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error("Error al generar backup: " . $e->getMessage());
            return response()->json(['error' => 'Error al generar la copia de seguridad'], 500);
        }
    }

    public function importSQL(Request $request){
        // Valida que se suba un archivo .sql
        $request->validate([
            'sql_file' => 'required|file',
        ]);
        
        // verifica si el archivo es un archivo sql
        $fileExtension = $request->file('sql_file')->getClientOriginalExtension();

        if ($fileExtension !== 'sql') {
            return redirect()->back()->with('error', 'El archivo debe ser un archivo SQL');
        }

        try {
            // Obtén el contenido del archivo
            $filePath = $request->file('sql_file')->getRealPath();
            $sql = file_get_contents($filePath);

            // Limpia el archivo eliminando comentarios y líneas innecesarias
            $sql = $this->cleanSqlFile($sql);

            // dd($sql);

            // Deshabilitar temporalmente la escritura en sesiones
            DB::beginTransaction();

            // Divide el archivo SQL en múltiples sentencias
            $queries = array_filter(array_map('trim', explode(';', $sql)));

            set_time_limit(0);
            // Ejecuta cada consulta
            foreach ($queries as $query) {
                Log::info($query);
                if (!empty($query)) {
                    DB::statement($query);
                }
            }

            // Rehabilitar sesiones y confirmar transacción
            DB::commit();

            return redirect()->back()->with('success', 'Archivo SQL importado correctamente');
        } catch (\Exception $e) {
            // Revertir la transacción y habilitar las sesiones
            DB::rollBack();
            dd('Error al importar el archivo SQL: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al importar el archivo SQL: ' . $e->getMessage());
        }
    }

    private function cleanSqlFile($sql){
        // Reemplaza '0000-00-00' por '1970-01-01' (o cualquier otra fecha válida)
        $sql = str_replace("'0000-00-00'", "'1970-01-01'", $sql);
    
        // Deshabilitar las claves foráneas (antes de la ejecución)
        $sql = "SET foreign_key_checks = 0;\n" . $sql;

        $sql = "SET sql_mode = 'STRICT_TRANS_TABLES';\n" . $sql;
        
        // Habilitar las claves foráneas (después de la ejecución)
        $sql .= "\nSET foreign_key_checks = 1;\n";
    
        // Eliminar las sentencias de DROP de la tabla `cache`
        $sql = preg_replace('/DROP TABLE IF EXISTS `cache`.*?;/s', '', $sql);
    
        // Eliminar las sentencias CREATE TABLE para la tabla `cache`
        $sql = preg_replace('/CREATE TABLE `cache`.*?;/s', '', $sql);
    
        // Eliminar las inserciones de datos en la tabla `cache`
        $sql = preg_replace('/INSERT INTO `cache`.*?;/', '', $sql);
    
        // Eliminar cualquier comentario o línea que contenga datos en la tabla `cache`
        $sql = preg_replace('/LOCK TABLES `cache` WRITE;.*?UNLOCK TABLES;/s', '', $sql);
    
        // Elimina los comentarios -- y /*...*/
        $sql = preg_replace('/--.*\n/', '', $sql); // Elimina comentarios de una línea
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql); // Elimina comentarios de múltiples líneas
    
        // Eliminar sentencias de USE y CREATE DATABASE
        $sql = preg_replace('/^(USE|CREATE DATABASE).*/m', '', $sql); // Elimina USE y CREATE DATABASE
    
        // Opcional: Elimina cualquier otra línea vacía o innecesaria
        $sql = preg_replace('/^\s*[\r\n]/m', '', $sql);

        // Reemplazo de caracteres especiales con un array
        $reemplazos = [
            'Ã¡' => 'á', 'Ã©' => 'é', 'Ã­' => 'í', 'Ã³' => 'ó', 'Ãº' => 'ú',
            'Ã±' => 'ñ', 'Ã¼' => 'ü', 'Ã‰' => 'É', 'Ã“' => 'Ó', 'Ã‘' => 'Ñ',
            "\\'" => "'", // Reemplazar comillas escapadas
        ];
        $sql = str_replace(array_keys($reemplazos), array_values($reemplazos), $sql);

        // Normalización Unicode (si es necesario)
        if (function_exists('normalizer_normalize')) {
            $sql = normalizer_normalize($sql, Normalizer::FORM_C);
        }

        // eliminar saltos \r
        $sql = str_replace("\'", " ", $sql);

    
        return $sql;
    }

}
