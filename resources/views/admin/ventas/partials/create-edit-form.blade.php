@if (!isset($clientes))
    @php
        $clientes = \App\Models\Cliente::all();
    @endphp    
@endif

@if (!isset($empresas))
    @php
        $empresas = \App\Models\Empresa::all();
    @endphp
@endif

<div id="accordionVenta">

    <!-- Acordeón Detalles de la Venta -->
    <div style="margin: 1rem;" class="accordion-item">
        <h2 class="accordion-header" id="headingDetallesVenta">
            <button id="detailVenta" style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetallesVenta" aria-expanded="true" aria-controls="collapseDetallesVenta">
                Detalles de la Venta
            </button>
        </h2>
        <div style="overflow-x: hidden" id="collapseDetallesVenta" class="accordion-collapse collapse show" aria-labelledby="headingDetallesVenta" data-bs-parent="#accordionVenta">
            <form id="createVentaForm" class="accordion-body" enctype="multipart/form-data">
                <input type="hidden" name="idVenta" id="idVenta">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required-field">
                                <label class="form-label" for="FechaVenta">Fecha de venta</label>
                                <input type="date" class="form-control" id="FechaVenta" name="FechaVenta">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required-field">
                                <label class="form-label" for="AgenteVenta">Agente</label>
                                <input type="text" class="form-control" id="AgenteVenta" name="AgenteVenta">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group required-field">
                                <label class="form-label" for="EnviadoVenta">Enviado</label>
                                <input type="text" class="form-control" placeholder="Email de agente" id="EnviadoVenta" name="EnviadoVenta">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group required-field">
                                <label class="form-label" for="FormaPago">Forma de Pago</label>
                                <select type="text" class="form-select" id="FormaPago" name="FormaPago">
                                    <option value="">Selecciona una forma de pago</option>
                                    <option value="1">Efectivo</option>
                                    <option value="2">Banco</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group required-field">
                                <label class="form-label" for="cliente_id">Cliente</label>
                                <select class="form-select" id="cliente_id" name="cliente_id">
                                    <option value="">Selecciona un cliente</option>
                                    @if (isset($empresas))
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->idClientes }}">{{ $cliente->NombreCliente }} {{ $cliente->ApellidoCliente }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required-field">
                                <label class="form-label" for="IvaVenta">Iva</label>
                                <input type="text" class="form-control" id="IvaVenta" name="IvaVenta" value="21">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="TotalIvaVenta">Total Iva</label>
                                <input type="text" class="form-control" id="TotalIvaVenta" name="TotalIvaVenta" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="RetencionesVenta">Retenciones</label>
                                <input type="number" value="0" class="form-control" id="RetencionesVenta" name="RetencionesVenta">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="TotalRetencionesVenta">Total Retenciones</label>
                                <input type="number" class="form-control" id="TotalRetencionesVenta" name="TotalRetencionesVenta" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="TotalFacturaVenta">Total Factura</label>
                                <input type="text" class="form-control" id="TotalFacturaVenta" name="TotalFacturaVenta" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="SuplidosVenta">Suplidos</label>
                                <input type="number" value="0" class="form-control" id="SuplidosVenta" name="SuplidosVenta">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required-field">
                                <label class="form-label" for="Plazos">Plazos</label>
                                <select class="form-select" id="Plazos" name="Plazos" required>
                                    <option value="0">Pagado</option>
                                    @for ($i = 1; $i <= 24; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group required-field">
                                <label class="form-label" for="empresa_id">Empresa</label>
                                <select class="form-select" id="empresa_id" name="empresa_id" style="color: var(--ligth)">
                                    <option value="">Selecciona un Empresa</option>
                                    @if (isset($empresas))
                                        @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->idEmpresa }}">{{ $empresa->EMP }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">

                        <div class="plazo-fields plazo1" style="display: none;">
                            <div class="col-md-6">
                                <div class="form-group required-field">
                                    <label class="form-label" for="proximoPago">Próxima Fecha de Pago</label>
                                    <input type="date" class="form-control" id="proximoPago" name="proximoPago">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- Campos para Plazo 2 -->
                    <div class="row plazo-fields plazo2" style="display: none;">

                        <div class="col-md-6">
                            <div class="form-group required-field">
                                <label class="form-label" for="frecuenciaPago">Frecuencia de Pagos</label>
                                <select class="form-control" id="frecuenciaPagoCreate" name="frecuenciaPago">
                                    <option value="mensual">Mensual</option>
                                    <option value="semanal">Semanal</option>
                                    <option value="quincenal">Quincenal</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group required-field">
                                <label class="form-label" for="siguienteCobro">Fecha del Siguiente Cobro</label>
                                <input type="date" class="form-control" id="siguienteCobroCreate" name="siguienteCobro">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required-field">
                                <label class="form-label" for="Cobrado">Cobrado</label>
                                <input type="text" class="form-control" id="Cobrado" name="Cobrado" value="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="PendienteVenta">Pendiente</label>
                                <input type="text" class="form-control" id="PendienteVenta" name="PendienteVenta" value="0" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required-field">
                                <label class="form-label" for="NAsientoContable">Nº Asiento Contable</label>
                                <input type="text" class="form-control" id="NAsientoContable" name="NAsientoContable">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="Observaciones">Observaciones</label>
                                <input type="text" class="form-control" id="Observaciones" name="Observaciones">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <button type="button" class="btn btn-outline-warning" id="guardarVenta">Guardar</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Acordeón Líneas de Venta -->
    <div style="margin: 1rem;" class="accordion-item">
        <h2 class="accordion-header" id="headingLineasVenta">
            <button style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLineasVenta" aria-expanded="false" aria-controls="collapseLineasVenta">
                Líneas de Venta
            </button>
        </h2>
        <div id="collapseLineasVenta" class="accordion-collapse collapse" aria-labelledby="headingLineasVenta" data-bs-parent="#accordionVenta">
            <div class="accordion-body">
                <div class="container">
                    <table id="tableToShowElements" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titulo</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Descuento</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="elementsToShow">
                            <!-- Aquí se insertarán dinámicamente las líneas de venta -->
                        </tbody>
                    </table>
                </div>

                <button id="addNewLine" type="button" class="btn btn-outline-primary mb-2">Añadir línea</button>

                <div class="mb-2" id="newLinesContainer"></div>
            </div>
        </div>
    </div>

</div>