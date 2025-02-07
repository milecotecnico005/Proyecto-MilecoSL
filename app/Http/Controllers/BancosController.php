<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\BankImport;
use App\Models\Banco;
use App\Models\banco_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BancosController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $bancos         = Banco::all();
        $banco_detail   = banco_detail::all();
        return view('admin.clientes.bancos.index', compact('bancos', 'banco_detail'));
    }

    public function store( Request $request ){
        try {

            $request->validate([
                'nameBanco' => 'required',
            ]);

            Banco::create([
                'nameBanco' => $request->nameBanco,
            ]);

            return redirect()->route('admin.bancos.index')->with('success', 'Banco creado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.bancos.index')->with('error', 'Error al crear el banco');
        }
    }

    public function storeApi( Request $request ){
        try {

            $request->validate([
                'nameBanco' => 'required',
            ]);

            $banco = Banco::create([
                'nameBanco' => $request->nameBanco,
            ]);

            return response()->json([
                'message' => 'Banco creado correctamente',
                'id' => $banco->idbanco,
                'name' => $banco->nameBanco
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el banco'], 500);
        }
    }

    public function edit( $id, Request $request ){
        try{

            $request->validate([
                'nameBanco' => 'required',
            ]);
            
            $banco               = Banco::FindOrFail($id);
            $banco->nameBanco    = $request->nameBanco;
            
            $banco->save();

            return redirect()->route('admin.bancos.index')->with('successEdit', 'Banco actualizado correctamente');
        }catch(\Exception $e){
            return redirect()->route('admin.bancos.index')->with('errorEdit', 'Error al actualizar el banco');
        }
    }

    public function details( $id ){
        $banco = Banco::with('banco_detail')->FindOrFail($id);

        // obtener el saldo total del banco
        $saldo = 0;

        $obtenerElUltimoSaldo = banco_detail::where('banco_id', $id)->orderBy('id_detail', 'desc')->first();

        if($obtenerElUltimoSaldo){
            $saldo = $obtenerElUltimoSaldo->saldo;
        }

        return view('admin.clientes.bancos.details', compact('banco', 'saldo'));
    }

    public function importXML( Request $request ){
        try {
            
            // Valida que el archivo sea de tipo xlsx
            $request->validate([
                'file' => 'required|file|mimes:xlsx'
            ]);

            // Realiza la importación usando la clase BankImport
            Excel::import(new BankImport, $request->file('file'));

            return redirect()->back()->with('success', 'Archivo importado exitosamente');
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }


}
