<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoClientesController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {

        $tiposclientes = TipoCliente::all();

        return view('admin.clientes.tiposclientes.index', compact('tiposclientes'));
    }

    public function store( Request $request ){
        try {

            $request->validate([
                'nameTipoCliente' => 'required',
                'descuento'       => 'required|numeric'
            ]);

            TipoCliente::create([
                'nameTipoCliente' => $request->nameTipoCliente,
                'descuento'       => $request->descuento
            ]);

            return redirect()->route('admin.tipo-clientes.index')->with('success', 'Tipo de cliente creado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.tipo-clientes.index')->with('error', 'Error al crear el tipo de cliente');
        }
    }

    public function edit( $id, Request $request ){
        try{
            
            $tipoCliente                    = TipoCliente::FindOrFail($id);
            $tipoCliente->nameTipoCliente   = $request->nameTipoCliente;
            $tipoCliente->descuento         = $request->descuento;
            
            $tipoCliente->save();

            return redirect()->route('admin.tipo-clientes.index')->with('successEdit', 'Tipo de cliente actualizado correctamente');
        }catch(\Exception $e){
            return redirect()->route('admin.tipo-clientes.index')->with('errorEdit', 'Error al actualizar el tipo de cliente');
        }
    }

}
