@extends('adminlte::page')

@section('title', 'Estadisticas')


@section('content')

    <style>

        .text-truncate{
            cursor: pointer;
            text-decoration: underline;
        }

        .text-truncate:hover {
            text-decoration: dotted underline;
        }

        canvas {
            max-width: 400px;   /* Ancho máximo para los gráficos */
            max-height: 400px;  /* Alto máximo para los gráficos */
            width: 100%;        /* Se ajusta al 100% del contenedor padre */
            height: auto;       /* Mantiene el aspecto */
        }

        /* From Uiverse.io by dylanharriscameron */ 
        .cardResumen {
            position: relative;
            width: 200px;
            height: 250px;
            border-radius: 14px;
            z-index: 3;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
        ;
        }

        .cardResumen .bg {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 190px;
            height: 240px;
            z-index: 1;
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(24px);
            border-radius: 10px;
            overflow: hidden;
            outline: 2px solid white;
        }

        .cardResumen .blob {
            position: absolute;
            z-index: 0;
            top: 50%;
            left: 50%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #ff0000;
            opacity: 1;
            filter: blur(12px);
            animation: blob-bounce 3s infinite ease;
        }

        /* ajustar el contenido cuando tiene valores muy grandes */
        .cardResumenContent h1{
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            padding: 1rem;
        }

        /* cambiar el tamaño en modo movil para que se adapten */
        @media (max-width: 768px) {
            .cardResumen {
                width: 150px;
                height: 200px;
            }

            .cardResumen .bg {
                width: 140px;
                height: 190px;
            }

            .cardResumen .blob {
                width: 100px;
                height: 100px;
            }

            /* Ajustar el contenido cuanto tiene valores muy grandes */
            .cardResumenContent h1{
                font-size: 1rem;
                font-weight: 700;
                text-align: center;
                padding: 1rem;
            }

        }

        .cardResumen[data-color="2"] .blob {
            background-color: #00ff00;
        }

        .cardResumen[data-color="3"] .blob {
            background-color: #0000ff;
        }

        .cardResumen[data-color="4"] .blob {
            background-color: rgba(251, 168, 22, 0.8);
        }

        .cardResumen[data-color="5"] .blob {
            background-color: rgba(84, 255, 189, 0.8);
        }

        .cardResumen[data-color="6"] .blob {
            background-color: rgba(3, 3, 3, 0.8);
        }

        .cardResumenContent{
            z-index: 3;
            position: relative;
            color: #000;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            padding: 1rem;
        }

        /* cuando hagan hover mostrar un tooltip un letrero que eso consiste en el mes actual y mostrar més actual */
        .cardResumen:hover::before {
            content: "Mes actual";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            border-radius: 10px;
            z-index: 4;
        }

        /* Añadir clamp a los textos para textos responsive */
        .cardResumenContent h1{
            font-size: clamp(1rem, 2vw, 1.5rem);
        }

        .cardResumenContent h3{
            font-size: clamp(1rem, 2vw, 1.5rem);
        }
        

        @keyframes blob-bounce {
            0% {
                transform: translate(-100%, -100%) translate3d(0, 0, 0);
            }

            25% {
                transform: translate(-100%, -100%) translate3d(100%, 0, 0);
            }

            50% {
                transform: translate(-100%, -100%) translate3d(100%, 100%, 0);
            }

            75% {
                transform: translate(-100%, -100%) translate3d(0, 100%, 0);
            }

            100% {
                transform: translate(-100%, -100%) translate3d(0, 0, 0);
            }
        }

        .grid-container {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            justify-items: center;
            width: 100%;
        }

            /* Media Queries para pantallas medianas como tablets y portátiles */
        @media (max-width: 1200px) {
            .grid-container {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 25px; /* Mayor separación entre las tarjetas */
            }
        }

        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 15px; /* Ajustar separación para móviles medianos */
            }
        }

        @media (max-width: 576px) {
            .grid-container {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 10px; /* Menor separación para móviles pequeños */
            }
        }
        
        @media (max-width: 350px) {
            .grid-container {
                grid-template-columns: repeat(auto-fit, minmax(100%, 1fr));
                gap: 5px; /* Menor separación para móviles pequeños */
            }
        }


    </style>

    {{-- Graficos --}}
    <div class="row">

        {{-- Resumenes Cards --}}
        <div class="container mt-3">
            <div class="grid-container gap-2">
                <!-- Tarjeta 1 -->
                <div class="cardResumen">
                    <div class="bg"></div>
                    <div class="blob"></div>
                    <div class="d-flex flex-column justify-content-center align-items-center h-100 cardResumenContent">
                        <h3 class="text-center">Total de Compras</h3>
                        <h1 class="text-center">{{ formatPrice($totalCompras) }}</h1>
                    </div>
                </div>
        
                <!-- Tarjeta 2 -->
                <div class="cardResumen" data-color="2">
                    <div class="bg"></div>
                    <div class="blob"></div>
                    <div class="d-flex flex-column justify-content-center align-items-center h-100 cardResumenContent">
                        <h3 class="text-center">Total de Ventas</h3>
                        <h1 class="text-center">{{ formatPrice($totalVentas) }}</h1>
                    </div>
                </div>
        
                <!-- Tarjeta 3 -->
                <div class="cardResumen" data-color="3">
                    <div class="bg"></div>
                    <div class="blob"></div>
                    <div class="d-flex flex-column justify-content-center align-items-center h-100 cardResumenContent">
                        <h3 class="text-center">Total de Cobros</h3>
                        <h1 class="text-center">{{ formatPrice($totalCobros) }}</h1>
                    </div>
                </div>
        
                <!-- Tarjeta 4 -->
                <div class="cardResumen" data-color="4">
                    <div class="bg"></div>
                    <div class="blob"></div>
                    <div class="d-flex flex-column justify-content-center align-items-center h-100 cardResumenContent">
                        <h3 class="text-center">Total Partes S/Fac: <small class="text-muted" style="font-size: 12px">({{ $totalPartesSinFacturarCount }})</small></h3>
                        <h1 class="text-center">{{ formatPrice($totalPartesSinFacturar) }}</h1>
                    </div>
                </div>
        
                <!-- Tarjeta 5 -->
                <div class="cardResumen" data-color="5">
                    <div class="bg"></div>
                    <div class="blob"></div>
                    <div class="d-flex flex-column justify-content-center align-items-center h-100 cardResumenContent">
                        <h3 class="text-center">Presupuestos de {{ $mesEnCurso }}</h3>
                        <h1 class="text-center">{{ $presupuestosCount }}</h1>
                    </div>
                </div>
        
                <!-- Tarjeta 6 -->
                <div class="cardResumen" data-color="6">
                    <div class="bg"></div>
                    <div class="blob"></div>
                    <div class="d-flex flex-column justify-content-center align-items-center h-100 cardResumenContent">
                        <h3 class="text-center">Total Presupuestos</h3>
                        <h1 class="text-center">{{ formatPrice($presupuestos) }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="empresaSelect">Selecciona una empresa:</label>
                    <select id="empresaSelect" class="form-control select2">
                        <option value="">Seleccione una empresa</option>
                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->idEmpresa }}">{{ $empresa->EMP }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="periodoSelect">Selecciona un periodo:</label>
                    <select id="periodoSelect" class="form-control">
                        <option value="mensual">Mensual</option>
                        <option value="trimestral">Trimestral</option>
                        <option value="anual">Anual</option>
                    </select>
                </div>
            </div>
        
            <div class="row mt-4">
                <div id="resumenGrid" style="width: 100%; height: 500px;" class="ag-theme-quartz"></div>
            </div>
        </div>

        {{-- Articulos más vendidos --}}
        <div class="col-12 mt-2 mb-2">
            <div class="card">
                <div class="card-body">
                    <div id="articulosmasvendidos" style="width: 100%; height: 500px;" class="ag-theme-quartz"></div>
                </div>
            </div>
        </div>

    </div>

    @component('components.modal-component', [
        "modalId" => 'modalDetailsEstadisticas',
        "modalTitleId" => 'modalDetailsEstadisticasTitle',
        "modalSize"  => 'modal-xl',
        "modalTitle" => 'Detalles de la transacción',
        "hideButton" => true,
        "disabledSaveBtn" => true,        
    ])

        <div class="row" id="containerModal">
            
        </div>
        
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'createVentaModal',
        'modalTitle' => 'Crear Venta',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveVentaBtn',
        'disabledSaveBtn' => true,
        'hideButton' => true
    ])
        @include('admin.ventas.partials.create-edit-form')
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'editVentaModal',
        'modalTitle' => 'Editar venta',
        'modalTitleId' => 'editVentaTitle',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveEditVentaBtn',
        // 'disabledSaveBtn' => true
    ])
        @include('admin.ventas.partials.create-edit-form')
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'showVentaModal',
        'modalTitle' => 'Detalles de la Venta',
        'modalSize' => 'modal-xl',
        'btnSaveId' => '',
    ])
        <div id="ventaDetailsContainer"></div>
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'plazosModal',
        'modalTitle' => 'Plazos de la Venta',
        'modalSize' => 'modal-xl',
        'modalTitleId' => 'plazosModalTitle',
        'btnSaveId' => '',
    ])
        <div id="plazosContainer" class="accordion" id="accordionPlazos"></div>
    @endcomponent

    @component('components.modal-component', [
        'modalId' => 'cobroModal',
        'modalTitle' => 'Registrar Cobro',
        'modalSize' => 'modal-lg',
        'btnSaveId' => 'btnGuardarCobro',
    ])
        <form id="cobroForm">
            <div class="form-group">
                <label for="montoCobro">Monto a Cobrar</label>
                <input type="number" class="form-control" id="montoCobro" name="montoCobro" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label for="fechaCobro">Fecha de Cobro</label>
                <input type="date" class="form-control" id="fechaCobro" name="fechaCobro">
            </div>
            <div class="form-group">
                {{-- Select al banco donde se va a ingresar ese cobro --}}
                <label for="bancoCobro">Banco</label>
                <select class="form-select" id="bancoCobro" name="bancoCobro">
                    @foreach ($bancos as $banco)
                        <option value="{{ $banco->idbanco }}">{{ $banco->nameBanco }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" id="plazoId" name="plazoId">
            <input type="hidden" id="totalPlazo" name="totalPlazo">
            <input type="hidden" id="cobradoActual" name="cobradoActual">
        </form>
    @endcomponent

    <!-- Modal para Crear Compra -->
    @component('components.modal-component', [
        'modalId' => 'modalCreateCompra',
        'modalTitle' => 'Crear Compra',
        'modalSize' => 'modal-xl',
        'modalTitleId' => 'createCompraTitle',
        'btnSaveId' => 'btnCreateCompra',
        'disabledSaveBtn' => true,
        'hideButton' => true
    ])
        <div id="accordion">

            <!-- Acordeón Detalles de la Compra -->
            <div style="margin: 1rem;" class="accordion-item">
                <h2 class="accordion-header" id="headingDetallesCompra">
                    <button id="detailShop" style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetallesCompra" aria-expanded="true" aria-controls="collapseDetallesCompra">
                        Detalles de la Compra
                    </button>
                </h2>
                <div id="collapseDetallesCompra" class="accordion-collapse collapse show" aria-labelledby="headingDetallesCompra" data-bs-parent="#accordion">
                    <form id="formCreateCompra" class="accordion-body" enctype="multipart/form-data">
                        <div class="card-body">

                            <input type="hidden" name="idCompra" id="idCompraCreate">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required-field">
                                        <label class="form-label" for="fechaCompra">Fecha de Compra</label>
                                        <input type="date" class="form-control" id="fechaCompra" name="fechaCompra" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required-field">
                                        <label class="form-label" for="empresa_id">Empresa</label>
                                        <select class="form-select" id="empresa_id" name="empresa_id" required>
                                            <option value="">Seleccione una empresa</option>
                                            @foreach($empresas as $empresa)
                                                <option value="{{ $empresa->idEmpresa }}">{{ $empresa->EMP }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required-field">
                                        <label class="form-label" for="NFacturaCompra">Número de Factura</label>
                                        <input type="text" class="form-control" id="NFacturaCompra" name="NFacturaCompra" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required-field">
                                        <label class="form-label" for="proveedor_id">Proveedor</label>
                                        <select class="form-select" id="proveedor_id" name="proveedor_id" required>
                                            <option value="">Seleccione un proveedor</option>
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor->idProveedor }}">{{ $proveedor->nombreProveedor }}</option>
                                            @endforeach
                                        </select>
                                        <small id="proveedorHelpCreateCompra" class="form-text text-muted">Si no encuentra el proveedor, puede crearlo aquí</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group required-field">
                                        <label class="form-label" for="formaPago">Forma de Pago</label>
                                        <select class="form-select" id="formaPago" name="formaPago" required>
                                            <option value="1">Banco</option>
                                            <option value="2">Efectivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Importe">Importe</label>
                                        <input type="number" class="form-control" id="Importe" name="Importe" value="0" step="0.01" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Iva">IVA</label>
                                        <input type="number" class="form-control" id="IvaCreateCompra" name="Iva" value="21" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="totalIva">Total IVA</label>
                                        <input type="number" class="form-control" id="totalIvaCreateCompra" value="0" name="totalIva" step="0.01" required readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group required-field">
                                        <label for="totalFactura">Total Exacto</label>
                                        <input type="number" class="form-control" id="totalFacturaCreateCompraExacto" value="0" name="totalFacturaExacto" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="totalFactura">Total Factura</label>
                                        <input type="number" class="form-control" id="totalFacturaCreateCompra" value="0" name="totalFactura" step="0.01" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="suplidosCompras">Suplidos</label>
                                        <input type="number" class="form-control" id="suplidosCompras" value="0" name="suplidosCompras" step="0.01">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group required-field">
                                <label class="form-label" for="NAsientoContable">Número de Asiento Contable</label>
                                <input type="text" class="form-control" id="NAsientoContable" name="NAsientoContable">
                            </div>

                            <div class="form-group">
                                <label for="ObservacionesCompras">Observaciones</label>
                                <textarea class="form-control" id="ObservacionesCompras" name="ObservacionesCompras" rows="3" required></textarea>
                            </div>

                            <div class="form-group required-field">
                                <label class="form-label" for="Plazos">Plazos</label>
                                <select class="form-select" id="Plazos" name="Plazos" required>
                                    <option value="0">Pagado</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                </select>
                            </div>
                            
                            <!-- Campos para Plazo 1 -->
                            <div class="form-group plazo-fields plazo1 required-field" style="display: none;">
                                <label class="form-label" for="proximoPago">Próxima Fecha de Pago</label>
                                <input type="date" class="form-control" id="proximoPago" name="proximoPago">
                            </div>
                            
                            <!-- Campos para Plazo 2 -->
                            <div class="form-group plazo-fields plazo2 required-field" style="display: none;">
                                <label class="form-label" for="frecuenciaPago">Frecuencia de Pagos</label>
                                <select class="form-select" id="frecuenciaPagoCreate" name="frecuenciaPago">
                                    <option value="mensual">Mensual</option>
                                    <option value="semanal">Semanal</option>
                                    <option value="quincenal">Quincenal</option>
                                </select>
                            </div>
                            <div class="form-group plazo-fields plazo2 required-field" style="display: none;">
                                <label class="form-label" for="siguienteCobro">Fecha del Siguiente Cobro</label>
                                <input type="date" class="form-control" id="siguienteCobroCreate" name="siguienteCobro">
                            </div>

                            <!-- Campo oculto para el usuario logueado -->
                            <input type="hidden" name="userAction" id="userAction" value="{{ Auth::id() }}">

                            <div id="previewOfPdfCreate" class="form-group mb-3">
                                
                            </div>

                            <div class="form-group mb-3 required-field">
                                <label class="form-label" for="fileCreate">Factura</label>
                                <input type="file" class="form-control" id="fileCreate" name="file"></input>
                            </div>

                            <div class="form-group mb-3">
                                <button type="button" class="btn btn-outline-warning" id="guardarCompra">Guardar</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- Acordeón Elementos de Compra -->
            <div style="margin: 1rem;" class="accordion-item">
                <h2 class="accordion-header" id="headingElementosCompra">
                    <button style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseElementosCompra" aria-expanded="false" aria-controls="collapseElementosCompra">
                        Elementos de Compra
                    </button>
                </h2>
                <div id="collapseElementosCompra" class="accordion-collapse collapse" aria-labelledby="headingElementosCompra" data-bs-parent="#accordion">
                    <div class="accordion-body">
                        <div class="container">
                            <table id="tableToShowElements" class="table" style="font-size: 10px">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>C.Prov</th>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Precio sin IVA</th>
                                        <th>RAE</th>
                                        <th>Descuento</th>
                                        <th>Proveedor</th>
                                        <th>Trazabilidad</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="elementsToShow">
                                    
                                </tbody>
                            </table>
                        </div>

                        <button id="addNewLine" type="button" class="btn btn-outline-primary mb-2">Añadir línea</button>

                        <div class="mb-2" id="newLinesContainer"></div>
                    </div>
                </div>
            </div>

        </div>
    @endcomponent

    {{-- Modal para ver los detalles de la factura junto a sus respectivas lineas de compra, todos los campos deben de ser readonly --}}
    @component('components.modal-component', [
        'modalId' => 'modalDetailsCompra',
        'modalTitle' => 'Detalles de la compra',
        'modalSize' => 'modal-xl',
        'modalTitleId' => 'DetailsCompraTitle',
        'disabledSaveBtn' => true,
        'hideButton' => true
    ])
        <div id="accordion">

            <!-- Acordeón Detalles de la Compra -->
            <div style="margin: 1rem;" class="accordion-item">
                <h2 class="accordion-header" id="headingDetallesCompraDetails">
                    <button id="detailShopDetails" style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetallesCompra" aria-expanded="true" aria-controls="collapseDetallesCompra">
                        Detalles de la Compra
                    </button>
                </h2>
                <div id="collapseDetallesCompra" class="accordion-collapse collapse show" aria-labelledby="headingDetallesCompra" data-bs-parent="#accordion">
                    <form id="formCreateCompra" class="accordion-body" enctype="multipart/form-data">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fechaCompra">Fecha de Compra</label>
                                        <input type="date" class="form-control" id="fechaCompraDetails" name="fechaCompra" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="empresa_id">Empresa</label>
                                        <select class="form-select" id="empresa_idDetails" name="empresa_id" required>
                                            <option value="">Seleccione una empresa</option>
                                            @foreach($empresas as $empresa)
                                                <option value="{{ $empresa->idEmpresa }}">{{ $empresa->EMP }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="NFacturaCompra">Número de Factura</label>
                                        <input type="text" class="form-control" id="NFacturaCompraDetails" name="NFacturaCompra" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="proveedor_id">Proveedor</label>
                                        <select class="form-select" id="proveedor_idDetails" name="proveedor_id" required>
                                            <option value="">Seleccione un proveedor</option>
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor->idProveedor }}">{{ $proveedor->nombreProveedor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formaPago">Forma de Pago</label>
                                        <select class="form-select" id="formaPagoDetails" name="formaPago" required>
                                            <option value="1">Banco</option>
                                            <option value="2">Efectivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Importe">Importe</label>
                                        <input type="number" class="form-control" id="ImporteDetails" name="Importe" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Iva">IVA</label>
                                        <input type="number" class="form-control" id="IvaCreateCompraDetails" name="Iva" value="21" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="totalIva">Total IVA</label>
                                        <input type="number" class="form-control" id="totalIvaCreateCompraDetails" name="totalIva" value="0" step="0.01" required readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="totalFactura">Total Factura</label>
                                        <input type="number" class="form-control" id="totalFacturaCreateCompraDetails" value="0" name="totalFactura" step="0.01" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="suplidosCompras">Suplidos</label>
                                        <input type="number" class="form-control" id="suplidosComprasDetails" value="0" name="suplidosCompras" step="0.01">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="NAsientoContable">Número de Asiento Contable</label>
                                <input type="text" class="form-control" id="NAsientoContableDetails" name="NAsientoContable">
                            </div>

                            <div class="form-group">
                                <label for="ObservacionesCompras">Observaciones</label>
                                <textarea class="form-control" id="ObservacionesComprasDetails" name="ObservacionesCompras" rows="3" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Plazos">Plazos</label>
                                <select class="form-select" id="PlazosDetails" name="Plazos" required>
                                    <option value="0">Pagado</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                </select>
                            </div>
                            
                            <!-- Campos para Plazo 1 -->
                            <div class="form-group plazo-fields plazo1" style="display: none;">
                                <label for="proximoPago">Próxima Fecha de Pago</label>
                                <input type="date" class="form-control" id="proximoPagoDetails" name="proximoPago">
                            </div>
                            
                            <!-- Campos para Plazo 2 -->
                            <div class="form-group plazo-fields plazo2" style="display: none;">
                                <label for="frecuenciaPago">Frecuencia de Pagos</label>
                                <select class="form-select" id="frecuenciaPagoDetails" name="frecuenciaPago">
                                    <option value="mensual">Mensual</option>
                                    <option value="semanal">Semanal</option>
                                    <option value="quincenal">Quincenal</option>
                                </select>
                            </div>
                            <div class="form-group plazo-fields plazo2" style="display: none;">
                                <label for="siguienteCobro">Fecha del Siguiente Cobro</label>
                                <input type="date" class="form-control" id="siguienteCobroDetails" name="siguienteCobro">
                            </div>

                            <!-- Campo oculto para el usuario logueado -->
                            <input type="hidden" name="userAction" id="userActionDetails" value="{{ Auth::id() }}">

                            <div id="previewOfPdf" class="form-group mb-3">
                                
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- Acordeón Elementos de Compra -->
            <div style="margin: 1rem;" class="accordion-item">
                <h2 class="accordion-header" id="headingElementosCompraDetails">
                    <button style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseElementosCompra" aria-expanded="false" aria-controls="collapseElementosCompra">
                        Lineas de Compra
                    </button>
                </h2>
                <div id="collapseElementosCompra" class="accordion-collapse collapse" aria-labelledby="headingElementosCompra" data-bs-parent="#accordion">
                    <div class="accordion-body">
                        <div class="container">
                            <div class="table-responsive">
                                <table id="tableToShowElementsDetails" class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Id de compra</th>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Precio sin IVA</th>
                                            <th>Descuento</th>
                                            <th>Proveedor</th>
                                            <th>Trazabilidad</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="elementsToShowDetails">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mb-2" id="newLinesContainer"></div>
                    </div>
                </div>
            </div>

        </div>
    @endcomponent


    @component('components.modal-component', [
        'modalId' => 'modalEditLineaCreate',
        'modalTitle' => 'Editar Línea de Compra',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editLineaTitleCreate',
        'btnSaveId' => 'btnSaveEditLineaCreate'
    ])

        <form id="formEditLinea">
            @csrf
            @method('PUT')

            <input type="hidden" name="idLinea" id="idLineaEdit">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" id="descripcionEdit" name="descripcion" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" id="cantidadEdit" name="cantidad" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="rae">RAE</label>
                        <input type="number" class="form-control" id="raeEdit" name="rae" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="precioSinIva">Precio sin IVA</label>
                        <input type="number" class="form-control" id="precioSinIvaEdit" name="precioSinIva" step="0.01" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="descuento">Descuento</label>
                        <input type="number" class="form-control" id="descuentoEdit" name="descuento" step="0.01" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" class="form-control" id="totalEdit" name="total" step="0.01" required readonly>
                    </div>
                </div>
            </div>

        </form>
        
    @endcomponent

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

    @component('components.modal-component', [
        'modalId' => 'editParteTrabajoModal',
        'modalTitle' => 'Editar Parte de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveEditParteTrabajoBtn',
        'modalTitleId' => 'editParteTrabajoTitle',
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
    

@stop

@section('css')

@stop


@section('js')
<script>

    document.addEventListener('DOMContentLoaded', function(event){
        // obtener el segundo valor de un select con jquery
        let firstValue = $('#empresaSelect option:eq(1)').val();

        // autoseleccionar el primer elemento de los selectores al cargar la página
       setTimeout(() => {
            $('#empresaSelect').val(firstValue).trigger('change');
       }, 100);
    })

    $(document).ready(function () {
        $('#empresaSelect').select2();
        let gridOptionsApi = '';

        // Configuración de las columnas y opciones de la cuadrícula
        let gridOptions = {
            columnDefs: [
                { 
                    headerName: "Movimiento", 
                    field: "tipo_transaccion" 
                },
                {
                    headerName: "Importe",
                    field: "Importe",
                    valueFormatter: params => `${formatPrice(params.value)}`,
                    cellStyle: { textAlign: 'right' },
                },
                { 
                    headerName: "IVA%", 
                    field: "porcentajeIVA", 
                    valueFormatter: params => `${params.value}`,
                    cellStyle: { textAlign: 'right' },
                },
                {
                    headerName: "TIVA",
                    field: "total_iva",
                    valueFormatter: params => `${formatPrice(params.value)}`,
                    cellStyle: { textAlign: 'right' },
                },
                {
                    headerName: "Total",
                    field: "total",
                    valueFormatter: params => `${formatPrice(params.value)}`,
                    cellStyle: { textAlign: 'right' },
                },
                { headerName: "Cantidad", field: "cantidad", cellStyle: { textAlign: 'right' } },
                { headerName: "Periodo", field: "periodo", cellStyle: { textAlign: 'right' } },
                { 
                    headerName: "Acciones",
                    field: "Acciones",
                    filter: false,
                    sortable: false,
                    resizable: true,
                    width: 100,
                    flex: 1,
                    minWidth: 50,
                    // menuTabs: ['filterMenuTab', 'generalMenuTab', 'columnsMenuTab'],
                    cellRenderer: function(params) {
                        return params.value; // Renderiza el HTML que enviaste en `Acciones`
                    },
                    suppressAutoSize: true,
                    cellClass: 'acciones-column'
                }
            ],
            rowData: [],
            pagination: true,
            paginationPageSize: 10,
            defaultColDef: {
                flex: 1,
                minWidth: 80,
                sortable: true,
                resizable: true,
                filter: true,
            },
            onGridReady: function(params) {
                gridOptionsApi = params;
            },
        };

        // Inicializar la cuadrícula
        const gridDiv = document.querySelector('#resumenGrid');
        const gridInstance = agGrid.createGrid(gridDiv, gridOptions);


        // Función para cargar los datos en la cuadrícula
        function cargarResumen() {
            // Obtén los valores seleccionados
            const empresaId = $('#empresaSelect').val();
            const periodo = $('#periodoSelect').val();

            // Validar que los campos necesarios están seleccionados
            if (!empresaId || !periodo) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Por favor, seleccione una empresa y un periodo para cargar los datos.'
                });
                return;
            }

            setTimeout(() => {
                const allDisplayedRows = [];
                const rowCount = gridOptionsApi.api.getDisplayedRowCount();

                for (let i = 0; i < rowCount; i++) {
                    const rowNode = gridOptionsApi.api.getDisplayedRowAtIndex(i);
                    if (rowNode) {
                        allDisplayedRows.push(rowNode.data);
                    }
                }
        
                // Eliminar todas las filas visibles
                gridOptionsApi.api.applyTransaction({ remove: allDisplayedRows });
            }, 100);

            // Realizar la solicitud AJAX
            $.ajax({
                url: '{{ route("admin.estadisticas.resumen") }}',
                method: 'POST',
                data: {
                    empresa_id: empresaId,
                    periodo: periodo,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    // Verificar si los datos vienen correctamente estructurados
                    if (response.transacciones || response.ventas || response.compras) {
                        // Procesa los datos y actualiza la tabla/grid
                        const rowData = [];

                        // Agregar las ventas al conjunto de datos
                        if (response.ventas) {
                            response.ventas.forEach(venta => {
                                rowData.push({
                                    tipo: 'Venta',
                                    detalle: 'Total Ventas',
                                    Importe: venta.totalImporte,
                                    total: venta.total,
                                    total_iva: venta.totalIva,
                                    cantidad: venta.cantidad,
                                    periodo: venta.periodo,  // Cambiado de "mes" a "periodo"
                                    tipo_transaccion: 'Ventas',
                                    porcentajeIVA: venta.porcentajeIVA,
                                    Acciones: `
                                        @component('components.actions-button')
                                            <button
                                                class="btn btn-sm btn-primary openDetailsEstadisticas"
                                                data-toggle="tooltip"
                                                title="Ver detalles"
                                                data-placement="top"
                                                data-total="${venta.total}"
                                                data-totaliva="${venta.totalIva}"
                                                data-totalimporte="${venta.totalImporte}"
                                                data-cantidad="${venta.cantidad}"
                                                data-periodo="${venta.periodo}"
                                                data-empresa="${empresaId}"
                                                data-selector="${periodo}"
                                                data-iva="${venta.porcentajeIVA}"
                                                data-tipo="venta"
                                            >
                                                <ion-icon name="eye-outline"></ion-icon>
                                            </button>
                                        @endcomponent
                                    `
                                });
                            });
                        }

                        // Agregar las compras al conjunto de datos
                        if (response.compras) {
                            response.compras.forEach(compra => {
                                rowData.push({
                                    tipo: 'Compra',
                                    detalle: 'Total Compras',
                                    total: compra.total,
                                    cantidad: compra.cantidad,
                                    periodo: compra.periodo,  // Cambiado de "mes" a "periodo"
                                    tipo_transaccion: 'Compras',
                                    porcentajeIVA: compra.porcentajeIVA,
                                    total_iva: compra.totalIva,
                                    Importe: compra.totalImporte,
                                    Acciones: `
                                        @component('components.actions-button')

                                            <button
                                                class="btn btn-sm btn-primary openDetailsEstadisticas"
                                                data-toggle="tooltip"
                                                title="Ver detalles"
                                                data-placement="top"               
                                                data-total="${compra.total}"
                                                data-totaliva="${compra.totalIva}"
                                                data-totalimporte="${compra.totalImporte}"
                                                data-cantidad="${compra.cantidad}"
                                                data-periodo="${compra.periodo}"
                                                data-tipo="compra"
                                                data-empresa="${empresaId}"
                                                data-selector="${periodo}"
                                                data-iva="${compra.porcentajeIVA}"
                                            >
                                                <ion-icon name="eye-outline"></ion-icon>
                                            </button>
                                            
                                        @endcomponent
                                    `,
                                });
                            });
                        }

                        if ( response.albaranes ) {
                            response.albaranes.forEach(venta => {
                                rowData.push({
                                    tipo: 'Albarán',
                                    detalle: 'Total Albaranes',
                                    Importe: venta.totalImporte,
                                    total: venta.total,
                                    total_iva: venta.totalIva,
                                    cantidad: venta.cantidad,
                                    periodo: venta.periodo,  // Cambiado de "mes" a "periodo"
                                    tipo_transaccion: 'Albarán',
                                    porcentajeIVA: venta.porcentajeIVA,
                                    Acciones: `
                                        @component('components.actions-button')
                                            <button
                                                class="btn btn-sm btn-primary openDetailsEstadisticas"
                                                data-toggle="tooltip"
                                                title="Ver detalles"
                                                data-placement="top"
                                                data-total="${venta.total}"
                                                data-totaliva="${venta.totalIva}"
                                                data-totalimporte="${venta.totalImporte}"
                                                data-cantidad="${venta.cantidad}"
                                                data-periodo="${venta.periodo}"
                                                data-empresa="${empresaId}"
                                                data-selector="${periodo}"
                                                data-iva="${venta.porcentajeIVA}"
                                                data-tipo="Albaran"
                                            >
                                                <ion-icon name="eye-outline"></ion-icon>
                                            </button>
                                        @endcomponent
                                    `
                                });
                            });
                        }

                        if (response.partesSinFacturar){
                            response.partesSinFacturar.forEach(parte => {
                                rowData.push({
                                    tipo: 'Parte',
                                    detalle: 'Total Partes',
                                    total: parte.totalPartesSinFacturar,
                                    cantidad: parte.cantidadPartesSinFacturar,
                                    periodo: parte.periodo,  // Cambiado de "mes" a "periodo"
                                    tipo_transaccion: 'Partes',
                                    tipo_iva: (parte.porcentajeIVA) ? parte.porcentajeIVA+'%' : 0+'%'
                                });
                            });
                        }

                        if (response.cobros) {
                            response.cobros.forEach(cobro => {
                                rowData.push({
                                    tipo: 'Cobro',
                                    detalle: 'Total Cobros',
                                    total: cobro.totalCobros,
                                    cantidad: cobro.cantidadCobros,
                                    periodo: cobro.periodo,  // Cambiado de "mes" a "periodo"
                                    tipo_transaccion: 'Cobros',
                                });
                            });
                        }

                        if (response.pagos) {
                            response.pagos.forEach(pago => {
                                rowData.push({
                                    tipo: 'Pago',
                                    detalle: 'Total Pagos',
                                    total: pago.totalPagos,
                                    cantidad: pago.cantidadPagos,
                                    periodo: pago.periodo,  // Cambiado de "mes" a "periodo"
                                    tipo_transaccion: 'Pagos',
                                });
                            });
                        }

                        if(response.presupuestos){
                            response.presupuestos.forEach(presupuesto => {
                                rowData.push({
                                    tipo: 'Presupuesto',
                                    detalle: 'Total Presupuestos',
                                    total: presupuesto.totalPresupuestos,
                                    cantidad: presupuesto.cantidadPresupuestos,
                                    periodo: presupuesto.periodo,  // Cambiado de "mes" a "periodo"
                                    tipo_transaccion: 'Presupuestos',
                                    tipo_iva: (presupuesto.porcentajeIVA) ? presupuesto.porcentajeIVA+'%' : 0+'%'
                                });
                            });
                        }

                        // Actualiza la tabla/grid con los nuevos datos
                        setTimeout(() => {
                            gridOptionsApi.api.applyTransaction({ add: rowData });
                        }, 200);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al cargar los datos. Por favor, intente nuevamente.'
                        });
                    }
                },
                error: function (error) {
                    console.error('Error al cargar el resumen:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al cargar los datos. Por favor, intente nuevamente.'
                    });
                }
            });
        }

        let table = $('#resumenGrid')

        table.on('click', '.openDetailsEstadisticas', function(event){
            event.preventDefault();

            const total         = $(this).data('total');
            const totaliva      = $(this).data('totaliva');
            const totalimporte  = $(this).data('totalimporte');
            const cantidad      = $(this).data('cantidad');
            const periodo       = $(this).data('periodo');
            const tipo          = $(this).data('tipo');
            const selector      = $(this).data('selector');
            const empresa       = $(this).data('empresa');
            const iva           = $(this).data('iva');

            // ajax para obtener los detalles 
            getResumenDetails(total, totaliva, totalimporte, cantidad, periodo, tipo, selector, empresa, iva);

        })

        // Manejar eventos de cambio en los selectores
        $('#empresaSelect, #periodoSelect').on('change', cargarResumen);
    });
