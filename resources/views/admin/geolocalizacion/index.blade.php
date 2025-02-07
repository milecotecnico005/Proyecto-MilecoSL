@extends('adminlte::page')

@section('title', 'Geolocalización')

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

        .showOrdenBtn{
            cursor: pointer;
            text-decoration: underline;
        }

        .showOrdenBtn:hover {
            text-decoration: dotted underline;
        }

    </style>

    <div id="tableCard" class="card">
        <div class="card-body">

            <h3>Geolocalización de las órdenes de trabajo</h3>
            <table class="table table-striped localizaciones">
                <thead>
                    <tr>
                        <th>Asunto</th>
                        <th>N.Orden</th>
                        <th>F.Creación</th>
                        <th>F.Visita</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($geolocalizaciones as $geolocalizacion)
                        <tr>
                            <td
                                class="text-truncate"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                data-fulltext="{{ $geolocalizacion->Asunto }}"
                                title="{{ $geolocalizacion->Asunto }}"
                            >{{ Str::limit($geolocalizacion->Asunto, 5) }}</td>
                            <td
                                class="showOrdenBtn"
                                data-id="{{ $geolocalizacion->idOrdenTrabajo }}"
                                data-bs-placement="top"
                                data-bs-toggle="tooltip"
                                title="Ver detalles de la orden"
                            >#{{ $geolocalizacion->idOrdenTrabajo }}</td>
                            <td>{{ formatDate($geolocalizacion->FechaAlta) }}</td>
                            <td>{{ formatDate($geolocalizacion->FechaVisita) }}</td>
                            <td>
                                @component('components.actions-button')
                                    <button 
                                        type="button" 
                                        data-order="{{ $geolocalizacion->idOrdenTrabajo }}" 
                                        data-position="{{ json_encode($geolocalizacion->position) }}" 
                                        class="btn btn-primary showDetails" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalPosition"
                                    >
                                        Ver
                                    </button>
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <h2>Geolocalización Partes realizadas</h2>
            <table class="table table-striped localizaciones">
                <thead>
                    <tr>
                        <th>Asunto</th>
                        <th>N.Orden</th>
                        <th>N.Parte</th>
                        <th>F.Creación</th>
                        <th>F.Visita</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($partesGeo as $geolocalizacion)
                        <tr>
                            <td
                                class="text-truncate"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                data-fulltext="{{ $geolocalizacion->Asunto }}"
                                title="{{ $geolocalizacion->Asunto }}"
                            >{{ Str::limit($geolocalizacion->Asunto, 5) }}</td>
                            <td
                                class="showOrdenBtn"
                                data-id="{{ $geolocalizacion->orden_id }}"
                                data-bs-placement="top"
                                data-bs-toggle="tooltip"
                                title="Ver detalles de la orden"
                            >#{{ $geolocalizacion->orden_id }}</td>
                            <td>#{{ $geolocalizacion->idParteTrabajo }}</td>
                            <td>{{ formatDate($geolocalizacion->FechaAlta) }}</td>
                            <td>{{ formatDate($geolocalizacion->FechaVisita) }}</td>
                            <td>
                                @component('components.actions-button')
                                    <button type="button" 
                                        data-order="{{ $geolocalizacion->idParteTrabajo }}" 
                                        data-position="{{ json_encode($geolocalizacion->position_parte) }}" 
                                        class="btn btn-primary showDetails" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalPosition"
                                    >
                                        Ver
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
        'modalId' => 'modalPosition',
        'disabledSaveBtn' => true,
        'modalTitle' => 'Geolocalización',
        'modalTitleId' => 'modalTitlePosition',
        'modalSize' => 'modal-lg',    
    ])
        <!-- Ajustar el estilo del contenedor para garantizar que el mapa ocupe más espacio vertical -->
        <div id="modalBodyId" style="height: 70vh; width: 100%;"></div>
    @endcomponent

    {{-- Modal para detalles de la orden --}}
    @component('components.modal-component', [
        'modalId' => 'modalDetallesOrden',
        'modalTitle' => 'Detalles de la Orden',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'detallesOrdenTitle',
        'btnSaveId' => 'btnDetallesOrden',
        'disabledSaveBtn' => true
    ])
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="asunto">Asunto</label>
                <input type="text" class="form-control" id="asuntoDetails" name="asunto" placeholder="Asunto" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="fecha_alta">Fecha de Alta</label>
                <input type="date" class="form-control" id="fecha_altaDetails" name="fecha_alta" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group
                col-md-6">
                <label for="fecha_visita">Fecha de Visita</label>
                <input type="date" class="form-control" id="fecha_visitaDetails" name="fecha_visita" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="estado">Estado</label>
                <select id="estadoDetails" name="estado" class="form-control" disabled>
                    <option selected>Seleccionar...</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Finalizado">Finalizado</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group
                col-md-6">
                <label for="cliente_id">Cliente</label>
                <input id="cliente_idDetails" name="cliente_id" class="form-control" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="departamento">Departamento</label>
                <input type="text" class="form-control" id="departamentoDetails" name="departamento" placeholder="Departamento" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group
                col-md-6">
                <label for="trabajo_id">Trabajo</label>
                <select id="trabajo_idDetails" multiple name="trabajo_id[]" class="form-select" disabled>
                    @foreach ($trabajos as $trabajo )
                        <option value="{{ $trabajo->idTrabajo }}">{{ $trabajo->nameTrabajo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group
                col-md-6">
                <label for="operario_id">Operario/s</label>
                <select id="operario_idDetails" multiple name="operario_id[]" class="form-select" disabled>
                    @foreach ($operarios as $operario )
                        <option value="{{ $operario->idOperario }}">{{ $operario->nameOperario }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group
                col-md-12 d-flex flex-wrap justify-content-center" id="imagesDetails">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group
                col-md-12">
                <label for="observaciones">Observaciones</label>
                <textarea class="form-control" id="observacionesDetails" name="observaciones" rows="3" disabled></textarea>
            </div>
        </div>
    @endcomponent

@stop

@section('js')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>

        let table = $('.localizaciones').DataTable({
            colReorder: {
                realtime: false
            },
            dom:"<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
                "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
                "<'row'<'col-12'tr>>" +
                "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

            buttons: [
                
            ],
            pageLength: 10,  // Mostrar 50 registros por defecto
            lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opciones para seleccionar cantidad de registros
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
            }
        });

        function toggleExpandAsunto(element) {
            // Obtener el texto completo y truncado del atributo data-fulltext
            let fullText = element.getAttribute('data-fulltext');
            let truncatedText = fullText.length > 10 ? fullText.substring(0, 10) + '...' : fullText;

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

        table.on('dblclick', '.showOrdenBtn', function(e){
            openLoader();

            const ordenId = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.ordenes.showApi') }}",
                method: 'POST',
                data: {
                    ordenId,
                    _token: "{{ csrf_token() }}"
                },
                success: function({ status, orden, code }){
                    closeLoader();
                    if ( status ) {
                    
                        $('#modalDetallesOrden #asuntoDetails').val(orden.Asunto);
                        $('#modalDetallesOrden #fecha_altaDetails').val(orden.FechaAlta);
                        $('#modalDetallesOrden #fecha_visitaDetails').val(orden.FechaVisita);
                        $('#modalDetallesOrden #estadoDetails').val(orden.Estado);
                        $('#modalDetallesOrden #cliente_idDetails').val(orden.cliente.NombreCliente + ' ' + orden.cliente.ApellidoCliente);
                        $('#modalDetallesOrden #departamentoDetails').val(orden.Departamento);
                        $('#modalDetallesOrden #observacionesDetails').val(orden.Observaciones);

                        // inicializar select2
                        if ($('#modalDetallesOrden select.form-select').data('select2')) {
                            $('#modalDetallesOrden select.form-select').select2('destroy');
                        }

                        $('#modalDetallesOrden select.form-select').select2({
                            width: '100%',
                            dropdownParent: $('#modalDetallesOrden')
                        });

                        // Cargar trabajos en el select2 multiple
                        let trabajos = orden.trabajo.map(trabajo => {
                            return { id: trabajo.id, text: trabajo.nombre };  // Suponiendo que trabajo tiene 'id' y 'nombre'
                        });

                        // Asegúrate de que las opciones de trabajos estén en el select
                        trabajos.forEach(trabajo => {
                            if ($('#modalDetallesOrden #trabajo_idDetails option[value="' + trabajo.idTrabajo + '"]').length === 0) {
                                $('#modalDetallesOrden #trabajo_idDetails').append(new Option(trabajo.nameTrabajo, trabajo.idTrabajo));
                            }
                        });

                        // Selecciona los trabajos asignados en el select2 multiple
                        let trabajosIds = orden.trabajo.map(trabajo => trabajo.idTrabajo);
                        $('#modalDetallesOrden #trabajo_idDetails').val(trabajosIds).trigger('change');

                        // Cargar operarios en el select2 multiple
                        let operarios = orden.operarios.map(operario => {
                            return { id: operario.id, text: operario.nameOperario };  // Suponiendo que operario tiene 'id' y 'nameOperario'
                        });

                        // Asegúrate de que las opciones de operarios estén en el select
                        operarios.forEach(operario => {
                            if ($('#modalDetallesOrden #operario_idDetails option[value="' + operario.idOperario + '"]').length === 0) {
                                $('#modalDetallesOrden #operario_idDetails').append(new Option(operario.nameOperario, operario.idOperario));
                            }
                        });

                        // Selecciona los operarios asignados en el select2 multiple
                        let operariosIds = orden.operarios.map(operario => operario.idOperario);
                        $('#modalDetallesOrden #operario_idDetails').val(operariosIds).trigger('change');

                        $('#modalDetallesOrden #imagesDetails').empty();
                        orden.archivos.forEach((imagen, index) => {
                            // mostrar vista previa de las imagenes / videos o audios
                            let type = imagen.typeFile;
                            let url = imagen.pathFile;
                            let comentario = ''
                            if ( imagen.comentarios.length !== 0 ) {
                                if ( imagen.comentarios[index] ) {
                                    comentario = imagen.comentarios[index].comentarioArchivo
                                }
                            }

                            let serverUrl = 'https://sebcompanyes.com/';
                            let urlModificar = '/home/u657674604/domains/sebcompanyes.com/public_html/';

                            let urlFinal = url.replace(urlModificar, serverUrl);

                            let finalType = '';

                            switch (type) {
                                case 'jpg' || 'jpeg' || 'png' || 'gif':
                                    finalType = 'image';                                       
                                    break;
                                case 'mp4' || 'avi' || 'mov' || 'wmv' || 'flv' || '3gp' || 'webm':
                                    finalType = 'video';
                                    break;
                                case 'mp3' || 'wav' || 'ogg' || 'm4a' || 'flac' || 'wma':
                                    finalType = 'audio';
                                    break;
                                case 'pdf':
                                    finalType = 'pdf';
                                    break;
                                case 'doc' || 'docx':
                                    finalType = 'word';
                                    break;
                                case 'xls' || 'xlsx':
                                    finalType = 'excel';
                                    break;
                                case 'ppt' || 'pptx':
                                    finalType = 'powerpoint';
                                    break;
                                default:
                                    finalType = 'image';
                                    break;
                            }

                            switch (finalType) {
                                case 'image':
                                    $('#modalDetallesOrden #imagesDetails').append(`
                                        <img src="${urlFinal}" class="img-fluid">
                                        <br>
                                        <span>${comentario}</span>
                                    `);
                                    break;
                                case 'video':
                                    $('#modalDetallesOrden #imagesDetails').append(`
                                        <video src="${urlFinal}" class="img-fluid" controls></video>
                                        <br>
                                        <span>${comentario}</span>
                                    `);
                                    break;
                                case 'audio':
                                    $('#modalDetallesOrden #imagesDetails').append(`
                                        <audio src="${urlFinal}" class="img-fluid"></audio>
                                        <br>
                                        <span>${comentario}</span>
                                    `);
                                    break;
                                case 'pdf':
                                    $('#modalDetallesOrden #imagesDetails').append(`
                                        <embed src="${urlFinal}" type="application/pdf" width="100%" height="600px">
                                        <br>
                                        <span>${comentario}</span>
                                    `);
                                    break;
                                case 'word':
                                    $('#modalDetallesOrden #imagesDetails').append(`
                                        <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${urlFinal}" width='100%' height='600px' frameborder='0'>
                                        <br>
                                        <span>${comentario}</span>
                                    `);
                                    break;
                                case 'excel':
                                    $('#modalDetallesOrden #imagesDetails').append(`
                                        <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${urlFinal}" width='100%' height='600px' frameborder='0'>
                                        <br>
                                        <span>${comentario}</span>
                                    `);
                                    break;
                                case 'powerpoint':
                                    $('#modalDetallesOrden #imagesDetails').append(`
                                        <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${urlFinal}" width='100%' height='600px' frameborder='0'>
                                        <br>
                                        <span>${comentario}</span>
                                    `);
                                    break;
                                default:
                                    $('#modalDetallesOrden #imagesDetails').append(`
                                        <img src="${urlFinal}" class="img-fluid">
                                        <br>
                                        <span>${comentario}</span>
                                    `);
                                    break;
                            }

                        });

                        // abrir el modal del detalle de la orden
                        $('#modalDetallesOrden').modal('show');

                    }
                },
                error: function(err){
                    console.error(err);
                    closeLoader();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Algo salió mal',
                        footer: err.responseText.error
                    });
                }
            })

        })

        let map;

        table.on('click', '.showDetails', function() {
            const position = $(this).data('position');
            const prev = JSON.parse(position);
            let parsedPosition = JSON.parse(prev)[0];
            const order = $(this).data('order');

            // verificar si parsedPosition es un string en lugar de un objeto
            if (typeof parsedPosition === 'string') {
                parsedPosition = JSON.parse(parsedPosition);
            }

            const { latitude, longitude } = parsedPosition.coords;

            $('#modalPosition #modalBodyId').html('');
            $('#modalPosition #modalTitlePosition').html('Geolocalización de la orden #' + order);
            

            $('#modalPosition').on('shown.bs.modal', function () {
                if (map) {
                    map.remove();
                }

                $('#modalPosition #modalBodyId').css('height', '80vh');

                map = L.map('modalBodyId').setView([latitude, longitude], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                L.marker([latitude, longitude]).addTo(map)
                    .bindPopup('Ubicación aproximada del usuario')
                    .openPopup();

                setTimeout(function() {
                    map.invalidateSize();
                }, 100);
            });
        });

    </script>
@stop
