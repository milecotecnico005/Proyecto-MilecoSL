<div id="accordionParteTrabajo">
    <div style="margin: 1rem;" class="accordion-item">
        <h2 class="accordion-header" id="headingDetallesParteTrabajoPresu">
            <button id="detailParteTrabajo" style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetallesParteTrabajoPresu" aria-expanded="true" aria-controls="collapseDetallesParteTrabajoPresu">
                Detalles del presupuesto
            </button>
        </h2>
        <div id="collapseDetallesParteTrabajoPresu" class="accordion-collapse collapse show" aria-labelledby="headingDetallesParteTrabajoPresu" data-bs-parent="#accordionParteTrabajo">
            <form id="formCreateOrden">
                @csrf
                <input type="hidden" name="orden_id" id="ordenId">
                <input type="hidden" name="idParteTrabajo" id="idParteTrabajo">
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
                    <div class="form-group col-md-6">
                        <label class="form-label" for="fecha_visita">Fecha de Visita</label>
                        <input type="date" class="form-control" id="fecha_visita" name="fecha_visita">
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

                <div class="form-row">
                    <div class="form-group col-sm-4 required-field">
                        <label class="form-label" for="departamento">Departamento</label>
                        <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Departamento">
                    </div>
                    <div class="form-group col-sm-4 required-field">
                        <label class="form-label" for="trabajo">Trabajo</label>
                        <select name="trabajo_id[]" class="form-select" id="trabajo_id">
                            <option value="">Seleccionar...</option>
                            @foreach ($trabajos as $trabajo)
                                <option value="{{ $trabajo->idTrabajo }}">{{ $trabajo->nameTrabajo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="form-label" for="suma">Suma</label>
                        <input type="text" class="form-control" id="suma" name="suma" placeholder="Suma" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="form-label" for="condicionesgene">Condiciones Generales</label>
                        <textarea class="form-control" id="condicionesgene" name="condicionesgene" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="form-label" for="observaciones">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-row">
                    {{-- Añadir anexos de manera dinamica --}}
                    <div class="form-group col-sm-12" id="AnexosContainer">
                        
                    </div>
                    <button type="button" class="btn btn-outline-primary" id="addAnexo">Añadir Anexo</button>
                </div>

                @if (!isset($hideGuardar))
                    <div class="form-row">
                        <div class="form-group col-md-12 mt-2 d-flex justify-content-end align-items-end">
                            <button type="button" class="btn btn-outline-warning" id="btnCreateOrdenButton">Crear Presupuesto</button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Acordeón Materiales empleados -->
    <div style="margin: 1rem;" class="accordion-item">
        <h2 class="accordion-header" id="headingMaterialesEmpleadospresu">
            <button id="materialesEmpleados" style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMaterialesEmpleadospresu" aria-expanded="false" aria-controls="collapseMaterialesEmpleadospresu">
                Partes de Trabajo
            </button>
        </h2>
        <div id="collapseMaterialesEmpleadospresu" class="accordion-collapse collapse" aria-labelledby="headingMaterialesEmpleadospresu" data-bs-parent="#accordionParteTrabajo">
            <div class="accordion-body">
                <div class="container">
                    <table id="tableToShowElements" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ART</th>
                                <th>UDS</th>
                                <th>P.Estimado</th>
                                <th>D%</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="elementsToShow">
                            <!-- Aquí se insertarán dinámicamente las líneas de materiales -->
                        </tbody>
                    </table>
                </div>
                <button id="addNewMaterial" type="button" class="btn btn-outline-primary mb-2">Añadir Parte de trabajo</button>
                <div class="mb-2" id="newMaterialsContainer"></div>
            </div>
        </div>
    </div>
</div>