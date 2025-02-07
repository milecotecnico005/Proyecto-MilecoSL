@extends('adminlte::page')

@section('title', 'Modelo 347')

@section('content')

<div id="tableCard" class="card">
    <div class="card-body">
        <h1>Modelo 347</h1>

        <form action="{{ route('admin.modelo347.actualizarLimite') }}" method="POST" class="mb-1">
            @csrf
            
            <div class="row" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; text-align: center;">
                <label for="limite">Límite de facturación para el modelo 347</label>
                <div class="form-group col-md-6 d-flex justify-content-center">
                    <input type="number" name="limite" id="limite" class="form-control" value="{{ $limite }}" required>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>

        </form>

        <div id="modelo347Grid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>

        <a class="btn btn-success mt-3 openModalToExport">Exportar a Excel</a>
    </div>
</div>

@component('components.modal-component', [
    'modalId' => 'exportModal',
    'modalTitle' => 'exportModalTitle',
    'modalTitleId' => 'exportModalTitle',
    'modalSize' => 'modal-lg',
    'hideButton' => true,
])

    <form action="{{ route('admin.modelo347.exportarExcel') }}" method="POST">
        @csrf
        <select name="cliente_id" class="form-control mb-3 mt-2">
            <option value="">Todos los clientes</option>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->idClientes }}">{{ $cliente->NombreCliente }} {{ $cliente->ApellidoCliente }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-success mt-2">Exportar</button>
    </form>
    
