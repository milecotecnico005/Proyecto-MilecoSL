@extends('adminlte::page')

@section('title', 'Citas')

@section('content')

    {{-- <img src="https://sebcompanyes.com/img/circle.png" alt="CircleImageBackground" class="backgroundImage"> --}}

    <div id="tableCard" class="card">
        <div class="card-body">

            <!-- Botón para mostrar los seleccionados -->
            <button id="showSelectedBtn" class="btn btn-primary d-none">Mostrar los seleccionados</button>
            <button id="showAllBtn"      class="btn btn-primary d-none">Mostrar los seleccionados</button>

            <div id="citasGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>

            {{-- <table class="table-striped" id="citasTable">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="form-check" id="selectAll">
                        </th>
                        <th>Cita</th>
                        <th>Orden</th>
                        <th>F.Alta</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Asunto</th>
                        <th>Encargado</th>
                        <th>Canal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($citas as $cita)
                    @php
                        $nameCliente = $cita->cliente->NombreCliente . ' ' . $cita->cliente->ApellidoCliente;
                    @endphp
                        <tr
                            class="mantenerPulsadoParaSubrayar"
                        >
                            <td
                                class="text-center"
                                data-bs-placement="top"
                                data-bs-toggle="tooltip"
                                title="Seleccionar Cita"
                                style="max-width: 30px"
                            >
                                <input type="checkbox" class="selectCita form-check" data-id="{{ $cita->idCitas }}" 
                                       {{ in_array($cita->idCitas, json_decode(request()->cookie('selectedCitas', '[]'))) ? 'checked' : '' }}>
                            </td>
                            <td
                                class="text-center openEditCita openCitaModal"
                                data-bs-placement="top"
                                data-bs-toggle="tooltip"
                                title="ID de la Cita"
                                data-id="{{ $cita->idCitas }}"
                                data-info="{{ json_encode($cita) }}"
                                data-userCita="{{ json_encode($cita->user) }}"
                                data-archivos="{{ json_encode($cita->archivos) }}"
                                data-orden="{{ $cita->ordenes && count($cita->ordenes) > 0 ? $cita->ordenes[0]->idOrdenTrabajo : null }}"
                            >{{ $cita->idCitas }}</td>
                            <td
                                @if ( $cita->ordenes && count($cita->ordenes) > 0 )
                                    @php
                                        $orden = $cita->ordenes[0];

                                        $trabajosArray = '';
                                        $operariosArray = '';
                                        $archivosArray = [];
                                        $archivosComentarios = '';
                                        $trabajosArrayWithId = [];
                                        $salariosArray = [];

                                        foreach ($orden->trabajo as $trabajo) {
                                            $trabajosArray .= $trabajo->nameTrabajo . ', ';
                                        }

                                        foreach ($orden->operarios as $operario) {
                                            $operariosArray .= $operario->nameOperario . ', ';
                                        }

                                        foreach ($orden->archivos as $archivo) {
                                            $archivosArray[] = $archivo;
                                        }

                                        foreach ($orden->archivos as $value => $archivo) {
                                            $archivosComentarios .= $archivo->comentarios[0]->comentarioArchivo . ', ';
                                        }

                                        foreach ($orden->operarios as $salario ) {
                                            if ( $salario->salario ) {
                                                $salariosArray[] = $salario->salario;
                                            }
                                        }

                                        foreach ($orden->trabajo as $tra) {
                                            $trabajosArrayWithId[] = [
                                                'id' => $tra->idTrabajo,
                                                'name' => $tra->nameTrabajo
                                            ];
                                        }

                                    @endphp
                                    class="orden-truncate text-center btnOpenEditModalFast"
                                    data-id="{{ $orden->idOrdenTrabajo }}"
                                    data-asunto="{{ $orden->Asunto }}"
                                    data-fecha-alta="{{ $orden->FechaAlta }}"
                                    data-fecha-visita="{{ $orden->FechaVisita }}"
                                    data-estado="{{ $orden->Estado }}"
                                    data-cliente="{{ $orden->cliente->idClientes }}"
                                    data-departamento="{{ $orden->Departamento }}"
                                    data-trabajos="{{ $trabajosArray }}"
                                    data-operarios="{{ $operariosArray }}"
                                    data-observaciones="{{ $orden->Observaciones }}"
                                    data-archivos="{{ json_encode($orden->archivos) }}"
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="Editar"
                                @endif
                            >
                                {{ $cita->ordenes && count($cita->ordenes) > 0 ? Str::limit($orden->idOrdenTrabajo, 5) : 'Sin orden' }}
                            </td>
                            <td
                                class="text-center openqQuickEdit"
                                data-bs-placement="top"
                                data-bs-toggle="tooltip"
                                title="{{ $cita->fechaDeAlta }}"
                                data-fieldName="fechaDeAlta"
                                data-type="date"
                                data-parteid="{{ $cita->idCitas }}"
                            >{{ $cita->fechaDeAlta }}</td>
                            <td
                                class="text-truncate"
                                data-bs-placement="top"
                                data-bs-toggle="tooltip"
                                title="{{$nameCliente}}"
                                data-fulltext="{{$nameCliente}}"
                            >
                                {{ Str::limit($nameCliente, 10) }}
                            </td>
                            <td>
                                @if ($cita->estado == 'Pendiente')
                                    <span class="badge badge-warning">Pendiente</span>
                                @elseif ($cita->estado == 'En proceso' || $cita->estado == 'En Proceso')
                                    <span class="badge badge-primary">En proceso</span>
                                @else
                                    <span class="badge badge-success">Finalizado</span>
                                @endif
                            </td>
                            <td
                                class="text-truncate openqQuickEdit" 
                                data-fulltext="{{ $cita->asunto }}"
                                data-bs-placement="top"
                                data-bs-toggle="tooltip"
                                title="{{ $cita->asunto }}"
                                data-parteid="{{ $cita->idCitas }}"
                                data-fieldName="asunto"
                                data-type="text"
                            >
                                {{ Str::limit($cita->asunto, 10) }}
                            </td>
                            <td>{{ str_replace(' ', '', $cita->name) }}</td>
                            <td class="text-center">
                                {!! $cita->tipoCita == 'Telegram' ? '<ion-icon name="navigate-circle-outline" style="font-size: 24px; color: aqua;">Telegram</ion-icon>' : 
                                    ($cita->tipoCita == 'Whatsapp' ? '<ion-icon name="logo-whatsapp" style="font-size: 24px; color: #65f865;">Whatsapp</ion-icon>' : 
                                    ($cita->tipoCita == 'Email' ? '<ion-icon name="mail-outline" style="font-size: 24px;">correo</ion-icon>' : 
                                    ($cita->tipoCita == 'Telefono' ? '<ion-icon name="call-outline" style="font-size: 24px;">telefono</ion-icon>' : ''))) !!}
                            </td>                          
                            <td>
                                @component('components.actions-button')
                                    <!-- Botón Detalles -->
                                    <button type="button" class="btn btn-info detailsCitaBtn"
                                        data-info="{{ json_encode($cita) }}"
                                        data-userCita="{{ json_encode($cita->user) }}"
                                        data-archivos="{{ json_encode($cita->archivos) }}"
                                        data-cliente="{{ json_encode($cita->cliente) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Ver detalles"
                                    >
                                        <ion-icon name="information-circle-outline"></ion-icon>
                                    </button>

                                    <!-- Botón Editar -->
                                    <button type="button" class="btn btn-primary editCitabtn"
                                        data-info="{{ json_encode($cita) }}"
                                        data-userCita="{{ json_encode($cita->user) }}"
                                        data-archivos="{{ json_encode($cita->archivos) }}"
                                        data-orden="{{ $cita->ordenes && count($cita->ordenes) > 0 ? $cita->ordenes[0]->idOrdenTrabajo : null }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Editar cita"
                                    >
                                        <ion-icon name="create-outline"></ion-icon>
                                    </button>

                                    @if ($cita->enlaceDoc)
                                        <!-- Botón Ver Documento -->
                                        <a href="{{ $cita->enlaceDoc }}" target="_blank" class="btn btn-secondary"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Ver documento"
                                        >
                                            <ion-icon name="document-text-outline"></ion-icon>
                                        </a>
                                    @endif

                                    <!-- Botón Generar Orden (si no hay órdenes) -->
                                    @if ( count($cita->ordenes) <= 0 )
                                        <button type="button" class="btn btn-success generateOrden"
                                            data-info="{{ json_encode($cita->ordenes) }}"
                                            data-userCita="{{ json_encode($cita->user) }}"
                                            data-archivos="{{ json_encode($cita->archivos) }}"
                                            data-cita="{{ json_encode($cita) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Generar Orden"
                                        >
                                            <ion-icon name="document-outline"></ion-icon>
                                        </button>
                                    @endif
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    </div>
    

    @component('components.modal-component', [
        'modalTitle'    => 'Crear Cita',
        'modalId'       => 'createCitaModal',
        'btnSaveId'     => 'saveCitaBtn',
        'modalSize'     => 'modal-lg'
    ])
        <form class="form" method="POST" action="{{ route('admin.citas.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row mb-3">
                    <div class="col-md-6 required-field">
                        <label class="form-label" for="fechaCita">Fecha de la Cita</label>
                        <input type="date" class="form-control" id="fechaCita" name="fechaCita">
                    </div>
                    <div class="col-md-6 required-field">
                        <label class="form-label" for="asunto">Asunto </label>
                        <textarea cols="3" type="text" class="form-control" id="asunto" name="asunto"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 required-field">
                        <label class="form-label" for="tipoCita">Canal </label>
                        <select class="form-control" id="tipoCita" name="tipoCita">
                            <option value="Whatsapp">Whatsapp</option>
                            <option value="Telegram">Telegram</option>
                            <option value="Email">Email</option>
                            <option value="Telefono">Telefono</option>
                        </select>
                    </div>
                    <div class="col-md-6 required-field">
                        <label class="form-label" for="usuarioQueCreaLaCita">Usuario que crea la Cita</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        <input type="hidden" class="form-control" id="usuarioQueCreaLaCita" name="user_id" value="{{ Auth::user()->id }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 required-field">
                        <label class="form-label" for="estado">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end justify-content-end">
                        <div class="form-group">
                            <label class="form-label" for="inputparasubirarchivos">Subir Archivos</label>
                            <input type="file" class="form-control" id="inputparasubirarchivos" name="inputparasubirarchivos[]" multiple>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="enlaceDoc">Enlace a documento</label>
                        <input type="text" name="enlaceDoc" title="Enlace a documento de google Docs" class="form-control" id="enlaceDoc">
                    </div>
                    <div class="form-group col-md-6 required-field">
                        <label class="form-label" for="cliente_id">Cliente </label>
                        <select id="cliente_id" name="cliente_id" class="form-select">
                            <option selected>Seleccionar...</option>
                            @foreach ($clientes as $cliente )
                                
                                <option value="{{ $cliente->idClientes }}">{{ $cliente->NombreCliente }} {{ $cliente->ApellidoCliente }}</option>
                        
                            @endforeach
                        </select>

                        <hr style="margin-top: 10px; margin-bottom: 10px">

                        <small class="text-muted">
                            <a id="addNewClienteModalBtn">Si no ves al cliente, Crea uno nuevo aquí</a>
                        </small>

                    </div>
                </div>
                {{-- Container para mostrar la vista previa de los archivos subidos --}}
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div id="filesPreviewContainer" class="d-flex flex-wrap"></div>
                    </div>
                </div>
            </div>
        </form>

    @endcomponent

    @component('components.modal-component',[
        'modalTitle'      => 'Detalles de la Cita',
        'modalId'         => 'detailsCitaModal',
        'btnSaveId'       => 'saveDetailsCitaBtn',
        'modalSize'       => 'modal-lg',
        'disabledSaveBtn' => true,
        'hideButton'      => true
    ])

        <div class="container">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fechaCita">Fecha de la Cita</label>
                    <input type="date" class="form-control" id="fechaCita" name="fechaCita" readonly>
                </div>
                <div class="col-md-6">
                    <label for="asunto">Asunto</label>
                    <textarea type="text" class="form-control" id="asunto" name="asunto" readonly></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tipoCita">Tipo de Cita</label>
                    <input type="text" class="form-control" id="tipoCita" name="tipoCita" readonly>
                </div>
                <div class="col-md-6">
                    <label for="usuarioQueCreaLaCita">Usuario que crea la Cita</label>
                    <input type="text" class="form-control" id="usuarioQueCreaLaCita" name="usuarioQueCreaLaCita" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cliente">Cliente</label>
                    <input type="text" class="form-control" id="cliente" name="cliente" readonly>
                </div>
                <div class="col-md-6">
                    <label for="estado">Estado</label>
                    <input type="text" class="form-control" id="estado" name="estado" readonly>
                </div>
            </div>
            <div class="row mb-2">
                <div style="overflow-y: scroll" class="col-md-12">
                    <label for="archivos">Archivos</label>
                    <div class="d-flex flex-wrap" id="archivosDetalles">
                    </div>
                </div>
            </div>
        </div>
        
    @endcomponent

    @component('components.modal-component', [
        'modalTitle'    => 'Editar Cita',
        'modalId'       => 'editCitaModal',
        'btnSaveId'     => 'saveEditCitaBtn',
        'modalSize'     => 'modal-lg'
    ])
        <form class="form" method="POST" id="formUpdate" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container">
                <div class="row mb-3">
                    <div class="col-md-6 required-field">
                        <label class="form-label" for="fechaCitaEdit">Fecha de la Cita</label>
                        <input type="date" class="form-control" id="fechaCitaEdit" name="fechaCita">
                    </div>
                    <div class="col-md-6 required-field">
                        <label class="form-label" for="asuntoEdit">Asunto</label>
                        <textarea type="text" class="form-control" id="asuntoEdit" name="asunto"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 required-field">
                        <label class="form-label" for="tipoCitaEdit">Tipo de Cita</label>
                        <select class="form-control" id="tipoCitaEdit" name="tipoCita">
                            <option value="Whatsapp">Whatsapp</option>
                            <option value="Telegram">Telegram</option>
                            <option value="Email">Email</option>
                            <option value="Telefono">Telefono</option>
                        </select>
                    </div>
                    <div class="col-md-6 required-field">
                        <label class="form-label" for="usuarioQueCreaLaCitaEdit">Usuario que crea la Cita</label>
                        <input type="text" class="form-control" id="nameToShow" readonly>
                        <input type="hidden" class="form-control" id="usuarioQueCreaLaCitaEdit" name="user_id" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 required-field">
                        <label class="form-label" for="estadoEdit">Estado</label>
                        <select class="form-select" id="estadoEdit" name="estado">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end justify-content-end">
                        <div class="form-group">
                            <label class="form-label" for="inputparasubirarchivosEdit">Subir Archivos</label>
                            <input type="file" class="form-control" id="inputparasubirarchivosEdit" name="inputparasubirarchivos[]" multiple>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="enlaceDoc">Enlace a documento</label>
                        <textarea type="text" name="enlaceDoc" title="Enlace a documento de google Docs" class="form-control" id="enlaceDoc"></textarea>
                    </div>
                    <div class="form-group col-md-6 required-field">
                        <label class="form-label" for="cliente_id">Cliente</label>
                        <select id="cliente_id" name="cliente_id" class="form-select">
                            <option selected>Seleccionar...</option>
                            @foreach ($clientes as $cliente )
                                
                                <option value="{{ $cliente->idClientes }}">{{ $cliente->NombreCliente }} {{ $cliente->ApellidoCliente }}</option>
                        
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Container para mostrar la vista previa de los archivos subidos --}}
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div id="filesPreviewContainer" class="d-flex flex-wrap flex-row g-5 justify-between">
                            
                        </div>
                    </div>
                </div>
            </div>
        </form>

    @endcomponent

    <!-- Modal para Crear Orden -->
    @component('components.modal-component', [
        'modalId' => 'modalCreateOrden',
        'modalTitle' => 'Crear Orden',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'createOrdenTitle',
        'btnSaveId' => 'btnCreateOrden'
    ])
        <form id="formCreateOrden" action="{{ route('admin.ordenes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-12 required-field">
                    <label class="form-label" for="tipo">Citas pendientes</label>
                    <select name="cita" id="citasPendigSelect" class="form-select">
                        <option selected>Seleccionar...</option>
                        @foreach ($citas as $cita)
                            <option 
                                data-asunto="{{ $cita->asunto }}"
                                data-fecha="{{ $cita->fechaDeAlta }}"
                                data-estado="{{ $cita->estado }}"
                                data-cliente="{{ $cita->cliente_id }}"
                                value="{{ $cita->idCitas }}">
                                {{ $cita->asunto }} | Fecha de alta: {{ $cita->fechaDeAlta }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 required-field">
                    <label class="form-label" for="asunto">Asunto</label>
                    <textarea rows="3" type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto"></textarea>
                </div>
                <div class="form-group col-md-6 required-field">
                    <label class="form-label" for="fecha_alta">Fecha de Alta</label>
                    <input type="date" class="form-control" id="fecha_alta" name="fecha_alta">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-6">
                    <label for="fecha_visita">Fecha de Visita</label>
                    <input type="date" class="form-control" id="fecha_visita" name="fecha_visita">
                </div>
                <div class="form-group col-md-6 required-field">
                    <label class="form-label" for="estado">Estado</label>
                    <select id="estado" name="estado" class="form-control">
                        <option value="" selected>Seleccionar...</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="En proceso">En proceso</option>
                        <option value="Finalizado">Finalizado</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-6">
                    <label for="hora_inicio">Hora de inicio</label>
                    <input type="time" class="form-control" id="hora_inicio" name="hora_inicio">
                </div>
                <div class="form-group col-md-6">
                    <label for="hora_fin">Hora de fin</label>
                    <input type="time" class="form-control" id="hora_fin" name="hora_fin">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-6 required-field">
                    <label class="form-label" for="cliente_id">Cliente</label>
                    <select id="cliente_id" name="cliente_id" class="form-select">
                        <option selected>Seleccionar...</option>
                        @foreach ($clientes as $cliente )
                            
                            <option value="{{ $cliente->idClientes }}">{{ $cliente->NombreCliente }} {{ $cliente->ApellidoCliente }}</option>
                    
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="departamento">Departamento</label>
                    <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Departamento">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-6 required-field">
                    <label class="form-label" for="trabajo_id">Trabajo</label>
                    <select id="trabajo_id" multiple name="trabajo_id[]" class="form-select" required>
                        @foreach ($trabajos as $trabajo )
                            <option value="{{ $trabajo->idTrabajo }}">{{ $trabajo->nameTrabajo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group
                    col-md-6">
                    <label class="form-label" for="operario_id">Operario/s</label>
                    <select id="operario_id" multiple name="operario_id[]" class="form-select">
                        @foreach ($operarios as $operario )
                            <option value="{{ $operario->idOperario }}">{{ $operario->nameOperario }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="image-fluid d-flex flex-wrap" id="previewImage1"></div>
                    <label class="form-label" for="files">Archivos</label>
                    <input type="file" class="form-control" id="files1" name="file[]">
                </div>
            </div>
            <div class="form-row" id="inputsToUploadFilesContainer"></div>
            <button type="button" class="btn btn-primary" id="btnAddFiles">Añadir más archivos</button>
            <div class="form-row">
                <div class="form-group
                    col-md-12">
                    <label for="observaciones">Observaciones</label>
                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                </div>
            </div>
        </form>
    @endcomponent

    {{-- Modal para crear un nuevo cliente --}}
    @component('components.modal-component', [
        'btnSaveId'  => 'btn-save-cliente',
        'modalId'    => 'modal-cliente',
        'modalTitle' => 'Nuevo Cliente',
        'modalSize'  => 'modal-lg',
    ])
        <form id="form-cliente" action="{{ route('admin.clientes.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="cif">CIF</label>
                                <input type="text" name="cif" id="cif" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 required-field">
                            <div class="form-group">
                                <label class="form-label" for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="apellido">Apellido</label>
                                <input type="text" name="apellido" id="apellido" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="telefono">Telefono</label>
                                <input type="number" name="telefono[]" id="telefono" class="form-control" required>
                            </div>
                            {{-- Boton para crear otro input para agregar otro telefono --}}
                            <div class="form-group mb-2" id="telefonosContainer"></div>
                            <button type="button" class="btn btn-outline-primary" id="btnAddTelefono">Agregar otro telefono</button>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="direccion">Direccion</label>
                                <div class="d-flex justify-content-between">
                                    <input type="text" class="form-control direccion" name="direccion" placeholder="Escribe una calle">
                                    <button type="button" class="btn btn-outline-primary direccion-btnSearch" id="btnSearch">Buscar</button>
                                </div>
                                <div id="suggestions"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="codPostal">Código Postal</label>
                                <input type="text" name="codPostal" id="codPostal" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="cidade_id">Ciudad</label>
                                <select name="cidades_id" id="cidade_id" class="form-select" required>
                                    <option value="">seleccione una ciudad</option>
                                    @foreach($ciudades as $ciudad)
                                        <option value="{{ $ciudad->idCiudades }}">{{ $ciudad->nameCiudad }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="agente">Agente</label>
                                <input type="text" name="agente" id="agente" value="{{ Auth::user()->name }}" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="tipoClienteId">Tipo de Cliente</label>
                                <select name="tipoClienteId" id="tipoClienteId" class="form-select" required>
                                    <option value="">Tipo de cliente</option>
                                    @foreach($tiposClientes as $tipo)
                                        <option value="{{ $tipo->idTiposClientes }}">{{ $tipo->nameTipoCliente }} | descuento: {{ $tipo->descuento }}%</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="banco_id">Banco</label>
                                <select name="banco_id" id="banco_id" class="form-select" required>
                                    <option value="">Seleccione un banco</option>
                                    @foreach($bancos as $banco)
                                        <option value="{{ $banco->idbanco }}">{{ $banco->nameBanco }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="sctaContable">Cuenta Contable</label>
                                <input type="text" name="sctaContable" id="sctaContable" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="observaciones">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="user_id">Usuario</label>
                                <select name="user_id" id="user_id" class="user_id p-3 form-select">
                                    <option selected value="">Ninguno</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} | {{ $user->email }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Se selecciona un usuario si el cliente está registrado en el aplicativo</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>        
        
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'modalEditOrden',
        'modalTitle' => 'Editar Orden',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editOrdenTitle',
        'btnSaveId' => 'btnEditOrden'
    ])
        <form id="formEditOrden" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group col-md-6 required-field">
                    <label class="form-label" for="asunto">Asunto</label>
                    <textarea rows="3" type="text" class="form-control" id="asuntoEdit" name="asunto" placeholder="Asunto"></textarea>
                </div>
                <div class="form-group
                    col-md-6 required-field">
                    <label class="form-label" for="fecha_alta">Fecha de Alta</label>
                    <input type="date" class="form-control" id="fecha_altaEdit" name="fecha_alta">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-6">
                    <label class="form-label" for="fecha_visita">Fecha de Visita</label>
                    <input type="date" class="form-control" id="fecha_visitaEdit" name="fecha_visita">
                </div>
                <div class="form-group
                    col-md-6 required-field">
                    <label class="form-label" for="estado">Estado</label>
                    <select id="estadoEdit" name="estado" class="form-control">
                        <option selected>Seleccionar...</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="En proceso">En proceso</option>
                        <option value="Finalizado">Finalizado</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-6 required-field">
                    <label class="form-label" for="cliente_id">Cliente</label>
                    <select id="cliente_idEdit" name="cliente_id" class="form-select">
                        <option selected>Seleccionar...</option>
                        @foreach ($clientes as $cliente )
                            
                            <option value="{{ $cliente->idClientes }}">{{ $cliente->NombreCliente }} {{ $cliente->ApellidoCliente }}</option>
                    
                        @endforeach
                    </select>
                </div>
                <div class="form-group
                    col-md-6">
                    <label class="form-label" for="departamento">Departamento</label>
                    <input type="text" class="form-control" id="departamentoEdit" name="departamento" placeholder="Departamento">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-6 required-field">
                    <label class="form-label" for="trabajo_id">Trabajo</label>
                    <select id="trabajo_idEdit" multiple name="trabajo_id[]" class="form-select">
                        @foreach ($trabajos as $trabajo )
                            <option value="{{ $trabajo->idTrabajo }}">{{ $trabajo->nameTrabajo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group
                    col-md-6">
                    <label class="form-label" for="operario_id">Operario/s</label>
                    <select id="operario_idEdit" multiple name="operario_id[]" class="form-select">
                        @foreach ($operarios as $operario )
                            <option value="{{ $operario->idOperario }}">{{ $operario->nameOperario }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="image-fluid d-flex flex-wrap" id="previewImage1"></div>
                    <label class="form-label" for="files">Archivos</label>
                    <input type="file" class="form-control" id="files1" name="file[]">
                </div>
            </div>
            <div class="form-row" id="inputsToUploadFilesContainer"></div>
            <button type="button" class="btn btn-primary" id="btnAddFiles">Añadir más archivos</button>
            <div class="form-row">
                <div class="form-group
                    col-md-12">
                    <label class="form-label" for="observaciones">Observaciones</label>
                    <textarea class="form-control" id="observacionesEdit" name="observaciones" rows="3"></textarea>
                </div>
            </div>
        </form>
    @endcomponent
        

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

    @if (session('Cita creada correctamente'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Cita creada correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    @if (session('Error al crear la cita'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Error al crear la cita',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
        
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    <script src="{{ asset('js/table.js') }}"></script>

    <script>
    
        $(document).ready(function() {

            // obtener los datos de todas las citas para mostrarlas en la tabla
            const citas = @json($citas);
            const clientes = @json($clientes);
            const users = @json($users);
            const trabajos = @json($trabajos);
            const operarios = @json($operarios);
            const ciudades = @json($ciudades);
            const tiposClientes = @json($tiposClientes);
            const bancos = @json($bancos);

            // Inicializar la tabla de citas
            const agTablediv = document.querySelector('#citasGrid');

            let rowData = {};
            let data = [];

            const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
                { 
                    name: 'ID',
                    fieldName: 'idCitas',
                    addAttributes: true, 
                    addcustomDatasets: true,
                    dataAttributes: { 
                        'data-id': ''
                    },
                    attrclassName: 'openCitaModal',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                    principal: true
                }, 
                { 
                    name: 'Orden',
                    addAttributes: true,
                    dataAttributes: { 
                        'data-order': 'order-column' 
                    },
                    attrclassName: 'btnOpenEditModalFast',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                },
                { 
                    name: 'FechaAlta', 
                    className: 'fecha-alta-column',
                    fieldName: 'fechaDeAlta',
                    fieldType: 'date',
                    editable: true,

                },
                { 
                    name: 'Cliente',
                    fieldName: 'cliente_id',
                    fieldType: 'select',
                    addAttributes: true,
                },
                { name: 'Estado' },
                { 
                    name: 'Asunto',
                    fieldName: 'asunto',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "asunto",
                        'data-type': "text"
                    }
                },
                { name: 'Encargado' },
                { name: 'Canal' },
                { 
                    name: 'Acciones',
                    className: 'acciones-column'
                }
            ];

            function prepareRowData(citas) {
                citas.forEach(cita => {
                    rowData[cita.idCitas] = {
                        ID: cita.idCitas,
                        Orden: cita.Orden ?? null,
                        FechaAlta: cita.fechaDeAlta,
                        Cliente: cita.Cliente,
                        Estado: cita.estado,
                        Asunto: cita.Asunto,
                        Encargado: cita.usuario.name,
                        Canal: cita.tipoCita,
                        Acciones: 
                        `
                            @component('components.actions-button')
                                <button type="button" class="btn btn-info detailsCitaBtn"
                                    data-idcitas="${cita.idCitas}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Ver detalles"
                                >
                                    <ion-icon name="information-circle-outline"></ion-icon>
                                </button>

                                <!-- Botón Editar -->
                                <button type="button" class="btn btn-primary editCitabtn"
                                    data-idcitas="${cita.idCitas}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Editar cita"
                                >
                                    <ion-icon name="create-outline"></ion-icon>
                                </button>

                                ${ cita.enlaceDoc ? `
                                    <!-- Botón Ver Documento -->
                                    <a href="${cita.enlaceDoc}" target="_blank" class="btn btn-secondary"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Ver documento"
                                    >
                                        <ion-icon name="document-text-outline"></ion-icon>
                                    </a>
                                
                                ` : '' }
                                
                                ${ cita.ordenes && cita.ordenes.length == 0 ? `
                                    <button type="button" class="btn btn-success generateOrden"
                                        data-info='${JSON.stringify(cita)}'
                                        data-userCita='${JSON.stringify(cita.user)}'
                                        data-archivos='${JSON.stringify(cita.archivos)}'
                                        data-cita='${JSON.stringify(cita)}'
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Generar Orden"
                                    >
                                        <ion-icon name="document-outline"></ion-icon>
                                    </button>
                                ` : '' }
                            @endcomponent
                        
                        `
                    }
                });

                data = Object.values(rowData);
            }

            prepareRowData(citas);

            const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then((result) => {
                const customButtons = `
                    <button type="button" class="btn btn-warning createUserbtn"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Crear Cita"
                    >
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="mr-1">Crear Cita</span>
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                    </button>
                `;

                // Inicializar la tabla de citas
                inicializarAGtable( agTablediv, data, result, 'CITAS', customButtons, 'Cita');
            })

           

            table.on('click','.createUserbtn', function() {
                $('#createCitaModal').modal('show');
            });

        });
        
        // let table = $('#citasTable').DataTable({
        //     order: [[1, 'desc']],
        //     // responsive: true,
        //     colReorder: {
        //         realtime: true
        //     },
        //     // Ajuste para mostrar los botones a la izquierda, el filtro a la derecha, y el selector de cantidad de registros
        //     dom: 
        //     "<'row'<'col-12 mb-2'<'table-title'>>>" +
        //     "<'row'<'col-12 col-md-8 col-sm-8 left-buttons'B><'col-12 col-md-4 col-sm-4 d-flex justify-content-end right-filter'f>>" +
        //     "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
        //     "<'row'<'col-12'tr>>" +
        //     "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

        //     buttons: [
        //         {
        //             text: 'Crear Cita',
        //             className: 'btn btn-outline-warning createUserbtn',
        //             action: function () {
        //                 $('#createCitaModal').modal('show');
        //             }
        //         },
        //         {
        //             className: 'btn btn-outline-info showSelectedBtn',
        //             text: 'Ver seleccionados',
        //             action: function (){
        //                 $('#showSelectedBtn').click();
        //             }
        //         },
        //         {
        //             text: 'Mostrar todos',
        //             className: 'btn btn-outline-primary showAllBtnShow',
        //             action: function (){
        //                 $('#showAllBtn').click();
        //             }
        //         },
        //         {
        //             text: 'Limpiar Filtros', 
        //             className: 'btn btn-outline-danger limpiarFiltrosBtn', 
        //             action: function (e, dt, node, config) { 
        //                 clearFiltrosFunction(dt, '#citasTable');
        //             }
        //         }
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
        //             targets: '_all',  // Índices de las columnas con textos truncados
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
        //         configureInitComplete(this.api(), '#citasTable', 'CITAS', 'danger');
        //     }
        // });

        // table.on('init.dt', function() {
        //     restoreFilters(table, '#citasTable'); // Restaurar filtros después de inicializar la tabla
        // });
        
        // mantenerFilaYsubrayar(table);
        // fastEditForm(table, 'Cita')

        // $('#citasTable').colResizable({
        //     liveDrag: true,       
        //     resizeMode: 'flex',  
        //     partialRefresh: true,  
        //     minWidth: 50,         
        // });

        let table = $('#citasGrid');

        $('.limpiarFiltrosBtn').removeClass('dt-button').css('margin-bottom', '10px');
        $('.createUserbtn').removeClass('dt-button').css('margin-bottom', '10px');
        $('.showSelectedBtn').removeClass('dt-button').css('margin-bottom', '10px');
        $('.showAllBtnShow').removeClass('dt-button').css('margin-bottom', '10px');
        $('#addNewClienteModalBtn').css('cursor', 'pointer', 'color', 'blue', 'text-decoration', 'underline');

        $('.btnOpenEditModalFast').css('cursor', 'pointer');
        $('.btnOpenEditModalFast').css('text-decoration', 'underline');

        $('.openCitaModal').css('cursor', 'pointer');
        $('.openCitaModal').css('text-decoration', 'underline');
        
        // initializeSelectableTable("citasTable", "showSelectedBtn", "showAllBtn");


        table.on('dblclick', '.btnOpenEditModalFast', function() {
            const orderId = $(this).data('order');
            editOrdenTrabajo(orderId);
        });

        table.on('dblclick', '.openCitaModal', function() {
            $('#editCitaModal').modal('show');
            let id = $(this).data('id');
            editarCitaAjax(id);
        });

        table.on('dblclick', '.OpenHistorialCliente', function(event){
            const elemento  = $(this);
            const span      = elemento.find('span')[1]
            const parteid   = span.getAttribute('data-parteid');

            getEditCliente(parteid, 'Cita');
        });

        $('#createCitaModal').on('shown.bs.modal', function() {
            // Destruir la instancia de Select2, si existe
            if ($('#cliente_id').data('select2')) {
                $('#cliente_id').select2('destroy');
            }

            const date = new Date();
            $('#createCitaModal #fechaCita').val(date.toISOString().split('T')[0]);

            $('#createCitaModal #asunto').on('input', function(event){
                $(this).css('height', 'auto');
                $(this).css('height', this.scrollHeight + 'px');
            });

            // cargar textarea con el alto de todo el contenido
            $('#createCitaModal #asunto').css('height', $('#createCitaModal #asunto')[0].scrollHeight + 'px');

            // Inicializa Select2
            $('#createCitaModal #cliente_id').select2({
                width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                height: '150px', // Se asegura de que el select ocupe el 100% del contenedor
                dropdownParent: $('#createCitaModal') // Asocia el dropdown con el modal para evitar problemas de superposición
            });
        });

        $('#editCitaModal').on('shown.bs.modal', function() {
            // Destruir la instancia de Select2, si existe
            if ($('#cliente_id').data('select2')) {
                $('#cliente_id').select2('destroy');
            }

            // Inicializa Select2
            $('#editCitaModal select.form-select').select2({
                width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                height: '150px', // Se asegura de que el select ocupe el 100% del contenedor
                dropdownParent: $('#editCitaModal') // Asocia el dropdown con el modal para evitar problemas de superposición
            });
        });
    

        $('#createCitaModal #addNewClienteModalBtn').click(function() {
            
            $('#modal-cliente').modal('show');

            $('#modal-cliente').on('shown.bs.modal', function() {
                // Inicializa Select2
                $('#modal-cliente select.form-select').select2({
                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                    height: '150px', // Se asegura de que el select ocupe el 100% del contenedor
                    dropdownParent: $('#modal-cliente') // Asocia el dropdown con el modal para evitar problemas de superposición
                });
            });
        });

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
                                        $('#codPostal').val(parseInt(item));
                                    }
                                })

                                $('#cidade_id').val(1);

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

        $('#btnAddTelefono').click(function() {

            //como maximo se pueden agregar 3 telefonos
            if ($('#telefonosContainer').children().length >= 3) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'No se pueden agregar más de 3 teléfonos',
                    confirmButtonText: 'Aceptar',
                });
                $(this).prop('disabled', true);
                return;
            }

            // agrega un boton para eliminar el input
            let btnDelete = $('<button type="button" class="btn btn-outline-danger btnDeleteTelefono mt-2 mb-2">Eliminar</button>');

            // agrega un input para agregar otro telefono
            let input = $('<input type="number" name="telefono[]" class="form-control" required>');

            // agrega el input y el boton al contenedor
            $('#telefonosContainer').append(input).append(btnDelete);

            // elimina el input y el boton
            btnDelete.click(function() {
                input.remove();
                btnDelete.remove();
                $('#btnAddTelefono').prop('disabled', false);
            });

        });

        $('#btn-save-cliente').click(function(e) {

            //validar cada input que sea requerido y con el formato correcto
            let cif = $('#cif').val();
            let nombre = $('#nombre').val();
            let apellido = $('#apellido').val();
            let direccion = $('#direccion').val();
            let codPostal = $('#codPostal').val();
            let cidade_id = $('#cidade_id').val();
            let email = $('#email').val();
            let agente = $('#agente').val();
            let tipoClienteId = $('#tipoClienteId').val();
            let banco_id = $('#banco_id').val();
            let sctaContable = $('#sctaContable').val();
            let observaciones = $('#observaciones').val();
            let user_id = $('#user_id').val();
            let telefonos = $('input[name="telefono[]"]');

            let isNumberValid = true;

            if (nombre === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Todos los campos son requeridos',
                });
                return;
            }


            if (isNumberValid) {
                
                $.ajax({
                    url: '{{ route('admin.clientes.storeApi') }}',
                    type: 'POST',
                    data: $('#form-cliente').serialize(),
                    beforeSend: function() {
                        openLoader();
                    },
                    success: function(response) {
                        closeLoader();
                        Swal.fire({
                            icon: 'success',
                            title: 'Cliente creado correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // Actualizar el select de clientes en el formulario de creación de citas
                        if ( response.nombre && response.apellido ) {
                            $('#createCitaModal #cliente_id').append('<option value="' + response.id + '">' + response.nombre + ' ' + response.apellido + '</option>').trigger('change');
                        } else {
                            $('#createCitaModal #cliente_id').append('<option value="' + response.id + '">' + response.nombre + '</option>').trigger('change');
                            
                        }
                        $('#modal-cliente').modal('hide');
                    },
                    error: function(error) {
                        closeLoader();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al crear el cliente',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });

            }
        });

        // Función para mostrar la vista previa de los archivos seleccionados
        const showFilesPreview = (files) => {
            let filesPreviewContainer = $('#filesPreviewContainer');
            filesPreviewContainer.html('');

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                const currentIndex = fileCounterParte++;
                const uniqueId = `file_${i}_${currentIndex}`;

                reader.onload = function(e) {
                    const fileWrapper = $(`<div class="file-wrapper" id="preview_${uniqueId}"></div>`).css({
                        'display': 'inline-block',
                        'text-align': 'center',
                        'margin': '10px',
                        'max-width': '350px',
                        'width': '100%',
                        'vertical-align': 'top',
                        'border': '1px solid #ddd',
                        'padding': '10px',
                        'border-radius': '5px',
                        'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                        'overflow': 'hidden'
                    });

                    // Verificar si el archivo es una imagen/video/audio
                    const isImage = file.type.startsWith('image');
                    const isVideo = file.type.startsWith('video');
                    const isAudio = file.type.startsWith('audio');
                    let img = '';

                    if ( isImage ) {
                        // Crear elementos para la previsualización
                        img = $('<img>').attr('src', e.target.result).css({
                            'max-width': '300px',
                            'max-height': '300px',
                            'margin-bottom': '5px',
                            'object-fit': 'cover',
                            'border': '1px solid #ddd',
                            'padding': '5px',
                            'border-radius': '5px',
                            'border': 'none'
                        });
                    }else if ( isVideo ) {
                        // Crear elementos para la previsualización
                        img = $('<video controls></video>').attr('src', e.target.result).css({
                            'max-width': '300px',
                            'max-height': '300px',
                            'margin-bottom': '5px',
                            'object-fit': 'cover',
                            'border': '1px solid #ddd',
                            'padding': '5px',
                            'border-radius': '5px',
                            'border': 'none'
                        });
                    }else if ( isAudio ) {
                        // Crear elementos para la previsualización
                        img = $('<audio controls></audio>').attr('src', e.target.result).css({
                            'max-width': '300px',
                            'max-height': '300px',
                            'margin-bottom': '5px',
                            'object-fit': 'cover',
                            'border': '1px solid #ddd',
                            'padding': '5px',
                            'border-radius': '5px',
                            'border': 'none'
                        });
                    }else {
                        // Crear elementos para la previsualización
                        img = $('<img>').attr('src', '{{ asset('img/file.png') }}').css({
                            'max-width': '300px',
                            'max-height': '300px',
                            'margin-bottom': '5px',
                            'object-fit': 'cover',
                            'border': '1px solid #ddd',
                            'padding': '5px',
                            'border-radius': '5px',
                            'border': 'none'
                        });
                    }

                    const fileName = $('<span></span>').text(file.name).css('display', 'block');
                    const commentBox = $(`<textarea class="form-control mb-2" name="comentario[${currentIndex + 1}]" placeholder="Comentario archivo ${currentIndex + 1}" rows="2"></textarea>`);
                    const removeBtn = $(`<button type="button" class="btn btn-danger btnRemoveFile">Eliminar</button>`).attr('data-unique-id', uniqueId).attr('data-input-id', `input_${i}`);

                    fileWrapper.append(img);
                    fileWrapper.append(fileName);
                    fileWrapper.append(commentBox);
                    fileWrapper.append(removeBtn);

                    filesPreviewContainer.append(fileWrapper);
                }

                reader.onerror = function(error) {
                    console.error('Error al leer el archivo:', error);
                };

                reader.readAsDataURL(file);
            }

        }

        // Listener para el cambio en el input de archivos
        $('#inputparasubirarchivos').change(function() {
            let files = $(this)[0].files;
            showFilesPreview(files);
        });

        // Listener para eliminar un archivo de la vista previa y del input
        $(document).on('click', '.deleteFileBtn', function() {
            let fileName = $(this).data('name');
            $(this).parent().remove(); // Eliminar el elemento de la vista previa

            let input = $('#inputparasubirarchivos');
            let files = input[0].files;
            let newFiles = [];

            // Filtrar archivos para excluir el archivo a eliminar
            for (let i = 0; i < files.length; i++) {
                if (files[i].name != fileName) {
                    newFiles.push(files[i]);
                }
            }

            // Crear un nuevo input de tipo archivo para reemplazar el original
            let newInput = $('<input type="file" class="form-control" id="inputparasubirarchivos" name="inputparasubirarchivos" multiple>');

            // Reemplazar el input original con el nuevo input vacío
            input.replaceWith(newInput);

            // Asignar los archivos restantes al nuevo input (opcional, dependiendo de la estrategia)
            // Puedes optar por no reasignar los archivos al nuevo input para evitar restricciones del navegador
            newInput[0].files = newFiles;

            // resetear el contador de archivos
            fileCounter = 0;

            // Mostrar la vista previa de los archivos restantes
            showFilesPreview(newFiles);
        });

        // validar el formulario antes de enviarlo
        $('#saveCitaBtn').on('click', () => {
            
            // verificar si los divs que tienen la clase required field, su input no está vació
            let requiredFields = $('#createCitaModal .required-field input, #createCitaModal .required-field select, #createCitaModal .required-field textarea');
            let inputsValid    = true;

            requiredFields.each(function(index, element) {
                if ( element.value === '' || element.value === 'Seleccionar...') {
                    inputsValid = false;
                    $(element).addClass('is-invalid');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Faltan campos por completar',
                        text: 'Verifica que todos los campos con * esten completados',
                    })
                } else {
                    $(element).removeClass('is-invalid');
                }
            });
            
            if (inputsValid) {
                $('#createCitaModal form').submit();
            }
        })

        // generar orden

        let fileCounter = 0; // Contador para los archivos, asegurando nombres únicos para los comentarios

        const previewFiles = (files, container, inputIndex) => {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                const currentIndex = fileCounter++;
                const uniqueId = `file_${inputIndex}_${currentIndex}`; // Identificador único

                reader.onload = function(e) {
                    // Crear un contenedor para cada archivo
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

                    // Crear elementos para la previsualización
                    const img = $('<img>').attr('src', e.target.result).css({
                        'max-width': '300px',
                        'max-height': '300px',
                        'margin-bottom': '5px',
                        'object-fit': 'cover',
                        'border': '1px solid #ddd',
                        'padding': '5px',
                        'border-radius': '5px',
                        'border': 'none'
                    });

                    const fileName = $('<span></span>').text(file.name).css('display', 'block');
                    const commentBox = $(`<textarea class="form-control mb-2" name="comentario[${currentIndex + 1}]" placeholder="Comentario archivo ${currentIndex + 1}" rows="2"></textarea>`);
                    const removeBtn = $(`<button type="button" class="btn btn-danger btnRemoveFile">Eliminar</button>`).attr('data-unique-id', uniqueId).attr('data-input-id', `input_${inputIndex}`);

                    // Añadir elementos al contenedor
                    fileWrapper.append(img);
                    fileWrapper.append(fileName);
                    fileWrapper.append(commentBox);
                    fileWrapper.append(removeBtn);

                    container.append(fileWrapper);

                    // Ya no deshabilitamos el input de archivos
                }

                reader.readAsDataURL(file);
            }
        }

        table.on('click', '.generateOrden', function() {

            $('#modalCreateOrden').modal('show');

            // tomar los datos de la cita seleccionada
            let citaInfo = $(this).data('cita');

            $('#modalCreateOrden').on('shown.bs.modal', () => {
                // Destruir la instancia de Select2, si existe
                if ($('#modalCreateOrden select.form-select').data('select2')) {
                    $('#modalCreateOrden select.form-select').select2('destroy');
                }

                $('#modalCreateOrden select.form-select').select2({
                    width: '100%',  // Asegura que el select ocupe el 100% del contenedor
                    dropdownParent: $('#modalCreateOrden')  // Asocia el dropdown con el modal para evitar problemas de superposición
                });

                let textarea = $('#modalCreateOrden #asunto');
                
                // Restablece la altura del textarea
                textarea.css('height', 'auto');
                
                // Verifica y ajusta el scrollHeight solo si es mayor a 0
                if (textarea[0].scrollHeight > 0) {
                    textarea.css('height', textarea[0].scrollHeight + 'px');
                }

                // Evento que expande automáticamente el textarea cuando se ingresa texto
                textarea.on('input', function() {
                    $(this).css('height', 'auto');
                    $(this).css('height', this.scrollHeight + 'px');
                });

            });

            // limpiar citasPendigSelect y dejar solo la cita seleccionada
            $('#modalCreateOrden #citasPendigSelect').val(citaInfo.idCitas).trigger('change').attr('readonly');
            $('#modalCreateOrden #asunto').val(citaInfo.asunto);
            $('#modalCreateOrden #fecha_alta').val(citaInfo.fechaDeAlta);
            $('#modalCreateOrden #fecha_visita').val(citaInfo.fechaDeVisita);
            $('#modalCreateOrden #estado').val("Pendiente");
            $('#modalCreateOrden #cliente_id').val(citaInfo.cliente.idClientes).trigger('change').attr('readonly');
            $('#modalCreateOrden #observaciones').val(citaInfo.observaciones || '');
            $('#modalCreateOrden #trabajo_id').val(1);

            // validar que no puedan cambiar la cita por otra
            $('#modalCreateOrden #citasPendigSelect').on('change', function(event){
                const citaValue = $(this).val();

                if (citaValue != citaInfo.idCitas) {
                    $(this).val(citaInfo.idCitas).trigger('change');
                }
            });

            // validar este select con select2 si está vacío cambiar el estado a en proceso, si no dejarlo en pendiente
            $('#modalCreateOrden #operario_id').on('change', function() {
                const operarioId = $(this).val();
                if (operarioId.length > 0) {
                    $('#modalCreateOrden #estado').val('En proceso').trigger('change');
                } else {
                    $('#modalCreateOrden #estado').val('Pendiente').trigger('change');
                }
            });

            // mostrar la vista previa de los archivos seleccionados
            const archivos = $(this).data('archivos');

            if (archivos && archivos.length > 0) {
                const archivosContainer = $('#modalCreateOrden #previewImage1');
                archivosContainer.html('');
                
                for (let i = 0; i < archivos.length; i++) {
                    let archivo = archivos[i];
                    // mostrar vista previa de la imagen, video o audio o documento subido
                    
                    let fileType = archivo.typeFile; // jpg, jpeg, png, gif, mp4, mp3, pdf, doc, docx, xls, xlsx, wav, mov, ogg, webm
                    let fileExtension = archivo.nameFile.split('.').pop();
    
                    let filePreview = '';

                    switch (fileType) {
                        case 'jpg' || 'jpeg' || 'png' || 'gif':
                            fileType = 'image';
                            break;
                        case 'mp4' || 'mov' || 'webm' || 'avi':
                            fileType = 'video';
                            break;
                        case 'mp3' || 'wav' || 'ogg':
                            fileType = 'audio';
                            break;
                        case 'pdf' || 'doc' || 'docx' || 'xls' || 'xlsx':
                            fileType = 'application';
                            break;
                        default:
                            fileType = 'image';
                            break;
                    }

                    let url = archivo.pathFile;
                    let serverUrl = 'https://sebcompanyes.com/';
                    let urlModificar = '/home/u657674604/domains/sebcompanyes.com/public_html/';

                    url = url.replace(urlModificar, serverUrl);

                    if (fileType == 'image') {
                        filePreview = `<img src='${url}' style="max-width: 300px; max-height: 300px; margin: 5px; object-fit: contain;">`;
                    } else if (fileType == 'video') {
                        filePreview = `<video src='${url}' style="max-width: 300px; max-height: 300px; margin: 5px" controls></video>`;
                    } else if (fileType == 'application') {
                        if (fileExtension == 'pdf') {
                            filePreview = `<embed src='${url}' style="max-width: 300px; max-height: 300px; margin: 5px">`;
                        } else if (fileExtension == 'doc' || fileExtension == 'docx') {
                            filePreview = `<ion-icon name="document" style="max-width: 300px; max-height: 300px; margin: 5px"></ion-icon>`;
                        }
                    }

                    // verificar si la imagen o video está en formato horizontal para ordernar todas las verticales primero y luego las horizontales

                    if(fileType == 'image'){

                        const img = new Image();
                        img.src = url;

                        img.onload = function() {
                            if (this.width > this.height) {
                                archivosContainer.prepend('<div class="file-preview-item d-flex justify-content-between g-2 flex-wrap flex-column align-items-center align-self-center mb-2">' + filePreview + '<textarea rows="2" name="comentarioCita[]" class="form-control" placeholder="Comentario del archivo de la cita"></textarea>');
                            } else {
                                archivosContainer.append('<div class="file-preview-item d-flex justify-content-between g-2 flex-wrap flex-column align-items-center align-self-center mb-2">' + filePreview + '<textarea rows="2" name="comentarioCita[]" class="form-control" placeholder="Comentario del archivo de la cita"></textarea>');
                            }
                        }

                    }else{
                        archivosContainer.append('<div class="file-preview-item d-flex justify-content-between g-2 flex-wrap flex-column align-items-center align-self-center">' + filePreview + '<a target="_blank" href="{{ route('admin.citas.download', '') }}/' + archivo.idarchivos + '" class="btn btn-outline-primary m-1">Descargar</a>');
                    }

                    // añadir boton para descargar el archivo

                    archivosContainer.append('');

                    archivosContainer.find('img, video').css('cursor', 'pointer');

                    // añadir evento a la imagen o video para que se abra en una nueva pestaña
                    archivosContainer.find('img, video').on('click', function() {
                        window.open(url, '_blank');
                    });
                }

            }


        });

        $('#btnCreateOrden').on('click', function() {

            // Validar que se haya seleccionado una cita y uno o más trabajos
            const citaId = $('#citasPendigSelect').val();
            const trabajos = $('#trabajo_id').val();

            if (!citaId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debes seleccionar una cita',
                    confirmButtonText: 'Aceptar',
                });
                return;
            }

            if (!trabajos || trabajos.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debes seleccionar al menos un trabajo',
                    confirmButtonText: 'Aceptar',
                });
                return;
            }

            // deshabilitar el botón de guardar
            $('#btnCreateOrden').attr('disabled', true);

            openLoader();
            $('#formCreateOrden').submit();

        });


        // Subir archivos y mostrar una vista previa de la imagen o icono si es un archivo

        $('#files1').on('change', function() {
            const files = $(this)[0].files;
            const filesContainer = $('#previewImage1');

            // Añadir previsualización
            previewFiles(files, filesContainer, 0);
        });

        $('#files1').on('click', function(e) {
            // verificar si hay archivos cargados
            if ($('#previewImage1').children().length > 0) {
                e.preventDefault();
                alert('Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"');
                return;
            }
        });


        // Evento para añadir más inputs de archivos
        $('#btnAddFiles').on('click', function() {
            const newInputContainer = $('<div class="form-group col-md-12"></div>');
            const inputIndex = $('#inputsToUploadFilesContainer input').length + 1; // Índice del nuevo input
            const newInputId = `input_${inputIndex}`;

            // como maximo se pueden añadir 5 inputs
            if (inputIndex >= 5) {
                alert('No puedes añadir más de 5 archivos');
                return;
            }
            
            const newInput = $(`<input type="file" class="form-control" name="file[]" id="${newInputId}">`);
            newInputContainer.append(newInput);
            $('#inputsToUploadFilesContainer').append(newInputContainer);

            // Manejar la previsualización para los nuevos inputs
            newInput.on('change', function() {
                const files = $(this)[0].files;
                const filesContainer = $('#previewImage1');

                // Añadir previsualización
                previewFiles(files, filesContainer, inputIndex);
            });

            newInput.on('click', function(e) {
                // verificar si hay archivos cargados
                if ($('#previewImage1').children().length > inputIndex) {
                    e.preventDefault();
                    alert('Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"');
                    return;
                }
            });

        });

        // Evento para eliminar archivos de la previsualización
        $(document).on('click', '.btnRemoveFile', function() {
            const uniqueId = $(this).data('unique-id');  // ID único del archivo a eliminar
            const inputId = $(this).data('input-id');    // ID del input asociado

            // Eliminar el contenedor de previsualización del archivo
            $(`#preview_${uniqueId}`).remove();

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
        });

        // generar parte de trabajo
        let fileCounterParte = 0;
        let materialCounter = 0;
        let parteTrabajoId = null;
        let selectedFiles = [];

        const previewFilesParte = (files, container, inputIndex) => {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                const currentIndex = fileCounterParte++;
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

        $('#OrdenesTable').on('click', '.createParteTrabajoBtn', function() {
            $('#createParteTrabajoModal').modal('show');

            $('#createParteTrabajoModal').on('shown.bs.modal', () => {
                if ($('#createParteTrabajoModal select.form-select').data('select2')) {
                    $('#createParteTrabajoModal select.form-select').select2('destroy');
                }

                $('#createParteTrabajoModal select.form-select').select2({
                    width: '100%',
                    dropdownParent: $('#createParteTrabajoModal')
                });
            });

            // obtener los datos de la orden
            let idOrden = $(this).data('id');
            let asunto = $(this).data('asunto');
            let fechaAlta = $(this).data('fecha-alta');
            let fechaVisita = $(this).data('fecha-visita');
            let estado = $(this).data('estado');
            let cliente = $(this).data('cliente');
            let departamento = $(this).data('departamento');
            let trabajos = $(this).data('trabajoswithid');
            let operarios = $(this).data('operarios');
            let observaciones = $(this).data('observaciones');
            let archivos = $(this).data('archivos');
            let archivosComentarios = $(this).data('comentarios');

            if ( estado == 'Pendiente' ) {
                estado = 1;
            }else if( estado == 'En proceso' ){
                estado = 2;
            }else{
                estado = 3;
            }

            // cambiar los options de trabajo por las opciones del array de trabajos
            $('#createParteTrabajoModal #trabajo_id').empty();

            trabajos.forEach(trabajo => {
                //obtener el id del trabajo que se encuentra entre paréntesis
                let idTrabajo = trabajo.id;
                trabajo = trabajo.name;

                $('#createParteTrabajoModal #trabajo_id').append(new Option(trabajo, idTrabajo, true, true)).trigger('change');

            });

            // asignar los valores a los campos del modal

            $('#createParteTrabajoModal #parteTrabajo_id').val(idOrden);
            $('#createParteTrabajoModal #asunto').val(asunto);
            $('#createParteTrabajoModal #fecha_alta').val(fechaAlta);
            $('#createParteTrabajoModal #fecha_visita').val(fechaVisita);
            $('#createParteTrabajoModal #estado').val(estado);
            $('#createParteTrabajoModal #cliente_id').val(cliente);
            $('#createParteTrabajoModal #departamento').val(departamento);
            $('#createParteTrabajoModal #observaciones').val(observaciones);
            $('#createParteTrabajoModal #ordenId').val(idOrden);

            // Añadir previsualización de archivos debajo su respectivo comentario
            const imagesContainer = $('#createParteTrabajoModal #imagesDetails');
            const archivosArray = archivos.split(', ');
            const archivosComentariosArray = archivosComentarios.split(', ');

            archivosArray.pop();
            archivosComentariosArray.pop();

            archivosArray.forEach((archivo, index) => {
                const fileWrapper = $(`<div class="file-wrapper"></div>`).css({
                    'display': 'inline-block',
                    'text-align': 'center',
                    'margin': '10px',
                    'width': '350px',
                    'height': '350px',
                    'vertical-align': 'top',
                    'border': '1px solid #ddd',
                    'padding': '10px',
                    'border-radius': '5px',
                    'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                    'overflow': 'hidden'
                });

                const fileName = $(`<img src="{{ asset('archivos/ordenestrabajo/${archivo}') }}" alt="Archivo ${index + 1}" style="max-width: 100%; max-height: 100%; object-fit: cover">`);
                const commentBox = $(`<textarea class="form-control mb-2" name="comentario[${index + 1}]" placeholder="Comentario archivo ${index + 1}" rows="2" disabled></textarea>`).val(archivosComentariosArray[index]);

                fileName.css('cursor', 'pointer');
                fileName.on('click', function() {
                    window.open(`{{ asset('archivos/ordenestrabajo/${archivo}') }}`, '_blank');
                });

                fileWrapper.append(fileName);
                fileWrapper.append(commentBox);

                imagesContainer.append(fileWrapper);
            });
            
        });


        $('#btnCreateOrdenButton').on('click', function(event) {
            event.preventDefault();
            const formData = new FormData($('#createParteTrabajoModal #formCreateOrden')[0]);

            const files = $('#createParteTrabajoModal #formCreateOrden input[type="file"]');

            for (let i = 0; i < files.length; i++) {
                const input = files[i];
                const inputName = $(input).attr('name');
                const filesToUpload = input.files;

                for (let j = 0; j < filesToUpload.length; j++) {
                    formData.append(inputName, filesToUpload[j]);
                }
            }

            if (!formData.get('cita') || !formData.get('asunto') || !formData.get('fecha_alta') || !formData.get('fecha_visita') || !formData.get('estado') || !formData.get('cliente_id') || !formData.get('departamento') || !formData.get('observaciones') || !formData.get('suma') || !formData.get('trabajo_id')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Todos los campos son requeridos',
                });
                return;
            }

            $.ajax({
                url: "{{ route('admin.partes.store') }}",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Parte de trabajo creada correctamente',
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

        
    </script>

    {{-- Details --}}
    <script>
        $('#citasGrid').on('click', '.detailsCitaBtn', function() {
            $('#detailsCitaModal').modal('show');
            const id = $(this).attr('data-idcitas');
            detailsCitaAjax(id);
        });
    </script>

    {{-- Edit --}}
    <script>
        $('#citasGrid').on('click', '.editCitabtn', function() {
            $('#editCitaModal').modal('show');
            const id = $(this).data('idcitas');
            editarCitaAjax(id);
        });

        $('#editCitaModal').on('shown.bs.modal', function () {
            let textarea = $('#editCitaModal #asuntoEdit');
            
            // Restablece la altura del textarea
            textarea.css('height', 'auto');
            
            // Verifica y ajusta el scrollHeight solo si es mayor a 0
            if (textarea[0].scrollHeight > 0) {
                textarea.css('height', textarea[0].scrollHeight + 'px');
            }

            // Evento que expande automáticamente el textarea cuando se ingresa texto
            textarea.on('input', function() {
                $(this).css('height', 'auto');
                $(this).css('height', this.scrollHeight + 'px');
            });
        });

        // validar el formulario antes de enviarlo
        $('#saveEditCitaBtn').on('click', () => {
            let fechaCita = $('#fechaCitaEdit').val();
            let asunto = $('#asuntoEdit').val();
            let tipoCita = $('#tipoCitaEdit').val();
            let usuarioQueCreaLaCita = $('#usuarioQueCreaLaCitaEdit').val();
            let estado = $('#estadoEdit').val();
            let archivos = $('#inputparasubirarchivosEdit')[0].files;

            if (fechaCita == '' || asunto == '' || tipoCita == '' || usuarioQueCreaLaCita == '' || estado == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Todos los campos son obligatorios',
                    confirmButtonText: 'Aceptar',
                })
                return false;
            }

            $('#editCitaModal form').submit();
        });
    </script>


@stop