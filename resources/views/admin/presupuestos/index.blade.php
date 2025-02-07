@extends('adminlte::page')

@section('title', 'Presupuestos')

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
            border: 1px solid #007bff;
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

        .text-truncate{
            text-overflow: ellipsis;
            white-space: nowrap;
            text-decoration: underline;
            cursor: pointer;
        }

    </style>

    <div id="tableCard" class="card">
        <div class="card-body">
            <table id="partes_trabajo" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Proyecto</th>
                        <th>F.Alta</th>
                        <th>F.Visita</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($presupuestos as $parte)
                        <tr
                            class="mantenerPulsadoParaSubrayar"
                        >
                            <td>{{ $parte->idParteTrabajo }}</td>
                            <td
                                class="text-truncate"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{{ $parte->Asunto }}"
                                data-fulltext="{{ $parte->Asunto }}"
                            >
                                {{ Str::limit($parte->Asunto, 10) }}
                            </td>
                            <td>{{ formatDate($parte->FechaAlta) }}</td>
                            <td>{{ formatDate($parte->FechaVisita) }}</td>
                            <td>{{ $parte->cliente->NombreCliente }}</td>
                            <td>{{ formatPrice($parte->suma) }}</td>
                            <td>{{ ($parte->Estado == 1) ? 'Pendiente' : (($parte->Estado == 2) ? 'En proceso' : 'Finalizado') }}</td>
                            <td>
                                @component('components.actions-button')
                                    <button 
                                        type="button" 
                                        class="btn btn-info editPresupuestoBtn" 
                                        data-id="{{ $parte->idParteTrabajo }}"
                                    >
                                        <div class="d-flex justify-content-center flex-wrap flex-column align-items-center align-content-center">
                                            <ion-icon name="create-outline"></ion-icon>
                                            <small>Editar</small>
                                        </div>
                                    </button>
                                    <button 
                                        type="button" 
                                        class="btn btn-primary detailsPresupuestoBtn" 
                                        data-id="{{ $parte->idParteTrabajo }}"
                                    >
                                        <div class="d-flex justify-content-center flex-wrap flex-column align-items-center align-content-center">
                                            <ion-icon name="eye-outline"></ion-icon>
                                            <small>Detalles</small>
                                        </div>
                                    </button>
                                    @if ($parte->estadoVenta == 1)
                                        <button 
                                            type="button" 
                                            data-id="{{ $parte->idParteTrabajo }}"
                                            data-info="{{ json_encode($parte) }}"
                                            data-cliente="{{ json_encode($parte->cliente) }}"
                                            data-lineas="{{ json_encode($parte->partesTrabajoLineas) }}"
                                            class="btn btn-warning generateOrdenTrabajo"
                                        >
                                            <div class="d-flex justify-content-center flex-wrap flex-column align-items-center align-content-center">
                                                <ion-icon name="document-text-outline"></ion-icon>
                                                <small>Generar OT</small>
                                            </div>
                                        </button>
                                    @endif
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @component('components.modal-component', [
        'modalId' => 'createParteTrabajoModal',
        'modalTitle' => 'Crear Presupuesto',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveParteTrabajoBtn',
        'disabledSaveBtn' => true,
        'hideButton' => true
    ])
        @include('admin.presupuestos.form')
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'editPresupuestoModal',
        'modalTitle' => 'Editar presupuesto',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'editPresupuestoSaveBtn',
        'modalTitleId' => 'editPresupuestoTitle',
        'hideGuardar' => true,
        'otherButtonsContainer' => 'editPresupuestoFooter'
    ])
        @include('admin.presupuestos.form', ['hideGuardar' => true])
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'editParteTrabajoModal',
        'modalTitle' => 'Editar Parte de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveEditParteTrabajoPresuBtn',
    ])
        @include('admin.presupuestos.partesForm', ['hideButtonSave' => true, 'editParteTrabajo' => true])
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'detailsParteTrabajoModal',
        'modalTitle' => 'Detalles de la Parte de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'closeDetailsParteTrabajoBtn',
        'disabledSaveBtn' => true
    ])
        @include('admin.presupuestos.form', ['disabled' => true])
    @endcomponent

    {{-- Modal para imprimir --}}
    @component('components.modal-component', [
        'modalId' => 'imprimirPresupuestosModal',
        'modalTitle' => 'Imprimir Presupuestos',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'closeImprimirPresupuestosBtn',
        'nameButtonSave' => 'Imprimir',
        'hideButton'     => true
    ])
        @include('admin.presupuestos.imprimir')
    @endcomponent

    {{-- modal To create Orden de trabajo --}}
    @component('components.modal-component', [
        'modalId' => 'createOrdenTrabajoModal',
        'modalTitle' => 'Crear Orden de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveOrdenTrabajoBtn',
    ])
        <form method="POST">
            <div class="form-group">
                <label for="asunto">Operarios</label>
                <select class="form-select" name="operarios[]" multiple id="operariosId">
                    <option value="">Seleccione un operario / varios</option>
                    @foreach ($operarios as $operario)
                        <option value="{{ $operario->idOperario }}">{{ $operario->nameOperario }} | tel: {{ $operario->telefonoOperario }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'createParteTrabajoPresupuestoModal',
        'modalTitle' => 'Crear Capitulo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveParteTrabajoPresupuestoBtn',
        'disabledSaveBtn' => true,
        'hideButton' => true
    ])
        @include('admin.presupuestos.partesForm', ['disabled' => false])
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

    {{-- Componente para desfragmentar el formulario --}}
    @component('components.modal-component',[
        'modalId' => 'desfragmentarFormModal',
        'modalTitle' => 'Titulo del input',
        'modalSize' => 'modal-sm',
        'modalTitleId' => 'desfragmentarFormTitle',
        'btnSaveId' => 'saveDesfragmentarFormBtn',
        'modalTop' => true	
    ])

        <div class="form-row">
            <div class="col-sm-12" id="inputContainer"></div>
        </div>
        
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

    {{-- Modal para fichar un articulo de manera rápida --}}
    @component('components.modal-component',[
        'modalId' => 'createArticuloPresuFastModal',
        'modalTitleId' => 'ArticuloPresuTitle',
        'modalTitle' => 'Fichar un articulo para presupuesto',
        'modalSize' => 'modal-lg',
        'btnSaveId' => 'saveArticuloPresuFastBtn',
    ])

        @include('admin.presupuestos.articuloPresuForm')
        
    @endcomponent


@stop

