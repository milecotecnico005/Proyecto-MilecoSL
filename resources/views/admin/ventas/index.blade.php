@extends('adminlte::page')

@section('title', 'Ventas')

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
        {{-- <div class="" id="handsonTable">
        </div> --}}
        <div id="VentaMainsGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>

        {{-- <div id="myTable_controls" class="mb-3"></div> --}}
        {{-- <table id="ventas" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Emp</th>
                    <th>Agente</th>
                    <th>F.Pago</th>
                    <th>Estado</th>
                    <th>Importe</th>
                    <th>IVA</th>
                    <th>Plazo</th>
                    <th>T.Iva</th>
                    <th>Retenciones</th>
                    <th>Cobrado</th>
                    <th>A.Contable</th>
                    <th>Obs.</th>
                    <th>Total</th>
                    <th>Pendiente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr
                        class="mantenerPulsadoParaSubrayar"
                    >
                        <td>{{ $venta->idVenta }}</td>
                        <td>{{ formatDate($venta->FechaVenta) }}</td>
                        <td
                            class="text-truncate"
                            data-fulltext="{{ $venta->cliente->NombreCliente }}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ $venta->cliente->NombreCliente }} {{ $venta->cliente->ApellidosCliente }}"
                        >
                            {{ Str::limit( $venta->cliente->NombreCliente." ".$venta->cliente->ApellidosCliente, 5) }}
                        </td>
                        <td
                            class="text-truncate"
                            data-fulltext="{{ $venta->empresa->EMP }}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ $venta->empresa->EMP }}"
                        >
                            {{ Str::limit($venta->empresa->EMP, 5) }}
                        </td>
                        <td
                            class="text-truncate"
                            data-fulltext="{{ $venta->AgenteVenta }}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ $venta->AgenteVenta }}"
                        >
                            {{ Str::limit($venta->AgenteVenta, 5) }}
                        </td>
                        <td
                            class="text-truncate"
                            data-fulltext="{{ $venta->FormaPagoVenta == 1 ? 'Efectivo' : 'Banco' }}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ $venta->FormaPagoVenta == 1 ? 'Efectivo' : 'Banco' }}"
                        >
                            @if ($venta->FormaPago == 1)
                                <span class="badge bg-success">Efectivo</span>
                            @elseif ($venta->FormaPago == 2)
                                <span class="badge bg-warning">Banco</span>
                            @endif
                        </td>
                        @php
                            $estadoVenta = $venta->ventaConfirm;
                        @endphp
                        <td
                            @if ($estadoVenta)
                                data-fulltext="{{ number_format($venta->ImporteVenta, 2) }}€"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ number_format($venta->ImporteVenta, 2) }}€"
                            @endif
                        >
                            @if ($estadoVenta)
                                <span class="badge bg-success">Facturada</span>
                            @endif
                        </td>
                        <td
                            data-fulltext="{{ number_format($venta->ImporteVenta, 2) }}€"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ number_format($venta->ImporteVenta, 2) }}€"
                        >
                            {{ number_format($venta->ImporteVenta, 2) }}€
                        </td>
                        <td
                            data-fulltext="{{ number_format($venta->IVAVenta, 2) }}€"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ number_format($venta->IVAVenta, 2) }}€"
                        >
                            {{ number_format($venta->IVAVenta, 2) }}€
                        </td>
                        <td
                            data-fulltext="{{ $venta->Plazos }}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ $venta->Plazos }}"
                            @if ($venta->Plazos != 0)
                                class="openModalPlazos"
                                data-venta="{{ $venta->idVenta }}"
                                style="cursor: pointer; text-decoration: underline;"
                            @endif
                        >
                            {{ $venta->Plazos }}
                        </td>
                        <td
                            data-fulltext="{{ number_format($venta->TotalIvaVenta, 2) }}€"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ number_format($venta->TotalIvaVenta, 2) }}€"
                        >
                            {{ number_format($venta->TotalIvaVenta, 2) }}€
                        </td>
                        <td
                            data-fulltext="{{ number_format($venta->RetencionesVenta, 2) }}€"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ number_format($venta->RetencionesVenta, 2) }}€"
                        >
                            {{ number_format($venta->RetencionesVenta, 2) }}€
                        </td>
                        <td
                            data-fulltext="{{ number_format($venta->Cobrado, 2) }}€"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ number_format($venta->Cobrado, 2) }}€"
                        >
                            {{ number_format($venta->Cobrado, 2) }}€
                        </td>
                        <td
                            data-fulltext="{{ number_format($venta->TotalFacturaVenta, 2) }}€"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ number_format($venta->TotalFacturaVenta, 2) }}€"
                        >
                            {{ number_format($venta->TotalFacturaVenta, 2) }}€
                        </td>
                        <td
                            data-fulltext="{{ $venta->Observaciones }}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ $venta->Observaciones }}"
                            class="text-truncate"
                        >
                            {{ Str::limit($venta->Observaciones, 5) }}
                        </td>
                        <td
                            data-fulltext="{{ number_format($venta->TotalFacturaVenta, 2) }}€"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ number_format($venta->TotalFacturaVenta, 2) }}€"
                        >
                            {{ number_format($venta->TotalFacturaVenta, 2) }}€
                        </td>
                        <td
                            data-fulltext="{{ number_format($venta->PendienteVenta, 2) }}€"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ number_format($venta->PendienteVenta, 2) }}€"
                        >
                            {{ $venta->PendienteVenta }}€
                        </td>

                        <td>
                            @component('components.actions-button')
                                <button 
                                    type="button" 
                                    class="btn btn-primary detailsVentaBtn" 
                                    data-id="{{ $venta->idVenta }}"
                                    data-bs-placement="top"
                                    title="Detalles de la Venta"
                                    data-bs-toggle="tooltip"
                                >
                                    <ion-icon name="information-circle-outline"></ion-icon>
                                </button>
                                    @if ( !$venta->ventaConfirm )
                                        <button 
                                            type="button" 
                                            class="btn btn-info editVentaBtn" 
                                            data-id="{{ $venta->idVenta }}"
                                            data-bs-placement="top"
                                            title="Editar Venta"
                                            data-bs-toggle="tooltip"
                                        >
                                            <ion-icon name="create-outline"></ion-icon>
                                        </button>
                                        <a 
                                            class="btn btn-success generateAlbaran" 
                                            href="{{ route('admin.ventas.generateAlbaran', $venta->idVenta) }}" 
                                            target="_blank"
                                            data-bs-placement="top"
                                            title="Albarán"
                                            data-bs-toggle="tooltip"
                                        >
                                            <ion-icon name="document-attach-outline"></ion-icon>
                                        </a>
                                    @endif
                                <a 
                                    class="btn btn-warning generateFactura" 
                                    href="{{ route('admin.ventas.generateFactura', $venta->idVenta) }}" 
                                    target="_blank"
                                    data-bs-placement="top"
                                    title="{{ $venta->ventaConfirm ? 'Descargar Factura' : 'Generar Factura' }}"
                                    data-bs-toggle="tooltip"
                                >
                                    @if ( !$venta->ventaConfirm )
                                        <ion-icon name="cash-outline"></ion-icon>
                                    @else
                                        <ion-icon name="cloud-download-outline"></ion-icon>
                                    @endif
                                </a>
                            @endcomponent
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>
    
</div>

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

@stop

