<?php

use App\Http\Controllers\CompraController;
use App\Http\Controllers\Modelo347Controller;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\FrontEndController::class, 'index'])->name('index');

Route::get('/politicas-privacidad-milecoSLWeb_Movil', [App\Http\Controllers\FrontEndController::class, 'politicas'])->name('politicas');

Route::middleware(['auth', 'can:home'])->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/register', function () {
    return redirect('/login'); // Redirigir al login
});

Route::middleware(['auth'])->name('admin.')->group(function () {

    Route::GET('/admin/users', [App\Http\Controllers\UsersController::class, 'index'])
        ->name('users.index');

    Route::GET('/admin/users/edit/{id}', [App\Http\Controllers\UsersController::class, 'edit'])
        ->middleware('can:admin.users.update')
        ->name('users.edit');

    Route::PUT('/admin/users/update/{id}', [App\Http\Controllers\UsersController::class, 'update'])
        ->middleware('can:admin.users.update')
        ->name('users.update');

    Route::POST('/admin/users/store', [App\Http\Controllers\UsersController::class, 'store'])
        ->name('users.store');

    Route::PUT('/admin/users/toggle/{id}/{type}', [App\Http\Controllers\UsersController::class, 'toggleActiveDisabled'])
        ->middleware('can:admin.users.update')
        ->name('users.updateToggle');

    Route::GET('/admin/citas/download/{id}', [App\Http\Controllers\CitasController::class, 'download'])
        ->name('citas.download');

    Route::PUT('/admin/users/updatePassword/{id}', [App\Http\Controllers\UsersController::class, 'updatePassword'])
        ->middleware('can:admin.users.update')
        ->name('users.updatePassword');

});

Route::PUT('/admin/users/updateProfile/{id}', [App\Http\Controllers\UsersController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('users.updateProfile');

Route::middleware(['auth'])->post('/clear-cacheApp', function () {

    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('event:clear');

    // Opcionalmente, reconstruir caché
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('event:cache');

    return response()->json(['success' => true, 'message' => 'Cache limpiada y reconstruida correctamente.']);
})->name('clearCacheApp');

Route::middleware(['auth'])->name('admin.')->group(function () {

    // Roles
    Route::get('/admin/roles', [PermissionController::class, 'indexRoles'])
        ->middleware('can:admin.roles.index')
        ->name('roles.index');

    // crear roles
    Route::post('/admin/roles/create', [PermissionController::class, 'createRole'])
        ->middleware('can:admin.roles.create')
        ->name('roles.create');

    // store
    Route::post('/admin/roles/store', [PermissionController::class, 'storeRole'])
        ->middleware('can:admin.roles.create')
        ->name('roles.store');

    // Editar roles
    Route::get('/admin/roles/edit/{id}', [PermissionController::class, 'editRole'])
        ->middleware('can:admin.roles.update')
        ->name('roles.edit');

    // Actualizar roles
    Route::put('/admin/roles/update/{id}', [PermissionController::class, 'updateRole'])
        ->middleware('can:admin.roles.update')
        ->name('roles.update');
    
    // Eliminar roles
    Route::delete('/admin/roles/destroy/{id}', [PermissionController::class, 'destroyRole'])
        ->middleware('can:admin.roles.destroy')
        ->name('roles.destroy');

    // Permisos
    Route::post('/admin/permissions/store', [PermissionController::class, 'storePermission'])
        ->middleware('can:admin.roles.index')
        ->name('permissions.store');
    
    // Asignar permisos a roles
    Route::get('/admin/roles/{roleId}/permissions', [PermissionController::class, 'assignRolePermissions'])
        ->name('permissions.assignRolePermissions');
    Route::put('/admin/roles/{roleId}/permissions', [PermissionController::class, 'updateRolePermissions'])
        ->name('permissions.updateRolePermissions');

    // Asignar permisos a usuarios
    Route::get('/admin/users/{userId}/permissions', [PermissionController::class, 'assignUserPermissions'])
        ->name('permissions.assignUserPermissions');
    Route::put('/admin/users/{userId}/permissions', [PermissionController::class, 'updateUserPermissions'])
        ->name('permissions.updateUserPermissions');
});

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Citas
    Route::get('/admin/citas', [App\Http\Controllers\CitasController::class, 'index'])
        ->middleware('can:admin.citas.index')
        ->name('citas.index');

    Route::get('/admin/citas/edit/{id}', [App\Http\Controllers\CitasController::class, 'edit'])
        ->middleware('can:admin.citas.update')
        ->name('citas.edit');

    Route::get('/admin/citas/{id}', [App\Http\Controllers\CitasController::class, 'showApi'])
        ->name('citas.showApi');

    Route::get('/admin/citas/create', [App\Http\Controllers\CitasController::class, 'create'])
        ->middleware('can:admin.citas.create')
        ->name('citas.create');

    Route::post('/admin/citas/store', [App\Http\Controllers\CitasController::class, 'store'])
        ->middleware('can:admin.citas.create')
        ->name('citas.store');

    Route::put('/admin/citas/update/{id}', [App\Http\Controllers\CitasController::class, 'update'])
        ->middleware('can:admin.citas.update')
        ->name('citas.update');

    Route::delete('/admin/citas/destroy/{id}', [App\Http\Controllers\CitasController::class, 'destroy'])
        ->middleware('can:admin.citas.destroy')
        ->name('citas.destroy');
});
 
