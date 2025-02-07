<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Operarios;
use App\Models\Trabajos;
use App\Models\trabajos_has_operarios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperariosController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Operarios = Operarios::all();

        $AllUsers  = User::JOIN('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->JOIN('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->WHERE('roles.name', '!=', 'Cliente')
            ->SELECT('users.*', 'roles.name as rol')
            ->get();
            
        $AllTrabajos = Trabajos::all();
        return view('admin.operarios.index', compact('Operarios', 'AllUsers', 'AllTrabajos'));
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'name'     => 'required',
                'email'    => 'required',
                'telefono' => 'required',
                'user_id'  => 'required',
                'trabajos' => 'required|array',
            ]);

            //verificar si el usuario ya existe
            $user = User::FindOrFail($request->user_id);

            // verificar si el operario ya existe
            $operario = Operarios::where('user_id', $request->user_id)->first();

            if ( $operario ) {
                throw new \Exception('El operario ya existe');
            }

            if (!$user) {
                throw new \Exception('El usuario no existe');
            }

            $operario = Operarios::create([
                'user_id'          => $request->user_id,
                'nameOperario'     => $request->name,
                'emailOperario'    => $request->email,
                'telefonoOperario' => $request->telefono,
            ]);

            foreach ($request->trabajos as $trabajo) {
                trabajos_has_operarios::create([
                    'trabajos_idTrabajo'   => $trabajo,
                    'operarios_idOperario' => $operario->idOperario,
                ]);
            }

            return response()->json([
                'message' => 'Operario creado correctamente',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getSkills(Request $request)
    {

        $skills = trabajos_has_operarios::JOIN('trabajos', 'trabajos_has_operarios.trabajos_idTrabajo', '=', 'trabajos.idTrabajo')
            ->WHERE('trabajos_has_operarios.operarios_idOperario', $request->OperarioId)
            ->SELECT('trabajos.*')
            ->get();

        return response()->json([
            'data' => $skills,
            'status' => 200
        ]);
    }

    public function update(Request $request, string $id)
    {
        try {

            $request->validate([
                'name'     => 'required',
                'email'    => 'required',
                'telefono' => 'required',
                'user_id'  => 'required',
                'trabajos' => 'required|array',
            ]);

            $operario = Operarios::FindOrFail($id);

            $operario->update([
                'nameOperario'     => $request->name,
                'emailOperario'    => $request->email,
                'telefonoOperario' => $request->telefono,
            ]);

            trabajos_has_operarios::where('operarios_idOperario', $operario->idOperario)->delete();

            foreach ($request->trabajos as $trabajo) {
                trabajos_has_operarios::create([
                    'trabajos_idTrabajo'   => $trabajo,
                    'operarios_idOperario' => $operario->idOperario,
                ]);
            }

            return response()->json([
                'message' => 'Operario actualizado correctamente',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
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
