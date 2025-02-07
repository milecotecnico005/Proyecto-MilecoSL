
@extends('adminlte::page')

@section('title', 'Bancos')

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


    </style>


    <div>
        <div id="tableCard" class="card">
            <a id="createNewBank" class="btn btn-outline-primary d-none">Nuevo Banco</a>
            <a id="import" class="btn btn-outline-warning d-none">Importar</a>

            <div class="card-body">
                <table class="table table-bordered table-hover" id="bancos-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bancos as $banco)
                            <tr>
                                <td>{{ $banco->idbanco }}</td>
                                <td>{{ $banco->nameBanco }}</td>
                                <td>
                                    <a
                                        data-idbancos="{{ $banco->idbanco }}"
                                        data-nameBanco="{{ $banco->nameBanco }}" 
                                        href="#" 
                                        class="btn btn-outline-warning btnEditBank"
                                        >Editar
                                    </a>
                                    <a href="{{ route('admin.bancos.details', $banco->idbanco) }}" class="btn btn-outline-info">Detalles</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="tableCard" class="card">
            <div class="card-header">
                <h6 class="text-center">Resumen general Bancos</h6>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="bancoDetail">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>plazo</th>
                            <th>Fecha Operación</th>
                            <th>Concepto</th>
                            <th>Fecha Valor</th>
                            <th>Importe</th>
                            <th>Saldo</th>
                            <th>Empresa</th>
                            <th>Notas 1</th>
                            <th>Notas 2</th>
                            <th>Notas 3</th>
                            <th>Notas 4</th>
                            <th>Fecha Alta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banco_detail as $detalle)
                            <tr>
                                <td>{{ $detalle->id_detail }}</td>
                                <td>{{ $detalle->plazo }}</td>
                                <td>{{ $detalle->fecha_operacion }}</td>
                                <td>{{ $detalle->concepto }}</td>
                                <td>{{ $detalle->fecha_valor }}</td>
                                <td>{{ $detalle->importe }}€</td>
                                <td>{{ $detalle->saldo }}€</td>
                                <td>{{ $detalle->empresa->EMP }}</td>
                                <td>{{ $detalle->notas1 }}</td>
                                <td>{{ $detalle->notas2 }}</td>
                                <td>{{ $detalle->notas3 }}</td>
                                <td>{{ $detalle->notas4 }}</td>
                                <td>{{ $detalle->fecha_alta }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>


    {{-- Crear nuevo banco modal --}}
    @component('components.modal-component',[
        'modalId'       => 'createBankModal',
        'modalSize'     => 'modal-lg',
        'modalTitle'    => 'Nuevo Banco',
        'btnSaveId'     => 'saveBankBtn',
    ])
        <form id="createBankForm" action="{{ route('admin.bancos.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="nameBanco">Nombre del Banco</label>
                    <input type="text" class="form-control" id="nameBanco" name="nameBanco" required>
                </div>
            </div>
        </form>
    @endcomponent

    @component('components.modal-component',[
        'modalId'       => 'editBankModal',
        'modalSize'     => 'modal-lg',
        'modalTitle'    => 'Editar Banco',
        'btnSaveId'     => 'updateBankBtn',
    ])
        <form id="editBankForm"  method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="nameBanco">Nombre del Banco</label>
                    <input type="text" class="form-control" id="nameBancoEdit" name="nameBanco" required>
                </div>
            </div>
        </form>
        
    @endcomponent

    {{-- Importar banco modal --}}
    @component('components.modal-component',[
        'modalId'       => 'importModal',
        'modalSize'     => 'modal-lg',
        'modalTitle'    => 'Importar Bancos',
        'btnSaveId'     => 'importBtn',
    ])
        <form id="importForm" action="{{ route('admin.bancos.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="file">Archivo</label>
                    <input type="file" class="form-control" id="file" name="file" required>
                </div>
            </div>
        </form>
    @endcomponent

@stop

@section('js')
    <script>
        $(document).ready(function() {
            let table = $('#bancos-table').DataTable({
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
                        text: 'Nuevo Banco',
                        className: 'btn btn-outline-warning createNewBank mb-2',
                        action: function (){
                            $('#createNewBank').click();
                        }
                    },
                    {
                        text: 'Importar',
                        className: 'btn btn-outline-success import mb-2',
                        action: function (){
                            $('#import').click();
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
            let tableDetail = $('#bancoDetail').DataTable({
                colReorder: {
                    realtime: false
                },
                responsive: true,
                order: [[ 0, 'desc' ]],
                // autoFill: true,
                // fixedColumns: true,
                dom: "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
                "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
                "<'row'<'col-12'tr>>" +
                "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

                buttons: [
                    // {
                    //     text: 'Nuevo Banco',
                    //     className: 'btn btn-outline-warning createNewBank mb-2',
                    //     action: function (){
                    //         $('#createNewBank').click();
                    //     }
                    // },
                    // {
                    //     text: 'Importar',
                    //     className: 'btn btn-outline-success import mb-2',
                    //     action: function (){
                    //         $('#import').click();
                    //     }
                    // },
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

            $('.createNewBank, .import').removeClass('dt-button');

            $('#import').click(function() {
                console.log('click');
                $('#importModal').modal('show');
            });

            $('#importBtn').click(function() {
                $('#importForm').submit();
            });

            $('#file').change(function() {
                let file = $(this).val();
                let extension = file.split('.').pop().toLowerCase();
                if (extension != 'xlsx') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'El archivo debe ser de tipo xlsx'
                    })
                    $(this).val('');
                }
            });

        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire(
                'Correcto',
                '{{ session('success') }}',
                'success'
            )
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire(
                'Error',
                '{{ session('error') }}',
                'error'
            )
        </script>
    @endif

    <script>
        $('#createNewBank').click(function() {
            $('#createBankModal').modal('show');
        });

        $('#bancos-table').on('click', '.btnEditBank', function() {
            let nameBanco = $(this).data('namebanco');
            let idBancos = $(this).data('idbancos');

            $('#nameBancoEdit').val(nameBanco);
            $('#editBankForm').attr('action', 'bancos/edit/' + idBancos);
            $('#editBankModal').modal('show');
        });

        $('#updateBankBtn').click(function() {
            $('#editBankForm').submit();
        });

        $('#saveBankBtn').click(function() {
            console.log('click');
            $('#createBankForm').submit();
        });

    </script>

@stop