// Clientes
Route::middleware(['auth'])->name('admin.')->group(function () {

    // Clientes
    Route::get('/admin/clientes', [App\Http\Controllers\ClientesController::class, 'index'])
        ->middleware('can:admin.clientes.index')
        ->name('clientes.index');

    Route::get('/admin/clientes/edit/{id}', [App\Http\Controllers\ClientesController::class, 'edit'])
        ->middleware('can:admin.clientes.update')
        ->name('clientes.edit');
        
    Route::get('/admin/clientes/showApi/{id}', [App\Http\Controllers\ClientesController::class, 'showApi'])
        ->middleware('can:admin.clientes.index')
        ->name('clientes.showApi');

    Route::get('/admin/clientes/create', [App\Http\Controllers\ClientesController::class, 'create'])
        ->middleware('can:admin.clientes.create')
        ->name('clientes.create');

    Route::post('/admin/clientes/store', [App\Http\Controllers\ClientesController::class, 'store'])
        ->middleware('can:admin.clientes.create')
        ->name('clientes.store');

    Route::post('/admin/clientes/storeApi', [App\Http\Controllers\ClientesController::class, 'storeApi'])
        ->middleware('can:admin.clientes.create')
        ->name('clientes.storeApi');

    Route::put('/admin/clientes/update/{id}', [App\Http\Controllers\ClientesController::class, 'update'])
        ->middleware('can:admin.clientes.update')
        ->name('clientes.update');

    Route::delete('/admin/clientes/destroy/{id}', [App\Http\Controllers\ClientesController::class, 'destroy'])
        ->middleware('can:admin.clientes.destroy')
        ->name('clientes.destroy');

    Route::get('/admin/clientes/getClientes', [App\Http\Controllers\ClientesController::class, 'getClientes'])
        ->name('clientes.getClientes');

    Route::get('/admin/clientes/validate-cif', [App\Http\Controllers\ClientesController::class, 'verifyCif'])
        ->name('clientes.verifyCif');

    Route::POST('/admin/clientes/{id}/historial', [App\Http\Controllers\ClientesController::class, 'historialCliente'])
        ->name('clientes.historialCliente');

    // Importador de clientes
    Route::post('/clientes/import', [App\Http\Controllers\ClientesController::class, 'import'])
        ->middleware('can:admin.clientes.import')
        ->name('clientes.import');

    // Tipos de clientes
    Route::get('/admin/tiposclientes', [App\Http\Controllers\TipoClientesController::class, 'index'])
        ->middleware('can:admin.tipo-clientes.index')
        ->name('tipo-clientes.index');

    Route::post('/admin/tiposclientes/store', [App\Http\Controllers\TipoClientesController::class, 'store'])
        ->middleware('can:admin.tipo-clientes.create')
        ->name('tiposclientes.store');

    Route::put('/admin/tiposclientes/edit/{id}', [App\Http\Controllers\TipoClientesController::class, 'edit'])
        ->middleware('can:admin.tipo-clientes.update')
        ->name('tiposclientes.edit');

    // Ciudades
    Route::get('/admin/cities', [App\Http\Controllers\CiudadesController::class, 'index'])
        ->middleware('can:admin.ciudades.index')
        ->name('ciudades.index');

    Route::post('/admin/cities/store', [App\Http\Controllers\CiudadesController::class, 'store'])
        ->middleware('can:admin.ciudades.create')
        ->name('ciudades.store');

    Route::put('/admin/cities/edit/{id}', [App\Http\Controllers\CiudadesController::class, 'edit'])
        ->middleware('can:admin.ciudades.update')
        ->name('ciudades.update');

    // Bancos
    Route::get('/admin/banks', [App\Http\Controllers\BancosController::class, 'index'])
        ->middleware('can:admin.bancos.index')
        ->name('bancos.index');

    Route::post('/admin/bancos/store', [App\Http\Controllers\BancosController::class, 'store'])
        ->middleware('can:admin.bancos.create')
        ->name('bancos.store');

    Route::put('/admin/bancos/edit/{id}', [App\Http\Controllers\BancosController::class, 'edit'])
        ->middleware('can:admin.bancos.update')
        ->name('bancos.update');

    Route::get('/admin/bancos/details/{id}', [App\Http\Controllers\BancosController::class, 'details'])
    ->middleware('can:admin.bancos.index')
        ->name('bancos.details');

    Route::post('/admin/bancos/importar', [App\Http\Controllers\BancosController::class, 'importXML'])
        ->name('bancos.import');

    Route::post('/admin/bancos/storeApi', [App\Http\Controllers\BancosController::class, 'storeApi'])
        ->name('bancos.storeApi');

    Route::post('/admin/users/storeApi', [App\Http\Controllers\UsersController::class, 'storeApi'])
        ->name('banco.storeApiUsers');

    Route::get('/admin/users/validate-email', [App\Http\Controllers\UsersController::class, 'validateEmailUser'])
        ->name('banco.validateEmail');
});

// Trabajos

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Trabajos
    Route::get('/admin/trabajos', [App\Http\Controllers\TrabajosController::class, 'index'])
        ->middleware('can:admin.trabajos.index')
        ->name('trabajos.index');

    Route::get('/admin/trabajos/edit/{id}', [App\Http\Controllers\TrabajosController::class, 'edit'])
        ->middleware('can:admin.trabajos.update')
        ->name('trabajos.edit');

    Route::get('/admin/trabajos/create', [App\Http\Controllers\TrabajosController::class, 'create'])
        ->middleware('can:admin.trabajos.create')
        ->name('trabajos.create');

    Route::post('/admin/trabajos/store', [App\Http\Controllers\TrabajosController::class, 'store'])
        ->middleware('can:admin.trabajos.create')
        ->name('trabajos.store');

    Route::put('/admin/trabajos/update/{id}', [App\Http\Controllers\TrabajosController::class, 'update'])
        ->middleware('can:admin.trabajos.update')
        ->name('trabajos.update');

    Route::delete('/admin/trabajos/destroy/{id}', [App\Http\Controllers\TrabajosController::class, 'destroy'])
        ->middleware('can:admin.trabajos.destroy')
        ->name('trabajos.destroy');
});

// Operarios

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Operarios
    Route::get('/admin/operarios', [App\Http\Controllers\OperariosController::class, 'index'])
        ->middleware('can:admin.operarios.index')
        ->name('operarios.index');

    Route::get('/admin/operarios/edit/{id}', [App\Http\Controllers\OperariosController::class, 'edit'])
        ->middleware('can:admin.operarios.update')
        ->name('operarios.edit');

    Route::get('/admin/operarios/skills', [App\Http\Controllers\OperariosController::class, 'getSkills'])
        ->middleware('can:admin.operarios.view_skills')
        ->name('operarios.getskills');

    Route::post('/admin/operarios/store', [App\Http\Controllers\OperariosController::class, 'store'])
        ->middleware('can:admin.operarios.create')
        ->name('operarios.store');

    Route::put('/admin/operarios/update/{id}', [App\Http\Controllers\OperariosController::class, 'update'])
        ->middleware('can:admin.operarios.update')
        ->name('operarios.update');

    Route::delete('/admin/operarios/destroy/{id}', [App\Http\Controllers\OperariosController::class, 'destroy'])
        ->middleware('can:admin.operarios.destroy')
        ->name('operarios.destroy');

    Route::get('/admin/operario/{id}/calendar', [App\Http\Controllers\GoogleCalendarController::class, 'listEvents'])
        ->middleware('can:admin.operarios.view_calendar')
        ->name('operario.calendar');
});

// ordenes de trabajo

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Órdenes de Trabajo
    Route::get('/admin/orders', [App\Http\Controllers\OrdenesTrabajoController::class, 'index'])
        ->middleware('can:admin.ordenes.index')
        ->name('ordenes.index');

    Route::post('/admin/ordenes/showApi', [App\Http\Controllers\OrdenesTrabajoController::class, 'showApi'])
        ->middleware('can:admin.ordenes.index')
        ->name('ordenes.showApi');

    Route::get('/admin/ordenes/edit/{id}', [App\Http\Controllers\OrdenesTrabajoController::class, 'edit'])
        ->middleware('can:admin.ordenes.update')
        ->name('ordenes.edit');

    Route::get('/admin/ordenes/create', [App\Http\Controllers\OrdenesTrabajoController::class, 'create'])
        ->middleware('can:admin.ordenes.create')
        ->name('ordenes.create');

    Route::post('/admin/ordenes/store', [App\Http\Controllers\OrdenesTrabajoController::class, 'store'])
        ->middleware('can:admin.ordenes.create')
        ->name('ordenes.store');

    Route::post('/admin/ordenes/createOrderByParte', [App\Http\Controllers\OrdenesTrabajoController::class, 'createOrderByParte'])
        ->middleware('can:admin.ordenes.create')
        ->name('ordenes.createOrderByParte');

    Route::put('/admin/ordenes/update/{id}', [App\Http\Controllers\OrdenesTrabajoController::class, 'update'])
        ->middleware('can:admin.ordenes.update')
        ->name('ordenes.update');

    Route::delete('/admin/ordenes/destroy/{id}', [App\Http\Controllers\OrdenesTrabajoController::class, 'destroy'])
        ->middleware('can:admin.ordenes.destroy')
        ->name('ordenes.destroy');
});