@section('css')
    <style>
        .file-wrapper {
            display: inline-block;
            text-align: center;
            margin: 10px;
            width: 150px;
            vertical-align: top;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #previewImage1 {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-start;
        }

        .image-fluid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-start;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {

            let table = $('#partes_trabajo').DataTable({
                colReorder: {
                    realtime: false
                },
                // responsive: true,
                // autoFill: true,
                // fixedColumns: true,
                order: [[0, 'desc']],
                dom: 
                "<'row'<'col-12 mb-2'<'table-title'>>>"+
                "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
                "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
                "<'row'<'col-12'tr>>" +
                "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

                buttons: [
                    {
                        text: 'Crear nuevo presupuesto',
                        className: 'btn btn-outline-warning createParteTrabajoBtn mb-2',
                    },
                    {
                        text: 'Limpiar Filtros', 
                        className: 'btn btn-outline-danger limpiarFiltrosBtn mb-2', 
                        action: function (e, dt, node, config) { 
                            clearFiltrosFunction(dt, '#citasTable');
                        }
                    }
                    // {
                    //     text: 'Imprimir',
                    //     className: 'btn btn-outline-success imprimirPresupuestos mb-2',
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
                    configureInitComplete(this.api(), '#partes_trabajo', 'PRESUPUESTOS', 'dark');
                }
            });

            $('.limpiarFiltrosBtn').removeClass('dt-button')
            $('.createParteTrabajoBtn, .imprimirPresupuestos').removeClass('dt-button')
            
            table.on('init.dt', function() {
                restoreFilters(table, '#partes_trabajo'); // Restaurar filtros después de inicializar la tabla
            });
            
            mantenerFilaYsubrayar(table);
            fastEditForm(table, 'Presupuestos')

            const imprimirPresupuestos = document.querySelector('.imprimirPresupuestos');

            let fileCounter = 0;
            let materialCounter = 0;
            let parteTrabajoId = null;

            const previewFiles = (files, container, inputIndex) => {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
                    const currentIndex = fileCounter++;
                    const uniqueId = `file_${inputIndex}_${currentIndex}`;

                    reader.onload = function(e) {
                        const fileWrapper = $(`<div class="file-wrapper" id="preview_${uniqueId}"></div>`).css({
                            'display': 'inline-block',
                            'text-align': 'center',
                            'margin': '10px',
                            'width': '150px',
                            'vertical-align': 'top',
                            'border': '1px solid #ddd',
                            'padding': '10px',
                            'border-radius': '5px',
                            'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                            'overflow': 'hidden'
                        });

                        const img = $('<img>').attr('src', e.target.result).css({
                            'max-width': '100%',
                            'max-height': '100px',
                            'margin-bottom': '5px',
                            'object-fit': 'cover'
                        });

                        const fileName = $('<span></span>').text(file.name).css('display', 'block');
                        const commentBox = $(`<textarea class="form-control mb-2" name="comentario[${currentIndex + 1}]" placeholder="Comentario archivo ${currentIndex + 1}" rows="2"></textarea>`);
                        const removeBtn = $(`<button type="button" class="btn btn-danger btnRemoveFile">Eliminar</button>`).attr('data-unique-id', uniqueId).attr('data-input-id', `input_${inputIndex}`);

                        fileWrapper.append(img);
                        fileWrapper.append(fileName);
                        fileWrapper.append(commentBox);
                        fileWrapper.append(removeBtn);

                        container.append(fileWrapper);
                    }

                    reader.readAsDataURL(file);
                }
            }

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
                        url: "{{ route('admin.presupuestos.updatesum') }}",
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

            let calculateTotalSumPartePresu = (parteTrabajoId = null) => {
                let totalSum = 0;
                const precioHora = parseFloat($('#createParteTrabajoPresupuestoModal #precio_hora').val()) || 0;
                const desplazamiento = parseFloat($('#createParteTrabajoPresupuestoModal #desplazamiento').val()) || 0;

                $('#createParteTrabajoPresupuestoModal #elementsToShow tr, #editPresupuestoModal #elementsToShow tr').each(function() {
                    const total = parseFloat($(this).find('.material-total').text());
                    if (!isNaN(total)) {
                        totalSum += total;
                    }
                });

                if (!isNaN(precioHora)) {
                    totalSum += precioHora;
                }

                if (!isNaN(desplazamiento)) {
                    totalSum += desplazamiento;
                }

                $('#createParteTrabajoPresupuestoModal #suma, #editPresupuestoModal #suma').val(totalSum.toFixed(2));

                $('#createParteTrabajoModal #elementsToShow, #editPresupuestoModal #elementsToShow').find(`tr[data-id="${parteTrabajoId}"]`).find('.updatePrecioFrom').text(totalSum.toFixed(2) + '€');

                // calcular el total del presupuesto
                let totalPresupuesto = 0;
                $('#createParteTrabajoModal #elementsToShow tr, #editPresupuestoModal #elementsToShow tr').each(function() {
                    const total = parseFloat($(this).find('.calculatePrecio').text());
                    if (!isNaN(total)) {
                        totalPresupuesto += total;
                    }
                });

                $('#createParteTrabajoModal #collapseDetallesParteTrabajoPresu #suma, #editPresupuestoModal #collapseDetallesParteTrabajoPresu #suma').val(totalPresupuesto.toFixed(2) + '€');

                if (parteTrabajoId) {
                    $.ajax({
                        url: "{{ route('admin.presupuestos.updatesum') }}",
                        method: 'POST',
                        data: {
                            parteTrabajoId: parteTrabajoId,
                            suma: totalSum,
                            presupuesto: totalPresupuesto,
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

            const ficharArticuloRapido = ( modalId ) => {

                $('#createArticuloPresuFastModal').modal('show');

                $('#createArticuloPresuFastModal #saveArticuloPresuFastBtn').off('click').on('click', function() {
                    
                    // obtener el formulario
                    const form = $('#createArticuloPresuFastModal #ficharArticuloPresu');

                    // obtener los campos del formulario
                    const formated = new FormData(form[0]);

                    // añadir token
                    formated.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: "{{ route('admin.presupuestos.storeArticuloPresu') }}",
                        method: 'POST',
                        data: formated,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            openLoader();
                        },
                        success: function(response) {
                            closeLoader();
                            if (response.success) {

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Articulo fichado correctamente',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                // añadir el articulo al selector del modal padre
                                $(modalId).find('select[name="articulo_id"]').append(
                                    $('<option>', {
                                        value: response.id,
                                        text: response.nombre
                                    })
                                );

                                // seleccionar el articulo
                                $(modalId).find('select[name="articulo_id"]').val(response.id).trigger('change');

                                // añadir el precio al input del modal padre
                                $(modalId).find('input[name="precioSinIva"]').val(response.precio);

                                // añadir el precio al total
                                $(modalId).find('input[name="total"]').val(response.precio);

                                // cerrar el modal
                                $('#createArticuloPresuFastModal').modal('hide');

                            } else {
                                console.error('Error al fichar el articulo');
                            }
                        },
                        error: function(err) {
                            closeLoader();
                            console.error(err);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al fichar el articulo',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                    
                });

            }

            function openDetailsParteTrabajoModal(idParteTrabajo) {
                openLoader();
                const parteId = idParteTrabajo;
  
                $.ajax({
                    url: `/admin/presupuestos/parte/${parteId}/edit`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {

                            const parte = response.parte_trabajo;
                            parteTrabajoId = parte.idParteTrabajo;
                            closeLoader();

                            const buttonToDownloadPdf = document.createElement('a');
                            buttonToDownloadPdf.href = `/parte-trabajo/${parte.idParteTrabajo}/pdf`;
                            buttonToDownloadPdf.classList.add('btn', 'btn-danger');
                            buttonToDownloadPdf.setAttribute('data-bs-toggle', 'tooltip');
                            buttonToDownloadPdf.setAttribute('data-bs-placement', 'top');
                            buttonToDownloadPdf.setAttribute('title', 'Descargar PDF');
                            buttonToDownloadPdf.innerHTML = 'PDF <ion-icon name="download-outline"></ion-icon>';

                            const buttonToDownloadExcel = document.createElement('a');
                            buttonToDownloadExcel.href = `/parte-trabajo/${parte.idParteTrabajo}/excel`;
                            buttonToDownloadExcel.classList.add('btn', 'btn-success');
                            buttonToDownloadExcel.setAttribute('data-bs-toggle', 'tooltip');
                            buttonToDownloadExcel.setAttribute('data-bs-placement', 'top');
                            buttonToDownloadExcel.setAttribute('title', 'Descargar Excel');
                            buttonToDownloadExcel.innerHTML = 'Excel <ion-icon name="download-outline"></ion-icon>';

                            const buttonToDownloadZip = document.createElement('a');
                            buttonToDownloadZip.href = `/parte-trabajo/${parte.idParteTrabajo}/bundle`;
                            buttonToDownloadZip.classList.add('btn', 'btn-warning');
                            buttonToDownloadZip.setAttribute('data-bs-toggle', 'tooltip');
                            buttonToDownloadZip.setAttribute('data-bs-placement', 'top');
                            buttonToDownloadZip.setAttribute('title', 'Descargar ZIP');
                            buttonToDownloadZip.innerHTML = 'ZIP <ion-icon name="download-outline"></ion-icon>';

                            const buttonsContainer = $('#editParteTrabajoModal #editParteTrabajoFooter')

                            buttonsContainer.empty();

                            buttonsContainer.append(buttonToDownloadPdf);
                            buttonsContainer.append(buttonToDownloadExcel);
                            buttonsContainer.append(buttonToDownloadZip);

                            let calculateTotalSum = (parteTrabajoId = null) => {
                                let totalSum = 0;
                                const precioHora = parseFloat($('#createParteTrabajoPresupuestoModal #precio_hora').val()) || 0;
                                const desplazamiento = parseFloat($('#createParteTrabajoPresupuestoModal #desplazamiento').val()) || 0;

                                $('#editParteTrabajoModal #elementsToShow tr ').each(function() {
                                    const total = parseFloat($(this).find('.material-total').text());
                                    if (!isNaN(total)) {
                                        totalSum += total;
                                    }
                                });

                                if (!isNaN(precioHora)) {
                                    totalSum += precioHora;
                                }

                                if (!isNaN(desplazamiento)) {
                                    totalSum += desplazamiento;
                                }

                                $('#editParteTrabajoModal #suma').val(totalSum.toFixed(2));

                                $('#createParteTrabajoModal #elementsToShow, #editPresupuestoModal #elementsToShow').find(`tr[data-id="${parteTrabajoId}"]`).find('.updatePrecioFrom').text(totalSum.toFixed(2) + '€');

                                // calcular el total del presupuesto
                                let totalPresupuesto = 0;
                                $('#createParteTrabajoModal #elementsToShow tr, #editPresupuestoModal #elementsToShow tr').each(function() {
                                    const total = parseFloat($(this).find('.calculatePrecio').text());
                                    if (!isNaN(total)) {
                                        totalPresupuesto += total;
                                    }
                                });

                                $('#createParteTrabajoModal #collapseDetallesParteTrabajoPresu #suma, #editPresupuestoModal #collapseDetallesParteTrabajoPresu #suma').val(totalPresupuesto.toFixed(2) + '€');

                                if (parteTrabajoId) {
                                    $.ajax({
                                        url: "{{ route('admin.presupuestos.updatesum') }}",
                                        method: 'POST',
                                        data: {
                                            parteTrabajoId: parteTrabajoId,
                                            suma: totalSum,
                                            presupuesto: totalPresupuesto,
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

                            $('#editParteTrabajoModal #asunto').attr('disabled', false);
                            $('#editParteTrabajoModal #estado').attr('disabled', false);
                            $('#editParteTrabajoModal #fecha_visita').attr('disabled', false);
                            $('#editParteTrabajoModal #fecha_alta').attr('disabled', false);
                            $('#editParteTrabajoModal #cliente_id').attr('disabled', false);
                            $('#editParteTrabajoModal #departamento').attr('disabled', false);
                            $('#editParteTrabajoModal #trabajo_id').attr('disabled', false);
                            $('#editParteTrabajoModal #observaciones').attr('disabled', false);
                            $('#editParteTrabajoModal #solucion').attr('disabled', false);
                            $('#editParteTrabajoModal #hora_inicio').attr('disabled', false);
                            $('#editParteTrabajoModal #hora_fin').attr('disabled', false);
                            $('#editParteTrabajoModal #precio_hora').attr('disabled', false);
                            $('#editParteTrabajoModal #desplazamiento').attr('disabled', false);
                            $('#editParteTrabajoModal #files1').attr('disabled', false);
                            $('#editParteTrabajoModal #btnAddFiles').attr('disabled', false);

                            let materialCounterEdit = 0;

                            $('#editParteTrabajoModal').modal('show');
                            // cambiar el nombre del modal
                            $('#editParteTrabajoModal #editParteTrabajoTitle').text(`Editar Parte de Trabajo No. ${parte.idParteTrabajo}`);
                            $('#editParteTrabajoModal #formCreateOrden')[0].reset();
                            $('#editParteTrabajoModal #btnCreateOrdenButton').hide();

                            $('#editParteTrabajoModal #formCreateOrden').attr('action', ``);

                            if ( parte.cita ) {
                                $('#editParteTrabajoModal #citasPendigSelect').parent().show();
                                $('#editParteTrabajoModal #citasPendigSelect').val(parte.cita.idProyecto).trigger('change');


                                $('#editParteTrabajoModal #citasPendigSelect').on('change', function() {
                                    $('#editParteTrabajoModal #citasPendigSelect').val(parte.cita.idProyecto).trigger('change');
                                });

                            }else{
                                $('#editParteTrabajoModal #citasPendigSelect').parent().hide();
                            }

                            // hora de inicio y hora de fin con moment.js
                            let horaInicio = moment(parte.hora_inicio, 'HH:mm:ss').format('HH:mm');
                            let horaFin = moment(parte.hora_fin, 'HH:mm:ss').format('HH:mm');

                            let valorHoraAcumulado = 0;

                            parte.operarios.forEach(operario => {
                                valorHoraAcumulado += operario.operarios.salario.salario_hora;
                            });

                            if( horaInicio || horaFin ){
                                $('#editParteTrabajoModal #hora_inicio').val(horaInicio);
                                $('#editParteTrabajoModal #hora_fin').val(horaFin);
                            }

                            if ( horaInicio && horaFin ) {
                                calculateDifHours(
                                    '#editParteTrabajoModal #hora_inicio', 
                                    '#editParteTrabajoModal #hora_fin', 
                                    '#editParteTrabajoModal #horas_trabajadas',
                                    valorHoraAcumulado,
                                    parte.cliente.tipo_cliente.descuento,
                                    'editParteTrabajoModal'
                                );
                            }

                            $('#editParteTrabajoModal #hora_inicio').off('change').on('change', function() {
                                calculateDifHours(
                                    this, 
                                    '#editParteTrabajoModal #hora_fin', 
                                    '#editParteTrabajoModal #horas_trabajadas',
                                    valorHoraAcumulado,
                                    parte.cliente.tipo_cliente.descuento,
                                    'editParteTrabajoModal'
                                );
                                
                            });

                            $('#editParteTrabajoModal #hora_fin').off('change').on('change', function() {
                                calculateDifHours(
                                    '#editParteTrabajoModal #hora_inicio', 
                                    this, 
                                    '#editParteTrabajoModal #horas_trabajadas',
                                    valorHoraAcumulado,
                                    parte.cliente.tipo_cliente.descuento,
                                    'editParteTrabajoModal'
                                );
                                calculateTotalSum(parteTrabajoId);
                            });

                            $('#editParteTrabajoModal #precio_hora').on('change', function() {
                                calculateTotalSum(parteTrabajoId);
                            });

                            // inputs tipo time
                            $('#editParteTrabajoModal #hora_inicio').val(horaInicio);
                            $('#editParteTrabajoModal #hora_fin').val(horaFin);

                            // input tipo number
                            $('#editParteTrabajoModal #horas_trabajadas').val(parte.horas_trabajadas);
                            $('#editParteTrabajoModal #precio_hora').val(parte.precio_hora);
                            $('#editParteTrabajoModal #desplazamiento').val(parte.desplazamiento);

                            $('#editParteTrabajoModal #asunto').val(parte.Asunto);
                            $('#editParteTrabajoModal #fecha_alta').val(parte.FechaAlta);
                            $('#editParteTrabajoModal #fecha_visita').val(parte.FechaVisita);
                            $('#editParteTrabajoModal #estado').val(parte.Estado);
                            $('#editParteTrabajoModal #cliente_id').val(parte.cliente_id).trigger('change');
                            $('#editParteTrabajoModal #departamento').val(parte.Departamento);
                            $('#editParteTrabajoModal #observaciones').val(parte.Observaciones);
                            $('#editParteTrabajoModal #trabajo_id').val(parte.trabajo.idTrabajo).trigger('change');
                            $('#editParteTrabajoModal #suma').val(Number(parte.suma).toFixed(2));
                            $('#editParteTrabajoModal #solucion').val(parte.solucion);

                            $('#editParteTrabajoModal #elementsToShow').empty();
                            parte.partes_trabajo_lineas.forEach(linea => {

                                // calcular el beneficio de la linea precioVenta - precioCompra * cantidad
                                let beneficio = (linea.precioSinIva - linea.articulo.ptsCosto) * linea.cantidad;
                                let beneficioPorcentaje = (beneficio / linea.precioSinIva) * 100;

                                $('#editParteTrabajoModal #elementsToShow').append(`
                                    <tr
                                        id="material_${linea.idMaterial}"
                                    >
                                        <td>${linea.idMaterial}</td>
                                        <td
                                            class="showHistorialArticulo"
                                            data-id="${linea.articulo.idArticulo}"
                                            data-nameart="${linea.articulo.nombreArticulo}"
                                            data-trazabilidad="${linea.articulo.TrazabilidadArticulos}"
                                        >${linea.articulo.nombreArticulo}</td>
                                        <td>${linea.cantidad}</td>
                                        <td>${linea.precioSinIva}€</td>
                                        <td>${linea.descuento}</td>
                                        <td class="material-total">${linea.total}€</td>
                                        <td>${beneficio.toFixed(2)}€ | ${beneficioPorcentaje.toFixed(2)}%</td>
                                        <td>
                                            @component('components.actions-button')
                                                <button type="button" class="btn btn-outline-danger btnRemoveMaterial"
                                                    data-linea='${JSON.stringify(linea)}'
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Eliminar"
                                                >
                                                    <ion-icon name="trash-outline"></ion-icon>    
                                                </button>
                                                <button type="button" class="btn btn-outline-primary btnEditMaterial"
                                                    data-linea='${JSON.stringify(linea)}'
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Editar"
                                                >
                                                    <ion-icon name="create-outline"></ion-icon>
                                                </button>
                                            @endcomponent
                                        </td>
                                    </tr>
                                `);
                            });

                            $('#editParteTrabajoModal #showSignatureFromClient').empty();
                            // mostrar vista previa de las imagenes / videos o audios
                            $('#editParteTrabajoModal #imagesEdit').empty();
                            $('#editParteTrabajoModal #imagesDetails').empty();

                            $('#editParteTrabajoModal #cliente_firmaid').val('').attr('readonly', true);

                            let tieneFirma = false;

                            if (parte.partes_trabajo_archivos.length > 0) {
                                parte.partes_trabajo_archivos.forEach((archivo, index) => {
                                    let type = archivo.typeFile;
                                    let url = archivo.pathFile;
                                    let comentario = archivo.comentarioArchivo || ''; // Si no hay comentario, asignar cadena vacía

                                    let serverUrl = 'https://sebcompanyes.com/';
                                    let urlModificar = '/home/u657674604/domains/sebcompanyes.com/public_html/';
                                    let urlFinal = url.replace(urlModificar, serverUrl);
                                    let finalType = '';

                                    switch (type) {
                                        case 'jpg':
                                        case 'jpeg':
                                        case 'png':
                                        case 'gif':
                                            finalType = 'image';
                                            break;
                                        case 'mp4':
                                        case 'avi':
                                        case 'mov':
                                        case 'wmv':
                                        case 'flv':
                                        case '3gp':
                                        case 'webm':
                                            finalType = 'video';
                                            break;
                                        case 'mp3':
                                        case 'wav':
                                        case 'ogg':
                                        case 'm4a':
                                        case 'flac':
                                        case 'wma':
                                            finalType = 'audio';
                                            break;
                                        case 'pdf':
                                            finalType = 'pdf';
                                            break;
                                        case 'doc':
                                        case 'docx':
                                            finalType = 'word';
                                            break;
                                        case 'xls':
                                        case 'xlsx':
                                            finalType = 'excel';
                                            break;
                                        case 'ppt':
                                        case 'pptx':
                                            finalType = 'powerpoint';
                                            break;
                                        default:
                                            finalType = 'image';
                                            break;
                                    }

                                    // Wrapper for each file and comment
                                    const fileWrapper = $(`<div class="file-wrapper"></div>`).css({
                                        'display': 'inline-block',
                                        'text-align': 'center',
                                        'margin': '10px',
                                        'width': '100%',
                                        'max-width': '350px',
                                        'height': 'auto',
                                        'vertical-align': 'top',
                                        'border': '1px solid #ddd',
                                        'padding': '10px',
                                        'border-radius': '5px',
                                        'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                                        'overflow': 'hidden',
                                        'position': 'relative',
                                        'box-sizing': 'border-box' // Ensure padding is included within width
                                    });

                                    // Content wrapper to maintain consistent dimensions for different media types
                                    const contentWrapper = $('<div class="content-wrapper"></div>').css({
                                        'width': '100%',
                                        'height': '250px',  // Set a fixed height for the container
                                        'display': 'flex',
                                        'align-items': 'center',
                                        'justify-content': 'center',
                                        'margin-bottom': '10px',
                                        'overflow': 'hidden'
                                    });

                                    let fileContent;

                                    switch (finalType) {
                                        case 'image':
                                            fileContent = `<img src="${urlFinal}" style="width: 100%; height: 100%; object-fit: contain;">`;
                                            break;
                                        case 'video':
                                            fileContent = `<video controls style="width: 100%; height: 100%; object-fit: contain;"><source src="${urlFinal}" type="video/mp4" /></video>`;
                                            break;
                                        case 'audio':
                                            fileContent = `<audio controls style="width: 100%;"><source src="${urlFinal}" type="audio/mpeg" /></audio>`;
                                            break;
                                        case 'pdf':
                                            fileContent = `<embed src="${urlFinal}" type="application/pdf" style="width: 100%; height: 100%; object-fit: contain;">`;
                                            break;
                                        case 'word':
                                        case 'excel':
                                        case 'powerpoint':
                                            fileContent = `<iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${urlFinal}" style="width: 100%; height: 100%; object-fit: contain;" frameborder="0"></iframe>`;
                                            break;
                                        default:
                                            fileContent = `<img src="${urlFinal}" style="width: 100%; height: 100%; object-fit: contain;">`;
                                            break;
                                    }

                                    contentWrapper.append(fileContent);
                                    fileWrapper.append(contentWrapper);

                                    const commentBox = $(`<textarea class="form-control editCommentario" data-archivoid="${archivo.idarchivos}" name="comentario[${index + 1}]" placeholder="Comentario archivo ${index + 1}" rows="2" readonly></textarea>`).val(comentario);

                                    const buttonDelete = $(`<button type="button" class="btn btn-danger removeFileServer" data-archivoid="${archivo.idarchivos}"><ion-icon name="trash-outline"></ion-icon></button>`);
                                    const buttonDeleteContainer = $(`<div style="position: absolute; top: 0; right: 0;" class="d-flex justify-content-end"></div>`);
                                    
                                    buttonDeleteContainer.append(buttonDelete);
                                    fileWrapper.append(buttonDeleteContainer);
                                    fileWrapper.append(commentBox);

                                    $('#editParteTrabajoModal #imagesDetails').append(fileWrapper);
                                });
                            }

                            // evento para eliminar archivo
                            $('#editParteTrabajoModal .removeFileServer').off('click').on('click', function() {
                                const archivoId = $(this).data('archivoid');
                                // buscar el contenedor del archivo que tiene el atributo data-archivoid
                                const archivoWrapper = $(`#editParteTrabajoModal .file-wrapper[data-archivoid="${archivoId}"]`);

                                Swal.fire({
                                    title: '¿Estás seguro?',
                                    text: "¡No podrás revertir esto!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, eliminarlo!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        openLoader();
                                        $.ajax({
                                            url: "{{ route('admin.parte.deletefile') }}",
                                            method: 'POST',
                                            data: {
                                                archivoId: archivoId,
                                                _token: "{{ csrf_token() }}"
                                            },
                                            success: function(response) {
                                                closeLoader();
                                                if (response.success) {
                                                    archivoWrapper.remove();
                                                    Swal.fire(
                                                        '¡Eliminado!',
                                                        'El archivo ha sido eliminado.',
                                                        'success'
                                                    );
                                                } else {
                                                    Swal.fire(
                                                        'Error',
                                                        'No se ha podido eliminar el archivo.',
                                                        'error'
                                                    );
                                                }
                                            },
                                            error: function(err) {
                                                closeLoader();
                                                console.error(err);
                                                Swal.fire(
                                                    'Error',
                                                    'No se ha podido eliminar el archivo.',
                                                    'error'
                                                );
                                            }
                                        });
                                    }
                                });
                            });

                            // evento doble click para habilitar la edición del comentario
                            $('#editParteTrabajoModal .editCommentario').off('dblclick touchstart').on('dblclick touchstart', function(event) {
                                // Detectar si es un toque prolongado
                                if (event.type === 'touchstart') {
                                    let element = $(this);
                                    let timer = setTimeout(function() {
                                        element.attr('readonly', false);
                                        element.focus();
                                    }, 500); // 500 ms para considerar que es un toque prolongado

                                    // cambiar el borde del textarea para indicar que está en modo edición
                                    element.css('border', '1px solid #007bff');

                                    // Cancelar el temporizador si el usuario levanta el dedo antes de los 500 ms
                                    element.on('touchend', function() {
                                        clearTimeout(timer);
                                    });
                                } else {
                                    // Caso de doble clic (para dispositivos de escritorio)
                                    $(this).attr('readonly', false);
                                    $(this).focus();
                                }
                            });

                            // evento para editar comentario
                            $('#editParteTrabajoModal .editCommentario').off('change').on('change', function() {
                                const archivoId = $(this).data('archivoid');
                                const comentario = $(this).val();
                                openLoader();

                                $.ajax({
                                    url: "{{ route('admin.presupuestos.updatefile') }}",
                                    method: 'POST',
                                    data: {
                                        archivoId: archivoId,
                                        comentario: comentario,
                                        _token: "{{ csrf_token() }}"
                                    },
                                    success: function(response) {
                                        closeLoader();
                                        if (response.success) {
                                            showToast('Comentario actualizado correctamente', 'success');
                                            // Deshabilitar el textarea
                                            $('#editParteTrabajoModal .editCommentario').attr('readonly', true);
                                        } else {
                                            showToast('Error al actualizar el comentario', 'error');
                                        }
                                    },
                                    error: function(err) {
                                        openLoader();
                                        showToast('Error al actualizar el comentario', 'error');
                                    }
                                });
                            });


                            $('#editParteTrabajoModal #clear-signature').off('click').on('click', function(event) {
                                event.preventDefault();
                            });

                            $('#editParteTrabajoModal #previewImage1').empty();

                            let previewFiles = (files, container, inputIndex) => {
                                openLoader();
                                let filesLoaded = 0;

                                const MAX_PREVIEW_SIZE = 5 * 1024 * 1024; // 5MB

                                for (let i = 0; i < files.length; i++) {
                                    const file = files[i];
                                    const reader = new FileReader();
                                    const currentIndex = fileCounter++;
                                    const uniqueId = `file_${inputIndex}_${currentIndex}`;

                                    // if (file.size > MAX_PREVIEW_SIZE) {
                                    //     Swal.fire({
                                    //         icon: 'warning',
                                    //         title: 'Oops...',
                                    //         text: 'El archivo es demasiado grande. no se puede previsualizar pero.'
                                    //     });
                                    //     continue;
                                    // }

                                    reader.onload = function(e) {
                                        const fileWrapper = $(`<div class="file-wrapper" id="preview_${uniqueId}"></div>`).css({
                                            'display': 'inline-block',
                                            'text-align': 'center',
                                            'margin': '10px',
                                            'width': '350px',
                                            'vertical-align': 'top',
                                            'border': '1px solid #ddd',
                                            'padding': '10px',
                                            'border-radius': '5px',
                                            'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                                            'overflow': 'hidden'
                                        });

                                        let previewElement;

                                        if (file.type.startsWith("image/")) {
                                            previewElement = $('<img>').attr('src', e.target.result).css({
                                                'max-width': '300px',
                                                'max-height': '300px',
                                                'margin-bottom': '5px',
                                                'object-fit': 'cover',
                                                'border': '1px solid #ddd',
                                                'padding': '5px',
                                                'border-radius': '5px'
                                            });
                                        } else if (file.type.startsWith("video/")) {
                                            const videoUrl = URL.createObjectURL(file);
                                            previewElement = `
                                                <video class="plyr-video" controls autoplay muted poster="https://sebcompanyes.com/vendor/adminlte/dist/img/mileco.jpeg"
                                                    style="max-width: 300px; max-height: 300px; margin-bottom: 5px;">
                                                    <source src="${videoUrl}" type="${file.type}">
                                                </video>`;
                                        } else if (file.type.startsWith("audio/")) {
                                            previewElement = `
                                                <audio class="plyr-audio" id="plyr-audio-${uniqueId}" controls
                                                    style="width: 300px; margin-bottom: 5px;">
                                                    <source src="${e.target.result}" type="audio/mp3">
                                                </audio>`;
                                        } else {
                                            previewElement = $('<div>').text("Vista previa no disponible para este tipo de archivo.").css({
                                                'color': '#888',
                                                'margin-bottom': '5px'
                                            });
                                        }

                                        const fileName = $('<span></span>').text(file.name).css('display', 'block');
                                        const commentBox = $(`<textarea class="form-control mb-2" name="comentario[${currentIndex + 1}]" placeholder="Comentario archivo ${currentIndex + 1}" rows="2"></textarea>`);
                                        const removeBtn = $(`<button type="button" class="btn btn-danger btnRemoveFile">Eliminar</button>`).attr('data-unique-id', uniqueId).attr('data-input-id', `input_${inputIndex}`);

                                        fileWrapper.append(previewElement);
                                        fileWrapper.append(fileName);
                                        fileWrapper.append(commentBox);
                                        fileWrapper.append(removeBtn);

                                        container.append(fileWrapper);

                                        filesLoaded++;

                                        if (filesLoaded === files.length) {
                                            closeLoader();
                                        }

                                    };

                                    reader.readAsDataURL(file);
                                }
                            };

                            $('#editParteTrabajoModal #files1').off('change').on('change', function() {
                                openLoader();
                                const files = $(this)[0].files;
                                const filesContainer = $('#editParteTrabajoModal #previewImage1');

                                // Añadir previsualización
                                previewFiles(files, filesContainer, 0);
                                closeLoader();
                            });

                            $('#editParteTrabajoModal #files1').off('change').on('click', function(e) {
                                // verificar si hay archivos cargados
                                if ($('#previewImage1').children().length > 0) {
                                    e.preventDefault();
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: 'Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"'
                                    })
                                    return;
                                }
                            });

                            // Evento para añadir más inputs de archivos
                            $('#editParteTrabajoModal #btnAddFiles').off('click').on('click', function() {
                                const newInputContainer = $('<div class="form-group col-md-12"></div>');
                                const inputIndex = $('#inputsToUploadFilesContainer input').length + 1; // Índice del nuevo input
                                const newInputId = `input_${inputIndex}`;

                                // como maximo se pueden añadir 5 inputs
                                if (inputIndex >= 5) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: 'No puedes añadir más de 5 archivos'
                                    });
                                    return;
                                }
                                
                                const newInput = $(`<input type="file" class="form-control" name="file[]" id="${newInputId}">`);
                                newInputContainer.append(newInput);
                                $('#editParteTrabajoModal #inputsToUploadFilesContainer').append(newInputContainer);

                                // Manejar la previsualización para los nuevos inputs
                                newInput.on('change', function() {
                                    openLoader();
                                    const files = $(this)[0].files;
                                    const filesContainer = $('#editParteTrabajoModal #previewImage1');

                                    // Añadir previsualización
                                    previewFiles(files, filesContainer, inputIndex);
                                    closeLoader();
                                });

                                newInput.on('click', function(e) {
                                    // verificar si hay archivos cargados
                                    if ($('#previewImage1').children().length > inputIndex) {
                                        e.preventDefault();
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Oops...',
                                            text: 'Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"'
                                        })
                                        return;
                                    }
                                });

                            });

                            $(document).off('click', '.btnRemoveFile').on('click', '.btnRemoveFile', function() {
                                openLoader();
                                const uniqueId = $(this).data('unique-id');  // ID único del archivo a eliminar
                                const inputId = $(this).data('input-id');    // ID del input asociado

                                if ( uniqueId === 'file_0_0' || inputId === 'input_0' ) {
                                    $('#editParteTrabajoModal #files1').val('');                           
                                }

                                // Eliminar el contenedor de previsualización del archivo
                                $(`#preview_${uniqueId}`).remove();

                                // limpiar el input de archivos
                                $(`#${inputId}`).val('');

                                // Eliminar el input asociado si existe
                                if (inputId) {
                                    $(`#${inputId}`).remove();

                                    // descontar el contador de archivos
                                    fileCounter--;

                                    // actualizar el contador de archivos para todos los inputs restantes
                                    $('#inputsToUploadFilesContainer input').each(function(index, input) {
                                        const newIndex = index + 1;
                                        $(input).attr('id', `input_${newIndex}`);
                                        $(input).attr('name', `file_${newIndex}`);
                                        $(input).attr('data-input-index', newIndex);
                                        $(input).attr('placeholder', `comentario${newIndex}`);
                                    });
                                }
                                closeLoader();
                            });

                            $('#editParteTrabajoModal #collapseMaterialesEmpleados #addNewMaterial').off('click').on('click', function() {
                                materialCounterEdit++;
                                let newMaterial = `
                                    <form id="AddNewMaterialForm${materialCounter}" class="mt-2 mb-2">
                                        <input type="hidden" id="parteTrabajo_id" name="parteTrabajo_id" value="">
                                        <input type="hidden" id="materialCounter" name="materialCounter" value="${materialCounter}">
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="articulo_id${materialCounter}">Artículo</label>
                                                    <select class="form-select articulo" id="articulo_id${materialCounter}" name="articulo_id" required>
                                                        <option value="">Seleccione un artículo</option>
                                                        @foreach ($articulos as $articulo)
                                                            <option data-namearticulo="{{ $articulo->nombreArticulo }}" value="{{ $articulo->idArticulo }}">
                                                                {{ $articulo->nombreArticulo }} | {{ formatTrazabilidad($articulo->TrazabilidadArticulos) }} | stock: {{ $articulo->stock->cantidad }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-muted mb-1 mt-1 ficharArticuloRapidoBtn">¿No está fichado el articulo? Click aquí!</span></small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cantidad${materialCounter}">Cantidad</label>
                                                    <input type="number" class="form-control cantidad" id="cantidad${materialCounter}" name="cantidad" value="1" step="0.01" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="precioSinIva${materialCounter}">Precio sin IVA</label>
                                                    <input type="number" class="form-control precioSinIva" id="precioSinIva${materialCounter}" name="precioSinIva" step="0.01" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="descuento${materialCounter}">Descuento</label>
                                                    <input type="number" class="form-control descuento" id="descuento${materialCounter}" name="descuento" step="0.01" value="0" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="total${materialCounter}">Total</label>
                                                    <input type="number" class="form-control total" id="total${materialCounter}" name="total" step="0.01" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end justify-content-center align-items-end align-content-end">
                                                <button type="button" class="btn btn-outline-success saveMaterial" data-material="${materialCounter}">
                                                    Guardar Linea
                                                    <ion-icon name="save-outline"></ion-icon>
                                                </button>    
                                            </div>
                                        </div>
                                    </form>
                                `;

                                $('#editParteTrabajoModal #collapseMaterialesEmpleados #newMaterialsContainer').append(newMaterial);

                                if ($('#editParteTrabajoModal #collapseMaterialesEmpleados #newMaterialsContainer  select').data('select2')) {
                                    $('#editParteTrabajoModal #collapseMaterialesEmpleados #newMaterialsContainer  select').select2('destroy');
                                }

                                $('#editParteTrabajoModal #collapseMaterialesEmpleados #newMaterialsContainer  select').select2({
                                    width: '100%',  // Asegura que el select ocupe el 100% del contenedor
                                    dropdownParent: $('#editParteTrabajoModal')  // Asocia el dropdown con el modal para evitar problemas de superposición
                                });

                                $('#editParteTrabajoModal #collapseMaterialesEmpleados #newMaterialsContainer ').off('change', `#articulo_id${materialCounter}`).on('change', `#articulo_id${materialCounter}`, function () {
                                    openLoader();
                                    const articuloId = $(this).val();
                                    const form = $(this).closest('form');
                                    const precioSinIvaInput = form.find('.precioSinIva');
                                    const cantidadInput = form.find('.cantidad');
                                    const totalInput = form.find('.total');
                                    const descuentoInput = form.find('.descuento');
                                    let Articulos = @json($articulos);
                                    
                                    $.ajax({
                                        url: "/presupuesto/getStock/" + articuloId,
                                        method: 'GET',
                                        data: {
                                            articulo_id: articuloId,
                                        },
                                        success: function(response) {
                                            closeLoader();
                                            const venta = Number(response.stock.articulo.ptsVenta);
                                            $(`#editParteTrabajoModal #newMaterialsContainer #precioSinIva${materialCounter}`).val(venta.toFixed(2));
                                            $(`#editParteTrabajoModal #newMaterialsContainer #total${materialCounter}`).val(venta.toFixed(2));
                                            
                                        },
                                        error: function(err) {
                                            console.error(err);
                                            closeLoader();
                                        }
                                    });

                                    const articulo = Articulos.find(art => art.idArticulo === parseInt(articuloId));
                            
                                    if (articulo) {
                                        precioSinIvaInput.val(articulo.precio).attr('disabled', false);
                                        cantidadInput.attr('disabled', false);
                                        descuentoInput.attr('disabled', false);
                                        totalInput.val(cantidadInput.val() * articulo.precio);
                                    }
                                });

                                $('#editParteTrabajoModal #collapseMaterialesEmpleados #newMaterialsContainer').off('change', `#cantidad${materialCounter}`).on('change', `#cantidad${materialCounter}`, function () {
                                    const cantidad = parseFloat($(this).val());
                                    const form = $(this).closest('form');
                                    const precio = parseFloat(form.find('.precioSinIva').val());
                                    const descuento = parseFloat(form.find('.descuento').val());
                                    const totalInput = form.find('.total');

                                    if ( cantidad <= 0 ) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Oops...',
                                            text: 'La cantidad no puede ser menor o igual a 0',
                                        });
                                        $(this).val(1);
                                    }

                                    let total = 0;

                                    if ( descuento !== 0 ) {
                                        const lineaDescuento = (descuento * (precio * cantidad)) / 100;
                                        total = (precio * cantidad) - lineaDescuento;
                                        totalInput.val(total);
                                        return;
                                    }

                                    if ( descuento === 0 ) {
                                        total = precio * cantidad;
                                    }

                                    totalInput.val(total);
                                });

                                $('#editParteTrabajoModal #collapseMaterialesEmpleados #newMaterialsContainer').off('change', `#precioSinIva${materialCounter}`).on('change', `#precioSinIva${materialCounter}`, function () {
                                    const precio = parseFloat($(this).val());
                                    const form = $(this).closest('form');
                                    const cantidad = parseFloat(form.find('.cantidad').val());
                                    const descuentoInput = parseFloat(form.find('.descuento').val());
                                    const totalInput = form.find('.total');

                                    let total = 0;

                                    if ( descuento !== 0 ) {
                                        const lineaDescuento = (descuento * (precio * cantidad)) / 100;
                                        total = (precio * cantidad) - lineaDescuento;
                                        totalInput.val(total);
                                        return;
                                    }

                                    if ( descuento === 0 ) {
                                        total = precio * cantidad;
                                    }

                                    totalInput.val(total);
                                    return;
                                });

                                $('#editParteTrabajoModal #collapseMaterialesEmpleados #newMaterialsContainer').off('change', `#descuento${materialCounter}`).on('change', `#descuento${materialCounter}`, function () {
                                    const descuento = parseFloat($(this).val());
                                    const form = $(this).closest('form');
                                    const cantidad = parseFloat(form.find('.cantidad').val());
                                    const precio = parseFloat(form.find('.precioSinIva').val());
                                    const totalInput = form.find('.total');

                                    let total = 0;

                                    if ( descuento !== 0 ) {
                                        const lineaDescuento = (descuento * (precio * cantidad)) / 100;
                                        total = (precio * cantidad) - lineaDescuento;
                                        totalInput.val(total);
                                        return;
                                    }

                                    if ( descuento === 0 ) {
                                        total = precio * cantidad;
                                    }

                                    totalInput.val(total);
                                });

                                $('#editParteTrabajoModal #collapseMaterialesEmpleados #newMaterialsContainer .ficharArticuloRapidoBtn').css('cursor', 'pointer');

                                $('#editParteTrabajoModal #collapseMaterialesEmpleados #newMaterialsContainer').off('click').on('click', '.ficharArticuloRapidoBtn', function() {
                                    ficharArticuloRapido('#editParteTrabajoModal #collapseMaterialesEmpleados #newMaterialsContainer');
                                });

                            });

                            $('#editParteTrabajoModal #collapseMaterialesEmpleados').off('click').on('click', '.saveMaterial', function () {
                                const materialNumber    = $(this).data('material');
                                const form              = $(`#AddNewMaterialForm${materialNumber}`);
                                const articuloId        = form.find(`#articulo_id${materialNumber}`).val();
                                const cantidad          = parseFloat(form.find(`#cantidad${materialNumber}`).val());
                                const precioSinIva      = parseFloat(form.find(`#precioSinIva${materialNumber}`).val());
                                const descuento         = parseFloat(form.find(`#descuento${materialNumber}`).val());
                                const total             = parseFloat(form.find(`#total${materialNumber}`).val());

                                if (!articuloId || isNaN(cantidad) || isNaN(precioSinIva) || isNaN(descuento) || isNaN(total)) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Todos los campos son requeridos',
                                    });
                                    return;
                                }

                                const nombreArticulo = $(`#articulo_id${materialNumber} option:selected`).data('namearticulo');

                                
                                form.remove();

                                $.ajax({
                                    url: "{{ route('admin.presupuestos.lineaspartes') }}",
                                    method: 'POST',
                                    data: {
                                        parteTrabajo_id: parteTrabajoId,
                                        articulo_id: articuloId,
                                        cantidad: cantidad,
                                        precioSinIva: precioSinIva,
                                        descuento: descuento,
                                        total: total,
                                        _token: "{{ csrf_token() }}"
                                    },
                                    success: function(response) {
                                        if (response.success) {

                                            // CALCULAR EL BENEFICIO
                                            let beneficio = 0;
                                            let beneficioPorcentaje = 0;

                                            if (response.stock.articulo.ptsCosto > 0) {
                                                beneficio = total - (cantidad * response.stock.articulo.ptsCosto);
                                                beneficioPorcentaje = (beneficio / (cantidad * response.stock.articulo.ptsCosto)) * 100;
                                            } else {
                                                beneficio = total; // O el valor que prefieras para representar el beneficio en este caso
                                                beneficioPorcentaje = 100; // o algún otro valor que indique que el cálculo no es aplicable
                                            }

                                            const newRow = `
                                            <tr
                                                id="material_${response.linea.idMaterial}"
                                            >
                                                <td>${response.linea.idMaterial}</td>
                                                <td>${nombreArticulo}</td>
                                                <td>${cantidad}</td>
                                                <td>${precioSinIva}€</td>
                                                <td>${descuento}</td>
                                                <td class="material-total">${total}€</td>
                                                <td>${beneficio.toFixed(2)}€ | ${beneficioPorcentaje.toFixed(2)}%</td>
                                                <td>
                                                    @component('components.actions-button')
                                                        <button type="button" class="btn btn-outline-danger btnRemoveMaterial"
                                                            data-linea='${JSON.stringify(response.linea)}'
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Eliminar"
                                                        >
                                                            <ion-icon name="trash-outline"></ion-icon>    
                                                        </button>
                                                        <button type="button" class="btn btn-outline-primary btnEditMaterial"
                                                            data-linea='${JSON.stringify(response.linea)}'
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Editar"
                                                        >
                                                            <ion-icon name="create-outline"></ion-icon>
                                                        </button>
                                                    @endcomponent
                                                </td>
                                            </tr>
                                            `;

                                            $('#editParteTrabajoModal #collapseMaterialesEmpleados #elementsToShow').append(newRow);
                                            calculateTotalSum(parteTrabajoId);
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Línea de material guardada correctamente',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                        } else {
                                            console.error('Error al guardar la línea de material');
                                        }
                                    },
                                    error: function(err) {
                                        console.error(err);
                                    }
                                });
                            });

                            $('#editParteTrabajoModal #elementsToShow').off('click').on('click', '.btnRemoveMaterial', function() {
                                
                                const linea = $(this).data('linea');
                                const row   = $(this).closest('tr');
                                const lineaId = linea.idMaterial;
                                const articuloId = linea.articulo.idArticulo || linea.articulo_id;
 
                                Swal.fire({
                                    title: '¿Estás seguro de eliminar la linea del material?',
                                    text: "¡El articulo se devolverá al stock correspondiente!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, eliminarlo!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        openLoader();
                                        $.ajax({
                                            url: "{{ route('admin.presupuestos.lineaspartesDestroy') }}",
                                            method: 'POST',
                                            data: {
                                                articulo_id: articuloId,
                                                lineaId: lineaId,
                                                _token: "{{ csrf_token() }}"
                                            },
                                            success: function(response) {
                                                closeLoader();
                                                if (response.success) {
                                                    row.remove();
                                                    calculateTotalSum(parteTrabajoId);
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Línea de material eliminada correctamente',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    });
                                                } else {
                                                    closeLoader();
                                                    console.error('Error al eliminar la línea de material');
                                                }
                                            },
                                            error: function(err) {
                                                closeLoader();
                                                console.error(err);
                                            }
                                        });
                                    }
                                })
                                
                            });

                            $('#editParteTrabajoModal #elementsToShow').off('click', '.btnEditMaterial');

                            $('#editParteTrabajoModal #elementsToShow').on('click', '.btnEditMaterial', function() {
                                const linea = $(this).data('linea');
                                const row   = $(this).closest('tr');
                                const lineaId = linea.idMaterial;
                                const articuloId = linea.articulo.idArticulo || linea.articulo_id;

                                // abrir modal para editar la linea de material
                                $('#editMaterialLineModal').modal('show');

                                $('#editMaterialLineModal #editMaterialLineTitle').text(`Editar Línea de Material No. ${lineaId}`);
                                $('#editMaterialLineModal #formEditMaterialLine')[0].reset();


                                $('#editMaterialLineModal #material_id').val(articuloId).trigger('change');
                                $('#editMaterialLineModal #cantidad').val(linea.cantidad);
                                $('#editMaterialLineModal #precio').val(linea.precioSinIva);
                                $('#editMaterialLineModal #descuento').val(linea.descuento);
                                $('#editMaterialLineModal #total').val(linea.total);
                                $('#editMaterialLineModal #lineaId').val(lineaId);

                                // inicializar select2
                                $('#editMaterialLineModal select.form-select').select2({
                                    width: '100%',
                                    dropdownParent: $('#editMaterialLineModal')
                                });

                            });

                            // dejar de escuchar el evento del material seleccionado
                            $('#editParteTrabajoModal #material_id').off('change', 'select.form-select');

                            $('#editMaterialLineModal #material_id').on('change', function() {
                                openLoader();
                                const articuloId = $(this).val();
                                const precioSinIvaInput = $('#editMaterialLineModal #precio');
                                const cantidadInput = $('#editMaterialLineModal #cantidad');
                                const totalInput = $('#editMaterialLineModal #total');
                                const descuentoInput = $('#editMaterialLineModal #descuento');
                                let Articulos = @json($articulos);
                                
                                $.ajax({
                                    url: "/presupuesto/getStock/" + articuloId,
                                    method: 'GET',
                                    data: {
                                        articulo_id: articuloId,
                                    },
                                    success: function(response) {
                                        closeLoader();
                                        const venta = Number(response.stock.articulo.ptsVenta);
                                        precioSinIvaInput.val(venta.toFixed(2));
                                        totalInput.val(venta.toFixed(2));
                                        
                                    },
                                    error: function(err) {
                                        console.error(err);
                                        closeLoader();
                                    }
                                });

                                const articulo = Articulos.find(art => art.idArticulo === parseInt(articuloId));
                        
                                if (articulo) {
                                    precioSinIvaInput.val(articulo.precio).attr('disabled', false);
                                    cantidadInput.attr('disabled', false);
                                    descuentoInput.attr('disabled', false);
                                    totalInput.val(cantidadInput.val() * articulo.precio);
                                }
                            });

                            $('#editMaterialLineModal #cantidad').off('change').on('change', function() {
                                const cantidad  = parseFloat($(this).val());
                                const precio    = parseFloat($('#editMaterialLineModal #precio').val());
                                const descuento = parseFloat($('#editMaterialLineModal #descuento').val());

                                if ( cantidad <= 0 ) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: 'La cantidad no puede ser menor o igual a 0',
                                    });
                                    $(this).val(1);
                                }

                                let total = 0;

                                if ( descuento !== 0 ) {
                                    const lineaDescuento = (descuento * (precio * cantidad)) / 100;
                                    total = (precio * cantidad) - lineaDescuento;
                                    $('#editMaterialLineModal #descuento').val(descuento);
                                }

                                if ( descuento === 0 ) {
                                    total = precio * cantidad;
                                }

                                $('#editMaterialLineModal #total').val(total);
                            });

                            $('#editMaterialLineModal #precio').off('change').on('change', function() {
                                const precio    = parseFloat($(this).val());
                                const cantidad  = parseFloat($('#editMaterialLineModal #cantidad').val());
                                const descuento = parseFloat($('#editMaterialLineModal #descuento').val());

                                let total = 0;

                                if ( descuento !== 0 ) {
                                    const lineaDescuento = (descuento * (precio * cantidad)) / 100;
                                    total = (precio * cantidad) - lineaDescuento;
                                    $('#editMaterialLineModal #descuento').val(descuento);
                                }

                                if ( descuento === 0 ) {
                                    total = precio * cantidad;
                                }

                                $('#editMaterialLineModal #total').val(total);
                            });

                            $('#editMaterialLineModal #descuento').off('change').on('change', function() {
                                const descuento = parseFloat($(this).val())
                                const cantidad  = parseFloat($('#editMaterialLineModal #cantidad').val())
                                const precio    = parseFloat($('#editMaterialLineModal #precio').val())

                                let total = 0;

                                if ( descuento !== 0 ) {
                                    const lineaDescuento = (descuento * (precio * cantidad)) / 100;
                                    total = (precio * cantidad) - lineaDescuento;
                                    $('#editMaterialLineModal #descuento').val(descuento);
                                }

                                if ( descuento === 0 ) {
                                    total = precio * cantidad;
                                }

                                $('#editMaterialLineModal #total').val(total);
                            });
                            
                            $('#editMaterialLineModal #saveEditMaterialLineBtn').off('change').on('click', function() {
                                const form = $('#editMaterialLineModal #formEditMaterialLine');
                                const articuloId = form.find('#material_id').val();
                                const cantidad = form.find('#cantidad').val();
                                const precio = form.find('#precio').val();
                                const descuento = form.find('#descuento').val();
                                const total = form.find('#total').val();
                                const lineaId = form.find('#lineaId').val();

                                if (!articuloId || !cantidad || !precio || !descuento || !total) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Todos los campos son requeridos',
                                    });
                                    return;
                                }

                                $.ajax({
                                    url: "{{ route('admin.presupuestos.lineasParteUpdate', ':lineaId') }}".replace(':lineaId', lineaId),
                                    method: 'PUT',
                                    data: {
                                        parteTrabajo_id: parteTrabajoId,
                                        articulo_id: articuloId,
                                        cantidad: cantidad,
                                        precioSinIva: precio,
                                        descuento: descuento,
                                        total: total,
                                        _token: "{{ csrf_token() }}"
                                    },
                                    beforeSend: function () {
                                        openLoader();
                                    },
                                    success: function(response) {
                                        closeLoader();
                                        if (response.success) {

                                            const linea = response.linea;

                                            // Verificación de datos
                                            if (!linea) {
                                                console.error('La información de línea o artículo está indefinida', linea, articuloInfo);
                                                return;
                                            }

                                            let beneficio = 0;
                                            let beneficioPorcentaje = 0;

                                            if (response.stock.articulo.ptsCosto > 0) {
                                                beneficio = total - (cantidad * response.stock.articulo.ptsCosto);
                                                beneficioPorcentaje = (beneficio / (cantidad * response.stock.articulo.ptsCosto)) * 100;
                                            } else {
                                                beneficio = total; // O el valor que prefieras para representar el beneficio en este caso
                                                beneficioPorcentaje = 100; // o algún otro valor que indique que el cálculo no es aplicable
                                            }

                                            // Actualizar la fila de la tabla
                                            const updatedRow = `
                                                <td>${linea.idMaterial}</td>
                                                <td>${linea.articulo.nombreArticulo}</td>
                                                <td>${linea.cantidad}</td>
                                                <td>${linea.precioSinIva}€</td>
                                                <td>${linea.descuento}</td>
                                                <td
                                                    class="material-total"
                                                >${linea.total}€</td>
                                                <td>${beneficio.toFixed(2)}€ | ${beneficioPorcentaje.toFixed(2)}%</td>
                                                <td>
                                                    @component('components.actions-button')
                                                        <button type="button" class="btn btn-outline-danger btnRemoveMaterial"
                                                            data-linea='${JSON.stringify(linea)}'
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Eliminar"
                                                        >
                                                            <ion-icon name="trash-outline"></ion-icon>    
                                                        </button>
                                                        <button type="button" class="btn btn-outline-primary btnEditMaterial"
                                                            data-linea='${JSON.stringify(linea)}'
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Editar"
                                                        >
                                                            <ion-icon name="create-outline"></ion-icon>
                                                        </button>
                                                    @endcomponent
                                                </td>
                                            `;

                                            // Verificar que el elemento existe
                                            const materialElement = $(`#editParteTrabajoModal #elementsToShow #material_${linea.idMaterial}`);

                                            materialElement.html(updatedRow);

                                            // Recalcular el total
                                            calculateTotalSum(parteTrabajoId);

                                            // Cerrar el modal
                                            $('#editMaterialLineModal').modal('hide');

                                            // Mostrar la notificación de éxito
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Línea de material actualizada correctamente',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                        

                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: response.message,
                                            });
                                        }
                                    },
                                    error: function(err) {
                                        closeLoader();
                                        console.error(err);
                                    }
                                });
                                
                            });

                            // dejar de escuchar el evento de doble click de la tabla de elementos
                            $('#editParteTrabajoModal #elementsToShow').off('dblclick', '.showHistorialArticulo');
                            
                            $('#editParteTrabajoModal #elementsToShow .showHistorialArticulo').css('cursor', 'pointer');
                            $('#editParteTrabajoModal #elementsToShow .showHistorialArticulo').css('text-decoration', 'underline');


                            $('#editParteTrabajoModal #elementsToShow').on('dblclick', '.showHistorialArticulo', function(event){
                                openLoader();
                                const id = $(this).data('id');
                                const name = $(this).data('nameart');
                                const trazabilidad = $(this).data('trazabilidad');

                                getHistorial(id, name, trazabilidad);
                            });

                            $('#editParteTrabajoModal #saveEditParteTrabajoPresuBtn').off('click');

                            $('#editParteTrabajoModal #saveEditParteTrabajoPresuBtn').on('click', function(event){
                                
                                event.preventDefault();
                                const form              = $('#editParteTrabajoModal').find('#formCreateOrden[data-edit="1"]');
                                const formData          = new FormData(form[0]);

                                $.ajax({
                                    url: "{{ route('admin.presupuestos.updateParte', ':parteTrabajoId') }}".replace(':parteTrabajoId', parteTrabajoId),
                                    method: 'POST',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function() {
                                        openLoader();
                                    },
                                    success: function(response) {
                                        closeLoader();
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Parte de trabajo actualizado correctamente',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                            
                                            $('#editParteTrabajoModal').modal('hide');
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: response.message,
                                            });
                                        }

                                    },
                                    error: function(err) {
                                        closeLoader();
                                        console.error(err);
                                    }
                                });
                            })

                        }
                    },
                    error: function(err) {
                        console.error(err);
                        closeLoader();
                    }
                });
            }

            $('.createParteTrabajoBtn').on('click', function() {
                $('#createParteTrabajoModal').modal('show');

                $('#createParteTrabajoModal').on('shown.bs.modal', () => {
                    if ($('#createParteTrabajoModal select.form-select').data('select2')) {
                        $('#createParteTrabajoModal select.form-select').select2('destroy');
                    }

                    $('#createParteTrabajoModal select.form-select').select2({
                        width: '100%',
                        height: '100%',
                        placeholder: 'Seleccionar...',
                        dropdownParent: $('#createParteTrabajoModal')
                    });

                    // autoexpandir todos los textarea
                    $('textarea').each(function() {
                        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                    }).on('input', function() {
                        this.style.height = 'auto';
                        this.style.height = (this.scrollHeight) + 'px';
                    });

                    $('#editPartePresupuestoModal #elementsToShow').empty();

                    $('#createParteTrabajoModal').off('click', '.editPartePresupuestoModalBtn');

                    $('#createParteTrabajoModal').on('click', '.editPartePresupuestoModalBtn', function(event){
                        const parteId = $(this).data('id');
                        openDetailsParteTrabajoModal(parteId);
                    });

                });

                // Autocompletar campos de fecha
                $('#createParteTrabajoModal #fecha_alta').val(moment().format('YYYY-MM-DD'));
                $('#createParteTrabajoModal #fecha_visita').val(moment().add(1, 'days').format('YYYY-MM-DD'));

                const textoObservacionesDef = "En caso de sobrepasar el tiempo limite de validez de esta oferta/informe rogamos vuelvan a consultar precios, no olvide que estamos en constante renovación a fin de ofrecerle la mejor relación calidad/precio de nuestros trabajos. Todo el material empleado en nuestros trabajos cumplirá las especificaciones técnicas reglamentarias  al uso que ha sido destinado. Se efectuaran revisiones periódicas gratuitas cada tres meses a fin de asegurar el buen uso y funcionamiento del producto. Esta garantía queda extinta en su totalidad por siniestros derivados de inclemencias meteorológicas, manipulación por personal ajeno a la empresa y/o actos vandálicos. Los daños derivados directos o indirectos como causa de los trabajos realizados serán evaluados y si procediera valorados y/o reparados por personal técnico enviado por la propia empresa siendo responsabilidad del cliente o afectado el facilitar el acceso en el tiempo y forma por la misma. Todos nuestros equipos y materiales tienen certificado de homologación por la CE.";
                const condicionesGen = "Este presupuesto, en adelante acuerdo, carecerá de validez si no está firmado por parte de la empresa y del cliente.\n"+
                "1- Este presupuesto/acuerdo tendrá una validez de dos meses a partir de la fecha arriba indicada.\n"+
                "2- En los precios no está incluido ningún tipo de impuesto.\n"+
                "3- Quedarán excluidas todas las modificaciones, rectificaciones, reparaciones o ampliaciones que difieran de los trabajos presupuestados y reflejados en el presente escrito.\n"+
                "4- El cliente quedará obligado al suministro de puntos de agua, luz según sean necesarios, así como los permisos legales y/o dirección de obra o en su defecto documentación acreditativa necesaria para su gestión, sea de cualquier carácter (tasas obligatorias, subvenciones, etc.), si la empresa lo necesitase, y facilitará el paso al lugar donde se efectuarán los trabajos. En ningún caso será responsabilidad de la empresa la omisión y/o negación de la citada documentación/permisos/dirección de obra, etc., quedando relegada en su totalidad al cliente.\n"+
                "5- En caso de que la empresa gestione subvenciones de cualquier tipo, la empresa no se hará responsable de los resultados/resoluciones de las mismas, ya que dicha decisión corresponde solo al organismo ante el que se gestiona.\n"+
                "6- La forma de pago de todos los trabajos será del 30% a la formalización del acuerdo, 40% al comienzo de la obra y 30% a la finalización de la misma, no pudiendo modificarse sin acuerdo previo por las partes firmantes. Para la resolución de cualquier litigio serán competentes los Juzgados y Tribunales de la ciudad de Córdoba, con renuncia a cualquier otro.";

                // Observaciones
                $('#createParteTrabajoModal #observaciones').val(textoObservacionesDef);
                $('#createParteTrabajoModal #condicionesgene').val(condicionesGen);

                // suma = 0
                $('#createParteTrabajoModal #suma').val(0);
            });

            $('#createParteTrabajoModal #addAnexo').on('click', function(event){

                // Añadir anexos de manera dinamica
                const newInputContainer = $('<div class="form-group col-md-12 position-relative"></div>');
                const inputIndex = $('#createParteTrabajoModal #AnexosContainer textarea').length + 1;

                const newInput = $(`<textarea rows="4" type="text" class="form-control position-relative z-1" name="anexos[]" id="anexos${inputIndex}">`);
                const label    = $(`<label for="anexos${inputIndex}">Anexo ${inputIndex}</label>`);

                // añadir boton de x arriba a la derecha de cada textarea para eliminar el anexo y recuperar el contador de anexos
                const removeBtn = $(`<button type="button" class="btn btn-outline-danger btnRemoveFile position-absolute top-0 end-0 z-0">
                    <i class="fas fa-times"></i>    
                </button>`).attr('data-unique-id', `anexos${inputIndex}`);

                removeBtn.on('click', function() {
                    
                    $(this).closest('.form-group').remove();
                    showToast('Anexo eliminado correctamente', 'success');

                    // Recuperar el contador de anexos
                    $('#createParteTrabajoModal #AnexosContainer textarea').each(function(index, input) {
                        $(input).attr('id', `anexos${index + 1}`);
                        $(input).attr('name', `anexos[${index}]`);
                        $(input).prev().attr('for', `anexos${index + 1}`);

                        $(input).next().attr('data-unique-id', `anexos${index + 1}`);
                    });

                    // cambiar el texto de los labels
                    $('#createParteTrabajoModal #AnexosContainer label').each(function(index, label) {
                        $(label).text(`Anexo ${index + 1}`);
                    });

                });

                newInputContainer.append(removeBtn);
                newInputContainer.append(label);
                newInputContainer.append(newInput);
                $('#createParteTrabajoModal #AnexosContainer').append(newInputContainer);

                // autoexpandir los textarea de los anexos
                $('#createParteTrabajoModal #AnexosContainer textarea').each(function() {
                    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                }).on('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });

                // hacer scroll hasta el final del textarea
                newInput.focus();

                // abrir el teclado en dispositivos moviles
                newInput.trigger('click');

            });

            table.on('click', '.editParteTrabajoBtn', function() {
                const parteId = $(this).data('id');
                $.ajax({
                    url: `/admin/presupuestos/edit/${parteId}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const parte = response.parte_trabajo;
                            parteTrabajoId = parte.idParteTrabajo;
                            $('#editParteTrabajoModal').modal('show');
                            $('#formCreateOrden')[0].reset();

                            $('#editParteTrabajoModal #asunto').val(parte.Asunto);
                            $('#editParteTrabajoModal #fecha_alta').val(parte.FechaAlta);
                            $('#editParteTrabajoModal #fecha_visita').val(parte.FechaVisita);
                            $('#editParteTrabajoModal #estado').val(parte.Estado);
                            $('#editParteTrabajoModal #cliente_id').val(parte.cliente_id).trigger('change');
                            $('#editParteTrabajoModal #departamento').val(parte.Departamento);
                            $('#editParteTrabajoModal #observaciones').val(parte.Observaciones);
                            $('#editParteTrabajoModal #trabajo_id').val(parte.trabajo.idTrabajo).trigger('change');
                            $('#editParteTrabajoModal #suma').val(parte.suma);

                            $('#editParteTrabajoModal #elementsToShow').empty();
                            parte.partes_trabajo_lineas.forEach(linea => {
                                $('#editParteTrabajoModal #elementsToShow').append(`
                                    <tr>
                                        <td>${linea.idMaterial}</td>
                                        <td>${linea.articulo.nombreArticulo}</td>
                                        <td>${linea.cantidad}</td>
                                        <td>${linea.precioSinIva}€</td>
                                        <td>${linea.descuento}</td>
                                        <td class="material-total">${linea.total}€</td>
                                    </tr>
                                `);
                            });

                            if ($('select.form-select').data('select2')) {
                                $('select.form-select').select2('destroy');
                            }
                            $('select.form-select').select2({
                                width: '100%',
                                dropdownParent: $('#editParteTrabajoModal')
                            });
                        }
                    },
                    error: function(err) {
                        console.error(err);
                    }
                });
            });

            table.on('click', '.detailsParteTrabajoBtn', function() {
                const parteId = $(this).data('id');
                $.ajax({
                    url: `/admin/presupuestos/edit/${parteId}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const parte = response.parte_trabajo;
                            $('#detailsParteTrabajoModal').modal('show');
                            $('#formCreateOrden')[0].reset();

                            $('#detailsParteTrabajoModal #asunto').val(parte.Asunto).attr('disabled', true);
                            $('#detailsParteTrabajoModal #fecha_alta').val(parte.FechaAlta).attr('disabled', true);
                            $('#detailsParteTrabajoModal #fecha_visita').val(parte.FechaVisita).attr('disabled', true);
                            $('#detailsParteTrabajoModal #estado').val(parte.Estado).attr('disabled', true);
                            $('#detailsParteTrabajoModal #cliente_id').val(parte.cliente_id).trigger('change').attr('disabled', true);
                            $('#detailsParteTrabajoModal #departamento').val(parte.Departamento).attr('disabled', true);
                            $('#detailsParteTrabajoModal #observaciones').val(parte.Observaciones).attr('disabled', true);
                            $('#detailsParteTrabajoModal #trabajo_id').val(parte.trabajo.idTrabajo).trigger('change').attr('disabled', true);
                            $('#detailsParteTrabajoModal #suma').val(parte.suma).attr('disabled', true);

                            $('#detailsParteTrabajoModal #elementsToShow').empty();
                            parte.partes_trabajo_lineas.forEach(linea => {
                                $('#detailsParteTrabajoModal #elementsToShow').append(`
                                    <tr>
                                        <td>${linea.idMaterial}</td>
                                        <td>${linea.articulo.nombreArticulo}</td>
                                        <td>${linea.cantidad}</td>
                                        <td>${linea.precioSinIva}€</td>
                                        <td>${linea.descuento}</td>
                                        <td class="material-total">${linea.total}€</td>
                                    </tr>
                                `);
                            });
                        }
                    },
                    error: function(err) {
                        console.error(err);
                    }
                });
            });

            table.on('click', '.generateOrdenTrabajo', function(){

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Quieres generar una orden de trabajo a partir de este presupuesto?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, generar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const parteId = $(this).data('id');
                        const parteInfo = $(this).data('info');
                        const clienteInfo = $(this).data('cliente');
                        const lineas = $(this).data('lineas');

                        $('#createOrdenTrabajoModal').modal('show');

                        $('#createOrdenTrabajoModal').off('shown.bs.modal').on('shown.bs.modal', () => {
                            // Destruir la instancia de Select2, si existe
                            if ($('#createOrdenTrabajoModal select.form-select').data('select2')) {
                                $('#createOrdenTrabajoModal select.form-select').select2('destroy');
                            }

                            $('#createOrdenTrabajoModal select.form-select').select2({
                                width: '100%',  // Asegura que el select ocupe el 100% del contenedor
                                dropdownParent: $('#createOrdenTrabajoModal')  // Asocia el dropdown con el modal para evitar problemas de superposición
                            });

                        });

                        $('#saveOrdenTrabajoBtn').off('click').on('click', function(){
                            $.ajax({
                                url: "{{ route('admin.presupuestos.generateOrden') }}",
                                method: 'POST',
                                data: {
                                    parteInfo,
                                    cliente: clienteInfo,
                                    operarios: $('#operariosId').val(),
                                    lineas,
                                    _token: "{{ csrf_token() }}"
                                },
                                beforeSend: function() {
                                    openLoader();
                                },
                                success: function(response) {
                                    closeLoader();
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Orden de trabajo creada correctamente',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        window.location.href = `/admin/orders`;
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Algo salió mal',
                                        });
                                    }
                                },
                                error: function(err) {
                                    console.error(err);
                                    closeLoader();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Algo salió mal',
                                    });
                                }
                            });
                        })

                    }
                })

            });

            $('#saveEditParteTrabajoBtn').on('click', function() {
                const formData = new FormData($('#formCreateOrden')[0]);
                $.ajax({
                    url: `/admin/presupuestos/update/${parteTrabajoId}`,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Parte de trabajo actualizado correctamente',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#editParteTrabajoModal').modal('hide');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo salió mal',
                            });
                        }
                    },
                    error: function(err) {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo salió mal',
                        });
                    }
                });
            });

            $('#btnCreateOrden').on('click', function() {
                $('#formCreateOrden').submit();
            });

            $('#files1').on('change', function() {
                const files = $(this)[0].files;
                const filesContainer = $('#previewImage1');

                previewFiles(files, filesContainer, 0);
            });

            $('#files1').on('click', function(e) {
                if ($('#previewImage1').children().length > 0) {
                    e.preventDefault();
                    alert('Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"');
                    return;
                }
            });

            $('#btnAddFiles').on('click', function() {
                const newInputContainer = $('<div class="form-group col-md-12"></div>');
                const inputIndex = $('#inputsToUploadFilesContainer input').length + 1;
                const newInputId = `input_${inputIndex}`;

                if (inputIndex >= 5) {
                    alert('No puedes añadir más de 5 archivos');
                    return;
                }
                
                const newInput = $(`<input type="file" class="form-control" name="file[]" id="${newInputId}" accept="image/*">`);
                newInputContainer.append(newInput);
                $('#inputsToUploadFilesContainer').append(newInputContainer);

                newInput.on('change', function() {
                    const files = $(this)[0].files;
                    const filesContainer = $('#previewImage1');

                    previewFiles(files, filesContainer, inputIndex);
                });

                newInput.on('click', function(e) {
                    if ($('#previewImage1').children().length > inputIndex) {
                        e.preventDefault();
                        alert('Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"');
                        return;
                    }
                });
            });

            $(document).on('click', '.btnRemoveFile', function() {
                const uniqueId = $(this).data('unique-id');
                const inputId = $(this).data('input-id');

                $(`#preview_${uniqueId}`).remove();

                if (inputId) {
                    $(`#${inputId}`).remove();
                    fileCounter--;

                    $('#inputsToUploadFilesContainer input').each(function(index, input) {
                        const newIndex = index + 1;
                        $(input).attr('id', `input_${newIndex}`);
                        $(input).attr('name', `file_${newIndex}`);
                        $(input).attr('data-input-index', newIndex);
                        $(input).attr('placeholder', `comentario${newIndex}`);
                    });
                }
            });

            const calculatePriceHoraXcantidad = (cantidad_form, precio_form, descuento, modal) => {
                const cantidad = parseFloat(cantidad_form);
                const precio = parseFloat(precio_form);
                const descuentoCliente = parseFloat(descuento);

                if ( !isNaN(cantidad) && !isNaN(precio) ) {
                    const total = cantidad * precio;
                    if( descuentoCliente == 0 ){
                        $(`#${modal} #precio_hora`).val(total.toFixed(2));
                    }else{
                        const totalDescuento = total - (total * (descuentoCliente / 100));
                        $(`#${modal} #precio_hora`).val(totalDescuento.toFixed(2));
                        $(`#${modal} #precioHoraHelp`).fadeIn().text(`Precio con descuento del ${descuentoCliente}%`);
                    }
                }
            };

            const calculateDifHours = (hora_inicio, hora_fin, itemRender, precio_hora, descuento, modal) => {
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

                        calculatePriceHoraXcantidad(hoursWorked, precio_hora, descuento, modal);

                    }
                }
            };

            function CreateNewParteTrabajo(modalPadre){
                // ABRIR EL MODAL DE PARTES DE TRABAJO
                $('#createParteTrabajoPresupuestoModal').modal('show');

                $('#createParteTrabajoPresupuestoModal #citasPendigSelect').parent().hide();

                $('#createParteTrabajoPresupuestoModal #asunto').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #estado').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #fecha_visita').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #fecha_alta').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #cliente_id').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #departamento').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #trabajo_id').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #observaciones').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #solucion').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #hora_inicio').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #hora_fin').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #horas_trabajadas').attr('disabled', false).attr('readonly', true);
                $('#createParteTrabajoPresupuestoModal #precio_hora').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #desplazamiento').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #files1').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #btnAddFiles').attr('disabled', false);
                $('#createParteTrabajoPresupuestoModal #suma').attr('disabled', false).attr('readonly', true);

                // REINICIAR EL FORMULARIO
                $('#createParteTrabajoPresupuestoModal #formCreateOrden')[0].reset();
                $('#createParteTrabajoPresupuestoModal #imagesDetails').empty();
                $('#createParteTrabajoPresupuestoModal #elementsToShow').empty();
                $('#createParteTrabajoPresupuestoModal #previewImage1').empty();

                 // valores por defecto fecha de alta, fecha de visita, estado, cliente, departamento, trabajo
                // obtenerlas del modal del presupuesto que está abierto detrás de este
                const asunto = $(`#${modalPadre} #asunto`).val();
                const fechaAlta = $(`#${modalPadre} #fecha_alta`).val();
                const fechaVisita = $(`#${modalPadre} #fecha_visita`).val();
                const estado = $(`#${modalPadre} #estado`).val();
                const cliente = $(`#${modalPadre} #cliente_id`).val();
                const departamento = $(`#${modalPadre} #departamento`).val();
                const trabajo = $(`#${modalPadre} #trabajo_id`).val();

                $('#createParteTrabajoPresupuestoModal #fecha_alta').val(fechaAlta);
                $('#createParteTrabajoPresupuestoModal #fecha_visita').val(fechaVisita);
                $('#createParteTrabajoPresupuestoModal #estado').val(1);
                $('#createParteTrabajoPresupuestoModal #suma').val(0);
                $('#createParteTrabajoPresupuestoModal #cliente_id').val(cliente).trigger('change');

                $('#createParteTrabajoPresupuestoModal #cliente_id').on('change', function(event){
                    $(this).val(cliente).trigger('change');
                });

                $('#createParteTrabajoPresupuestoModal #departamento').val(departamento);
                $('#createParteTrabajoPresupuestoModal #trabajo_id').val(trabajo).trigger('change');

                // limpiar inputs de archivos
                $('#createParteTrabajoPresupuestoModal #files1').val('');
                $('#createParteTrabajoPresupuestoModal input[type="file"]').val('');

                // reiniciar inputs de archivos
                $('#createParteTrabajoPresupuestoModal #inputsToUploadFilesContainer').empty();

                // reiniciar eventos
                $('#createParteTrabajoPresupuestoModal #btnCreateOrdenButtonPresu').off('click');
                $('#createParteTrabajoPresupuestoModal #hora_inicio').off('change');
                $('#createParteTrabajoPresupuestoModal #hora_fin').off('change');

                // eventos
                $('#createParteTrabajoPresupuestoModal #hora_inicio').on('change', function() {
                    calculateDifHours('#createParteTrabajoPresupuestoModal #hora_inicio', '#createParteTrabajoPresupuestoModal #hora_fin', '#createParteTrabajoPresupuestoModal #horas_trabajadas', '#createParteTrabajoPresupuestoModal #precio_hora', 0, 'createParteTrabajoPresupuestoModal');
                });

                $('#createParteTrabajoPresupuestoModal #hora_fin').on('change', function() {
                    calculateDifHours('#createParteTrabajoPresupuestoModal #hora_inicio', '#createParteTrabajoPresupuestoModal #hora_fin', '#createParteTrabajoPresupuestoModal #horas_trabajadas', '#createParteTrabajoPresupuestoModal #precio_hora', 0, 'createParteTrabajoPresupuestoModal');
                });
                
                $('#createParteTrabajoPresupuestoModal #btnCreateOrdenButtonPresu').on('click', function(event){
                    event.preventDefault();
                    const formData = new FormData($('#createParteTrabajoPresupuestoModal #formCreateOrden')[0]);

                    const asuntoInput = $('#createParteTrabajoPresupuestoModal #formCreateOrden #asunto');
                    const fechaAltaInput = $('#createParteTrabajoPresupuestoModal #formCreateOrden #fecha_alta');
                    const clienteInput = $('#createParteTrabajoPresupuestoModal #formCreateOrden #cliente_id');
                    const departamentoInput = $('#createParteTrabajoPresupuestoModal #formCreateOrden #departamento');
                    const trabajoInput = $('#createParteTrabajoPresupuestoModal #formCreateOrden #trabajo_id');
                    const hora_inicio = $('#createParteTrabajoPresupuestoModal #formCreateOrden #hora_inicio');
                    const hora_fin = $('#createParteTrabajoPresupuestoModal #formCreateOrden #hora_fin');
                    const presupuesto_id = $(`#${modalPadre} #idParteTrabajo`).val();

                    if ( !asuntoInput.val() || !fechaAltaInput.val() || !clienteInput.val() || !departamentoInput.val() || !hora_inicio.val() || !hora_fin.val() ) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: `El campo ${!asuntoInput.val() ? 'Asunto' : !fechaAltaInput.val() ? 'Fecha de alta' : !clienteInput.val() ? 'Cliente' : !departamentoInput.val() ? 'Departamento' : 'Trabajo'} es requerido`,
                        });
                        return;
                    }

                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('presupuesto_id', presupuesto_id);
                    openLoader();
                    $.ajax({
                        url: "{{ route('admin.presupuestos.storeParte') }}",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            closeLoader();
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Capítulo Creado correctamente',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                Articulos = response.articulos;
                                parteTrabajoId = response.parteTrabajoId;
                                const sumaParcial = response.total;
                                const parte = response.partes_trabajo;

                                $('#createParteTrabajoPresupuestoModal #btnCreateOrdenButton').attr('disabled', true);
                                $('#createParteTrabajoPresupuestoModal #btnAddFiles').attr('disabled', true);

                                $('#createParteTrabajoPresupuestoModal #formCreateOrden input').attr('disabled', true);
                                $('#createParteTrabajoPresupuestoModal #formCreateOrden select').attr('disabled', true);
                                $('#createParteTrabajoPresupuestoModal #formCreateOrden textarea').attr('disabled', true);

                                $('#createParteTrabajoPresupuestoModal #materialesEmpleados').click();
                                
                                $('#createParteTrabajoPresupuestoModal #addNewMaterial').trigger('click');

                                $('#createParteTrabajoPresupuestoModal #suma').val(sumaParcial);

                                $('#createParteTrabajoPresupuestoModal #detailParteTrabajo').addClass('collapsed');
                                $('#createParteTrabajoPresupuestoModal #detailParteTrabajo').attr('aria-expanded', false);

                                $(`#${modalPadre} #elementsToShow`).append(`
                                    <tr
                                        data-id="${parteTrabajoId}"
                                    >
                                        <td>${parteTrabajoId}</td>
                                        <td>${parte.Asunto}</td>
                                        <td>1</td>
                                        <td class="updatePrecioFrom">${parte.suma}€</td>
                                        <td>0%</td>
                                        <td class="updatePrecioFrom calculatePrecio">${parte.suma}€</td>
                                        <td>
                                            @component('components.actions-button')
                                                <button class="btn btn-outline-primary editPartePresupuestoModalBtn" data-id="${parte.idParteTrabajo}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger deleteParteTrabajoBtn" data-id="${parte.idParteTrabajo}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endcomponent
                                        </td>
                                    </tr>
                                `);
                                
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Algo salió mal',
                                });
                            }
                        },
                        error: function(err) {
                            closeLoader();
                            console.error(err);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo salió mal',
                            });
                        }
                    });
                });

                // eventos para visualizar los archivos subidos
                $('#createParteTrabajoPresupuestoModal #files1').on('change', function() {
                    const files = $(this)[0].files;
                    const filesContainer = $('#createParteTrabajoPresupuestoModal #previewImage1');

                    previewFiles(files, filesContainer, 0);
                });

                $('#createParteTrabajoPresupuestoModal #files1').on('click', function(e) {
                    if ($('#createParteTrabajoPresupuestoModal #previewImage1').children().length > 0) {
                        e.preventDefault();
                        showToast('Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"', 'error');
                        return;
                    }
                });

                $('#createParteTrabajoPresupuestoModal #btnAddFiles').on('click', function() {
                    const newInputContainer = $('<div class="form-group col-md-12"></div>');
                    const inputIndex = $('#createParteTrabajoPresupuestoModal #inputsToUploadFilesContainer input').length + 1;
                    const newInputId = `input_${inputIndex}`;

                    if (inputIndex >= 5) {
                        showToast('No puedes añadir más de 5 archivos', 'error');
                        return;
                    }
                    
                    const newInput = $(`<input type="file" class="form-control" name="file[]" id="${newInputId}" accept="image/*">`);
                    newInputContainer.append(newInput);
                    $('#createParteTrabajoPresupuestoModal #inputsToUploadFilesContainer').append(newInputContainer);

                    newInput.on('change', function() {
                        const files = $(this)[0].files;
                        const filesContainer = $('#createParteTrabajoPresupuestoModal #previewImage1');

                        previewFiles(files, filesContainer, inputIndex);
                    });

                    newInput.on('click', function(e) {
                        if ($('#createParteTrabajoPresupuestoModal #previewImage1').children().length > inputIndex) {
                            e.preventDefault();
                            alert('Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"');
                            return;
                        }
                    });
                });
            }

            $('#createParteTrabajoModal #addNewMaterial').on('click', function() {
                CreateNewParteTrabajo('createParteTrabajoModal');
            });

            $('#createParteTrabajoPresupuestoModal #addNewMaterial').on('click', function() {
                materialCounter++;
                let newMaterial = `
                    <form id="AddNewMaterialForm${materialCounter}" class="mt-2 mb-2">
                        <div class="row">
                            <input type="hidden" id="parteTrabajo_id" name="parteTrabajo_id" value="">
                            <input type="hidden" id="materialCounter" name="materialCounter" value="${materialCounter}">
                            
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="articulo_id${materialCounter}">Artículo</label>
                                        <select class="form-select articulo" id="articulo_id${materialCounter}" name="articulo_id" required>
                                            <option value="">Seleccione un artículo</option>
                                            @foreach ($articulos as $articulo)
                                                <option data-namearticulo="{{ $articulo->nombreArticulo }}" value="{{ $articulo->idArticulo }}">{{ $articulo->nombreArticulo }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted mb-1 mt-1 ficharArticuloRapidoBtn">¿No está fichado el articulo? Click aquí!</span></small>
                                    </div>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cantidad${materialCounter}">Cantidad</label>
                                        <input type="number" class="form-control cantidad" id="cantidad${materialCounter}" name="cantidad" value="1" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precioSinIva${materialCounter}">Precio</label>
                                        <input type="number" class="form-control precioSinIva" id="precioSinIva${materialCounter}" name="precioSinIva" step="0.01" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="descuento${materialCounter}">Descuento</label>
                                        <input type="number" class="form-control descuento" id="descuento${materialCounter}" name="descuento" step="0.01" value="0" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total${materialCounter}">Total</label>
                                        <input type="number" class="form-control total" id="total${materialCounter}" name="total" step="0.01" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-success saveMaterial" data-material="${materialCounter}">Guardar</button>    
                            </div>
                        </div>
                    </form>
                `;

                $('#createParteTrabajoPresupuestoModal #newMaterialsContainer').append(newMaterial);

                //INICIALIZAR LOS SELECT2
                $('#createParteTrabajoPresupuestoModal select.form-select').select2({
                    width: '100%',
                    dropdownParent: $('#createParteTrabajoPresupuestoModal')
                });

                $('#createParteTrabajoPresupuestoModal #collapseMaterialesEmpleados #newMaterialsContainer').off('click').on('click', '.ficharArticuloRapidoBtn', function() {
                    ficharArticuloRapido('#createParteTrabajoPresupuestoModal #collapseMaterialesEmpleados #newMaterialsContainer');
                });

                $('#createParteTrabajoPresupuestoModal #newMaterialsContainer').on('change', `#articulo_id${materialCounter}`, function () {
                    const articuloId = $(this).val();
                    const form = $(this).closest('form');
                    const precioSinIvaInput = form.find('.precioSinIva');
                    const cantidadInput = form.find('.cantidad');
                    const totalInput = form.find('.total');
                    const descuentoInput = form.find('.descuento');

                    $.ajax({
                        url: "/presupuesto/getStock/" + articuloId,
                        method: 'GET',
                        data: {
                            articulo_id: articuloId,
                        },
                        beforeSend: function() {
                            precioSinIvaInput.val('').attr('disabled', true);
                            cantidadInput.val('').attr('disabled', true);
                            descuentoInput.val('').attr('disabled', true);
                            totalInput.val('').attr('disabled', true);
                            openLoader();
                        },
                        success: function(response) {
                            closeLoader();
                            if (response.success) {

                                let trazabilidad = '';
                                if ( !response.stock.articulo.TrazabilidadArticulos ) {
                                    // Alerta arriba a la derecha que el articulo no tiene trazabilidad
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'warning',
                                        title: 'Este artículo no tiene trazabilidad',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    trazabilidad = 'Sin trazabilidad';

                                }else{
                                    trazabilidad = formatTrazabilidad(response.stock.articulo.TrazabilidadArticulos);
    
                                    if ( !trazabilidad || trazabilidad == '' ) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Trazabilidad',
                                            text: 'No hay trazabilidad para este artículo',
                                        })
                                    }
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: '¿Quieres Utilizar este artículo?',
                                    text: `Nombre: ${response.stock.articulo.nombreArticulo} \n, Stock actual: ${response.stock.cantidad || 0} \n Precio: ${response.stock.articulo.ptsVenta || 0}€ \n trazabilidad: ${trazabilidad} \n Con fecha de compra: ${response.stock.ultimaCompraDate || 'Sin fecha'}`,
                                    showCancelButton: true,
                                    confirmButtonText: `Si`,
                                    cancelButtonText: `No`,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const venta = Number(response.stock.articulo.ptsVenta) || 0;
                                        $(`#precioSinIva${materialCounter}`).val(venta.toFixed(2)).attr('disabled', false);;
                                        $(`#total${materialCounter}`).val(venta.toFixed(2));
                                        $(`#cantidad${materialCounter}`).val(1).attr('disabled', false);
                                        $(`#descuento${materialCounter}`).val(0).attr('disabled', false);
                                    } else {
                                        $(`#articulo_id${materialCounter}`).val('');
                                        $(`#precioSinIva${materialCounter}`).val('').attr('disabled', true);
                                        $(`#total${materialCounter}`).val('').attr('disabled', true);
                                        $(`#cantidad${materialCounter}`).val('').attr('disabled', true);
                                        $(`#descuento${materialCounter}`).val('').attr('disabled', true);

                                    }
                                });

                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        },
                        error: function(err) {
                            console.error(err);
                            closeLoader();
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err.responseJSON.message,
                            });
                        }
                    });

                    const articulo = Articulos.find(art => art.idArticulo === parseInt(articuloId));
            
                    if (articulo) {
                        precioSinIvaInput.val(articulo.precio).attr('disabled', false);
                        cantidadInput.attr('disabled', false);
                        descuentoInput.attr('disabled', false);
                        totalInput.val(cantidadInput.val() * articulo.precio);
                    }
                });

                $('#createParteTrabajoPresupuestoModal #newMaterialsContainer').on('change', `#cantidad${materialCounter}`, function () {
                    const cantidad = $(this).val();
                    const form = $(this).closest('form');
                    const precioSinIvaInput = form.find('.precioSinIva').val();
                    const descuentoInput = form.find('.descuento').val();
                    const totalInput = form.find('.total');

                    if (cantidad && precioSinIvaInput) {
                        const total = cantidad * precioSinIvaInput - descuentoInput;
                        totalInput.val(total);
                        calculateTotalSum(null);
                    }
                });

                $('#createParteTrabajoPresupuestoModal #newMaterialsContainer').on('change', `#precioSinIva${materialCounter}`, function () {
                    const precioSinIva = $(this).val();
                    const form = $(this).closest('form');
                    const cantidad = form.find('.cantidad').val();
                    const descuentoInput = form.find('.descuento').val();
                    const totalInput = form.find('.total');

                    if (precioSinIva && cantidad) {
                        const total = cantidad * precioSinIva - descuentoInput;
                        totalInput.val(total);
                        calculateTotalSum(null);
                    }
                });

                $('#createParteTrabajoPresupuestoModal #newMaterialsContainer').on('change', `#descuento${materialCounter}`, function () {
                    const descuento = $(this).val();
                    const form = $(this).closest('form');
                    const cantidad = form.find('.cantidad').val();
                    const precioSinIvaInput = form.find('.precioSinIva').val();
                    const totalInput = form.find('.total');

                    if (descuento && cantidad && precioSinIvaInput) {
                        const total = cantidad * precioSinIvaInput - descuento;
                        totalInput.val(total);
                        calculateTotalSum(null);
                    }
                });
            });

            $('#createParteTrabajoPresupuestoModal #collapseMaterialesEmpleados').on('click', '.saveMaterial', function () {
                const materialNumber    = $(this).data('material');
                const form              = $(`#createParteTrabajoPresupuestoModal #collapseMaterialesEmpleados #AddNewMaterialForm${materialNumber}`);
                const articuloId        = form.find(`#articulo_id${materialNumber}`).val();
                const cantidad          = parseFloat(form.find(`#cantidad${materialNumber}`).val());
                const precioSinIva      = parseFloat(form.find(`#precioSinIva${materialNumber}`).val());
                const descuento         = parseFloat(form.find(`#descuento${materialNumber}`).val());
                const total             = parseFloat(form.find(`#total${materialNumber}`).val());

                if (!articuloId || isNaN(cantidad) || isNaN(precioSinIva) || isNaN(descuento) || isNaN(total)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Todos los campos son requeridos',
                    })
                    return;
                }

                const nombreArticulo = $(`#articulo_id${materialNumber} option:selected`).data('namearticulo');

                form.remove();

                $.ajax({
                    url: "{{ route('admin.presupuestos.lineaspartes') }}",
                    method: 'POST',
                    data: {
                        parteTrabajo_id: parteTrabajoId,
                        articulo_id: articuloId,
                        cantidad: cantidad,
                        precioSinIva: precioSinIva,
                        descuento: descuento,
                        total: total,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        openLoader();
                    },
                    success: function(response) {
                        closeLoader();
                        if (response.success) {

                            let beneficio = 0;
                            let beneficioPorcentaje = 0;
                            const linea = response.linea;

                            if (response.stock.articulo.ptsCosto > 0) {
                                beneficio = total - (cantidad * response.stock.articulo.ptsCosto);
                                beneficioPorcentaje = (beneficio / (cantidad * response.stock.articulo.ptsCosto)) * 100;
                            } else {
                                beneficio = total; // O el valor que prefieras para representar el beneficio en este caso
                                beneficioPorcentaje = 100; // o algún otro valor que indique que el cálculo no es aplicable
                            }
                            
                            const newRow = `
                                <tr
                                    id="materialRow${materialNumber}"
                                    data-articuloid="${articuloId}"
                                    data-material="${materialNumber}"
                                    data-cantidad="${cantidad}"
                                    data-precio="${precioSinIva}"
                                    data-descuento="${descuento}"
                                    data-total="${total}"
                                >
                                    <td>${linea.idMaterial}</td>
                                    <td>${linea.articulo.nombreArticulo}</td>
                                    <td>${linea.cantidad}</td>
                                    <td>${linea.precioSinIva}€</td>
                                    <td>${linea.descuento}</td>
                                    <td class="material-total">${linea.total}€</td>
                                    <td>${beneficio.toFixed(2)}€ | ${beneficioPorcentaje.toFixed(2)}%</td>
                                    <td>
                                        <button 
                                            type="button" 
                                            data-articuloid="${linea.articulo_id}" 
                                            data-material="${materialNumber}"
                                            data-cantidad="${cantidad}"
                                            id="deleteMaterial${materialNumber}"
                                            class="btn btn-outline-danger btn-sm deleteMaterial" 
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            `;
                            
                            $('#createParteTrabajoPresupuestoModal #elementsToShow').append(newRow);
                            $(`#createParteTrabajoPresupuestoModal #deleteMaterial${materialNumber}`).attr('data-id', response.linea.idMaterial);
                            $(`#createParteTrabajoPresupuestoModal #deleteMaterial${materialNumber}`).attr('data-row', response.linea.idMaterial);
                            $(`#createParteTrabajoPresupuestoModal #materialRow${materialNumber}`).attr('data-id', response.linea.idMaterial);
                            calculateTotalSumPartePresu(parteTrabajoId);
                        } else {
                            console.error('Error al guardar la línea de material');
                        }
                    },
                    error: function(err) {
                        closeLoader();
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo salió mal',
                        });
                    }
                });
            });

            $('#createParteTrabajoPresupuestoModal #collapseMaterialesEmpleados').on('click', '.deleteMaterial', function(event){
                const materialNumber = $(this).data('material');
                const form = $(`#AddNewMaterialForm${materialNumber}`);
                const cantidad = parseFloat(form.find(`#cantidad${materialNumber}`).val());
                const precioSinIva = parseFloat(form.find(`#precioSinIva${materialNumber}`).val());
                const descuento = parseFloat(form.find(`#descuento${materialNumber}`).val());
                const total = parseFloat(form.find(`#total${materialNumber}`).val());
                const articuloId = $(this).data('articuloid');
                const cantidadArticulo = $(this).data('cantidad');
                const lineaId = $(this).data('id');
                const rowToDelete = $(this).data('row');
                // buscar en la tabla el row que su data-id sea igual al data-row del boton
                const row = $(`#materialRow${materialNumber}`);

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "El material será eliminado de la lista y se restaurará el stock del artículo",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.presupuestos.lineaspartesDestroy') }}",
                            method: 'POST',
                            data: {
                                parteTrabajo_id: parteTrabajoId,
                                articulo_id: articuloId,
                                cantidad: cantidadArticulo,
                                precioSinIva: precioSinIva,
                                descuento: descuento,
                                lineaId,
                                total: total,
                                _token: "{{ csrf_token() }}"
                            },
                            beforeSend: function() {
                                openLoader();
                            },
                            success: function(response) {
                                closeLoader();
                                if (response.success) {

                                    Swal.fire({
                                        icon: 'success',
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 2500
                                    });

                                    row.remove();
                                    calculateTotalSum(parteTrabajoId);
                                } else {
                                    console.error('Error al eliminar la línea de material');
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Algo salió mal',
                                    });
                                }
                            },
                            error: function(err) {
                                closeLoader();
                                console.error(err);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Algo salió mal',
                                });
                            }
                        });
                    }
                })

            });

            $('#createParteTrabajoPresupuestoModal #collapseMaterialesEmpleados').on('click', '.editParteTrabajoBtn', function() {
                openLoader();
                const parteId = $(this).data('id');          
                openDetailsParteTrabajoModal(parteId);
            });

            $('#btnCreateOrdenButton').on('click', function(event) {
                event.preventDefault();
                const formData = new FormData($('#formCreateOrden')[0]);

                const asuntoInput = $('#formCreateOrden #asunto');
                const fechaAltaInput = $('#formCreateOrden #fecha_alta');
                const clienteInput = $('#formCreateOrden #cliente_id');
                const departamentoInput = $('#formCreateOrden #departamento');
                const trabajoInput = $('#formCreateOrden #trabajo_id');

                if (!asuntoInput.val() || !fechaAltaInput.val() || !clienteInput.val() || !departamentoInput.val() || !trabajoInput.val()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: `El campo ${!asuntoInput.val() ? 'Asunto' : !fechaAltaInput.val() ? 'Fecha de alta' : !clienteInput.val() ? 'Cliente' : !departamentoInput.val() ? 'Departamento' : 'Trabajo'} es requerido`,
                    });
                    return;
                }


                $.ajax({
                    url: "{{ route('admin.presupuestos.store') }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Presupuesto Creado correctamente',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            Articulos = response.articulos;
                            parteTrabajoId = response.parteTrabajoId;

                            $('#btnCreateOrdenButton').attr('disabled', true);
                            $('#btnAddFiles').attr('disabled', true);

                            $('#formCreateOrden input').attr('disabled', true);
                            $('#formCreateOrden select').attr('disabled', true);
                            $('#formCreateOrden textarea').attr('disabled', true);

                            $('#materialesEmpleados').click();
                            
                            $('#addNewMaterial').trigger('click');

                            $('#createParteTrabajoModal #idParteTrabajo').val(parteTrabajoId);
                            
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo salió mal',
                            });
                        }
                    },
                    error: function(err) {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo salió mal',
                        });
                    }
                });

            });

            // imprimirPresupuestos.addEventListener('click', function() {
            //     $('#imprimirPresupuestosModal').modal('show');

            //     if ($('#imprimirPresupuestosModal select.form-control').data('select2')) {
            //         $('#imprimirPresupuestosModal select.form-control').select2('destroy');
            //     }

            //     $('#imprimirPresupuestosModal select.form-control').select2({
            //         width: '100%',
            //         dropdownParent: $('#imprimirPresupuestosModal')
            //     });

            // });


            $('.sendToImprimirPresupuestosBtn').on('click', function( event ) {
                event.preventDefault();
                // verificamos si se ha seleccionado un presupuesto
                const presupuestoId = $('#imprimirPresupuestosModal select.form-control').val();

                if ( !presupuestoId || presupuestoId <= 0 ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Debes seleccionar un presupuesto',
                    });
                    return;
                }

                for (let i = 0; i < presupuestoId.length; i++) {
                    if ( !presupuestoId[i] || presupuestoId[i] == "" || presupuestoId[i].length <= 0 ) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debes seleccionar un presupuesto',
                        });
                        return;
                    }
                }

                if ( presupuestoId || presupuestoId != "" ) {
                    $('#imprimirForm').submit();
                    $('#imprimirPresupuestosModal').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Debes seleccionar un presupuesto',
                    });
                }

            });

            // Abrir el modal de editar presupuesto con sus respectivos anexos, por medio de una peticion ajax que habra el openLoader y closeLoader
            table.on('click', '.editPresupuestoBtn', function() {
                openLoader();
                const presupuestoId = $(this).data('id');
                $.ajax({
                    // la url necesito hacerle el replace para que me tome el id del presupuesto
                    url: "{{ route('admin.presupuestos.editCabecera', ':presupuestoId') }}".replace(':presupuestoId', presupuestoId),
                    method: 'GET',
                    data: {
                        presupuestoId: presupuestoId,
                    },
                    success: function(response) {
                        closeLoader();
                        if (response.success) {
                            $('#editPresupuestoModal').modal('show');

                            $('#editPresupuestoTitle').text(`Editar presupuesto ${response.presupuesto.idParteTrabajo}`);

                            const presupuesto = response.presupuesto;
                            const cliente = presupuesto.cliente;
                            const partes = presupuesto.partes || [];
                            const anexos = presupuesto.anexos || [];
                            const archivos = presupuesto.archivos || [];

                            const buttonToDownloadPdf = document.createElement('a');
                            buttonToDownloadPdf.href = `/presupuesto/${response.presupuesto.idParteTrabajo}/pdf`;
                            buttonToDownloadPdf.classList.add('btn', 'btn-danger');
                            buttonToDownloadPdf.classList.add('generatePdfPresupuesto');
                            buttonToDownloadPdf.setAttribute('data-bs-toggle', 'tooltip');
                            buttonToDownloadPdf.setAttribute('data-bs-placement', 'top');
                            buttonToDownloadPdf.setAttribute('title', 'Descargar PDF');
                            buttonToDownloadPdf.setAttribute('target', '_blank');
                            buttonToDownloadPdf.setAttribute('data-id', response.presupuesto.idParteTrabajo);
                            buttonToDownloadPdf.innerHTML = 'PDF <ion-icon name="download-outline"></ion-icon>';

                            const buttonToDownloadExcel = document.createElement('a');
                            buttonToDownloadExcel.href = `/parte-trabajo/${response.presupuesto.idParteTrabajo}/excel`;
                            buttonToDownloadExcel.classList.add('btn', 'btn-success');
                            buttonToDownloadExcel.setAttribute('data-bs-toggle', 'tooltip');
                            buttonToDownloadExcel.setAttribute('data-bs-placement', 'top');
                            buttonToDownloadExcel.setAttribute('title', 'Descargar Excel');
                            buttonToDownloadExcel.innerHTML = 'Excel <ion-icon name="download-outline"></ion-icon>';

                            const buttonToDownloadZip = document.createElement('a');
                            buttonToDownloadZip.href = `/parte-trabajo/${response.presupuesto.idParteTrabajo}/bundle`;
                            buttonToDownloadZip.classList.add('btn', 'btn-warning');
                            buttonToDownloadZip.setAttribute('data-bs-toggle', 'tooltip');
                            buttonToDownloadZip.setAttribute('data-bs-placement', 'top');
                            buttonToDownloadZip.setAttribute('title', 'Descargar ZIP');
                            buttonToDownloadZip.innerHTML = 'ZIP <ion-icon name="download-outline"></ion-icon>';

                            const buttonsContainer = $('#editPresupuestoModal #editPresupuestoFooter')

                            buttonsContainer.html('');
                            buttonsContainer.append(buttonToDownloadPdf);
                            // buttonsContainer.append(buttonToDownloadExcel);
                            // buttonsContainer.append(buttonToDownloadZip);

                            $('#editPresupuestoModal #idParteTrabajo').val(presupuesto.idParteTrabajo);
                            $('#editPresupuestoModal #asunto').val(presupuesto.Asunto);
                            $('#editPresupuestoModal #fecha_alta').val(presupuesto.FechaAlta);

                            $('#editPresupuestoModal #cliente_id').val(cliente.idClientes).trigger('change');
                            $('#editPresupuestoModal #departamento').val(presupuesto.Departamento);
                            $('#editPresupuestoModal #trabajo_id').val(presupuesto.trabajos[0].trabajo_id).trigger('change');
                            $('#editPresupuestoModal #fecha_visita').val(presupuesto.FechaVisita);
                            $('#editPresupuestoModal #condicionesgene').val(presupuesto.condiciones_generales);
                            $('#editPresupuestoModal #observaciones').val(presupuesto.Observaciones);
                            $('#editPresupuestoModal #condiciones_generales').val(presupuesto.condiciones_generales);
                            $('#editPresupuestoModal #suma').val(presupuesto.suma).attr('disabled', false).attr('readonly', true);

                            $('#editPresupuestoModal #elementsToShow').html('');

                            partes.forEach(parte => {
                                $('#editPresupuestoModal #elementsToShow').append(`
                                    <tr
                                        data-id="${parte.idParteTrabajo}"
                                    >
                                        <td>${parte.idParteTrabajo}</td>
                                        <td>${parte.Asunto}</td>
                                        <td>1</td>
                                        <td class="updatePrecioFrom">${parte.suma}€</td>
                                        <td>0%</td>
                                        <td class="updatePrecioFrom calculatePrecio">${parte.suma}€</td>
                                        <td>
                                            @component('components.actions-button')
                                                <button class="btn btn-outline-primary editPartePresupuestoModalBtn" data-id="${parte.idParteTrabajo}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger deleteParteTrabajoBtn" data-id="${parte.idParteTrabajo}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endcomponent
                                        </td>
                                    </tr>
                                `);
                            });            

                            $('#editPresupuestoModal #btnCreateOrdenButton').attr('disabled', false);
                            $('#editPresupuestoModal #btnAddFiles').attr('disabled', false);

                            $('#editPresupuestoModal #formCreateOrden input').attr('disabled', false);
                            $('#editPresupuestoModal #formCreateOrden select').attr('disabled', false);
                            $('#editPresupuestoModal #formCreateOrden textarea').attr('disabled', false);

                            $('#editPresupuestoModal #detailParteTrabajo').addClass('collapsed');
                            $('#editPresupuestoModal #detailParteTrabajo').attr('aria-expanded', false);

                            $('#editPresupuestoModal #elementsToShow').off('click', '.editPartePresupuestoModalBtn').on('click', '.editPartePresupuestoModalBtn', function() {
                                const parteId = $(this).data('id');          
                                openDetailsParteTrabajoModal(parteId);
                            });

                            // evento para eliminar una parte de trabajo
                            $('#editPresupuestoModal #elementsToShow').off('click', '.deleteParteTrabajoBtn').on('click', '.deleteParteTrabajoBtn', function() {
                                const parteId = $(this).data('id');
                                const row = $(this).closest('tr');

                                Swal.fire({
                                    title: '¿Estás seguro?',
                                    text: "La parte de trabajo será eliminada de la lista",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, eliminar',
                                    cancelButtonText: 'Cancelar',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajax({
                                            url: "{{ route('admin.presupuestos.partesDestroy') }}",
                                            method: 'POST',
                                            data: {
                                                parteTrabajo_id: parteTrabajoId,
                                                parte_id: parteId,
                                                _token: "{{ csrf_token() }}"
                                            },
                                            beforeSend: function() {
                                                openLoader();
                                            },
                                            success: function(response) {
                                                closeLoader();
                                                if (response.success) {
                                                    row.remove();
                                                    calculateTotalSumPartePresu(parteTrabajoId);
                                                } else {
                                                    console.error('Error al eliminar la línea de material');
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Oops...',
                                                        text: 'Algo salió mal',
                                                    });
                                                }
                                            },
                                            error: function(err) {
                                                closeLoader();
                                                console.error(err);
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Oops...',
                                                    text: 'Algo salió mal',
                                                });
                                            }
                                        });
                                    }
                                });
                            });

                            // eventos para visualizar los archivos subidos
                            $('#editPresupuestoModal #files1').off('change').on('change', function() {
                                const files = $(this)[0].files;
                                const filesContainer = $('#editPresupuestoModal #previewImage1');

                                previewFiles(files, filesContainer, 0);
                            });

                            $('#editPresupuestoModal #files1').off('click').on('click', function(e) {
                                if ($('#editPresupuestoModal #previewImage1').children().length > 0) {
                                    e.preventDefault();
                                    showToast('Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"', 'error');
                                    return;
                                }
                            });

                            $('#editPresupuestoModal #btnAddFiles').off('click').on('click', function() {
                                const newInputContainer = $('<div class="form-group col-md-12"></div>');
                                const inputIndex = $('#editPresupuestoModal #inputsToUploadFilesContainer input').length + 1;
                                const newInputId = `input_${inputIndex}`;

                                if (inputIndex >= 5) {
                                    showToast('No puedes añadir más de 5 archivos', 'error');
                                    return;
                                }
                                
                                const newInput = $(`<input type="file" class="form-control" name="file[]" id="${newInputId}" accept="image/*">`);
                                newInputContainer.append(newInput);
                                $('#editPresupuestoModal #inputsToUploadFilesContainer').append(newInputContainer);

                                newInput.on('change', function() {
                                    const files = $(this)[0].files;
                                    const filesContainer = $('#editPresupuestoModal #previewImage1');

                                    previewFiles(files, filesContainer, inputIndex);
                                });

                                newInput.on('click', function(e) {
                                    if ($('#editPresupuestoModal #previewImage1').children().length > inputIndex) {
                                        e.preventDefault();
                                        alert('Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"');
                                        return;
                                    }
                                });
                            });

                            // evento para añadir más anexos
                            $('#editPresupuestoModal #addAnexo').off('click').on('click', function(event){

                                // Añadir anexos de manera dinamica
                                const newInputContainer = $('<div class="form-group col-md-12 position-relative"></div>');
                                const inputIndex = $('#editPresupuestoModal #AnexosContainer textarea').length + 1;

                                const newInput = $(`<textarea rows="4" type="text" class="form-control position-relative z-1" name="anexos[]" id="anexos${inputIndex}">`);
                                const label    = $(`<label for="anexos${inputIndex}">Anexo ${inputIndex}</label>`);

                                // añadir boton de x arriba a la derecha de cada textarea para eliminar el anexo y recuperar el contador de anexos
                                const removeBtn = $(`<button type="button" class="btn btn-outline-danger btnRemoveFile position-absolute top-0 end-0 z-0">
                                    <i class="fas fa-times"></i>    
                                </button>`).attr('data-unique-id', `anexos${inputIndex}`);

                                removeBtn.on('click', function() {
                                    
                                    $(this).closest('.form-group').remove();
                                    showToast('Anexo eliminado correctamente', 'success');

                                    // Recuperar el contador de anexos
                                    $('#editPresupuestoModal #AnexosContainer textarea').each(function(index, input) {
                                        $(input).attr('id', `anexos${index + 1}`);
                                        $(input).attr('name', `anexos[${index}]`);
                                        $(input).prev().attr('for', `anexos${index + 1}`);

                                        $(input).next().attr('data-unique-id', `anexos${index + 1}`);
                                    });

                                    // cambiar el texto de los labels
                                    $('#editPresupuestoModal #AnexosContainer label').each(function(index, label) {
                                        $(label).text(`Anexo ${index + 1}`);
                                    });

                                });

                                newInputContainer.append(removeBtn);
                                newInputContainer.append(label);
                                newInputContainer.append(newInput);
                                $('#editPresupuestoModal #AnexosContainer').append(newInputContainer);

                                // autoexpandir los textarea de los anexos
                                $('#editPresupuestoModal #AnexosContainer textarea').each(function() {
                                    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                                }).on('input', function() {
                                    this.style.height = 'auto';
                                    this.style.height = (this.scrollHeight) + 'px';
                                });

                                // hacer scroll hasta el final del textarea
                                newInput.focus();

                                // abrir el teclado en dispositivos moviles
                                newInput.trigger('click');

                            });

                            $('#editPresupuestoModal #AnexosContainer').empty();

                            // cargar los anexos
                            anexos.forEach(anexo => {
                                const newInputContainer = $('<div class="form-group col-md-12 position-relative"></div>');
                                const inputIndex = $('#editPresupuestoModal #AnexosContainer textarea').length + 1;

                                const newInput = $(`<textarea rows="4" type="text" class="form-control position-relative z-1" name="anexos[]" id="anexos${inputIndex}">`).val(anexo.value_anexo);
                                const label    = $(`<label for="anexos${inputIndex}">Anexo ${inputIndex}</label>`);

                                // añadir boton de x arriba a la derecha de cada textarea para eliminar el anexo y recuperar el contador de anexos
                                const removeBtn = $(`<button type="button" class="btn btn-outline-danger btnRemoveFile position-absolute top-0 end-0 z-0">
                                    <i class="fas fa-times"></i>    
                                </button>`).attr('data-unique-id', `anexos${inputIndex}`);

                                removeBtn.on('click', function() {

                                    const anexoToRemoveDOM = $(this).closest('.form-group');
                                    
                                    Swal.fire({
                                        title: '¿Estás seguro?',
                                        text: "El anexo será eliminado de la lista",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Sí, eliminar',
                                        cancelButtonText: 'Cancelar',
                                        allowEscapeKey: false,
                                        allowOutsideClick: false,
                                    }).then((result) => {
                                        if (result.isConfirmed) {

                                            $.ajax({
                                                url: "{{ route('admin.presupuestos.anexosDestroy') }}",
                                                method: 'POST',
                                                data: {
                                                    anexoId: anexo.idanexo,
                                                    _token: "{{ csrf_token() }}"
                                                },
                                                beforeSend: function() {
                                                    openLoader();
                                                },
                                                success: function(response){
                                                    closeLoader();

                                                    anexoToRemoveDOM.remove();
                                                    showToast('Anexo eliminado correctamente', 'success');
                
                                                    // Recuperar el contador de anexos
                                                    $('#editPresupuestoModal #AnexosContainer textarea').each(function(index, input) {
                                                        $(input).attr('id', `anexos${index + 1}`);
                                                        $(input).attr('name', `anexos[${index}]`);
                                                        $(input).prev().attr('for', `anexos${index + 1}`);
                
                                                        $(input).next().attr('data-unique-id', `anexos${index + 1}`);
                                                    });
                
                                                    // cambiar el texto de los labels
                                                    $('#editPresupuestoModal #AnexosContainer label').each(function(index, label) {
                                                        $(label).text(`Anexo ${index + 1}`);
                                                    });

                                                },
                                                error: function(response){
                                                    closeLoader();
                                                    console.error(response);
                                                    showToast('Algo salió mal', 'error');
                                                }
                                            });

                                        }

                                    })
                                    
                                });

                                newInputContainer.append(removeBtn);
                                newInputContainer.append(label);
                                newInputContainer.append(newInput);
                                $('#editPresupuestoModal #AnexosContainer').append(newInputContainer);

                                // autoexpandir los textarea de los anexos
                                $('#editPresupuestoModal #AnexosContainer textarea').each(function() {
                                    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                                }).on('input', function() {
                                    this.style.height = 'auto';
                                    this.style.height = (this.scrollHeight) + 'px';
                                });

                                // hacer scroll hasta el final del textarea
                                newInput.focus();

                                // abrir el teclado en dispositivos moviles
                                newInput.trigger('click');
                            });

                            // cargar los archivos
                            // archivos.forEach((archivo, index) => {
                            //     // mostrar vista previa de las imagenes / videos o audios
                            //     console.log(archivo,index)
                            //     let type = archivo.typeFile;
                            //     let url = archivo.pathFile;
                            //     let comentario = archivo.comentarioArchivo || ''; // Si no hay comentario, asignar cadena vacía

                            //     let serverUrl = 'https://sebcompanyes.com/';
                            //     let urlModificar = '/home/u657674604/domains/sebcompanyes.com/public_html/';
                            //     let urlFinal = url.replace(urlModificar, serverUrl);
                            //     let finalType = '';

                            //     switch (type) {
                            //         case 'jpg':
                            //         case 'jpeg':
                            //         case 'png':
                            //         case 'gif':
                            //             finalType = 'image';                                       
                            //             break;
                            //         case 'mp4':
                            //         case 'avi':
                            //         case 'mov':
                            //         case 'wmv':
                            //         case 'flv':
                            //         case '3gp':
                            //         case 'webm':
                            //             finalType = 'video';
                            //             break;
                            //         case 'mp3':
                            //         case 'wav':
                            //         case 'ogg':
                            //         case 'm4a':
                            //         case 'flac':
                            //         case 'wma':
                            //             finalType = 'audio';
                            //             break;
                            //         case 'pdf':
                            //             finalType = 'pdf';
                            //             break;
                            //         case 'doc':
                            //         case 'docx':
                            //             finalType = 'word';
                            //             break;
                            //         case 'xls':
                            //         case 'xlsx':
                            //             finalType = 'excel';
                            //             break;
                            //         case 'ppt':
                            //         case 'pptx':
                            //             finalType = 'powerpoint';
                            //             break;
                            //         default:
                            //             finalType = 'image';
                            //             break;
                            //     }

                            //     const fileWrapper = $(`<div class="file-wrapper"></div>`).css({
                            //         'display': 'inline-block',
                            //         'text-align': 'center',
                            //         'margin': '10px',
                            //         'width': '350px',
                            //         'height': '400px',
                            //         'vertical-align': 'top',
                            //         'border': '1px solid #ddd',
                            //         'padding': '10px',
                            //         'border-radius': '5px',
                            //         'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                            //         'overflow': 'hidden',
                            //         'position': 'relative'
                            //     });

                            //     // Verificar si es una firma digital
                            //     if (comentario === 'firma_digital_bd') {
                            //         fileWrapper.append(`
                            //             <img src="${urlFinal}" class="img-fluid">
                            //             <br>
                            //             <span>${parte.nombre_firmante}</span>
                            //         `);
                            //         $('#editParteTrabajoModal #showSignatureFromClient').show();
                            //         $('#editParteTrabajoModal #signature-pad').hide();
                            //         $('#editParteTrabajoModal #showSignatureFromClient').append(fileWrapper);
                            //         $('#editParteTrabajoModal #cliente_firmaid').val(parte.nombre_firmante).attr('readonly', true);
                            //         tieneFirma = true;
                            //         return;
                            //     }

                            //     switch (finalType) {
                            //         case 'image':
                            //             fileWrapper.append(`
                            //                 <img src="${urlFinal}" class="img-fluid" style="max-width: 150px">
                            //             `);
                            //             break;
                            //         case 'video':
                            //             fileWrapper.append(`
                            //                 <video controls data-poster="https://sebcompanyes.com/vendor/adminlte/dist/img/mileco.jpeg"
                            //                     style="max-width: 150px; max-height: 340px;">
                            //                     <source src="${urlFinal}" type="video/mp4" />
                            //                 </video>
                            //             `);
                            //             break;
                            //         case 'audio':
                            //             fileWrapper.append(`
                            //                 <audio controls src="${urlFinal}" class="img-fluid" style="max-width: 150px"></audio>
                            //             `);
                            //             break;
                            //         case 'pdf':
                            //             fileWrapper.append(`
                            //                 <embed src="${urlFinal}" type="application/pdf" width="100%" height="600px">
                            //             `);
                            //             break;
                            //         case 'word':
                            //         case 'excel':
                            //         case 'powerpoint':
                            //             fileWrapper.append(`
                            //                 <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${urlFinal}" width="100%" height="600px" frameborder="0">
                            //             `);
                            //             break;
                            //         default:
                            //             fileWrapper.append(`
                            //                 <img src="${urlFinal}" class="img-fluid">
                            //             `);
                            //             break;
                            //     }

                            //     const commentBox    = $(`<textarea class="form-control mb-2 editCommentario mb-1 mt-1" data-archivoid="${archivo.idarchivos}" name="comentario[${index + 1}]" placeholder="Comentario archivo ${index + 1}" rows="2" readonly></textarea>`).val(archivo.comentarioArchivo);
                            //     const buttonDelete  = $(`<button type="button" class="btn btn-danger removeFileServer" data-archivoid="${archivo.idarchivos}"><ion-icon name="trash-outline"></ion-icon></button>`);

                            //     // añadir el boton de eliminar archivo arriba a la derecha del fileWrapper
                            //     buttonDeleteContainer = $(`<div style="position: absolute; top: 0; right: 0;" class="d-flex justify-content-end"></div>`);
                            //     buttonDeleteContainer.append(buttonDelete);

                            //     fileWrapper.append(buttonDeleteContainer);

                            //     fileWrapper.append(commentBox);

                            //     fileWrapper.attr('data-archivoid', archivo.idarchivos);

                            //     $('#editPresupuestoModal #imagesDetails').append(fileWrapper);
                            // });

                            $('#editPresupuestoModal #addNewMaterial').off('click').on('click', function(event){
                                CreateNewParteTrabajo('editPresupuestoModal');
                            })

                            $('.generatePdfPresupuesto').off('click').on('click', function(event) {
                                const id = $(this).data('id');
                                event.preventDefault();
                                // Swal fire con la toma de desicion si necesita el formato corto o largo y el boton de cancelar
                                Swal.fire({
                                    title: '¿Qué formato deseas?',
                                    text: "Selecciona el formato que deseas descargar",
                                    icon: 'question',
                                    showCancelButton: true,
                                    showDenyButton: true,
                                    confirmButtonColor: '#3085d6',
                                    denyButtonColor: '#d33',
                                    confirmButtonText: 'Formato largo',
                                    denyButtonText: 'Formato corto',
                                    cancelButtonText: 'Cancelar',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.open(`/presupuesto/${id}/pdf?formato=largo`, '_blank');
                                    } else if (result.isDenied) {
                                        window.open(`/presupuesto/${id}/pdf?formato=corto`, '_blank');
                                    }
                                });

                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    },
                    error: function(err) {
                        closeLoader();
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo salió mal',
                        });
                    }
                });
            });

            // evento para expandir todos los textarea de editar presupuesto
            $('#editPresupuestoModal').on('shown.bs.modal', function() {
                $('textarea').each(function() {
                    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                }).on('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });

                $('#editPresupuestoModal select').select2({
                    width: '100%',
                    dropdownParent: $('#editPresupuestoModal')
                });

            });

            $('#editParteTrabajoModal').on('shown.bs.modal', function() {
                // expandir los textarea y inicializar los select2
                $('textarea').each(function() {
                    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                }).on('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });

                $('#editParteTrabajoModal select').select2({
                    width: '100%',
                    dropdownParent: $('#editParteTrabajoModal')
                });

                $('#editParteTrabajoModal #collapseMaterialesEmpleados select').select2({
                    width: '100%',
                    dropdownParent: $('#editParteTrabajoModal')
                });
            });

            $('#createParteTrabajoPresupuestoModal').on('shown.bs.modal', function() {
                // expandir los textarea y inicializar los select2
                $('textarea').each(function() {
                    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                }).on('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });

                $('#createParteTrabajoPresupuestoModal select').select2({
                    width: '100%',
                    dropdownParent: $('#createParteTrabajoPresupuestoModal')
                });
            });

            $('#createParteTrabajoModal').on('shown.bs.modal', function() {
                // expandir los textarea y inicializar los select2
                $('textarea').each(function() {
                    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                }).on('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });

                $('#createParteTrabajoModal select').select2({
                    width: '100%',
                    dropdownParent: $('#createParteTrabajoModal')
                });
            });

            $('#editPresupuestoSaveBtn').on('click', function(event) {
                event.preventDefault();
                const formData = new FormData($('#editPresupuestoModal #formCreateOrden')[0]);

                const asuntoInput = $('#editPresupuestoModal #formCreateOrden #asunto');
                const fechaAltaInput = $('#editPresupuestoModal #formCreateOrden #fecha_alta');
                const clienteInput = $('#editPresupuestoModal #formCreateOrden #cliente_id');
                const departamentoInput = $('#editPresupuestoModal #formCreateOrden #departamento');
                const trabajoInput = $('#editPresupuestoModal #formCreateOrden #trabajo_id');
                const presupustoId = $('#editPresupuestoModal #formCreateOrden #idParteTrabajo');

                if (!asuntoInput.val() || !fechaAltaInput.val() || !clienteInput.val() || !departamentoInput.val() || !trabajoInput.val()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: `El campo ${!asuntoInput.val() ? 'Asunto' : !fechaAltaInput.val() ? 'Fecha de alta' : !clienteInput.val() ? 'Cliente' : !departamentoInput.val() ? 'Departamento' : 'Trabajo'} es requerido`,
                    });
                    return;
                }

                $.ajax({
                    // la url necesito hacerle el replace para que me tome el id del presupuesto
                    url: "{{ route('admin.presupuestos.update', ':presupuestoId') }}".replace(':presupuestoId', presupustoId.val()),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Presupuesto actualizado correctamente',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#editPresupuestoModal').modal('hide');
                            table.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo salió mal',
                            });
                        }
                    },
                    error: function(err) {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo salió mal',
                        });
                    }
                });

            });

            calculateTotalSum();
        });

    </script>
@stop
