{{-- resources/views/admin/tiposempresas/index.blade.php --}}

@extends('adminlte::page')

@section('title', 'Tipos de Empresas')

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
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha de alta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipos as $tipoEmpresa)
                        <tr>
                            <td>{{ $tipoEmpresa->idtiposEmpresa }}</td>
                            <td>{{ $tipoEmpresa->nameTipo }}</td>
                            <td>{{ formatDate($tipoEmpresa->created_at) }}</td>
                            <td>
                                @component('components.actions-button')
                                <a
                                    data-id="{{ $tipoEmpresa->idtiposEmpresa }}"
                                    data-nombre="{{ $tipoEmpresa->nameTipo }}" 
                                    class="btn btn-outline-primary btnEditModal"
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

    @component('components.modal-component',[
        'modalId' => 'createTypeEmpresaModal',
        'modalTitle' => 'Crear Tipo de Empresa',
        'modalSize' => 'modal-md',
        'btnSaveId' => 'saveTypeEmpresaBtn'
    ])
        <form id="createTypeEmpresaForm">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del tipo de empresa">
            </div>
        </form>
    @endcomponent

    @component('components.modal-component',[
        'modalId' => 'editTypeEmpresaModal',
        'modalTitle' => 'Editar Tipo de Empresa',
        'modalSize' => 'modal-md',
        'btnSaveId' => 'updateTypeEmpresaBtn',
    ])
        <form id="editTypeEmpresaForm">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del tipo de empresa">
            </div>
        </form>
    @endcomponent

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    
    @if (session('success'))
        <script>
            Swal.fire(
                '¡Éxito!',
                '{{ session('success') }}',
                'success'
            )
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire(
                '¡Error!',
                '{{ session('error') }}',
                'error'
            )
        </script>
    @endif

    <script>

        // datatable
        let table = $('.table').DataTable({
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
                    text: 'Crear Tipo de Empresa',
                    className: 'btn btn-outline-warning createTypeEmpresaBtn mb-2',
                    action: function () {
                        $('#createTypeEmpresaModal').modal('show');
                    }
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

        $('.createTypeEmpresaBtn').removeClass('dt-button');

        // Crear Tipo de Empresa

        $('#saveTypeEmpresaBtn').click(function(){
            const nombre = $('#createTypeEmpresaForm #nombre').val();
            $.ajax({
                url: '{{ route('admin.tiposempresas.store') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    nombre: nombre
                },
                success: function(response){
                    if(response.success){
                        Swal.fire(
                            '¡Éxito!',
                            response.message,
                            'success'
                        ).then((result) => {
                            if(result.isConfirmed){
                                location.reload();
                            }
                        });
                    }else{
                        Swal.fire(
                            '¡Error!',
                            response.message,
                            'error'
                        );
                    }
                }
            });
        });

        // Editar Tipo de Empresa

        table.on('click', '.btnEditModal', function(){
            const id = $(this).data('id');
            const nombre = $(this).data('nombre');
            $('#editTypeEmpresaForm #nombre').val(nombre);
            $('#editTypeEmpresaModal').modal('show');
            $('#updateTypeEmpresaBtn').click(function(){
                const nombre = $('#editTypeEmpresaForm #nombre').val();
                // add id to the route
                $.ajax({
                    url: '/admin/tiposempresas/update/' + id ,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        nombre: nombre
                    },
                    success: function(response){
                        if(response.success){
                            Swal.fire(
                                '¡Éxito!',
                                response.message,
                                'success'
                            ).then((result) => {
                                if(result.isConfirmed){
                                    location.reload();
                                }
                            });
                        }else{
                            Swal.fire(
                                '¡Error!',
                                response.message,
                                'error'
                            );
                        }
                    }
                });
            });
        });

    </script>

@stop
