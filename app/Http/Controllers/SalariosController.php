<?php

namespace App\Http\Controllers;

use App\Models\Salario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salarios = Salario::all();
        // obtener los usuarios que aun no tienen salario
        $usuarios  = User::doesntHave('salario')->get();

        return view('admin.salarios.index', compact('salarios', 'usuarios'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $request->validate([
                'user_id'      => 'required',
                'f_alta'       => 'required|date',
            ]);
            DB::beginTransaction();

            $salario = Salario::create([
                'user_id'      => $request->user_id,
                'f_alta'       => $request->f_alta,
                'salario_men'  => $request->salario_men,
                'salario_sem'  => $request->salario_sem,
                'salario_hora'  => $request->salario_hora,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Salario creado correctamente');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al crear el salario');
        }
    }

    public function update(Request $request, string $id)
    {
        try{
            $request->validate([
                'f_alta'       => 'required|date',
            ]);

            DB::beginTransaction();

            $salario = Salario::find($id);
            $salario->update([
                'f_alta'        => $request->f_alta,
                'f_baja'        => $request->f_baja,
                'salario_men'   => $request->salario_men,
                'salario_sem'   => $request->salario_sem,
                'salario_hora'  => $request->salario_hora,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Salario actualizado correctamente');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al actualizar el salario');
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
