@extends('adminlte::page')

@section('title', 'Categorias de arituclos')

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
        <div class="card-body p-4">
            <table class="table table-striped" id="categoriesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->idArticuloCategoria }}</td>
                            <td>{{ $categoria->nameCategoria }}</td>
                            <td>
                                @component('components.actions-button')
                                    <button 
                                        data-id="{{ $categoria->idArticuloCategoria }}"
                                        data-name="{{ $categoria->nameCategoria }}"
                                        class="btn btn-primary editCategory">
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

    @component('components.modal-component', [
        'modalId' => 'createCategoryModal',
        'modalTitleId' => 'createCategoryModalLabel',
        'modalTitle' => 'Crear categoria de articulos',
        'btnSaveId' => 'saveCategoryBtn',
        'modalSize' => 'modal-md',
    ])

        <form action="{{ route('admin.categorias.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
        </form>
        
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'editCategoryModal',
        'modalTitleId' => 'editCategoryModalLabel',
        'modalTitle' => 'Editar categoria de articulos',
        'btnSaveId' => 'saveEditCategoryBtn',
        'modalSize' => 'modal-md',
    ])

        <form method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
        </form>
        
    @endcomponent

@stop

@section('css')
    
@stop

@section('js')

    @if (session('success'))
        
        <script>
            Swal.fire(
                'Categoria creada',
                'La categoria se ha creado correctamente',
                'success'
            )
        </script>
        
    @endif

    @if (session('successEdit'))
        
        <script>
            Swal.fire(
                'Categoria actualizada',
                'La categoria se ha actualizado correctamente',
                'success'
            )
        </script>

    @endif


    <script>

        let table = $('#categoriesTable').DataTable({
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
                    text: 'Crear Categoria',
                    className: 'btn btn-outline-warning createCategorybtn mb-2',
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

        $('.createCategorybtn').removeClass('dt-button');

        $('.createCategorybtn').on('click', function() {
            $('#createCategoryModal').modal('show');
        });

        $('#saveCategoryBtn').on('click', function() {

            // validar que el campo nombre no este vacio y tampoco tenga caracteres especiales excepto letras y espacios
            let nombre = $('#createCategoryModal form #nombre').val();
            let regex = /^[a-zA-Z\s]*$/;

            if (nombre == '' || !regex.test(nombre)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El campo nombre no puede estar vacio y solo puede contener letras y espacios',
                })
                return;
            }

            $('#createCategoryModal form').submit();
        });

        table.on('click', '.editCategory', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');

            $('#editCategoryModal form #id').val(id);
            $('#editCategoryModal form #nombre').val(name);

            $('#editCategoryModal').modal('show');
        });

        $('#saveEditCategoryBtn').on('click', function() {

            // validar que el campo nombre no este vacio y tampoco tenga caracteres especiales excepto letras y espacios
            let nombre = $('#editCategoryModal form #nombre').val();
            let regex = /^[a-zA-Z\s]*$/;

            const id = $('#editCategoryModal form #id').val();

            // agregar action al form
            $('#editCategoryModal form').attr('action', '/admin/categorias/update/' + id);

            if (nombre == '' || !regex.test(nombre)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El campo nombre no puede estar vacio y solo puede contener letras y espacios',
                })
                return;
            }

            $('#editCategoryModal form').submit();
        });

    </script>

@stop