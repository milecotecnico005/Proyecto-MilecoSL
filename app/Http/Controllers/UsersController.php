<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){

        $AllUsers = User::LEFTJOIN('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->LEFTJOIN('roles', 'model_has_roles.role_id', '=', 'roles.id')
                        ->SELECT('users.*', 'roles.name as role', 'roles.id as roleId')
                        ->get();
        $AllRoles = Role::all();

        $permissions = Permission::all();

        return view('admin.users.index', compact('AllUsers', 'AllRoles', 'permissions'));
    }

    public function edit( Request $request ){
            
        $User = User::LEFTJOIN('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->LEFTJOIN('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->SELECT('users.*', 'roles.name as role', 'roles.id as roleId')
        ->find($request->id);

        return response()->json([
            'status' => true,
            'data' => $User
        ]);
    }

    public function store( Request $request ){
                
        try {

            $request->validate([
                'name'              => 'required',
                'email'             => 'required|email',
                'password'          => 'required|min:8',
                'role'              => 'required'
            ]);
            DB::beginTransaction();
            $role = Role::find($request->role);

            User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password),
                'userState' => 1
            ])->assignRole($role->id);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Usuario creado correctamente'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error al crear el usuario',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function storeApi( Request $request ){
                
        try {

            DB::beginTransaction();

            $User = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password),
                'userState' => 1
            ]);

            // asignarle el rol cliente 10
            $User->assignRole(10);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Usuario creado correctamente',
                'id' => $User->id,
                'name' => $User->name,
                'email' => $User->email
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error al crear el usuario',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function validateEmailUser( Request $request ){
                
        $User = User::where('email', $request->email)->first();
        if ( $User ) {
            return response()->json([
                'status' => true,
                'data' => $User,
                'existente' => true
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'El email no existe',
                'existente' => false
            ]);
        }
    }

    public function update( Request $request ){
            
        try {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email'
            ]);

            $User = User::findOrFail($request->id);
            $User->name = $request->name;

            if ( $User->email != $request->email ) {
                $User->email = $request->email;
            }

            $role = Role::find($request->role);
            $User->save();

            $User->syncRoles([$role->id]);

            return response()->json([
                'status' => true,
                'message' => 'Usuario actualizado correctamente'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar el usuario',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function toggleActiveDisabled( Request $request ){
                
        try {
            
            if ( $request->type == 'Desactivar' ) {
                $state = 0;
                $msg = 'Usuario desactivado correctamente';
            }else{
                $state = 1;
                $msg = 'Usuario activado correctamente';
            }

            $User = User::findOrFail($request->userId);
            $User->userState = $state;
            $User->save();

            return response()->json([
                'status' => true,
                'message' => $msg
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar el usuario',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function updatePassword( $id, Request $request ){

        try{
            DB::beginTransaction();

            $User           = User::findOrFail($id);
            $User->password = Hash::make($request->password);
            $User->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Contraseña actualizada correctamente'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar la contraseña',
                'error' => $th->getMessage()
            ]);
        }

    }

}
