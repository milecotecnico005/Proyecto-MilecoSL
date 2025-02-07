@extends('adminlte::page')

@section('title', 'Proveedores')

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

            <div id="ProveedoresGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>

            {{-- <table class="table table-striped" id="ProveedoresTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>CIF</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Email</th>
                        <th>Agente</th>
                        <th>Tipo</th>
                        <th>Banco</th>
                        <th>SctaIni</th>
                        <th>SctaCon</th>
                        <th>Obser.</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->idProveedor }}</td>
                            <td>{{ $proveedor->cifProveedor }}</td>
                            <td
                                class="text-truncate"
                                data-fulltext="{{ $proveedor->nombreProveedor }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{{ $proveedor->nombreProveedor }}"
                            >
                                {{ Str::limit($proveedor->nombreProveedor, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-fulltext="{{ $proveedor->direccionProveedor }} {{ $proveedor->codigoPostalProveedor }} {{ $proveedor->ciudad->nameCiudad }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{{ $proveedor->direccionProveedor }}"
                            >
                                {{ Str::limit($proveedor->direccionProveedor." ".$proveedor->codigoPostalProveedor." ".$proveedor->ciudad->nameCiudad, 5) }}
                            </td>
                            <td>{{ $proveedor->emailProveedor }}</td>
                            <td
                                class="text-truncate"
                                data-fulltext="{{ $proveedor->agenteProveedor }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{{ $proveedor->agenteProveedor }}"
                            >
                                {{ Str::limit($proveedor->agenteProveedor, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-fulltext="{{ ($proveedor->tipoProveedor) == 2 ? 'Proveedor' : 'Acreedor' }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{{ ($proveedor->tipoProveedor) == 2 ? 'Proveedor' : 'Acreedor' }}"
                            >
                                {{ Str::limit(($proveedor->tipoProveedor) == 2 ? 'Proveedor' : 'Acreedor', 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-fulltext="{{ $proveedor->banco->nameBanco }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{{ $proveedor->banco->nameBanco }}"
                            >
                                {{ Str::limit($proveedor->banco->nameBanco, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-fulltext="{{ $proveedor->Scta_ConInicio }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{{ $proveedor->Scta_ConInicio }}"
                            >
                                {{ Str::limit($proveedor->Scta_ConInicio, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-fulltext="{{ $proveedor->Scta_Contable }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{{ $proveedor->Scta_Contable }}"
                            >
                                {{ Str::limit($proveedor->Scta_Contable, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-fulltext="{{ $proveedor->observacionesProveedor }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{{ $proveedor->observacionesProveedor }}"
                            >
                                {{ Str::limit($proveedor->observacionesProveedor, 5) }}
                            </td>
                            <td>
                                @component('components.actions-button')
                                    <button 
                                        class="btn btn-info btnOpenDetailsModal"
                                        data-id="{{ $proveedor->idProveedor }}"
                                        data-cif="{{ $proveedor->cifProveedor }}"
                                        data-nombre="{{ $proveedor->nombreProveedor }}"
                                        data-direccion="{{ $proveedor->direccionProveedor }}"
                                        data-codigo-postal="{{ $proveedor->codigoPostalProveedor }}"
                                        data-ciudad="{{ $proveedor->ciudad->nameCiudad }}"
                                        data-email="{{ $proveedor->emailProveedor }}"
                                        data-agente="{{ $proveedor->agenteProveedor }}"
                                        data-tipo="{{ ($proveedor->tipoProveedor) == 2 ? 'Proveedor' : 'Acreedor' }}"
                                        data-banco-id="{{ $proveedor->banco->nameBanco }}"
                                        data-scta-con-inicio="{{ $proveedor->Scta_ConInicio }}"
                                        data-scta-contable="{{ $proveedor->Scta_Contable }}"
                                        data-observaciones="{{ $proveedor->observacionesProveedor }}"
                                        data-toggle="modal"
                                        data-target="#modalDetallesProveedor"
                                    >
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </button>
                                    <button 
                                        data-id="{{ $proveedor->idProveedor }}"
                                        data-cif="{{ $proveedor->cifProveedor }}"
                                        data-nombre="{{ $proveedor->nombreProveedor }}"
                                        data-direccion="{{ $proveedor->direccionProveedor }}"
                                        data-codigo-postal="{{ $proveedor->codigoPostalProveedor }}"
                                        data-ciudad="{{ $proveedor->ciudad_id }}"
                                        data-email="{{ $proveedor->emailProveedor }}"
                                        data-agente="{{ $proveedor->agenteProveedor }}"
                                        data-tipo="{{ $proveedor->tipoProveedor }}"
                                        data-banco-id="{{ $proveedor->banco_id }}"
                                        data-scta-con-inicio="{{ $proveedor->Scta_ConInicio }}"
                                        data-scta-contable="{{ $proveedor->Scta_Contable }}"
                                        data-observaciones="{{ $proveedor->observacionesProveedor }}"
                                        class="btn btn-primary btnOpenEditModal"
                                        data-toggle="modal"
                                        data-target="#modalEditProveedor"
                                    >
                                        <ion-icon name="create-outline"></ion-icon>
                                    </button>
                                @endcomponent   
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    </div>

    <style>
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

    <!-- Modal para Crear Proveedor -->
    @component('components.modal-component', [
        'modalId' => 'modalCreateProveedor',
        'modalTitle' => 'Crear Proveedor',
        'modalSize' => 'modal-xl',
        'modalTitleId' => 'createProveedorTitle',
        'btnSaveId' => 'btnCreateProveedor'
    ])
        @include('admin.proveedores.formcreate')
    @endcomponent

    {{-- Modal para detalles del proveedor --}}
    @component('components.modal-component', [
        'modalId' => 'modalDetallesProveedor',
        'modalTitle' => 'Detalles del Proveedor',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'detallesProveedorTitle',
        'btnSaveId' => 'btnDetallesProveedor',
        'disabledSaveBtn' => true
    ])
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cifProveedorDetalles">CIF</label>
                <input type="text" class="form-control" id="cifProveedorDetalles" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="nombreProveedorDetalles">Nombre</label>
                <input type="text" class="form-control" id="nombreProveedorDetalles" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="direccionProveedorDetalles">Dirección</label>
                <input type="text" class="form-control" id="direccionProveedorDetalles" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="codigoPostalProveedorDetalles">Código Postal</label>
                <input type="text" class="form-control" id="codigoPostalProveedorDetalles" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="ciudadDetalles">Ciudad</label>
                <input type="text" class="form-control" id="ciudadDetalles" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="emailProveedorDetalles">Email</label>
                <input type="email" class="form-control" id="emailProveedorDetalles" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="agenteProveedorDetalles">Agente</label>
                <input type="text" class="form-control" id="agenteProveedorDetalles" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="tipoProveedorDetalles">Tipo</label>
                <input type="text" class="form-control" id="tipoProveedorDetalles" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="bancoDetalles">Banco</label>
                <input type="text" class="form-control" id="bancoDetalles" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="Scta_ConInicioDetalles">Cuenta Contable Inicial</label>
                <input type="text" class="form-control" id="Scta_ConInicioDetalles" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="Scta_ContableDetalles">Cuenta Contable</label>
                <input type="text" class="form-control" id="Scta_ContableDetalles" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="observacionesProveedorDetalles">Observaciones</label>
                <textarea class="form-control" id="observacionesProveedorDetalles" rows="3" disabled></textarea>
            </div>
        </div>
    @endcomponent

    <!-- Modal para Editar Proveedor -->
    @component('components.modal-component', [
        'modalId' => 'modalEditProveedor',
        'modalTitle' => 'Editar Proveedor',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editProveedorTitle',
        'btnSaveId' => 'btnEditProveedor'
    ])
        <form id="formEditProveedor" action="{{ route('admin.proveedores.update', 0) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="editProveedorId" name="idProveedor">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="editCifProveedor">CIF</label>
                    <input type="text" class="form-control" id="editCifProveedor" name="cifProveedor" placeholder="CIF">
                </div>
                <div class="form-group col-md-6">
                    <label for="editNombreProveedor">Nombre</label>
                    <input type="text" class="form-control" id="editNombreProveedor" name="nombreProveedor" placeholder="Nombre">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="editDireccionProveedor">Dirección</label>
                    <div class="d-flex justify-content-center">
                        <input type="text" class="form-control direccion" id="editDireccionProveedor" name="direccionProveedor" placeholder="Dirección">
                        <button type="button" class="btn btn-outline-primary direccion-btnSearch" id="btnSearch">Buscar</button>
                    </div>
                    <div id="suggestions"></div>
                </div>
                <div class="form-group col-md-6">
                    <label for="editCodigoPostalProveedor">Código Postal</label>
                    <input type="text" class="form-control" id="editCodigoPostalProveedor" name="codigoPostalProveedor" placeholder="Código Postal">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="editCiudad_id">Ciudad</label>
                    <select id="editCiudad_id" name="ciudad_id" class="form-control">
                        <option selected>Seleccionar...</option>
                        @foreach ($ciudades as $ciudad)
                            <option value="{{ $ciudad->idCiudades }}">{{ $ciudad->nameCiudad }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="editEmailProveedor">Email</label>
                    <input type="email" class="form-control" id="editEmailProveedor" name="emailProveedor" placeholder="Email">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="editAgenteProveedor">Agente</label>
                    <input type="text" class="form-control" id="editAgenteProveedor" name="agenteProveedor" placeholder="Agente">
                </div>
                <div class="form-group col-md-6">
                    <label for="editTipoProveedor">Tipo</label>
                    <select id="editTipoProveedor" name="tipoProveedor" class="form-control">
                        <option selected>Seleccionar...</option>
                        <option value="2">Proveedor</option>
                        <option value="3">Acreedor</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="editBanco_id">Banco</label>
                    <select id="editBanco_id" name="banco_id" class="form-control">
                        <option selected>Seleccionar...</option>
                        @foreach ($bancos as $banco)
                            <option value="{{ $banco->idbanco }}">{{ $banco->nameBanco }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="editScta_ConInicio">Cuenta Contable Inicial</label>
                    <input type="text" class="form-control" id="editScta_ConInicio" name="Scta_ConInicio" placeholder="Cuenta Contable Inicial">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="editScta_Contable">Cuenta Contable</label>
                    <input type="text" class="form-control" id="editScta_Contable" name="Scta_Contable" placeholder="Cuenta Contable">
                </div>
                <div class="form-group col-md-6">
                    <label for="editObservacionesProveedor">Observaciones</label>
                    <textarea class="form-control" id="editObservacionesProveedor" name="observacionesProveedor" rows="3"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="telefono">Telefono</label>
                        <input type="number" name="telefono[]" id="telefono" class="form-control">
                    </div>
                    {{-- Boton para crear otro input para agregar otro telefono --}}
                    <div class="form-group mb-2" id="telefonosContainer"></div>
                    <button type="button" class="btn btn-outline-primary" id="btnAddTelefono">Agregar otro telefono</button>
                </div>
            </div>
        </form>
    @endcomponent

@stop

@section('css')
    <!-- Estilos personalizados aquí si es necesario -->
@stop

@section('js')

    @if (session('success'))
        <script>
            Swal.fire(
                '¡Éxito!',
                '{{ session('success') }}',
                'success'
            );
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire(
                '¡Error!',
                '{{ session('error') }}',
                'error'
            );
        </script>
    @endif

    <script>
        $(document).ready(function () {
            // Inicialización de DataTables
            // let table = $('#ProveedoresTable').DataTable({
            //     colReorder: {
            //         realtime: false
            //     },
            //     responsive: true,
            //     order: [[0, 'desc']],
            //     // autoFill: true,
            //     // fixedColumns: true,
            //     // Ajuste para mostrar los botones a la izquierda, el filtro a la derecha, y el selector de cantidad de registros
            //     dom: "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
            //     "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
            //     "<'row'<'col-12'tr>>" +
            //     "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

            //     buttons: [
            //         {
            //             text: 'Crear Proveedor',
            //             className: 'btn btn-outline-warning createProveedorBtn mb-2',
            //         },
            //         // {
            //         //     extend: 'pdf',
            //         //     text: 'Exportar a PDF',
            //         //     className: 'btn btn-danger',
            //         //     exportOptions: {
            //         //         columns: [0, 1, 2, 3, 4, 5]
            //         //     }
            //         // },
            //         // {
            //         //     extend: 'excel',
            //         //     text: 'Exportar a Excel',
            //         //     className: 'btn btn-success',
            //         //     exportOptions: {
            //         //         columns: [0, 1, 2, 3, 4, 5]
            //         //     }
            //         // }
            //     ],

            //     // Mostrar el selector de cantidad de entidades y establecer 50 como valor por defecto
            //     pageLength: 50,  // Mostrar 50 registros por defecto
            //     lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opciones para seleccionar cantidad de registros

            //     // Traducción manual al español
            //     language: {
            //         processing: "Procesando...",
            //         search: "Buscar:",
            //         lengthMenu: "Mostrar _MENU_ registros por página",
            //         info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            //         infoEmpty: "Mostrando 0 a 0 de 0 registros",
            //         infoFiltered: "(filtrado de _MAX_ registros totales)",
            //         loadingRecords: "Cargando...",
            //         zeroRecords: "No se encontraron registros coincidentes",
            //         emptyTable: "No hay datos disponibles en la tabla",
            //         paginate: {
            //             first: "Primero",
            //             previous: "Anterior",
            //             next: "Siguiente",
            //             last: "Último"
            //         },
            //         aria: {
            //             sortAscending: ": activar para ordenar la columna en orden ascendente",
            //             sortDescending: ": activar para ordenar la columna en orden descendente"
            //         }
            //     },
            //     // Ocultar la columna de ID y ordenar por la fecha de alta con este formato 'DD/MM/YY'
            //     columnDefs: [
            //         {
            //             targets: [1,2,3,4,5,6,7,8,9,10],  // Índices de las columnas con textos truncados
            //             render: function(data, type, row, meta) {
            //                 if (type === 'filter' || type === 'sort') {
            //                     // Accede directamente al atributo data-fulltext de la celda
            //                     return meta.settings.aoData[meta.row].anCells[meta.col].getAttribute('data-fulltext');
            //                 }
            //                 // Devuelve el contenido visible para la visualización
            //                 return data;
            //             }
            //         }
            //     ],
            // });

            // $('.createProveedorBtn').removeClass('dt-button');

            // Inicializar la tabla de citas
            const agTablediv = document.querySelector('#ProveedoresGrid');

            let rowData = {};
            let data = [];

            const proveedores = @json($proveedores);

            const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
                { 
                    name: 'ID',
                    fieldName: 'proveedor_id',
                    addAttributes: true, 
                    addcustomDatasets: true,
                    dataAttributes: { 
                        'data-id': 'editProjectFast'
                    },
                    attrclassName: 'proveedorEditFast',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                    principal: true
                },
                { 
                    name: 'CIF',
                    fieldName: 'cifProveedor',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "cifProveedor",
                        'data-type': "text"
                    }
                }, 
                { 
                    name: 'Nombre',
                    fieldName: 'nombreProveedor',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "nombreProveedor",
                        'data-type': "text"
                    }
                }, 
                { 
                    name: 'Direccion',
                    fieldName: 'direccionProveedor',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "direccionProveedor",
                        'data-type': "text"
                    }
                }, 
                { 
                    name: 'ZIP',
                    fieldName: 'codigoPostalProveedor',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "codigoPostalProveedor",
                        'data-type': "text"
                    }
                }, 
                { 
                    name: 'Ciudad',
                },
                { 
                    name: 'Email',
                    fieldName: 'emailProveedor',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "emailProveedor",
                        'data-type': "text"
                    }
                },
                { 
                    name: 'Agente',
                    fieldName: 'agenteProveedor',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "agenteProveedor",
                        'data-type': "text"
                    }
                },
                { 
                    name: 'Tipo',
                },
                { 
                    name: 'Banco',
                },
                { 
                    name: 'SbctaIni',
                    fieldName: 'Scta_ConInicio',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "Scta_ConInicio",
                        'data-type': "text"
                    }
                },
                { 
                    name: 'SbctaCon',
                    fieldName: 'Scta_Contable',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "Scta_Contable",
                        'data-type': "text"
                    }
                },
                { 
                    name: 'Observaciones',
                    fieldName: 'observacionesProveedor',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "observacionesProveedor",
                        'data-type': "text"
                    }
                },
                { 
                    name: 'Acciones',
                    className: 'acciones-column'
                }
            ];

            function prepareRowData(proveedores) {
                proveedores.forEach(proveedor => {
                    // if (proveedor.proyecto_n_m_n && proveedor.proyecto_n_m_n.length > 0) {
                    //     console.log({proyecto: proveedor.proyecto_n_m_n[0].proyecto.name});
                    // }
                    rowData[proveedor.idProveedor] = {
                        ID: proveedor.idProveedor,
                        CIF: proveedor.cifProveedor,
                        Nombre: proveedor.nombreProveedor,
                        Direccion: proveedor.direccionProveedor,
                        ZIP: proveedor.codigoPostalProveedor,
                        Ciudad: (proveedor.ciudad) ? proveedor.ciudad.nameCiudad : '',
                        Email: proveedor.emailProveedor,
                        Agente: proveedor.agenteProveedor,
                        Tipo: (proveedor.tipoProveedor) == 2 ? 'Proveedor' : 'Acreedor',
                        Banco: (proveedor.banco) ? proveedor.banco.nameBanco : '',
                        SbctaIni: proveedor.Scta_ConInicio,
                        SbctaCon: proveedor.Scta_Contable,
                        Observaciones: proveedor.observacionesProveedor,
                        Acciones: 
                        `
                            @component('components.actions-button')
                                <button 
                                    class="btn btn-info btnOpenDetailsModal"
                                    data-id="${proveedor.idProveedor}"
                                    data-cif="${proveedor.cifProveedor}"
                                    data-nombre="${proveedor.nombreProveedor}"
                                    data-direccion="${proveedor.direccionProveedor}"
                                    data-codigo-postal="${proveedor.codigoPostalProveedor}"
                                    data-ciudad="${proveedor.ciudad_id}"
                                    data-email="${proveedor.emailProveedor}"
                                    data-agente="${proveedor.agenteProveedor}"
                                    data-tipo="${ (proveedor.tipoProveedor) == 2 ? 'Proveedor' : 'Acreedor' }"
                                    data-banco-id="${proveedor.banco_id}"
                                    data-scta-con-inicio="${proveedor.Scta_ConInicio}"
                                    data-scta-contable="${proveedor.Scta_Contable}"
                                    data-observaciones="${proveedor.observacionesProveedor}"
                                    data-toggle="modal"
                                    data-target="#modalDetallesProveedor"
                                >
                                    <div class="d-flex justify-content-center">
                                        <ion-icon name="eye-outline"></ion-icon>
                                        <span class="ml-2">Detalles</span>
                                    </div>
                                </button>
                                <button 
                                    data-id="${proveedor.idProveedor}"
                                    data-cif="${proveedor.cifProveedor}"
                                    data-nombre="${proveedor.nombreProveedor}"
                                    data-direccion="${proveedor.direccionProveedor}"
                                    data-codigo-postal="${proveedor.codigoPostalProveedor}"
                                    data-ciudad="${proveedor.ciudad_id}"
                                    data-email="${proveedor.emailProveedor}"
                                    data-agente="${proveedor.agenteProveedor}"
                                    data-tipo="${ (proveedor.tipoProveedor) == 2 ? 'Proveedor' : 'Acreedor' }"
                                    data-banco-id="${proveedor.banco_id}"
                                    data-scta-con-inicio="${proveedor.Scta_ConInicio}"
                                    data-scta-contable="${proveedor.Scta_Contable}"
                                    data-observaciones="${proveedor.observacionesProveedor}"
                                    class="btn btn-primary btnOpenEditModal"
                                    data-toggle="modal"
                                    data-target="#modalEditProveedor"
                                >
                                    <div class="d-flex justify-content-center">
                                        <ion-icon name="create-outline"></ion-icon>
                                        <span class="ml-2">Editar</span>
                                    </div>
                                </button>
                            @endcomponent   
                        `
                    }
                });

                data = Object.values(rowData);
            }

            prepareRowData(proveedores);

            const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
                const customButtons = `
                    <button class="btn btn-outline-warning createProveedorBtn mb-2">
                        Crear Proveedor
                    </button>
                `;

                // Inicializar la tabla de citas
                inicializarAGtable( agTablediv, data, result, 'Proveedores', customButtons, 'Proveedor');
            });

            let table = $('#ProveedoresGrid');

            $('button.direccion-btnSearch').on('click', function(){
                const street = $('input.direccion').val();

                if( street.length > 0 ){
                    $.ajax({
                        url: 'https://nominatim.openstreetmap.org/search',
                        data: {
                            q: `${street}, Córdoba, España`,
                            format: 'json',
                            adressdetails: 1,
                            limit: 10
                        },
                        beforeSend: function(){
                            // mostrar un spinner de carga en el input

                            const suggestionsClose = $('#suggestions');

                            suggestionsClose.empty();

                            const suggestionItem = $('<div class="suggestion">Cargando...</div>');

                            suggestionsClose.append(suggestionItem);

                        },
                        success: function(data){
                            
                            const suggestionsClose = $('#suggestions');

                            suggestionsClose.empty();

                            if ( data.length > 0 ) {
                                data.forEach( suggestion => {
                                    suggestionsClose.append(
                                        `
                                            <div data-name="${suggestion.display_name}" class="suggestion-item">${suggestion.display_name}</div>
                                        `
                                    )
                                });

                                $('.suggestion-item').on('click', function(){
                                    const selectedStreet = $(this).attr('data-name');
                                    $('input.direccion').val(selectedStreet); 
                                    suggestionsClose.empty();

                                    // agregar el codigo postal al input correspondiente y seleccionar la ciudad 1

                                    const postalCode = selectedStreet.split(',')

                                    postalCode.forEach( (item, index) => {
                                        // convertir a numero y verificar si es un numero para agregarlo al input
                                        if( !isNaN(parseInt(item)) ){
                                            $('#codigoPostalProveedor').val(parseInt(item));
                                        }
                                    })

                                    $('#ciudad_id').val(1);

                                })
                                
                            }else{
                                suggestionsClose.empty();

                                const suggestionItem = $('<div class="suggestion">No se encontraron sugerencias</div>');
                            }
                            

                        },
                        error: function(error){
                            console.log(error);
                        }
                    })
                }

            })

            // function toggleExpandAsunto(element) {
            //     // Obtener el texto completo y truncado del atributo data-fulltext
            //     let fullText = element.getAttribute('data-fulltext');
            //     let truncatedText = fullText.length > 5 ? fullText.substring(0, 5) + '...' : fullText;

            //     // Comparar el texto actual con el fulltext para decidir la acción
            //     if (element.innerText === fullText) {
            //         element.innerText = truncatedText;  // Mostrar truncado
            //     } else {
            //         element.innerText = fullText;  // Mostrar completo
            //     }
            // }

            // table.on('click', '.text-truncate', function(event) {
            //     toggleExpandAsunto(this);
            // });

            $('.text-truncate').css('cursor', 'pointer');


            // Abrir el modal de detalles y rellenar campos
            table.on('click','.btnOpenDetailsModal', function () {
                $('#cifProveedorDetalles').val($(this).data('cif'));
                $('#nombreProveedorDetalles').val($(this).data('nombre'));
                $('#direccionProveedorDetalles').val($(this).data('direccion'));
                $('#codigoPostalProveedorDetalles').val($(this).data('codigo-postal'));
                $('#ciudadDetalles').val($(this).data('ciudad'));
                $('#emailProveedorDetalles').val($(this).data('email'));
                $('#agenteProveedorDetalles').val($(this).data('agente'));
                $('#tipoProveedorDetalles').val($(this).data('tipo'));
                $('#bancoDetalles').val($(this).data('banco-id'));
                $('#Scta_ConInicioDetalles').val($(this).data('scta-con-inicio'));
                $('#Scta_ContableDetalles').val($(this).data('scta-contable'));
                $('#observacionesProveedorDetalles').val($(this).data('observaciones'));

                $('#modalDetallesProveedor').modal('show');

            });

            // Abrir el modal de edición y rellenar campos
            table.on('click', '.btnOpenEditModal', function () {
                // Obtener el ID del proveedor desde el botón
                const proveedorId = $(this).data('id');

                editProveedor(proveedorId);
            });

            table.on('dblclick', '.proveedorEditFast', function (event){
                const proveedorId = $(this).data('parteid');
                console.log(proveedorId);
                editProveedor(proveedorId);
            });

            // Crear Proveedor
            table.on('click','.createProveedorBtn', function () {
                $('#modalCreateProveedor').modal('show');
            });

            $('#btnCreateProveedor').on('click', function () {
                $('#formCreateProveedor').submit();
            });

            // Editar Proveedor
            $('#btnEditProveedor').on('click', function () {
                $('#formEditProveedor').submit();
            });

        });
    </script>
@stop
