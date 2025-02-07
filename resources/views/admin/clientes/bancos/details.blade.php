@extends('adminlte::page')

@section('title', "Detalles del Banco $banco->nameBanco")

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

        #suggestions {
            border: 1px solid #ddd;
            max-height: 150px;
            overflow-y: auto;
            width: 300px;
            background: white;
            position: absolute;
            z-index: 1000;
        }
        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }
        .suggestion-item:hover {
            background-color: #f0f0f0;
        }

    </style>


    <div id="tableCard" class="card">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <div class="form-group">
                <label for="nameBanco">Nombre del Banco</label>
                <input type="text" class="form-control" id="nameBanco" name="nameBanco" value="{{ $banco->nameBanco }}" disabled>
            </div>

            {{-- Saldo del banco --}}
            <div class="form-group">
                <label for="saldo">Saldo</label>
                <input type="text" class="form-control" id="saldo" name="saldo" value="{{ $saldo }}€" disabled>
            </div>

            <div class="form-group">
                <table class="table table-striped" id="bancoDetail">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>plazo</th>
                            <th>Fecha Operación</th>
                            <th>Concepto</th>
                            <th>F.Valor</th>
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
                        @foreach($banco->banco_detail as $detalle)
                        <tr>
                                <td>{{ $detalle->id_detail }}</td>
                                <td>{{ $detalle->plazo_id }}</td>
                                <td>{{ $detalle->fecha_operacion }}</td>
                                <td>{{ $detalle->concepto }}</td>
                                <td>{{ formatDate($detalle->fecha_valor) }}</td>
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


    </div>

    <script>
        $(document).ready(function() {

            let table = $('#bancoDetail').DataTable({
                colReorder: {
                    realtime: false
                },
                order: [[0, 'desc']],
                // responsive: true,
                // autoFill: true,
                // fixedColumns: true,
                // Ajuste para mostrar los botones a la izquierda, el filtro a la derecha, y el selector de cantidad de registros
                dom: "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
                "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
                "<'row'<'col-12'tr>>" +
                "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

                buttons: [
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
        });
    </script>
@stop