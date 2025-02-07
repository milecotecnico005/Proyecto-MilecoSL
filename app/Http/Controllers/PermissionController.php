<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function indexRoles()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        
        return view('admin.permissions.indexRoles', compact('roles', 'permissions'));
    }

    public function updateRole(Request $request, $roleId){
        // Buscar el rol por ID

        $role = Role::findOrFail($roleId);

        // Actualizar el nombre del rol
        $role->update([
            'name' => $request->name,
        ]);

        if ( isset($request->permissions) && count($request->permissions) != 0 ) {
            // Obtener los permisos por ID y asegurar que existen en la base de datos
            $permissions = Permission::whereIn('id', $request->permissions)->get();
    
            // Actualizar los permisos del rol
            $role->syncPermissions($permissions);
        }else{
            // significa que no se seleccionaron permisos entonces se le quitan todos los permisos
            $role->syncPermissions([]);
        }

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Rol actualizado.');
    }

    public function assignRolePermissions($roleId)
    {
        // Obtener el rol y sus permisos asignados
        $role = Role::findOrFail($roleId);
        $permissions = Permission::all();
        
        return view('admin.permissions.assignRolePermissions', compact('role', 'permissions'));
    }

    public function updateRolePermissions(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = $request->permissions ?: [];

        // Asignar los permisos seleccionados al rol
        $role->syncPermissions($permissions);

        return redirect()->route('admin.permissions.assignRolePermissions', $roleId)->with('success', 'Permisos actualizados.');
    }

    public function assignUserPermissions($userId)
    {
        $user = User::findOrFail($userId);
        $permissions = Permission::all();
        
        return view('admin.permissions.assignUserPermissions', compact('user', 'permissions'));
    }

    public function updateUserPermissions(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $permissions = $request->permissions ?: [];

        if ( isset($request->permissions) && count($request->permissions) != 0 ) {
            // Obtener los permisos por ID y asegurar que existen en la base de datos
            $permissions = Permission::whereIn('id', $request->permissions)->get();
    
            // Actualizar los permisos del usuario
            $user->syncPermissions($permissions);
        }else{
            // significa que no se seleccionaron permisos entonces se le quitan todos los permisos
            $user->syncPermissions([]);
        }

        return redirect()->back()->with('success', 'Permisos de usuario actualizados.');
    }

    public function storePermission(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // verificar si ya existe el permiso
        $permission = Permission::where('name', $request->name)->first();

        if ( $permission ) {
            return redirect()->back()->with('error', 'El permiso ya existe.');
        }
        
        // Crear el permiso
        Permission::create([
            'name' => $request->name,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Permiso creado.');
    }
}
