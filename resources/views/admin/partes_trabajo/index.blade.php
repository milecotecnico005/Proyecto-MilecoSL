@extends('adminlte::page')

@section('title', 'Partes de trabajo')

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
            border: 1px solid rgb(63, 150, 250)
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

        @media (max-width: 768px) {
            table {
                font-size: 10px !important;
            }
        }

    </style>

    <div id="tableCard" class="card">

        <button type="button" style="max-width: 200px" class="btn btn-outline-success createParteTrabajoBtn d-none"></button>
        <button type="button" style="max-width: 200px" class="btn btn-primary d-none" id="venderVariosBtn"></button>
        <button type="button" style="max-width: 200px" data-partes="{{ json_encode($partes_trabajo) }}" class="btn btn-success d-none" id="confirmVentaModal"></button>

        <div class="card-body">

            <div id="PartesGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>

            {{-- <table id="partes_trabajo" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="select-column">Seleccionar</th>
                        <th>Orden</th>
                        <th>Parte</th>
                        <th>Proyecto</th>
                        <th>F.Alta</th>
                        <th>F.Visita</th>
                        <th>Cliente</th>
                        <th>Dto.</th>
                        <th>Asunto</th>
                        <th>Solución</th>
                        <th>Estado</th>
                        <th>E.Venta</th>
                        <th>Total</th>
                        <th>Trabajo</th>
                        <th>H.i</th>
                        <th>H.f</th>
                        <th>Tiempo</th>
                        <th>Observaciones</th>
                        <th>notas1</th>
                        <th>notas2</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($partes_trabajo as $parte)
                        @php
                            if ($parte->orden) {
                                $orden = $parte->orden->idOrdenTrabajo;
                            } else {
                                $orden = "";
                            }
                                                        
                        @endphp
                        <tr data-parteid="{{ $parte->idParteTrabajo }}" class="mantenerPulsadoParaSubrayar">
                            <td 
                                data-tdparte="{{ $parte->idParteTrabajo }}" 
                                class="d-flex justify-content-center align-items-center checkboxesColumn"
                                style="height: 150px;">
                                <input type="checkbox" class="form-check-input" name="parteTrabajo[]" value="{{ $parte->idParteTrabajo }}">
                            </td>
                            <td
                                class="showOrdenBtn"
                                data-id="{{ $orden }}"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Ver orden"
                            >{{ $orden }}</td>
                            <td
                                class="editParteTrabajoTable"
                                data-id="{{ $parte->idParteTrabajo }}"
                            >{{ $parte->idParteTrabajo }}</td>
                            <td
                                @if (isset($parte->proyectoNMN) && count($parte->proyectoNMN) > 0)
                                    data-proyectoid="{{ $parte->proyectoNMN[0]->proyecto->idProyecto }}"
                                    data-parteid="{{ $parte->idParteTrabajo }}"
                                    class="openProjectDetails"
                                    data-fulltext="{{ $parte->proyectoNMN[0]->proyecto->name }}"
                                @endif
                            >
                                @if (isset($parte->proyectoNMN) && count($parte->proyectoNMN) > 0)
                                    <span 
                                        class="badge badge-pill badge-info text-truncate badgeProject"
                                        data-fulltext="{{ $parte->proyectoNMN[0]->proyecto->name }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="{{ $parte->proyectoNMN[0]->proyecto->name }}"
                                    >
                                        {{ Str::limit($parte->proyectoNMN[0]->proyecto->name, 5) }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ formatDate($parte->FechaAlta) }}</td>
                            <td>{{ formatDate($parte->FechaVisita) }}</td>
                            <td
                                data-fulltext="{{ $parte->cliente->NombreCliente. ' ' .$parte->cliente->ApellidosCliente }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $parte->cliente->NombreCliente }}"
                                class="text-truncate"
                            >{{ Str::limit($parte->cliente->NombreCliente.' '.$parte->cliente->ApellidosCliente, 10) }}</td>
                            <td
                                data-fulltext="{{ $parte->Departamento }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $parte->Departamento }}"
                                class="text-truncate openqQuickEdit"
                                data-fieldName="Departamento"
                                data-type="text"
                                data-parteid="{{ $parte->idParteTrabajo }}"
                            >{{ Str::limit($parte->Departamento, 10) }}</td>
                            <td
                                data-fulltext="{{ $parte->Asunto }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $parte->Asunto }}"
                                class="text-truncate openqQuickEdit"
                                data-parteid="{{ $parte->idParteTrabajo }}"
                                data-fieldName="Asunto"
                                data-type="text"
                            >{{ Str::limit($parte->Asunto, 10) }}</td>
                            <td
                                data-fulltext="{{ $parte->solucion }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $parte->solucion }}"
                                class="text-truncate openqQuickEdit"
                                data-fieldName="solucion"
                                data-type="text"
                                data-parteid="{{ $parte->idParteTrabajo }}"
                            >
                                @if ($parte->solucion)
                                    {{ Str::limit($parte->solucion, 10) }}
                                @else
                                    Sin solución
                                @endif
                            </td>
                            
                            <td>
                                @if ($parte->Estado == 1)
                                    <span class="badge badge-warning">Pendiente</span>
                                @elseif ($parte->Estado == 2)
                                    <span class="badge badge-primary">En proceso</span>
                                @else
                                    <span class="badge badge-success">Finalizado</span>
                                @endif
                            </td>
                            <td>
                                @if ($parte->estadoVenta == 1)
                                    <span class="badge badge-warning">No vendido</span>
                                @elseif ($parte->estadoVenta == 2)
                                    <span class="badge badge-success">Vendido</span>
                                @endif
                            </td>
                            <td>
                                @if ($parte->suma)
                                    {{ number_format($parte->suma, 2, ',', '.') }}€
                                @else
                                    0€
                                @endif
                            </td>
                            <td
                                data-fulltext="{{ $parte->trabajo->nameTrabajo }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $parte->trabajo->nameTrabajo }}"
                                class="text-truncate"
                            >
                                {{ Str::limit($parte->trabajo->nameTrabajo, 10) }}
                            </td>
                            <td>{{ $parte->hora_inicio }}</td>
                            <td>{{ $parte->hora_fin }}</td>
                            <td>{{ $parte->horas_trabajadas }}</td>
                            <td
                                data-fulltext="{{ $parte->Observaciones }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $parte->Observaciones }}"
                                class="text-truncate openqQuickEdit"
                                data-fieldName="Observaciones"
                                data-type="text"
                                data-parteid="{{ $parte->idParteTrabajo }}"
                            >
                                @if ($parte->Observaciones)
                                    
                                    {{ Str::limit($parte->Observaciones, 10) }}
                                @endif
                            </td>
                            <td
                                data-fulltext="{{ $parte->notas1 }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $parte->notas1 }}"
                                class="text-truncate openqQuickEdit"
                                data-fieldName="notas1"
                                data-type="text"
                                data-parteid="{{ $parte->idParteTrabajo }}"
                                >
                                @if ($parte->notas1)
                                    {{ Str::limit($parte->notas1, 10) }}
                                @endif
                            </td>
                            <td
                                data-fulltext="{{ $parte->notas2 }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $parte->notas2 }}"
                                class="text-truncate openqQuickEdit"
                                data-fieldName="notas2"
                                data-type="text"
                                data-parteid="{{ $parte->idParteTrabajo }}"
                            >
                                @if ($parte->notas2)
                                    {{ Str::limit($parte->notas2, 10) }}
                                @endif
                            </td>
                            
                        </tr> --}}
                    {{-- @endforeach --}}
                {{-- </tbody>
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

    @component('components.modal-component', [
        'modalId' => 'createParteTrabajoModal',
        'modalTitle' => 'Crear Parte de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveParteTrabajoBtn',
        'disabledSaveBtn' => true
    ])
        @include('admin.partes_trabajo.form')
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

    @component('components.modal-component', [
        'modalId' => 'detailsParteTrabajoModal',
        'modalTitle' => 'Detalles de la Parte de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'closeDetailsParteTrabajoBtn',
        'modalTitleId' => 'detailsParteTrabajoTitle',
        'disabledSaveBtn' => true,
        'hideButton' => true
    ])
        @include('admin.partes_trabajo.form', ['disabled' => true])
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'confirmVentaModalMod',
        'modalTitle' => 'Confirmar Venta',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'confirmVentaModalBtn',
    ])

        <div class="row">
            <div class="col-md-12">
                <h3>¿Estás seguro de querer vender los partes seleccionados?</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table id="partesSeleccionados" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Orden No.</th>
                            <th>Proyecto</th>
                            <th>Fecha de Alta</th>
                            <th>Fecha de Visita</th>
                            <th>Cliente</th>
                        </tr>
                    </thead>
                    <tbody id="partesToShowFiltered">
                        
                        
                    </tbody>
                </table>
            </div>
        </div>

        
    @endcomponent

    {{-- Modal para detalles de la orden --}}
    @component('components.modal-component', [
        'modalId' => 'modalEditOrden',
        'modalTitle' => 'Editar Orden',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editOrdenTitle',
        'btnSaveId' => 'btnEditOrden',
    ])
        <form id="formEditOrden" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="orden_id" id="orden_id">
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
                    <select id="estadoEdit" name="estado" class="form-select">
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

    <!-- Modal para Crear Orden -->
    @component('components.modal-component', [
        'modalId' => 'modalCreateOrden',
        'modalTitle' => 'Crear Orden',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'createOrdenTitle',
        'btnSaveId' => 'btnCreateOrden'
    ])
        <form id="formCreateOrden" action="{{ route('admin.ordenes.createOrderByParte') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="parte_id" id="parte_id">
            <input type="hidden" name="orden_id" id="orden_id">
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
                    <label class="form-label" for="fecha_visita">Fecha de Visita</label>
                    <input type="date" class="form-control" id="fecha_visita" name="fecha_visita">
                </div>
                <div class="form-group col-md-6 required-field">
                    <label class="form-label" for="estado">Estado</label>
                    <select id="estado" name="estado" class="form-control">
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
                    <label class="form-label" for="hora_inicio">Hora de inicio</label>
                    <input type="time" class="form-control" id="hora_inicio" name="hora_inicio">
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label" for="hora_fin">Hora de fin</label>
                    <input type="time" class="form-control" id="hora_fin" name="hora_fin">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-6 required-field">
                    <label class="form-label" for="cliente_id">Cliente</label>
                    <select id="cliente_id" name="cliente_id" class="form-select">
                        @foreach ($clientes as $cliente )
                            
                            <option value="{{ $cliente->idClientes }}">{{ $cliente->NombreCliente }} {{ $cliente->ApellidoCliente }}</option>
                    
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6 required-field">
                    <label class="form-label" for="departamento">Departamento</label>
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
                    <label class="form-label" for="operario_id">Operario/s</label>
                    <select id="operario_id" multiple name="operario_id[]" class="form-select">
                        @foreach ($operarios as $operario )
                            <option value="{{ $operario->idOperario }}">{{ $operario->nameOperario }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row required-field">
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
                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
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
                        @foreach ($articulosTodos as $articulo)
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

    {{-- Modal para mostrar las imagenes de un articulo --}}
    @component('components.modal-component',[
        'modalId' => 'showImagesArticuloModal',
        'modalTitleId' => 'showImagesModalLabel',
        'modalTitle' => 'Imágenes del articulo',
        'modalSize' => 'modal-xl',
        'hideButton' => true,
    ])

        <div class="row col-sm-12" id="showImages">

        </div>
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'showReportModal',
        'modalTitle' => 'Generar Informe',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'generateReportBtn',
        'nameButtonSave' => 'Generar Informe'
    ])

        {{-- Se debe generar un informe de tiempos y con un rango de fechas determinado --}}
        <form
            action="{{ route('admin.partes.generateReport') }}"
            method="POST"
            id="generateReportForm"
        >
            @csrf
            <div class="row mb-2">
                <div class="col-md-6 mb-2">
                    <label for="fechaInicio">Fecha de inicio</label>
                    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
                </div>
                <div class="col-md-6 mb-2">
                    <label for="fechaFin">Fecha de fin</label>
                    <input type="date" class="form-control" id="fechaFin" name="fechaFin">
                </div>
            </div>
    
            <div class="row">
                <div class="col-md-12">
                    <label for="users_id">Operarios</label>
                    <select name="users_id[]" id="users_id" class="form-select" multiple>
                        <option value="0" selected>Todos los usuarios</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'showReportModalInAGGRID',
        'modalTitle' => 'Itinerario',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'generateReportBtnAGGRID',
        'nameButtonSave' => 'Generar Itinerario'
    ])

        <div class="row mb-2">
            <div class="col-md-6 mb-2">
                <label for="fechaInicio">Fecha de inicio</label>
                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
            </div>
            <div class="col-md-6 mb-2">
                <label for="fechaFin">Fecha de fin</label>
                <input type="date" class="form-control" id="fechaFin" name="fechaFin">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label for="users_id">Operarios</label>
                <select name="users_id[]" id="users_id" class="form-select" 
                    @if (!$isAdmin) disabled @endif>
                    @if ($isAdmin)
                        <option 
                            value="0" 
                            data-alluser="{{ json_encode($users) }}" 
                            selected>
                            Todos los usuarios
                        </option>
                        @foreach ($users as $user)
                            <option 
                                value="{{ $user->id }}" 
                                data-nameoperario="{{ $user->name }}">
                                {{ $user->name }}
                            </option>
                        @endforeach
                    @else
                        <option 
                            value="{{ auth()->user()->id }}" 
                            selected 
                            data-nameoperario="{{ auth()->user()->name }}">
                            {{ auth()->user()->name }}
                        </option>
                    @endif
                </select>
            </div>
        </div>

        @if ($isAdmin)
            <div class="row mt-2">
                <div class="col-md-12">
                    <label for="autorid">Auditor</label>
                    <select name="autorid" id="autorid" class="form-select">
                        <option 
                            value="0" 
                            data-alluser="{{ json_encode($users) }}" 
                            selected>
                            Todos los usuarios
                        </option>
                        @foreach ($users as $user)
                            <option 
                                value="{{ $user->id }}" 
                                data-nameoperario="{{ $user->name }}">
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

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

            // let table = $('#partes_trabajo').DataTable({
            //     colReorder: { realtime: true },
            //     order: [[1, 'desc']],
            //     // scrollX: true,
            //     language: {
            //         processing: "Procesando...",
            //         search: "Buscar:",
            //         lengthMenu: "Mostrar _MENU_",
            //         info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            //         infoEmpty: "Mostrando 0 a 0 de 0 registros",
            //         infoFiltered: "(filtrado de _MAX_ registros totales)",
            //         zeroRecords: "No se encontraron registros coincidentes",
            //         paginate: {
            //             first: "Primero", previous: "Anterior", next: "Siguiente", last: "Último"
            //         },
            //         aria: {
            //             sortAscending: ": activar para ordenar la columna en orden ascendente",
            //             sortDescending: ": activar para ordenar la columna en orden descendente"
            //         }
            //     },
            //     pageLength: 50,
            //     lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            //     dom: "<'row'<'col-12 mb-2'<'table-title'>>>" +
            //         "<'row'<'col-md-6 left-buttons'B><'col-md-6 d-flex justify-content-end'l f>>" +
            //         "<'row'<'col-12'tr>>" +
            //         "<'row'<'col-md-5'i><'col-md-7'p>>",
            //     buttons: [
            //         { text: 'Vender varios', className: 'btn btn-outline-primary venderVariosBtnClass mb-2' },
            //         { text: 'Confirmar Venta', className: 'btn btn-outline-success confirmVentaBtnClass mb-2 d-none' },
            //         {
            //             text: 'Limpiar Filtros', 
            //             className: 'btn btn-outline-danger limpiarFiltrosBtn mb-2', 
            //             action: function (e, dt, node, config) { 
            //                 clearFiltrosFunction(dt, '#partes_trabajo');
            //             }
            //         }
            //     ],
            //     columnDefs: [
            //         { targets: [0], visible: false, searchable: false },
            //         {
            //             targets: '_all',
            //             render: function (data, type, row, meta) {
            //                 let cell = meta.settings.aoData[meta.row].anCells[meta.col];
            //                 let fullText = $(cell).attr('data-fulltext');
            //                 return fullText || data; 
            //             }
            //         }
            //     ],
            //     initComplete: function () {
            //         configureInitComplete(this.api(), '#partes_trabajo', 'PARTES DE TRABAJO', 'primary');
            //     }
            // });

            // table.on('init.dt', function() {
            //     restoreFilters(table, '#partes_trabajo');// Restaurar filtros después de inicializar la tabla
            // });

            // mantenerFilaYsubrayar(table);
            // fastEditForm(table, 'PartesTrabajo');


            // $('#partes_trabajo').colResizable({
            //     liveDrag: true,       
            //     resizeMode: 'flex',   
            //     partialRefresh: true  
            // });

            // Inicializar la tabla de citas
            const agTablediv = document.querySelector('#PartesGrid');

            let rowData = {};
            let data = [];

            const partes = @json($partes_trabajo);

            const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
                { 
                    name: 'ID',
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
                    principal: true
                }, 
                { 
                    name: 'Orden',
                    fieldName: 'parte',
                    addAttributes: true, 
                    addcustomDatasets: true,
                    dataAttributes: { 
                        'data-id': ''
                    },
                    attrclassName: 'showOrdenBtn',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                }, 
                { 
                    name: 'Proyecto',
                    addAttributes: true,
                    dataAttributes: { 
                        'data-order': 'order-column',
                        'data-id': ''
                    },
                    attrclassName: 'openProjectDetails',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                },
                { 
                    name: 'FechaAlta', 
                    className: 'fecha-alta-column',
                    fieldName: 'FechaAlta',
                    fieldType: 'date',
                    editable: true,

                },
                { 
                    name: 'FechaVisita', 
                    className: 'fecha-alta-column',
                    fieldName: 'FechaVisita',
                    fieldType: 'date',
                    editable: true,

                },
                { 
                    name: 'Cliente',
                    fieldName: 'cliente_id',
                    fieldType: 'select',
                    addAttributes: true,
                },
                {
                    name: 'Operarios',
                    fieldName: 'operario_id',
                    fieldType: 'select',
                    addAttributes: true,
                },
                { name: 'Departamento' },
                { 
                    name: 'Titulo',
                    fieldName: 'tituloParte',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    customDatasets: {
                        'data-fieldName': "tituloParte",
                        'data-type': "text"
                    }
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
                    name: 'Solucion',
                    fieldName: 'solucion',
                    editable: true,
                    addAttributes: true,
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-fulltext': ''
                    },
                    addcustomDatasets: true,
                    customDatasets: {
                        'data-fieldName': "solucion",
                        'data-type': "text"
                    }
                },
                { name: 'Estado' },
                { name: 'EVenta' },
                { name: 'Total' },
                { name: 'Iva' },
                { name: 'TotalII' },
                { name: 'Trabajo' },
                { name: 'HInicio' },
                { name: 'HFin' },
                { name: 'Tiempo' },
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
                    name: "Autor"
                },
                { 
                    name: 'Acciones',
                    className: 'acciones-column'
                }
            ];

            function prepareRowData(partes) {
                partes.forEach(parte => {
                    // console.log(parte);
                    // if (parte.proyecto_n_m_n && parte.proyecto_n_m_n.length > 0) {
                    //     console.log({proyecto: parte.proyecto_n_m_n[0].proyecto.name});
                    // }
                    const tecnicosPorComas = parte.orden.operarios.map(tec => tec.user.name).join(', ');
                    let autor = 'Sin registro';
                    if (parte.partes_trabajo_lineas && parte.partes_trabajo_lineas.length > 0) {
                        // Obtén los nombres únicos de los autores
                        const nombresUnicos = [...new Set(parte.partes_trabajo_lineas.map(linea => linea.user?.name).filter(Boolean))];
                        // Unir los nombres únicos con comas
                        autor = nombresUnicos.join(', ');
                    }
                    rowData[parte.idParteTrabajo] = {
                        ID: parte.idParteTrabajo,
                        Orden: parte.idParteTrabajo,
                        Proyecto: (parte.proyecto_n_m_n && parte.proyecto_n_m_n.length > 0) ? parte.proyecto_n_m_n[0].proyecto.name : '',
                        FechaAlta: parte.FechaAlta,
                        FechaVisita: parte.FechaVisita,
                        Cliente: `${parte.cliente.NombreCliente} ${parte.cliente.ApellidoCliente}`,
                        Departamento: parte.Departamento,
                        Operarios: tecnicosPorComas,
                        Titulo: parte.tituloParte,
                        Asunto: parte.Asunto,
                        Solucion: parte.solucion,
                        Estado: (parte.Estado == 1) ? 'Pendiente' : (parte.Estado == 2) ? 'En proceso' : 'Finalizado',
                        EVenta: (parte.estadoVenta == 1) ? 'No vendido' : 'Vendido',
                        Total: formatPrice(parte.suma),
                        Iva: (parte.ivaParte) ? parte.ivaParte+'%' : 'Sin calcular',
                        TotalII: formatPrice(parte.totalParte),
                        Trabajo: parte.trabajo.nameTrabajo,
                        HInicio: parte.hora_inicio,
                        HFin: parte.hora_fin,
                        Tiempo: parte.horas_trabajadas,
                        Observaciones: parte.Observaciones,
                        Notas1: parte.notas1,
                        Notas2: parte.notas2,
                        Autor: autor,
                        Acciones: 
                        `
                            @component('components.actions-button')

                                <button 
                                    type="button" 
                                    class="btn btn-info detailsParteTrabajoBtn" 
                                    data-id="${parte.idParteTrabajo}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Ver detalles"
                                >
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column">
                                        <ion-icon name="information-circle-outline"></ion-icon>
                                        <small  class="text-info-emphasis" style="font-size: 10px; color:white !important;">Detalles</small>
                                    </div>
                                </button>

                                <button 
                                    type="button" 
                                    class="btn btn-primary editParteTrabajoBtn" 
                                    data-id="${parte.idParteTrabajo}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Editar parte"
                                >
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column">
                                        <ion-icon name="create-outline"></ion-icon>
                                        <small  class="text-info-emphasis" style="font-size: 10px; color:white !important;">Editar</small>
                                    </div>
                                </button>     

                                <button 
                                    type="button" 
                                    class="btn btn-primary generateNewOrdenBtn" 
                                    data-id="${parte.idParteTrabajo}"
                                    data-orden="${parte.orden_id}"
                                    data-asunto="${parte.Asunto}"
                                    data-clienteid="${parte.cliente.idClientes}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Generar una nueva orden"
                                >
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column">
                                        <ion-icon name="add-circle-outline"></ion-icon>
                                        <small  class="text-info-emphasis" style="font-size: 10px; color:white !important;">N.orden</small>
                                    </div>
                                </button>

                                {{-- Descargar PDF --}}
                                <a
                                    href="/parte-trabajo/${parte.idParteTrabajo}/pdf"
                                    class="btn btn-danger"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Descargar PDF"
                                >
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column">
                                        <ion-icon name="download-outline"></ion-icon>
                                        <small  class="text-info-emphasis" style="font-size: 10px; color:white !important;">PDF</small>
                                    </div>
                                </a>

                                {{-- Descargar Excel --}}
                                <a 
                                    href="/parte-trabajo/${parte.idParteTrabajo}/excel"
                                    class="btn btn-success"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Descargar Excel"
                                >
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column">
                                        <ion-icon name="download-outline"></ion-icon>
                                        <small  class="text-info-emphasis" style="font-size: 10px; color:white !important;">Excel</small>
                                    </div>
                                </a>

                                {{-- Descargar ZIP --}}
                                <a 
                                    href="/parte-trabajo/${parte.idParteTrabajo}/bundle"
                                    class="btn btn-warning"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Descargar ZIP"
                                >
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column">
                                        <ion-icon style="color:whitesmoke" name="download-outline"></ion-icon>
                                        <small class="text-info-emphasis" style="font-size: 10px; color:white !important;">ZIP</small>
                                    </div>
                                </a>
                                
                            @endcomponent
                        
                        `
                    }
                });

                data = Object.values(rowData);
            }

            prepareRowData(partes);

            const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
                const customButtons = `
                    <small></small>
                `;

                // Inicializar la tabla de citas
                inicializarAGtable( agTablediv, data, result, 'Partes De Trabajo', customButtons, 'PartesTrabajo', true, true);
            });

            $('.limpiarFiltrosBtn').removeClass('dt-button');
            $('.createParteTrabajoBtn').removeClass('dt-button');
            $('.venderVariosBtnClass').removeClass('dt-button');
            $('.confirmVentaBtnClass').removeClass('dt-button');
            $('.editParteTrabajoTable').css('cursor', 'pointer');
            $('.editParteTrabajoTable').css('text-decoration', 'underline');


            let table = $('#PartesGrid');

            // funcion para acortar palabras
            function truncateString(string, limit = 15){
                if (string.length > limit) {
                    return string.substring(0, limit) + '...';
                }
                return string;
            }

            function openDetailsOrdersTrabajoModal(ordenIdSend){
                const ordenId = ordenIdSend;

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
                            
                            $('#modalEditOrden #asuntoEdit').val(orden.Asunto);
                            $('#modalEditOrden #fecha_altaEdit').val(orden.FechaAlta);
                            $('#modalEditOrden #fecha_visitaEdit').val(orden.FechaVisita);
                            $('#modalEditOrden #estadoEdit').val(orden.Estado).trigger('change');
                            $('#modalEditOrden #cliente_idEdit').val(orden.cliente_id).trigger('change');
                            $('#modalEditOrden #departamentoEdit').val(orden.Departamento);
                            $('#modalEditOrden #observacionesEdit').val(orden.Observaciones);
                            $('#modalEditOrden #orden_id').val(orden.idOrdenTrabajo);

                            setTimeout(function() {
                                $('#modalEditOrden #estadoEdit').val(orden.Estado).trigger('change');
                                console.log(orden.Estado);
                                console.log($('#modalEditOrden #estadoEdit').val());
                            }, 2000);

                            // inicializar select2
                            if ($('#modalEditOrden select.form-select').data('select2')) {
                                $('#modalEditOrden select.form-select').select2('destroy');
                            }

                            $('#modalEditOrden select.form-select').select2({
                                width: '100%',
                                dropdownParent: $('#modalEditOrden')
                            });

                            $('#modalEditOrden #editOrdenTitle').html(`Editar Orden No. ${orden.idOrdenTrabajo}`);

                            // Cargar trabajos en el select2 multiple
                            let trabajos = orden.trabajo.map(trabajo => {
                                return { id: trabajo.id, text: trabajo.nombre };  // Suponiendo que trabajo tiene 'id' y 'nombre'
                            });

                            // Asegúrate de que las opciones de trabajos estén en el select
                            trabajos.forEach(trabajo => {
                                if ($('#modalEditOrden #trabajo_idEdit option[value="' + trabajo.idTrabajo + '"]').length === 0) {
                                    $('#modalEditOrden #trabajo_idEdit').append(new Option(trabajo.nameTrabajo, trabajo.idTrabajo));
                                }
                            });

                            // Selecciona los trabajos asignados en el select2 multiple
                            let trabajosIds = orden.trabajo.map(trabajo => trabajo.idTrabajo);
                            $('#modalEditOrden #trabajo_idEdit').val(trabajosIds).trigger('change');

                            // Cargar operarios en el select2 multiple
                            let operarios = orden.operarios.map(operario => {
                                return { id: operario.id, text: operario.nameOperario };  // Suponiendo que operario tiene 'id' y 'nameOperario'
                            });

                            // Asegúrate de que las opciones de operarios estén en el select
                            operarios.forEach(operario => {
                                if ($('#modalEditOrden #operario_idEdit option[value="' + operario.idOperario + '"]').length === 0) {
                                    $('#modalEditOrden #operario_idEdit').append(new Option(operario.nameOperario, operario.idOperario));
                                }
                            });

                            // Selecciona los operarios asignados en el select2 multiple
                            let operariosIds = orden.operarios.map(operario => operario.idOperario);
                            $('#modalEditOrden #operario_idEdit').val(operariosIds).trigger('change');

                            $('#modalEditOrden #imagesEdit').empty();

                            const imagesContainer = $('#modalEditOrden #previewImage1');
                            imagesContainer.empty();

                            orden.archivos.forEach((imagen, index) => {

                                const archivo = imagen;

                                const fileWrapper = $(`<div class="file-wrapper"></div>`).css({
                                    'display': 'flex',
                                    'flex-direction': 'column',
                                    'justify-content': 'center',
                                    'text-align': 'center',
                                    'margin': '10px',
                                    'width': '250px',
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
                            
                            // Subir archivos y mostrar una vista previa de la imagen o icono si es un archivo
                            $('#modalEditOrden #files1').on('change', function() {
                                const files = $(this)[0].files;
                                const filesContainer = $('#modalEditOrden #previewImage1');

                                // Añadir previsualización
                                previewFiles(files, filesContainer, 0);
                            });

                            $('#modalEditOrden #files1').on('click', function(e) {
                                // verificar si hay archivos cargados
                                if ($('#modalEditOrden #previewImage1').children().length > 0) {
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

                            $('#modalEditOrden #inputsToUploadFilesContainer').empty();

                            // Evento para añadir más inputs de archivos
                            $('#modalEditOrden #btnAddFiles').off('click').on('click', function() {
                                const newInputContainer = $('<div class="form-group col-md-12"></div>');
                                const inputIndex = $('#modalEditOrden #inputsToUploadFilesContainer input').length + 1; // Índice del nuevo input
                                const newInputId = `input_${inputIndex}`;

                                // Como máximo se pueden añadir 5 inputs
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

                                const newInput = $(`<input type="file" class="form-control" name="file[]" id="${newInputId}">`);
                                newInputContainer.append(newInput);
                                $('#modalEditOrden #inputsToUploadFilesContainer').append(newInputContainer);

                                newInput.val('');  // Resetear el input de archivos

                                // Manejar la previsualización para los nuevos inputs
                                newInput.on('change', function() {
                                    const files = $(this)[0].files;
                                    const filesContainer = $('#modalEditOrden #previewImage1');

                                    // Añadir previsualización
                                    previewFiles(files, filesContainer, inputIndex);
                                });

                                newInput.on('click', function(e) {
                                    // verificar si hay archivos cargados
                                    if ($('#modalEditOrden #previewImage1').children().length > inputIndex) {
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

                            // abrir el modal del detalle de la orden
                            $('#modalEditOrden').modal('show');

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
            }

            $('#createParteTrabajoModal').on('shown.bs.modal', () => {
                $('#createParteTrabajoModal select.form-select').select2({
                    width: '100%',  // Asegura que el select ocupe el 100% del contenedor
                    dropdownParent: $('#createParteTrabajoModal')  // Asocia el dropdown con el modal para evitar problemas de superposición
                });

            });

            $('#editParteTrabajoModal').on('shown.bs.modal', () => {
                $('#editParteTrabajoModal select.form-select').select2({
                    width: '100%',  // Asegura que el select ocupe el 100% del contenedor
                    dropdownParent: $('#editParteTrabajoModal')  // Asocia el dropdown con el modal para evitar problemas de superposición
                });

                const solucion = $('#editParteTrabajoModal #solucion');
                solucion.css('height', 'auto');
                solucion.css('height', solucion[0].scrollHeight + 'px');

            });

            table.on('dblclick', '.showOrdenBtn', function(e){
                openLoader();

                const ordenId = $(this).data('id');

                editOrdenTrabajo(ordenId);

            });

            table.on('dblclick', '.OpenHistorialCliente', function(event){
                const elemento  = $(this);
                const span      = elemento.find('span')[1]
                const parteid   = span.getAttribute('data-parteid');

                getEditCliente(parteid, 'PartesTrabajo');

            });

            $('#btnEditOrden').on('click', function(event){

                event.preventDefault();

                let form = $('#modalEditOrden #formEditOrden');

                let formData = new FormData(form[0]);

                // validar si algun campo de los que tienen la clase required-field dentro del div con class required-field están los inputs
                let emptyFields = false;

                $('#modalEditOrden .required-field').each(function(index, element){
                    let inputs = $(element).find('input, select, textarea');
                    inputs.each(function(index, input){
                        if ( $(input).hasClass('required-field') && $(input).val() === '' ) {
                            emptyFields = true;
                        }
                    });
                });

                if ( emptyFields ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Debes llenar todos los campos requeridos'
                    });
                    return;
                }

                Swal.fire({
                    title: '¿Estás seguro de que deseas editar esta orden?',
                    text: "¡Verifica que todos los campos requeridos estén completos!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, editar!',
                    allowClickOutside: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        openLoader();

                        const idOrden = $('#modalEditOrden #orden_id').val();

                        // cambiar la url del formulario y el metodo PUT
                        $('#modalEditOrden #formEditOrden').attr('action', `/admin/ordenes/update/${idOrden}`);
                        $('#modalEditOrden #formEditOrden').attr('method', 'POST');
                        $('#modalEditOrden #formEditOrden').append('<input type="hidden" name="_method" value="PUT">');
                        
                        $('#modalEditOrden #formEditOrden').submit();
                        $('#modalEditOrden').modal('hide');
                    }
                })

            });

            $('#editParteTrabajoModal #solucion, #editParteTrabajoModal #observaciones').on('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

            let fileCounter = 0;
            let materialCounter = 0;
            let parteTrabajoId = null;

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

                        // Añadir elementos al contenedor
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

            const calculatePriceHoraXcantidad = (cantidad_form, precio_form, descuento) => {
                const cantidad = parseFloat(cantidad_form);
                const precio = parseFloat(precio_form);
                const descuentoCliente = parseFloat(descuento);

                if ( !isNaN(cantidad) && !isNaN(precio) ) {
                    const total = cantidad * precio;
                    if( descuentoCliente == 0 ){
                        // $('#editParteTrabajoModal #precio_hora').val(total.toFixed(2));
                        $('#editParteTrabajoModal #precio_hora').val(0);
                    }else{
                        const totalDescuento = total - (total * (descuentoCliente / 100));
                        // $('#editParteTrabajoModal #precio_hora').val(totalDescuento.toFixed(2));
                        $('#editParteTrabajoModal #precio_hora').val(0);
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

            $('.createParteTrabajoBtn').on('click', function() {
                $('#createParteTrabajoModal').modal('show');
                $('#formCreateOrden')[0].reset();
                $('#elementsToShow').empty();
                
                $('#createParteTrabajoModal').on('shown.bs.modal', () => {
                    if ($('createParteTrabajoModal select.form-select').data('select2')) {
                        $('createParteTrabajoModal select.form-select').select2('destroy');
                    }

                    $('createParteTrabajoModal select.form-select').select2({
                        width: '100%',
                        dropdownParent: $('#createParteTrabajoModal')
                    });
                });

                $('#citasPendigSelect').on('change', function() {
                    let selectedOption  = $(this).find('option:selected');
                    let asunto          = selectedOption.data('asunto');
                    let fecha           = selectedOption.data('fecha');
                    let estado          = selectedOption.data('estado');

                    $('#asunto').val(asunto);
                    $('#fecha_alta').val(fecha);
                    $('#estado').val(2);
                });
            });

            let signaturePad = null;

            table.off('click', '.editParteTrabajoBtn').on('click', '.editParteTrabajoBtn', function() {
                openLoader();
                const parteId = $(this).data('id');          
                openDetailsParteTrabajoModal(parteId);
            });

            table.off('dblclick', '.editParteTrabajoTable').on('dblclick', '.editParteTrabajoTable', function() {
                openLoader();
                const parteId = $(this).data('id');          
                openDetailsParteTrabajoModal(parteId);
            });

            table.off('click', '.detailsParteTrabajoBtn').on('click', '.detailsParteTrabajoBtn', function() {
                const parteId = $(this).data('id');
                openLoader();
                $('#detailsParteTrabajoModal #btnCreateOrdenButton').hide();
                $.ajax({
                    url: `/admin/partes/${parteId}/edit`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const parte = response.parte_trabajo;
                            closeLoader();
                            $('#detailsParteTrabajoModal').modal('show');
                            $('#formCreateOrden')[0].reset();
                            $('#detailsParteTrabajoTitle').text(`Detalles Parte de Trabajo No. ${parte.idParteTrabajo}`);

                            const solucionTextArea = $('#detailsParteTrabajoModal #solucion');
                            solucionTextArea.css('height', 'auto');
                            solucionTextArea.css('height', solucionTextArea[0].scrollHeight + 'px');

                            $('#detailsParteTrabajoModal #formCreateOrden').attr('action', ``);
                            $('#detailsParteTrabajoModal #addNewMaterial').hide();
                            $('#detailsParteTrabajoModal #btnAddFiles').hide();
                            $('#detailsParteTrabajoModal #files1').attr('disabled', true);

                            if ( parte.cita ) {
                                $('#detailsParteTrabajoModal #citasPendigSelect').val(parte.cita.idProyecto).trigger('change').attr('disabled', true);
                            }else{
                                $('#detailsParteTrabajoModal #citasPendigSelect').val('').trigger('change').attr('disabled', true);
                            }

                            // hora de inicio y hora de fin con moment.js
                            let horaInicio = moment(parte.hora_inicio, 'HH:mm:ss').format('HH:mm');
                            let horaFin = moment(parte.hora_fin, 'HH:mm:ss').format('HH:mm');

                            // inputs tipo time
                            $('#detailsParteTrabajoModal #hora_inicio').val(horaInicio).attr('disabled', true);
                            $('#detailsParteTrabajoModal #hora_fin').val(horaFin).attr('disabled', true);

                            // input tipo number
                            $('#detailsParteTrabajoModal #horas_trabajadas').val(parte.horas_trabajadas).attr('disabled', true);
                            $('#detailsParteTrabajoModal #precio_hora').val(parte.precio_hora).attr('disabled', true);
                            $('#detailsParteTrabajoModal #desplazamiento').val(parte.desplazamiento).attr('disabled', true);

                            $('#detailsParteTrabajoModal #asunto').val(parte.Asunto).attr('disabled', true);
                            $('#detailsParteTrabajoModal #fecha_alta').val(parte.FechaAlta).attr('disabled', true);
                            $('#detailsParteTrabajoModal #fecha_visita').val(parte.FechaVisita).attr('disabled', true);
                            $('#detailsParteTrabajoModal #estado').val(parte.Estado).attr('disabled', true);
                            $('#detailsParteTrabajoModal #cliente_id').val(parte.cliente_id).trigger('change').attr('disabled', true);
                            $('#detailsParteTrabajoModal #departamento').val(parte.Departamento).attr('disabled', true);
                            $('#detailsParteTrabajoModal #observaciones').val(parte.Observaciones).attr('disabled', true);
                            $('#detailsParteTrabajoModal #trabajo_id').val(parte.trabajo.idTrabajo).trigger('change').attr('disabled', true);
                            $('#detailsParteTrabajoModal #suma').val(parte.suma).attr('disabled', true);
                            $('#detailsParteTrabajoModal #solucion').val(parte.solucion).attr('disabled', true);

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

                            // mostrar vista previa de las imagenes / videos o audios
                            $('#detailsParteTrabajoModal #imagesDetails').empty();
                            $('#detailsParteTrabajoModal #showSignatureFromClient').empty();
                            $('#detailsParteTrabajoModal #cliente_firmaid').val('').attr('readonly', true);

                            if( parte.partes_trabajo_archivos.length > 0 ){
                                parte.partes_trabajo_archivos.forEach(archivo => {

                                    // mostrar vista previa de las imagenes / videos o audios
                                    let type = archivo.typeFile;
                                    let url = archivo.pathFile;
                                    let comentario = ''

                                    if ( archivo.comentarioArchivo ) {
                                        comentario = archivo.comentarioArchivo
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
                                    
                                    const fileWrapper = $(`<div class="file-wrapper"></div>`).css({
                                        'display': 'inline-block',
                                        'text-align': 'center',
                                        'margin': '10px',
                                        'width': '350px',
                                        'height': '400px',
                                        'vertical-align': 'top',
                                        'border': '1px solid #ddd',
                                        'padding': '10px',
                                        'border-radius': '5px',
                                        'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                                        'overflow': 'hidden'
                                    });

                                    // verificar el comentario si es firma_digital_bd para mostrar la firma en vez del canvas con id signature-pad
                                    if ( comentario === 'firma_digital_bd' ) {
                                        fileWrapper.empty();
                                        fileWrapper.append(`
                                            <img src="${urlFinal}" class="img-fluid">
                                            <br>
                                            <span>${parte.nombre_firmante}</span>
                                        `);
                                        $('#detailsParteTrabajoModal #showSignatureFromClient').show();
                                        $('#detailsParteTrabajoModal #signature-pad').hide();
                                        $('#detailsParteTrabajoModal #signature-pad').attr('src', urlFinal);
                                        $('#detailsParteTrabajoModal #showSignatureFromClient').append(fileWrapper);
                                        $('#detailsParteTrabajoModal #cliente_firmaid').val(parte.nombre_firmante).attr('readonly', true);
                                        return;
                                    }

                                    switch (finalType) {
                                        case 'image':
                                            fileWrapper.append(`
                                                <img src="${urlFinal}" class="img-fluid">
                                                <br>
                                                <span>${comentario}</span>
                                            `);
                                            break;
                                        case 'video':
                                            fileWrapper.append(`
                                                <video
                                                    controls 
                                                    data-poster="https://sebcompanyes.com/vendor/adminlte/dist/img/mileco.jpeg"
                                                    style="max-width: 320px; max-height: 340px;"
                                                >
                                                    <source src="${urlFinal}" type="video/mp4" />
                                                </video>
                                                <br>
                                                <span>${comentario}</span>
                                            `);
                                            break;
                                        case 'audio':
                                            fileWrapper.append(`
                                                <audio src="${urlFinal}" class="img-fluid"></audio>
                                                <br>
                                                <span>${comentario}</span>
                                            `);
                                            break;
                                        case 'pdf':
                                            fileWrapper.append(`
                                                <embed src="${urlFinal}" type="application/pdf" width="100%" height="600px">
                                                <br>
                                                <span>${comentario}</span>
                                            `);
                                            break;
                                        case 'word':
                                            fileWrapper.append(`
                                                <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${urlFinal}" width='100%' height='600px' frameborder='0'>
                                                <br>
                                                <span>${comentario}</span>
                                            `);
                                            break;
                                        case 'excel':
                                            fileWrapper.append(`
                                                <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${urlFinal}" width='100%' height='600px' frameborder='0'>
                                                <br>
                                                <span>${comentario}</span>
                                            `);
                                            break;
                                        case 'powerpoint':
                                            fileWrapper.append(`
                                                <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${urlFinal}" width='100%' height='600px' frameborder='0'>
                                                <br>
                                                <span>${comentario}</span>
                                            `);
                                            break;
                                        default:
                                            fileWrapper.append(`
                                                <img src="${urlFinal}" class="img-fluid">
                                                <br>
                                                <span>${comentario}</span>
                                            `);
                                            break;
                                    }

                                    $('#detailsParteTrabajoModal #imagesDetails').append(fileWrapper);

                                });
                            }

                        }
                    },
                    error: function(err) {
                        console.error(err);
                        closeLoader();
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
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"'
                    });
                    return;
                }
            });

            $('#btnAddFiles').on('click', function() {
                const newInputContainer = $('<div class="form-group col-md-12"></div>');
                const inputIndex = $('#inputsToUploadFilesContainer input').length + 1;
                const newInputId = `input_${inputIndex}`;

                if (inputIndex >= 5) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'No puedes añadir más de 5 archivos'
                    })
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
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"'
                        })
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

            $('#addNewMaterial').on('click', function() {
                materialCounter++;
                let newMaterial = `
                    <form id="AddNewMaterialForm${materialCounter}" class="mt-2 mb-2">
                        <div class="row">
                            <input type="hidden" id="parteTrabajo_id" name="parteTrabajo_id" value="">
                            <input type="hidden" id="materialCounter" name="materialCounter" value="${materialCounter}">
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="articulo_id${materialCounter}">Artículo</label>
                                    <select class="form-select articulo" id="articulo_id${materialCounter}" name="articulo_id" required>
                                        <option value="">Seleccione un artículo</option>
                                        @foreach ($articulos as $articulo)
                                            <option data-namearticulo="{{ $articulo->nombreArticulo }}" value="{{ $articulo->idArticulo }}">
                                                {{ $articulo->nombreArticulo }} | {{ formatTrazabilidad($articulo->TrazabilidadArticulos) }} | {{ $articulo->stock->cantidad }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cantidad${materialCounter}">Cantidad</label>
                                    <input type="number" class="form-control cantidad" id="cantidad${materialCounter}" name="cantidad" value="1" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="precioSinIva${materialCounter}">Precio sin IVA</label>
                                    <input type="number" class="form-control precioSinIva" id="precioSinIva${materialCounter}" name="precioSinIva" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="descuento${materialCounter}">Descuento</label>
                                    <input type="number" class="form-control descuento" id="descuento${materialCounter}" name="descuento" step="0.01" value="0" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="total${materialCounter}">Total</label>
                                    <input type="number" class="form-control total" id="total${materialCounter}" name="total" step="0.01" required readonly>
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-success saveMaterial" data-material="${materialCounter}">Guardar</button>    
                            </div>
                        </div>
                    </form>
                `;

                $('#newMaterialsContainer').append(newMaterial);

                if ($('#newMaterialsContainer select.form-select').data('select2')) {
                    $('#newMaterialsContainer select.form-select').select2('destroy');
                }

                $('#newMaterialsContainer select.form-select').select2({
                    width: '100%',  // Asegura que el select ocupe el 100% del contenedor
                    dropdownParent: $('#createParteTrabajoModal')  // Asocia el dropdown con el modal para evitar problemas de superposición
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
                        success: function(response) {
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

                $('#newMaterialsContainer').on('change', `#cantidad${materialCounter}`, function () {
                    const cantidad = $(this).val();
                    const form = $(this).closest('form');
                    const precioSinIvaInput = form.find('.precioSinIva').val();
                    const descuentoInput = form.find('.descuento').val();
                    const totalInput = form.find('.total');

                    if (cantidad && precioSinIvaInput) {
                        const total = cantidad * precioSinIvaInput - descuentoInput;
                        totalInput.val(total);
                        calculateTotalSum(parteTrabajoId);
                    }
                });

                $('#newMaterialsContainer').on('change', `#precioSinIva${materialCounter}`, function () {
                    const precioSinIva = $(this).val();
                    const form = $(this).closest('form');
                    const cantidad = form.find('.cantidad').val();
                    const descuentoInput = form.find('.descuento').val();
                    const totalInput = form.find('.total');

                    if (precioSinIva && cantidad) {
                        const total = cantidad * precioSinIva - descuentoInput;
                        totalInput.val(total);
                        calculateTotalSum(parteTrabajoId);
                    }
                });

                $('#newMaterialsContainer').on('change', `#descuento${materialCounter}`, function () {
                    const descuento = $(this).val();
                    const form = $(this).closest('form');
                    const cantidad = form.find('.cantidad').val();
                    const precioSinIvaInput = form.find('.precioSinIva').val();
                    const totalInput = form.find('.total');

                    if (descuento && cantidad && precioSinIvaInput) {
                        const total = cantidad * precioSinIvaInput - descuento;
                        totalInput.val(total);
                        calculateTotalSum(parteTrabajoId);
                    }
                });
            });

            $('#collapseMaterialesEmpleados').on('click', '.saveMaterial', function () {
                const materialNumber = $(this).data('material');
                const form = $(`#AddNewMaterialForm${materialNumber}`);
                const articuloId = form.find(`#articulo_id${materialNumber}`).val();
                const cantidad = parseFloat(form.find(`#cantidad${materialNumber}`).val());
                const precioSinIva = parseFloat(form.find(`#precioSinIva${materialNumber}`).val());
                const descuento = parseFloat(form.find(`#descuento${materialNumber}`).val());
                const total = parseFloat(form.find(`#total${materialNumber}`).val());

                if (!articuloId || isNaN(cantidad) || isNaN(precioSinIva) || isNaN(descuento) || isNaN(total)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Todos los campos son requeridos',
                    });
                    return;
                }

                const nombreArticulo = $(`#articulo_id${materialNumber} option:selected`).data('namearticulo');

                const newRow = `
                <tr>
                    <td>${materialNumber}</td>
                    <td>${nombreArticulo}</td>
                    <td>${cantidad}</td>
                    <td>${precioSinIva}€</td>
                    <td>${descuento}</td>
                    <td class="material-total">${total}€</td>
                </tr>
                `;
                
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
                    success: function(response) {
                        if (response.success) {
                            $('#elementsToShow').append(newRow);
                            calculateTotalSum(parteTrabajoId);
                        } else {
                            console.error('Error al guardar la línea de material');
                        }
                    },
                    error: function(err) {
                        console.error(err);
                    }
                });
            });

            $('#btnCreateOrdenButton').on('click', function(event) {
                event.preventDefault();
                const formData = new FormData($('#formCreateOrden')[0]);

                const files = $('#formCreateOrden input[type="file"]');

                for (let i = 0; i < files.length; i++) {
                    const input = files[i];
                    const inputName = $(input).attr('name');
                    const filesToUpload = input.files;

                    for (let j = 0; j < filesToUpload.length; j++) {
                        formData.append(inputName, filesToUpload[j]);
                    }
                }

                if (files.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Debes seleccionar al menos un archivo',
                    });
                    return;
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

            // Controlar la visibilidad de la columna "Seleccionar"
            $('#venderVariosBtn').on('click', function() {
                let column = table.column(0); // La primera columna es "Seleccionar"
                let isVisible = column.visible(); // Verificar si está visible o no

                // Alternar visibilidad de la columna
                column.visible(!isVisible);

                // Mostrar los checkboxes si la columna está visible
                if (!isVisible) {
                    $('.checkboxesColumn').fadeIn();
                    $('td[data-tdparte] input[type="checkbox"]').css('display', 'block');
                } else {
                    $('.checkboxesColumn').fadeOut();
                    $('td[data-tdparte] input[type="checkbox"]').css('display', 'none');
                    $('.dt-buttons .confirmVentaBtnClass').attr('disabled', true).addClass('d-none');
                }

                const arrayCheckboxes = $('td[data-tdparte] input[type="checkbox"]');

                arrayCheckboxes.on('change', function() {
                    const checkedCheckboxes = $('td[data-tdparte] input[type="checkbox"]:checked');
                    const checkedCheckboxesValues = Array.from(checkedCheckboxes).map(checkbox => $(checkbox).val());

                    if (checkedCheckboxesValues.length > 0) {
                        $('#venderVariosBtn').attr('disabled', false);

                        $('.dt-buttons .confirmVentaBtnClass').attr('disabled', false).removeClass('d-none');

                        $('#confirmVentaModal').on('click', function (event){

                            const todosMisPartes = $(this).data('partes');
                            
                            const partesSeleccionadas = todosMisPartes.filter(parte => checkedCheckboxesValues.includes(parte.idParteTrabajo.toString()));

                            $('#confirmVentaModal').attr('disabled', true);

                            $('#partesToShowFiltered').empty();

                            partesSeleccionadas.forEach( (parte) => {
                                $('#partesToShowFiltered').append(`
                                    <tr>
                                        <td>${parte.idParteTrabajo}</td>
                                        <td>${parte.orden_id}</td>
                                        <td>${parte.Asunto}</td>
                                        <td>${parte.FechaAlta}</td>
                                        <td>${parte.FechaVisita}</td>
                                        <td>
                                            <button class="btn btn-danger" data-parteid="${parte.idParteTrabajo}">Eliminar</button>   
                                        </td>
                                    </tr>
                                `);
                            });

                            $('#partesToShowFiltered').on('click', 'button', function() {
                                const parteId = $(this).data('parteid');
                                const parteIndex = checkedCheckboxesValues.indexOf(parteId.toString());
                                checkedCheckboxesValues.splice(parteIndex, 1);
                                $(`td[data-parteid="${parteId}"] input[type="checkbox"]`).prop('checked', false);
                                $(this).closest('tr').remove();

                                if (checkedCheckboxesValues.length === 0) {
                                    $('#confirmVentaModal').attr('disabled', true);
                                }
                            });

                            // abrir modal de confirmación
                            $('#confirmVentaModalMod').modal('show');

                            $('#confirmVentaModalMod #confirmVentaModalBtn').on('click', function(event) {
                                event.preventDefault();
                                
                                Swal.fire({
                                    title: '¿Estás seguro de querer vender los partes seleccionados?',
                                    showDenyButton: true,
                                    confirmButtonText: `Sí`,
                                    denyButtonText: `No`,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajax({
                                        url: "{{ route('admin.ventas.ventaVarios') }}",
                                        method: 'POST',
                                        data: {
                                            partes: checkedCheckboxesValues,
                                            _token: "{{ csrf_token() }}"
                                        },
                                        beforeSend: function() {
                                            // confirmar que por lo menos un checkbox está seleccionado

                                            if (checkedCheckboxesValues.length === 0) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Oops...',
                                                    text: 'Debes seleccionar al menos un parte de trabajo',
                                                });
                                                return;
                                            }

                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: response.message,
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                                $('#confirmVentaModalMod').modal('hide');
                                                location.reload();
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
                                    } else if (result.isDenied) {
                                        Swal.fire('Los partes no han sido vendidos', '', 'info');
                                    }
                                });
                            });

                        });

                    } else {
                        $('#venderVariosBtn').attr('disabled', true);
                        $('.dt-buttons .confirmVentaBtnClass').attr('disabled', true).addClass('d-none');
                    }
                });

            });

            // Generar una nueva orden de trabajo para la parte de trabajo

            table.on('click','.generateNewOrdenBtn', function(event){

                const parteId       = $(this).data('id');
                const ordenId       = $(this).data('orden');
                const parteAsunto   = $(this).data('asunto');
                const clienteId     = $(this).data('clienteid');

                // Abrir modal de crear orden

                $('#modalCreateOrden').modal('show');

                $('#modalCreateOrden #cliente_id').off('change'); // Desactivar el evento temporalmente

                // Filtrar todas las opciones de cliente para que solo se pueda seleccionar el cliente de la parte de trabajo
                $('#modalCreateOrden #cliente_id').val(clienteId).trigger('change');

                $('#modalCreateOrden #cliente_id').on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const selectedValue = selectedOption.val();
                    if (selectedValue !== clienteId) {
                        $(this).val(clienteId).trigger('change');
                    }
                });

                $('#modalCreateOrden #parte_id').val(parteId);
                $('#modalCreateOrden #orden_id').val(ordenId);
                $('#modalCreateOrden #fecha_alta').val(new Date().toISOString().split('T')[0]);

                
                $('#modalCreateOrden #observaciones').val('Orden de trabajo generada a partir de la parte de trabajo: ' + parteAsunto);
                $('#modalCreateOrden #estado').val('Pendiente');

                $('#modalCreateOrden #operario_id').on('change', function(){

                    // verificar si el select está vacío
                    if ($(this).val() === '') {
                        $('#modalCreateOrden #estado').val('Pendiente').trigger('change');
                    }else{
                        $('#modalCreateOrden #estado').val('En proceso').trigger('change');
                    }
                    
                })

                // Inicializar select2
                $('#modalCreateOrden select.form-select').select2({
                    width: '100%',
                    dropdownParent: $('#modalCreateOrden')
                });

                // Subir archivos y mostrar una vista previa de la imagen o icono si es un archivo

                let previewFiles = (files, container, inputIndex) => {
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

                $('#modalCreateOrden #files1').on('change', function() {
                    const files = $(this)[0].files;
                    const filesContainer = $('#modalCreateOrden #previewImage1');

                    // Añadir previsualización
                    previewFiles(files, filesContainer, 0);
                });

                $('#modalCreateOrden #files1').on('click', function(e) {
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
                $('#modalCreateOrden #btnAddFiles').on('click', function() {
                    const newInputContainer = $('<div class="form-group col-md-12"></div>');
                    const inputIndex = $('#inputsToUploadFilesContainer input').length + 1; // Índice del nuevo input
                    const newInputId = `input_${inputIndex}`;

                    // como maximo se pueden añadir 5 inputs
                    if (inputIndex >= 5) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'No puedes añadir más de 5 archivos',
                        });
                        return;
                    }
                    
                    const newInput = $(`<input type="file" class="form-control" name="file[]" id="${newInputId}">`);
                    newInputContainer.append(newInput);
                    $('#modalCreateOrden #inputsToUploadFilesContainer').append(newInputContainer);

                    // Manejar la previsualización para los nuevos inputs
                    newInput.on('change', function() {
                        const files = $(this)[0].files;
                        const filesContainer = $('#modalCreateOrden #previewImage1');

                        // Añadir previsualización
                        previewFiles(files, filesContainer, inputIndex);
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

                $('#modalCreateOrden #btnCreateOrden').on('click', function(event){

                    event.preventDefault();

                    $('#modalCreateOrden #formCreateOrden').submit();
                })

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

            $('#editParteTrabajoModal').on('shown.bs.modal', function () {
                let textarea = $('#editParteTrabajoModal textarea');
                
                textarea.each(function(index, element) {
                    // Restablece la altura del textarea
                    $(element).css('height', 'auto');
                    $(element).css('height', $(element)[0].scrollHeight + 'px');
                    
                    // Verifica y ajusta el scrollHeight solo si es mayor a 0
                    if (element.scrollHeight > 0) {
                        $(element).css('height', element.scrollHeight + 'px');
                    }

                    // Evento que expande automáticamente el textarea cuando se ingresa texto
                    $(element).on('input', function() {
                        $(this).css('height', 'auto');
                        $(this).css('height', this.scrollHeight + 'px');
                    });
                });

            });

            // Abrir detalles del proyecto
            table.on('click','.openProjectDetails', function(event){
                const projectid = $(this).data('parteid');
                getDetailsProject(projectid);
            });

            // Abrir modal para generar el informe de la parte de trabajo
            table.on('click','.generateExcelPartesTrabajoBtn', function(event){
                const parteId = $(this).data('parteid');
                $('#showReportModal').modal('show');

                // fecha actual para inicio y fin
                const fechaActual = new Date().toISOString().split('T')[0];

                $('#showReportModal #fechaInicio').val(fechaActual);
                $('#showReportModal #fechaFin').val(fechaActual);

                $('#generateReportBtn').off('click').on('click', function(event){
                    $('#showReportModal #generateReportForm').submit();
                });

            });

            $('#showReportModal').on('shown.bs.modal', function () {
                // inicializar el select2
                $('#showReportModal select.form-select').select2({
                    width: '100%',
                    dropdownParent: $('#showReportModal')
                });
            });

            $('#showReportModalInAGGRID').on('shown.bs.modal', function () {

                // fecha actual para inicio y fin
                const fechaActual = new Date().toISOString().split('T')[0];

                $('#showReportModalInAGGRID #fechaInicio').val(fechaActual);
                $('#showReportModalInAGGRID #fechaFin').val(fechaActual);

                // inicializar el select2
                $('#showReportModalInAGGRID select.form-select').select2({
                    width: '100%',
                    dropdownParent: $('#showReportModalInAGGRID')
                })

            });

        });
    </script>
@stop