// Proveedores

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Proveedores
    Route::get('/admin/proveedores', [App\Http\Controllers\ProveedoresController::class, 'index'])
        ->middleware('can:admin.proveedores.index')
        ->name('proveedores.index');

    Route::get('/admin/proveedores/edit/{id}', [App\Http\Controllers\ProveedoresController::class, 'edit'])
        ->middleware('can:admin.proveedores.update')
        ->name('proveedores.edit');

    Route::get('/admin/proveedores/show/{id}', [App\Http\Controllers\ProveedoresController::class, 'show'])
        ->middleware('can:admin.proveedores.index')
        ->name('proveedores.show');

    Route::get('/admin/proveedores/create', [App\Http\Controllers\ProveedoresController::class, 'create'])
        ->middleware('can:admin.proveedores.create')
        ->name('proveedores.create');

    Route::post('/admin/proveedores/store', [App\Http\Controllers\ProveedoresController::class, 'store'])
        ->middleware('can:admin.proveedores.create')
        ->name('proveedores.store');

    Route::post('/admin/proveedores/storeApi', [App\Http\Controllers\ProveedoresController::class, 'storeApi'])
        ->middleware('can:admin.proveedores.create')
        ->name('proveedores.storeApi');

    Route::put('/admin/proveedores/update/{id}', [App\Http\Controllers\ProveedoresController::class, 'update'])
        ->middleware('can:admin.proveedores.update')
        ->name('proveedores.update');

    Route::delete('/admin/proveedores/destroy/{id}', [App\Http\Controllers\ProveedoresController::class, 'destroy'])
        ->middleware('can:admin.proveedores.destroy')
        ->name('proveedores.destroy');

    Route::get('/admin/proveedores/getProveedores', [App\Http\Controllers\ProveedoresController::class, 'getProveedores'])
        ->middleware('can:admin.proveedores.index')
        ->name('proveedores.getProveedores');
});

// Empresas

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Empresas
    Route::get('/admin/empresas', [App\Http\Controllers\EmpresasController::class, 'index'])
        ->middleware('can:admin.empresas.index')
        ->name('empresas.index');

    Route::get('/admin/empresas/edit/{id}', [App\Http\Controllers\EmpresasController::class, 'edit'])
        ->middleware('can:admin.empresas.update')
        ->name('empresas.edit');

    Route::get('/admin/empresas/create', [App\Http\Controllers\EmpresasController::class, 'create'])
        ->middleware('can:admin.empresas.create')
        ->name('empresas.create');

    Route::post('/admin/empresas/store', [App\Http\Controllers\EmpresasController::class, 'store'])
        ->middleware('can:admin.empresas.create')
        ->name('empresas.store');

    Route::put('/admin/empresas/update/{id}', [App\Http\Controllers\EmpresasController::class, 'update'])
        ->middleware('can:admin.empresas.update')
        ->name('empresas.update');

    Route::post('/admin/empresas/update/logo', [App\Http\Controllers\EmpresasController::class, 'uploadLogo'])
        ->middleware('can:admin.empresas.update')
        ->name('empresas.uploadLogo');

    Route::get('/admin/empresas/{idEmpresa}/logo', [App\Http\Controllers\EmpresasController::class, 'getLatestLogo'])
        ->middleware('can:admin.empresas.index')
        ->name('admin.empresas.getLogo');

    Route::delete('/admin/empresas/destroy/{id}', [App\Http\Controllers\EmpresasController::class, 'destroy'])
        ->middleware('can:admin.empresas.destroy')
        ->name('empresas.destroy');
});

// Tipos de empresas

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Tipos de Empresas
    Route::get('/admin/tiposempresas', [App\Http\Controllers\TipoEmpresasController::class, 'index'])
        ->middleware('can:admin.tiposempresas.index')
        ->name('tipo-empresas.index');

    Route::post('/admin/tiposempresas/store', [App\Http\Controllers\TipoEmpresasController::class, 'store'])
        ->middleware('can:admin.tiposempresas.create')
        ->name('tiposempresas.store');

    Route::put('/admin/tiposempresas/update/{id}', [App\Http\Controllers\TipoEmpresasController::class, 'update'])
        ->middleware('can:admin.tiposempresas.update')
        ->name('tiposempresas.update');
});

// Compras
Route::middleware(['auth'])->name('admin.')->group(function () {
    // Listar todas las compras
    Route::get('/admin/compras', [CompraController::class, 'index'])
        ->middleware('can:admin.compras.index')
        ->name('compras.index');
    
    // Mostrar el formulario para crear una nueva compra
    Route::get('/admin/compras/create', [CompraController::class, 'create'])
        ->middleware('can:admin.compras.create')
        ->name('compras.create');
    
    // Guardar una nueva compra en la base de datos
    Route::post('/admin/compras/store', [CompraController::class, 'store'])
        ->middleware('can:admin.compras.store')
        ->name('compras.store');
    
    // Mostrar el formulario para editar una compra existente
    Route::get('/admin/compras/edit/{id}', [CompraController::class, 'edit'])
        ->middleware('can:admin.compras.edit')
        ->name('compras.edit');
    
    // Actualizar una compra existente
    Route::put('/admin/compras/update/{id}', [CompraController::class, 'update'])
        ->middleware('can:admin.compras.update')
        ->name('compras.update');
    
    // Mostrar detalles de una compra específica
    Route::get('/admin/compras/show/{id}', [CompraController::class, 'show'])
        ->middleware('can:admin.compras.show')
        ->name('compras.show');
    
    // Eliminar una compra existente
    Route::delete('/admin/compras/destroy/{id}', [CompraController::class, 'destroy'])
        ->middleware('can:admin.compras.destroy')
        ->name('compras.destroy');

    // Actualizar la suma de una compra
    Route::post('/admin/compras/store/updateSum/{id}', [CompraController::class, 'updateSum'])
        ->name('compras.updatesum');

    // Enviar mensaje a Telegram
    Route::post('/admin/compras/store/sendTelegram', [CompraController::class, 'sendTelegram'])
        ->name('compras.sendTelegram');
    
    // Obtener artículo por código
    Route::get('/admin/compras/getArticuloByCodigo', [CompraController::class, 'getArticuloByCodigo'])
        ->name('compras.getArticuloByCodigo');
});

// Lineas Compras
Route::middleware(['auth'])->name('admin.')->group(function () {
    // Listar todas las líneas de compra
    Route::get('/admin/lineas', [CompraController::class, 'indexLinea'])
        ->middleware('can:admin.compras.index')
        ->name('lineas.index');
    
    // Mostrar el formulario para crear una nueva línea de compra
    Route::get('/admin/lineas/create', [CompraController::class, 'createLinea'])
        ->middleware('can:admin.compras.index')
        ->name('lineas.create');
    
    // Guardar una nueva línea de compra en la base de datos
    Route::post('/admin/lineas/store', [CompraController::class, 'storeLinea'])
        ->middleware('can:admin.compras.index')
        ->name('lineas.store');
    
    // Mostrar el formulario para editar una línea de compra existente
    Route::get('/admin/lineas/edit/{id}', [CompraController::class, 'editLinea'])
        ->middleware('can:admin.compras.index')
        ->name('lineas.edit');
    
    // Actualizar una línea de compra existente
    Route::put('/admin/lineas/update/{id}', [CompraController::class, 'updateLinea'])
        ->middleware('can:admin.compras.index')
        ->name('lineas.update');
    
    // Mostrar detalles de una línea de compra específica
    Route::get('/admin/lineas/show/{id}', [CompraController::class, 'showLinea'])
        ->middleware('can:admin.compras.index')
        ->name('lineas.show');
    
    // Eliminar una línea de compra existente
    Route::delete('/admin/lineas/destroy/{id}', [CompraController::class, 'destroyLinea'])
        ->middleware('can:admin.compras.index')
        ->name('lineas.destroy');

    // Obtener información para almacenar una nueva línea de compra
    Route::post('/admin/lineas/getInfoToStore', [CompraController::class, 'getInfoToStore'])
        ->name('lineas.getInfoToStore');
});

