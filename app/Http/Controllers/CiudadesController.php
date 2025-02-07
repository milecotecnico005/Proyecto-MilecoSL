<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CiudadesController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){

        $ciudades = Ciudad::all();

        return view('admin.clientes.ciudades.index', compact('ciudades'));
    }

    public function store( Request $request ){
        try {

            $request->validate([
                'nameCiudad' => 'required',
            ]);

            Ciudad::create([
                'nameCiudad' => $request->nameCiudad,
            ]);

            return redirect()->route('admin.ciudades.index')->with('success', 'Ciudad creada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.ciudades.index')->with('error', 'Error al crear la ciudad');
        }
    }

    public function edit( $id, Request $request ){
        try{
            $ciudad               = Ciudad::FindOrFail($id);
            $ciudad->nameCiudad   = $request->nameCiudad;
            
            $ciudad->save();

            return redirect()->route('admin.ciudades.index')->with('successEdit', 'Ciudad actualizada correctamente');
        }catch(\Exception $e){
            return redirect()->route('admin.ciudades.index')->with('errorEdit', 'Error al actualizar la ciudad');
        }
    }

}
