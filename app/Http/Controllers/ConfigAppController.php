<?php

namespace App\Http\Controllers;

use App\Imports\VentasComprasImport;
use App\Models\ConfigModel;
use App\Models\Empresa;
use App\Models\TelegramGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ConfigAppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $canales = TelegramGroup::all();
        $empresas = Empresa::all();

        return view('admin.config.index', compact('canales', 'empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getConfig(Request $request){

        try {
            
            $id = $request->config;
            // obtener el ultimo registro de la columna $id
            
            $config = ConfigModel::where($id, '!=', null)
            ->orderBy('id', 'desc')
            ->first();

            $historial = ConfigModel::where($id, '!=', null)
            ->leftJoin('telegram_groups', 'telegram_groups.chat_id', '=', 'telegram_config.'.$id)
            ->orderBy('telegram_config.id', 'desc')
            ->get();

            return response()->json([
                'status' => true,
                'data' => $config,
                'historial' => $historial,
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener la configuración',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function saveConfig(Request $request){

        try {
            
            // obtener la anterior configuración
            $config = ConfigModel::orderBy('id', 'desc')->first();

            // crear una nueva configuración solamente cambiando el valor de la columna
            $newConfig = new ConfigModel();

            $newConfig->avisos = $config->avisos;
            $newConfig->compras = $config->compras;
            $newConfig->partes = $config->partes;

            $newConfig->{$request->tipo} = $request->chatId;

            $newConfig->save();
            
            return response()->json([
                'status' => true,
                'message' => 'Configuración guardada correctamente',
                'data' => $config,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al guardar la configuración',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function ImportComprasVentas(Request $request){
        
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        // esta accion puede tardar un poco aumentar el tiempo de ejecución y el limite de memoria
        ini_set('memory_limit', '512M');
        set_time_limit(0);

        Excel::import(new VentasComprasImport, $request->file('file'));

        return back()->with('success', 'Datos importados correctamente.');
    }

    public function downloadFormat(Request $request){

        $path = public_path('archivos/formatos/compras_ventas_import.xlsx');

        return response()->download($path);
    }

    public function checkSession(Request $request){

        $status = Auth::check();

        return response()->json([
            'status' => $status,
            'active' => Auth::check(),
        ], 200);
    }

}