// Articulos

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Listar todos los artículos
    Route::get('/admin/articulos', [App\Http\Controllers\ArticulosController::class, 'index'])
        ->middleware('can:admin.articulos.index')
        ->name('articulos.index');
    
    // Mostrar el formulario para editar un artículo existente
    Route::get('/admin/articulos/edit/{id}', [App\Http\Controllers\ArticulosController::class, 'edit'])
        ->middleware('can:admin.articulos.edit')
        ->name('articulos.edit');
    
    // Mostrar el formulario para crear un nuevo artículo
    Route::get('/admin/articulos/create', [App\Http\Controllers\ArticulosController::class, 'create'])
        ->middleware('can:admin.articulos.create')
        ->name('articulos.create');
    
    // Guardar un nuevo artículo en la base de datos
    Route::post('/admin/articulos/store', [App\Http\Controllers\ArticulosController::class, 'store'])
        ->middleware('can:admin.articulos.store')
        ->name('articulos.store');
    
    // Actualizar un artículo existente
    Route::put('/admin/articulos/update/{id}', [App\Http\Controllers\ArticulosController::class, 'update'])
        ->middleware('can:admin.articulos.update')
        ->name('articulos.update');
    
    // Eliminar un artículo existente
    Route::delete('/admin/articulos/destroy/{id}', [App\Http\Controllers\ArticulosController::class, 'destroy'])
        ->middleware('can:admin.articulos.destroy')
        ->name('articulos.destroy');
    
    // Obtener el stock de un artículo específico
    Route::get('admin/articulos/getStock/{id}', [App\Http\Controllers\ArticulosController::class, 'getStock'])
        ->name('articulos.getStock');
    
    // Ver el historial de un artículo específico
    Route::get('admin/articulos/historial/{id}', [App\Http\Controllers\ArticulosController::class, 'historial'])
        ->name('articulos.historial');

    // Ver el historial de un artículo específico
    Route::get('/admin/articulos/{id}/images', [App\Http\Controllers\ArticulosController::class, 'getImages'])
        ->name('articulos.getImages');

    Route::POST('/admin/articulos/deleteimage/{id}', [App\Http\Controllers\ArticulosController::class, 'deleteImage'])
        ->name('articulos.deleteImage');
});

// Categorias de articulos

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Listar todas las categorías de artículos
    Route::get('/admin/categorias', [App\Http\Controllers\CategoriasArticulosControler::class, 'index'])
        ->middleware('can:admin.categorias.index')
        ->name('categorias.index');
    
    // Mostrar el formulario para editar una categoría existente
    Route::get('/admin/categorias/edit/{id}', [App\Http\Controllers\CategoriasArticulosControler::class, 'edit'])
        ->middleware('can:admin.categorias.edit')
        ->name('categorias.edit');
    
    // Mostrar el formulario para crear una nueva categoría
    Route::get('/admin/categorias/create', [App\Http\Controllers\CategoriasArticulosControler::class, 'create'])
        ->middleware('can:admin.categorias.create')
        ->name('categorias.create');
    
    // Guardar una nueva categoría en la base de datos
    Route::post('/admin/categorias/store', [App\Http\Controllers\CategoriasArticulosControler::class, 'store'])
        ->middleware('can:admin.categorias.store')
        ->name('categorias.store');
    
    // Actualizar una categoría existente
    Route::put('/admin/categorias/update/{id}', [App\Http\Controllers\CategoriasArticulosControler::class, 'update'])
        ->middleware('can:admin.categorias.update')
        ->name('categorias.update');
    
    // Eliminar una categoría existente
    Route::delete('/admin/categorias/destroy/{id}', [App\Http\Controllers\CategoriasArticulosControler::class, 'destroy'])
        ->middleware('can:admin.categorias.destroy')
        ->name('categorias.destroy');
});

// Articulos Stock

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Listar todo el stock de artículos
    Route::get('/admin/stock', [App\Http\Controllers\ArticulosStockController::class, 'index'])
        ->middleware('can:admin.stock.index')
        ->name('stock.index');
    
    // Mostrar el formulario para editar el stock de un artículo
    Route::get('/admin/stock/edit/{id}', [App\Http\Controllers\ArticulosStockController::class, 'edit'])
        ->middleware('can:admin.stock.edit')
        ->name('stock.edit');
    
    // Mostrar el formulario para crear un nuevo stock de artículo
    Route::get('/admin/stock/create', [App\Http\Controllers\ArticulosStockController::class, 'create'])
        ->middleware('can:admin.stock.create')
        ->name('stock.create');
    
    // Guardar un nuevo stock de artículo en la base de datos
    Route::post('/admin/stock/store', [App\Http\Controllers\ArticulosStockController::class, 'store'])
        ->middleware('can:admin.stock.store')
        ->name('stock.store');
    
    // Actualizar el stock de un artículo
    Route::put('/admin/stock/update/{id}', [App\Http\Controllers\ArticulosStockController::class, 'update'])
        ->middleware('can:admin.stock.update')
        ->name('stock.update');
    
    // Eliminar el stock de un artículo
    Route::delete('/admin/stock/destroy/{id}', [App\Http\Controllers\ArticulosStockController::class, 'destroy'])
        ->middleware('can:admin.stock.destroy')
        ->name('stock.destroy');
});

// PagosCompras

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Listar todos los pagos de compras
    Route::get('/admin/pagoscompras', [App\Http\Controllers\PagosCobrosController::class, 'index'])
        ->middleware('can:admin.pagoscompras.index')
        ->name('pagoscompras.index');
    
    // Mostrar el formulario para editar un pago de compra
    Route::get('/admin/pagoscompras/edit/{id}', [App\Http\Controllers\PagosCobrosController::class, 'edit'])
        ->middleware('can:admin.pagoscompras.edit')
        ->name('pagoscompras.edit');
    
    // Mostrar el formulario para crear un nuevo pago de compra
    Route::get('/admin/pagoscompras/create', [App\Http\Controllers\PagosCobrosController::class, 'create'])
        ->middleware('can:admin.pagoscompras.create')
        ->name('pagoscompras.create');
    
    // Guardar un nuevo pago de compra en la base de datos
    Route::post('/admin/pagoscompras/store', [App\Http\Controllers\PagosCobrosController::class, 'store'])
        ->middleware('can:admin.pagoscompras.store')
        ->name('pagoscompras.store');
    
    // Actualizar un pago de compra
    Route::put('/admin/pagoscompras/update/{id}', [App\Http\Controllers\PagosCobrosController::class, 'update'])
        ->middleware('can:admin.pagoscompras.update')
        ->name('pagoscompras.update');
    
    // Eliminar un pago de compra
    Route::delete('/admin/pagoscompras/destroy/{id}', [App\Http\Controllers\PagosCobrosController::class, 'destroy'])
        ->middleware('can:admin.pagoscompras.destroy')
        ->name('pagoscompras.destroy');
});

