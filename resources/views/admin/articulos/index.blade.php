@extends('adminlte::page')

@section('title', 'Articulos')

@section('content')

    <div id="tableCard" class="card">
        <button id="activeModalCreate" type="button" style="max-width: 200px" class="btn btn-outline-success createArticlebtn d-none">Crear</button>
        <div class="card-body">

            <div id="ArticulosGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>

            {{-- <table class="table table-striped" id="articlesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Articulo</th>
                        <th>Trazabilidad</th>
                        <th>Stock</th>
                        <th>P.Costo</th>
                        <th>Beneficio</th>
                        <th>P.venta</th>
                        <th>Empresa</th>
                        <th>Proveedor</th>
                        <th>SubCuenta</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @foreach ($articulos as $articulo)
                        @php
                            $trazabilidad = formatTrazabilidad($articulo->TrazabilidadArticulos);    
                        
                        @endphp
                        <tr
                            class="mantenerPulsadoParaSubrayar"
                        >
                            <td>{{ $articulo->idArticulo }}</td>
                            <td>
                                @if ( isset($articulo->imagenes) && count($articulo->imagenes) > 0 )
                                    @php

                                        $img = $articulo->imagenes[0];

                                        $path = $img->pathFile;
                                        $serverUrl = "https://sebcompanyes.com";
                                        $rutaArchivo = "/home/u657674604/domains/sebcompanyes.com/public_html";
                                        $rutaModificada = str_replace($rutaArchivo, $serverUrl, $path);
                                    @endphp
                                    <img
                                        src="{{ $rutaModificada }}"
                                        alt="{{ $articulo->nombreArticulo }}"
                                        class="img-thumbnail"
                                        style="width: 50px; height: 50px"
                                    >
                                @endif
                            </td>
                            <td
                                class="text-truncate"
                                data-fulltext="{{ $articulo->nombreArticulo }}"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ $articulo->nombreArticulo }}"
                            >
                                {{ Str::limit($articulo->nombreArticulo, 5) }}
                            </td>
                            @if ( $articulo->articulo_id )
                                <td
                                    class="text-truncate"
                                    data-fulltext="Traspaso del articulo con ID: {{$trazabilidad }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Traspaso del articulo con ID: {{$trazabilidad }}"
                                >{{ Str::limit("Traspaso del articulo con ID: $trazabilidad", 5) }}</td>
                                <td
                                    class="text-truncate"
                                    data-fulltext="Cantidad de transpaso: {{ $articulo->cantidad_traspasada }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Cantidad de transpaso: {{ $articulo->cantidad_traspasada }}"
                                >
                                    {{ Str::limit("Cantidad de transpaso: $articulo->cantidad_traspasada", 5) }}
                                </td>
                                @else
                                <td
                                    class="text-truncate"
                                    data-fulltext="{{ $trazabilidad }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="{{ $trazabilidad }}"
                                >{{ Str::limit($trazabilidad, 5) }}</td>
                                <td>{{ ($articulo->stock) ?  $articulo->stock->cantidad : 0 }}</td>
                            @endif
                            <td>{{ number_format($articulo->ptsCosto, 2, ',', '.') }}€</td>
                            <td>{{ number_format($articulo->Beneficio, 2, ',', '.') }}€</td>
                            <td>{{ number_format($articulo->ptsVenta, 2, ',', '.') }}€</td>
                            <td
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ ( $articulo->empresa ) ? $articulo->empresa->EMP : 'Recurrente' }}"
                                class="text-truncate"
                                data-fulltext="{{ ( $articulo->empresa ) ? $articulo->empresa->EMP : 'Recurrente' }}"
                            >{{ Str::limit(( $articulo->empresa ) ? $articulo->empresa->EMP : 'Recurrente', 5) }}</td>
                            <td
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ ($articulo->proveedor) ? $articulo->proveedor->nombreProveedor : 'Recurrente' }}"
                                class="text-truncate"
                                data-fulltext="{{ ($articulo->proveedor) ? $articulo->proveedor->nombreProveedor : 'Recurrente' }}"
                            >{{ Str::limit(($articulo->proveedor) ? $articulo->proveedor->nombreProveedor : 'Recurrente', 5) }}</td>
                            <td
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ $articulo->SubctaInicio }}"
                                class="text-truncate"
                                data-fulltext="{{ $articulo->SubctaInicio }}"
                            >{{ Str::limit($articulo->SubctaInicio, 5) }}</td>
                            <td
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ $articulo->Observaciones }}"
                                class="text-truncate"
                                data-fulltext="{{ $articulo->Observaciones }}"
                            >{{ Str::limit($articulo->Observaciones, 5) }}</td>
                            <td>
                                @component('components.actions-button')
                                    <button 
                                        data-id="{{ $articulo->idArticulo }}"
                                        data-name="{{ $articulo->nombreArticulo }}"
                                        data-trazabilidad="{{ $articulo->TrazabilidadArticulos }}"
                                        data-stockinfo="{{ $articulo->stock }}"
                                        data-empresainfo="{{ $articulo->empresa }}"
                                        data-categoriainfo="{{ $articulo->categoria }}"
                                        data-proveedorinfo="{{ $articulo->proveedor }}"
                                        data-ptscosto="{{ $articulo->ptsCosto }}"
                                        data-ptsventa="{{ $articulo->ptsVenta }}"
                                        data-beneficio="{{ $articulo->Beneficio }}"
                                        data-subctainicio="{{ $articulo->SubctaInicio }}"
                                        data-observaciones="{{ $articulo->observaciones }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Detalles"
                                        class="btn btn-info detallesArticle">
                                        <ion-icon name="information-circle-outline"></ion-icon>
                                    </button>
                                    @if ( !$articulo->articulo_id )
                                        <button 
                                            data-id="{{ $articulo->idArticulo }}"
                                            data-name="{{ $articulo->nombreArticulo }}"
                                            data-trazabilidad="{{ $articulo->TrazabilidadArticulos }}"
                                            data-stockinfo="{{ $articulo->stock }}"
                                            data-empresainfo="{{ $articulo->empresa }}"
                                            data-categoriainfo="{{ $articulo->categoria }}"
                                            data-proveedorinfo="{{ $articulo->proveedor }}"
                                            data-ptscosto="{{ $articulo->ptsCosto }}"
                                            data-ptsventa="{{ $articulo->ptsVenta }}"
                                            data-beneficio="{{ $articulo->Beneficio }}"
                                            data-subctainicio="{{ $articulo->SubctaInicio }}"
                                            data-observaciones="{{ $articulo->observaciones }}"
                                            data-imagenes="{{ json_encode($articulo->imagenes) }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Editar"
                                            class="btn btn-primary editArticle">
                                            <ion-icon name="create-outline"></ion-icon>
                                        </button>
                                    @endif
                                    {{-- Ver historial de usos --}}
                                    {{-- <button
                                        class="btn btn-success showHistorial"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Historial de usos"
                                        data-id="{{ $articulo->idArticulo }}"
                                        data-nameart="{{ $articulo->nombreArticulo }}"
                                        data-trazabilidad="{{ $trazabilidad }}"
                                    >
                                        <ion-icon name="time-outline"></ion-icon>
                                    </button>
                                @endcomponent --}}
                            {{-- </td>
                        </tr> --}}
                    {{-- @endforeach --}}
                {{-- </tbody> --}}
            {{-- </table>  --}}
        </div>
    </div>

    @component('components.modal-component', [
        'modalId' => 'createArticleModal',
        'modalTitleId' => 'createArticleModalLabel',
        'modalTitle' => 'Crear articulo',
        'btnSaveId' => 'saveArticleBtn',
        'modalSize' => 'modal-xl',
    ])

        @include('admin.articulos.articulosForm')

    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'editParteTrabajoModal',
        'modalTitle' => 'Editar Parte de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveEditParteTrabajoBtn',
        'modalTitleId' => 'editParteTrabajoTitle',
        'otherButtonsContainer' => 'editParteTrabajoFooter'
    ])
       @include('admin.partes_trabajo.form')
    @endcomponent

    {{-- Modal para editar la linea de material --}}
    @component('components.modal-component', [
        'modalId' => 'editMaterialLineModal',
        'modalTitle' => 'Editar Linea de Material',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editMaterialLineTitle',
        'btnSaveId' => 'saveEditMaterialLineBtn'
    ])
        
        <form id="formEditMaterialLine" method="POST">
            @csrf
            <input type="hidden" name="lineaId" id="lineaId">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="material_id">Articulo</label>
                    <select id="material_id" name="material_id" class="form-select">
                        @foreach ($articulos as $articulo)
                            <option data-namearticulo="{{ $articulo->nombreArticulo }}" value="{{ $articulo->idArticulo }}">
                                {{ $articulo->nombreArticulo }} | {{ formatTrazabilidad($articulo->TrazabilidadArticulos) }} | stock: {{ $articulo->stock->cantidad }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-4">
                    <label for="precio">Precio</label>
                    <input type="number" class="form-control" id="precio" name="precio" placeholder="Precio">
                </div>
                <div class="form-group col-md-4">
                    <label for="descuento">Descuento</label>
                    <input type="number" class="form-control" id="descuento" name="descuento" placeholder="descuento">
                </div>
                <div class="form-group
                    col-md-4">
                    <label for="total">Total</label>
                    <input type="number" class="form-control" id="total" name="total" placeholder="Total" disabled>
                </div>
            </div>
        </form>

        
    @endcomponent

    @component('components.modal-component',[
        'modalId' => 'editArticleModal',
        'modalTitleId' => 'editArticleModalLabel',
        'modalTitle' => 'Editar articulo',
        'btnSaveId' => 'saveEditArticleBtn',
        'modalSize' => 'modal-lg',
    ])

        <form method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="">
            <div class="container">

                {{-- Campos prioritarios --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ptsCosto" class="form-label">Costo</label>
                        <input type="text" class="form-control" id="ptsCosto" name="ptsCosto">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ptsVenta" class="form-label">Venta</label>
                        <input type="text" class="form-control" id="ptsVenta" name="ptsVenta">
                    </div>
                </div>

                {{-- Campos con cálculos --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="Beneficio" class="form-label">Beneficio</label>
                        <input type="text" class="form-control" id="Beneficio" name="Beneficio" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="empresa_id" class="form-label">Empresa</label>
                        <select class="form-select" id="empresa_id" name="empresa_id">
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->idEmpresa }}">{{ $empresa->EMP }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="categoria_id" class="form-label">Categoría</label>
                        <select class="form-select" id="categoria_id" name="categoria_id">
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->idArticuloCategoria }}">{{ $categoria->nameCategoria }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Campos adicionales --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="proveedor_id" class="form-label">Proveedor</label>
                        <select class="form-select" id="proveedor_id" name="proveedor_id">
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->idProveedor }}">{{ $proveedor->nombreProveedor }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="TrazabilidadArticulos" class="form-label">Trazabilidad</label>
                        <select class="form-select" id="TrazabilidadArticulos" name="TrazabilidadArticulos">
                            @foreach ($trazabilidades as $trazabilidad)
                                <option value="{{ $trazabilidad->compra_id }}">{{ $trazabilidad->trazabilidad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="SubctaInicio" class="form-label">SubctaInicio</label>
                        <input type="text" class="form-control" id="SubctaInicio" name="SubctaInicio">
                    </div>
                </div>

                {{-- Campos de fechas y cantidad --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="ultimaCompraDate" class="form-label">Última Compra</label>
                        <input type="date" class="form-control" id="ultimaCompraDate" name="ultimaCompraDate">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="existenciasMin" class="form-label">Existencias Mínimas</label>
                        <input type="number" class="form-control" id="existenciasMin" name="existenciasMin">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="existenciasMax" class="form-label">Existencias Máximas</label>
                        <input type="number" class="form-control" id="existenciasMax" name="existenciasMax">
                    </div>
                </div>

                {{-- Campo de cantidad y observaciones --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad">
                    </div>
                    <div class="col-md-4 mb-3">
                        <textarea placeholder="Observaciones" class="form-control" name="observaciones" id="observaciones" cols="40" rows="3"></textarea>
                    </div>
                </div>

                {{-- Input para cargar imagenes --}}
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="images">Imagenes</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                    </div>
                </div>

                {{-- Contenedor para mostrar la vista previa de las imagenes --}}
                <div class="row" id="previewImages"></div>

            </div>
        </form>
        
    @endcomponent

    {{-- Modal para mostrar el historial de usos del articulo --}}
    @component('components.modal-component',[
        'modalId' => 'showDetailsModal',
        'modalTitleId' => 'showDetailsModalLabel',
        'modalTitle' => 'Historial de usos',
        'modalSize' => 'modal-xl',
        'hideButton' => true,
    ])

        <div class="row col-sm-12" id="showAccordeons">

        </div>
        
    @endcomponent

@stop


@section('js')
    <script>
        $(document).ready(function() {

            const agTablediv = document.querySelector('#ArticulosGrid');

            let rowData = {};
            let data = [];

            const articulos = @json($articulos);

            const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
                { 
                    name: 'ID',
                    fieldName: 'idArticulo',
                    addAttributes: true, 
                    addcustomDatasets: true,
                    dataAttributes: { 
                        'data-id': ''
                    },
                    attrclassName: 'editArticleFast',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                    principal: true
                },
                {
                    name: 'Imagen',
                    type: 'image',
                },
                {
                    name: "CodProveedor",
                },
                {
                    name: 'Articulo',
                },
                {
                    name: 'Trazabilidad',
                },
                {
                    name: 'Stock',
                },
                {
                    name: 'PCosto',
                },
                {
                    name: 'Beneficio',
                },
                {
                    name: 'Pventa',
                },
                {
                    name: 'Empresa',
                },
                { 
                    name: 'Proveedor',
                    fieldName: 'proveedor_id',
                    fieldType: 'select',
                    addAttributes: true,
                },
                {
                    name: 'SubCuenta',
                },
                {
                    name: 'Observaciones',
                },
                { 
                    name: 'Acciones',
                    className: 'acciones-column'
                }
            ];

            function prepareRowData(articulos) {
                articulos.forEach(articulo => {
                    let urlFinal = '';
                    if (articulo.imagenes.length > 0) {
                        let archivo = articulo.imagenes[0];
                        let url = archivo.pathFile;

                        urlFinal = globalBaseUrl + url;
                    }
                    // buscar el codProveedor dentro de articulo.compras.lineas
                    let codProveedor = articulo.compras?.lineas?.filter(linea => {
                        return (linea.articulo_id == articulo.idArticulo);
                    });

                    codProveedor = ( codProveedor && codProveedor.length > 0 ) ? codProveedor[0].cod_proveedor : '';

                    rowData[articulo.idArticulo] = {
                        ID: articulo.idArticulo,
                        Imagen: `${ (articulo.imagenes.length > 0) ? urlFinal: '' }`,
                        CodProveedor: codProveedor,
                        Articulo: articulo.nombreArticulo,
                        Trazabilidad: formatTrazabilidad(articulo.TrazabilidadArticulos),
                        Stock: (articulo.stock) ? articulo.stock.cantidad : 0,
                        PCosto: formatPrice(articulo.ptsCosto),
                        Beneficio: formatPrice(articulo.Beneficio),
                        Pventa: formatPrice(articulo.ptsVenta),
                        Empresa: (articulo.empresa) ? articulo.empresa.EMP : 'Recurrente',
                        Proveedor: (articulo.proveedor != null) ? articulo.proveedor.nombreProveedor : 'Recurrente',
                        SubCuenta: articulo.SubctaInicio,
                        Observaciones: articulo.Observaciones,
                        Acciones: `
                            @component('components.actions-button')
                                <button 
                                    data-id="${articulo.idArticulo}"
                                    data-name="${articulo.nombreArticulo}"
                                    data-trazabilidad="${articulo.TrazabilidadArticulos}"
                                    data-stockinfo='${JSON.stringify(articulo.stock)}'
                                    data-empresainfo='${JSON.stringify(articulo.empresa)}'
                                    data-categoriainfo='${JSON.stringify(articulo.categoria)}'
                                    data-proveedorinfo='${JSON.stringify(articulo.proveedor)}'
                                    data-ptscosto="${articulo.ptsCosto}"
                                    data-ptsventa="${articulo.ptsVenta}"
                                    data-beneficio="${articulo.Beneficio}"
                                    data-subctainicio="${articulo.SubctaInicio}"
                                    data-observaciones="${articulo.Observaciones}"
                                    data-imagenes='${JSON.stringify(articulo.imagenes)}'
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Detalles"
                                    class="btn btn-info detallesArticle"
                                >
                                    <ion-icon name="information-circle-outline"></ion-icon>
                                </button>
                                <button 
                                    data-id="${articulo.idArticulo}"
                                    data-name="${articulo.nombreArticulo}"
                                    data-trazabilidad="${articulo.TrazabilidadArticulos}"
                                    data-stockinfo='${JSON.stringify(articulo.stock)}'
                                    data-empresainfo='${JSON.stringify(articulo.empresa)}'
                                    data-categoriainfo='${JSON.stringify(articulo.categoria)}'
                                    data-proveedorinfo='${JSON.stringify(articulo.proveedor)}'
                                    data-ptscosto="${articulo.ptsCosto}"
                                    data-ptsventa="${articulo.ptsVenta}"
                                    data-beneficio="${articulo.Beneficio}"
                                    data-subctainicio="${articulo.SubctaInicio}"
                                    data-observaciones="${articulo.Observaciones}"
                                    data-imagenes='${JSON.stringify(articulo.imagenes)}'
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Editar"
                                    class="btn btn-primary editArticle"
                                >
                                    <ion-icon name="create-outline"></ion-icon>
                                </button>
                                <button
                                    class="btn btn-success showHistorial"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Historial de usos"
                                    data-id="${articulo.idArticulo}"
                                    data-nameart="${articulo.nombreArticulo}"
                                    data-trazabilidad="${formatTrazabilidad(articulo.TrazabilidadArticulos)}"
                                >
                                    <ion-icon name="time-outline"></ion-icon>
                                </button>
                            @endcomponent
                        `
                    }
                });

                data = Object.values(rowData);
            }

            prepareRowData(articulos);

            const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
                const customButtons = `
                    <small></small>
                `;

                // Inicializar la tabla de citas
                inicializarAGtable( agTablediv, data, result, 'Articulos', customButtons, 'Articulos');
            });

        

            // let table = $('#articlesTable').DataTable({
            //     colReorder: {
            //         realtime: false
            //     },
            //     order: [[0, 'desc']],
            //     // autoFill: true,
            //     // fixedColumns: true,
            //     dom: 
            //     "<'row'<'col-12 mb-2'<'table-title'>>>" +
            //     "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
            //     "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
            //     "<'row'<'col-12'tr>>" +
            //     "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

            //     buttons: [
            //         // {
            //         //     text: 'Crear Cita',
            //         //     className: 'btn btn-outline-warning mb-2 activeModalCreate',
            //         //     action: function () {
            //         //         $('#activeModalCreate').click();
            //         //     }
            //         // },
            //         {
            //             text: 'Limpiar Filtros', 
            //             className: 'btn btn-outline-danger limpiarFiltrosBtn mb-2', 
            //             action: function (e, dt, node, config) { 
            //                 clearFiltrosFunction(dt, '#clientes-table');
            //             }
            //         }
            //     ],

            //     // Mostrar el selector de cantidad de entidades y establecer 50 como valor por defecto
            //     pageLength: 50,  // Mostrar 50 registros por defecto
            //     lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opciones para seleccionar cantidad de registros

            //     // Traducción manual al español
            //     language: {
            //         processing: "Procesando...",
            //         search: "Buscar:",
            //         lengthMenu: "Mostrar _MENU_",
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
            //             targets: [1, 2, 7, 8, 9, 10],  // Índices de las columnas con textos truncados
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
            //     initComplete: function () {
            //     configureInitComplete(this.api(), '#articlesTable', 'ARTICULOS', 'dark');
            // }
            // });

            // table.on('init.dt', function() {
            //     restoreFilters(table, '#articlesTable'); // Restaurar filtros después de inicializar la tabla
            // });

            // mantenerFilaYsubrayar(table);
            // fastEditForm(table, 'Articulos');


            // Mostrar el historia

            let table = $('#ArticulosGrid');

            const calculateTotalSum = (parteTrabajoId = null) => {
                let totalSum = 0;
                $('#elementsToShow tr').each(function() {
                    const total = parseFloat($(this).find('.material-total').text());
                    if (!isNaN(total)) {
                        totalSum += total;
                    }
                });
                $('#suma').val(totalSum.toFixed(2));

                if (parteTrabajoId) {
                    $.ajax({
                        url: "{{ route('admin.partes.updatesum') }}",
                        method: 'POST',
                        data: {
                            parteTrabajoId: parteTrabajoId,
                            suma: totalSum,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                console.log('Suma actualizada correctamente');
                            } else {
                                console.error('Error al actualizar la suma');
                            }
                        },
                        error: function(err) {
                            console.error(err);
                        }
                    });
                }
            };

            const calculatePriceHoraXcantidad = (cantidad_form, precio_form, descuento) => {
                const cantidad = parseFloat(cantidad_form);
                const precio = parseFloat(precio_form);
                const descuentoCliente = parseFloat(descuento);

                if ( !isNaN(cantidad) && !isNaN(precio) ) {
                    const total = cantidad * precio;
                    if( descuentoCliente == 0 ){
                        $('#editParteTrabajoModal #precio_hora').val(total.toFixed(2));
                    }else{
                        const totalDescuento = total - (total * (descuentoCliente / 100));
                        $('#editParteTrabajoModal #precio_hora').val(totalDescuento.toFixed(2));
                        $('#editParteTrabajoModal #precioHoraHelp').fadeIn().text(`Precio con descuento del ${descuentoCliente}%`);
                    }
                }
            };

            const calculateDifHours = (hora_inicio, hora_fin, itemRender, precio_hora, descuento) => {
                // Obtener los valores de los campos input (hora_inicio y hora_fin)
                let horaInicio = $(hora_inicio).val();
                let horaFin = $(hora_fin).val();

                // Validar si ambos valores existen y no están vacíos
                if (horaInicio && horaFin) {
                    // Asegurarse de que las horas estén en el formato correcto (HH:mm)
                    const horaInicioFormatted = moment(horaInicio, 'HH:mm');
                    const horaFinFormatted = moment(horaFin, 'HH:mm');

                    // Verificar si las horas son válidas
                    if (horaInicioFormatted.isValid() && horaFinFormatted.isValid()) {
                        // Validar que la hora de fin no sea anterior a la hora de inicio
                        if (horaFinFormatted.isBefore(horaInicioFormatted)) {
                            $(itemRender).val(''); // Limpia el campo de horas trabajadas
                            $(hora_fin).val(''); // Limpia el campo de hora de fin
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'La hora de fin no puede ser anterior a la hora de inicio',
                            });
                            return;
                        }

                        // Calcular la diferencia en milisegundos
                        const duration = moment.duration(horaFinFormatted.diff(horaInicioFormatted));
                        
                        // Convertir la diferencia a horas con decimales
                        const hoursWorked = duration.asHours(); // Ejemplo: 2.5 horas

                        // Asignar la diferencia calculada al elemento de destino como un número
                        $(itemRender).val(hoursWorked.toFixed(2)); // Redondear a 2 decimales

                        calculatePriceHoraXcantidad(hoursWorked, precio_hora, descuento);

                    } else {
                        console.error('Las horas proporcionadas no son válidas');
                    }
                } else {
                    console.error('Debes proporcionar ambas horas: hora de inicio y hora de fin');
                }
            };


            table.on('click', '.showHistorial', function(event){
                openLoader();
                const id = $(this).data('id');
                const name = $(this).data('nameart');
                const trazabilidad = $(this).data('trazabilidad');

                getHistorial(id, name, trazabilidad);

            });

            table.on('dblclick', '.editArticleFast', function() {
                const idModal = $('#editArticleModal');
                const id = $(this).data('parteid');
                
                getEditArticle(id, idModal);
            });
            
            $('.limpiarFiltrosBtn').removeClass('dt-button');
            $('.activeModalCreate').removeClass('dt-button');

            $('#createArticleModal #ptsVenta').keyup(function() {
                const costo = $('#createArticleModal #ptsCosto').val();
                const venta = $(this).val();

                const beneficio = venta - costo;

                $('#createArticleModal #Beneficio').val(beneficio);
            });

            $('#createArticleModal #ptsCosto').keyup(function() {
                const costo = $(this).val();

                // asignar el campo venta automaticamente con el 25% de beneficio sobre el costo

                const costoVenta = costo * 0.25;
                const venta = parseFloat(costo) + parseFloat(costoVenta);
                const beneficio = venta - costo;

                // redondear a 2 decimales
                $('#createArticleModal #ptsVenta').val(venta.toFixed(2));
                $('#createArticleModal #Beneficio').val(beneficio.toFixed(2));
            });

            $('#saveArticleBtn').click(function() {
                $('#createArticleModal form').submit();
            });

            $('.createArticlebtn').click(function() {
                $('#createArticleModal').modal('show');

                $('#createArticleModal').on('shown.bs.modal', () => {
                    // Destruir la instancia de Select2, si existe
                    if ($('select.form-select').data('select2')) {
                        $('select.form-select').select2('destroy');
                    }

                    $('select.form-select').select2({
                        width: '100%',  // Asegura que el select ocupe el 100% del contenedor
                        dropdownParent: $('#createArticleModal')  // Asocia el dropdown con el modal para evitar problemas de superposición
                    });

                });

            });

            table.on('click', '.editArticle', function() {

                const idModal = $('#editArticleModal');
                const id = $(this).data('id');
                
                getEditArticle(id, idModal);

            });

            // Detalles
            table.on('click', '.detallesArticle', function() {
                const idModal = $('#editArticleModal');
                const id = $(this).data('id');
                const name = $(this).data('name');
                const trazabilidad = $(this).data('trazabilidad');
                const stockinfo = $(this).data('stockinfo');
                const empresa = $(this).data('empresainfo');
                const categoria = $(this).data('categoriainfo');
                const proveedor = $(this).data('proveedorinfo');
                const ptscosto = $(this).data('ptscosto');
                const ptsventa = $(this).data('ptsventa');
                const beneficio = $(this).data('beneficio');
                const subctainicio = $(this).data('subctainicio');
                const observaciones = $(this).data('observaciones');

                idModal.find('input[name="id"]').val(id);
                idModal.find('input[name="nombre"]').val(name);
                idModal.find('input[name="ptsCosto"]').val(ptscosto);
                idModal.find('input[name="ptsVenta"]').val(ptsventa);
                idModal.find('input[name="Beneficio"]').val(beneficio);
                idModal.find('input[name="SubctaInicio"]').val(subctainicio);
                idModal.find('textarea[name="observaciones"]').val(observaciones);
                idModal.find('input[name="cantidad"]').val(stockinfo.cantidad);
                idModal.find('input[name="existenciasMin"]').val(stockinfo.existenciasMin);
                idModal.find('input[name="existenciasMax"]').val(stockinfo.existenciasMax);
                idModal.find('input[name="ultimaCompraDate"]').val(stockinfo.ultimaCompraDate);

                idModal.find('select[name="empresa_id"]').val(empresa.idEmpresa).trigger('change');
                idModal.find('select[name="categoria_id"]').val(categoria.idArticuloCategoria).trigger('change');
                idModal.find('select[name="proveedor_id"]').val(proveedor.idProveedor).trigger('change');

                idModal.find('select[name="TrazabilidadArticulos"] option').each(function() {
                    if ($(this).text() === trazabilidad) {
                        $(this).attr('selected', 'selected');
                    }
                });

                $('#editArticleModal #ptsVenta').keyup(function() {
                    const costo = $('#editArticleModal #ptsCosto').val();
                    const venta = $(this).val();

                    const beneficio = venta - costo;

                    $('#editArticleModal #Beneficio').val(beneficio);
                });

                $('#editArticleModal #ptsCosto').keyup(function() {
                    const costo = $(this).val();
                    const venta = $('#editArticleModal #ptsVenta').val();

                    const beneficio = venta - costo;

                    $('#editArticleModal #Beneficio').val(beneficio);
                });

                $('#editArticleModal').modal('show');

                $('#editArticleModal input').attr('readonly', true);
                $('#editArticleModal select').attr('disabled', true);
                $('#editArticleModal textarea').attr('readonly', true);
                $('#editArticleModal #saveEditArticleBtn').hide();

            });

        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire(
                'Articulo creado',
                'El articulo se ha creado correctamente',
                'success'
            )
        </script>

    @endif

    @if (session('successEdit'))
        <script>
            Swal.fire(
                'Articulo actualizado',
                'El articulo se ha actualizado correctamente',
                'success'
            )
        </script>

    @endif

    @if (session('error'))
        <script>
            Swal.fire(
                'Error',
                'Ha ocurrido un error al crear el articulo',
                'error'
            )
        </script>

    @endif

@stop
