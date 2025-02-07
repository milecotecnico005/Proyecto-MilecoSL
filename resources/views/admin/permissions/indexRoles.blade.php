@extends('adminlte::page')

@section('title', 'Roles')

@section('content')

<style>
    .form-check-label {
        word-wrap: break-word;
        display: block;
        margin-top: 1px;
        padding-left: 1px;
    }
</style>

<div class="card" id="tableCard">
    <div class="card-body">
        <h1>Roles</h1>
        
        <!-- Botón para abrir el modal de creación de rol -->
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#roleModal" data-action="create">Crear Rol</button>
        <button class="btn btn-outline-primary createPermiso">Crear permiso</button>
        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @component('components.actions-button')
                                <!-- Botón para editar rol -->
                                <button class="btn btn-warning" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#roleModal"
                                        data-action="edit"
                                        data-role-id="{{ $role->id }}"
                                        data-role-name="{{ $role->name }}"
                                        data-role-permissions="{{ json_encode($role->permissions->pluck('id')->toArray()) }}"
                                >Editar</button>

                                <!-- Botón para asignar permisos -->
                                <button class="btn btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#roleModal"
                                        data-action="permissions"
                                        data-role-id="{{ $role->id }}"
                                        data-role-name="{{ $role->name }}"
                                        data-role-permissions="{{ json_encode($role->permissions->pluck('id')->toArray()) }}"
                                >Permisos</button>

                                <!-- Formulario para eliminar rol -->
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            @endcomponent
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

{{-- Modal único para crear, editar y asignar permisos a los roles --}}
@component('components.modal-component', [
    'modalId' => 'roleModal',
    'modalSize' => 'modal-lg',
    'modalTitleId' => 'roleModalLabel',
    'btnSaveId' => 'btnSaveRole',
    'modalTitle' => 'Crear Rol',
])

    <form id="roleForm" action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="roleName" class="form-label">Nombre del Rol</label>
                <input type="text" class="form-control" id="roleName" name="name" required>
            </div>

            <!-- Contenedor de permisos con scroll, visible solo cuando sea necesario -->
            <div class="mb-3" id="permissionsContainer" style="display:none; max-height: 400px; overflow-y: auto;">
                <label for="permissions" class="form-label">Seleccionar Permisos</label>
                
                <div class="row" id="permissionsContainerRow">
                    {{-- input para filtrar entre los permisos --}}
                    <div class="col-12">
                        <input type="text" class="form-control d-none" id="filterPermissions" placeholder="Filtrar permisos">
                    </div>
                    @foreach($permissions as $permission)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                       id="permission_{{ $permission->id }}"
                                       @if(in_array($permission->id, json_decode($role->permissions->pluck('id')->toJson(), true) ?? [])) checked @endif
                                >
                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        @php
                                            $permissionName = explode('.', $permission->name);
                                            
                                            if (count($permissionName) > 1) {
                                                // Obtener los 2 últimos elementos del array
                                                $permissionModule = $permissionName[count($permissionName) - 2];
                                                $permissionAction = $permissionName[count($permissionName) - 1];
    
                                                // traducir el nombre del permiso
                                                $permissionModule = __('' . $permissionModule);
                                                $permissionAction = __('' . $permissionAction);

                                                switch ($permissionAction) {
                                                    case 'index':
                                                        $permissionAction = 'Inicio';
                                                        break;
                                                    case 'create':
                                                        $permissionAction = 'Crear';
                                                        break;
                                                    case 'edit':
                                                        $permissionAction = 'Editar';
                                                        break;
                                                    case 'delete':
                                                        $permissionAction = 'Eliminar';
                                                        break;
                                                    case 'view':
                                                        $permissionAction = 'Ver';
                                                        break;
                                                    case 'destroy':
                                                        $permissionAction = 'Eliminar';
                                                        break;
                                                    case 'store':
                                                        $permissionAction = 'Guardar';
                                                        break;
                                                    case 'update':
                                                        $permissionAction = 'Actualizar';
                                                        break;
                                                    case 'show':
                                                        $permissionAction = 'Mostrar';
                                                        break;
                                                    case 'assign':
                                                        $permissionAction = 'Asignar';
                                                        break;
                                                    case 'detach':
                                                        $permissionAction = 'Desasignar';
                                                        break;
                                                    default:
                                                        $permissionAction = $permissionAction;
                                                        break;
                                                }
    
                                                // Concatenar el nombre del módulo y la acción
                                                $permissionName = $permissionModule . ' - ' . $permissionAction;
                                            }else{
                                                $permissionName = __('' . $permission->name);
                                            }

                                        @endphp
                                        {{ $permissionName }}
                                    </label>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>

