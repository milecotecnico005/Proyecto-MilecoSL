<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Trabajos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Throw_;

class TrabajosController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $trabajos = Trabajos::all();

        return view('admin.trabajos.index', compact('trabajos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required',
                'descripcion' => 'required',
            ]);

            Trabajos::create([
                'nameTrabajo' => $request['name'],
                'descripcionTrabajo' => $request['descripcion'],
            ]);
            
            return response()->json([
                'message' => 'Trabajo creado correctamente',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            Throw new \Exception($e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'descripcion' => 'required',
            ]);

            $trabajo = Trabajos::find($id);

            $trabajo->nameTrabajo = $request['name'];
            $trabajo->descripcionTrabajo = $request['descripcion'];

            $trabajo->save();

            return response()->json([
                'message' => 'Trabajo actualizado correctamente',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            Throw new \Exception($e->getMessage());
        }
    }

}
