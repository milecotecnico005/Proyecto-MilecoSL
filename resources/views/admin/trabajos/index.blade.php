@extends('adminlte::page')

@section('title', 'Trabajos')

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

    <div id="cardTable" class="card">
        <div class="card-body">
            <table class="table table-striped" id="TrabajosTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trabajos as $Trabajo)
                        <tr>
                            <td>{{ $Trabajo->idTrabajo }}</td>
                            <td>{{ $Trabajo->nameTrabajo }}</td>
                            <td>{{ $Trabajo->descripcionTrabajo }}</td>
                            <td>
                                @component('components.actions-button')
                                    <button
                                        type="button"
                                        class="btn btn-primary modalEditTrabajos"
                                        data-name="{{ $Trabajo->nameTrabajo }}"
                                        data-descripcion="{{ $Trabajo->descripcionTrabajo }}"
                                        data-trabajoid="{{ $Trabajo->idTrabajo }}"
                                    >
                                        <ion-icon name="create-outline"></ion-icon>
                                    </button>
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Editar Trabajo -->
    @component('components.modal-component', [
        'modalId' => 'modalEdit',
        'modalTitle' => 'Editar Trabajo',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editTrabajoTitle',
        'btnSaveId' => 'btnSaveEditTrabajo'
    ])
        <form id="formEditTrabajo" class="form">
            <div class="form-floating mb-3">
                <input 
                    type="text"
                    id="nameEditTrabajo"
                    placeholder="Nombre del Trabajo"
                    class="form-control"
                    required
                >
                <label for="nameEditTrabajo">Nombre</label>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="text"
                    id="emailEditTrabajo"
                    placeholder="Descripción del Trabajo"
                    class="form-control"
                    required
                >
                <label for="emailEditTrabajo">Descripcion</label>
            </div>
        </form>
    @endcomponent

    <!-- Modal para Crear Trabajo -->
    @component('components.modal-component', [
        'modalId' => 'modalCreateTrabajo',
        'modalTitle' => 'Crear Trabajo',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'createTrabajoTitle',
        'btnSaveId' => 'btnCreateTrabajo'
    ])
        <form id="formCreateTrabajo" class="form">
            <div class="form-floating mb-3">
                <input 
                    type="text"
                    id="nameCreateTrabajo"
                    placeholder="Nombre del Trabajo"
                    class="form-control"
                    name="name"
                    required
                >
                <label for="nameCreateTrabajo">Nombre</label>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="text"
                    id="emailCreateTrabajo"
                    placeholder="Descripción del Trabajo"
                    class="form-control"
                    name="description"
                    required
                >
                <label for="emailCreateTrabajo">Descripcion</label>
            </div>
        </form>
    @endcomponent

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>

        let table = $('#TrabajosTable').DataTable({
            colReorder: {
                realtime: false
            },
            responsive: true,
            // autoFill: true,
            // fixedColumns: true,
            dom: "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
            "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

            buttons: [
                {
                    text: 'Crear Trabajo',
                    className: 'btn btn-outline-warning createTrabajobtn mb-2 ',
                },
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

        $('.createTrabajobtn').removeClass('dt-button');

        // Create Trabajo
        $('.createTrabajobtn').each(function(){
            $(this).on('click', function(e){
                e.preventDefault();
                $('#modalCreateTrabajo').modal('show');
                $('#createTrabajoTitle').text('Crear Trabajo');
                $('#nameCreateTrabajo').val('');
                $('#emailCreateTrabajo').val('');
            });
        });

        // Save changes Create Trabajo
        $('#btnCreateTrabajo').click(() => {
            Swal.fire({
                title: '¿Estás seguro de crear el Trabajo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, crear!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let name     = $('#nameCreateTrabajo').val();
                    let descripcion    = $('#emailCreateTrabajo').val();
                    $.ajax({
                        url: '/admin/trabajos/store',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name,
                            descripcion,
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
                                text: 'El Trabajo ha sido creado correctamente.',
                                showConfirmButton: true,
                                timer: 1500,
                                allowsOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false
                            }).then(() => {
                                $('#modalCreateTrabajo').modal('hide');
                                location.reload();
                            });
                        },
                        error: function(error){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '¡Algo salió mal! Inténtalo de nuevo.'
                            });
                            console.log(error);
                        }
                    });
                }
            })
        
        });

        // Update Trabajos
        $('.modalEditTrabajos').each(function(){
            $(this).on('click', function(e){
                e.preventDefault();
                let TrabajoId   = $(this).data('trabajoid');
                let name        = $(this).data('name');
                let descripcion = $(this).data('descripcion');

                $('#modalEdit').modal('show');
                $('#editTrabajoTitle').text('Editar Trabajo');
                $('#nameEditTrabajo').val(name);
                $('#emailEditTrabajo').val(descripcion);
                $('.modalEditTrabajos').data('Trabajoid', TrabajoId);

                $('#formEditTrabajo').attr('action', '/admin/Trabajos/update/' + TrabajoId);
            });
        });

        // Save changes Edit Trabajo
        $('#btnSaveEditTrabajo').click(() => {
            Swal.fire({
                title: '¿Estás seguro de actualizar el Trabajo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, actualizar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let TrabajoId = $('.modalEditTrabajos').data('Trabajoid');
                    let name   = $('#nameEditTrabajo').val();
                    let descripcion  = $('#emailEditTrabajo').val();
                    $.ajax({
                        url: '/admin/trabajos/update/' + TrabajoId,
                        method: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name,
                            descripcion
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
                                text: 'El Trabajo ha sido actualizado correctamente.',
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
                                text: '¡Algo salió mal! Inténtalo de nuevo.'
                            });
                            console.log(error);
                        }
                    });
                }
            })
        });

    </script>
@stop
