<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoEmpresa;
use Illuminate\Http\Request;

class TipoEmpresasController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $tipos = TipoEmpresa::all();
        return view('admin.empresas.tipos', compact('tipos'));
    }

    public function store(Request $request)
    {
        // Validar los datos enviados desde el formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            // Agregar más validaciones según tus necesidades
        ]);
        
        // Crear un nuevo tipo de empresa
        TipoEmpresa::create([
            'nameTipo' => $request->nombre,
            // Agregar más campos según tu modelo TipoEmpresa
        ]);
        
        // Redireccionar con un mensaje de éxito
        return response()->json(['success' => true, 'message' => 'Tipo de empresa creado exitosamente']);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos enviados desde el formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            // Agregar más validaciones según tus necesidades
        ]);
        
        // Buscar el tipo de empresa por su ID
        $tipo = TipoEmpresa::findOrFail($id);
        
        // Actualizar los datos del tipo de empresa
        $tipo->update([
            'nameTipo' => $request->nombre,
            // Agregar más campos según tu modelo TipoEmpresa
        ]);
        
        // Redireccionar con un mensaje de éxito
        return response()->json(['success' => true, 'message' => 'Tipo de empresa actualizado exitosamente']);
    }

}
