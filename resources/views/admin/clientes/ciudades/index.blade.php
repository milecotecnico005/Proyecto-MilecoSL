
@extends('adminlte::page')

@section('title', 'Ciudades')

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
        <div class="card-body">
            <table class="table table-bordered table-hover" id="ciudades-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Clientes</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ciudades as $ciudad)
                        <tr>
                            <td>{{ $ciudad->idCiudades }}</td>
                            <td>{{ $ciudad->nameCiudad }}</td>
                            <td>{{ $ciudad->clientes->count() }}</td>
                            <td>
                                @component('components.actions-button')
                                    <a
                                        data-nameCiudad="{{ $ciudad->nameCiudad }}" 
                                        data-idCiudades="{{ $ciudad->idCiudades }}"
                                        href="#" 
                                        class="btn btn-warning btnEditCity"
                                    >
                                        <ion-icon name="create-outline"></ion-icon>                                
                                    </a>
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- Crear nueva ciudad modal --}}
    @component('components.modal-component',[
        'modalId'       => 'createCityModal',
        'modalSize'     => 'modal-lg',
        'modalTitle'    => 'Nueva Ciudad',
        'btnSaveId'     => 'saveCityBtn',
    ])
        <form id="createCityForm" action="{{ route('admin.ciudades.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="nameCiudad">Nombre de la Ciudad</label>
                    <input type="text" class="form-control" id="nameCiudad" name="nameCiudad" required>
                </div>
            </div>
        </form>
    @endcomponent

    {{-- Editar ciudad modal --}}

    @component('components.modal-component',[
        'modalId'       => 'editCityModal',
        'modalSize'     => 'modal-lg',
        'modalTitle'    => 'Editar Ciudad',
        'btnSaveId'     => 'updateCityBtn',
    ])
        <form id="editCityForm"  method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="nameCiudad">Nombre de la Ciudad</label>
                    <input type="text" class="form-control" id="nameCiudadEdit" name="nameCiudad" required>
                </div>
            </div>
        </form>
    @endcomponent

@stop

@section('js')

    @if (session('success'))
        <script>
            Swal.fire(
                'Editado!',
                'La ciudad ha sido editada.',
                'success'
            )
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire(
                'Error!',
                'Ha ocurrido un error.',
                'error'
            )
        </script>
    @endif

    @if (session('successEdit'))
        <script>
            Swal.fire(
                'Editado!',
                'La ciudad ha sido editada.',
                'success'
            )
        </script>
    @endif

    @if (session('errorEdit'))
        <script>
            Swal.fire(
                'Error!',
                'Ha ocurrido un error.',
                'error'
            )
        </script>
    @endif

    <script>
        $(document).ready(function() {
            let table = $('#ciudades-table').DataTable({
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
                        text: 'Crear Ciudad',
                        className: 'btn btn-outline-warning createNewCity mb-2',
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

            $('.createNewCity').removeClass('dt-button');

            $('.createNewCity').on('click', function() {
                $('#createCityModal').modal('show');
            });

            table.on('click', '.btnEditCity', function() {
                $('#editCityModal').modal('show');

                let idCiudades = $(this).data('idciudades');
                let nameCiudad = $(this).data('nameciudad');

                $('#editCityForm').attr('action', `cities/edit/${idCiudades}`);
                $('#nameCiudadEdit').val(nameCiudad);

            });

            $('#saveCityBtn').on('click', function() {

                // validar formulario
                if( $('#nameCiudad').val() == '' ){
                    alert('El campo nombre de la ciudad es requerido');
                    return;
                }

                $('#createCityForm').submit();
            });

            $('#updateCityBtn').on('click', function() {

                // validar formulario
                if( $('#nameCiudadEdit').val() == '' ){
                    alert('El campo nombre de la ciudad es requerido');
                    return;
                }

                $('#editCityForm').submit();
            });

        });
    </script>
@stop