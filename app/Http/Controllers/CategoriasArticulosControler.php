<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArticulosCategorias;
use Illuminate\Http\Request;

class CategoriasArticulosControler extends Controller
{
    public function index()
    {
        $categorias = ArticulosCategorias::all();
        return view('admin.categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        ArticulosCategorias::create([
            'nameCategoria' => $request->nombre,
        ]);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria creada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $categoria = ArticulosCategorias::find($id);
        $categoria->nameCategoria = $request->nombre;
        $categoria->save();

        return redirect()->route('admin.categorias.index')
            ->with('successEdit', 'Categoria actualizada correctamente.');
    }

}