// Ventas

Route::middleware(['auth'])->name('admin.')->group(function () {
    // Rutas principales para gestionar ventas
    Route::get('/admin/ventas', [App\Http\Controllers\VentasController::class, 'index'])
        ->middleware('can:admin.ventas.index')
        ->name('ventas.index');

    Route::get('/admin/ventas/show/{id}', [App\Http\Controllers\VentasController::class, 'show'])
        ->middleware('can:admin.ventas.index')
        ->name('ventas.show');
        
    Route::get('/admin/ventas/edit/{id}', [App\Http\Controllers\VentasController::class, 'edit'])
        ->middleware('can:admin.ventas.edit')
        ->name('ventas.edit');

    Route::get('/admin/ventas/create', [App\Http\Controllers\VentasController::class, 'create'])
        ->middleware('can:admin.ventas.create')
        ->name('ventas.create');

    Route::post('/admin/ventas/store', [App\Http\Controllers\VentasController::class, 'store'])
        ->middleware('can:admin.ventas.store')
        ->name('ventas.store');

    Route::post('/admin/ventas/store/confirm/{id}', [App\Http\Controllers\VentasController::class, 'confirm'])
        ->middleware('can:admin.ventas.store')
        ->name('ventas.confirm');

    Route::post('/admin/ventas/update/{id}', [App\Http\Controllers\VentasController::class, 'update'])
        ->middleware('can:admin.ventas.update')
        ->name('ventas.update');

    Route::delete('/admin/ventas/destroy/{id}', [App\Http\Controllers\VentasController::class, 'destroy'])
        ->middleware('can:admin.ventas.destroy')
        ->name('ventas.destroy');

    // Generación de documentos
    Route::get('/admin/ventas/InformeClienteModelo347/{id}/{trim}/{year}/{emp}/{enviar}/{descargar}/{envdesc}', [App\Http\Controllers\VentasController::class, 'InformeModelo347'])
        ->name('ventas.InformeModelo347');

    Route::get('/admin/ventas/albaran/{id}', [App\Http\Controllers\VentasController::class, 'generateAlbaran'])
        ->name('ventas.generateAlbaran');

    Route::get('/admin/ventas/factura/{id}', [App\Http\Controllers\VentasController::class, 'generateFactura'])
        ->name('ventas.generateFactura');

    Route::get('/admin/ventas/download_factura/{id}', [App\Http\Controllers\VentasController::class, 'downloadFactura'])
        ->name('ventas.downloadFactura');

    // Rutas para gestionar las líneas de ventas
    Route::get('/admin/lineasventas', [App\Http\Controllers\VentasController::class, 'indexLineas'])
        ->middleware('can:admin.ventas.store')
        ->name('lineasventas.index');

    Route::get('/admin/lineasventas/edit/{id}', [App\Http\Controllers\VentasController::class, 'editLineas'])
        ->middleware('can:admin.ventas.store')
        ->name('lineasventas.edit');

    Route::get('/admin/lineasventas/create', [App\Http\Controllers\VentasController::class, 'createLineas'])
        ->middleware('can:admin.ventas.store')
        ->name('lineasventas.create');

    Route::post('/admin/lineasventas/store', [App\Http\Controllers\VentasController::class, 'storeLineas'])
        ->middleware('can:admin.ventas.store')
        ->name('lineasventas.store');

    Route::post('/admin/lineasventas/update/{id}', [App\Http\Controllers\VentasController::class, 'updateLineas'])
        ->middleware('can:admin.ventas.store')
        ->name('lineasventas.update');

    Route::delete('/admin/lineasventas/destroy/{id}', [App\Http\Controllers\VentasController::class, 'destroyLineas'])
        ->middleware('can:admin.ventas.store')
        ->name('lineasventas.destroy');

    // Venta de varios productos
    Route::post('/admin/ventasvarios', [App\Http\Controllers\VentasController::class, 'ventasVarias'])
        ->middleware('can:admin.ventas.store')
        ->name('ventas.ventaVarios');

    Route::get('/admin/ventas/{id}/plazos', [App\Http\Controllers\VentasController::class, 'getPlazos'])
        ->middleware('can:admin.ventas.store')
        ->name('ventas.getPlazos');

    Route::post('/api/plazos/{id}/cobros', [App\Http\Controllers\VentasController::class, 'registrarCobro'])
        ->middleware('can:admin.ventas.store')
        ->name('ventas.cobrosPlazos');

    Route::post('/api/plazos/crear/plazo', [App\Http\Controllers\VentasController::class, 'crearPlazoVenta'])
        ->middleware('can:admin.ventas.store')
        ->name('ventas.crearPlazoVenta');
});

// Proyectos

Route::middleware(['auth'])->name('admin.')->group(function () {

    // Rutas principales para gestionar proyectos
    Route::get('/admin/proyectos', 
        [App\Http\Controllers\ProjectsController::class, 'index'])
        ->middleware('can:admin.proyectos.index')
        ->name('projects.index');

    Route::get('/admin/proyectos/edit/{id}', 
        [App\Http\Controllers\ProjectsController::class, 'edit'])
        ->middleware('can:admin.proyectos.edit')
        ->name('projects.edit');

    Route::get('/admin/proyectos/create', 
        [App\Http\Controllers\ProjectsController::class, 'create'])
        ->middleware('can:admin.proyectos.create')
        ->name('projects.create');

    Route::post('/admin/proyectos/store', 
        [App\Http\Controllers\ProjectsController::class, 'store'])
        ->middleware('can:admin.proyectos.store')
        ->name('projects.store');

    Route::put('/admin/proyectos/update/{id}', 
        [App\Http\Controllers\ProjectsController::class, 'update'])
        ->middleware('can:admin.proyectos.update')
        ->name('projects.update');

    Route::delete('/admin/proyectos/destroy/{id}', 
        [App\Http\Controllers\ProjectsController::class, 'destroy'])
        ->middleware('can:admin.proyectos.destroy')
        ->name('projects.destroy');

    // Rutas para obtener partes relacionados con el proyecto
    Route::get('/admin/proyectos/{id}/partes', 
        [App\Http\Controllers\ProjectsController::class, 'getParts'])
        ->middleware('can:admin.partes.index')
        ->name('projects.getpartes');

    // Rutas para gestionar órdenes del proyecto
    Route::get('/admin/proyectos/ordenes/{id}', 
        [App\Http\Controllers\ProjectsController::class, 'getOrdenes'])
        ->middleware('can:admin.proyectos.index')
        ->name('projects.getOrdenes');

    Route::post('/admin/proyectos/addOrder', 
        [App\Http\Controllers\ProjectsController::class, 'addOrders'])
        ->middleware('can:admin.proyectos.index')
        ->name('projects.addOrders');

    Route::post('/admin/proyectos/removeOrder', 
        [App\Http\Controllers\ProjectsController::class, 'removeOrder'])
        ->middleware('can:admin.proyectos.index')
        ->name('projects.removeOrder');

    Route::get('/admin/proyectos/getAllApi', 
        [App\Http\Controllers\ProjectsController::class, 'getAllApi'])
        ->name('projects.getAllApi');
});

// Partes

