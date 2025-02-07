

@extends('adminlte::page')

@section('title', 'Operarios')

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

    <div id="tableCard" class="card">
        @php
            $tokenValido = app('App\Http\Controllers\GoogleCalendarController')->checkGoogleToken();
        @endphp
        <div class="card-body">
            <table class="table table-striped" id="OperariosTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Operarios as $Operario)
                    @php
                        $habilidades = '';
                        foreach ($Operario->trabajos as $habilidad) {
                            $habilidades .= $habilidad->idTrabajo . ', ';
                        }
                        $Operario->habilidades = rtrim($habilidades, ', ');
                    @endphp
                        <tr>
                            <td>{{ $Operario->idOperario }}</td>
                            <td>{{ $Operario->nameOperario }}</td>
                            <td>{{ $Operario->emailOperario }}</td>
                            <td>{{ $Operario->telefonoOperario }}</td>
                            <td>
                                @component('components.actions-button')
                                    <button
                                        type="button"
                                        class="btn btn-primary modalEditOperarios"
                                        data-name="{{ $Operario->nameOperario }}"
                                        data-email="{{ $Operario->emailOperario }}"
                                        data-telefono="{{ $Operario->telefonoOperario }}"
                                        data-habilidades="{{ $Operario->habilidades }}"
                                        data-operarioid="{{ $Operario->idOperario }}"
                                    >
                                        <ion-icon name="create-outline"></ion-icon>
                                    </button>
                                    <button
                                        type="button"
                                        data-operarioid="{{ $Operario->idOperario }}"
                                        class="btn btn-success modalSkillsOperarios"
                                    >
                                        <ion-icon name="list-outline"></ion-icon>
                                    </button>
                                    <button
                                        type="button"
                                        data-operarioid="{{ $Operario->idOperario }}"
                                        data-info="{{ json_encode($Operario) }}"
                                        class="btn btn-primary openAgendaOperariobtn"
                                    >
                                        <ion-icon name="calendar-outline"></ion-icon>
                                    </button>
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Editar Operario -->
    @component('components.modal-component', [
        'modalId' => 'modalEdit',
        'modalTitle' => 'Editar Operario',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editOperarioTitle',
        'btnSaveId' => 'btnSaveEditOperario'
    ])
        <form id="formEditOperario" class="form">
            @csrf
            @method('PUT')
            <input type="hidden" name="" id="operarioidEditForm">
            <div class="form-floating mb-3">
                <input 
                    type="text"
                    id="nameEditOperario"
                    placeholder="Nombre del Operario"
                    class="form-control"
                    required
                >
                <label for="nameEditOperario">Nombre</label>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="text"
                    id="emailEditOperario"
                    placeholder="Email del Operario"
                    class="form-control"
                    required
                >
                <label for="emailEditOperario">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="number"
                    id="telefonoEditOperario"
                    placeholder="Teléfono del Operario"
                    class="form-control"
                    required
                >
                <label for="telefonoEditOperario">Teléfono</label>
            </div>
            <select 
                name="trabajos[]" 
                id="operarioEditTrabajos" 
                class="form-select mb-3 trabajosSelect"
                multiple="multiple" 
                aria-placeholder="Selecciona un Trabajo"
                aria-label="Default select example">
                @foreach ($AllTrabajos as $trabajo)
                    <option
                        data-nametrabajo="{{ $trabajo->nameTrabajo }}"
                        data-descripcion="{{ $trabajo->descripcionTrabajo }}"
                        value="{{ $trabajo->idTrabajo }}">{{ $trabajo->nameTrabajo }}</option>
                @endforeach
            </select>
        </form>
    @endcomponent

    <!-- Modal para Crear Operario -->
    @component('components.modal-component', [
        'modalId' => 'modalCreateOperario',
        'modalTitle' => 'Crear Operario',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'createOperarioTitle',
        'btnSaveId' => 'btnCreateOperario'
    ])
        <form id="formCreateOperario" class="form">
            <div class="form-floating mb-3">
                <select name="user_id" aria-placeholder="Selecciona un usuario" id="operarioCreateUserId" class="form-select mb-3 usersSelect" aria-label="Default select example">
                    <option value="" selected>Selecciona un Usuario</option>
                    @foreach ($AllUsers as $user)
                        <option
                            data-nameuser="{{ $user->name }}"
                            data-emailuser="{{ $user->email }}"
                            value="{{ $user->id }}">{{ $user->name }} | {{ $user->email }} | {{ $user->rol }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-floating mb-3">
                <select 
                    name="trabajos[]" 
                    id="operarioCreateTrabajos" 
                    class="form-select mb-3 usersSelect"
                    multiple="multiple" 
                    aria-placeholder="Selecciona un Trabajo"
                    aria-label="Default select example">
                    @foreach ($AllTrabajos as $trabajo)
                        <option
                            data-nametrabajo="{{ $trabajo->nameTrabajo }}"
                            data-descripcion="{{ $trabajo->descripcionTrabajo }}"
                            value="{{ $trabajo->idTrabajo }}">{{ $trabajo->nameTrabajo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="text"
                    id="nameCreateOperario"
                    placeholder="Nombre del Operario"
                    class="form-control"
                    name="name"
                    required
                    readonly
                >
                <label for="nameCreateOperario">Nombre</label>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="email"
                    id="emailCreateOperario"
                    placeholder="Descripción del Operario"
                    class="form-control"
                    name="email"
                    required
                    readonly
                >
                <label for="emailCreateOperario">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="number"
                    id="telefonoCreateOperario"
                    placeholder="Teléfono del Operario"
                    class="form-control"
                    name="telefono"
                    required
                >
                <label for="telefonoCreateOperario">Teléfono</label>
            </div>
        </form>
    @endcomponent

    {{-- Skills modal --}}

    @component('components.modal-component', [
        'modalId' => 'modalSkills',
        'modalTitle' => 'Habilidades del Operario',
        'modalSize' => 'modal-xs',
        'modalTitleId' => 'skillsTitle',
        'btnSaveId' => 'btnSaveSkills'
    ])
        <div id="operarioSkillsId" class="d-flex justify-content-start flex-wrap flex-column">
        </div>
    @endcomponent

    {{-- Modal agenda de google calendar correspondiente al operario --}}
    @component('components.modal-component', [
        'modalId' => 'modalAgenda',
        'modalTitle' => 'Agenda del Operario',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'agendaTitle',
        'btnSaveId' => 'btnSaveAgenda'
    ])
        <div id="operarioAgendaId" class="d-flex justify-content-center flex-wrap gap-3">
        </div>
    @endcomponent


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>

        let table = $('#OperariosTable').DataTable({
            colReorder: {
                realtime: false
            },
            responsive: true,
            // autoFill: true,
            // fixedColumns: true,
            // Ajuste para mostrar los botones a la izquierda, el filtro a la derecha, y el selector de cantidad de registros
            dom: "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
            "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

            buttons: [
                {
                    text: 'Crear Operario',
                    className: 'btn btn-outline-warning createOperariobtn mb-2',
                },
                @if (!$tokenValido)
                    {
                        text: 'Conectar con Google Calendar',
                        className: 'btn btn-outline-primary mb-2 googleBtn',
                        action: function ( e, dt, node, config ) {
                            window.location.href = "{{ route('google.redirect') }}";
                        }
                    },
                @endif
                // {
                //     extend: 'pdf',
                //     text: 'Exportar a PDF',
                //     className: 'btn btn-danger',
                //     exportOptions: {
                //         columns: [0, 1, 2, 3, 4, 5]
                //     }
                // },
                // {
                //     extend: 'excel',
                //     text: 'Exportar a Excel',
                //     className: 'btn btn-success',
                //     exportOptions: {
                //         columns: [0, 1, 2, 3, 4, 5]
                //     }
                // }
            ],

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
            // Ocultar la columna de ID y ordenar por la fecha de alta con este formato 'DD/MM/YY'
            columnDefs: [
                // {
                //     targets: [1],
                //     render: function(data, type, row) {
                //         return moment(data).format('YYYY-MM-DD');
                //     }
                // }
            ],
        });

        $('.googleBtn, .createOperariobtn').removeClass('dt-button');

        // select2
        $(document).ready(function() {
            // Inicializa Select2 cuando el modal se muestra
            $('#modalCreateOperario').on('shown.bs.modal', function() {
                // Destruir la instancia de Select2, si existe
                if ($('.usersSelect').data('select2')) {
                    $('.usersSelect').select2('destroy');
                }
                // Inicializa Select2
                $('.usersSelect').select2({
                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                    dropdownParent: $('#modalCreateOperario'), // Asocia el dropdown con el modal para evitar problemas de superposición
                });

                $('.usersSelect').on('change', function() {
                    let userId = $(this).val();
                    let user = $(this).find('option:selected').text();
                    let email = user.split('|')[1].trim();
                    $('#nameCreateOperario').val(user.split('|')[0].trim());
                    $('#emailCreateOperario').val(email);

                });

            });

            $('#modalEdit').on('shown.bs.modal', () => {
                // Destruir la instancia de Select2, si existe
                if ($('.trabajosSelect').data('select2')) {
                    $('.trabajosSelect').select2('destroy');
                }

                $('.trabajosSelect').select2({
                    width: '100%',  // Asegura que el select ocupe el 100% del contenedor
                    dropdownParent: $('#modalEdit')  // Asocia el dropdown con el modal para evitar problemas de superposición
                });

                $('.trabajosSelect').on('change', function() {
                    let trabajos = $(this).val();
                    $('#operarioEditTrabajos').val(trabajos).trigger('change');
                });
            });


        });

        table.on('click', '.openAgendaOperariobtn', function(){
            let Operario = $(this).data('info');
            $('#modalAgenda').modal('show');
            $('#agendaTitle').text('Agenda de ' + Operario.nameOperario);
            $('#operarioAgendaId').empty();

            let url = `/admin/operario/${Operario.idOperario}/calendar`;

            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    OperarioId: Operario.idOperario
                },
                success: function({ items }){
                    console.log(items);

                    items.forEach(item => {

                        const formatTimeStart = new Date(item.start.dateTime).toLocaleString();
                        const formatTimeEnd = new Date(item.end.dateTime).toLocaleString();

                        $('#operarioAgendaId').append(`
                            <div class="card mb-2" style="width: 18rem;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title" style="font-weight: bold">${item.summary}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">${item.status}</h6>
                                    </div>
                                    <h6 class="card-subtitle mb-2 text-muted">Hora de inicio: ${ formatTimeStart }</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Hora de fin: ${ formatTimeEnd }</h6>
                                    <p class="card-text">${item.description || 'Sin Descripcion' }</p>
                                    <p class="card-text">Creado por: ${ item.creator.email }</p>
                                    <a href="${item.htmlLink}" target="_blank" class="card-link">Ver en Google Calendar</a>
                                </div>
                            </div>
                        `);
                    });
                },
                error: function(error){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Algo salió mal! Inténtalo de nuevo.',
                        footer: 'Error: ' + error.responseJSON.message
                    });
                    console.log(error);
                }
            });

        })

        // Create Operario
        $('.createOperariobtn').each(function(){
            $(this).on('click', function(e){
                e.preventDefault();
                $('#modalCreateOperario').modal('show');
                $('#createOperarioTitle').text('Crear Operario');
                $('#nameCreateOperario').val('');
                $('#emailCreateOperario').val('');
            });
        });

        // Save changes Create Operario
        $('#btnCreateOperario').click(() => {
            Swal.fire({
                title: '¿Estás seguro de crear el Operario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, crear!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let name     = $('#nameCreateOperario').val();
                    let email    = $('#emailCreateOperario').val();
                    let telefono = $('#telefonoCreateOperario').val();
                    let user_id  = $('#operarioCreateUserId').val();
                    let trabajos = $('#operarioCreateTrabajos').val();

                    if (!name || !email || !telefono || !user_id || !trabajos ) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Todos los campos son obligatorios!'
                        });
                        return;
                    }

                    $.ajax({
                        url: '/admin/operarios/store',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name,
                            email,
                            telefono,
                            user_id,
                            trabajos
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
                                text: 'El Operario ha sido creado correctamente.',
                                showConfirmButton: true,
                                timer: 1500,
                                allowsOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false
                            }).then(() => {
                                $('#modalCreateOperario').modal('hide');
                                location.reload();
                            });
                        },
                        error: function(error){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '¡Algo salió mal! Inténtalo de nuevo.',
                                footer: 'Error: ' + error.responseJSON.message
                            });
                        }
                    });
                }
            })
        
        });

        // Update Operarios
        $('.modalEditOperarios').each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();
                const OperarioId = $(this).data('operarioid');
                const name = $(this).data('name');
                const descripcion = $(this).data('email');
                const telefono = $(this).data('telefono');
                const habilidades = $(this).data('habilidades');

                // Mostrar el modal de edición
                $('#modalEdit').modal('show');

                // Llenar los campos del formulario con los datos del operario
                $('#editOperarioTitle').text('Editar Operario');
                $('#nameEditOperario').val(name);
                $('#emailEditOperario').val(descripcion);
                $('#telefonoEditOperario').val(telefono);
                $('#operarioidEditForm').val(OperarioId);

                let habilidadesArray = [];
                if ( Array.isArray(habilidades) ) {
                    habilidadesArray = habilidades.split(',').map(Number);
                }else{
                    habilidadesArray = [habilidades];
                }
                
                $('#operarioEditTrabajos').val(habilidadesArray).trigger('change');

                // Actualizar la acción del formulario con el ID del operario
                $('#formEditOperario').attr('action', '/admin/Operarios/update/' + OperarioId);
            });
        });

        // Save changes Edit Operario
        $('#btnSaveEditOperario').click(() => {
            Swal.fire({
                title: '¿Estás seguro de actualizar el Operario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, actualizar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    let user_id     = $('#operarioidEditForm').val();
                    let name        = $('#nameEditOperario').val();
                    let email       = $('#emailEditOperario').val();
                    let telefono    = $('#telefonoEditOperario').val();
                    let trabajos    = $('#operarioEditTrabajos').val();

                    $.ajax({
                        url: '/admin/operarios/update/' + user_id,
                        method: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name,
                            email,
                            telefono,
                            trabajos,
                            user_id
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
                                text: 'El Operario ha sido actualizado correctamente.',
                                showConfirmButton: true,
                                timer: 1500,
                                allowsOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false
                            }).then(() => {
                                $('#modalEdit').modal('hide');
                                location.reload();
                            });
                        },
                        error: function(error){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '¡Algo salió mal! Inténtalo de nuevo.',
                                footer: 'Error: ' + error.responseJSON.message
                            });
                            console.log(error);
                        }
                    });
                }
            })
        });

        // Skills Operarios

        $('.modalSkillsOperarios').each(function(){
            $(this).on('click', function(e){
                e.preventDefault();
                const OperarioId = $(this).data('operarioid');

                $.ajax({
                    url: '/admin/operarios/skills',
                    method: 'GET',
                    data: {
                       OperarioId
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
                        $('#modalSkills').modal('show');
                        $('#skillsTitle').text('Habilidades del Operario');
                        $('#operarioSkillsId').empty();
                        data.forEach(skill => {
                            $('#operarioSkillsId').append(`<span>${skill.nameTrabajo}</span>`);
                        });
                        
                    },
                    error: function(error){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Algo salió mal! Inténtalo de nuevo.',
                            footer: 'Error: ' + error.responseJSON.message
                        });
                    }
                });

                
            });
        });

    </script>
@stop
