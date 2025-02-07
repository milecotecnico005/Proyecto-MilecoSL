<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Archivos;
use App\Models\Empresa;
use App\Models\TipoEmpresa;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmpresasController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas   = Empresa::all(); // Obtener todas las empresas con su tipo asociado
        $tipos      = TipoEmpresa::all(); // Obtener todos los tipos de empresa
        return view('admin.empresas.index', compact('empresas', 'tipos'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'anoEmpresa'            => 'required|date',
                'EMP'                   => 'required',
            ]);
            DB::beginTransaction();
            // Formatear la fecha para obtener el año
            $dateFormated = Carbon::parse($request->anoEmpresa)->format('Y');
            
            $tipoEmpresa = TipoEmpresa::find($request->tipoEmpresa);

            $nombre = ( $tipoEmpresa ) ? $tipoEmpresa->nameTipo.'-'.$request->EMP."-".$dateFormated : $request->EMP."-".$dateFormated;

            // Verificar si la empresa ya existe
            $empresa = Empresa::where('EMP', $nombre)->first();

            if ($empresa) {
                return redirect()->route('admin.empresas.index')->with('error', 'La empresa ya existe');
            }

            Empresa::create([
                'añoEmpresa'            => $request->anoEmpresa,
                'EMP'                   => $nombre,
                'tipoEmpresa'           => ( $tipoEmpresa ) ? $request->tipoEmpresa : null,
                'observacionesEmpresa'  => ( $request->observacionesEmpresa ) ? $request->observacionesEmpresa : null
            ]);
            DB::commit();
            return redirect()->route('admin.empresas.index')->with('success', 'Empresa creada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $e->getTrace();
            return redirect()->route('admin.empresas.index')->with('error', 'Error al crear la empresa');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'anoEmpresa'            => 'required|date',
                'EMP'                   => 'required',
            ]);

            DB::beginTransaction();

            $tipoEmpresa = TipoEmpresa::find($request->tipoEmpresa);
            
            $dateFormated = Carbon::parse($request->anoEmpresa)->format('Y');
            
            $nombre = ( $tipoEmpresa ) ? $tipoEmpresa->nameTipo.'-'.$request->EMP."-".$dateFormated : $request->EMP."-".$dateFormated;

            Empresa::findOrFail($id)->update([
                'añoEmpresa'            => $request->anoEmpresa,
                'EMP'                   => $nombre,
                'tipoEmpresa'           => ( $tipoEmpresa ) ? $request->tipoEmpresa : null,
                'observacionesEmpresa'  => ( $request->observacionesEmpresa ) ? $request->observacionesEmpresa : null
            ]);
            DB::commit();
            return redirect()->route('admin.empresas.index')->with('success', 'Empresa actualizada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.empresas.index')->with('error', 'Error al actualizar la empresa: '.$e->getMessage());
        }
    }

    public function getLatestLogo($idEmpresa){

        $archivo = Archivos::where('empresa_id', $idEmpresa)->latest()->first();

        if ($archivo) {
            return response()->json([
                'status' => true,
                'logo' => asset("{$archivo->pathFile}")
            ]);
        }

        return response()->json([
            'message' => 'No se encontró el archivo',
            'status' => false
        ]);

    }

    public function uploadLogo(Request $request){
        try {

            $request->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            DB::beginTransaction();

            $idEmpresa = $request->empresa_id;

            // Verifica si la empresa existe
            Empresa::findOrFail($idEmpresa);

            // Ruta donde se guardará el archivo
            $path = public_path("archivos/empresas/logos/{$idEmpresa}");

            // Verifica y crea la carpeta si no existe
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file = $request->file('logo');

            // Nombre único del archivo
            $name = str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $path = "archivos/empresas/logos/{$idEmpresa}/{$name}";

            // Guarda la información en la base de datos
            Archivos::create([
                'nameFile' => $name,
                'typeFile' => $file->getClientOriginalExtension(),
                'pathFile' => $path,
                'empresa_id' => $idEmpresa,
            ]);

            DB::commit();

            return back()->with('success', 'Logo subido correctamente.');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al subir el logo: ' . $th->getMessage()]);
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