Route::middleware(['auth'])->name('admin.')->group(function () {

    // Rutas principales para gestionar partes de trabajo
    Route::get('/admin/partes', 
        [App\Http\Controllers\PartesTrabajoController::class, 'index'])
        ->middleware('can:admin.partes.index')
        ->name('partes.index');

    Route::get('/admin/partes/{id}/edit', 
        [App\Http\Controllers\PartesTrabajoController::class, 'edit'])
        ->middleware('can:admin.partes.edit')
        ->name('partes.edit');

    Route::get('/admin/partes/create', 
        [App\Http\Controllers\PartesTrabajoController::class, 'create'])
        ->middleware('can:admin.partes.create')
        ->name('partes.create');

    Route::post('/admin/partes/store', 
        [App\Http\Controllers\PartesTrabajoController::class, 'store'])
        ->middleware('can:admin.partes.store')
        ->name('partes.store');

    Route::post('/admin/partes/update/{id}', 
        [App\Http\Controllers\PartesTrabajoController::class, 'update'])
        ->middleware('can:admin.partes.update')
        ->name('partes.update');

    Route::delete('/admin/partes/destroy/{id}', 
        [App\Http\Controllers\PartesTrabajoController::class, 'destroy'])
        ->middleware('can:admin.partes.destroy')
        ->name('partes.destroy');

    // Otras rutas relacionadas con los partes de trabajo
    Route::post('/admin/partes/store/updateSum', 
        [App\Http\Controllers\PartesTrabajoController::class, 'updateSum'])
        ->name('partes.updatesum');

    Route::post('/admin/partes/store/sendTelegram', 
        [App\Http\Controllers\PartesTrabajoController::class, 'sendMessageTelegramStore'])
        ->name('partes.sendTelegram');

    Route::post('/admin/partes/store/SoloUnCampo', 
        [App\Http\Controllers\PartesTrabajoController::class, 'SoloUnCampo'])
        ->name('partes.SoloUnCampo');

    Route::post('/admin/partes/informe/tiempos', 
        [App\Http\Controllers\PartesTrabajoController::class, 'generateReport'])
        ->name('partes.generateReport');

    // Rutas para generar archivos
    Route::get('/parte-trabajo/{id}/pdf', 
        [App\Http\Controllers\PartesTrabajoController::class, 'generarPdf'])
        ->name('parte.generatePartePDF');

    Route::get('/parte-trabajo/{id}/excel', 
        [App\Http\Controllers\PartesTrabajoController::class, 'generateExcel'])
        ->name('parte.generateExcel');

    Route::get('/parte-trabajo/{id}/bundle', 
        [App\Http\Controllers\ZipController::class, 'createZip'])
        ->name('parte.generateZip');

    Route::get('/proyecto/{id}/bundle', 
        [App\Http\Controllers\ZipController::class, 'createProjectZip'])
        ->name('parte.generateProjectZip');

    Route::get('/proyecto/{id}/albaran', 
        [App\Http\Controllers\VentasController::class, 'generateAlbaranProyecto'])
        ->name('parte.generateProjectAlbaran');

    // Rutas para gestionar detalles del proyecto
    Route::post('/parte/show/details/project', 
        [App\Http\Controllers\PartesTrabajoController::class, 'getProjectDetails'])
        ->name('parte.getProjectDetails');

    Route::post('/parte/show/delete/File', 
        [App\Http\Controllers\PartesTrabajoController::class, 'deletefile'])
        ->name('parte.deletefile');

    Route::post('/parte/show/updatefile/File', 
        [App\Http\Controllers\PartesTrabajoController::class, 'updatefile'])
        ->name('parte.updatefile');

    Route::get('/parte-trabajo/{id}/sell', 
        [App\Http\Controllers\VentasController::class, 'ventaRapidaParte'])
        ->name('parte.sell');

    Route::POST('/admin/partes/{id}/getInfo/Iva/Elementos', 
        [App\Http\Controllers\PartesTrabajoController::class, 'getInforIva'])
        ->name('parte.getInforIva');

    Route::POST('/admin/partes/reorderLineas', 
        [App\Http\Controllers\PartesTrabajoController::class, 'reorderLineas'])
        ->name('parte.reorderLineas');

});

// lineas partes
Route::middleware(['auth'])->name('admin.')->group(function () {

    // Rutas para gestionar líneas de partes de trabajo
    Route::get('/admin/lineaspartes', 
        [App\Http\Controllers\PartesTrabajoController::class, 'indexLineas'])
        ->middleware('can:admin.partes.store')
        ->name('lineaspartes.index');

    Route::get('/admin/lineaspartes/edit/{id}', 
        [App\Http\Controllers\PartesTrabajoController::class, 'editLineas'])
        ->middleware('can:admin.partes.store')
        ->name('lineaspartes.edit');

    Route::get('/admin/lineaspartes/create', 
        [App\Http\Controllers\PartesTrabajoController::class, 'createLineas'])
        ->middleware('can:admin.partes.store')
        ->name('lineaspartes.create');

    Route::post('/admin/lineaspartes/store', 
        [App\Http\Controllers\PartesTrabajoController::class, 'storeLineas'])
        ->middleware('can:admin.partes.store')
        ->name('lineaspartes.store');

    Route::put('/admin/lineaspartes/update/{id}', 
        [App\Http\Controllers\PartesTrabajoController::class, 'updateLineas'])
        ->middleware('can:admin.partes.store')
        ->name('lineaspartes.update');

    Route::post('/admin/lineaspartes/destroy', 
        [App\Http\Controllers\PartesTrabajoController::class, 'destroyLineas'])
        ->middleware('can:admin.partes.store')
        ->name('lineaspartes.destroy');

});

// Rutas del dashboard

Route::middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/admin/dashboard/{id}', [App\Http\Controllers\HomeController::class, 'getInfo'])->name('dashboard.getInfo');
});

// Rutas de presupuestos

