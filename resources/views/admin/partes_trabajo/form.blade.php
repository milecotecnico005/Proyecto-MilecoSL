<div id="accordionParteTrabajo">
    <!-- Acordeón Detalles Parte de Trabajo -->
    <div class="accordion-item" style="margin: 1rem;">
        <h2 class="accordion-header" id="headingDetallesParteTrabajo">
            <button id="detailParteTrabajo" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetallesParteTrabajo" aria-expanded="true" aria-controls="collapseDetallesParteTrabajo" style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem;">
                Detalles de la Parte de trabajo
            </button>
        </h2>
        <div id="collapseDetallesParteTrabajo" class="accordion-collapse collapse show" aria-labelledby="headingDetallesParteTrabajo" data-bs-parent="#accordionParteTrabajo">
            <form id="formCreateOrden" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="orden_id" id="ordenId">
                
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="form-label" for="tipo">Proyectos</label>
                        <select name="cita" id="citasPendigSelect" class="form-select">
                            <option value="" selected>Seleccionar...</option>
                            @foreach ($projects as $cita)
                                <option 
                                    data-asunto="{{ $cita->name }}"
                                    data-fecha="{{ $cita->start_date }}"
                                    data-estado="{{ $cita->status }}"
                                    value="{{ $cita->idProyecto }}">
                                    {{ $cita->name }} | Fecha de Inicio: {{ $cita->start_date }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12 col-md-12 required-field">
                        <label class="form-label" for="asunto">Asunto</label>
                        <textarea rows="3" type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto" required></textarea>
                    </div>
                </div>

                <!-- Asunto y Fecha de Alta -->
                <div class="form-row">
                    <div style="max-width: 35%" class="form-group col-sm-4 col-md-6 required-field">
                        <label class="form-label" for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control" required>
                            <option selected>Seleccionar...</option>
                            <option value="1">Pendiente</option>
                            <option value="2">En proceso</option>
                            <option value="3">Finalizado</option>
                        </select>
                    </div>
                    <div style="max-width: 65%" class="form-group col-sm-8 col-md-6 required-field">
                        <label class="form-label" for="operario_id">Operarios</label>
                        <select id="operario_id" name="operario[]" class="form-select" multiple>
                            <option value="" selected>Seleccionar...</option>
                            @foreach ($operarios as $operario)
                                <option value="{{ $operario->idOperario }}">{{ $operario->nameOperario }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Fecha de Visita y Estado -->
                <div class="form-row">
                    <div style="max-width: 50%" class="form-group col-sm-6 col-md-6 required-field">
                        <label class="form-label" for="fecha_visita">Fecha de Visita</label>
                        <input type="date" class="form-control" id="fecha_visita" name="fecha_visita" required aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                    </div>
                    <div style="max-width: 50%" class="form-group col-sm-6 col-md-6 required-field">
                        <label class="form-label" for="fecha_alta">Fecha de Alta</label>
                        <input type="date" class="form-control" id="fecha_alta" name="fecha_alta" required aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <!-- Cliente y Departamento -->
                <div class="form-row">
                    <div class="form-group col-sm-6 col-md-4 required-field">
                        <label class="form-label" for="cliente_id">Cliente</label>
                        <select id="cliente_id" name="cliente_id" class="form-select" required>
                            <option selected>Seleccionar...</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->idClientes }}">{{ $cliente->NombreCliente }} {{ $cliente->ApellidoCliente }}</option>
                            @endforeach
                        </select>
                        <small id="clienteHelp" class="form-text text-muted"></small>
                    </div>
                    <div style="max-width: 50%" class="form-group col-sm-4 col-md-4 required-field">
                        <label class="form-label" for="departamento">Departamento</label>
                        <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Departamento" required>
                    </div>
                    <div style="max-width: 50%" class="form-group col-sm-4 col-md-4 required-field">
                        <label class="form-label" for="trabajo">Trabajo</label>
                        <select name="trabajo_id" class="form-select" id="trabajo_id" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($trabajos as $trabajo)
                                <option value="{{ $trabajo->idTrabajo }}">{{ $trabajo->nameTrabajo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Observaciones y Solución -->
                <div class="form-row">
                    <div class="form-group col-sm-6 col-md-6">
                        <label class="form-label" for="observaciones">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>
                    <div class="form-group col-sm-6 col-md-6 required-field">
                        <label class="form-label" for="solucion">Solución</label>
                        <textarea class="form-control" id="solucion" name="solucion" rows="3" placeholder="Solución" required></textarea>
                    </div>
                </div>

                <!-- Horas trabajadas -->
                <div class="form-row">
                    <div style="max-width: 33%" class="form-group col-sm-6 col-md-4 required-field">
                        <label class="form-label" for="hora_inicio">Hora I</label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                    </div>
                    <div style="max-width: 33%" class="form-group col-sm-6 col-md-4 required-field">
                        <label class="form-label" for="hora_fin">Hora F</label>
                        <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
                    </div>
                    <div style="max-width: 33%" class="form-group col-sm-6 col-md-4 required-field">
                        <label class="form-label" for="horas_trabajadas">Total</label>
                        <input type="text" class="form-control" id="horas_trabajadas" name="horas_trabajadas" required>
                    </div>
                </div>

                <!-- Precio de horas y Desplazamiento -->
                <div class="form-row d-none">
                    <div style="max-width: 50%" class="form-group col-sm-6 col-md-6 required-field">
                        <label class="form-label" for="precio_hora">Total M.Obra</label>
                        <input type="number" class="form-control" id="precio_hora" name="precio_hora" placeholder="Valor total de horas">
                        <small id="precioHoraHelp" class="form-text text-muted"></small>
                    </div>
                    <div style="max-width: 50%" class="form-group col-sm-6 col-md-6 required-field">
                        <label for="desplazamiento" class="form-label">Desplazamiento</label>
                        <input type="number" class="form-control" id="desplazamiento" name="desplazamiento" value="0">
                    </div>
                </div>

                <!-- Trabajo y Suma -->
                <div class="form-row">
                    <div style="max-width: 50%" class="form-group col-sm-6 col-md-6">
                        <label class="form-label" for="descuento">Descuento</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="descuento" name="descuento" placeholder="Ingrese el descuento en porcentaje">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div style="max-width: 50%" class="form-group col-sm-6 col-md-6 required-field">
                        <label class="form-label" for="suma">Suma</label>
                        <input type="text" class="form-control" id="suma" name="suma" placeholder="Suma" readonly>
                        <small id="sumaHelp" class="form-text text-muted"></small>
                    </div>
                </div>

                <div class="form-row" id="imagesDetails"></div>

                <!-- Archivos -->
                <div class="form-row">
                    <div class="form-group col-md-12 required-field">
                        <div class="image-fluid d-flex flex-wrap" id="previewImage1"></div>
                        <label for="files">Archivos</label>
                        <input type="file" class="form-control" id="files1" name="file[]">
                    </div>
                </div>

                <div class="form-row" id="inputsToUploadFilesContainer"></div>
                <button type="button" class="btn btn-outline-primary" id="btnAddFiles">Añadir más archivos</button>

                <hr>

                <div class="container mt-3">
                    <h4>Firma del cliente</h4>
                
                    <div class="col-md-12 text-center">
                        <!-- Botón de desbloqueo -->
                        <div id="unlock-signature" style="cursor: pointer;">
                            <ion-icon name="lock-closed-outline" style="font-size: 2rem;"></ion-icon>
                            <p>Doble clic para desbloquear la firma</p>
                        </div>
                    </div>

                    <div class="col-sm-12" id="showSignatureFromClient"></div>
                
                    <!-- Canvas para la firma, oculto inicialmente -->
                    <canvas id="signature-pad" style="display: none; border: 1px solid #000;"></canvas>
                
                    <input type="hidden" id="signature" name="signature">
                
                    <div class="form-group mt-3">
                        <label for="name">Nombre correspondiente a la firma</label>
                        <input type="text" class="form-control" id="cliente_firmaid" name="name" placeholder="Nombre">
                    </div>
                
                    <div class="mt-3">
                        <button id="clear-signature" class="btn btn-outline-danger">
                            <ion-icon name="trash-outline"></ion-icon>
                            Limpiar
                        </button>
                    </div>
                </div>
                
                <hr>
                <div class="form-row">
                    <div class="col-sm-12 d-flex flex-column">
                        <small class="form-text text-muted">Los campos marcados con (*) son obligatorios</small>
                        <small class="form-text text-muted">Debes guardar el parte de trabajo antes de añadir lineas de material</small>
                    </div>
                </div>

                <!-- Botón de crear parte de trabajo -->
                <div class="form-row">
                    <div class="form-group col-md-12 mt-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-warning" id="btnCreateOrdenButton">
                            <ion-icon name="save-outline"></ion-icon>
                            Guardar Parte de trabajo
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Acordeón Materiales empleados -->
    <div style="margin: 1rem;" class="accordion-item">
        <h2 class="accordion-header" id="headingMaterialesEmpleados">
            <button id="materialesEmpleados" style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMaterialesEmpleados" aria-expanded="false" aria-controls="collapseMaterialesEmpleados">
                Materiales empleados
            </button>
        </h2>
        <div id="collapseMaterialesEmpleados" class="accordion-collapse collapse" aria-labelledby="headingMaterialesEmpleados" data-bs-parent="#accordionParteTrabajo">
            <div class="accordion-body">
                <div class="container">
                    <table id="tableToShowElements" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ART</th>
                                <th>UDS</th>
                                <th>Precio</th>
                                <th>D%</th>
                                <th>Total</th>
                                <th>BENF</th>
                                <th>Acc</th>
                            </tr>
                        </thead>
                        <tbody id="elementsToShow">
                            <!-- Aquí se insertarán dinámicamente las líneas de materiales -->
                        </tbody>
                    </table>
                </div>
                <div class="mb-2" id="newMaterialsContainer"></div>
                <button id="addNewMaterial" type="button" class="btn btn-outline-primary mb-2">Añadir material</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        // evento cuando cambie el valor de la suma, aplicar descuento
        $('#formCreateOrden #suma').on('change', function() {

            let suma        = parseFloat($(this).val());
            let descuento   = parseFloat($('#formCreateOrden #descuento').val());

            if (isNaN(descuento)) {
                descuento = 0;
            }

            if (descuento > 0) {

                const resultadoDescuento = suma * descuento / 100;
                let total = suma - resultadoDescuento;

                if (isNaN(total)) {
                    total = 0;
                }
                
                $('#formCreateOrden #suma').val(total.toFixed(2));
                
                // mostrar el help text de la suma
                $('#formCreateOrden #sumaHelp').text(`Precio del parte sin D% : ${ formatPrice(suma.toFixed(2)) }`);
            }else{
                $('#formCreateOrden #sumaHelp').text(``);
            }

        });

        
    });

</script>