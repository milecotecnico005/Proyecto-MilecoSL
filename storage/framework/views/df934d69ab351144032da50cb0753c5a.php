<?php $__env->startSection('title', 'Dashboard'); ?>


<?php $__env->startSection('content'); ?>

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

    </style>

    
    <div class="row">

        <div class="col-12">
            <!-- Gráficos generales, citas, ventas, cobros, compras utilizando ChartJS -->
            <div class="card tableCard">
                <div class="card-header">
                    <h3 style="font-size: 18px; font-weight: bold; letter-spacing: '.5rem'" class="card-title">Gráficos generales</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Gráfico de Citas -->
                        <div class="col-md-6 col-lg-6 mb-4 d-flex justify-content-center">
                            <canvas id="canvas-citas" style="max-width: 100%;"></canvas>
                        </div>
                        <!-- Gráfico de Ventas -->
                        <div class="col-md-6 col-lg-6 mb-4 d-flex justify-content-center">
                            <canvas id="canvas-ventas" style="max-width: 100%;"></canvas>
                        </div>
                        <!-- Gráfico de Cobros -->
                        <div class="col-md-6 col-lg-6 mb-4 d-flex justify-content-center">
                            <canvas id="canvas-cobros" style="max-width: 100%;"></canvas>
                        </div>
                        <!-- Gráfico de Ventas -->
                        <div class="col-md-6 col-lg-6 mb-4 d-flex justify-content-center">
                            <canvas id="canvas-compras" style="max-width: 100%;"></canvas>
                        </div>
                        
                        <div class="col-md-6 col-lg-6 mb-4 d-flex justify-content-center">
                            <canvas id="canvas-comprasRealizadas" style="max-width: 100%;"></canvas>
                        </div>
                        
                        <div class="col-md-6 col-lg-6 mb-4 d-flex justify-content-center">
                            <canvas id="canvas-lineasOrdenes" style="max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    

    <!-- Tabs para mostrar tablas con los últimos registros de citas, ventas, cobros, compras -->
    <div class="row">
        <div class="col-md-12">
            <div class="card tableCard">
                <div class="card-header">
                    <h3 style="font-size: 18px; font-weight: bold; letter-spacing: '.5rem'" class="card-title">Últimos registros</h3>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="citas-tab" data-bs-toggle="tab" data-bs-target="#tab-citas" type="button" role="tab" aria-controls="tab-citas" aria-selected="true">Partes de trabajo</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ventas-tab" data-bs-toggle="tab" data-bs-target="#tab-ventas" type="button" role="tab" aria-controls="tab-ventas" aria-selected="false">Ventas</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cobros-tab" data-bs-toggle="tab" data-bs-target="#tab-cobros" type="button" role="tab" aria-controls="tab-cobros" aria-selected="false">Cobros</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="compras-tab" data-bs-toggle="tab" data-bs-target="#tab-compras" type="button" role="tab" aria-controls="tab-compras" aria-selected="false">Compras</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab-citas" role="tabpanel" aria-labelledby="citas-tab">
                            <div id="PartesGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>
                        </div>
                        <div class="tab-pane fade" id="tab-ventas" role="tabpanel" aria-labelledby="ventas-tab">
                            <div class="table-responsive">
                                <div id="VentasGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-cobros" role="tabpanel" aria-labelledby="cobros-tab">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Empleado</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Datos dinámicos aquí -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-compras" role="tabpanel" aria-labelledby="compras-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="ComprasTable">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Fecha de compra</th>
                                            <th>Proveedor</th>
                                            <th>trazabilidad</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Datos dinámicos aquí -->
                                    </tbody>
                                </table
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-4">
                    <!-- La tarjeta se expandirá con el ancho de la tabla -->
                    <div id="OrdenesGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>
                </div>
            </div>
        </div>

    </div>
   


    

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'detailsParteTrabajoModal',
        'modalTitle' => 'Detalles de la Parte de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'closeDetailsParteTrabajoBtn',
        'disabledSaveBtn' => true
    ]); ?>
        <?php echo $__env->make('admin.partes_trabajo.form', ['disabled' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'editParteTrabajoModal',
        'modalTitle' => 'Editar Parte de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveEditParteTrabajoBtn',
    ]); ?>
        <?php echo $__env->make('admin.partes_trabajo.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->renderComponent(); ?>

    

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'createVentaModal',
        'modalTitle' => 'Crear Venta',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveVentaBtn',
    ]); ?>
        <?php echo $__env->make('admin.ventas.partials.create-edit-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'showVentaModal',
        'modalTitle' => 'Detalles de la Venta',
        'modalSize' => 'modal-xl',
        'btnSaveId' => '',
    ]); ?>
        <div id="ventaDetailsContainer"></div>
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'plazosModal',
        'modalTitle' => 'Plazos de la Venta',
        'modalSize' => 'modal-xl',
        'modalTitleId' => 'plazosModalTitle',
        'btnSaveId' => '',
    ]); ?>
        <div id="plazosContainer" class="accordion" id="accordionPlazos"></div>
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'cobroModal',
        'modalTitle' => 'Registrar Cobro',
        'modalSize' => 'modal-lg',
        'btnSaveId' => 'btnGuardarCobro',
    ]); ?>
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
                
                <label for="bancoCobro">Banco</label>
                <select class="form-select" id="bancoCobro" name="bancoCobro">
                    <?php $__currentLoopData = $bancos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($banco->idbanco); ?>"><?php echo e($banco->nameBanco); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <input type="hidden" id="plazoId" name="plazoId">
            <input type="hidden" id="totalPlazo" name="totalPlazo">
            <input type="hidden" id="cobradoActual" name="cobradoActual">
        </form>
    <?php echo $__env->renderComponent(); ?>

    

    
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalDetailsCompra',
        'modalTitle' => 'Detalles de la compra',
        'modalSize' => 'modal-xl',
        'modalTitleId' => 'DetailsCompraTitle',
        'disabledSaveBtn' => true
    ]); ?>
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
                                        <select class="form-control" id="empresa_idDetails" name="empresa_id" required>
                                            <option value="">Seleccione una empresa</option>
                                            <?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($empresa->idEmpresa); ?>"><?php echo e($empresa->EMP); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                        <select class="form-control" id="proveedor_idDetails" name="proveedor_id" required>
                                            <option value="">Seleccione un proveedor</option>
                                            <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($proveedor->idProveedor); ?>"><?php echo e($proveedor->nombreProveedor); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formaPago">Forma de Pago</label>
                                        <select class="form-control" id="formaPagoDetails" name="formaPago" required>
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
                                <input type="text" class="form-control" id="NAsientoContableDetails" name="NAsientoContable" required>
                            </div>

                            <div class="form-group">
                                <label for="ObservacionesCompras">Observaciones</label>
                                <textarea class="form-control" id="ObservacionesComprasDetails" name="ObservacionesCompras" rows="3" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Plazos">Plazos</label>
                                <select class="form-control" id="PlazosDetails" name="Plazos" required>
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
                                <select class="form-control" id="frecuenciaPagoDetails" name="frecuenciaPago">
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
                            <input type="hidden" name="userAction" id="userActionDetails" value="<?php echo e(Auth::id()); ?>">

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
                                    </tr>
                                </thead>
                                <tbody id="elementsToShowDetails">
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-2" id="newLinesContainer"></div>
                    </div>
                </div>
            </div>

        </div>
    <?php echo $__env->renderComponent(); ?>

    <!-- Modal para Editar Compra -->
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalEditCompra',
        'modalTitle' => 'Editar Compra',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editCompraTitle',
        'btnSaveId' => 'btnSaveEditCompra'
    ]); ?>
        <form id="formEditCompra">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fechaEdit">Fecha de Compra</label>
                    <input type="date" class="form-control" id="fechaEditCompra" name="fecha" required>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="empresa_id">Empresa</label>
                        <select class="form-control" id="empresa_idEdit" name="empresa_id" required>
                            <option value="">Seleccione una empresa</option>
                            <?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($empresa->idEmpresa); ?>"><?php echo e($empresa->EMP); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="nfacturaEdit">Número de Factura</label>
                    <input type="text" class="form-control" id="nfacturaEditCompra" name="nfactura" required>
                </div>
                <div class="col-md-4">
                    <label for="proveedorEdit">Proveedor</label>
                    <select class="form-control" id="proveedorEditCompra" name="proveedor" required>
                        <option value="">Seleccione...</option>
                        <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($proveedor->idProveedor); ?>"><?php echo e($proveedor->nombreProveedor); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="formapagoEdit">Forma de Pago</label>
                    <select class="form-control" id="formapagoEditCompra" name="formapago" required>
                        <option value="1">Banco</option>
                        <option value="2">Efectivo</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="ivaEdit">IVA</label>
                    <input type="number" class="form-control" id="ivaEditCompra" name="iva" value="21" required readonly>
                </div>
                <div class="col-md-4">
                    <label for="totalivaEdit">Total IVA</label>
                    <input type="number" step="0.01" class="form-control" id="totalivaEditCompra" value="0" name="totaliva" required>
                </div>
                <div class="col-md-4">
                    <label for="totalEdit">Total</label>
                    <input type="number" step="0.01" class="form-control" id="totalEditCompra" value="0" name="total" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="suplidosEdit">Suplidos</label>
                    <input type="number" step="0.01" class="form-control" id="suplidosEditCompra" name="suplidos">
                </div>
                <div class="col-md-6">
                    <label for="nasientoEdit">Número de Asiento Contable</label>
                    <input type="text" class="form-control" id="nasientoEditCompra" name="nasiento" required>
                </div>
            </div>

            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Observaciones" id="observacionesEditCompra" name="observaciones"></textarea>
                <label for="observacionesEdit">Observaciones</label>
            </div>

            <div class="mb-3">
                <label for="plazosEdit">Plazos</label>
                <select class="form-control" id="plazosEditCompra" name="plazos" required>
                    <option value="0">Pagado</option>
                    <option value="1">1 Plazo</option>
                    <option value="2">Más de 1 Plazo</option>
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
                <select class="form-control" id="frecuenciaPagoDetails" name="frecuenciaPago">
                    <option value="mensual">Mensual</option>
                    <option value="semanal">Semanal</option>
                    <option value="quincenal">Quincenal</option>
                </select>
            </div>
            <div class="form-group plazo-fields plazo2" style="display: none;">
                <label for="siguienteCobro">Fecha del Siguiente Cobro</label>
                <input type="date" class="form-control" id="siguienteCobroDetails" name="siguienteCobro">
            </div>

            <div class="form-group mb-3">
                <label for="fileCreate">Factura</label>
                <input type="file" class="form-control" id="fileEdit" name="file"></input>
            </div>

            <!-- Campo oculto para el usuario logueado -->
            <input type="hidden" name="userAction" id="userActionDetails" value="<?php echo e(Auth::id()); ?>">

        </form>
    <?php echo $__env->renderComponent(); ?>

    
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalDetallesOrden',
        'modalTitle' => 'Detalles de la Orden',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'detallesOrdenTitle',
        'btnSaveId' => 'btnDetallesOrden',
        'disabledSaveBtn' => true
    ]); ?>
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
                    <?php $__currentLoopData = $trabajos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trabajo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($trabajo->idTrabajo); ?>"><?php echo e($trabajo->nameTrabajo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group
                col-md-6">
                <label for="operario_id">Operario/s</label>
                <select id="operario_idDetails" multiple name="operario_id[]" class="form-select" disabled>
                    <?php $__currentLoopData = $operarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($operario->idOperario); ?>"><?php echo e($operario->nameOperario); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    <?php echo $__env->renderComponent(); ?>

    

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalEditOrden',
        'modalTitle' => 'Editar Orden',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editOrdenTitle',
        'btnSaveId' => 'btnEditOrden'
    ]); ?>
        <form id="formEditOrden" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="asunto">Asunto</label>
                    <input type="text" class="form-control" id="asuntoEdit" name="asunto" placeholder="Asunto">
                </div>
                <div class="form-group
                    col-md-6">
                    <label for="fecha_alta">Fecha de Alta</label>
                    <input type="date" class="form-control" id="fecha_altaEdit" name="fecha_alta">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-6">
                    <label for="fecha_visita">Fecha de Visita</label>
                    <input type="date" class="form-control" id="fecha_visitaEdit" name="fecha_visita">
                </div>
                <div class="form-group
                    col-md-6">
                    <label for="estado">Estado</label>
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
                    col-md-6">
                    <label for="cliente_id">Cliente</label>
                    <select id="cliente_idEdit" name="cliente_id" class="form-select">
                        <option selected>Seleccionar...</option>
                        <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <option value="<?php echo e($cliente->idClientes); ?>"><?php echo e($cliente->NombreCliente); ?> <?php echo e($cliente->ApellidoCliente); ?></option>
                    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group
                    col-md-6">
                    <label for="departamento">Departamento</label>
                    <input type="text" class="form-control" id="departamentoEdit" name="departamento" placeholder="Departamento">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-6">
                    <label for="trabajo_id">Trabajo</label>
                    <select id="trabajo_idEdit" multiple name="trabajo_id[]" class="form-select">
                        <?php $__currentLoopData = $trabajos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trabajo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($trabajo->idTrabajo); ?>"><?php echo e($trabajo->nameTrabajo); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group
                    col-md-6">
                    <label for="operario_id">Operario/s</label>
                    <select id="operario_idEdit" multiple name="operario_id[]" class="form-select">
                        <?php $__currentLoopData = $operarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($operario->idOperario); ?>"><?php echo e($operario->nameOperario); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group
                    col-md-12">
                    <label for="observaciones">Observaciones</label>
                    <textarea class="form-control" id="observacionesEdit" name="observaciones" rows="3"></textarea>
                </div>
            </div>
        </form>
    <?php echo $__env->renderComponent(); ?>

    
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'editMaterialLineModal',
        'modalTitle' => 'Editar Linea de Material',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editMaterialLineTitle',
        'btnSaveId' => 'saveEditMaterialLineBtn'
    ]); ?>
        
        <form id="formEditMaterialLine" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="lineaId" id="lineaId">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="material_id">Articulo</label>
                    <select id="material_id" name="material_id" class="form-select">
                        <?php $__currentLoopData = $articulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option data-namearticulo="<?php echo e($articulo->nombreArticulo); ?>" value="<?php echo e($articulo->idArticulo); ?>">
                                <?php echo e($articulo->nombreArticulo); ?> | <?php echo e(formatTrazabilidad($articulo->TrazabilidadArticulos)); ?> | stock: <?php echo e($articulo->stock->cantidad); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

        
    <?php echo $__env->renderComponent(); ?>

    
    <?php $__env->startComponent('components.modal-component',[
        'modalId'       => 'showProjectDetailsModal',
        'modalTitleId'  => 'showProjectDetailsTitle',
        'modalTitle'    => 'Historial de proyecto',
        'modalSize'     => 'modal-xl',
        'hideButton'    => true,
        'otherButtonsContainer' => 'showProjectDetailsFooter'
    ]); ?>
        <div class="row col-sm-12" id="showAccordeonsProject">

        </div>  
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'showReportModalInAGGRID',
        'modalTitle' => 'Itinerario',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'generateReportBtnAGGRID',
        'nameButtonSave' => 'Generar Itinerario'
    ]); ?>

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
                    <?php if(!$isAdmin): ?> disabled <?php endif; ?>>
                    <?php if($isAdmin): ?>
                        <option 
                            value="0" 
                            data-alluser="<?php echo e(json_encode($users)); ?>" 
                            selected>
                            Todos los usuarios
                        </option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option 
                                value="<?php echo e($user->id); ?>" 
                                data-nameoperario="<?php echo e($user->name); ?>">
                                <?php echo e($user->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <option 
                            value="<?php echo e(auth()->user()->id); ?>" 
                            selected 
                            data-nameoperario="<?php echo e(auth()->user()->name); ?>">
                            <?php echo e(auth()->user()->name); ?>

                        </option>
                    <?php endif; ?>
                </select>
            </div>
        </div>

    <?php echo $__env->renderComponent(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .tableCard {
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
<?php $__env->stopSection(); ?>

<?php
    
    $partesData = [];

    $estados = [];

    $estadosOrdenes = [];

    $citasFechasAlta = [];

    $ventasFechaAlta = [];

    $comprasFechaAlta = [];

    $ordenesFechas = [];

    foreach ($partes as $parte) {
        $partesData[] = $parte;
        $estados[] = ($parte->Estado == 1) ? 'Pendiente' : (($parte->Estado == 2) ? 'En proceso' : 'Finalizado');
    }

    foreach ($ordenes as $orden) {
        $ordenes[] = $orden;
        $estadosOrdenes[] = $orden->Estado;
        $ordenesFechas[] = $orden->FechaAlta;
    }

    foreach ($citas as $cita) {
        $citasFechasAlta[] = $cita->fechaDeAlta;
    }

    foreach ($ventas as $venta) {
        $ventasFechaAlta[] = $venta->FechaVenta;
    }

    foreach ($compras as $compra) {
        $comprasFechaAlta[] = $compra->fechaCompra;
    }

    echo ('<script>
        const partesArray   = '.json_encode($partesData).';
        const estadosArray  = '.json_encode($estados).';

        const ordenesArray          = '.json_encode($ordenes).';
        const estadosOrdenesArray   = '.json_encode($estadosOrdenes).';

        const citasFechasAlta = '.json_encode($citasFechasAlta).';
        const citasArray = '.json_encode($citas).';

        const ventasArray = '.json_encode($ventas).';
        const ventasFechaAlta = '.json_encode($ventasFechaAlta).';

        const comprasArray = '.json_encode($compras).';
        const comprasFechaAlta = '.json_encode($comprasFechaAlta).';

        const fechasOrdenes = '.json_encode($ordenesFechas).';

    </script>');
    
?>

<?php
    $tokenValido = app('App\Http\Controllers\GoogleCalendarController')->checkGoogleToken();
?>

<?php $__env->startSection('js'); ?>

<script>

    // cuando la pagina cargue automaticamente hacer click en el tab de #myTab button que apunte al target de #tab-citas
    $(document).ready(function() {
        setTimeout(() => {
            $('#myTab button#citas-tab').trigger('click');
        }, 100);
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        let estadosPartesAgrupados = [];
        let estadosOrdenesAgrupados = [];
        let mesesCitasAgrupados = [];
        let mesesVentasAgrupados = [];
        let mesesComprasAgrupados = [];
        let mesesOrdenesAgrupados = [];
        
        function filtrarTablaPorEstado(estado, tableId, column = 3) {
            $('#'+tableId).DataTable().column(column).search(estado).draw();
        }

        // Agrupacion de los estados de las partes de trabajo
        for (let i = 0; i < estadosArray.length; i++) {
            if (!estadosPartesAgrupados.includes(estadosArray[i])) {
                estadosPartesAgrupados.push(estadosArray[i]);
            }
        }

        // Agrupacion de los estados de las ordenes de trabajo
        for (let i = 0; i < estadosOrdenesArray.length; i++) {
            if (!estadosOrdenesAgrupados.includes(estadosOrdenesArray[i])) {
                estadosOrdenesAgrupados.push(estadosOrdenesArray[i]);
            }
        }

        // Agrupar las citas por mes
        for (let i = 0; i < citasFechasAlta.length; i++) {
            let fecha = new Date(citasFechasAlta[i]);
            let mes = fecha.getMonth();
            let year = fecha.getFullYear();
            let fechaFormateada = `${mes + 1}/${year}`;

            // obtener el nombre del mes
            let nombreMes = fecha.toLocaleString('es-ES', { 
                month: 'short',
                year: 'numeric'
            });

            if (mesesCitasAgrupados.includes(nombreMes)) {
                continue;
            } else {
                mesesCitasAgrupados.push(nombreMes);
            }
        }

        // Agrupar las ventas por mes
        for (let i = 0; i < ventasFechaAlta.length; i++) {
            let fecha = new Date(ventasFechaAlta[i]);
            let mes = fecha.getMonth();
            let year = fecha.getFullYear();
            let fechaFormateada = `${mes + 1}/${year}`;

            // obtener el nombre del mes
            let nombreMes = fecha.toLocaleString('es-ES', { 
                month: 'short',
                year: 'numeric'
            });

            if (mesesVentasAgrupados.includes(nombreMes)) {
                continue;
            } else {
                mesesVentasAgrupados.push(nombreMes);
            }
        }

        // Agrupar las compras por mes
        for (let i = 0; i < comprasFechaAlta.length; i++) {
            let fecha = new Date(comprasFechaAlta[i]);
            let mes = fecha.getMonth();
            let year = fecha.getFullYear();
            let fechaFormateada = `${mes + 1}/${year}`;

            // obtener el nombre del mes
            let nombreMes = fecha.toLocaleString('es-ES', { 
                month: 'short',
                year: 'numeric'
            });

            if (mesesComprasAgrupados.includes(nombreMes)) {
                continue;
            } else {
                mesesComprasAgrupados.push(nombreMes);
            }
        }

        // Agrupar las ordenes por mes
        for (let i = 0; i < fechasOrdenes.length; i++) {
            let fecha = new Date(fechasOrdenes[i]);
            let mes = fecha.getMonth();
            let year = fecha.getFullYear();
            let fechaFormateada = `${mes + 1}/${year}`;

            // obtener el nombre del mes
            let nombreMes = fecha.toLocaleString('es-ES', { 
                month: 'short',
                year: 'numeric'
            });

            if (mesesOrdenesAgrupados.includes(nombreMes)) {
                continue;
            } else {
                mesesOrdenesAgrupados.push(nombreMes);
            }
        }

        const getRandomColor = () => {
            let letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        //  Data de los partes de trabajo
        let dataValues = estadosPartesAgrupados.map(estado => {
            return partesArray.filter(parte => {
                let estadoName = '';
                if (parte.Estado == 1) {
                    estadoName = 'Pendiente';
                } else if (parte.Estado == 2) {
                    estadoName = 'En proceso';
                } else {
                    estadoName = 'Finalizado';
                }
                return estadoName === estado;
            }).length;
        });

        // data de las ordenes de trabajo
        let dataValuesOrdenes = estadosOrdenesAgrupados.map(estado => {
            return ordenesArray.filter(orden => orden.Estado === estado).length;
        });

        // data de las citas
        let dataValuesCitas = mesesCitasAgrupados.map(mes => {
            return citasArray.filter(cita => {
                let fecha = new Date(cita.fechaDeAlta);
                let nombreMes = fecha.toLocaleString('es-ES', { 
                    month: 'short',
                    year: 'numeric'
                });
                return nombreMes === mes;
            }).length;
        });

        // data de las ventas
        let dataValuesVentas = mesesVentasAgrupados.map(mes => {
            return ventasArray.filter(venta => {
                let fecha = new Date(venta.FechaVenta);
                let nombreMes = fecha.toLocaleString('es-ES', { 
                    month: 'short',
                    year: 'numeric'
                });
                return nombreMes === mes;
            }).length;
        });

        // data de las compras
        let dataValuesCompras = mesesComprasAgrupados.map(mes => {
            return comprasArray.filter(compra => {
                let fecha = new Date(compra.fechaCompra);
                let nombreMes = fecha.toLocaleString('es-ES', { 
                    month: 'short',
                    year: 'numeric'
                });
                return nombreMes === mes;
            }).length;
        });

        // data de las ordenes
        let dataValuesOrdenesLine = mesesOrdenesAgrupados.map(mes => {
            return ordenesArray.filter(orden => {
                let fecha = new Date(orden.FechaAlta);
                let nombreMes = fecha.toLocaleString('es-ES', { 
                    month: 'short',
                    year: 'numeric'
                });
                return nombreMes === mes;
            }).length;
        });

        // Colores aleatorios para los sectores del gráfico
        let backgroundColors = [
            'rgba(36, 138, 254, 0.8)',
            'rgba(254, 224, 36, 0.8)',
            'rgba(254, 43, 36, 0.8)'
        ];

        // Colores aleatorios para los sectores del gráfico de ordenes
        let backgroundColorsOrdenes = [
            'rgba(36, 138, 254, 0.8)',
            'rgba(254, 224, 36, 0.8)',
            'rgba(254, 43, 36, 0.8)'
        ];

        // Colores aleatorios para los sectores del gráfico de citas
        let backgroundColorsCitas = [
            'rgba(36, 138, 254, 0.8)',
            'rgba(254, 224, 36, 0.8)',
            'rgba(254, 43, 36, 0.8)'
        ];

        // Colores aleatorios para los sectores del gráfico de ventas
        let backgroundColorsVentas = [
            'rgba(254, 43, 36, 0.8)',
        ];

        // Colores aleatorios para los sectores del gráfico de compras
        let backgroundColorsCompras = [
            'rgba(36, 138, 254, 0.8)',
        ];

        // Colores aleatorios para los sectores del gráfico de ordenes
        let backgroundColorsOrdenesLine = [
            'rgba(251, 168, 22, 0.8)',
        ];

        // DataTables
        let tables = {
            'partesTrabajoTable': false,
            'VentasTable': false,
            'CobrosTable': false,
            'ComprasTable': false
        };

        // Función para inicializar DataTables
        function initializeTable(tableId) {
            if (!tables[tableId]) {
                $('#' + tableId).DataTable({
                    colReorder: {
                        realtime: false
                    },
                    dom: "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
                        "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
                        "<'row'<'col-12'tr>>" +
                        "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",
                    order: [[0, 'desc']],
                    buttons: [],
                    pageLength: 50,  // Mostrar 50 registros por defecto
                    lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opciones para seleccionar cantidad de registros
                    language: {
                        processing: "Procesando...",
                        search: "Buscar:",
                        lengthMenu: "Mostrar _MENU_",
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
                    },
                });
                tables[tableId] = true;
            }
        }

        function inicializarPartesTable(tabId = null){
            
            // Inicializar la tabla de citas
            const agTablediv = document.querySelector('#PartesGrid');

            let rowData = {};
            let data = [];

            const partes = <?php if(isset($partes)): ?> <?php echo json_encode($partes, 15, 512) ?> <?php endif; ?>;
                
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
                        Acciones: 
                        `
                            <?php $__env->startComponent('components.actions-button'); ?>

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
                                
                            <?php echo $__env->renderComponent(); ?>
                        
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
                inicializarAGtable( agTablediv, data, result, 'Partes De Trabajo', customButtons, 'PartesTrabajo', true)

                $('.limpiarFiltrosBtn').removeClass('dt-button');
                $('.createParteTrabajoBtn').removeClass('dt-button');
                $('.venderVariosBtnClass').removeClass('dt-button');
                $('.confirmVentaBtnClass').removeClass('dt-button');
                $('.editParteTrabajoTable').css('cursor', 'pointer');
                $('.editParteTrabajoTable').css('text-decoration', 'underline');

                // si viene el tabId, seleccionar el tab correspondiente
                // Identificar tabla según tabId
                let table = tabId ? $(`${tabId} #PartesGrid`) : $('#PartesGrid');

                // Delegar eventos en el contenedor de la tabla
                table.off(); // Limpiar todos los eventos previos


                table.on('dblclick', '.showOrdenBtn', function(e){
                    openLoader();

                    const ordenId = $(this).data('id');

                    editOrdenTrabajo(ordenId);
                })

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

                table.on('click', '.editParteTrabajoBtn', function() {
                    openLoader();
                    const parteId = $(this).data('id');          
                    openDetailsParteTrabajoModal(parteId);
                });

                table.on('dblclick', '.editParteTrabajoTable', function() {
                    openLoader();
                    const parteId = $(this).data('id');          
                    openDetailsParteTrabajoModal(parteId);
                });

                table.on('click', '.detailsParteTrabajoBtn', function() {
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

                table.on('dblclick','.openProjectDetails', function(event){
                    const projectid = $(this).data('parteid');
                    getDetailsProject(projectid);
                });

            })

        }

        // Evento para detectar cuando un tab se muestra
        $('#myTab button').on('click', function (e) {
            let target = $(this).attr("data-bs-target"); // Obtener el ID del tab activo

            if (target === "#tab-citas") {
                inicializarPartesTable('#tab-citas');
            } else if (target === "#tab-ventas") {
                inicializarVentasTable('#tab-ventas');
            } else if (target === "#tab-cobros") {
                initializeTable('CobrosTable');
            } else if (target === "#tab-compras") {
                initializeTable('ComprasTable');
            }

            // Ajustar columnas para cualquier tabla visible
            // $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });

        // Inicializar la tabla visible al cargar la página
        initializeTable('partesTrabajoTable');
        initializeTable('OrdenesTable');

        // Inicializar la tabla de citas
        const agTablediv = document.querySelector('#OrdenesGrid');

        let rowData = {};
        let data = [];

        const ordenes = <?php echo json_encode($ordenes, 15, 512) ?>;

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
                rowData[orden.idOrdenTrabajo] = {
                    ID: orden.idOrdenTrabajo,
                    Parte: (orden.partes_trabajo && orden.partes_trabajo.length > 0) ? orden.partes_trabajo[0].idParteTrabajo : '',
                    Proyecto: (orden.proyecto && orden.proyecto.length > 0) ? orden.proyecto[0].name : '',
                    Asunto: orden.Asunto,
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
                        <?php $__env->startComponent('components.actions-button'); ?>
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
                        <?php echo $__env->renderComponent(); ?>
                    
                    `
                }
            });

            data = Object.values(rowData);
        }

        prepareRowData(ordenes);

        const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
            const customButtons = `
                <?php if(!$tokenValido): ?>
                    <button type="button" class="btn btn-outline-primary calendarButtonToken"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Conectar con Google Calendar"
                    >
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="mr-1">Conectar con Google Calendar</span>
                            <ion-icon name="cloud-upload-outline"></ion-icon>
                        </div>
                    </button>
                <?php endif; ?>
            `;

            // Inicializar la tabla de citas
            inicializarAGtable( agTablediv, data, result, 'Ordenes de Trabajo.', customButtons, 'OrdenesTrabajo');
        });

        // Grafico de partes de trabajo
        let citasGraphic = document.getElementById('canvas-citas').getContext('2d');
        let citas = new Chart(citasGraphic, {
            type: 'doughnut',
            data: {
                labels: estadosPartesAgrupados,
                datasets: [{
                    label: 'Partes de Trabajo',
                    data: dataValues,
                    backgroundColor: backgroundColors,
                    borderColor: backgroundColors,
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Partes de trabajo'
                    }
                },
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        // Obtener el índice del sector seleccionado
                        const index = elements[0].index;
                        // Obtener el estado asociado al sector
                        const estadoSeleccionado = this.data.labels[index];

                        $('#citas-tab').trigger('click');

                        // Llamar a una función para filtrar el DataTable
                        filtrarTablaPorEstado(estadoSeleccionado, 'partesTrabajoTable', 8);

                        // desplazar a la tabla
                        document.getElementById('partesTrabajoTable').scrollIntoView({ behavior: 'smooth' });

                    }
                }
            },
        });

        // Grafico de ordenes de trabajo

        let ventasGraphic = document.getElementById('canvas-ventas').getContext('2d');
        let ventas = new Chart(ventasGraphic, {
            type: 'doughnut',
            data: {
                labels: estadosOrdenesAgrupados,
                datasets: [{
                    label: 'Ordenes de Trabajo',
                    data: dataValuesOrdenes,
                    backgroundColor: backgroundColorsOrdenes,
                    borderColor: backgroundColorsOrdenes,
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Ordenes de trabajo'
                    }
                },
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        // Obtener el índice del sector seleccionado
                        const index = elements[0].index;
                        // Obtener el estado asociado al sector
                        const estadoSeleccionado = this.data.labels[index];

                        // Llamar a una función para filtrar el DataTable
                        filtrarTablaPorEstado(estadoSeleccionado, 'OrdenesTable');

                        // hacer scroll hasta la tabla
                        document.getElementById('OrdenesTable').scrollIntoView({ behavior: 'smooth' });

                    }
                }
            },
        });

        // Grafico de citas
        let cobrosGraphic = document.getElementById('canvas-cobros').getContext('2d');
        let cobros = new Chart(cobrosGraphic, {
            type: 'bar',
            data: {
                labels: mesesCitasAgrupados,
                datasets: [{
                    label: 'Citas',
                    data: dataValuesCitas,
                    backgroundColor: backgroundColorsCitas,
                    borderColor: backgroundColorsCitas,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafico de ventas
        let comprasGraphic = document.getElementById('canvas-compras').getContext('2d');
        let compras = new Chart(comprasGraphic, {
            type: 'line',
            data: {
                labels: mesesVentasAgrupados,
                datasets: [{
                    label: 'Ventas',
                    data: dataValuesVentas,
                    backgroundColor: backgroundColorsVentas,
                    borderColor: backgroundColorsVentas,
                    borderWidth: 5
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafico de compras
        let comprasGraphicRealizadas = document.getElementById('canvas-comprasRealizadas').getContext('2d');
        let comprasRealizadas = new Chart(comprasGraphicRealizadas, {
            type: 'line',
            data: {
                labels: mesesComprasAgrupados,
                datasets: [{
                    label: 'Compras',
                    data: dataValuesCompras,
                    backgroundColor: backgroundColorsCompras,
                    borderColor: backgroundColorsCompras,
                    borderWidth: 5
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafico de linea de ordenes
        let ordenesGraphicLine = document.getElementById('canvas-lineasOrdenes').getContext('2d');
        let ordenesLine = new Chart(ordenesGraphicLine, {
            type: 'line',
            data: {
                labels: mesesOrdenesAgrupados,
                datasets: [{
                    label: 'Ordenes',
                    data: dataValuesOrdenesLine,
                    backgroundColor: backgroundColorsOrdenesLine,
                    borderColor: backgroundColorsOrdenesLine,
                    borderWidth: 5
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const formatDate = (date) => { // retornar fecha DD/MM/YY
            const d = new Date(date);
            const year = d.getFullYear().toString().substr(-2);
            const month = (d.getMonth() + 1).toString().padStart(2, '0');
            const day = d.getDate().toString().padStart(2, '0');
            return `${day}/${month}/${year}`;
        }

        const limitText = (text, limit) => {
            return text.length > limit ? text.substring(0, limit) + '...' : text;
        }

        // function para acortar las palabras a 5 caracteres
        const truncateText = (text, limit = 5) => {
            return text.length > limit ? text.substring(0, limit) + '...' : text;
        }

        function populateTableData(tableId, data) {
            const table = $('#' + tableId).DataTable();
            table.clear(); // Limpia las filas existentes

            data.forEach(parte => {
                let orden = parte.orden_id;
                let row = [
                    `<span class="showOrdenBtn" data-id="${orden}" title="Ver orden">${orden}</span>`,
                    `<span class="editParteTrabajoTable" data-id="${parte.idParteTrabajo}">${parte.idParteTrabajo}</span>`,
                    formatDate(parte.FechaAlta),
                    formatDate(parte.FechaVisita),
                    `<span class="text-truncate" data-fulltext="${parte.cliente.NombreCliente+" "+parte.cliente.ApellidoCliente}">${truncateText(parte.cliente.NombreCliente+" "+parte.cliente.ApellidoCliente)}</span>`,
                    parte.Departamento,
                    `<span class="text-truncate" data-fulltext="${parte.Asunto}">${truncateText(parte.Asunto)}</span>`,
                    parte.solucion ? `<span class="text-truncate" data-fulltext="${parte.solucion}">${truncateText(parte.solucion)}</span>` : 'Sin solución',
                    parte.Estado == 1 ? '<span class="badge badge-warning">Pendiente</span>' : parte.Estado == 2 ? '<span class="badge badge-primary">En proceso</span>' : '<span class="badge badge-success">Finalizado</span>',
                    parte.estadoVenta == 1 ? '<span class="badge badge-warning">Pendiente</span>' : parte.estadoVenta == 2 ? '<span class="badge badge-success">Vendido</span>' : '<span class="badge badge-danger">No vendido</span>',
                    parte.suma ? parseFloat(parte.suma).toFixed(2) + '€' : '0€',
                   `<span class="text-truncate" data-fulltext="${parte.trabajo.nameTrabajo}">${truncateText(parte.trabajo.nameTrabajo)}</span>`,
                    parte.hora_inicio,
                    parte.hora_fin,
                    parte.horas_trabajadas,
                    parte.Observaciones ? `<span class="text-truncate" data-fulltext="${parte.Observaciones}">${truncateText(parte.Observaciones)}</span>` : 'Sin observaciones',
                    `
                        <?php $__env->startComponent('components.actions-button'); ?>
                            <button class="btn btn-info detailsParteTrabajoBtn" data-id="${parte.idParteTrabajo}">Detalles</button>
                            <button class="btn btn-primary editParteTrabajoBtn" data-id="${parte.idParteTrabajo}">Editar</button>
                            <a href="/ruta-al-pdf/${parte.idParteTrabajo}" class="btn btn-danger">PDF</a>
                            <a href="/ruta-al-excel/${parte.idParteTrabajo}" class="btn btn-success">Excel</a>
                            <a href="/ruta-al-zip/${parte.idParteTrabajo}" class="btn btn-warning">ZIP</a>
                        <?php echo $__env->renderComponent(); ?>
                    `
                ];

                table.row.add(row); // Añadir la fila a la tabla
            });

            table.draw(); // Refresca la tabla para que se muestren los datos
        }

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
                        img = $('<img>').attr('src', '<?php echo e(asset('img/file.png')); ?>').css({
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

        // consultar citas, ventas, cobros, compras dependiendo de la pestaña seleccionada
        
        let OrdenesGrid = $('#OrdenesGrid');
        // Detalles

        OrdenesGrid.on('click', '.btnOpenDetailsModal', function() {
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

        OrdenesGrid.on('click', '.btnOpenEditModal', function() {
            const idOrden = $(this).data('id');
            editOrdenTrabajo(idOrden);
        });

        OrdenesGrid.on('dblclick', '.btnOpenEditModalFast', function() {
            const orderId = $(this).data('id');
            editOrdenTrabajo(orderId);
        });

        // Editar

        OrdenesGrid.on('dblclick', '.editParteTrabajoTable', function() {
            openLoader();
            const parteId = $(this).data('id');          
            openDetailsParteTrabajoModal(parteId);
        });

        // Abrir detalles del proyecto
        OrdenesGrid.on('dblclick','.openProjectDetails', function(event){
            const parteId = $(this).data('parteid');
            getDetailsProject(parteId);
        });  
  
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\milecosl\resources\views/home.blade.php ENDPATH**/ ?>