Route::middleware(['auth'])->name('admin.')->group(function () {

    // Rutas para gestionar presupuestos
    Route::get('/admin/presupuestos', 
        [App\Http\Controllers\PresupuestosController::class, 'index'])
        ->name('presupuestos.index');

    Route::get('/admin/presupuestos/editCabecera/{id}', 
        [App\Http\Controllers\PresupuestosController::class, 'editCabecera'])
        ->name('presupuestos.editCabecera');

    Route::get('/admin/presupuestos/edit/{id}', 
        [App\Http\Controllers\PresupuestosController::class, 'edit'])
        ->name('presupuestos.edit');

    Route::get('/admin/presupuestos/create', 
        [App\Http\Controllers\PresupuestosController::class, 'create'])
        ->name('presupuestos.create');

    Route::post('/admin/presupuestos/store', 
        [App\Http\Controllers\PresupuestosController::class, 'store'])
        ->name('presupuestos.store');

    Route::post('/admin/presupuestos/update/{id}', 
        [App\Http\Controllers\PresupuestosController::class, 'update'])
        ->name('presupuestos.update');

    Route::post('/admin/presupuestos/updateParte/{id}', 
        [App\Http\Controllers\PresupuestosController::class, 'updateParte'])
        ->name('presupuestos.updateParte');

    Route::delete('/admin/presupuestos/destroy/{id}', 
        [App\Http\Controllers\PresupuestosController::class, 'destroy'])
        ->name('presupuestos.destroy');

    Route::get('/admin/presupuestos/{id}/partes', 
        [App\Http\Controllers\PresupuestosController::class, 'getParts'])
        ->name('presupuestos.getpartes');

    Route::post('/admin/presupuestos/store/updateSum', 
        [App\Http\Controllers\PresupuestosController::class, 'updateSum'])
        ->name('presupuestos.updatesumSum');

    Route::post('/admin/presupuestos/store/orden', 
        [App\Http\Controllers\PresupuestosController::class, 'generateOrden'])
        ->name('presupuestos.generateOrden');

    Route::get('/admin/presupuestos/generarPDF', 
        [App\Http\Controllers\PresupuestosController::class, 'generarPDF'])
        ->name('presupuestos.generarPDF');

    Route::post('/admin/presupuestos/storeParte', 
        [App\Http\Controllers\PresupuestosController::class, 'storeParte'])
        ->name('presupuestos.storeParte');

    Route::post('/admin/presupuestos/partesDestroy', 
        [App\Http\Controllers\PresupuestosController::class, 'partesDestroy'])
        ->name('presupuestos.partesDestroy');

    Route::put('/admin/presupuestos/lineasParteUpdate/{id}', 
        [App\Http\Controllers\PresupuestosController::class, 'lineasParteUpdate'])
        ->name('presupuestos.lineasParteUpdate');

    Route::post('/admin/presupuestos/lineaspartes', 
        [App\Http\Controllers\PresupuestosController::class, 'lineaspartes'])
        ->name('presupuestos.lineaspartes');

    Route::post('/admin/presupuestos/lineaspartesDestroy', 
        [App\Http\Controllers\PresupuestosController::class, 'lineaspartesDestroy'])
        ->name('presupuestos.lineaspartesDestroy');

    Route::post('/admin/presupuestos/presupuestoPartes', 
        [App\Http\Controllers\PresupuestosController::class, 'presupuestoPartes'])
        ->name('presupuestos.updatesum');

    Route::get('/admin/presupuestos/parte/{id}/edit', 
        [App\Http\Controllers\PresupuestosController::class, 'getParteInfo'])
        ->name('presupuestos.getParteInfo');

    Route::post('/admin/presupuestos/presupuestos/anexosDestroy', 
        [App\Http\Controllers\PresupuestosController::class, 'anexosDestroy'])
        ->name('presupuestos.anexosDestroy');

    Route::get('/presupuesto/{id}/pdf', 
        [App\Http\Controllers\PresupuestosController::class, 'generatePdf'])
        ->name('presupuestos.generatePdf');

    Route::post('/presupuesto/storeArticuloPresu', 
        [App\Http\Controllers\PresupuestosController::class, 'storeArticuloPresu'])
        ->name('presupuestos.storeArticuloPresu');

    Route::post('/presupuesto/updatefile', 
        [App\Http\Controllers\PresupuestosController::class, 'updatefile'])
        ->name('presupuestos.updatefile');

    Route::get('/presupuesto/getStock/{id}', 
        [App\Http\Controllers\PresupuestosController::class, 'getStock'])
        ->name('presupuestos.getStock');

});

Route::middleware(['auth'])->name('admin.')->group(function () {

    // Rutas para gestionar líneas de presupuestos
    Route::get('/admin/lineaspresupuestos', 
        [App\Http\Controllers\PresupuestosController::class, 'indexLineas'])
        ->name('lineaspresupuestos.index');

    Route::get('/admin/lineaspresupuestos/edit/{id}', 
        [App\Http\Controllers\PresupuestosController::class, 'editLineas'])
        ->name('lineaspresupuestos.edit');

    Route::get('/admin/lineaspresupuestos/create', 
        [App\Http\Controllers\PresupuestosController::class, 'createLineas'])
        ->name('lineaspresupuestos.create');

    Route::post('/admin/lineaspresupuestos/store', 
        [App\Http\Controllers\PresupuestosController::class, 'storeLineas'])
        ->name('lineaspresupuestos.store');

    Route::put('/admin/lineaspresupuestos/update/{id}', 
        [App\Http\Controllers\PresupuestosController::class, 'updateLineas'])
        ->name('lineaspresupuestos.update');

    Route::delete('/admin/lineaspresupuestos/destroy/{id}', 
        [App\Http\Controllers\PresupuestosController::class, 'destroyLineas'])
        ->name('lineaspresupuestos.destroy');

});



// Taspasos

Route::middleware(['auth'])->name('admin.')->group(function () {

    // Rutas para gestionar traspasos
    Route::get('/admin/traspasos', 
        [App\Http\Controllers\TraspasosController::class, 'index'])
        ->name('traspasos.index');

    Route::get('/admin/traspasos/edit/{id}', 
        [App\Http\Controllers\TraspasosController::class, 'edit'])
        ->name('traspasos.edit');

    Route::get('/admin/traspasos/create', 
        [App\Http\Controllers\TraspasosController::class, 'create'])
        ->name('traspasos.create');

    Route::post('/admin/traspasos/store', 
        [App\Http\Controllers\TraspasosController::class, 'store'])
        ->name('traspasos.store');

    Route::put('/admin/traspasos/update/{id}', 
        [App\Http\Controllers\TraspasosController::class, 'update'])
        ->name('traspasos.update');

    Route::delete('/admin/traspasos/destroy/{id}', 
        [App\Http\Controllers\TraspasosController::class, 'destroy'])
        ->name('traspasos.destroy');

    // Generar ticket PDF para traspasos
    Route::post('/admin/traspasos/generarPDF/{id}', 
        [App\Http\Controllers\TraspasosController::class, 'ticketPDF'])
        ->name('traspasos.generarPDF');

});

Route::get('google/redirect', [App\Http\Controllers\GoogleCalendarController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('google/callback', [App\Http\Controllers\GoogleCalendarController::class, 'handleGoogleCallback']);

// GEOLOCALIZACION

Route::middleware(['auth'])->name('admin.')->group(function () {

    // Rutas para gestionar geolocalización
    Route::get('/admin/geolocalizacion', 
        [App\Http\Controllers\GeolocalizacionController::class, 'index'])
        ->name('geolocalizacion.index');

    Route::get('/admin/geolocalizacion/edit/{id}', 
        [App\Http\Controllers\GeolocalizacionController::class, 'edit'])
        ->name('geolocalizacion.edit');

    Route::get('/admin/geolocalizacion/create', 
        [App\Http\Controllers\GeolocalizacionController::class, 'create'])
        ->name('geolocalizacion.create');

    Route::post('/admin/geolocalizacion/store', 
        [App\Http\Controllers\GeolocalizacionController::class, 'store'])
        ->name('geolocalizacion.store');

    Route::put('/admin/geolocalizacion/update/{id}', 
        [App\Http\Controllers\GeolocalizacionController::class, 'update'])
        ->name('geolocalizacion.update');

    Route::delete('/admin/geolocalizacion/destroy/{id}', 
        [App\Http\Controllers\GeolocalizacionController::class, 'destroy'])
        ->name('geolocalizacion.destroy');

});

// Ruta de prueba PushNotification

Route::middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/admin/push', [App\Http\Controllers\AuthController::class, 'index'])->name('push.index');
    Route::get('/admin/push/send', [App\Http\Controllers\AuthController::class, 'send'])->name('push.send');
});

// Salarios