@endcomponent

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ventas = @json($ventas);
        const buttonExport = $('.openModalToExport');

        buttonExport.on('click', function () {
            $('#exportModal').modal('show');
        });

        $('#exportModal').on('show.bs.modal', function () {
            // inicializar select2
            $('#exportModal select').select2({
                width: '100%',
                dropdownParent: $('#exportModal')
            });
        });

        // Seleccionar el contenedor de la grid
        const gridDiv = document.querySelector('#modelo347Grid');

        // Transformar los datos para adaptarlos a la tabla
        const rowData = {};
        let data = [];

        const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
            {
                name: 'ID',
                fieldName: 'ID',
                addAttributes: true,
                addcustomDatasets: true,
                attrclassName: 'editClienteFast',
                styles: {
                    cursor: 'pointer',
                    textDecoration: 'underline'
                },
                principal: true
            },
            {
                name: 'Cliente',
                fieldName: 'Cliente',
                className: 'cliente-column'
            },
            {
                name: 'Empresa',
                fieldName: 'Empresa',
                className: 'empresa-column'
            },
            {
                name: '1Trim',
                fieldName: 'unotrim',
                className: 'trimestre1-column'
            },
            {
                name: '2Trim',
                fieldName: 'dostrim',
                className: 'trimestre2-column'
            },
            {
                name: '3Trim',
                fieldName: 'trestrim',
                className: 'trimestre3-column'
            },
            {
                name: '4Trim',
                fieldName: 'cuatrotrim',
                className: 'trimestre4-column'
            },
            {
                name: 'Año',
                fieldName: 'year',
                className: 'trimestre4-column'
            },
            {
                name: 'Total',
                fieldName: 'Total',
                className: 'total-column'
            },
            {
                name: "Enlace",
                fieldName: 'enlace'
            },
            {
                name: 'Tipo Movimiento',
                fieldName: 'tipo_movimiento',
                className: 'total-column'
            },
            { 
                name: 'Correo',
                fieldName: 'correo',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: { 
                    'data-fulltext': ''
                },
                addcustomDatasets: true,
                customDatasets: {
                    'data-fieldName': "correo",
                    'data-type': "text"
                }
            },
            { 
                name: 'Agente',
                fieldName: 'agente',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: { 
                    'data-fulltext': ''
                },
                addcustomDatasets: true,
                customDatasets: {
                    'data-fieldName': "agente",
                    'data-type': "text"
                }
            },
            { 
                name: 'Notas',
                fieldName: 'notasmodelo347',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: { 
                    'data-fulltext': ''
                },
                addcustomDatasets: true,
                customDatasets: {
                    'data-fieldName': "notasmodelo347",
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
                // console.log(compra)
                // console.log(parte);
                // if (parte.proyecto_n_m_n && parte.proyecto_n_m_n.length > 0) {
                //     console.log({proyecto: parte.proyecto_n_m_n[0].proyecto.name});
                // }
                let generateEnlace = "{{ route('admin.ventas.InformeModelo347', ['id' => ':id', 'trim' => ':trim', 'year' => ':year', 'emp' => ':emp', 'enviar' => ':env', 'descargar' => ':desc', 'envdesc' => 'envdesc']) }}";

                // Reemplazar los placeholders con los valores correspondientes
                generateEnlace = generateEnlace.replace(':id', venta.cliente_id);
                generateEnlace = generateEnlace.replace(':trim', venta.trimestre);
                generateEnlace = generateEnlace.replace(':year', venta.year);
                generateEnlace = generateEnlace.replace(':emp', venta.empresa_id);
                generateEnlace = generateEnlace.replace(':env', 0);
                generateEnlace = generateEnlace.replace(':desc', 1);
                generateEnlace = generateEnlace.replace('envdesc', 0);

                
                rowData[venta.trimestre] = {
                    ID: venta.cliente_id,
                    Cliente: venta.cliente.NombreCliente + ' ' + venta.cliente.ApellidoCliente,
                    Empresa: venta.empresa.EMP,
                    unotrim: venta.trimestre === 1 ? formatPrice(venta.total) : '0',
                    dostrim: venta.trimestre === 2 ? formatPrice(venta.total) : '0',
                    trestrim: venta.trimestre === 3 ? formatPrice(venta.total) : '0',
                    cuatrotrim: venta.trimestre === 4 ? formatPrice(venta.total) : '0',
                    Total: formatPrice(venta.total),
                    notasmodelo347: venta.notasmodelo347,
                    enlace: generateEnlace,
                    correo: venta.correo,
                    agente: venta.agente,
                    tipo_movimiento: 'Factura',
                    year: venta.year,
                    Acciones: 
                    `
                        @component('components.actions-button')
                            <button
                                class="btn btn-sm btn-primary openDetailsEstadisticas"
                                data-toggle="tooltip"
                                title="Ver detalles"
                                data-placement="top"
                                data-clienteid="${venta.cliente.idClientes}"
                                data-trimestre="${venta.trimestre}"
                                data-tipo="venta"
                            >
                                <div class="d-flex justify-content-center flex-column">
                                    <ion-icon name="eye-outline"></ion-icon>
                                    <small>Detalles</small>
                                </div>
                            </button>
                            <button
                                class="btn btn-sm btn-success downloadOrSendDocumentModelo347"
                                data-toggle="tooltip"
                                title="Enviar documento"
                                data-placement="top"
                                data-clienteid="${venta.cliente.idClientes}"
                                data-trimestre="${venta.trimestre}"
                                data-year="${venta.year}"
                                data-empresa="${venta.empresa_id}"
                                data-enviar="1"
                                data-descargar="0"
                                data-envdesc="1"
                            >
                                <div class="d-flex justify-content-center flex-column">
                                    <ion-icon name="mail-outline"></ion-icon>
                                    <small>Enviar</small>
                                </div>
                            </button>
                            <button
                                class="btn btn-sm btn-success downloadOrSendDocumentModelo347"
                                data-toggle="tooltip"
                                title="Descargar documento"
                                data-placement="top"
                                data-clienteid="${venta.cliente.idClientes}"
                                data-trimestre="${venta.trimestre}"
                                data-year="${venta.year}"
                                data-empresa="${venta.empresa_id}"
                                data-enviar="0"
                                data-descargar="0"
                                data-envdesc="1"
                            >
                                <div class="d-flex justify-content-center flex-column">
                                    <ion-icon name="cloud-download-outline"></ion-icon>
                                    <small>Descargar y Enviar</small>
                                </div>
                            </button>

                        @endcomponent
                    
                    `
                }
            });

            data = Object.values(rowData);
        }

        prepareRowData(ventas);

        const resultCabeceras = armarCabecerasDinamicamente(cabeceras, true).then(result => {
            const customButtons = `
                <small></small>
            `;

            // Inicializar la tabla de citas
            inicializarAGtable( gridDiv, data, result, 'Modelo 347', customButtons, 'Modelo347');
        });


        let table = $('#modelo347Grid');

        table.on('click', '.openDetailsEstadisticas', function(event){
            event.preventDefault();
            const clienteId = $(this).data('clienteid');
            const trimestre = $(this).data('trimestre');

            // ajax para obtener los detalles 
            getHistorialCliente(clienteId, 'Cliente', true, trimestre);

        });

        table.on('dblclick', '.editClienteFast', function(event){
            const parteid   = $(this).data('parteid');
            getEditCliente(parteid, 'Cliente');
        });

        table.on('click', '.downloadOrSendDocumentModelo347', function(event){
            const clienteId = $(this).data('clienteid');
            const trimestre = $(this).data('trimestre');
            const year = $(this).data('year');
            const empresa = $(this).data('empresa');
            const enviar = $(this).data('enviar');
            const descargar = $(this).data('descargar');
            const envdesc = $(this).data('envdesc');

            sendEmailModelo347(clienteId, trimestre, year, empresa, enviar, envdesc);
        })

        function sendEmailModelo347(clienteId, trimestre, year, emp, enviar = 0, envdesc = 0) {
            const url = "{{ route('admin.ventas.InformeModelo347', ['id' => ':id', 'trim' => ':trim', 'year' => ':year', 'emp' => ':emp', 'enviar' => ':enviar', 'descargar' => 0, 'envdesc' => ':envdesc']) }}";
            const emailUrl = url
                .replace(':id', clienteId)
                .replace(':trim', trimestre)
                .replace(':year', year)
                .replace(':emp', emp)
                .replace(':enviar', enviar)
                .replace(':envdesc', envdesc);

            // Hacer una solicitud AJAX para enviar el correo
            if (envdesc != 0 && enviar == 0) {
                openLoader();
                window.open(emailUrl, '_blank');
                closeLoader();
            }

            $.ajax({
                url: emailUrl,
                method: 'GET',
                success: function (response) {
                    console.log(response);
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'El correo ha sido enviado correctamente.',
                        icon: 'success',
                    });
                },
                error: function (error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al enviar el correo. Por favor, inténtelo de nuevo.',
                        icon: 'error',
                    });
                },
            });
        }

    });
</script>
@endsection