</script>

<script>
    // Funcion similar para cargar los articulos más vendidos en la tabla
    
    $(document).ready(function(){

        let articulos = @json($articulosMasVendidos);

        const rowData = {};
        let data = [];

        const agTablediv = document.querySelector('#articulosmasvendidos');

        const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
            { 
                name: 'ID',
                fieldName: 'ID',
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
                name: 'Nombre',
                fieldName: 'Nombre'
            },
            { 
                name: 'TCantidad',
                fieldName: 'TCantidad',
            },
            { 
                name: 'TUso',
                fieldName: 'TUso',
            },
            { 
                name: 'Acciones',
                className: 'acciones-column'
            }
        ];

        function prepareRowData(articulos) {
            articulos.forEach(articulo => {

                let urlFinal = '';
                if (articulo.articulo.imagenes.length > 0) {
                    let archivo = articulo.articulo.imagenes[0];
                    let url = archivo.pathFile;

                    urlFinal = globalBaseUrl + url;
                }

                rowData[articulo.articulo_id] = {
                    ID: articulo.articulo_id,
                    Imagen: `${ (articulo.articulo.imagenes.length > 0) ? urlFinal: '' }`,
                    Nombre: articulo.articulo.nombreArticulo,
                    TCantidad: articulo.total_cantidad,
                    TUso: articulo.total_uso,
                    Acciones:
                    `
                        @component('components.actions-button')
                            <button
                                class="btn btn-success showHistorialArticulo"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Historial de usos"
                                data-id="${articulo.articulo.idArticulo}"
                                data-nameart="${articulo.articulo.nombreArticulo}"
                                data-trazabilidad="${formatTrazabilidad(articulo.articulo.TrazabilidadArticulos)}"
                            >
                               <div class="d-flex justify-content-center align-items-center flex-column">
                                    <ion-icon name="time-outline"></ion-icon>
                                    <small>Historial</small>
                                 </div>
                            </button>
                        @endcomponent
                    `,
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
            inicializarAGtable( agTablediv, data, result, 'Articulos más vendidos', customButtons, 'PartesTrabajo');
        });

        let table = $('#articulosmasvendidos');

        table.on('dblclick', '.editArticleFast', function() {
            const idModal = $('#editArticleModal');
            const id = $(this).data('parteid');
            
            getEditArticle(id, idModal);
        });

        table.on('click', '.showHistorialArticulo', function(event){
            openLoader();
            const id = $(this).data('id');
            const name = $(this).data('nameart');
            const trazabilidad = $(this).data('trazabilidad');

            getHistorial(id, name, trazabilidad);

        });


    });

</script>

@stop