Route::middleware(['auth'])->name('admin.')->group(function () {

    // Rutas para gestionar salarios
    Route::get('/admin/salarios', 
        [App\Http\Controllers\SalariosController::class, 'index'])
        ->middleware('can:admin.salarios.index')
        ->name('salarios.index');

    Route::get('/admin/salarios/edit/{id}', 
        [App\Http\Controllers\SalariosController::class, 'edit'])
        ->middleware('can:admin.salarios.index')
        ->name('salarios.edit');

    Route::get('/admin/salarios/create', 
        [App\Http\Controllers\SalariosController::class, 'create'])
        ->middleware('can:admin.salarios.index')
        ->name('salarios.create');

    Route::post('/admin/salarios/store', 
        [App\Http\Controllers\SalariosController::class, 'store'])
        ->middleware('can:admin.salarios.index')
        ->name('salarios.store');

    Route::put('/admin/salarios/update/{id}', 
        [App\Http\Controllers\SalariosController::class, 'update'])
        ->middleware('can:admin.salarios.index')
        ->name('salarios.update');

    Route::delete('/admin/salarios/destroy/{id}', 
        [App\Http\Controllers\SalariosController::class, 'destroy'])
        ->name('salarios.destroy');

});

// Desplazamientos

Route::middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/admin/desplazamientos', [App\Http\Controllers\DesplazamientosController::class, 'index'])->name('desplazamientos.index');
    Route::get('/admin/desplazamientos/edit/{id}', [App\Http\Controllers\DesplazamientosController::class, 'edit'])->name('desplazamientos.edit');
    Route::get('/admin/desplazamientos/create', [App\Http\Controllers\DesplazamientosController::class, 'create'])->name('desplazamientos.create');
    Route::post('/admin/desplazamientos/store', [App\Http\Controllers\DesplazamientosController::class, 'store'])->name('desplazamientos.store');
    Route::PUT('/admin/desplazamientos/update/{id}', [App\Http\Controllers\DesplazamientosController::class, 'update'])->name('desplazamientos.update');
    Route::delete('/admin/desplazamientos/destroy/{id}', [App\Http\Controllers\DesplazamientosController::class, 'destroy'])->name('desplazamientos.destroy');
});

// Rutas de la configuración de la aplicación admin/configApp

Route::middleware(['auth'])->name('admin.')->group(function () {

    // Rutas para gestionar la configuración de la aplicación
    Route::get('/admin/configApp', 
        [App\Http\Controllers\ConfigAppController::class, 'index'])
        ->middleware('can:admin.configApp.index')
        ->name('configApp.index');

    Route::get('/admin/configApp/edit/{id}', 
        [App\Http\Controllers\ConfigAppController::class, 'edit'])
        ->middleware('can:admin.configApp.index')
        ->name('configApp.edit');

    Route::get('/admin/configApp/create', 
        [App\Http\Controllers\ConfigAppController::class, 'create'])
        ->middleware('can:admin.configApp.index')
        ->name('configApp.create');

    Route::post('/admin/configApp/store', 
        [App\Http\Controllers\ConfigAppController::class, 'store'])
        ->middleware('can:admin.configApp.index')
        ->name('configApp.store');

    Route::put('/admin/configApp/update/{id}', 
        [App\Http\Controllers\ConfigAppController::class, 'update'])
        ->middleware('can:admin.configApp.index')
        ->name('configApp.update');

    Route::delete('/admin/configApp/destroy/{id}', 
        [App\Http\Controllers\ConfigAppController::class, 'destroy'])
        ->middleware('can:admin.configApp.index')
        ->name('configApp.destroy');

    // Rutas para obtener y guardar la configuración
    Route::post('admin/config/getConfig', 
        [App\Http\Controllers\ConfigAppController::class, 'getConfig'])
        ->name('configApp.getCongif');

    Route::post('admin/config/saveConfig', 
        [App\Http\Controllers\ConfigAppController::class, 'saveConfig'])
        ->name('configApp.saveConfig');

    Route::post('admin/config/Import/Old/Files', 
        [App\Http\Controllers\ConfigAppController::class, 'ImportComprasVentas'])
        ->name('configApp.ImportComprasVentas');

    Route::get('admin/config/Download/Format/ToImport', 
        [App\Http\Controllers\ConfigAppController::class, 'downloadFormat'])
        ->name('configApp.downloadFormat');

    Route::get('admin/config/Check/Session/Active', 
        [App\Http\Controllers\ConfigAppController::class, 'checkSession'])
        ->name('configApp.checkSession');

});

// Rutas para las estadiasticas admin/analytics

Route::middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/admin/analytics', [App\Http\Controllers\AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/admin/analytics/getData', [App\Http\Controllers\AnalyticsController::class, 'getData'])->name('analytics.getData');
    Route::post('/admin/analytics/resumen', [App\Http\Controllers\AnalyticsController::class, 'obtenerResumen'])->name('estadisticas.resumen');
    Route::post('/admin/analytics/resumendetails', [App\Http\Controllers\AnalyticsController::class, 'resumendetails'])->name('estadisticas.resumendetails');
});

// rutas para admin/bakups
Route::middleware(['auth'])->name('admin.')->group(function (){
    Route::get('admin/backups',
        [App\Http\Controllers\BackupController::class, 'index'])
        ->middleware('can:admin.backups.index')
        ->name('backups.index');

    Route::get('admin/backups/generate',
        [App\Http\Controllers\BackupController::class, 'generate'])
        ->middleware('can:admin.backups.index')
        ->name('backups.generate');

    // Importar base de datos
    Route::post('admin/backups/import',
        [App\Http\Controllers\BackupController::class, 'importSQL'])
        ->middleware('can:admin.backups.index')
        ->name('backups.import');

});

// Rutas para modelo 347
Route::middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/modelo347', [Modelo347Controller::class, 'index'])->name('modelo347.index');
    Route::post('/modelo347/actualizar-limite', [Modelo347Controller::class, 'actualizarLimite'])->name('modelo347.actualizarLimite');
    Route::post('/modelo347/exportar', [Modelo347Controller::class, 'exportarExcel'])->name('modelo347.exportarExcel');
    Route::get('descargar-pdf/{idParteTrabajo}', [Modelo347Controller::class, 'descargarPdf'])->name('modelo347.descargarPdf')->middleware('signed');
});


// admin/file-manager

Route::middleware(['auth'])->name('admin.')->group(function(){
    Route::get('admin/file-manager/{path?}/{laravelApp?}', [App\Http\Controllers\FileManagerController::class, 'index'])->name('filemanager.index');
    Route::post('admin/file-manager/upload', [App\Http\Controllers\FileManagerController::class, 'upload'])->name('filemanager.upload');
    Route::delete('admin/file-manager/delete/{filename?}', [App\Http\Controllers\FileManagerController::class, 'delete'])->name('filemanager.delete');
    Route::delete('admin/file-manager/deleteFolder/{filename?}', [App\Http\Controllers\FileManagerController::class, 'deleteFolder'])->name('filemanager.deleteFolder');
    Route::post('admin/file-manager/create-directory', [App\Http\Controllers\FileManagerController::class, 'createDirectory'])->name('filemanager.create-directory');
    Route::get('admin/file-manager/download/file', [App\Http\Controllers\FileManagerController::class, 'download'])->name('filemanager.download');
    Route::get('admin/file-manager/edit/file/MilecoApp', [App\Http\Controllers\FileManagerController::class, 'edit'])->name('filemanager.edit');
    Route::post('admin/file-manager/save/{folder}/{file}', [App\Http\Controllers\FileManagerController::class, 'save'])->name('filemanager.save');
});