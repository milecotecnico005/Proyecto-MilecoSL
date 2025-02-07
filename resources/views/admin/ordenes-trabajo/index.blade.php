


@extends('adminlte::page')

@section('title', 'Ordenes')

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
            border: 1px solid rgb(255, 193, 7);
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

            <div id="OrdenesGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>

            {{-- <table class="table table-striped" id="OrdenesTable">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Parte</th>
                        <th>Pro.</th>
                        <th>Asunto</th>
                        <th>F.Alta</th>
                        <th>#Cita</th>
                        <th>F.Visita</th>
                        <th>Estado</th>
                        <th>Cliente</th>
                        <th>Departamento</th>
                        <th>H.Inicio</th>
                        <th>H.Fin</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordenes as $orden)
                        @php
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
                        <tr
                            data-id="{{ $orden->idOrdenTrabajo }}"
                            class="mantenerPulsadoParaSubrayar"
                        >
                            <td
                                class="btnOpenEditModalFast"
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
                                >{{ $orden->idOrdenTrabajo }}
                            </td>
                            <td
                                @if ( count($orden->partesTrabajo) > 0 )
                                    class="editParteTrabajoTable"
                                    data-id="{{ ( count($orden->partesTrabajo) > 0 ) ? $orden->partesTrabajo[0]->idParteTrabajo : '' }}"
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="Editar"
                                @endif
                                >
                                    {{ ( count($orden->partesTrabajo) > 0 ) ? $orden->partesTrabajo[0]->idParteTrabajo : '' 
                                }}
                            </td>
                            <td
                                @if (isset($orden->proyecto) && count($orden->proyecto) > 0)
                                    data-proyectoid="{{ $orden->proyecto[0]->idProyecto }}"
                                    class="openProjectDetails"
                                    data-fulltext="{{ $orden->proyecto[0]->name }}"
                                @endif
                            >
                                @if (isset($orden->proyecto) && count($orden->proyecto) > 0)
                                    <span 
                                        class="badge badge-pill badge-info badgeProject"
                                        data-fulltext="{{ $orden->proyecto[0]->name }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="{{ $orden->proyecto[0]->name }}"
                                    >
                                        {{ Str::limit($orden->proyecto[0]->name, 5) }}
                                    </span>
                                @endif
                            </td>
                            <td
                                data-fulltext="{{ $orden->Asunto }}"
                                class="text-truncate openqQuickEdit"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ $orden->Asunto }}"
                                data-fieldName="Asunto"
                                data-type="text"
                                data-parteid="{{ $orden->idOrdenTrabajo }}"
                            >
                                {{ Str::limit($orden->Asunto, 5) }}
                            </td>
                            <td
                                data-fulltext="{{ formatDate($orden->FechaAlta) }}"
                                class="text-truncate openqQuickEdit"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-fieldName="FechaAlta"
                                data-type="date"
                                title="{{ formatDate($orden->FechaAlta) }}"
                                data-parteid="{{ $orden->idOrdenTrabajo }}"
                            >{{ formatDate($orden->FechaAlta) }}</td>
                            <td
                                class="openCitaModal"
                                data-id="{{ $orden->cita->idCitas }}"
                                data-info="{{ json_encode($orden->cita) }}"
                                data-userCita="{{ json_encode($orden->cita->user) }}"
                                data-archivos="{{ json_encode($orden->cita->archivos) }}"
                            >{{ $orden->cita->idCitas }}</td>
                            <td
                                data-fulltext="{{ ($orden->FechaVisita) ? formatDate($orden->FechaVisita) : '' }}"
                                class="text-truncate openqQuickEdit"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-fieldName="FechaVisita"
                                data-type="date"
                                title="{{ ($orden->FechaVisita) ? formatDate($orden->FechaVisita) : '' }}"
                                data-parteid="{{ $orden->idOrdenTrabajo }}"

                            >
                                {{ ($orden->FechaVisita) ? formatDate($orden->FechaVisita) : '' }}
                            </td>
                            <td>
                                @if ($orden->Estado == 'Pendiente')
                                    <span
                                        class="badge badge-pill badge-warning"
                                    >
                                        {{ $orden->Estado }}
                                    </span>

                                @elseif ($orden->Estado == 'En Proceso')
                                    <span
                                        class="badge badge-pill badge-primary"
                                    >
                                        {{ $orden->Estado }}
                                    </span>
                                
                                @elseif ($orden->Estado == 'Finalizado')

                                    <span
                                        class="badge badge-pill badge-success"
                                    >
                                        {{ $orden->Estado }}
                                    </span>

                                @else

                                    <span
                                        class="badge badge-pill badge-primary"
                                    >
                                        {{ $orden->Estado }}
                                    </span>

                                @endif
                            </td>
                            <td
                                data-fulltext="{{ $orden->cliente->NombreCliente }} {{ $orden->cliente->ApellidoCliente }}"
                                class="text-truncate"
                                data-bs-placement="top" data-bs-toggle="tooltip"
                                title="{{ $orden->cliente->NombreCliente }} {{ $orden->cliente->ApellidoCliente }}"
                            >
                                {{ Str::limit($orden->cliente->NombreCliente . ' ' . $orden->cliente->ApellidoCliente, 10) }}
                            </td>
                            <td
                                data-fulltext="{{ $orden->Departamento }}"
                                class="text-truncate openqQuickEdit"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ $orden->Departamento }}"
                                data-fieldName="Departamento"
                                data-type="text"
                                data-parteid="{{ $orden->idOrdenTrabajo }}"
                            >
                                {{ Str::limit($orden->Departamento, 10) }}
                            </td>
                            <td
                                data-fulltext="{{ $orden->hora_inicio }}"
                                class="text-truncate openqQuickEdit"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ $orden->hora_inicio }}"
                                data-fieldName="hora_inicio"
                                data-type="time"
                                data-parteid="{{ $orden->idOrdenTrabajo }}"
                            >   
                                {{ $orden->hora_inicio }}
                            </td>
                            <td
                                data-fulltext="{{ $orden->hora_fin }}"
                                class="text-truncate openqQuickEdit"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ $orden->hora_fin }}"
                                data-fieldName="hora_fin"
                                data-type="time"
                                data-parteid="{{ $orden->idOrdenTrabajo }}"
                            >
                                {{ $orden->hora_fin }}
                            </td>
                            <td
                                data-fulltext="{{ $orden->Observaciones }}"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ $orden->Observaciones }}"
                                class="text-truncate openqQuickEdit"
                                data-fieldName="Observaciones"
                                data-type="text"
                                data-parteid="{{ $orden->idOrdenTrabajo }}"
                            >
                                {{ Str::limit($orden->Observaciones, 10) }}
                            </td>
                            <td>
                                @component('components.actions-button')
                                    <a 
                                        class="btn btn-info btnOpenDetailsModal"
                                        data-id="{{ $orden->idOrdenTrabajo }}"
                                        data-asunto="{{ $orden->Asunto }}"
                                        data-fecha-alta="{{ $orden->FechaAlta }}"
                                        data-fecha-visita="{{ $orden->FechaVisita }}"
                                        data-estado="{{ $orden->Estado }}"
                                        data-cliente="{{ $orden->cliente->NombreCliente }} {{ $orden->cliente->ApellidoCliente }}"
                                        data-departamento="{{ $orden->Departamento }}"
                                        data-trabajos="{{ $trabajosArray }}"
                                        data-operarios="{{ $operariosArray }}"
                                        data-archivos="{{ json_encode($archivosArray) }}"
                                        data-comentarios="{{ $archivosComentarios }}"
                                        data-observaciones="{{ $orden->Observaciones }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Ver detalles"
                                        >
                                        <ion-icon name="information-circle-outline"></ion-icon>
                                    </a>
                                    <a 
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
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"
                                        data-parte="{{ json_encode($orden->partesTrabajo) }}"
                                        class="btn btn-primary btnOpenEditModal">
                                        <ion-icon name="create-outline"></ion-icon>
                                    </a>
                                    @if ( count($orden->partesTrabajo) <= 0 )
                                        <a 
                                            data-proyectoid="{{ ( count($orden->proyecto) > 0 ) ? $orden->proyecto[0]->idProyecto : '' }}"
                                            data-id="{{ $orden->idOrdenTrabajo }}"
                                            data-asunto="{{ $orden->Asunto }}"
                                            data-fecha-alta="{{ $orden->FechaAlta }}"
                                            data-fecha-visita="{{ $orden->FechaVisita }}"
                                            data-estado="{{ $orden->Estado }}"
                                            data-cliente="{{ $orden->cliente->idClientes }}"
                                            data-clientedata="{{ json_encode($orden->cliente->tipoCliente) }}"
                                            data-ordendata="{{ json_encode($orden) }}"
                                            data-operariosdata="{{ json_encode($salariosArray) }}"
                                            data-departamento="{{ $orden->Departamento }}"
                                            data-trabajos="{{ $trabajosArray }}"
                                            data-operarios="{{ $operariosArray }}"
                                            data-operariosids="{{ json_encode($orden->operarios) }}"
                                            data-archivos="{{ json_encode($archivosArray) }}"
                                            data-comentarios="{{ $archivosComentarios }}"
                                            data-observaciones="{{ $orden->Observaciones }}"
                                            data-trabajoswithid="{{ json_encode($trabajosArrayWithId) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Crear Parte de Trabajo"
                                            class="btn btn-warning createParteTrabajoBtn">
                                            <ion-icon name="add-circle-outline"></ion-icon>
                                        </a>
                                    @endif
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    </div>

    {{-- Modal para detalles del proyecto --}}
    @component('components.modal-component',[
        'modalId'       => 'showProjectDetailsModal',
        'modalTitleId'  => 'showProjectDetailsTitle',
        'modalTitle'    => 'Historial de proyecto',
        'modalSize'     => 'modal-xl',
        'hideButton'    => true,
        'otherButtonsContainer' => 'showProjectDetailsFooter'
    ])
        <div class="row col-sm-12" id="showAccordeonsProject">

        </div>  
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
                        <option value="" selected>Seleccionar...</option>
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
                    <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto">
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
                    <select id="trabajo_id" multiple name="trabajo_id[]" class="form-select">
                        @foreach ($trabajos as $trabajo )
                            <option value="{{ $trabajo->idTrabajo }}">{{ $trabajo->nameTrabajo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group
                    col-md-6">
                    <label for="operario_id">Operario/s</label>
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
                    <label for="files">Archivos</label>
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

    {{-- Modal para detalles de la orden --}}
    @component('components.modal-component', [
        'modalId' => 'modalDetallesOrden',
        'modalTitle' => 'Detalles de la Orden',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'detallesOrdenTitle',
        'btnSaveId' => 'btnDetallesOrden',
        'disabledSaveBtn' => true,
        'hideButton' => true
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

    {{-- Modal para editar la orden --}}

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

    @component('components.modal-component', [
        'modalId' => 'createParteTrabajoModal',
        'modalTitle' => 'Crear Parte de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveParteTrabajoBtn',
        'disabledSaveBtn' => true,
        'hideButton' => true
    ])
        @include('admin.partes_trabajo.form')
    @endcomponent

    {{-- Cita modal --}}
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
                            <option value="Realizada">Realizada</option>
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

    @php
        $tokenValido = app('App\Http\Controllers\GoogleCalendarController')->checkGoogleToken();
    @endphp

    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.0.0/signature_pad.umd.min.js"></script>

    <script>

        $(document).ready(function() {

            // Inicializar la tabla de citas
            const agTablediv = document.querySelector('#OrdenesGrid');

            let rowData = {};
            let data = [];

            const ordenes = @json($ordenes);

            const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
                { 
                    name: 'ID',
                    fieldName: 'orden',
                    addAttributes: true, 
                    addcustomDatasets: true,
                    dataAttributes: { 
                        'data-id': ''
                    },
                    attrclassName: 'btnOpenEditModalFast',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                    principal: true
                }, 
                { 
                    name: 'Parte',
                    fieldName: 'parte',
                    addAttributes: true, 
                    addcustomDatasets: true,
                    dataAttributes: { 
                        'data-id': ''
                    },
                    attrclassName: 'editParteTrabajoTable',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                }, 
                { 
                    name: 'Proyecto',
                    addAttributes: true,
                    dataAttributes: { 
                        'data-order': 'order-column' 
                    },
                    attrclassName: 'openProjectDetails',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                },
                { 
                    name: 'Asunto',
                    fieldName: 'Asunto',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "Asunto",
                        'data-type': "text"
                    }
                },
                {
                    name: 'Operarios',
                    fieldName: 'operario_id',
                    fieldType: 'select',
                    addAttributes: true,
                },
                { 
                    name: 'FechaAlta', 
                    className: 'fecha-alta-column',
                    fieldName: 'FechaAlta',
                    fieldType: 'date',
                    editable: true,

                },
                { 
                    name: 'Cita',
                    addAttributes: true,
                    dataAttributes: { 
                        'data-order': 'order-column' 
                    },
                    attrclassName: 'openCitaModal',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                },
                { 
                    name: 'FechaVisita', 
                    className: 'fecha-alta-column',
                    fieldName: 'FechaVisita',
                    fieldType: 'date',
                    editable: true,

                },
                { name: 'Estado' },
                { 
                    name: 'Cliente',
                    fieldName: 'cliente_id',
                    fieldType: 'select',
                    addAttributes: true,
                },
                { name: 'Departamento' },
                { name: 'HInicio' },
                { name: 'HFin' },
                { name: 'Observaciones' },
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

            function prepareRowData(ordenes) {
                ordenes.forEach(orden => {
                    if (orden.partes_trabajo && orden.partes_trabajo.length > 0) {
                        // console.log(orden);
                    }
                    const tecnicosPorComas = orden.operarios.map(tec => tec.user.name).join(', ');
                    rowData[orden.idOrdenTrabajo] = {
                        ID: orden.idOrdenTrabajo,
                        Parte: (orden.partes_trabajo && orden.partes_trabajo.length > 0) ? orden.partes_trabajo[0].idParteTrabajo : '',
                        Proyecto: (orden.proyecto && orden.proyecto.length > 0) ? orden.proyecto[0].name : '',
                        Asunto: orden.Asunto,
                        Operarios: tecnicosPorComas,
                        FechaAlta: orden.FechaAlta,
                        Cita: orden.cita.idCitas,
                        FechaVisita: orden.FechaVisita,
                        Estado: orden.Estado,
                        Cliente: `${orden.cliente.NombreCliente} ${orden.cliente.ApellidoCliente}`,
                        Departamento: orden.Departamento,
                        HInicio: orden.hora_inicio,
                        HFin: orden.hora_fin,
                        Observaciones: orden.Observaciones,
                        Notas1: orden.notas1,
                        Notas2: orden.notas2,
                        Acciones: 
                        `
                            @component('components.actions-button')
                                <a 
                                    class="btn btn-info btnOpenDetailsModal"
                                    data-id="${orden.idOrdenTrabajo}"
                                    data-asunto="${orden.Asunto}"
                                    data-fecha-alta="${orden.FechaAlta}"
                                    data-fecha-visita="${orden.FechaVisita}"
                                    data-estado="${orden.Estado}"
                                    data-cliente="${orden.cliente.NombreCliente} ${orden.cliente.ApellidoCliente}"
                                    data-departamento="${orden.Departamento}"
                                    data-trabajos="${orden.trabajo}"
                                    data-operarios="${orden.operarios}"
                                    data-archivos="${orden.archivos}"
                                    data-comentarios="${orden.archivos.comentarios}"
                                    data-observaciones="${orden.Observaciones}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Ver detalles"
                                >
                                    <div class="d-flex justify-content-center align-items-center flex-column">
                                        <ion-icon name="information-circle-outline"></ion-icon>
                                        <span class="mr-1">Detalles</span>
                                    </div>
                                </a>
                                <a 
                                    data-id="${orden.idOrdenTrabajo}"
                                    data-asunto="${orden.Asunto}"
                                    data-fecha-alta="${orden.FechaAlta}"
                                    data-fecha-visita="${orden.FechaVisita}"
                                    data-estado="${orden.Estado}"
                                    data-cliente="${orden.cliente.idClientes}"
                                    data-departamento="${orden.Departamento}"
                                    data-trabajos="${orden.trabajo}"
                                    data-operarios="${orden.operarios}"
                                    data-observaciones="${orden.Observaciones}"
                                    data-archivos="${orden.archivos}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"
                                    data-parte="${(orden.partes_trabajo && orden.partes_trabajo.length > 0) ? orden.partes_trabajo[0].idParteTrabajo : ''}"
                                    class="btn btn-primary btnOpenEditModal"
                                >
                                    <div class="d-flex justify-content-center align-items-center flex-column">
                                        <ion-icon name="create-outline"></ion-icon>
                                        <span class="mr-1">Editar</span>
                                    </div>
                                </a>
                                ${ ( orden.partes_trabajo && orden.partes_trabajo.length <= 0) ? `
                                    <a 
                                        data-proyectoid="${ (orden.proyecto && orden.proyecto.length > 0) ? orden.proyecto[0].idProyecto : '' }"
                                        data-id="${orden.idOrdenTrabajo}"
                                        data-asunto="${orden.Asunto}"
                                        data-fecha-alta="${orden.FechaAlta}"
                                        data-fecha-visita="${orden.FechaVisita}"
                                        data-estado="${orden.Estado}"
                                        data-cliente="${orden.cliente.idClientes}"
                                        data-clientedata='${JSON.stringify(orden.cliente.tipo_cliente)}'
                                        data-ordendata='${JSON.stringify(orden)}'
                                        data-operariosdata='${JSON.stringify(orden.operarios)}'
                                        data-departamento='${orden.Departamento}'
                                        data-trabajos='${JSON.stringify(orden.trabajo)}'
                                        data-operarios='${JSON.stringify(orden.operarios)}'
                                        data-operariosids='${ JSON.stringify(orden.operarios) }'
                                        data-archivos='${ JSON.stringify(orden.archivos) }'
                                        data-comentarios='${ JSON.stringify(orden.archivos.comentarios) }'
                                        data-observaciones='${orden.Observaciones}'
                                        data-trabajoswithid='${ JSON.stringify(orden.trabajo) }'
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Crear Parte de Trabajo"
                                        class="btn btn-warning createParteTrabajoBtn"
                                    >
                                        <div class="d-flex justify-content-center align-items-center flex-column">
                                            <ion-icon name="add-circle-outline"></ion-icon>
                                            <span class="mr-1">Crear Parte</span>
                                        </div>
                                    </a>
                                ` : '' }
                            @endcomponent
                        
                        `
                    }
                });

                data = Object.values(rowData);
            }

            prepareRowData(ordenes);

            const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
                const customButtons = `
                    @if (!$tokenValido)
                        <button type="button" class="btn btn-outline-primary calendarButtonToken"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Conectar con Google Calendar"
                        >
                            <div class="d-flex justify-content-center align-items-center">
                                <span class="mr-1">Conectar con Google Calendar</span>
                                <ion-icon name="cloud-upload-outline"></ion-icon>
                            </div>
                        </button>
                    @endif
                `;

                // Inicializar la tabla de citas
                inicializarAGtable( agTablediv, data, result, 'Ordenes de Trabajo.', customButtons, 'OrdenesTrabajo', null, true);

            });

            $('.calendarButtonToken').on('click', function() {
                window.location.href = "{{ route('google.redirect') }}";
            });

            $('.btnOpenEditModalFast').css('cursor', 'pointer');
            $('.btnOpenEditModalFast').css('text-decoration', 'underline');

            $('.openCitaModal').css('cursor', 'pointer');
            $('.openCitaModal').css('text-decoration', 'underline');

            // let table = $('#OrdenesTable').DataTable({
            //     colReorder: {
            //         realtime: true
            //     },
            //     // responsive: true,
            //     // autoFill: true,
            //     // fixedColumns: true,
            //     order: [[0, 'desc']],
            //     dom:    "<'row'<'col-12 mb-2'<'table-title'>>>" +
            //             "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
            //             "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
            //             "<'row'<'col-12'tr>>" +
            //             "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",
            //     buttons: [         
            //         @if (!$tokenValido)
            //         {
            //             text: 'Conectar con Google Calendar',
            //             className: 'btn btn-outline-primary calendarButtonToken mb-2',
            //             action: function () {
            //                 window.location.href = "{{ route('google.redirect') }}";
            //             }
            //         },
            //         @endif
            //         {
            //             text: 'Limpiar Filtros', 
            //             className: 'btn btn-outline-danger limpiarFiltrosBtn mb-2', 
            //             action: function (e, dt, node, config) { 
            //                 clearFiltrosFunction(dt, '#OrdenesTable');
            //             }
            //         }
            //     ],
            //     pageLength: 50,  // Mostrar 50 registros por defecto
            //     lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opciones para seleccionar cantidad de registros
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
            //     columnDefs: [
            //         {
            //             // all targets
            //             targets: '_all',
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
            //         configureInitComplete(this.api(), '#OrdenesTable', 'ORDENES DE TRABAJO', 'warning');
            //     }
            // });

            let table = $('#OrdenesGrid');

            $('.editParteTrabajoTable').css('cursor', 'pointer');
            $('.editParteTrabajoTable').css('text-decoration', 'underline');

            $('.createOrdenbtn').removeClass('dt-button');
            $('.calendarButtonToken').removeClass('dt-button');
            $('.limpiarFiltrosBtn').removeClass('dt-button');

            // table.on('init.dt', function() {
            //     restoreFilters(table, '#OrdenesTable');// Restaurar filtros después de inicializar la tabla
            // });

            // mantenerFilaYsubrayar(table);
            // fastEditForm(table, 'OrdenesTrabajo')

            table.on('dblclick', '.editParteTrabajoTable', function() {
                openLoader();
                const parteId = $(this).data('id');          
                openDetailsParteTrabajoModal(parteId);
            });

            // Abrir detalles del proyecto
            table.on('click','.openProjectDetails', function(event){
                const parteId = $(this).data('parteid');
                getDetailsProject(parteId);
            });

            table.on('dblclick', '.OpenHistorialCliente', function(event){
                const elemento  = $(this);
                const span      = elemento.find('span')[1]
                const parteid   = span.getAttribute('data-parteid');

                getEditCliente(parteid, 'OrdenesTrabajo');
            });

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

            // Detalles

            table.on('click', '.btnOpenDetailsModal', function() {
                $('#modalDetallesOrden').modal('show');

                $('#modalDetallesOrden').on('shown.bs.modal', () => {
                    $('select.form-select').select2({
                        width: '100%',  // Asegura que el select ocupe el 100% del contenedor
                        dropdownParent: $('#modalDetallesOrden')  // Asocia el dropdown con el modal para evitar problemas de superposición
                    });

                });

                let idOrden         = $(this).data('id');
                let asunto          = $(this).data('asunto');
                let fechaAlta       = $(this).data('fecha-alta');
                let fechaVisita     = $(this).data('fecha-visita');
                let estado          = $(this).data('estado');
                let cliente         = $(this).data('cliente');
                let departamento    = $(this).data('departamento');
                let trabajos        = $(this).data('trabajos');
                let operarios       = $(this).data('operarios');
                let observaciones   = $(this).data('observaciones');
                let archivos        = $(this).data('archivos');
                let archivosComentarios = $(this).data('comentarios');

                const imagesContainer = $('#imagesDetails');
                imagesContainer.empty();

                const trabajosArray = trabajos.split(', ');
                const operariosArray = operarios.split(', ');
                const archivosComentariosArray = archivosComentarios.split(', ');

                // Eliminar el último elemento del array, ya que es un string vacío
                trabajosArray.pop();
                operariosArray.pop();
                archivosComentariosArray.pop();

                // Limpiar los select múltiples
                $('#trabajo_idDetails').val(null).trigger('change');
                $('#operario_idDetails').val(null).trigger('change');

                // Asignar los valores a los campos del modal
                $('#detallesOrdenTitle').text(`Detalles de la Orden ${idOrden}`);

                // asignar los valores al select múltiple de trabajos select2
                trabajosArray.forEach(trabajo => {
                    $('#trabajo_idDetails').append(new Option(trabajo, trabajo, true, true));
                });

                // asignar los valores al select múltiple de operarios select2
                operariosArray.forEach(operario => {
                    $('#operario_idDetails').append(new Option(operario, operario, true, true));
                });
                

                $('#asuntoDetails').val(asunto);
                $('#fecha_altaDetails').val(fechaAlta);
                $('#fecha_visitaDetails').val(fechaVisita);
                $('#estadoDetails').val(estado);
                $('#cliente_idDetails').val(cliente);
                $('#departamentoDetails').val(departamento);
                $('#observacionesDetails').val(observaciones);

                // Añadir previsualización de archivos debajo su respectivo comentario
                archivos.forEach((archivo, index) => {
                    const fileWrapper = $(`<div class="file-wrapper"></div>`).css({
                        'display': 'flex',
                        'flex-direction': 'column',
                        'justify-content': 'center',
                        'text-align': 'center',
                        'margin': '10px',
                        'width': '350px',
                        'max-height': '650px',
                        'border': '1px solid #ddd',
                        'padding': '10px',
                        'border-radius': '5px',
                        'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                        'overflow': 'hidden',
                        'gap': '15px',
                        'align-items': 'center',
                        'flex-wrap': 'wrap'
                    });

                    const type = archivo.typeFile;
                    let fileName = '';

                    let url = archivo.pathFile;
                    let serverUrl = 'https://sebcompanyes.com/';
                    let urlModificar = '/home/u657674604/domains/sebcompanyes.com/public_html/';

                    url = url.replace(urlModificar, serverUrl);

                    if (type === 'pdf') {
                        fileName = $(`<embed src="${url}" type="application/pdf" width="350" height="350">`);
                    } else if (type === 'mp4' || type === 'webm' || type === 'ogg') {
                        fileName = $(`<video width=350" height="350" controls><source src="${url}" type="video/${type}"></video>`);
                    } else if (type === 'mp3' || type === 'wav') {
                        fileName = $(`<audio controls><source src="${url}" type="audio/${type}"></audio>`);
                    } else {
                        fileName = $(`<img src="${url}" alt="Archivo ${index + 1}" style="max-width: 350px; max-height: 300px; object-fit: cover">`);
                    }

                    fileName.css('margin-bottom', '15px');

                    const commentBox = $(`<textarea class="form-control mb-2" name="comentario[${index + 1}]" placeholder="Comentario archivo ${index + 1}" rows="2" disabled></textarea>`).val(archivo.comentarios[0].comentarioArchivo);

                    fileName.css('cursor', 'pointer');
                    fileName.on('click', function() {
                        window.open(`${url}`, '_blank');
                    });

                    fileWrapper.append(fileName);
                    fileWrapper.append(commentBox);

                    imagesContainer.append(fileWrapper);
                });

            });

            // Editar

            table.on('click', '.btnOpenEditModal', function() {
                const idOrden = $(this).data('id');
                editOrdenTrabajo(idOrden);
            });

            table.on('dblclick', '.btnOpenEditModalFast', function() {
                const orderId = $(this).data('id');
                editOrdenTrabajo(orderId);
            });

            // Subir archivos y mostrar una vista previa de la imagen o icono si es un archivo

            $('#modalCreateOrden #files1, #modalEditOrden #files1').on('change', function() {
                const files = $(this)[0].files;
                const filesContainer = $('#previewImage1');

                // Añadir previsualización
                previewFiles(files, filesContainer, 0);
            });

            $('#modalCreateOrden #files1, #modalEditOrden #files1').on('click', function(e) {
                // verificar si hay archivos cargados
                if ($('#previewImage1').children().length > 0) {
                    e.preventDefault();
                    alert('Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"');
                    return;
                }
            });


            // Evento para añadir más inputs de archivos
            $('#modalCreateOrden #btnAddFiles, #modalEditOrden #btnAddFiles').on('click', function() {
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
                        const removeBtn = $(`<button type="button" class="btn btn-danger btnRemoveFile">Eliminar</button>`).attr('data-unique-id', uniqueId).attr('data-input-id', `input_${inputIndex}`);

                        fileWrapper.append(img);
                        fileWrapper.append(fileName);
                        fileWrapper.append(commentBox);
                        fileWrapper.append(removeBtn);

                        container.append(fileWrapper);
                    }

                    reader.onerror = function(error) {
                        console.error('Error al leer el archivo:', error);
                    };

                    reader.readAsDataURL(file);
                }
            }

            const calculateTotalSum = (parteTrabajoId = null) => {

                let totalSum = 0;
                $('#createParteTrabajoModal #elementsToShow tr').each(function() {
                    const total = parseFloat($(this).find('.material-total').text());
                    if (!isNaN(total)) {
                        totalSum += total;
                    }
                });

                // verificar si el campo descuento tiene un valor
                const descuento = parseFloat($('#createParteTrabajoModal #descuento').val());
                
                if (!isNaN(descuento)) {
                    totalSum -= totalSum * (descuento / 100);
                }

                $('#createParteTrabajoModal #suma').val(totalSum.toFixed(2));

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
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: 'Suma actualizada correctamente',
                                    howConfirmButton: false,
                                    timer: 1500
                                });
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
                        // $('#precio_hora').val(total.toFixed(2));
                        $('#precio_hora').val(0);
                    }else{
                        const totalDescuento = total - (total * (descuentoCliente / 100));
                        // $('#precio_hora').val(totalDescuento.toFixed(2));
                        $('#precio_hora').val(0);
                        $('#precioHoraHelp').fadeIn().text(`Precio con descuento del ${descuentoCliente}%`);
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

            

            table.on('click', '.createParteTrabajoBtn', function() {

                const canvas = document.getElementById('signature-pad');
                const signaturePad = new SignaturePad(canvas);

                function resizeCanvas() {
                    const canvas = $('#editParteTrabajoModal #signature-pad');
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    
                    // Ajustar el tamaño del canvas al contenedor padre
                    const canvasParentWidth = canvas.parent().width();
                    
                    // Guardar el contenido existente antes de redimensionar
                    const data = signaturePad ? signaturePad.toData() : null;

                    // Establecer el tamaño del canvas con el ratio correcto
                    canvas.width = canvasParentWidth * ratio;
                    canvas.height = 200 * ratio;  // Altura fija
                    
                    // Restaurar el contenido después de redimensionar
                    if (data) {
                        signaturePad.fromData(data);
                    }
                }
                $(window).on('resize', resizeCanvas);
            
                
                // obtener los datos de la orden
                let proyectoid      = $(this).data('proyectoid');
                let idOrden         = $(this).data('id');
                let asunto          = $(this).data('asunto');
                let fechaAlta       = $(this).data('fecha-alta');
                let fechaVisita     = $(this).data('fecha-visita');
                let estado          = $(this).data('estado');
                let cliente         = $(this).data('cliente');
                let departamento    = $(this).data('departamento');
                let trabajos        = $(this).data('trabajoswithid');
                let operarios       = $(this).data('operarios');
                let observaciones   = $(this).data('observaciones');
                let archivos        = $(this).data('archivos');

                let archivosComentarios = $(this).data('comentarios');
                let clienteData         = $(this).data('clientedata');
                let orderData           = $(this).data('ordendata');
                let operariosdata       = $(this).data('operariosdata');
                let operariosids        = $(this).data('operariosids');

                let horaInicio  = orderData.horaInicio;
                let horaFin     = orderData.horaFin;

                if ( !operarios || operarios.length == 0 ) {
                    Swal.fire({
                        icon: 'warning',
                        title: '!Atención!',
                        text: 'No hay operarios asignados a esta orden, por favor edita la orden y asigna un operario o más.',
                    });
                    return;
                }

                $('#createParteTrabajoModal').modal('show');
                $('#createParteTrabajoModal #clienteHelp').text(`Este cliente tiene un descuento del ${clienteData.descuento}%`);

                $('#createParteTrabajoModal').on('shown.bs.modal', () => {
                    if ($('#createParteTrabajoModal select.form-select').data('select2')) {
                        $('#createParteTrabajoModal select.form-select').select2('destroy');
                    }

                    $('#createParteTrabajoModal select.form-select').select2({
                        width: '100%',
                        dropdownParent: $('#createParteTrabajoModal')
                    });

                    // hacer que todos los textarea sean redimensionables
                    $('#createParteTrabajoModal textarea').each(function() {
                        $(this).css('height', 'auto');
                        $(this).height(this.scrollHeight);

                        $(this).on('input', function() {
                            this.style.height = 'auto';
                            this.style.height = (this.scrollHeight) + 'px';
                        });

                    });

                });

                // cambiar los options de trabajo por las opciones del array de trabajos
                $('#createParteTrabajoModal #trabajo_id').empty();

                // Limpiar las imagenes de la vista previa
                $('#createParteTrabajoModal #imagesDetails').empty();

                // Resetear los inputs de archivos
                $('#createParteTrabajoModal #files1').val('');  // Resetear el input principal de archivos
                $('#createParteTrabajoModal #previewImage1').empty();

                // Limpiar los inputs de archivos adicionales
                $('#createParteTrabajoModal #inputsToUploadFilesContainer').empty();

                trabajos.forEach(trabajo => {
                    //obtener el id del trabajo que se encuentra entre paréntesis
                    let idTrabajo = trabajo.idTrabajo;
                    trabajo = trabajo.nameTrabajo;

                    $('#createParteTrabajoModal #trabajo_id').append(new Option(trabajo, idTrabajo, true, true)).trigger('change');

                });

                // asignar los valores a los campos del modal

                if ( proyectoid ) {

                    // verificar si el select de citas pendientes está visible
                    $('#createParteTrabajoModal #citasPendigSelect').parent().show();
                    $('#createParteTrabajoModal #citasPendigSelect').val(proyectoid).trigger('change');

                }else{
                    // si no hay proyecto asignado al parte de trabajo. ocultar el select de citas pendientes
                    $('#createParteTrabajoModal #citasPendigSelect').parent().hide();
                }

                $('#createParteTrabajoModal #ordenId').val('');

                $('#createParteTrabajoModal #parteTrabajo_id').val(idOrden);
                $('#createParteTrabajoModal #asunto').val(asunto);
                $('#createParteTrabajoModal #fecha_alta').val(fechaAlta);
                $('#createParteTrabajoModal #fecha_visita').val(fechaVisita || new Date().toISOString().split('T')[0]);
                $('#createParteTrabajoModal #estado').val(2);
                $('#createParteTrabajoModal #cliente_id').val(cliente);
                $('#createParteTrabajoModal #departamento').val(departamento);
                $('#createParteTrabajoModal #observaciones').val(observaciones);
                $('#createParteTrabajoModal #ordenId').val(idOrden);

                // autocompletar los operarios asignados a la orden
                $('#createParteTrabajoModal #operario_id').val('').trigger('change');
                
                $('#createParteTrabajoModal #operario_id').val(
                    // buscar los operarios que el usuario tiene asignados
                    operariosids.map(operario => {
                        return operario.idOperario;
                    })

                ).trigger('change');

                let valorHoraAcumulado = 0;

                operariosdata.forEach(operario => {
                    valorHoraAcumulado += parseFloat(operario.salario_hora);
                });

                $('#createParteTrabajoModal #precio_hora').val(valorHoraAcumulado.toFixed(2));

                if( horaInicio || horaFin ){
                    $('#createParteTrabajoModal #hora_inicio').val(horaInicio);
                    $('#createParteTrabajoModal #hora_fin').val(horaFin);
                }

                if ( horaInicio && horaFin ) {
                    calculateDifHours(
                        '#createParteTrabajoModal #hora_inicio', 
                        '#createParteTrabajoModal #hora_fin', 
                        '#createParteTrabajoModal #horas_trabajadas',
                        valorHoraAcumulado,
                        clienteData.descuento
                    );
                }

                $('#createParteTrabajoModal #cliente_id').on('change', function() {
                    $(this).val(cliente).trigger('change');
                });

                $('#createParteTrabajoModal #hora_inicio').on('change', function() {
                    calculateDifHours(
                        this, 
                        '#createParteTrabajoModal #hora_fin', 
                        '#createParteTrabajoModal #horas_trabajadas',
                        valorHoraAcumulado,
                        clienteData.descuento
                    );
                    
                });

                $('#createParteTrabajoModal #hora_fin').on('change', function() {
                    calculateDifHours(
                        '#createParteTrabajoModal #hora_inicio', 
                        this, 
                        '#createParteTrabajoModal #horas_trabajadas',
                        valorHoraAcumulado,
                        clienteData.descuento
                    );
                });

                // Añadir previsualización de archivos debajo su respectivo comentario
                const imagesContainer = $('#createParteTrabajoModal #imagesDetails');

                imagesContainer.empty();

                archivos.forEach((archivo, index) => {

                    // mostrar vista previa de los archivos img/video/audio/pdf

                    const fileWrapper = $(`<div class="file-wrapper"></div>`).css({
                        'display': 'flex',
                        'flex-direction': 'column',
                        'justify-content': 'center',
                        'text-align': 'center',
                        'margin': '10px',
                        'width': '350px',
                        'max-height': '650px',
                        'border': '1px solid #ddd',
                        'padding': '10px',
                        'border-radius': '5px',
                        'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                        'overflow': 'hidden',
                        'gap': '15px',
                        'align-items': 'center',
                        'flex-wrap': 'wrap'
                    });

                    const type = archivo.typeFile;
                    let fileName = '';

                    let url = archivo.pathFile;

                    url = globalBaseUrl + url;

                    if (type === 'pdf') {
                        fileName = $(`<embed src="${url}" type="application/pdf" width="350" height="350">`);
                    } else if (type === 'mp4' || type === 'webm' || type === 'ogg') {
                        fileName = $(`<video width=350" height="350" controls><source src="${url}" type="video/${type}"></video>`);
                    } else if (type === 'mp3' || type === 'wav') {
                        fileName = $(`<audio controls><source src="${url}" type="audio/${type}"></audio>`);
                    } else {
                        fileName = $(`<img src="${url}" alt="Archivo ${index + 1}" style="max-width: 350px; max-height: 300px; object-fit: cover">`);
                    }

                    fileName.css('margin-bottom', '15px');

                    const commentBox = $(`<textarea class="form-control mb-2" name="comentario[${index + 1}]" placeholder="Comentario archivo ${index + 1}" rows="2" disabled></textarea>`).val(archivo.comentarios[0].comentarioArchivo);

                    fileName.css('cursor', 'pointer');
                    fileName.on('click', function() {
                        window.open(`${url}`, '_blank');
                    });

                    fileWrapper.append(fileName);
                    fileWrapper.append(commentBox);

                    imagesContainer.append(fileWrapper);
                });

                // Botón para limpiar la firma
                $('#clear-signature').click(function(event) {
                    event.preventDefault();
                    signaturePad.clear();
                });

                resizeCanvas();

                $('#unlock-signature').on('dblclick', function () {
                    const canvas = $('#signature-pad');
                    $(this).hide();  // Ocultar el mensaje de desbloqueo
                    canvas.show();   // Mostrar el canvas
                    $('#clear-signature').prop('disabled', false);  // Habilitar el botón de limpiar
                });
                
            });

            $('#createParteTrabajoModal #files1').on('change', function() {
                console.log('Cambio detectado en input de archivos');
                const files = $(this)[0].files;
                const filesContainer = $('#createParteTrabajoModal #previewImage1');

                // Evita la duplicación de archivos reiniciando el contenedor
                filesContainer.empty();  // Limpiar el contenedor antes de previsualizar nuevos archivos
                previewFilesParte(files, filesContainer, 0);
            });

            $('#createParteTrabajoModal #files1').on('click', function(e) {
                if ($('#previewImage1').children().length > 0) {
                    e.preventDefault();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }
            });

            $('#createParteTrabajoModal #btnAddFiles').on('click', function() {
                const newInputContainer = $('<div class="form-group col-md-12"></div>');
                const inputIndex = $('#inputsToUploadFilesContainer input').length + 1;
                const newInputId = `input_${inputIndex}`;

                if (inputIndex >= 5) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'No puedes añadir más de 5 archivos',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }
                
                const newInput = $(`<input type="file" class="form-control" name="file[]" id="${newInputId}" accept="image/*">`);
                newInputContainer.append(newInput);
                $('#createParteTrabajoModal #inputsToUploadFilesContainer').append(newInputContainer);

                newInput.on('change', function() {
                    const files = $(this)[0].files;
                    const filesContainer = $('#createParteTrabajoModal #previewImage1');
                    console.log(files);
                    previewFilesParte(files, filesContainer, inputIndex);
                });

                newInput.on('click', function(e) {
                    if ($('#previewImage1').children().length > inputIndex) {
                        e.preventDefault();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'warning',
                            title: 'Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        return;
                    }
                });
            });

            $(document).on('click', '#createParteTrabajoModal .btnRemoveFile', function() {
                const uniqueId = $(this).data('unique-id');
                const inputId = $(this).data('input-id');

                $(`#preview_${uniqueId}`).remove();

                if (inputId) {
                    $(`#${inputId}`).remove();
                    fileCounterParte--;

                    $('#inputsToUploadFilesContainer input').each(function(index, input) {
                        const newIndex = index + 1;
                        $(input).attr('id', `input_${newIndex}`);
                        $(input).attr('name', `file_${newIndex}`);
                        $(input).attr('data-input-index', newIndex);
                        $(input).attr('placeholder', `comentario${newIndex}`);
                    });
                }
            });

            $('#createParteTrabajoModal #addNewMaterial').on('click', function() {
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
                                        <small class="text-muted addDatasetToShowImages">Ver imagenes</small>
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

                $('#newMaterialsContainer').append(newMaterial);

                //INICIALIZAR LOS SELECT2
                $('#createParteTrabajoModal select.form-select').select2({
                    width: '100%',
                    dropdownParent: $('#createParteTrabajoModal')
                });
                
                $('#editParteTrabajoModal .addDatasetToShowImages').hide();

                // evento doble click para mostrar las imagenes del articulo
                $('#editParteTrabajoModal .addDatasetToShowImages').off('dblclick').on('dblclick', function() {
                    const idArticulo = $(this).data('id');
                    const nameArticulo = $(this).data('nameart');

                    getImagesArticulos(idArticulo, nameArticulo);
                });

                $('#newMaterialsContainer').on('change', `#articulo_id${materialCounter}`, function () {
                    const articuloId = $(this).val();
                    const form = $(this).closest('form');
                    const precioSinIvaInput = form.find('.precioSinIva');
                    const cantidadInput = form.find('.cantidad');
                    const totalInput = form.find('.total');
                    const descuentoInput = form.find('.descuento');

                    $.ajax({
                        url: "/admin/articulos/getStock/" + articuloId,
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

                                if (response.stock.cantidad <= 0) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'No hay stock disponible para este artículo',
                                    });
                                    $(`#articulo_id${materialCounter}`).val('');
                                    return;
                                }

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

                                    trazabilidad = 'Recurrente';

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

                                // verificar si el articulo tiene imagenes
                                const articuloImagenes = response.stock.articulo.imagenes;

                                if ( articuloImagenes.length > 0 ) {
                                    // mostrar el small
                                    $('.addDatasetToShowImages').removeClass('d-none').show();

                                    $('#editParteTrabajoModal .addDatasetToShowImages').css('cursor', 'pointer', '!important');
                                    $('#editParteTrabajoModal .addDatasetToShowImages').css('text-decoration', 'underline', '!important');

                                    // evento doble click para mostrar las imagenes del articulo
                                    $('#editParteTrabajoModal .addDatasetToShowImages').off('dblclick').on('dblclick', function() {
                                        const idArticulo = $(this).data('id');
                                        const nameArticulo = $(this).data('nameart');

                                        getImagesArticulos(idArticulo, nameArticulo);
                                    });

                                }else{
                                    $('.addDatasetToShowImages').addClass('d-none').hide();
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: '¿Quieres Utilizar este artículo?',
                                    text: `Nombre: ${response.stock.articulo.nombreArticulo} \n, Stock actual: ${response.stock.cantidad} \n Precio: ${response.stock.articulo.ptsVenta}€ \n trazabilidad: ${trazabilidad} \n Con fecha de compra: ${response.stock.ultimaCompraDate}`,
                                    showCancelButton: true,
                                    confirmButtonText: `Si`,
                                    cancelButtonText: `No`,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const venta = Number(response.stock.articulo.ptsVenta);
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

                    // const articulo = Articulos.find(art => art.idArticulo === parseInt(articuloId));
            
                    // if (articulo) {
                    //     precioSinIvaInput.val(articulo.precio).attr('disabled', false);
                    //     cantidadInput.attr('disabled', false);
                    //     descuentoInput.attr('disabled', false);
                    //     totalInput.val(cantidadInput.val() * articulo.precio);
                    // }
                });

                $('#newMaterialsContainer').on('change', `#cantidad${materialCounter}`, function () {
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

                $('#newMaterialsContainer').on('change', `#precioSinIva${materialCounter}`, function () {
                    const precio = parseFloat($(this).val());
                    const form = $(this).closest('form');
                    const cantidad = parseFloat(form.find('.cantidad').val());
                    const descuentoInput = parseFloat(form.find('.descuento').val());
                    const totalInput = form.find('.total');

                    let total = 0;

                    if ( descuentoInput !== 0 ) {
                        const lineaDescuento = (descuentoInput * (precio * cantidad)) / 100;
                        total = (precio * cantidad) - lineaDescuento;
                        totalInput.val(total);
                        return;
                    }

                    if ( descuentoInput === 0 ) {
                        total = precio * cantidad;
                    }

                    totalInput.val(total);
                    return;
                });

                $('#newMaterialsContainer').on('change', `#descuento${materialCounter}`, function () {
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
            });

            $('#createParteTrabajoModal #collapseMaterialesEmpleados').on('click', '.saveMaterial', function () {
                const materialNumber = $(this).data('material');
                const form = $(`#AddNewMaterialForm${materialNumber}`);
                const articuloId = form.find(`#articulo_id${materialNumber}`).val();
                const cantidad = parseFloat(form.find(`#cantidad${materialNumber}`).val());
                const precioSinIva = parseFloat(form.find(`#precioSinIva${materialNumber}`).val());
                const descuento = parseFloat(form.find(`#descuento${materialNumber}`).val());
                const total = parseFloat(form.find(`#total${materialNumber}`).val());

                if (!articuloId || isNaN(cantidad) || isNaN(precioSinIva) || isNaN(descuento) || isNaN(total)) {
                    alert('Todos los campos son requeridos y deben tener valores válidos');
                    return;
                }

                const nombreArticulo = $(`#articulo_id${materialNumber} option:selected`).data('namearticulo');
                
                form.remove();

                $.ajax({
                    url: "{{ route('admin.lineaspartes.store') }}",
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
                            
                            const linea = response.linea;

                            // Calcular el beneficio teniendo en cuenta el descuento
                            let precioFinal = linea.descuento 
                                ? linea.precioSinIva * (1 - linea.descuento / 100) 
                                : linea.precioSinIva;

                            let beneficio = (precioFinal - linea.articulo.ptsCosto) * linea.cantidad;

                            // Evitar división por cero
                            let totalPrecioVenta = precioFinal * linea.cantidad;
                            let beneficioPorcentaje = totalPrecioVenta > 0 
                                ? (beneficio / totalPrecioVenta) * 100 
                                : 0;

                            const newRow = `
                            <tr
                                id="material_${response.linea.idMaterial}"
                            >
                                <td>${response.linea.idMaterial}</td>
                                <td>${nombreArticulo}</td>
                                <td>${cantidad}</td>
                                <td>${formatPrice(precioSinIva)}</td>
                                <td>${descuento}</td>
                                <td class="material-total">${formatPrice(total)}</td>
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

                            $(`#deleteMaterial${materialNumber}`).attr('data-id', response.linea.idMaterial);
                            $(`#deleteMaterial${materialNumber}`).attr('data-row', response.linea.idMaterial);
                            $(`#materialRow${materialNumber}`).attr('data-id', response.linea.idMaterial);

                            $('#createParteTrabajoModal #elementsToShow').append(newRow);

                            calculateTotalSum(parteTrabajoId);
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

            $('#createParteTrabajoModal #collapseMaterialesEmpleados').on('click', '.deleteMaterial', function(event){
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
                            url: "{{ route('admin.lineaspartes.destroy') }}",
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

            $('#createParteTrabajoModal #elementsToShow').off('click', '.btnRemoveMaterial').on('click', '.btnRemoveMaterial', function() {
                            
                const linea = $(this).data('linea');
                const rowId = `#elementsToShow #material_${linea.idMaterial}`;
                const row   = $(rowId);
                const lineaId = linea.idMaterial;
                const articuloId = linea.articulo.idArticulo || linea.articulo_id;
                const cantidad = linea.cantidad;

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
                            url: "{{ route('admin.lineaspartes.destroy') }}",
                            method: 'POST',
                            data: {
                                articulo_id: articuloId,
                                lineaId: lineaId,
                                cantidad,
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

            $('#createParteTrabajoModal #elementsToShow').off('click', '.btnEditMaterial');

            $('#createParteTrabajoModal #elementsToShow').on('click', '.btnEditMaterial', function() {
                const linea = $(this).data('linea');
                const row   = $(this).closest('tr');
                const lineaId = linea.idMaterial;
                const articuloId = linea.articulo.idArticulo || linea.articulo_id;

                // abrir modal para editar la linea de material
                $('#editMaterialLineModal').modal('show');

                $('#editMaterialLineModal #editMaterialLineTitle').text(`Editar Línea de Material No. ${lineaId}`);
                $('#editMaterialLineModal #formEditMaterialLine')[0].reset();


                $('#editMaterialLineModal #material_id').val(articuloId);
                $('#editMaterialLineModal #cantidad').val(linea.cantidad);
                $('#editMaterialLineModal #precio').val(linea.precioSinIva);
                $('#editMaterialLineModal #descuento').val(linea.descuento);
                $('#editMaterialLineModal #total').val(linea.total);
                $('#editMaterialLineModal #lineaId').val(lineaId);

            });

            // dejar de escuchar el evento del material seleccionado
            $('#editParteTrabajoModal #material_id').off('change');

            $('#editMaterialLineModal #material_id').on('change', function() {
                openLoader();
                const articuloId = $(this).val();
                const precioSinIvaInput = $('#editMaterialLineModal #precio');
                const cantidadInput = $('#editMaterialLineModal #cantidad');
                const totalInput = $('#editMaterialLineModal #total');
                const descuentoInput = $('#editMaterialLineModal #descuento');
                @if (isset($articulos))
                    let Articulos = @json($articulos);
                @endif
                
                $.ajax({
                    url: "/admin/articulos/getStock/" + articuloId,
                    method: 'GET',
                    data: {
                        articulo_id: articuloId,
                    },
                    success: function(response) {
                        closeLoader();
                        if (response.success) {
                            if (response.stock.cantidad <= 0) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No hay stock disponible para este artículo',
                                });
                                $('#editMaterialLineModal #material_id').val('');
                                return;
                            }
                            const venta = Number(response.stock.articulo.ptsVenta);
                            precioSinIvaInput.val(venta.toFixed(2));
                            totalInput.val(venta.toFixed(2));
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
                const select    = $('#editMaterialLineModal #material_id').find(':selected').text();

                // extraer el stock del select TEST | EMP-03-FACPRUEBA -33 | stock: 2
                let stock = select.split('|').pop().trim().split(':').pop().trim();
                stock = parseInt(stock);

                if ( cantidad > stock ) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'La cantidad no puede ser mayor al stock disponible',
                    });
                    $(this).val(stock);
                }

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

                $('#editMaterialLineModal #total').val(total.toFixed(2));
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

                $('#editMaterialLineModal #total').val(total.toFixed(2));
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

                $('#editMaterialLineModal #total').val(total.toFixed(2));
            });

            $('#editMaterialLineModal #saveEditMaterialLineBtn').off('click').on('click', function() {
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
                    url: "{{ route('admin.lineaspartes.update', ':lineaId') }}".replace(':lineaId', lineaId),
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
                            
                            beneficio = parseFloat(beneficio);

                            // Actualizar la fila de la tabla
                            const updatedRow = `
                                <td>${linea.idMaterial}</td>
                                <td>${linea.articulo.nombreArticulo}</td>
                                <td>${linea.cantidad}</td>
                                <td>${formatPrice(linea.precioSinIva)}</td>
                                <td>${linea.descuento}</td>
                                <td 
                                    class="material-total"
                                    data-precio="${linea.total}"
                                >
                                    ${formatPrice(linea.total)}
                                </td>
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
                            `;

                            // Verificar que el elemento existe
                            const materialElement = $(`#createParteTrabajoModal #elementsToShow #material_${linea.idMaterial}`);

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

            $('#createParteTrabajoModal #btnCreateOrdenButton').off('click').on('click', function(event) {
                event.preventDefault();
                const formData = new FormData($('#createParteTrabajoModal #formCreateOrden')[0]);

                const files = $('#createParteTrabajoModal #formCreateOrden input[type="file"]');

                for (let i = 0; i < files.length; i++) {
                    const input = files[i];
                    const inputName = $(input).attr('name')+'parte';
                    const filesToUpload = input.files;

                    for (let j = 0; j < filesToUpload.length; j++) {
                        formData.append(inputName, filesToUpload[j]);
                    }
                }

                if (
                    !formData.get('asunto')         || 
                    !formData.get('fecha_alta')     || 
                    !formData.get('fecha_visita')   || 
                    !formData.get('estado')         || 
                    !formData.get('cliente_id')     || 
                    !formData.get('suma')           || 
                    !formData.get('trabajo_id')
                ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Todos los campos son requeridos',
                    });
                    return;
                }

                const signaturePad  = document.getElementById('signature-pad');
                const signatureData = signaturePad.toDataURL();
                const getNameFirma  = $('#createParteTrabajoModal #cliente_firmaid').val();

                formData.append('signature', signatureData);
                formData.append('nombre_firmante', getNameFirma);

                formData.append('_token', "{{ csrf_token() }}");

                // Realizar la solicitud AJAX
                $.ajax({
                    url: "{{ route('admin.partes.store') }}",
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
                                title: 'Parte de trabajo creada correctamente',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            Articulos       = response.articulos;
                            parteTrabajoId  = response.parteTrabajoId;

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
                        $('#btnCreateOrdenButton').attr('disabled', false); 
                        closeLoader();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo salió mal',
                        });
                    }
                });
            });

            $('#createParteTrabajoModal #solucion, #createParteTrabajoModal #observaciones').on('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

            $('.openCitaModal').css('cursor', 'pointer', 'text-decoration', 'underline');

            table.on('dblclick', '.openCitaModal', function() {
                $('#editCitaModal').modal('show');
                const citaId = $(this).data('order');
                editarCitaAjax(citaId);
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

                // inicializar select2
                $('#editCitaModal select.form-select').select2({
                    width: '100%',
                    dropdownParent: $('#editCitaModal')
                });

            });

            $('#modalEditOrden').on('shown.bs.modal', function () {
                let textarea = $('#modalEditOrden #asuntoEdit');
                
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

            $('#createParteTrabajoModal').on('shown.bs.modal', function () {
                let textarea = $('#createParteTrabajoModal #asunto');
                
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

            $('#createParteTrabajoModal').on('hidden.bs.modal', function () {
                if ($('#createParteTrabajoModal #elementsToShow tr').length > 0) {
                    $('#createParteTrabajoModal #elementsToShow tr').remove();

                    const parteTrabajoId = $('#createParteTrabajoModal #ordenId').val();

                    $.ajax({
                        url: "{{ route('admin.partes.sendTelegram') }}",
                        method: 'POST',
                        data: {
                            parteId: parteTrabajoId,
                            _token: "{{ csrf_token() }}"
                        },
                        beforeSend: function() {
                            openLoader();
                        },
                        success: function(response) {
                            console.log(response); // Asegúrate de ver la respuesta aquí
                            if (response.success) {
                                closeLoader();
                                showToastr('success', response.message, 'Éxito');
                                window.location.reload();
                            } else {
                                closeLoader();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                            }
                        },
                        error: function(err) {
                            closeLoader();
                            console.error(err);
                            Swal.fire({
                                icon: 'warning',
                                title: '!Advertencia¡',
                                text: 'Algo salió mal enviando la copia del pdf al canal de telegram, el parte de trabajo se ha creado correctamente',
                            });
                        }
                    });
                }
            });

            $('#editMaterialLineModal').on('shown.bs.modal', function (event) {
                $('#editMaterialLineModal .form-select').each(function() {
                    $(this).select2({
                        width: '100%',
                        dropdownParent: $('#editMaterialLineModal')
                    });
                });
            });

            calculateTotalSum();
        
    
        });
      
    </script>
@stop