@endcomponent

@component('components.modal-component', [
    'modalId' => 'permisoModal',
    'modalSize' => 'modal-lg',
    'modalTitleId' => 'permisoModalLabel',
    'btnSaveId' => 'btnSavePermiso',
    'modalTitle' => 'Crear Permiso',
])

    <form id="permisoForm" action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="permisoName" class="form-label">Nombre del Permiso</label>
                <input type="text" class="form-control" id="permisoName" name="name" required>
            </div>
        </div>
    </form>

@endcomponent
    

@endsection

@section('js')

{{-- Eventos success, error, update de swal --}}
<script>
    @if(session('success'))
        Swal.fire(
            '¡Éxito!',
            '{{ session('success') }}',
            'success'
        );
    @elseif(session('error'))
        Swal.fire(
            '¡Error!',
            '{{ session('error') }}',
            'error'
        );
    @elseif(session('update'))
        Swal.fire(
            '¡Actualizado!',
            '{{ session('update') }}',
            'success'
        );
    @endif
</script>

<script>
    // Cuando se abre el modal, ajustar el contenido según la acción seleccionada
    $('#roleModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Botón que abrió el modal
        let action = button.data('action'); // Acción (crear, editar, permisos)
        let roleId = button.data('role-id'); // ID del rol
        let roleName = button.data('role-name'); // Nombre del rol
        let rolePermissions = button.data('role-permissions'); // Permisos del rol
        
        // Establecer el título y el formulario según la acción
        let modal = $(this);
        modal.find('.modal-title').text(action.charAt(0).toUpperCase() + action.slice(1) + ' Rol');
        
        // Si es edición o asignación de permisos, establecer los valores correspondientes
        if (action === 'edit' || action === 'permissions') {
            
            // desmarcar todos los permisos
            modal.find('input[name="permissions[]"]').prop('checked', false);

            modal.find('#roleName').val(roleName);
            modal.find('#permissionsContainer').show(); // Mostrar contenedor de permisos
            // Marcar permisos del rol
            rolePermissions.forEach(function(permissionId) {
                modal.find('#permission_' + permissionId).prop('checked', true);
            });
            modal.find('#roleForm').attr('action', '/admin/roles/update/' + roleId); // Ajustar acción del formulario
            
            modal.find('#roleForm').append('<input type="hidden" name="_method" value="PUT">');

            // mostrar el input de filtrar permisos
            modal.find('#filterPermissions').removeClass('d-none');
            // filtrar los permisos
            $('#filterPermissions').on('keyup', function() {
                let value = $(this).val().toLowerCase();
                $('#permissionsContainerRow .form-check').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

        } else {
            modal.find('#roleName').val(''); // Limpiar campo de nombre para creación
            modal.find('#permissionsContainer').hide(); // Ocultar contenedor de permisos
            modal.find('#roleForm').attr('action', '/admin/roles/store'); // Ajustar acción del formulario
            modal.find('#roleForm input[name="_method"]').remove(); // Eliminar input _method
            modal.find('#filterPermissions').addClass('d-none'); // Ocultar input de filtrar permisos
        }

        // evento para el botón de guardar
        $('#btnSaveRole').on('click', function() {
            $('#roleForm').submit();
        });

    });

    // evento para crear un permiso
    $('.createPermiso').on('click', function() {
        $('#permisoModal').modal('show');

        $('#btnSavePermiso').on('click', function() {
            $('#permisoForm').submit();
        });

    });

</script>

@endsection
