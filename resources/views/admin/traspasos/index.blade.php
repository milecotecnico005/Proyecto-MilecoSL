@extends('adminlte::page')

@section('title', 'Traspasos')


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
            <table class="table table-striped" id="traspasosTable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Fecha</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($traspasos as $traspaso)
                        <tr
                            class="mantenerPulsadoParaSubrayar"
                        >
                            <td>{{ $traspaso->id_traspaso }}</td>
                            <td>{{ formatDate($traspaso->fecha_traspaso) }}</td>
                            <td>{{ $traspaso->origen->EMP }}</td>
                            <td>{{ $traspaso->destino->EMP }}</td>
                            <td>{{ $traspaso->articulo->nombreArticulo }}</td>
                            <td>{{ $traspaso->cantidad }}</td>
                            <td>
                                @component('components.actions-button')
                                    <form action="{{ route('admin.traspasos.generarPDF', $traspaso->id_traspaso ) }}" method="POST" >
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary">
                                            <ion-icon name="document-text-outline"></ion-icon>
                                        </button>
                                    </form>
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

@component('components.modal-component', [
    'modalId' => 'createNewTraspasoModal',
    'modalTitle' => 'Nuevo Traspaso',
    'modalSize' => 'modal-xl',
    'btnSaveId' => 'createNewTraspasoBTN',
])
    @include('admin.traspasos.create')
@endcomponent


@stop

@section('css')
    <style>
        #usersTable th, #usersTable td {
            overflow: hidden;
            white-space: nowrap;
        }
    </style>
@stop

@php
    echo 
    '<script>
        let productos = '.json_encode($productos).';
        let almacenes = '.json_encode($almacenes).';
    </script>';
@endphp

@section('js')

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            })
        </script>
    @endif

    <script>

        let table = $('#traspasosTable').DataTable({
            colReorder: {
                realtime: false
            },
            // responsive: true,
            // autoFill: true,
            // fixedColumns: true,
            // Ajuste para mostrar los botones a la izquierda, el filtro a la derecha, y el selector de cantidad de registros
            dom: "<'row'<'col-12 mb-2'<'table-title'>>>" +
            "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
            "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

            buttons: [
                {
                    text: 'Crear Traspaso',
                    className: 'btn btn-outline-warning newTraspasoBTN mb-2'
                },
                {
                    text: 'Limpiar Filtros', 
                    className: 'btn btn-outline-danger limpiarFiltrosBtn mb-2', 
                    action: function (e, dt, node, config) { 
                        clearFiltrosFunction(dt, '#traspasosTable');
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
                lengthMenu: "Mostrar _MENU_",
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
            initComplete: function () {
                configureInitComplete(this.api(), '#traspasosTable', 'TRASPASOS', 'primary');
            }
        });

        table.on('init.dt', function() {
            restoreFilters(table, '#traspasosTable');// Restaurar filtros después de inicializar la tabla
        });

        mantenerFilaYsubrayar(table);
        fastEditForm(table, 'Traspasos');

        $('.limpiarFiltrosBtn').removeClass('dt-button');
        $('.newTraspasoBTN').removeClass('dt-button');

        $('.newTraspasoBTN').on('click', function() {
            $('#createNewTraspasoModal').modal('show');

            $('#createNewTraspasoModal #fecha').val(moment().format('YYYY-MM-DD'));

            $('#createNewTraspasoModal').on('hidden.bs.modal', function (e) {
                $('#createNewTraspasoModal form').trigger('reset');
            });

            $('#producto').on('change', function() {

                $('#destino').empty();

                $('#destino').append(`<option value="">Selecciona un destino</option>`);

                almacenes.forEach(almacen => {
                    $('#destino').append(`<option value="${almacen.idEmpresa}">${almacen.EMP}</option>`).trigger('change');
                });
                
                let articuloDesc = $('#producto option:selected').data('articulodesc');

                // obtener la empresa dueña del producto
                const empresa = $('#producto option:selected').data('emp');
                        
                $('#origen').val(empresa).trigger('change');
                $('#destino option[value="'+empresa+'"]').remove();
                $('#cantidad').attr('readonly', false); 

            });

            $('#cantidad').on('keyup', function() {

                const regex = /^[0-9]*$/;

                if (!regex.test($(this).val())) {
                    $(this).val('');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'La cantidad debe ser un número entero',
                    })
                }

                let cantidad = $(this).val();
                let producto = $('#producto option:selected').data('stock');
                if (cantidad > producto.cantidad) {
                    // dar clase form-control is-invalid
                    $('#cantidad').removeClass('is-valid').addClass('is-invalid');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'La cantidad no puede ser mayor al stock tiene '+producto.cantidad+' unidades',
                    })
                    $(this).val('');
                }else{
                    $('#cantidad').removeClass('is-invalid').addClass('is-valid');
                }
            });

        });

        // evento cuando se abre el modal de crear nuevo traspaso
        $('#createNewTraspasoModal').on('show.bs.modal', function() {
            // INICIALIZAR SELECT2
            $('#createNewTraspasoModal select.form-select').select2({
                placeholder: 'Selecciona un producto',
                width: '100%',
                dropdownParent: $('#createNewTraspasoModal')
            });
        });

        $('#createNewTraspasoBTN').on('click', function() {
            
            // vlidate form
            if ($('#fecha').val() == '' || $('#origen').val() == '' || $('#destino').val() == '' || $('#producto').val() == '' || $('#cantidad').val() == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Todos los campos son requeridos',
                })
                return;
            }

            $('#createNewTraspasoModal form').submit();
        });

    </script>

@stop