@section('css')
    <style>
        .shadow-lg {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #myTable {
            width: 100% !important;
        }

        #myTable thead th {
            position: relative; /* Necesario para que jQuery UI resizable funcione */
        }

        .ui-resizable-e {
            width: 5px;
            cursor: ew-resize;
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
        }
        .ui-resizable-s {
            height: 5px;
            cursor: ns-resize;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }

    </style>
@stop

@section('js')
    <script> 

        $(document).ready(function() {
            // let table = $('#ventas').DataTable({
            //     colReorder: {
            //         realtime: false
            //     },
            //     // responsive: true,
            //     // autoFill: true,
            //     // fixedColumns: true,
            //     order: [[0, 'desc']],
            //     dom:    "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
            //             "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
            //             "<'row'<'col-12'tr>>" +
            //             "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",
            //     buttons: [
            //         {
            //             text: 'Crear Venta',
            //             className: 'btn btn-outline-warning createVentaBtn mb-2',
            //             id: 'createVentaBtn',
            //         },
            //         {
            //             text: 'Limpiar Filtros', 
            //             className: 'btn btn-outline-danger limpiarFiltrosBtn mb-2', 
            //             action: function (e, dt, node, config) { 
            //                 clearFiltrosFunction(dt, '#ventas');
            //             }
            //         }
            //     ],
            //     pageLength: 50,  // Mostrar 50 registros por defecto
            //     lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opciones para seleccionar cantidad de registros
            //     language: {
            //         processing: "Procesando...",
            //         search: "Buscar:",
            //         lengthMenu: "Mostrar _MENU_ ",
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
            //     initComplete: function () {
            //         configureInitComplete(this.api(), '#ventas', 'VENTAS', 'primary');
            //     }
            // });

            // table.on('init.dt', function() {
            //     restoreFilters(table, '#ventas');// Restaurar filtros después de inicializar la tabla
            // });
            
            // mantenerFilaYsubrayar(table);
            // fastEditForm(table, 'Ventas');

            // Inicializar la tabla de citas
            const agTablediv = document.querySelector('#VentaMainsGrid');

            let rowData = {};
            let data = [];

            const ventas = @json($ventas);

            const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
                { 
                    name: 'ID',
                    fieldName: 'Venta',
                    addAttributes: true, 
                    addcustomDatasets: true,
                    dataAttributes: { 
                        'data-id': ''
                    },
                    attrclassName: 'openEditVentaFast',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                    principal: true
                },
                {
                    name: 'NumFac',
                    addAttributes: true,
                    fieldName: 'num_fac',
                    fieldType: 'text',
                    editable: true,
                },
                {
                    name: 'TipoDoc',
                    addAttributes: true,
                    fieldName: 'tipo_doc',
                    fieldType: 'text',
                    editable: true,
                },
                { 
                    name: 'Fecha',
                    className: 'fecha-alta-column',
                    fieldName: 'FechaVenta',
                    fieldType: 'date',
                    editable: true,
                }, 
                { 
                    name: 'Emp',
                    // addAttributes: true,
                    // fieldName: 'NFacturaCompra',
                    // fieldType: 'textarea',
                    // dataAttributes: { 
                    //     'data-order': 'order-column' 
                    // },
                    // editable: true,
                    // attrclassName: 'openProjectDetails',
                    // styles: {
                    //     'cursor': 'pointer',
                    //     'text-decoration': 'underline'
                    // },
                },
                { 
                    name: 'Cliente',
                    fieldName: 'cliente_id',
                    fieldType: 'select',
                    addAttributes: true,
                },
                { 
                    name: 'Agente',
                    fieldName: 'AgenteVenta',
                    fieldType: 'text',
                    addAttributes: true,
                    editable: true,
                },
                { name: 'FPago' },
                { name: 'Enlace' },
                { name: 'Estado' },
                { name: 'Importe' },
                { name: 'IVA' },
                { name: 'TIva' },
                { 
                    name: 'Plazo',
                    fieldName: 'Plazos',
                    attrclassName: 'openModalPlazos',
                    addAttributes: true,
                    dataAttributes: { 
                        'data-venta': ''
                    },
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                },
                { name: 'Retenciones' },
                { name: 'Cobrado' },
                { name: 'AContable' },
                { name: 'Observaciones' },
                { name: 'Total' },
                { name: 'Pendiente' },
                { 
                    name: 'Notas1',
                    fieldName: 'notas1',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "notas1",
                        'data-type': "text"
                    }
                },
                { 
                    name: 'Notas2',
                    fieldName: 'notas2',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "notas2",
                        'data-type': "text"
                    }
                },
                { 
                    name: 'Acciones',
                    className: 'acciones-column'
                }
            ];

            function prepareRowData(ventas) {
                ventas.forEach(venta => {
                    // console.log(parte);
                    // if (parte.proyecto_n_m_n && parte.proyecto_n_m_n.length > 0) {
                    //     console.log({proyecto: parte.proyecto_n_m_n[0].proyecto.name});
                    // }
                    const rutaEnlace = (venta.venta_confirm) ? `/admin/ventas/download_factura/${venta.idVenta}` : `/admin/ventas/albaran/${venta.idVenta}`;
                    const nombreCliente = `${venta.cliente.NombreCliente} ${venta.cliente.ApellidoCliente}`;
                    rowData[venta.idVenta] = {
                        ID: venta.idVenta,
                        NumFac: venta.num_fac ?? '',
                        TipoDoc: venta.tipo_doc ?? '',
                        Fecha: formatDateYYYYMMDD(venta.FechaVenta),
                        Emp: venta.empresa.EMP,
                        Cliente: nombreCliente,
                        Agente: venta.AgenteVenta,
                        FPago: (venta.formaPago == 1) ? 'Banco' : 'Efectivo',
                        Estado: (venta.venta_confirm) ? 'Facturado' : 'Albarán',
                        Enlace: rutaEnlace,
                        Importe: formatPrice(venta.ImporteVenta),
                        IVA: venta.IVAVenta+'%',
                        Plazo: venta.Plazos,
                        TIva: formatPrice(venta.TotalIvaVenta),
                        Retenciones: venta.RetencionesVenta+'%',
                        Cobrado: formatPrice(venta.Cobrado),
                        AContable: venta.NAsientoContable,
                        Observaciones: venta.Observaciones,
                        Total: formatPrice(venta.TotalFacturaVenta),
                        Pendiente: formatPrice(venta.PendienteVenta),
                        Notas1: venta.notas1,
                        Notas2: venta.notas2,
                        Acciones: 
                        `
                            @component('components.actions-button')
                                <button 
                                    type="button" 
                                    class="btn btn-outline-primary detailsVentaBtn" 
                                    data-id="${venta.idVenta}"
                                    data-bs-placement="top"
                                    title="Detalles de la Venta"
                                    data-bs-toggle="tooltip"
                                >
                                    <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                        <ion-icon name="information-circle-outline"></ion-icon>
                                        <small>Detalles</small>
                                    </div>
                                </button>
                                    ${ (venta.venta_confirm == null) ? `
                                        <button 
                                            type="button" 
                                            class="btn btn-info editVentaBtn" 
                                            data-id="${venta.idVenta}"
                                            data-bs-placement="top"
                                            title="Editar Venta"
                                            data-bs-toggle="tooltip"
                                        >
                                            <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                                <ion-icon name="create-outline"></ion-icon>
                                                <small>Editar</small>
                                            </div>
                                        </button>
                                        <a 
                                            class="btn btn-success generateAlbaran" 
                                            href="/admin/ventas/albaran/${venta.idVenta}" 
                                            target="_blank"
                                            data-bs-placement="top"
                                            title="Albarán"
                                            data-bs-toggle="tooltip"
                                        >
                                            <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                                <ion-icon name="document-attach-outline"></ion-icon>
                                                <small>Albarán</small>
                                            </div>
                                        </a>
                                    ` : ''}
                                <a 
                                    class="btn btn-warning ${ (venta.venta_confirm == null) ? 'generateFactura' : '' }" 
                                    href="${ (venta.venta_confirm == null) ? `/admin/ventas/factura/${venta.idVenta}` : `/admin/ventas/download_factura/${venta.idVenta}` }" 
                                    target="_blank"
                                    data-bs-placement="top"
                                    data-ventaid="${venta.idVenta}"
                                    title="${ (venta.venta_confirm !== null) ? 'Descargar Factura' : 'Facturar' }"
                                    data-bs-toggle="tooltip"
                                >
                                    <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                        ${ (venta.venta_confirm == null) ? `
                                            <ion-icon name="cash-outline"></ion-icon>
                                        ` : `
                                            <ion-icon name="cloud-download-outline"></ion-icon>
                                        `}
                                        <small>${ (venta.venta_confirm == null) ? 'Facturar' : 'Descargar' }</small>
                                    </div>
                                </a>
                            @endcomponent
                        
                        `
                    }
                });

                data = Object.values(rowData);
            }

            prepareRowData(ventas);

            const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
                const customButtons = `
                    <button type="button" class="btn btn-outline-warning createVentaBtn">
                        <div class="d-flex justify-between align-items-center align-content-center">
                            <small>Crear Venta</small>
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                    </button>
                `;

                // Inicializar la tabla de citas
                inicializarAGtable( agTablediv, data, result, 'Ventas', customButtons, 'Ventas');
            });

            let table = $('#VentaMainsGrid');
            
            
            $('.limpiarFiltrosBtn').removeClass('dt-button');
            $('.createVentaBtn').removeClass('dt-button');

            function toggleExpandAsunto(element) {
                // Obtener el texto completo y truncado del atributo data-fulltext
                let fullText = element.getAttribute('data-fulltext');
                let truncatedText = fullText.length > 5 ? fullText.substring(0, 5) + '...' : fullText;

                // Reemplazar saltos de línea con <br> para renderizar correctamente
                fullText = fullText.replace(/\n/g, '<br>');
                truncatedText = truncatedText.replace(/\n/g, '<br>');

                // Comparar el texto actual con el fulltext para decidir la acción
                if (element.innerHTML === fullText) {
                    element.innerHTML = truncatedText;  // Mostrar truncado
                } else {
                    element.innerHTML = fullText;  // Mostrar completo
                }
            }

            table.on('click', '.text-truncate', function(e){
                toggleExpandAsunto(e.target);
            });

            let compraGuardadaGlobal = false;
            let globalLineas = 0;
            let sumaTotalesLineas = 0;

            table.on('click', '.generateFactura', function(e){
                event.preventDefault();
                Swal.fire({
                    title: 'Generar Factura',
                    text: '¿Estás seguro de querer generar la factura?, ningun elemento podrá ser modificado después',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, generar',
                    cancelButtonText: 'Cancelar',
                    allowClickOutside: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        openLoader();
                        // destruir este boton para el registro que se genero la factura
                        const generateAlbaran = $(this).closest('tr').find('.generateAlbaran');
                        generateAlbaran.remove();
                        
                        window.location.href = $(this).attr('href');
                        closeLoader();
                    }
                })

            });
    
            const calcularTotales = ( id ) => {
                let totalFactura = 0;
                let totalIva = parseFloat($('#IvaVenta').val()) || 0;
                let suplidos = parseFloat($('#SuplidosVenta').val()) || 0;
                let retenciones = parseFloat($('#RetencionesVenta').val()) || 0;
                let totalRetenciones = parseFloat($('#TotalRetencionesVenta').val()) || 0;
    
                $('#elementsToShow tr').each(function() {
                    let totalLinea = parseFloat($(this).find('.total-linea').text());
                    totalFactura += totalLinea;
                });

                const totalIvaParte = totalFactura - (totalFactura / (1 + (totalIva / 100)));
    
                totalIva = totalIvaParte;
                totalIva = parseFloat(totalIva.toFixed(2));

                totalRetenciones = totalFactura * (retenciones / 100);
                totalRetenciones = parseFloat(totalRetenciones.toFixed(2));
    
                totalFactura += suplidos - totalRetenciones;
                totalFactura = parseFloat(totalFactura.toFixed(2));

                let pendienteVenta = totalFactura - parseFloat( $('#Cobrado').val() );
                let cobrado = parseFloat($('#Cobrado').val());

                totalFactura.toFixed(2);
                totalIva.toFixed(2);
                totalRetenciones.toFixed(2);
                pendienteVenta.toFixed(2);
                cobrado.toFixed(2);

    
                $('#TotalIvaVenta').val(totalIva.toFixed(2));
                $('#TotalRetencionesVenta').val(totalRetenciones.toFixed(2));
                $('#TotalFacturaVenta').val(totalFactura.toFixed(2));
                $('#PendienteVenta').val(pendienteVenta.toFixed(2));
    
                if ( id ) {
                    $.ajax({
                        url: '/admin/lineasventas/update/' + id,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            totalFactura,
                            totalIva,
                            suplidos,
                            retenciones,
                            totalRetenciones,
                            cobrado,
                            pendiente: pendienteVenta,
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
    
            }

            const calcularTotalesEdit = ( id ) => {
                let totalFactura = 0;
                let totalIva = parseFloat($('#editVentaModal #IvaVenta').val()) || 0;
                let suplidos = parseFloat($('#editVentaModal #SuplidosVenta').val()) || 0;
                let retenciones = parseFloat($('#editVentaModal #RetencionesVenta').val()) || 0;
                let totalRetenciones = parseFloat($('#editVentaModal #TotalRetencionesVenta').val()) || 0;
    
                $('#editVentaModal #elementsToShow tr').each(function() {
                    let totalLinea = parseFloat($(this).find('.total-linea').text());
                    totalFactura += totalLinea;
                });
    
                const totalIvaParte = totalFactura - (totalFactura / (1 + (totalIva / 100)));
    
                totalIva = totalIvaParte;
                totaliva = parseFloat(totalIva.toFixed(2));

                totalRetenciones = totalFactura * (retenciones / 100);
                totalRetenciones = parseFloat(totalRetenciones.toFixed(2));
    
                totalFactura += totalIva + suplidos - totalRetenciones;
                totalFactura = parseFloat(totalFactura.toFixed(2));

                let pendienteVenta = totalFactura - parseFloat( $('#editVentaModal #Cobrado').val() );
                let cobrado = parseFloat($('#editVentaModal #Cobrado').val());

                totalFactura.toFixed(2);
                totalIva.toFixed(2);
                totalRetenciones.toFixed(2);
                pendienteVenta.toFixed(2);
                cobrado.toFixed(2);

                $('#editVentaModal #TotalIvaVenta').val(totalIva.toFixed(2));
                $('#editVentaModal #TotalRetencionesVenta').val(totalRetenciones.toFixed(2));
                $('#editVentaModal #TotalFacturaVenta').val(totalFactura.toFixed(2));
                $('#editVentaModal #PendienteVenta').val(pendienteVenta.toFixed(2));
    
                if ( id ) {
                    $.ajax({
                        url: '/admin/lineasventas/update/' + id,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            totalFactura,
                            totalIva,
                            suplidos,
                            retenciones,
                            totalRetenciones,
                            cobrado,
                            pendiente: pendienteVenta
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
    
            }
    
            // Mostrar modal para crear nueva venta
            table.on('click','.createVentaBtn', function (e) {
                e.preventDefault();
                $('#createVentaModal').modal('show');
                $('#createVentaTitle').text('Crear Venta');
                $('#createVentaForm')[0].reset(); // Reiniciar formulario

                // Limpiar tabla de elementos
                $('#createVentaModal #elementsToShow').empty();

                $('#createVentaModal #FechaVenta').val(new Date().toISOString().split('T')[0]);
                $('#createVentaModal #AgenteVenta').val('{{ Auth::user()->name }}');
                $('#createVentaModal #EnviadoVenta').val('{{ Auth::user()->email }}');
                $('#createVentaModal #NAsientoContable').val(1);
                $('#createVentaModal #Observaciones').val('Sin observaciones');
                $('#createVentaModal #TotalIvaVenta').val(0);
                $('#createVentaModal #TotalRetencionesVenta').val(0);
                $('#createVentaModal #TotalFacturaVenta').val(0);
                $('#v #Observaciones').val('Sin observaciones');

                // Inicializar Select2

                // Destruir la instancia de Select2, si existe
                if ($('#createVentaModal .form-select').data('select2')) {
                    $('#createVentaModal .form-select').select2('destroy');
                }

                // Inicializa Select2
                $('#createVentaModal .form-select').select2({
                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                    dropdownParent: $('#createVentaModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                    placeholder: 'Seleccione un cliente',
                });


            });
    
            // Calcular el total del IVA a partir del importe y almacenarlo
            $('#IvaVenta').on('change', function() {
                calcularTotales();
            });
    
            // calcular el valor a partir de las retenciones
            $('#RetencionesVenta').on('change', function() {
                calcularTotales();
            });
    
            $('#createVentaModal #Cobrado').on('focusout', function() {
                if ( $('#Cobrado').val() === '' ) {
                    Swal.fire({
                        title: 'Advertencia',
                        text: 'El valor cobrado no puede estar vacío',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
            });
    
            // Calcular el cobrado y el pendiente a partir del total de la factura
            $('#createVentaModal #Cobrado').on('change', function() {
                let totalFactura = parseFloat($('#TotalFacturaVenta').val());
    
                if ( $('#Cobrado').val() === '' ) {
                    Swal.fire({
                        title: 'Advertencia',
                        text: 'El valor cobrado no puede estar vacío',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
    
                let cobrado = parseFloat($('#Cobrado').val());
    
                cobrado = isNaN(cobrado) ? 0 : cobrado;
    
                if ( cobrado < 0 ) {
                    Swal.fire({
                        title: 'Error',
                        text: 'El valor cobrado no puede ser menor a 0',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
    
                if ( isNaN(cobrado) ) {
                    $('#Cobrado').val(0);
                }
    
                let pendiente = totalFactura - cobrado;
    
                if (pendiente < 0) {
                    Swal.fire({
                        title: 'Error',
                        text: 'El valor cobrado no puede ser mayor al total de la factura',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
    
                $('#PendienteVenta').val(pendiente);
            });
    
            // Actualizar el total de la factura con los suplidos
            $('#SuplidosVenta').on('change', function() {
                calcularTotales();
            });
    
            // Guardar nueva venta
            $('#guardarVenta').click(function () {
                openLoader();
                const table = $('#tableToShowElements');
                const elements = $('#elementsToShow');
    
                // Ocultar tabla de elementos
                table.hide();
                
                // Obtener los datos del formulario en un objeto FormData
                const formData = new FormData($('#createVentaForm')[0]);
    
                // Agregar el token CSRF manualmente si no se incluye automáticamente en el formulario
                formData.append('_token', '{{ csrf_token() }}');
    
                $.ajax({
                    url: '{{ route("admin.ventas.store") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,  // No procesar los datos (FormData no necesita ser procesado)
                    contentType: false,  // No establecer automáticamente el tipo de contenido
                    success: function({ message, venta, cliente, archivos, articulos, ordenes, partes, proyectos, ventaEmp }) {
                        closeLoader();
                        // Cerrar primer acordeón y abrir el segundo
                        $('#collapseDetallesVenta').collapse('hide');
                        $('#collapseLineasVenta').collapse('show');
    
                        Swal.fire({
                            title: 'Venta guardada',
                            text: message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });

                        partes = Object.values(partes);
    
                        ventaGuardadaGlobal = true;
                        $('#guardarVenta').attr('disabled', true);
    
                        if (ventaGuardadaGlobal) {
                            // Desactivar todos los inputs del formulario de venta
                            $('#createVentaForm input, #createVentaForm select, #createVentaForm textarea').attr('disabled', true);
    
                            $('#addNewLine').off('click').on('click', function() {
                                globalLineas++;
    
                                let newLine = `
                                    <form id="AddNewLineForm${globalLineas}" class="mt-2 mb-2">
                                        <div class="row">
                                            <input type="hidden" id="venta_id" name="venta_id" value="${venta.idVenta}">
                                            <input type="hidden" id="clienteId" name="cliente_id" value="${cliente.idCliente}">
                                            <input type="hidden" id="clienteNameId" name="cliente_name" value="${cliente.nombre}">
                                            <input type="hidden" id="archivoId" name="archivo_id" value="${venta.archivoId}">
                                            <input type="hidden" id="totalFactura" name="totalFactura" value="${venta.TotalFacturaVenta}">
                                            <input type="hidden" id="sumaTotalesLineas" data-value="0">
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="venderProyecto${globalLineas}">
                                                        <input type="checkbox" id="venderProyecto${globalLineas}" class="venderProyectoCheckbox"> Vender Proyecto
                                                    </label>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group select-container" id="ordenTrabajoContainer${globalLineas}">
                                                    <label for="ordenTrabajo${globalLineas}">Parte de trabajo</label>
                                                    <select class="form-select ordenTrabajo" id="ordenTrabajo${globalLineas}" name="ordenTrabajo" required>
                                                        <option value="" selected>Seleccione un parte de trabajo</option>
                                                        ${partes.map(parte => `
                                                            <option 
                                                                data-tipo="parte" 
                                                                data-lineas="${parte.lineas}" 
                                                                data-valorparte="${parte.totalParte}" 
                                                                value="${parte.idParteTrabajo}"
                                                            >
                                                                Num ${parte.idParteTrabajo} | ${( parte.tituloParte) ? parte.tituloParte : parte.Asunto }
                                                            </option>`
                                                        ).join('')}
                                                    </select>
                                                </div>
    
                                                <div class="form-group select-container" id="proyectoContainer${globalLineas}" style="display: none;">
                                                    <label for="proyecto${globalLineas}">Proyecto</label>
                                                    <select class="form-select proyecto" id="proyecto${globalLineas}" name="proyecto">
                                                        <option value="">Seleccione un proyecto</option>
                                                        ${proyectos.map(proyecto => `
                                                            <option 
                                                                value="${proyecto.idProyecto}"
                                                            >
                                                                Num ${proyecto.idProyecto} | ${proyecto.name}
                                                            </option>
                                                        `).join('')}
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div id="containerArticulo${globalLineas}" class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label for="articulo${globalLineas}">Artículo</label>
                                                    <select class="form-select articulo" id="articulo${globalLineas}" name="articulo[]" required disabled>
                                                        <option value="">Seleccione un artículo</option>
                                                        ${articulos.map(articulo => `<option data-trazabilidad="${articulo.TrazabilidadArticulos}" value="${articulo.idArticulo}">${articulo.nombreArticulo}</option>`).join('')}
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cantidad${globalLineas}">Cantidad</label>
                                                    <input type="number" class="form-control cantidad" id="cantidad${globalLineas}" name="cantidad" value="1" step="0.01" required disabled>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="precioSinIva${globalLineas}">Precio sin iva</label>
                                                    <input type="number" class="form-control precioSinIva" id="precioSinIva${globalLineas}" name="precioSIva" step="0.01" required disabled>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="descuento${globalLineas}">Descuento</label>
                                                    <input type="number" class="form-control descuento" id="descuento${globalLineas}" name="descuento" step="0.01" value="0" required disabled>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="total${globalLineas}">Total</label>
                                                    <input type="number" class="form-control total" id="total${globalLineas}" name="total" step="0.01" required disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-success saveLinea" data-line="${globalLineas}">Guardar</button>    
                                    </form>
                                `;
    
                                $('#newLinesContainer').append(newLine);

                                // Inicializa Select2
                                $('select.form-select').select2({
                                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                                    dropdownParent: $('#createVentaModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                                });

                                $(`ordenTrabajoContainer${globalLineas}`).off('change').on('change', function(){
                                    // desbloquear el campo descuento
                                    $(`#descuento${globalLineas}`).prop('disabled', false);

                                    // si el valor de la orden de trabajo cambia a un valor vacio, limpiar los campos y bloquearlos
                                    if ( $(this).val() === '' ) {
                                        $(`#cantidad${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#precioSinIva${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#descuento${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#total${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#containerArticulo${globalLineas}`).addClass('d-none');
                                        $(`#articulo${globalLineas}`).val('').trigger('change').prop('disabled', true);
                                    }

                                });
    
                                // Toggle visibility based on checkbox state
                                $(`#venderProyecto${globalLineas}`).off('change').on('change', function() {
                                    if ($(this).is(':checked')) {
                                        $(`#proyectoContainer${globalLineas}`).show();
                                        $(`#ordenTrabajoContainer${globalLineas}`).hide();
                                        $(`#articulo${globalLineas}`).prop('disabled', false).show();
                                        $(`#cantidad${globalLineas}`).prop('disabled', false);
                                        $(`#precioSinIva${globalLineas}`).prop('disabled', false);
                                        $(`#descuento${globalLineas}`).prop('disabled', false);
                                        $(`#total${globalLineas}`).prop('disabled', false);
                                        $(`#containerArticulo${globalLineas}`).removeClass('d-none');
                                    } else {
                                        $(`#proyectoContainer${globalLineas}`).hide();
                                        $(`#ordenTrabajoContainer${globalLineas}`).show();
                                        $(`#cantidad${globalLineas}`).prop('disabled', true).val('');
                                        $(`#precioSinIva${globalLineas}`).prop('disabled', true).val('');
                                        $(`#descuento${globalLineas}`).prop('disabled', true).val('');
                                        $(`#total${globalLineas}`).prop('disabled', true).val('');
                                        $(`#containerArticulo${globalLineas}`).addClass('d-none');
                                        $(`#articulo${globalLineas}`).prop('disabled', true).val('').trigger('change').hide();
                                    }
                                });
    
                                // cargar en articulos los partes de trabajo correspondientes al proyecto seleccionado
                                $(`#proyecto${globalLineas}`).off('change').on('change', function() {
                                    const proyectoId = $(this).val();
                                    const form = $(this).closest('form');
                                    const articuloSelect = form.find('.articulo');
                                    let sumaTotalVentas = 0;
                                    if (proyectoId) {
                                        articuloSelect.attr('disabled', false);
                                        $.ajax({
                                            url: `/admin/proyectos/${proyectoId}/partes`,
                                            method: 'GET',
                                            beforeSend: function() {
                                                articuloSelect.empty();
                                                articuloSelect.append('<option>Cargando...</option>');
                                                openLoader();
                                            },
                                            success: function(response) {
                                                articuloSelect.empty();
                                                articuloSelect.attr('disabled', false);
                                                articuloSelect.attr('multiple', "multiple");
                                                response.partes.forEach(parte => {

                                                    // validar si algun parte de trabajo aun no se ha finalizado
                                                    if (parte.parte_trabajo.Estado == '2') {
                                                        Swal.fire({
                                                            title: 'Error',
                                                            text: 'El parte de trabajo con asunto ' + parte.parte_trabajo.Asunto + ' aún no ha sido finalizado',
                                                            icon: 'error',
                                                            confirmButtonText: 'Aceptar'
                                                        });
                                                        articuloSelect.val('').trigger('change');
                                                        closeLoader();
                                                        return;
                                                    }

                                                    // TODO: validar que los partes de trabajo, sus articulos pertenecen a la empresa que esta creando la venta
                                                    articuloSelect.append(`
                                                    <option 
                                                        data-tipo="parte"
                                                        data-lineas=${JSON.stringify(parte.parte_trabajo.partes_trabajo_lineas)}
                                                        data-suma="${parte.parte_trabajo.totalParte}"
                                                        value="${parte.parte_trabajo.idParteTrabajo}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="${parte.parte_trabajo.Asunto} | Visita: ${parte.parte_trabajo.FechaVisita}"
                                                    >
                                                        Num ${parte.parte_trabajo.idParteTrabajo} | ${ (parte.parte_trabajo.tituloParte) ? parte.parte_trabajo.tituloParte : parte.parte_trabajo.Asunto }
                                                    </option>
                                                    `);
                                                    sumaTotalVentas += parte.parte_trabajo.totalParte;
                                                });

                                                // seleccionar todos los articulos
                                                articuloSelect.val(response.partes.map(parte => parte.parte_trabajo.idParteTrabajo));
                                                closeLoader();

                                                //convertir el selector de articulos en un select2
                                                // Destruir la instancia de Select2, si existe
                                                if ($('.articulo').data('select2')) {
                                                    $('.articulo').select2('destroy');
                                                }
                                                // Inicializa Select2
                                                $('.articulo').select2({
                                                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                                                    dropdownParent: $('#createVentaModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                                                });

                                                // seleccionar todos los articulos
                                                articuloSelect.val(response.partes.map(parte => parte.parte_trabajo.idParteTrabajo));

                                                $(`#precioSinIva${globalLineas}`).val(sumaTotalVentas).attr('disabled', true);
                                                $(`#cantidad${globalLineas}`).val(response.partes.length).attr('disabled', true);
                                                $(`#total${globalLineas}`).val(sumaTotalVentas).attr('disabled', true);
                                                $('#sumaTotalesLineas').data('value', sumaTotalVentas).attr('disabled', true);
                                                
                                                // Calcular el total de ventas de los partes seleccionados si quito una parte restarle el valor al total

                                                articuloSelect.on('change', function() {
                                                    let total           = 0;
                                                    let selectedOptions = $(this).find('option:selected');
                                                    let lineas          = [];

                                                    selectedOptions.each(function() {
                                                        total += parseFloat($(this).data('suma'));
                                                        lineas.push($(this).data('lineas'));
                                                    });

                                                    lineas = lineas.map((linea) => {
                                                        if (linea.length > 0) {
                                                            return linea;
                                                        }
                                                    })

                                                    console.log({
                                                        lineas
                                                    })

                                                    const validateEmp = lineas.every((linea) => linea.articulo.empresa_id === ventaEmp);
                                                    const idsQueNoPertenecen = lineas.filter((linea) => linea.articulo.empresa_id !== ventaEmp).map((linea) => linea.articulo.empresa_id);

                                                    console.log({
                                                        validateEmp,
                                                        idsQueNoPertenecen
                                                    })

                                                    if (!validateEmp) {
                                                        Swal.fire({
                                                            title: 'Warning',
                                                            text: 'Hay partes de trabajo con materiales de otra empresa, ¿quieres realizar un traspaso de materiales?',
                                                            icon: 'warning',
                                                            confirmButtonText: 'Aceptar',
                                                            showCancelButton: true,
                                                            cancelButtonText: 'Cancelar'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // redirigir a la vista de traspaso de materiales
                                                                
                                                                $.ajax({
                                                                    url: "{{ route('admin.traspasos.store') }}",
                                                                    method: 'POST',
                                                                    data: {
                                                                        _token: '{{ csrf_token() }}',
                                                                        ids: idsQueNoPertenecen
                                                                    },
                                                                    success: function(response) {
                                                                        Swal.fire({
                                                                            title: 'Traspaso realizado',
                                                                            text: response.message,
                                                                            icon: 'success',
                                                                            confirmButtonText: 'Aceptar'
                                                                        })

                                                                    },
                                                                    error: function(error) {
                                                                        console.error(error);
                                                                    }
                                                                });

                                                            } else {
                                                                articuloSelect.val('').trigger('change');
                                                            }
                                                        });
                                                    }

                                                    $(`#precioSinIva${globalLineas}`).val(total).attr('disabled', true);
                                                    $(`#cantidad${globalLineas}`).val(selectedOptions.length).attr('disabled', true);
                                                    $(`#total${globalLineas}`).val(total).attr('disabled', true);
                                                    $('#sumaTotalesLineas').data('value', total).attr('disabled', true);
                                                });
                                                
                                            },
                                            error: function(error) {
                                                console.error(error);
                                                closeLoader();
                                            }
                                        });
                                    } else {
                                        articuloSelect.attr('disabled', true);
                                    }
                                });
    
                                // Activar el selector de artículos solo cuando se selecciona una orden de trabajo
                                $('#newLinesContainer').off('change', `#ordenTrabajo${globalLineas}`).on('change', `#ordenTrabajo${globalLineas}`, function () {
                                    const ordenTrabajoId = $(this).val();
                                    const form = $(this).closest('form');
                                    const articuloSelect = form.find('.articulo');
                                    
                                    // obtener el valor de la orden de trabajo
                                    let tipo = $(this).find('option:selected').data('tipo') || 'Parte';
                                    let suma = $(this).find('option:selected').data('valorparte') || 0;

                                    suma = parseFloat(suma);
                                    suma = suma.toFixed(2);
    
                                    // añadir el valor de la orden de trabajo al precio sin iva
                                    $(`#precioSinIva${globalLineas}`).val(suma).attr('disabled', true);
                                    $(`#cantidad${globalLineas}`).val(1).attr('disabled', true);
                                    $(`#total${globalLineas}`).val(suma).attr('disabled', true);
                                    $(`#descuento${globalLineas}`).val(0).attr('disabled', false);
                                });
    
                                // Delegar eventos en el contenedor para manejar los cambios de los campos dinámicos
                                $('#newLinesContainer').on('change', `#articulo${globalLineas}`, function () {
                                    const articuloId = parseInt($(this).val());
                                    const form = $(this).closest('form');
                                    const precioSinIvaInput = form.find('.precioSinIva');
                                    const cantidadInput = form.find('.cantidad');
                                    const totalInput = form.find('.total');
                                    const descuentoInput = form.find('.descuento');
    
                                    // Buscar el artículo seleccionado para obtener su precio
                                    const articulo = articulos.find(art => art.idArticulo === articuloId);
                         
                                    if (articulo) {
                                        precioSinIvaInput.val(articulo.ptsVenta).attr('disabled', false);
                                        cantidadInput.attr('disabled', false);
                                        descuentoInput.attr('disabled', false);
                                        totalInput.val(cantidadInput.val() * articulo.ptsVenta);
                                        calcularTotales();
                                    }
                                });
    
                                $('#newLinesContainer').on('change', `#cantidad${globalLineas}`, function () {
                                    const cantidad = $(this).val();
                                    const form = $(this).closest('form');
                                    const precioSinIvaInput = form.find('.precioSinIva').val();
                                    const descuentoInput = form.find('.descuento').val();
                                    const totalInput = form.find('.total');
    
                                    if (cantidad && precioSinIvaInput) {
                                        const total = cantidad * precioSinIvaInput - descuentoInput;
                                        totalInput.val(total);
                                        calcularTotales();
                                    }
                                });
    
                                $('#newLinesContainer').on('change', `#precioSinIva${globalLineas}`, function () {
                                    const precioSinIva = $(this).val();
                                    const form = $(this).closest('form');
                                    const cantidad = form.find('.cantidad').val();
                                    const descuentoInput = form.find('.descuento').val();
                                    const totalInput = form.find('.total');
    
                                    if (precioSinIva && cantidad) {
                                        const total = cantidad * precioSinIva - descuentoInput;
                                        totalInput.val(total);
                                        calcularTotales();
                                    }
                                });
    
                                $('#newLinesContainer').on('change', `#descuento${globalLineas}`, function () {
                                    const descuento = parseFloat($(this).val());
                                    const form      = $(this).closest('form');
                                    const cantidad  = parseFloat(form.find('.cantidad').val());
                                    const precioSinIvaInput = parseFloat(form.find('.precioSinIva').val());
                                    const totalInput = form.find('.total');

                                    // validar si es un proyecto
                                    const proyecto = form.find('.proyecto').val();

                                    // el valor del descuento no puede ser mayor al 100%
                                    if (descuento > 100 || descuento < 0) {
                                        Swal.fire({
                                            title: 'warning',
                                            text: 'El descuento no puede ser mayor al 100%',
                                            icon: 'error',
                                            confirmButtonText: 'Aceptar'
                                        });
                                        $(this).val(0);
                                        return;
                                    }

                                    if (descuento == 0) {
                                        totalInput.val(cantidad * precioSinIvaInput);
                                        calcularTotales();
                                        return;
                                    }

                                    if (proyecto) {
                                        // const porcentaje = parseFloat(descuento);
                                        // const precioSinIva = parseFloat(precioSinIvaInput);
                                        // const total = precioSinIva - (precioSinIva * (porcentaje / 100));
                                        let precio = precioSinIvaInput * cantidad;
                                        let descuentoAplicado = precio * (descuento / 100);
                                        let lineaDescuento = precio - descuentoAplicado;
                                        let total = lineaDescuento;

                                        totalInput.val(total.toFixed(2));
                                        calcularTotales();
                                        return;
                                    }
                                    
                                    if (descuento && cantidad && precioSinIvaInput) {
                                        let precio = precioSinIvaInput * cantidad;
                                        let descuentoAplicado = precio * (descuento / 100);
                                        let lineaDescuento = precio - descuentoAplicado;
                                        let total = lineaDescuento;

                                        totalInput.val(total.toFixed(2));
                                        calcularTotales();
                                    }
                                });
                            });
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al guardar la venta',
                            icon: 'error',
                            footer: error.message,
                            confirmButtonText: 'Aceptar'
                        });
                        closeLoader();
                    }
                });
            });
    
            // Función para calcular la suma de los totales de las líneas existentes
            const calcularSumaTotalesLineas = () => {
                let sumaTotales = 0;
                $('#elementsToShow tr').each(function() {
                    let total = parseFloat($(this).find('td:last-child').text());
                    if (!isNaN(total)) {
                        sumaTotales += total;
                    }
                });
                return sumaTotales;
            }
    
            // Delegar evento de guardado para las líneas dinámicas
            $('#collapseLineasVenta').on('click', '.saveLinea', function () {
                const lineNumber = $(this).data('line');
                const form = $(`#AddNewLineForm${lineNumber}`);
                const ordenTrabajoId = form.find(`#ordenTrabajo${lineNumber}`).val();
                const articuloId = form.find(`#articulo${lineNumber}`).val();
                const cantidad = parseFloat(form.find(`#cantidad${lineNumber}`).val());
                const precioSIva = parseFloat(form.find(`#precioSinIva${lineNumber}`).val());
                const descuento = parseFloat(form.find(`#descuento${lineNumber}`).val());
                const total = parseFloat(form.find(`#total${lineNumber}`).val());
    
                $('#sumaTotalesLineas').data('value', calcularSumaTotalesLineas());
    
                let cliente = {
                    idCliente: form.find('#clienteId').val(),
                    nombreCliente: form.find('#clienteNameId').val()
                };
    
                let archivos = {
                    idarchivos: form.find('#archivoId').val()
                };
    
                let venta = {
                    idVenta: form.find('#venta_id').val(),
                    totalFactura: parseFloat(form.find('#totalFactura').val()) // Asegurarse que se convierte a float
                };
    
                // Obtener la suma de las líneas existentes y agregar la nueva
                let sumaTotalesLineas = calcularSumaTotalesLineas() + total;
    
                // Validar si la suma total supera el total de la factura
                // if (sumaTotalesLineas > venta.totalFactura) {
                //     Swal.fire({
                //         title: 'Error',
                //         text: 'El total de las líneas no puede ser mayor al total de la factura',
                //         icon: 'error',
                //         confirmButtonText: 'Aceptar'
                //     });
                    
                //     return;
                // }
    
                // Validaciones de campos obligatorios
                if (cliente.idCliente === '' || cliente.idCliente === undefined || cliente.idCliente === null) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al guardar la línea, primero debe guardar la venta',
                        icon: 'error',
                        footer: 'No se han podido obtener los datos de la venta',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }
    
                const table = $('#tableToShowElements');
                const elements = $('#elementsToShow');
    
                // Mostrar tabla de elementos
                table.show();
    
                //obtener el tipo de orden
                let tipo = $(`#ordenTrabajo${lineNumber} option:selected`).data('tipo');
    
                $.ajax({
                    url: '{{ route("admin.lineasventas.store") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        orden_trabajo_id: ordenTrabajoId,
                        articulo_id: articuloId,
                        cantidad,
                        precioSinIva: precioSIva,
                        descuento,
                        total,
                        venta_id: venta.idVenta,
                        tipo,
                    },
                    success: function({ status, message, venta, articulos, ordenes, cliente, linea, code, ok, lineas }) {
    
                        if ( ok == false ) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ha ocurrido un error al guardar la línea',
                                icon: 'error',
                                footer: message,
                                confirmButtonText: 'Aceptar'
                            });
                            return;
                        }
    
                        if ( lineas ) {
                            
                            lineas.forEach(linea => {
                            
                                const newElement = `
                                    <tr>
                                        <td>${lineNumber}</td>
                                        <td>${linea.parte_trabajo.Asunto}</td>
                                        <td>${linea.Descripcion}</td>
                                        <td>${linea.Cantidad}</td>
                                        <td>${linea.descuento}</td>
                                        <td class="total-linea">${linea.total}€</td>
                                    </tr>
                                `;
                                elements.append(newElement);
                            });
    
                        }else{
                            //remover "Descripcion de la parte" de linea.Descripcion
                            let descripcion = linea.Descripcion;
                            let separarPorEspacios = descripcion.split(' ');
                            // eliminar desde la posicion 0 hasta la posicion 3
                            separarPorEspacios.splice(0, 3);
                            descripcion = separarPorEspacios.join(' ');
                            
                            let newElement = `
                            <tr>
                                <td>${lineNumber}</td>
                                <td>${descripcion}</td>
                                <td>${linea.Descripcion}</td>
                                <td>${linea.Cantidad}</td>
                                <td>${linea.descuento}</td>
                                <td class="total-linea">${linea.total}€</td>
                                </tr>
                            `;
                            elements.append(newElement);
                        }
    
    
                        calcularTotales(venta.idVenta);
    
                        Swal.fire({
                            title: 'Línea guardada',
                            text: message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
    
                        // Limpiar campos de la nueva línea y deshabilitarlos
                        form.find('textarea, input').val('').attr('disabled', true);
    
                        // Limpiar el contenedor de líneas nuevas
                        $('#newLinesContainer').empty();
    
                        $('#addNewLine').attr('disabled', false);
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al guardar la línea',
                            icon: 'error',
                            footer: error.message,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
    
                $('#saveVentaBtn').on('click', function() {
                if (ventaGuardadaGlobal) {
                    
                    
    
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Primero debe guardar la venta antes de guardar las líneas',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
                });
    
            });
    
            table.on('click','.detailsVentaBtn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: `/admin/ventas/edit/${id}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.status === 'success') {
                            let venta = response.venta;
                            $('#createVentaForm #FechaVenta').val(venta.FechaVenta).attr('disabled', true);
                            $('#createVentaForm #AgenteVenta').val(venta.AgenteVenta).attr('disabled', true);
                            $('#createVentaForm #EnviadoVenta').val(venta.EnviadoVenta).attr('disabled', true);
                            $('#createVentaForm #cliente_id').val(venta.cliente_id).attr('disabled', true);
                            $('#createVentaForm #empresa_id').val(venta.empresa_id).attr('disabled', true);
                            $('#createVentaForm #FormaPago').val(venta.FormaPago).attr('disabled', true);
                            $('#createVentaForm #IvaVenta').val(venta.IVAVenta).attr('disabled', true);
                            $('#createVentaForm #TotalIvaVenta').val(venta.TotalIvaVenta).attr('disabled', true);
                            $('#createVentaForm #RetencionesVenta').val(venta.RetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalRetencionesVenta').val(venta.TotalRetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalFacturaVenta').val(venta.TotalFacturaVenta).attr('disabled', true);
                            $('#createVentaForm #SuplidosVenta').val(venta.SuplidosVenta).attr('disabled', true);
                            $('#createVentaForm #Plazos').val(venta.Plazos).attr('disabled', true);
                            $('#createVentaForm #Cobrado').val(venta.Cobrado).attr('disabled', true);
                            $('#createVentaForm #PendienteVenta').val(venta.PendienteVenta).attr('disabled', true);
                            $('#createVentaForm #NAsientoContable').val(venta.NAsientoContable).attr('disabled', true);
                            $('#createVentaForm #Observaciones').val(venta.Observaciones).attr('disabled', true);
    
                            // Limpiar y cargar las líneas de venta
                            $('#elementsToShow').empty();
                            venta.venta_lineas.forEach(linea => {
    
                                //remover "Descripcion de la parte" de linea.Descripcion
                                let descripcion = linea.Descripcion;
                                let separarPorEspacios = descripcion.split(' ');
                                // eliminar desde la posicion 0 hasta la posicion 3
                                separarPorEspacios.splice(0, 3);
                                descripcion = separarPorEspacios.join(' ');
    
                                $('#elementsToShow').append(`
                                    <tr>
                                        <td>${linea.idLineaVenta}</td>
                                        <td>${descripcion}</td>
                                        <td>${linea.Descripcion}</td>
                                        <td>${linea.Cantidad}</td>
                                        <td>${linea.descuento}</td>
                                        <td class="total-linea">${linea.total}€</td>
                                    </tr>
                                `);
                            });
    
                            $('#createVentaModal').modal('show');
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
    
            // Edit venta
            table.on('click', '.editVentaBtn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                getEditVenta(id);
            });

            table.on('dblclick', '.openEditVentaFast', function (e) {
                e.preventDefault();
                let id = $(this).data('parteid');
                getEditVenta(id);
            });
            
            table.on('dblclick', '.OpenHistorialCliente', function(event){
                const elemento  = $(this);
                const span      = elemento.find('span')[1]
                const parteid   = span.getAttribute('data-parteid');

                getEditCliente(parteid, 'Ventas');
            });

            // detalle de la venta
            $("#ventas").on('click', '.detailsVentaBtn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: `/admin/ventas/edit/${id}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.status === 'success') {
                            let venta = response.venta;
                            $('#createVentaForm #FechaVenta').val(venta.FechaVenta).attr('disabled', true);
                            $('#createVentaForm #AgenteVenta').val(venta.AgenteVenta).attr('disabled', true);
                            $('#createVentaForm #EnviadoVenta').val(venta.EnviadoVenta).attr('disabled', true);
                            $('#createVentaForm #cliente_id').val(venta.cliente_id).attr('disabled', true);
                            $('#createVentaForm #empresa_id').val(venta.empresa_id).attr('disabled', true);
                            $('#createVentaForm #FormaPago').val(venta.FormaPago).attr('disabled', true);
                            $('#createVentaForm #IvaVenta').val(venta.IVAVenta).attr('disabled', true);
                            $('#createVentaForm #TotalIvaVenta').val(venta.TotalIvaVenta).attr('disabled', true);
                            $('#createVentaForm #RetencionesVenta').val(venta.RetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalRetencionesVenta').val(venta.TotalRetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalFacturaVenta').val(venta.TotalFacturaVenta).attr('disabled', true);
                            $('#createVentaForm #SuplidosVenta').val(venta.SuplidosVenta).attr('disabled', true);
                            $('#createVentaForm #Plazos').val(venta.Plazos).attr('disabled', true);
                            $('#createVentaForm #Cobrado').val(venta.Cobrado).attr('disabled', true);
                            $('#createVentaForm #PendienteVenta').val(venta.PendienteVenta).attr('disabled', true);
                            $('#createVentaForm #NAsientoContable').val(venta.NAsientoContable).attr('disabled', true);
                            $('#createVentaForm #Observaciones').val(venta.Observaciones).attr('disabled', true);
    
                            // Limpiar y cargar las líneas de venta
                            $('#elementsToShow').empty();

                            // cambiar el titulo del modal
                            $('#createVentaModal .modal-title').text('Detalles de la venta');
                            
                            venta.venta_lineas.forEach(linea => {
    
                                //remover "Descripcion de la parte" de linea.Descripcion
                                let descripcion = linea.Descripcion;
                                let separarPorEspacios = descripcion.split(' ');
                                // eliminar desde la posicion 0 hasta la posicion 3
                                separarPorEspacios.splice(0, 3);
                                descripcion = separarPorEspacios.join(' ');
    
                                $('#elementsToShow').append(`
                                    <tr>
                                        <td>${linea.idLineaVenta}</td>
                                        <td>${descripcion}</td>
                                        <td>${linea.Descripcion}</td>
                                        <td>${linea.Cantidad}</td>
                                        <td>${linea.descuento}</td>
                                        <td class="total-linea">${linea.total}€</td>
                                    </tr>
                                `);

                            });

                            $('#createVentaForm button').hide();

                            $('#createVentaModal').modal('show');
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }

                });
            });

            // abrir modal con los plazos de la venta
            table.on('dblclick', '.openModalPlazos', function(event) {
                const ventaId = $(this).data('parteid');
                $('#plazosModal #plazosContainer').empty();

                getPlazosVenta(ventaId);
            });

            // Abrir el segundo modal para registrar cobro
            $(document).on('click', '.btnRegistrarCobro', function() {
                const plazoId = $(this).data('plazo-id');
                const total = parseFloat($(this).data('total'));
                const cobrado = parseFloat($(this).data('cobrado'));

                $('#plazoId').val(plazoId);
                $('#totalPlazo').val(total);
                $('#cobradoActual').val(cobrado);

                // autocomepltar el input de total a cobrar
                $('#montoCobro').val(total - cobrado);

                // fecha de cobro
                $('#fechaCobro').val(new Date().toISOString().split('T')[0]);

                $('#montoCobro').attr('max', total - cobrado); // Asegurar que no se supere el total
                $('#cobroModal').modal('show');

                $('#cobroModal').on('show.bs.modal', function() {
                    $('#montoCobro').focus();
                    // inicializar el select2
                    $('#cobroModal select.form-select').select2({
                        width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                        dropdownParent: $('#cobroModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                    });
                });

                $('#cobroModal').on('hidden.bs.modal', function() {
                    $('#montoCobro').val('');
                });

            });

            // Guardar el cobro
            $('#btnGuardarCobro').on('click', function() {
                const plazoId       = $('#plazoId').val();
                const montoCobro    = parseFloat($('#montoCobro').val());
                const total         = parseFloat($('#totalPlazo').val());
                const cobradoActual = parseFloat($('#cobradoActual').val());
   
                if (montoCobro + cobradoActual > total) {
                    Swal.fire({
                        title: 'Error',
                        text: 'El monto cobrado no puede superar el total del plazo.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                // Realizar el POST a la API
                $.ajax({
                    url: `/api/plazos/${plazoId}/cobros`, // Ajusta esta URL
                    method: 'POST',
                    data: {
                        monto: montoCobro,
                        fecha: $('#fechaCobro').val(),
                        banco: $('#bancoCobro').val(),
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Exitoso',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });

                        $('#cobroModal').modal('hide');
                        $('#plazosModal').modal('hide'); // Opcional, para recargar plazos
                        
                    },
                    error: function(error) {
                        alert('Error al registrar el cobro.');
                    }
                });
            });

            // Evento para capturar el cierre del modal de #createVentaModal
            $('#createVentaModal').on('hidden.bs.modal', function () {
                $('#createVentaModal #elementsToShow').empty();
                $('#createVentaModal #createVentaForm textarea, input').val('').attr('disabled', false);

                

            });

            $('#saveEditVentaBtn').on('click', function(event){

                // tomar formulario y enviarlo por submit
                const id = $('#editVentaModal #idVenta').val();
                // cambiarle el attr de action para enviario al editar
                $('#createVentaForm').attr('action', `/admin/ventas/update/${id}`);

                // cambiar el metodo a POST
                $('#createVentaForm').attr('method', 'POST');

                // añaadir el token
                $('#createVentaForm').append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');

                $('#createVentaForm').submit();

            });

        });


    </script>
@stop
