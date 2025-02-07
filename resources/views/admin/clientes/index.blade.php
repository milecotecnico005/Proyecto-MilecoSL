@extends('adminlte::page')

@section('title', 'Clientes')

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

    <div id="tableCard" class="card">
        <div class="card-body">
            <div id="ClientesGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>

            {{-- <table class="table-striped" id="clientes-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>CIF</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Email</th>
                        <th>Agente</th>
                        <th>Descuento</th>
                        <th>Banco</th>
                        <th>SubCon</th>
                        <th>Observaciones</th>
                        <th>MilecoUser</th>
                        <th>Notas 1</th>
                        <th>Notas 2</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                        @php
                            $telefonos = $cliente->telefonos;
                            $movil = [];

                            foreach ($telefonos as $telefono) {
                                $movil[] = $telefono->telefono;
                            }

                            $movil = json_encode($movil);

                        @endphp
                        <tr
                            class="mantenerPulsadoParaSubrayar"
                        >
                            <td>{{ $cliente->idClientes }}</td>
                            <td>{{ $cliente->CIF }}</td>
                            <td
                                class="text-truncate"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $cliente->NombreCliente." ".$cliente->ApellidoCliente }}"
                                data-fulltext="{{ $cliente->NombreCliente." ".$cliente->ApellidoCliente }}"
                            >
                                {{ Str::limit($cliente->NombreCliente." ".$cliente->ApellidoCliente, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $cliente->Direccion }} {{ $cliente->CodPostalCliente }}"
                                data-fulltext="{{ $cliente->Direccion }} {{ $cliente->CodPostalCliente }} {{ $cliente->ciudad->nameCiudad }}"
                            >
                                {{ Str::limit($cliente->Direccion." ".$cliente->CodPostalCliente." ".$cliente->ciudad->nameCiudad, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $cliente->EmailCliente }}"
                                data-fulltext="{{ $cliente->EmailCliente }}"
                            >
                                {{ Str::limit($cliente->EmailCliente, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $cliente->Agente }}"
                                data-fulltext="{{ $cliente->Agente }}"
                            >
                                {{ Str::limit($cliente->Agente, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $cliente->tipoCliente->descuento }}"
                                data-fulltext="{{ $cliente->tipoCliente->descuento }}"
                            >
                                {{ Str::limit($cliente->tipoCliente->descuento, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $cliente->banco->nameBanco ?? 'sin nada' }}"
                                data-fulltext="{{ $cliente->banco->nameBanco ?? 'nA' }}"
                            >
                                {{ Str::limit($cliente->banco->nameBanco ?? 'Sin asignar', 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $cliente->SctaContable }}"
                                data-fulltext="{{ $cliente->SctaContable }}"
                            >
                                {{ Str::limit($cliente->SctaContable, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $cliente->Observaciones }}"
                                data-fulltext="{{ $cliente->Observaciones }}"
                            >
                                {{ Str::limit($cliente->Observaciones, 5) }}
                            </td>
                            <td
                                class="text-truncate"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ ($cliente->user) ? $cliente->user->name : 'Sin Asignar' }}"
                                data-fulltext="{{ ($cliente->user) ? $cliente->user->name : 'Sin Asignar' }}"
                            >
                                @php
                                    $user = ($cliente->user) ? $cliente->user->name : 'Sin Asignar';
                                @endphp
                                {{ Str::limit($user, 5) }}
                            </td>
                            <td
                                data-fulltext="{{ $cliente->notas1 }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $cliente->notas1 }}"
                                class="text-truncate openqQuickEdit"
                                data-fieldName="notas1"
                                data-type="text"
                                data-parteid="{{ $cliente->idClientes }}"
                                >
                                @if ($cliente->notas1)
                                    {{ Str::limit($cliente->notas1, 10) }}
                                @endif
                            </td>
                            <td
                                data-fulltext="{{ $cliente->notas2 }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="{{ $cliente->notas2 }}"
                                class="text-truncate openqQuickEdit"
                                data-fieldName="notas2"
                                data-type="text"
                                data-parteid="{{ $cliente->idClientes }}"
                            >
                                @if ($cliente->notas2)
                                    {{ Str::limit($cliente->notas2, 10) }}
                                @endif
                            </td>
                            <td>
                                @component('components.actions-button')
                                    <a  
                                        data-idclientes="{{ $cliente->idClientes }}"
                                        data-cif="{{ $cliente->CIF }}"
                                        data-nombre="{{ $cliente->NombreCliente }}"
                                        data-apellido="{{ $cliente->ApellidoCliente }}"
                                        data-direccion="{{ $cliente->Direccion }}"
                                        data-codpostal="{{ $cliente->CodPostalCliente }}"
                                        data-ciudad="{{ $cliente->ciudad_Id }}"
                                        data-email="{{ $cliente->EmailCliente }}"
                                        data-agente="{{ $cliente->Agente }}"
                                        data-tipocliente="{{ $cliente->TipoClienteId }}"
                                        data-banco="{{ $cliente->banco_id }}"
                                        data-sctacontable="{{ $cliente->SctaContable }}"
                                        data-observaciones="{{ $cliente->Observaciones }}"
                                        data-user="{{ $cliente->user_id }}"
                                        data-telefonos= {{ $movil }}
                                        class="btn btn-warning ediClienteBtn">
                                        <ion-icon name="create-outline"></ion-icon>
                                    </a>
                                    <a
                                        data-idclientes="{{ $cliente->idClientes }}"
                                        data-cif="{{ $cliente->CIF }}"
                                        data-nombre="{{ $cliente->NombreCliente }}"
                                        data-apellido="{{ $cliente->ApellidoCliente }}"
                                        data-direccion="{{ $cliente->Direccion }}"
                                        data-codpostal="{{ $cliente->CodPostalCliente }}"
                                        data-ciudad="{{ $cliente->ciudad_Id }}"
                                        data-email="{{ $cliente->EmailCliente }}"
                                        data-agente="{{ $cliente->Agente }}"
                                        data-tipocliente="{{ $cliente->TipoClienteId }}"
                                        data-banco="{{ $cliente->banco_id }}"
                                        data-sctacontable="{{ $cliente->SctaContable }}"
                                        data-observaciones="{{ $cliente->Observaciones }}"
                                        data-user="{{ $cliente->user_id }}"
                                        data-telefonos= {{ $movil }}
                                        class="btn btn-info btnDetailsClient"
                                        >
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </a>
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    </div>

    {{-- Crear cliente con campos CIF, NombreCliente, ApellidoCliente, Direccion, codPostalCliente, ciudad_id, EmailCliente, Agente, TipoClienteId, banco_id, SctaContable, Observaciones, user_id --}}
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

    {{-- Mostrar detalle del cliente sin posibilidad de editar --}}
    @component('components.modal-component', [
        'modalId'         => 'modal-cliente-show',
        'modalTitle'      => 'Detalles del Cliente',
        'modalTitleId'    => 'modalTitleDetails',
        'modalSize'       => 'modal-lg',
        'disabledSaveBtn' => true,
        'hideButton'      => true,
    ])
        <div class="modal-body">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cif">CIF</label>
                            <input type="text" name="cif" id="cifDetails" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombreDetails" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" name="apellido" id="apellidoDetails" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="telefonosContainerDetails">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="direccion">Direccion</label>
                            <div class="d-flex justify-content-between">
                                <input type="text" name="direccion" id="direccionDetails" class="form-control direccion" readonly>
                                <button type="button" class="btn btn-outline-primary direccion-btnSearch" id="btnSearch">Buscar</button>
                            </div>
                            <div id="suggestions"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="codPostal">Código Postal</label>
                            <input type="text" name="codPostal" id="codPostalDetails" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cidade_id">Ciudad</label>
                            <input type="text" name="cidade_id" id="cidade_idDetails" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="emailDetails" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="agente">Agente</label>
                            <input type="text" name="agente" id="agenteDetails" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipoClienteId">Tipo de Cliente</label>
                            <input type="text" name="tipoClienteId" id="tipoClienteIdDetails" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="banco_id">Banco</label>
                            <input type="text" name="banco_id" id="banco_idDetails" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sctaContable">Cuenta Contable</label>
                            <input type="text" name="sctaContable" id="sctaContableDetails" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="observacion">Observaciones</label>
                            <textarea name="observacion" id="observacionDetails" class="form-control" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_id">Usuario</label>
                            <input type="text" name="user_id" id="user_idDetails" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcomponent


    {{-- IMPORTADOR DE CLIENTES --}}

    @component('components.modal-component', [
        'modalId'    => 'modal-import-clientes',
        'modalTitle' => 'Importar Clientes',
        'modalSize'  => 'modal-lg',
        'btnSaveId'  => 'btn-save-import-clientes',
    ])
        <form 
            id="form-import-clientes"
            action="{{ route('admin.clientes.import') }}" method="POST" enctype="multipart/form-data"
        >
            @csrf
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="file">Selecciona el archivo de clientes:</label>
                                <input type="file" name="file" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
    @endcomponent

    {{-- modal para fichar rapidamente, un banco, un usuario --}}
    @component('components.modal-component', [
        'modalId'    => 'modal-fast-create',
        'modalTitle' => 'Crear Banco',
        'modalSize'  => 'modal-lg',
        'btnSaveId'  => 'btn-save-fast-create',
        'modalTitleId' => 'modalTitleFastCreate',
    ])
        
    @endcomponent

@stop

@section('js')

    @if ( session('success') )
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if ( session('error') )
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        </script>
        
    @endif

    <script>


        // Inicializar la tabla de citas
        const agTablediv = document.querySelector('#ClientesGrid');

        let rowData = {};
        let data = [];

        const clientes = @json($clientes);

        const cabeceras = [
            {
                name: 'ID',
                fieldName: 'cliente_id',
                addAttributes: true,
                addcustomDatasets: true,
                dataAttributes: {
                    'data-id': ''
                },
                attrclassName: 'editClienteFast',
                styles: {
                    cursor: 'pointer',
                    textDecoration: 'underline'
                },
                principal: true
            },
            {
                name: 'CIF',
                fieldName: 'CIF',
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
                name: 'Nombre',
                fieldName: 'NombreCliente',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "NombreCliente",
                    'data-type': "text"
                }
            },
            {
                name: 'Apellido',
                fieldName: 'ApellidoCliente',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "ApellidoCliente",
                    'data-type': "text"
                }
            },
            {
                name: 'Direccion',
                fieldName: 'Direccion',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "Direccion",
                    'data-type': "text"
                }
            },
            {
                name: 'CP',
                fieldName: 'CodPostalCliente',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "CodPostalCliente",
                    'data-type': "text"
                }
            },
            {
                name: 'Ciudad',
                fieldName: 'nameCiudad',
                addAttributes: true,
                fieldType: 'select',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "ciudad_Id",
                    'data-type': "select"
                }
            },
            {
                name: 'Email',
                fieldName: 'EmailCliente',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "EmailCliente",
                    'data-type': "text"
                }
            },
            {
                name: 'Agente',
                fieldName: 'Agente',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "Agente",
                    'data-type': "text"
                }
            },
            {
                name: 'TCliente',
                fieldName: 'nameTipoCliente',
                addAttributes: true,
                fieldType: 'select',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "tipoCliente_Id",
                    'data-type': "select"
                }
            },
            {
                name: 'Banco',
                fieldName: 'nameBanco',
                addAttributes: true,
                fieldType: 'select',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "banco_id",
                    'data-type': "select"
                }
            },
            {
                name: 'SctaContable',
                fieldName: 'SctaContable',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "SctaContable",
                    'data-type': "text"
                }
            },
            {
                name: 'Observaciones',
                fieldName: 'Observaciones',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "Observaciones",
                    'data-type': "text"
                }
            },
            {
                name: 'MilecoUser',
                fieldName: 'name',
                addAttributes: true,
                fieldType: 'select',
                dataAttributes: {
                    'data-fulltext': ''
                },
                customDatasets: {
                    'data-fieldName': "user_id",
                    'data-type': "select"
                }
            },
            {
                name: 'Notas1',
                fieldName: 'notas1',
                editable: true,
                addAttributes: true,
                fieldType: 'textarea',
                dataAttributes: {
                    'data-fulltext': ''
                },
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


        function prepareRowData(clientes) {
            clientes.forEach(cliente => {
                // if (cliente.proyecto_n_m_n && cliente.proyecto_n_m_n.length > 0) {
                //     console.log({proyecto: cliente.proyecto_n_m_n[0].proyecto.name});
                // }
                rowData[cliente.idClientes] = {
                    ID: cliente.idClientes,
                    CIF: cliente.CIF,
                    Nombre: cliente.NombreCliente,
                    Apellido: cliente.ApellidoCliente,
                    Direccion: cliente.Direccion,
                    CP: cliente.CodPostalCliente,
                    Ciudad: cliente.ciudad.nameCiudad,
                    Email: cliente.EmailCliente,
                    Agente: cliente.Agente,
                    TCliente: cliente.tipo_cliente.nameTipoCliente,
                    Banco: (cliente.banco) ? cliente.banco.nameBanco : '',
                    SctaContable: cliente.SctaContable,
                    Observaciones: cliente.Observaciones,
                    user_id: cliente.user_id,
                    notas1: cliente.notas1,
                    notas2: cliente.notas2,
                    Acciones: 
                    `
                        @component('components.actions-button')
                            <button
                                data-idclientes="${cliente.idClientes}"
                                data-cif="${cliente.CIF}"
                                data-nombre="${cliente.NombreCliente}"
                                data-apellido="${cliente.ApellidoCliente}"
                                data-direccion="${cliente.Direccion}"
                                data-codpostal="${cliente.CodPostalCliente}"
                                data-ciudad="${cliente.ciudad_Id}"
                                data-email="${cliente.EmailCliente}"
                                data-agente="${cliente.Agente}"
                                data-tipocliente="${cliente.TipoClienteId}"
                                data-banco="${cliente.banco_id}"
                                data-sctacontable="${cliente.SctaContable}"
                                data-observaciones="${cliente.Observaciones}"
                                data-user="${cliente.user_id}"
                                data-telefonos= ${JSON.stringify(cliente.telefonos)}
                                class="btn btn-warning ediClienteBtn"
                                >
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <ion-icon name="create-outline"></ion-icon>
                                    <small class="text-info-emphasis" style="font-size: clamp(0.6rem, 1.5vw, 1rem);">
                                        Editar
                                    </small>
                                </div>
                            </button>
                            <button
                                data-idclientes="${cliente.idClientes}"
                                data-cif="${cliente.CIF}"
                                data-nombre="${cliente.NombreCliente}"
                                data-apellido="${cliente.ApellidoCliente}"
                                data-direccion="${cliente.Direccion}"
                                data-codpostal="${cliente.CodPostalCliente}"
                                data-ciudad="${cliente.ciudad_Id}"
                                data-email="${cliente.EmailCliente}"
                                data-agente="${cliente.Agente}"
                                data-tipocliente="${cliente.TipoClienteId}"
                                data-banco="${cliente.banco_id}"
                                data-sctacontable="${cliente.SctaContable}"
                                data-observaciones="${cliente.Observaciones}"
                                data-user="${cliente.user_id}"
                                data-telefonos= ${JSON.stringify(cliente.telefonos)}
                                class="btn btn-info btnDetailsClient"
                                >
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <ion-icon name="eye-outline"></ion-icon>
                                    <small class="text-info-emphasis" style="font-size: clamp(0.6rem, 1.5vw, 1rem);">
                                        Detalles
                                    </small>
                                </div>
                            </button>
                        @endcomponent
                    
                    `
                }
            });

            data = Object.values(rowData);
        }

        prepareRowData(clientes);

        const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
            // boton para crear un nuevo cliente
            const customButtons = `
                <button 
                    class="btn btn-outline-warning btnCreateClient"
                    data-bs-toggle="modal"
                    data-bs-target="#modal-cliente"
                    >
                    Crear cliente
                </button>
                <button 
                    class="btn btn-outline-primary import-clientes"
                    data-bs-toggle="modal"
                    data-bs-target="#modal-import-clientes"
                    >
                    Importar clientes
                </button>
            `;

            // Inicializar la tabla de citas
            inicializarAGtable( agTablediv, data, result, 'Clientes', customButtons, 'Cliente');
        });

        // let table = $('#clientes-table').DataTable({
        //     order: [[0, 'desc']],
        //     colReorder: {
        //         realtime: false
        //     },
        //     // responsive: true,
        //     // autoFill: true,
        //     // fixedColumns: true,
        //     // Ajuste para mostrar los botones a la izquierda, el filtro a la derecha, y el selector de cantidad de registros
        //     dom: "<'row'<'col-12 mb-2'<'table-title'>>>" +
        //     "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
        //     "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
        //     "<'row'<'col-12'tr>>" +
        //     "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

        //     buttons: [
        //         {
        //             text: 'Crear cliente',
        //             className: 'btn btn-outline-warning btnCreateClient mb-2',
        //             action: function () {
        //                 $('#modal-cliente').modal('show');
        //             }
        //         },
        //         {
        //             text: 'Importar clientes',
        //             className: 'btn btn-outline-success mb-2 import-clientes',
        //             action: function () {
        //                 $('#modal-import-clientes').modal('show');
        //             }
        //         },
        //         {
        //             text: 'Limpiar Filtros', 
        //             className: 'btn btn-outline-danger limpiarFiltrosBtn mb-2', 
        //             action: function (e, dt, node, config) { 
        //                 clearFiltrosFunction(dt, '#clientes-table');
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
        //         // {
        //         //     targets: [1],
        //         //     render: function(data, type, row) {
        //         //         return moment(data).format('YYYY-MM-DD');
        //         //     }
        //         // }
        //     ],
        //     initComplete: function () {
        //         configureInitComplete(this.api(), '#clientes-table', 'CLIENTES', 'info');
        //     }
        // });

        // table.on('init.dt', function() {
        //     restoreFilters(table, '#clientes-table'); // Restaurar filtros después de inicializar la tabla
        // });

        // mantenerFilaYsubrayar(table);
        // fastEditForm(table, 'Cliente');

        let table = $('#ClientesGrid');

        $('.text-truncate').css('cursor', 'pointer');

        $('.limpiarFiltrosBtn').removeClass('dt-button');

        $('.import-clientes').removeClass('dt-button');
        $('.btnCreateClient').removeClass('dt-button');

        $(document).ready(function() {
            // Inicializa Select2 cuando el modal se muestra
            $('#modal-cliente').on('shown.bs.modal', function() {
                // Destruir la instancia de Select2, si existe
                if ($('.user_id').data('select2')) {
                    $('.user_id').select2('destroy');
                }

                // Inicializa Select2
                $('.user_id').select2({
                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                    height: '150px', // Se asegura de que el select ocupe el 100% del contenedor
                    dropdownParent: $('#modal-cliente') // Asocia el dropdown con el modal para evitar problemas de superposición
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

        });

        table.on('dblclick', '.OpenHistorialCliente', function(event){
            const elemento  = $(this);
            const span      = elemento.find('span')[1]
            const parteid   = span.getAttribute('data-parteid');

            getEditCliente(parteid, 'Cliente');
        });

        table.on('dblclick', '.editClienteFast', function(event){
            const parteid   = $(this).data('parteid');

            getEditCliente(parteid, 'Cliente');
        });

        // Agregar otro input para agregar otro telefono a cada telefono se puede destruir el input
        $('#btnAddTelefono').click(function() {

            //como maximo se pueden agregar 3 telefonos
            if ($('#telefonosContainer').children().length >= 3) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Solo puedes agregar 3 telefonos',
                })
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

        $('#btnCreateClient').click(function() {
            $('#modal-cliente').modal('show');
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

            // if ( telefonos.length === 0 ) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Oops...',
            //         text: 'Debes agregar al menos un telefono',
            //     });
            //     return;
            // }

            let isNumberValid = true;

            // Array.from(telefonos).forEach( telefono => {

            //     const regex = /^[0-9]+$/;

            //     if (!telefono.value.match(regex)) {
            //         e.preventDefault();
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Oops...',
            //             text: 'El telefono debe ser un número',
            //         });
            //         isNumberValid = false;
            //         return;
            //     }

            //     if (telefono.value === '') {
            //         e.preventDefault();
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Oops...',
            //             text: 'Todos los campos son requeridos',
            //         });
            //         isNumberValid = false;
            //         return;
            //     }
            //     if (telefono.value.length < 9 || telefono.value.length > 9) {
            //         e.preventDefault();
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Oops...',
            //             text: 'El telefono debe tener al menos 9 digitos',
            //         });
            //         isNumberValid = false;
            //         return;
            //     }
            // })


            if ( nombre === '' ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El nombre es requerido',
                });
                return;
            }
            
            // valida que el email tenga el formato correcto @ y .
            // let emailFormat = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            // if (!email.match(emailFormat)) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Oops...',
            //         text: 'El email no tiene el formato correcto',
            //     })
            //     return;
            // }

            if (isNumberValid) {
                $('#form-cliente').submit();
            }
        });

    </script>

    {{-- Details modal --}}

    <script>
        $(document).ready(function() {
            $('#ClientesGrid').on('click', '.btnDetailsClient', function() {
                let idClientes   = $(this).data('idclientes');
                let cif          = $(this).data('cif');
                let nombre       = $(this).data('nombre');
                let apellido     = $(this).data('apellido');
                let direccion    = $(this).data('direccion');
                let codPostal    = $(this).data('codpostal');
                let ciudad       = $(this).data('ciudad');
                let email        = $(this).data('email');
                let agente       = $(this).data('agente');
                let tipoCliente  = $(this).data('tipocliente');
                let banco        = $(this).data('banco');
                let sctaContable = $(this).data('sctacontable');
                let observaciones = $(this).data('observaciones');
                let user          = $(this).data('user');
                let movil         = $(this).data('telefonos');

                const telefonosContainerDetails = $('#telefonosContainerDetails');

                // Limpia el contenedor de telefonos
                telefonosContainerDetails.empty();

                // Agrega los telefonos al contenedor
                movil.forEach(( telefono, index ) => {
                    let label = $('<label class="mb-2" for="telefono">Telefono ' + (index + 1) + '</label>');
                    let input = $('<input type="text" class="form-control mb-2" value="' + telefono + '" readonly>');
                    telefonosContainerDetails.append(label).append(input);
                });

                $('#modalTitleDetails').text('Detalles del Cliente: ' + nombre + ' ' + apellido);

                $('#cifDetails').val(cif);
                $('#nombreDetails').val(nombre);
                $('#apellidoDetails').val(apellido);
                $('#direccionDetails').val(direccion);
                $('#codPostalDetails').val(codPostal);
                $('#cidade_idDetails').val(ciudad);
                $('#emailDetails').val(email);
                $('#agenteDetails').val(agente);
                $('#tipoClienteIdDetails').val(tipoCliente);
                $('#banco_idDetails').val(banco);
                $('#sctaContableDetails').val(sctaContable);
                $('#observacionDetails').val(observaciones);
                $('#user_idDetails').val(user);

                $('#modal-cliente-show').modal('show');
            });
        });
    </script>

    {{-- Edit Client Modal --}}

    <script>
        $(document).on('click', '.ediClienteBtn', function() {
            let idClientes   = $(this).data('idclientes');
            getEditCliente(idClientes);
        });

        // Editar cliente

        $('#btn-save-cliente-edit').on('click', function() {

            //validar cada input que sea requerido y con el formato correcto
            let cif         = $('#cifEdit').val();
            let nombre      = $('#nombreEdit').val();

            if (cif === '' || nombre === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El CIF y el nombre son requeridos',
                });
                return;
            }

            // // valida que el email tenga el formato correcto @ y .
            // let emailFormat = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            // if (!email.match(emailFormat)) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Oops...',
            //         text: 'El email no tiene el formato correcto',
            //     })
            //     return;
            // }

            $('#form-cliente-edit').submit();
        });

        // esuchar el evento cuando se abre el modal de editar cliente
        $('#modal-cliente-edit').on('shown.bs.modal', function() {
            // Inicializa Select2
            $('#modal-cliente-edit select.form-select').select2({
                width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                height: 'auto', // Se asegura de que el select ocupe el 100% del contenedor
                dropdownParent: $('#modal-cliente-edit') // Asocia el dropdown con el modal para evitar problemas de superposición
            });

            // hacer todos los textareas autoajustables
            $('#modal-cliente-edit textarea').css('height', 'auto');
            $('#modal-cliente-edit textarea').height($('#modal-cliente-edit textarea')[0].scrollHeight);

            // agregar un evento para que el textarea se ajuste automaticamente
            $('#modal-cliente-edit textarea').on('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

        });
            
    </script>

    {{-- Importar clientes --}}
    <script>
        $(document).ready(function() {
            $('#btnImportClients').click(function() {
                $('#modal-import-clientes').modal('show');
            });

            $('#btn-save-import-clientes').click(function() {
                $('#form-import-clientes').submit();
            });
        });
    </script>

@stop
