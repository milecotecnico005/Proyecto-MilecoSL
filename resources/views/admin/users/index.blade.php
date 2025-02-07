@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')

    <style>
        #tableCard {
            background: rgba( 255, 255, 255, 0.7 );
            box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
            backdrop-filter: blur( 8.5px );
            -webkit-backdrop-filter: blur( 8.5px );
            border-radius: 10px;
            border: 1px solid rgba( 255, 255, 255, 0.18 );
            margin-top: 10px;
        }

        .backgroundImage{
            position: fixed;
            top: -383px;
            right: 0;
            width: 300px;
            height: 100%;
            z-index: 0;
            opacity: 1;
            transform: rotate(-25deg);
        }
    </style>

    <style>
        .form-check-label {
            word-wrap: break-word;
            display: block;
            margin-top: 1px;
            padding-left: 1px;
        }
    </style>

    <div id="tableCard" class="card">
        <div class="card-body">
            <table class="table table-striped" id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($AllUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ ($user->userState == 1) ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                @component('components.actions-button')
                                    <a 
                                        data-userId="{{ $user->id }}" 
                                        class="btn btn-primary modalEditUsers"
                                        type="button"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Editar usuario"
                                        >
                                        <ion-icon name="create-outline"></ion-icon>
                                    </a>
                                    <a 
                                        data-userId="{{ $user->id }}" 
                                        class="btn btn-primary updatePassword"
                                        type="button"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Actualizar contraseña"
                                        >
                                        <ion-icon name="key-outline"></ion-icon>
                                    </a>
                                    {{-- asignar permisos al usuario --}}
                                    <button
                                        class="btn btn-primary addPermisosUser"
                                        type="button"
                                        data-userId="{{ $user->id }}"
                                        data-userName="{{ $user->name }}"
                                        data-userpermissions="{{ json_encode($user->permissions->pluck('id')->toArray()) }}"
                                        data-rolepermissions="{{ json_encode($user->rolePermissions()->first()->permissions->pluck('id')->toArray()) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Asignar permisos"
                                    >
                                        <ion-icon name="build-outline"></ion-icon>
                                    </button>
                                    @php
                                        $userLoged = Auth::user()->id;
                                    @endphp
                                    @if ($userLoged != $user->id)
                                        <a 
                                            data-userId="{{ $user->id }}" 
                                            class="btn btn-warning toggleUsers"
                                            data-type="{{ ($user->userState == 1) ? 'Desactivar' : 'Activar' }}"
                                            type="button"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="{{ ($user->userState == 1) ? 'Desactivar usuario' : 'Activar usuario' }}"
                                            >
                                            <ion-icon name="{{ ($user->userState == 1) ? 'warning-outline' : 'person-outline' }}"></ion-icon>
                                        </a>
                                    @endif
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @component('components.modal-component', [
        'modalId' => 'modal',
        'modalTitle' => 'Editar usuario',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editUserTitle',
        'btnSaveId' => 'btnSaveEditUser'
    ])
        <form id="formEditUser" class="form">
            <div class="form-floating mb-3">
                <input type="hidden" name="userId" id="userIdEdit">
                <input 
                    type="text"
                    id="nameEditUser"
                    placeholder="Nombre del usuario"
                    class="form-control"
                    aria-label="Sizingexampleinput"
                    aria-describedby="inputGroup-sizing-default"
                    required
                >
                <label for="nameEditUser">Nombre</label>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="email"
                    id="emailEditUser"
                    placeholder="Email del usuario"
                    class="form-control"
                    required
                >
                <label for="emailEditUser">Correo Electronico</label>
            </div>
            <div class="form-floating mb-3">
                <select 
                    id="rolesEditUser"
                    class="form-select"
                    name="rolesEditUser"
                    required
                >
                    @foreach ($AllRoles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'modalCreateUser',
        'modalTitle' => 'Crear usuario',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'createUserTitle',
        'btnSaveId' => 'btnCreateUser'
    ])
        <form id="formCreateUser" class="form">
            <div class="form-floating mb-3">
                <input 
                    type="text"
                    id="nameCreateUser"
                    placeholder="Nombre del usuario"
                    class="form-control"
                    name="name"
                    aria-label="Sizingexampleinput"
                    aria-describedby="inputGroup-sizing-default"
                    required
                >
                <label for="nameCreateUser">Nombre</label>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="email"
                    id="emailCreateUser"
                    placeholder="Email del usuario"
                    class="form-control"
                    name="email"
                    required
                >
                <label for="emailCreateUser">Correo Electronico</label>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="password"
                    id="passwordCreateUser"
                    placeholder="Email del usuario"
                    class="form-control"
                    name="password"
                    required
                >
                <label for="passwordCreateUser">Contraseña</label>
            </div>
            <div class="mb-3">
                <label for="rolesCreateUser" class="form-label">Roles</label>
                <select 
                    id="rolesCreateUser"
                    class="form-select"
                    name="rolesCreateUser"
                    required
                >
                    @foreach ($AllRoles as $role)
                        <option value="{{ $role->id }}" {{ $role->id == 4 ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
        
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'modalUpdatePassword',
        'modalTitle' => 'Actualizar contraseña',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'updatePasswordTitle',
        'btnSaveId' => 'btnUpdatePassword'
    ])
        <form id="formUpdatePassword" class="form">
            <div class="form-floating mb-3">
                <input 
                    type="hidden"
                    id="userIdUpdatePassword"
                    name="userIdUpdatePassword"
                >
                <input 
                    type="password"
                    id="passwordUpdatePassword"
                    placeholder="Contraseña del usuario"
                    class="form-control"
                    name="passwordUpdatePassword"
                    required
                >
                <label for="passwordUpdatePassword">Contraseña</label>
            </div>
        </form>
        
    @endcomponent

    {{-- modal para asignar permisos al usuario --}}
    @component('components.modal-component', [
        'modalId' => 'modalAssignPermissions',
        'modalTitle' => 'Asignar Permisos al Usuario',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'assignPermissionsTitle',
        'btnSaveId' => 'btnAssignPermissions'
    ])
        <form id="assignPermissionsForm" method="POST">
            @csrf
            @method('PUT') <!-- Método PUT para actualizar -->
            <div class="modal-body">
                <div class="mb-3">
                    <label for="roleName" class="form-label">Nombre del Usuario</label>
                    <input type="text" class="form-control" id="userName" name="name" required readonly>
                </div>

                <!-- Contenedor de permisos con scroll, visible solo cuando sea necesario -->
                <div class="mb-3" id="permissionsContainer" style="max-height: 400px; overflow-y: auto;">
                    <label for="permissions" class="form-label">Seleccionar Permisos</label>
                    
                    <div class="row" id="permissionsContainerRow">
                        {{-- input para filtrar entre los permisos --}}
                        <div class="col-12 mb-2">
                            <input type="text" class="form-control" id="filterPermissions" placeholder="Filtrar permisos">
                        </div>

                        {{-- select all or unselect all --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="selectAllPermissions">
                                <label class="form-check" for="selectAllPermissions">
                                    Seleccionar todos
                                </label>
                            </div>
                        </div>


                        @foreach($permissions as $permission)
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                        id="permission_{{ $permission->id }}"
                                        @if(in_array($permission->id, json_decode($user->permissions->pluck('id')->toJson(), true) ?? [])) checked @endif
                                    >
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
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="btnAssignPermissions">Guardar cambios</button>
            </div>
        </form>
    @endcomponent

@stop


@section('js')
    <script>

        let table = $('#usersTable').DataTable({
            colReorder: {
                realtime: false
            },
            order: [[0, 'desc']],
            dom: "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
            "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",
            // Mostrar el selector de cantidad de entidades y establecer 50 como valor por defecto
            pageLength: 50,  // Mostrar 50 registros por defecto
            lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opciones para seleccionar cantidad de registros
            // Traducción manual al español
            language: {
                processing: "Procesando...",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros por página",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron registros coincidentes",
                emptyTable: "No hay datos disponibles en la tabla",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Último"
                },
                aria: {
                    sortAscending: ": activar para ordenar la columna en orden ascendente",
                    sortDescending: ": activar para ordenar la columna en orden descendente"
                }
            },
            buttons: [
                {
                    text: 'Crear usuario',
                    className: 'btn btn-outline-warning createUserbtn mb-2',
                    action: function ( e, dt, node, config ) {
                        $('#modalCreateUser').modal('show');
                        $('#createUserTitle').text('Crear usuario');
                        $('#nameCreateUser').val('');
                        $('#emailCreateUser').val('');
                        $('#passwordCreateUser').val('');
                        $('#rolesCreateUser').val(4);

                        // Inicializar el select2
                        $('#rolesCreateUser').select2({
                            width: '100%',
                            dropdownAutoWidth: true,
                            placeholder: 'Selecciona un rol',
                            allowClear: true,
                            dropdownParent: $('#modalCreateUser')
                        });

                    }
                }
            ]

            // responsive: true,
            // autoFill: true,
            // fixedColumns: true,
        });

        $('.createUserbtn').removeClass('dt-button');

        // Create user
        $('.createUserbtn').each(function(){
            $(this).on('click', function(e){
                e.preventDefault();
                $('#modalCreateUser').modal('show');
                $('#createUserTitle').text('Crear usuario');
                $('#nameCreateUser').val('');
                $('#emailCreateUser').val('');
                $('#passwordCreateUser').val('');
                $('#rolesCreateUser').val(4);
            });
        });

        // Save changes Create user
        $('#btnCreateUser').click(() => {
            Swal.fire({
                title: '¿Estás seguro de crear el usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, crear!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let name     = $('#nameCreateUser').val();
                    let email    = $('#emailCreateUser').val();
                    let password = $('#passwordCreateUser').val();
                    let role     = $('#rolesCreateUser').val();
                    $.ajax({
                        url: '/admin/users/store',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name,
                            email,
                            password,
                            role
                        },
                        success: function({ status, data }){
                            if(!status){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: '¡Algo salió mal! Inténtalo de nuevo.'
                                });
                                return;
                            }
                            Swal.fire({
                                icon: 'success',
                                title: '¡Creado!',
                                text: 'El usuario ha sido creado correctamente.',
                                showConfirmButton: true,
                                timer: 1500,
                                allowsOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false
                            }).then(() => {
                                $('#modalCreateUser').modal('hide');
                                location.reload();
                            });
                        },
                        error: function(error){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '¡Algo salió mal! Inténtalo de nuevo.'
                            });
                            const errorMessage = error.responseJSON.errors;
                            console.log(error);
                        }
                    });
                }
            })
        
        });

        // Update users

        table.on('click','.modalEditUsers', function(e){
            
            e.preventDefault();
            let userId   = $(this).data('userid');
            $.ajax({
                url: '/admin/users/edit/' + userId,
                method: 'GET',
                success: function({ status, data }){
                    if(!status){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Algo salió mal! Inténtalo de nuevo.'
                        });
                        return;
                    }
                    $('#modal').modal('show');
                    $('#nameEditUser').val(data.name);
                    $('#emailEditUser').val(data.email);
                    $('#userIdEdit').val(data.id);
                    $('#rolesEditUser').val(data.roleId);
                    $('#editUserTitle').text('Editar usuario: ' + data.name);
                }
            });
        });

        // Save changes Edit user

        $('#btnSaveEditUser').click(() => {
            Swal.fire({
                title: '¿Estás seguro de actualizar el usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, actualizar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let userId = $('#userIdEdit').val();
                    let name   = $('#nameEditUser').val();
                    let email  = $('#emailEditUser').val();
                    let role   = $('#rolesEditUser').val();
                    $.ajax({
                        url: '/admin/users/update/' + userId,
                        method: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name,
                            email,
                            role
                        },
                        success: function({ status, data }){
                            if(!status){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: '¡Algo salió mal! Inténtalo de nuevo.'
                                });
                                return;
                            }
                            Swal.fire({
                                icon: 'success',
                                title: '¡Actualizado!',
                                text: 'El usuario ha sido actualizado correctamente.',
                                showConfirmButton: true,
                                timer: 1500,
                                allowsOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false
                            }).then(() => {
                                $('#modal').modal('hide');
                                location.reload();
                            });
                        },
                        error: function(error){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '¡Algo salió mal! Inténtalo de nuevo.'
                            });
                            const errorMessage = error.responseJSON.errors;
                            console.log(error);
                        }
                    });
                }
            })
        });

        table.on('click', '.updatePassword', function(){
            let userId = $(this).data('userid');
            $('#modalUpdatePassword').modal('show');
            $('#userIdUpdatePassword').val(userId);
        });

        $('#btnUpdatePassword').on('click', function(){
                // validar que no esté vacio

                let password = $('#passwordUpdatePassword').val();
                let userId = $('#userIdUpdatePassword').val();

                if ( !password || !userId ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Algo salió mal! Inténtalo de nuevo.'
                    });
                    return;
                }

                $.ajax({
                    url: '/admin/users/updatePassword/' + userId,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        password,
                        userId
                    },
                    success: function({ status, data }){
                        if(!status){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '¡Algo salió mal! Inténtalo de nuevo.'
                            });
                            return;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'La contraseña ha sido actualizada correctamente.',
                            showConfirmButton: true,
                            timer: 1500,
                            allowsOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false
                        }).then(() => {
                            $('#modalUpdatePassword').modal('hide');
                            location.reload();
                        });
                    },
                    error: function(error){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Algo salió mal! Inténtalo de nuevo.'
                        });
                        const errorMessage = error.responseJSON.errors;
                        console.log(error);
                    }
                });

            })

        // Toggle user
        $('.toggleUsers').on('click', function(e){
                e.preventDefault();
                let userId = $(this).data('userid');
                let type = $(this).data('type');
                $.ajax({
                    url: '/admin/users/toggle/' + userId + '/' + type,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        type,
                        userId
                    },
                    success: function({ status, data }){
                        if(!status){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '¡Algo salió mal! Inténtalo de nuevo.'
                            });
                            return;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'El usuario ha sido actualizado correctamente.',
                            showConfirmButton: true,
                            timer: 1500,
                            allowsOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(error){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Algo salió mal! Inténtalo de nuevo.'
                        });
                        const errorMessage = error.responseJSON.errors;
                        console.log(error);
                    }
                });
            });

    </script>

    <script>
        $(document).ready(function () {
            // Cuando se hace clic en el botón "Asignar permisos"
            $('.addPermisosUser').on('click', function () {
                const userId = $(this).data('userid'); // Obtener el ID del usuario
                const userName = $(this).data('username'); // Obtener el nombre del usuario
                const userPermissions = $(this).data('userpermissions'); // Obtener los permisos del usuario
                const rolePermissions = $(this).data('rolepermissions'); // Obtener los permisos del rol

                // Desmarcar todos los permisos
                $('#permissionsContainer input[type="checkbox"]').prop('checked', false);
                
                // Marcar los permisos del usuario
                userPermissions.forEach(function(permissionId) {
                    $('#permission_' + permissionId).prop('checked', true);
                });

                // Marcar los permisos del rol
                rolePermissions.forEach(function(permissionId) {
                    $('#permission_' + permissionId).prop('checked', true);
                });
                
                // Establecer el nombre del usuario en el modal
                $('#userName').val(userName);

                // Mostrar el modal
                $('#modalAssignPermissions').modal('show');


                // cambiar el form para asignarle la accion
                $('#assignPermissionsForm').attr('action', `/admin/users/${userId}/permissions`);

                // filtrar los permisos
                $('#filterPermissions').off('keyup').on('keyup', function() {
                    let value = $(this).val().toLowerCase();
                    $('#permissionsContainerRow .form-check').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });

                // Seleccionar todos los permisos o deseleccionar todos
                $('#selectAllPermissions').off('change').on('change', function() {
                    let checked = $(this).prop('checked');
                    $('#permissionsContainer input[type="checkbox"]').prop('checked', checked);
                });

            });
        });
    </script>

@stop