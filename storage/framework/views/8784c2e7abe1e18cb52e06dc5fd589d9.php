<?php $__env->startSection('title', 'Compras'); ?>


<?php $__env->startSection('content'); ?>

    <style>
        #tableCard {
            background: rgba( 255, 255, 255, 0.7 );
            box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
            backdrop-filter: blur( 8.5px );
            -webkit-backdrop-filter: blur( 8.5px );
            border-radius: 10px;
            border: 1px solid rgba( 255, 255, 255, 0.18 );
            margin-top: 10px;
            border: 1px solid rgb(25, 135, 84)
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

            <div id="ComprasGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>

            
        </div>
    </div>

    <!-- Modal para Crear Compra -->
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalCreateCompra',
        'modalTitle' => 'Crear Compra',
        'modalSize' => 'modal-xl',
        'modalTitleId' => 'createCompraTitle',
        'btnSaveId' => 'btnCreateCompra',
        'disabledSaveBtn' => true,
        'hideButton' => true
    ]); ?>
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
                                            <?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($empresa->idEmpresa); ?>"><?php echo e($empresa->EMP); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                            <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($proveedor->idProveedor); ?>"><?php echo e($proveedor->nombreProveedor); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <input type="hidden" name="userAction" id="userAction" value="<?php echo e(Auth::id()); ?>">

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
    <?php echo $__env->renderComponent(); ?>

    
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalDetailsCompra',
        'modalTitle' => 'Detalles de la compra',
        'modalSize' => 'modal-xl',
        'modalTitleId' => 'DetailsCompraTitle',
        'disabledSaveBtn' => true,
        'hideButton' => true
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
                                        <select class="form-select" id="empresa_idDetails" name="empresa_id" required>
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
                                        <select class="form-select" id="proveedor_idDetails" name="proveedor_id" required>
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
    <?php echo $__env->renderComponent(); ?>

    <!-- Modal para Editar Compra -->
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalEditCompra',
        'modalTitle' => 'Editar Compra',
        'modalSize' => 'modal-xl',
        'modalTitleId' => 'editCompraTitle',
        'btnSaveId' => 'btnSaveEditCompra'
    ]); ?>
        

        <input type="hidden" name="idCompra" id="idCompraEdit">

        <div id="accordion">

            
            <div class="accordion-item" style="margin: 1rem">

                <h2 class="accordion-header" id="headingDetallesCompraEdit">
                    <button id="detailShopEdit" style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetallesCompraEdit" aria-expanded="true" aria-controls="collapseDetallesCompraEdit">
                        Detalles de la Compra
                    </button>
                </h2>

                <div id="collapseDetallesCompraEdit" class="accordion-collapse collapse show" aria-labelledby="headingDetallesCompraEdit" data-bs-parent="#accordion">
                    <div class="accordion-body">
                        <div class="card-body">
                            <form id="formEditCompra" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group required-field">
                                            <label class="form-label" for="fechaCompra">Fecha de Compra</label>
                                            <input type="date" class="form-control" id="fechaCompraEdit" name="fechaCompra" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required-field">
                                            <label class="form-label" for="empresa_id">Empresa</label>
                                            <select class="form-select" id="empresa_idEdit" name="empresa_id" required>
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
                                        <div class="form-group required-field">
                                            <label class="form-label" for="NFacturaCompra">Número de Factura</label>
                                            <input type="text" class="form-control" id="NFacturaCompraEdit" name="NFacturaCompra" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required-field">
                                            <label class="form-label" for="proveedor_id">Proveedor</label>
                                            <select class="form-select" id="proveedor_idEdit" name="proveedor_id" required>
                                                <option value="">Seleccione un proveedor</option>
                                                <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($proveedor->idProveedor); ?>"><?php echo e($proveedor->nombreProveedor); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <small id="proveedorHelpCreateCompraEdit" class="form-text text-muted">Si no encuentra el proveedor, puede crearlo aquí</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group required-field">
                                            <label class="form-label" for="formaPago">Forma de Pago</label>
                                            <select class="form-select" id="formaPagoEdit" name="formaPago" required>
                                                <option value="1">Banco</option>
                                                <option value="2">Efectivo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="Importe">Importe</label>
                                            <input type="number" class="form-control" id="ImporteEdit" name="Importe" value="0" step="0.01" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label" for="Iva">IVA</label>
                                            <input type="number" class="form-control" id="IvaEdit" name="Iva" value="21" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label" for="totalIva">Total IVA</label>
                                            <input type="number" class="form-control" id="totalIvaEdit" value="0" name="totalIva" step="0.01" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label" for="totalFactura">Total Factura</label>
                                            <input type="number" class="form-control" id="totalFacturaEdit" value="0" name="totalFactura" step="0.01" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group required-field">
                                            <label class="form-label" for="suplidosCompras">Total Exacto</label>
                                            <input type="number" class="form-control" id="totalFacturaExactoEdit" value="0" name="totalFacturaExacto" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="suplidosCompras">Suplidos</label>
                                            <input type="number" class="form-control" id="suplidosComprasEdit" value="0" name="suplidosCompras" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group required-field">
                                            <label class="form-label" for="NAsientoContable">Número de Asiento Contable</label>
                                            <input type="text" class="form-control" id="NAsientoContableEdit" name="NAsientoContable">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="ObservacionesCompras">Observaciones</label>
                                            <textarea class="form-control" id="ObservacionesComprasEdit" name="ObservacionesCompras" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group required-field">
                                            <label class="form-label" for="Plazos">Plazos</label>
                                            <select class="form-select" id="PlazosEdit" name="Plazos" required>
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
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group plazo-fields plazo1" style="display: none;">
                                            <label for="proximoPago">Próxima Fecha de Pago</label>
                                            <input type="date" class="form-control" id="proximoPagoEdit" name="proximoPago">
                                        </div>
                                    </div>
                                </div>

                                <div class="row" >
                                    <div class="col-md-6">
                                        <div class="form-group plazo-fields plazo2" style="display: none;">
                                            <label for="frecuenciaPago">Frecuencia de Pagos</label>
                                            <select class="form-select" id="frecuenciaPagoEdit" name="frecuenciaPago">
                                                <option value="mensual">Mensual</option>
                                                <option value="semanal">Semanal</option>
                                                <option value="quincenal">Quincenal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group plazo-fields plazo2" style="display: none;">
                                            <label for="siguienteCobro">Fecha del Siguiente Cobro</label>
                                            <input type="date" class="form-control" id="siguienteCobroEdit" name="siguienteCobro">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fileEdit">Factura</label>
                                            <input type="file" class="form-control" id="fileEdit" name="file"></input>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="previewOfPdfEdit" class="form-group"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
            
            <div class="accordion-item" style="margin: 1rem">
                <h2 class="accordion-header" id="headingElementosCompraEdit">
                    <button style="border: 1px solid gray; padding: 1rem; border-radius: 10px; margin-bottom: 1rem" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseElementosCompraEdit" aria-expanded="false" aria-controls="collapseElementosCompraEdit">
                        Elementos de Compra
                    </button>
                </h2>
                <div id="collapseElementosCompraEdit" class="accordion-collapse collapse" aria-labelledby="headingElementosCompraEdit" data-bs-parent="#accordion">
                    <div class="accordion-body">
                        <div class="container">
                            <table id="tableToShowElementsEdit" class="table" style="font-size: 10px">
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
                                        <th>Autor</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="elementsToShowEdit">
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-2" id="newLinesContainerEdit"></div>
                        <button id="addNewLineEdit" type="button" class="btn btn-outline-primary mb-2">Añadir línea</button>
                    </div>
                </div>
            </div>

        </div>

    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalEditLinea',
        'modalTitle' => 'Editar Línea de Compra',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editLineaTitle',
        'btnSaveId' => 'btnSaveEditLinea'
    ]); ?>

        <form id="formEditLinea">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <input type="hidden" name="idLinea" id="idLineaEdit">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cod_prov">Codigo proveedor</label>
                        <input type="text" class="form-control" id="cod_provEdit" name="cod_prov" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" id="descripcionEdit" name="descripcion" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" id="cantidadEdit" name="cantidad" required>
                    </div>
                </div>
                <div class="col-md-2">
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
        
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalEditLineaCreate',
        'modalTitle' => 'Editar Línea de Compra',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editLineaTitleCreate',
        'btnSaveId' => 'btnSaveEditLineaCreate'
    ]); ?>

        <form id="formEditLinea">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

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
        
    <?php echo $__env->renderComponent(); ?>

    <!-- Modal para Crear Proveedor -->
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalCreateProveedor',
        'modalTitle' => 'Crear Proveedor',
        'modalSize' => 'modal-xl',
        'modalTitleId' => 'createProveedorTitle',
        'btnSaveId' => 'btnCreateProveedor'
    ]); ?>
        <?php echo $__env->make('admin.proveedores.formcreate', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->renderComponent(); ?>

    
    <?php $__env->startComponent('components.modal-component',[
        'modalId' => 'showDetailsModal',
        'modalTitleId' => 'showDetailsModalLabel',
        'modalTitle' => 'Historial de usos',
        'modalSize' => 'modal-xl',
        'hideButton' => true,
    ]); ?>

        <div class="row col-sm-12" id="showAccordeons">

        </div>
        
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'editParteTrabajoModal',
        'modalTitle' => 'Editar Parte de trabajo',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveEditParteTrabajoBtn',
        'modalTitleId' => 'editParteTrabajoTitle',
        'otherButtonsContainer' => 'editParteTrabajoFooter'
    ]); ?>
       <?php echo $__env->make('admin.partes_trabajo.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

    <script>
        $(document).ready(function () {

            // let table = $('#ComprasTable').DataTable({
            //     colReorder: {
            //         realtime: false
            //     },
            //     order: [[0, 'desc']],
            //     // autoFill: true,
            //     // fixedColumns: true,
            //     // Ajuste para mostrar los botones a la izquierda, el filtro a la derecha, y el selector de cantidad de registros
            //     dom: 
            //     "<'row'<'col-12 mb-2'<'table-title'>>>" +
            //     "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
            //     "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
            //     "<'row'<'col-12'tr>>" +
            //     "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

            //     buttons: [
            //         {
            //             text: 'Crear Compra',
            //             className: 'btn btn-outline-warning createCompraBtn mb-2',
            //             action: function () {
            //                 $('#modalCreateCompra').modal('show');
            //             }
            //         },
            //         {
            //             text: 'Limpiar Filtros', 
            //             className: 'btn btn-outline-danger limpiarFiltrosBtn mb-2', 
            //             action: function (e, dt, node, config) { 
            //                 clearFiltrosFunction(dt, '#ComprasTable');
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
            //     // columnDefs: [
            //     //     {
            //     //         targets: [2,3,4,5],  // Índices de las columnas con textos truncados
            //     //         render: function(data, type, row, meta) {
            //     //             if (type === 'filter' || type === 'sort') {
            //     //                 // Accede directamente al atributo data-fulltext de la celda
            //     //                 return meta.settings.aoData[meta.row].anCells[meta.col].getAttribute('data-fulltext');
            //     //             }
            //     //             // Devuelve el contenido visible para la visualización
            //     //             return data;
            //     //         }
            //     //     }
            //     // ],
            //     initComplete: function () {
            //         configureInitComplete(this.api(), '#ComprasTable', 'COMPRAS', 'success');
            //     }
            // });

            // table.on('init.dt', function() {
            //     restoreFilters(table, '#ComprasTable');// Restaurar filtros después de inicializar la tabla
            // });

            // mantenerFilaYsubrayar(table);
            // fastEditForm(table, 'Compra');

            // Inicializar la tabla de citas
            const agTablediv = document.querySelector('#ComprasGrid');

            let rowData = {};
            let data = [];

            const compras = <?php echo json_encode($compras, 15, 512) ?>;

            const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
                { 
                    name: 'ID',
                    fieldName: 'Compra',
                    addAttributes: true, 
                    addcustomDatasets: true,
                    dataAttributes: { 
                        'data-id': ''
                    },
                    attrclassName: 'openEditCompraFast',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                    principal: true
                },
                { 
                    name: 'FechaCompra',
                    className: 'fecha-alta-column',
                    fieldName: 'fechaCompra',
                    fieldType: 'timestamp',
                    editable: true,
                    // styles: {
                    //     'cursor': 'pointer',
                    //     'text-decoration': 'underline'
                    // },
                }, 
                { 
                    name: 'NºFactura',
                    addAttributes: true,
                    fieldName: 'NFacturaCompra',
                    fieldType: 'textarea',
                    dataAttributes: { 
                        'data-order': 'order-column' 
                    },
                    editable: true,
                    attrclassName: 'openProjectDetails',
                    // styles: {
                    //     'cursor': 'pointer',
                    //     'text-decoration': 'underline'
                    // },
                },
                { 
                    name: 'TipoDoc',
                    fieldName: 'tipo_doc',
                    fieldType: 'textarea',
                    editable: true,
                    // styles: {
                    //     'cursor': 'pointer',
                    //     'text-decoration': 'underline'
                    // },
                },
                { 
                    name: 'Proveedor',
                    fieldName: 'proveedor_id',
                    fieldType: 'select',
                    addAttributes: true,
                },
                { 
                    name: 'Emp',
                },
                { name: 'FPago' },
                { name: 'Total' },
                { name: 'TExacto' },
                { name: 'Iva' },
                { name: 'TIva' },
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
                    name: "Autor",
                },
                { 
                    name: 'Acciones',
                    className: 'acciones-column'
                }
            ];

            function prepareRowData(compras) {
                compras.forEach(compra => {
                    // console.log(compra)
                    // console.log(parte);
                    // if (parte.proyecto_n_m_n && parte.proyecto_n_m_n.length > 0) {
                    //     console.log({proyecto: parte.proyecto_n_m_n[0].proyecto.name});
                    // }
                    let autor = 'Sin registro';
                    if (compra.lineas && compra.lineas.length > 0) {
                        // Obtén los nombres únicos de los autores
                        const nombresUnicos = [...new Set(compra.lineas.map(linea => linea.user?.name).filter(Boolean))];

                        // si en el user es null, entonces se le asigna el nombre de 'Sin registro'
                        if (nombresUnicos.length == 0) {
                            nombresUnicos.push('Sin registro');
                        }
                        // Unir los nombres únicos con comas
                        autor = nombresUnicos.join(', ');
                    }
                    rowData[compra.idCompra] = {
                        ID: compra.idCompra,
                        FechaCompra: formatDateYYYYMMDD(compra.fechaCompra),
                        NºFactura: compra.NFacturaCompra,
                        TipoDoc: compra.tipo_doc ?? '',
                        Proveedor: compra.proveedor.nombreProveedor,
                        Emp: compra.empresa.EMP,
                        FPago: (compra.formaPago == 1) ? 'Banco' : 'Efectivo',
                        Total: formatPrice(compra.totalFactura),
                        TExacto: formatPrice(compra.totalExacto),
                        Iva: compra.Iva + '%',
                        TIva: formatPrice(compra.totalIva),
                        Observaciones: compra.ObservacionesCompras,
                        Notas1: compra.notas1,
                        Notas2: compra.notas2,
                        Autor: autor,
                        Acciones: 
                        `
                            <?php $__env->startComponent('components.actions-button'); ?>
                                <button
                                    type="button"
                                    class="btn btn-outline-primary modalEditCompras"
                                    data-id="${compra.idCompra}"
                                    data-fecha="${compra.fechaCompra}"
                                    data-nfactura="${compra.NFacturaCompra}"
                                    data-proveedor="${compra.proveedor_id}"
                                    data-formapago="${compra.formaPago}"
                                    data-importe="${compra.Importe}"
                                    data-iva="${compra.Iva}"
                                    data-totaliva="${compra.totalIva}"
                                    data-retenciones="${compra.retencionesCompras}"
                                    data-totalretenciones="${compra.totalRetenciones}"
                                    data-total="${compra.totalFactura}"
                                    data-suplidos="${compra.suplidosCompras}"
                                    data-empresa="${compra.empresa_id}"
                                    data-nasiento="${compra.NAsientoContable}"
                                    data-observaciones="${compra.ObservacionesCompras}"
                                    data-plazos="${compra.Plazos}"
                                    data-lineas="${compra.lineas}"
                                    data-archivo="${compra.archivos}"
                                    data-proximafecha="${compra.plazos}"
                                    data-totalfacturaexacto="${compra.totalExacto}"
                                >
                                    <div class="d-flex justify-between align-items-center align-content-center flex-wrap flex-column">
                                        <ion-icon name="create-outline"></ion-icon>
                                        <small>Editar</small>
                                    </div>
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-info modalDetailsCompras"
                                    data-id="${compra.idCompra}"
                                    data-fecha="${compra.fechaCompra}"
                                    data-nfactura="${compra.NFacturaCompra}"
                                    data-proveedor="${compra.proveedor_id}"
                                    data-formapago="${compra.formaPago}"
                                    data-importe="${compra.Importe}"
                                    data-iva="${compra.Iva}"
                                    data-totaliva="${compra.totalIva}"
                                    data-retenciones="${compra.retencionesCompras}"
                                    data-totalretenciones="${compra.totalRetenciones}"
                                    data-total="${compra.totalFactura}"
                                    data-suplidos="${compra.suplidosCompras}"
                                    data-empresa="${compra.empresa_id}"
                                    data-nasiento="${compra.NAsientoContable}"
                                    data-observaciones="${compra.ObservacionesCompras}"
                                    data-plazos="${compra.Plazos}"
                                    data-lineas='${JSON.stringify(compra.lineas)}'
                                    data-archivo='${JSON.stringify(compra.archivos)}'
                                    data-proximafecha="${compra.plazos}"
                                    data-totalfacturaexacto="${compra.totalExacto}"
                                >
                                    <div class="d-flex justify-between align-items-center align-content-center flex-wrap flex-column">
                                        <ion-icon name="eye-outline"></ion-icon>
                                        <small>Detalles</small>
                                    </div>
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-danger deleteCompra"
                                    data-id="${compra.idCompra}"
                                >
                                    <div class="d-flex justify-between align-items-center align-content-center flex-wrap flex-column">
                                        <ion-icon name="trash-outline"></ion-icon>
                                        <small>Eliminar</small>
                                    </div>
                                </button>
                            <?php echo $__env->renderComponent(); ?>
                        
                        `
                    }
                });

                data = Object.values(rowData);
            }

            prepareRowData(compras);

            const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
                const customButtons = `
                    <button type="button" class="btn btn-outline-warning createCompraBtn">
                        <div class="d-flex justify-between align-items-center align-content-center">
                            <small>Crear Compra</small>
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                    </button>
                `;
    
                // Inicializar la tabla de citas
                inicializarAGtable( agTablediv, data, result, 'Compras', customButtons, 'Compra');
            });

            let table = $('#ComprasGrid');

            // Resto de codigo

            $('#collapseElementosCompra #tableToShowElementsDetails').DataTable({
                // autoFill: true,
                // fixedColumns: true,
                // disablem order asc and desc and pagination
                ordering: false,
                paging: false,
                responsive: true,
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

            let compraGuardadaGlobal = false;
            let globalLineas = 0;
            let sumaTotalesLineas = 0;

            // validar que el input de subir archivos solo acepte pdf
            $('#fileCreate').on('change', function() {
                let file = $(this)[0].files[0];
                let fileType = file.type;

                if (fileType !== 'application/pdf') {
                    Swal.fire({
                        title: 'Error',
                        text: 'El archivo debe ser de tipo PDF',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });

                    $(this).val('');
                }
            });

            $('#modalCreateCompra #fileCreate').on('change', function(event){
                // Obtener el archivo seleccionado y mostrar vista previa
                const file = event.target.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#modalCreateCompra #previewOfPdfCreate').html(`
                        <embed src="${e.target.result}" width="100%" height="600px" />
                    `);
                };

                reader.readAsDataURL(file);

                // Mostrar el nombre del archivo seleccionado
                $('#modalCreateCompra #fileCreate').on('change', function() {
                    let fileName = $(this).val().split('\\').pop();
                    $(this).next('.custom-file-label').html(fileName);
                });

            });

            // Mostrar modal para crear compra
            table.on('click', '.createCompraBtn', function (e) {
                e.preventDefault();
                $('#modalCreateCompra').modal('show');
                $('#modalCreateCompra #createCompraTitle').text('Crear Compra');
                $('#modalCreateCompra #formCreateCompra')[0].reset(); // Reiniciar formulario
                $('#modalCreateCompra #fileCreate').val(''); // Limpiar el input de subir archivo
                $('#modalCreateCompra #previewOfPdfCreate').empty(); // Limpiar la vista previa del PDF
                $('#modalCreateCompra #guardarCompra').attr('disabled', false); // Habilitar el botón de guardar

                // Si los campos de la compra están deshabilitados, habilitarlos
                $('#modalCreateCompra #formCreateCompra input, #modalCreateCompra #formCreateCompra select, #modalCreateCompra #formCreateCompra textarea').attr('disabled', false);

                $('#modalCreateCompra #IvaCreateCompra').val(21);
                $('#modalCreateCompra #fechaCompra').val(moment().format('YYYY-MM-DD'));
                $('#modalCreateCompra #ObservacionesCompras').val('Sin observaciones');
                $('#modalCreateCompra #NAsientoContable').val(1);

                // inicializar todos los select en selec2
                $('#modalCreateCompra select.form-select').select2({
                    width: '100%',
                    placeholder: 'Seleccione una opción',
                    dropdownParent: $('#modalCreateCompra')
                });

                $('#modalCreateCompra #proveedorHelpCreateCompra').css('cursor', 'pointer', 'text-decoration', 'underline');

            });

            $('#modalEditCompra #proveedorHelpCreateCompraEdit').on('click', function() {
                $('#modalCreateProveedor').modal('show');
                $('#modalCreateProveedor #formCreateProveedor')[0].reset();

                $('#modalCreateProveedor #createProveedorTitle').text('Crear Proveedor');

                $('#modalCreateProveedor #formCreateProveedor input, #modalCreateProveedor #formCreateProveedor select, #modalCreateProveedor #formCreateProveedor textarea').attr('disabled', false);
            });

            $('#modalCreateCompra #proveedorHelpCreateCompra').on('click', function() {
                $('#modalCreateProveedor').modal('show');
                $('#modalCreateProveedor #formCreateProveedor')[0].reset();

                $('#modalCreateProveedor #createProveedorTitle').text('Crear Proveedor');

                $('#modalCreateProveedor #formCreateProveedor input, #modalCreateProveedor #formCreateProveedor select, #modalCreateProveedor #formCreateProveedor textarea').attr('disabled', false);
            });

            $('#btnCreateProveedor').on('click', function(event){
                openLoader();
                event.preventDefault();

                let form = $('#modalCreateProveedor #formCreateProveedor');
                let formData = new FormData(form[0]);

                $.ajax({
                    url: '<?php echo e(route("admin.proveedores.storeApi")); ?>',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        closeLoader();
                        $('#modalCreateProveedor').modal('hide');
                        Swal.fire({
                            title: 'Proveedor creado',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });

                        // Actualizar el select de proveedores
                        $('#modalCreateCompra #proveedor_id').append(`
                            <option value="${response.id}">${response.nombreProveedor}</option>
                        `);

                        // Seleccionar el proveedor recién creado
                        $('#modalCreateCompra #proveedor_id').val(response.id).trigger('change');

                        // Actualizar el select de proveedores
                        $('#modalEditCompra #proveedor_idEdit').append(`
                            <option value="${response.id}">${response.nombreProveedor}</option>
                        `);

                        // Seleccionar el proveedor recién creado
                        $('#modalEditCompra #proveedor_idEdit').val(response.id).trigger('change');
                    },
                    error: function(error) {
                        closeLoader(); 
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al crear el proveedor',
                            icon: 'error',
                            footer: error.responseJSON.message,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });

            });

            const calcularTotales = (id) => {
                return new Promise((resolve, reject) => {
                    let importe = parseFloat($('#modalCreateCompra #Importe').val()) || 0;
                    let suplidos = parseFloat($('#modalCreateCompra #suplidosCompras').val()) || 0;
                    let iva      = parseFloat($('#modalCreateCompra #IvaCreateCompra').val()) || 21;
                    
                    iva = iva / 100;

                    let totalIva = (importe * iva).toFixed(2);
                    console.log({totalIva})
                    let totalFactura = (importe + parseFloat(totalIva) + suplidos).toFixed(2);
                    console.log({totalFactura})

                    // sumar los totales de las lineas
                    let sumaTotalesLineas = calcularSumaTotalesLineas();

                    // calcular el total del iva en base a las lineas
                    let totalIvaLineas = (sumaTotalesLineas * iva).toFixed(2);

                    // calcular el total de la factura en base a las lineas
                    let totalFacturaLineas = (sumaTotalesLineas + parseFloat(totalIvaLineas) + suplidos).toFixed(2);

                    // Esperar 2 segundos antes de hacer la petición (puedes ajustar este valor según sea necesario)
                    const sumatTotalesLineasPeticion = sumaTotalesLineas.toFixed(2);
                    setTimeout(() => {
                        if (id) {
                            $.ajax({
                                url: `<?php echo e(route('admin.compras.updatesum', ':id')); ?>`.replace(':id', id),
                                method: 'POST',
                                data: {
                                    _token: '<?php echo e(csrf_token()); ?>',
                                    importe: sumatTotalesLineasPeticion,
                                    suplidos: suplidos,
                                    totalIva: totalIvaLineas,
                                    totalFactura: totalFacturaLineas
                                },
                                success: function(response) {
                                    $('#modalCreateCompra #Importe').val(sumaTotalesLineas.toFixed(2));
                                    $('#modalCreateCompra #totalIvaCreateCompra').val(totalIvaLineas);
                                    $('#modalCreateCompra #totalFacturaCreateCompra').val(totalFacturaLineas);
                                    resolve(); // Finalizar la promesa cuando la actualización es exitosa
                                },
                                error: function(error) {
                                    console.log(error);
                                    reject(error); // Rechazar la promesa en caso de error
                                }
                            });
                        } else {
                            resolve(); // Finalizar la promesa si no hay ID
                        }
                    }, 2000);
                });
            };

            $('#Importe, #suplidosCompras').on('change', calcularTotales);

            // Guardar nueva compra
            $('#guardarCompra').click(function () {
                openLoader();
                const table = $('#tableToShowElements');
                const elements = $('#elementsToShow');

                // Ocultar tabla de elementos
                table.hide();
                
                // Obtener los datos del formulario en un objeto FormData
                const formData = new FormData($('#formCreateCompra')[0]);

                // Agregar el token CSRF manualmente si no se incluye automáticamente en el formulario
                formData.append('_token', '<?php echo e(csrf_token()); ?>');

                $.ajax({
                    url: '<?php echo e(route("admin.compras.store")); ?>',
                    method: 'POST',
                    data: formData,
                    processData: false,  // No procesar los datos (FormData no necesita ser procesado)
                    contentType: false,  // No establecer automáticamente el tipo de contenido
                    success: function({ message, compra, proveedor, empresa, archivos }) {
                        closeLoader();
                        // Cerrar primer acordeón y abrir el segundo
                        $('#collapseDetallesCompra').collapse('hide');
                        $('#collapseElementosCompra').collapse('show');

                        Swal.fire({
                            title: 'Compra guardada',
                            text: message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });

                        compraGuardadaGlobal = true;
                        $('#guardarCompra').attr('disabled', true);
                        $('#modalCreateCompra #idCompraCreate').val(compra.idCompra);

                        if (compraGuardadaGlobal) {
                            // Desactivar todos los inputs del formulario de compra
                            $('#formCreateCompra input, #formCreateCompra select, #formCreateCompra textarea').attr('disabled', true);

                            $('#modalCreateCompra #addNewLine').click(function() {
                                globalLineas++;
                                let newLine = `
                                    <form id="AddNewLineForm${globalLineas}" class="mt-2 mb-2">
                                        <small class="text-muted mb-2">Si ingresas una cantidad ( de articulos ) en decimales, se hará un calculo automatico, para colocar la cantidad en un número entero.</small>

                                        <div class="row">
                                            <input type="hidden" id="compra_id" name="compra_id" value="${compra.idCompra}">
                                            <input type="hidden" id="empresaId" name="empresa_id" value="${empresa.idEmpresa}">
                                            <input type="hidden" id="empresaNameId" name="empresa_name" value="${empresa.EMP}">
                                            <input type="hidden" id="proveedor_id" name="proveedor_id" value="${proveedor.idProveedor}">
                                            <input type="hidden" id="proveedor_cif" name="proveedor_cif" value="${compra.NFacturaCompra}">
                                            <input type="hidden" id="nameProovedorId" name="proovedorName" value="${proveedor.nombreProveedor}">
                                            <input type="hidden" id="archivoId" name="archivo_id" value="${archivos[0].idarchivos}">
                                            <input type="hidden" id="totalFactura" name="totalFactura" value="${compra.totalFactura}">
                                            <input type="hidden" id="sumaTotalesLineas" data-value="0">
                                            
                                            <div class="form-floating col-md-4 mb-2">
                                                <input class="form-control" name="cod_prov" placeholder="cod_prov" id="cod_prov${globalLineas}">
                                                <label for="cod_prov${globalLineas}">Codigo Proveedor</label>
                                            </div>
                                            <div class="form-floating col-md-4">
                                                <textarea class="form-control" placeholder="descripcion" id="descripcion${globalLineas}"></textarea>
                                                <label for="descripcion${globalLineas}">Descripcion</label>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="cantidad${globalLineas}">Cantidad</label>
                                                    <input type="number" class="form-control cantidad" id="cantidad${globalLineas}" name="cantidad" step="0.01" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="precioSinIva${globalLineas}">Precio sin iva</label>
                                                    <input type="number" class="form-control precioSinIva" id="precioSinIva${globalLineas}" name="precioSIva" step="0.01" required disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="RAE${globalLineas}">RAE</label>
                                                    <input type="number" value="0" class="form-control rae" id="RAE${globalLineas}" name="RAE" value="0">    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="descuento${globalLineas}">Descuento</label>
                                                    <input type="number" value="0" class="form-control descuento" id="descuento${globalLineas}" name="descuento" required disabled>    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="total${globalLineas}">Total</label>
                                                    <input type="number" class="form-control total" id="total${globalLineas}" name="total" value="0" required disabled>    
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-success saveLinea" data-line="${globalLineas}">Guardar</button>    
                                    </form>
                                `;

                                $('#modalCreateCompra #newLinesContainer').append(newLine);

                                // evento para cod_prov${globalLineas} y si existe en la base de datos, traer la descripcion y el precio sin iva
                                $(`#modalCreateCompra #cod_prov${globalLineas}`).off('change').on('change', function() {
                                    let cod_prov = $(this).val();
                                    let form = $(this).closest('form');
                                    let descripcion = form.find(`#descripcion${globalLineas}`);
                                    let precioSinIva = form.find(`#precioSinIva${globalLineas}`);

                                    $.ajax({
                                        url: `<?php echo e(route('admin.compras.getArticuloByCodigo')); ?>`,
                                        method: 'GET',
                                        data: {
                                            cod_prov: cod_prov
                                        },
                                        beforeSend: function(){
                                            openLoader();
                                        },
                                        success: function(response) {
                                            closeLoader();
                                            descripcion.val(response.articulo.descripcion);
                                            precioSinIva.val(response.articulo.precioSinIva);
                                            precioSinIva.attr('disabled', false);

                                            // auto ajustar el textarea de la descripcion
                                            descripcion.css('height', 'auto');
                                            descripcion.css('height', descripcion[0].scrollHeight + 'px');

                                        },
                                        error: function(error) {
                                            closeLoader();
                                            console.log(error);
                                        }
                                    });
                                });

                                // Delegar eventos en el contenedor para manejar los cambios de los campos dinámicos
                                $('#modalCreateCompra #newLinesContainer').on('change', `#cantidad${globalLineas}`, function () {
                                    let form = $(this).closest('form');
                                    let cantidad = parseFloat($(this).val());
                                    let precioSinIvaInput = $(this).closest('form').find('.precioSinIva');
                                    let totalCompra = parseFloat($('#modalCreateCompra #totalFactura').val());
                                    let totalInput = form.find('.total');;

                                    // Validar si precio sin IVA es diferente de 0
                                    let precioSinIva = parseFloat(precioSinIvaInput.val());

                                    // validar si la cantidad es un decimal
                                    if ( cantidad % 1 !== 0 && !isNaN(precioSinIva) ) {
                                        // tenemos que hacer el calculo agregando un 0 al precio sin iva para obtener el total de los articulos y cambiar la cantidad a entero
                                        // agregar un 0 al precio sin iva
                                        let valor = '';
                                        let valorArray = '';
                                        let valorEntero = '';
                                        let valorDecimal = '';
                                        let valorFinal = '';
                                        let precioSinIvaFinal = '';

                                        let cantidadString = cantidad.toString();
                                        let cantidadArray = cantidadString.split('.');
                                        let cantidadEntero = cantidadArray[0];
                                        let cantidadDecimal = cantidadArray[1];

                                        if ( cantidadDecimal.startsWith('0') ) {
                                            // agregar un 0 al precio sin iva
                                            valor = precioSinIva.toString();
                                            valorArray = valor.split('.');
                                            valorEntero = valorArray[0];
                                            valorDecimal = valorArray[1];
                                            valorFinal = '0.'+'0'+valorEntero+valorDecimal;
                                            precioSinIvaFinal = parseFloat(valorFinal);
                                        }else{
                                            // agregar un 0 al precio sin iva
                                            valor = precioSinIva.toString();
                                            valorArray = valor.split('.');
                                            valorEntero = valorArray[0];
                                            valorDecimal = valorArray[1];
                                            valorFinal = '0.'+valorEntero+valorDecimal;
                                            precioSinIvaFinal = parseFloat(valorFinal);
                                        }

                                        
                                        if (precioSinIva !== 0) {
                                            precioSinIvaInput.val(precioSinIvaFinal);
                                            const total = cantidad * precioSinIvaFinal;

                                            cantidad = cantidad * 100;
                                            $(this).val(cantidad);
                                            totalInput.val(total.toFixed(2));
                                            const descuentoInput = $(this).closest('form').find('.descuento');
                                            descuentoInput.attr('disabled', false);
                                            
                                        }
                                    }


                                    if (precioSinIva !== 0 && cantidad % 1 === 0) {
                                        const total = cantidad * precioSinIva;
                                        totalInput.val(total.toFixed(2));
                                        const descuentoInput = $(this).closest('form').find('.descuento');
                                        descuentoInput.attr('disabled', false);
                                    }

                                    // Validar si el descuento es diferente de 0
                                    const descuento = parseFloat($(this).closest('form').find('.descuento').val());

                                    if (descuento !== 0) {
                                        const descuentoPorcentaje = (descuento * (precioSinIva * cantidad)) / 100;
                                        const resultado = (cantidad * precioSinIva) - descuentoPorcentaje;
                                        const total = resultado.toFixed(2);

                                        if (total < 0 ) {
                                            Swal.fire({
                                                title: 'Error',
                                                text: 'El total no puede ser menor a 0 ni mayor al total de la compra',
                                                icon: 'error',
                                                confirmButtonText: 'Aceptar'
                                            });
                                        } else {
                                            totalInput.val(total);
                                        }
                                    }

                                    if (!cantidad) {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'La cantidad es requerida',
                                            icon: 'error',
                                            confirmButtonText: 'Aceptar'
                                        });
                                    } else {
                                        precioSinIvaInput.attr('disabled', false);
                                    }
                                });

                                // Evento para cuando cambia el precio sin IVA
                                $('#modalCreateCompra #newLinesContainer').on('change', `#precioSinIva${globalLineas}`, function () {
                                    let precioSinIva = parseFloat($(this).val());
                                    let totalCompra = parseFloat($('#modalCreateCompra #totalFactura').val());
                                    let form = $(this).closest('form');
                                    let cantidad = parseFloat(form.find('.cantidad').val());
                                    let totalInput = form.find('.total');
                                    let descuentoInput = form.find('.descuento');

                                    let descuento = parseFloat(form.find('.descuento').val());

                                    // verificar si la cantidad es un decimal
                                    if ( cantidad % 1 !== 0 ) {
                                        // tenemos que hacer el calculo agregando un 0 al precio sin iva para obtener el total de los articulos y cambiar la cantidad a entero

                                        // Verificar si la cantidad es tipo 0.06 0.06 porque al precio sin iva se le agrega un 0 mas

                                        let valor = '';
                                        let valorArray = '';
                                        let valorEntero = '';
                                        let valorDecimal = '';
                                        let valorFinal = '';
                                        let precioSinIvaFinal = '';
                                        
                                        let cantidadString = cantidad.toString();
                                        let cantidadArray = cantidadString.split('.');
                                        let cantidadEntero = cantidadArray[0];
                                        let cantidadDecimal = cantidadArray[1];

                                        if ( cantidadDecimal.startsWith('0') ) {
                                            // agregar un 0 al precio sin iva
                                            valor = precioSinIva.toString();
                                            valorArray = valor.split('.');
                                            valorEntero = valorArray[0];
                                            valorDecimal = valorArray[1];
                                            valorFinal = '0.'+'0'+valorEntero+valorDecimal;
                                            precioSinIvaFinal = parseFloat(valorFinal);
                                        }else{
                                            // agregar un 0 al precio sin iva
                                            valor = precioSinIva.toString();
                                            valorArray = valor.split('.');
                                            valorEntero = valorArray[0];
                                            valorDecimal = valorArray[1];
                                            valorFinal = '0.'+valorEntero+valorDecimal;
                                            precioSinIvaFinal = parseFloat(valorFinal);
                                        }

                                        precioSinIva = precioSinIvaFinal;
                                        form.find('.precioSinIva').val(precioSinIva);

                                        // cambiar la cantidad a entero es decir 0.39 se conviernte en 39
                                        cantidad = cantidad * 100;
                                        form.find('.cantidad').val(cantidad);
                                    }

                                    if (!precioSinIva) {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'El precio sin IVA es requerido',
                                            icon: 'error',
                                            confirmButtonText: 'Aceptar'
                                        });
                                    } else {
                                        let total = cantidad * precioSinIva;

                                        // Aplicar descuento si lo hay
                                        if (descuento !== 0) {
                                            const descuentoPorcentaje = (descuento * total) / 100;
                                            total = total - descuentoPorcentaje;
                                        }

                                        if (total < 0) {
                                            Swal.fire({
                                                title: 'Error',
                                                text: 'El total no puede ser menor que 0',
                                                icon: 'error',
                                                confirmButtonText: 'Aceptar'
                                            });
                                        } else {
                                            totalInput.val(total.toFixed(2));
                                            descuentoInput.attr('disabled', false);
                                        }
                                    }
                                });

                                // Evento para cuando cambia el descuento
                                $('#modalCreateCompra #newLinesContainer').on('change', `#descuento${globalLineas}`, function () {
                                    const descuento = parseFloat($(this).val());
                                    const totalCompra = parseFloat($('#modalCreateCompra #totalFactura').val());
                                    const form = $(this).closest('form');
                                    const cantidad = parseFloat(form.find('.cantidad').val());
                                    const precioSinIva = parseFloat(form.find('.precioSinIva').val());
                                    const totalInput = form.find('.total');

                                    if (descuento < 0) {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'El descuento es requerido',
                                            icon: 'error',
                                            confirmButtonText: 'Aceptar'
                                        });
                                    } else {

                                        // verificar si tiene RAEE
                                        let rae = parseFloat(form.find('.rae').val());
                                        let totalRAE = rae * cantidad;

                                        const descuentoPorcentaje = (descuento * (precioSinIva * cantidad)) / 100;
                                        let total = (cantidad * precioSinIva) - descuentoPorcentaje;

                                        // Sumar el total RAEE al total de la compra (sin o con descuento)
                                        total = total + totalRAE;
                                        
                                        totalInput.val(total.toFixed(2));
                                    }
                                });

                                // Evento para cuando cambia el RAEE
                                $('#modalCreateCompra #newLinesContainer').on('change', `#RAE${globalLineas}`, function () {
                                    const rae = parseFloat($(this).val());
                                    const form = $(this).closest('form');
                                    const cantidad = parseFloat(form.find('.cantidad').val());
                                    const precioSinIva = parseFloat(form.find('.precioSinIva').val());
                                    const totalInput = form.find('.total');
                                    const descuentoInput = form.find('.descuento');
                                    const descuento = parseFloat(descuentoInput.val());

                                    // Calcular el total RAEE
                                    let totalRAE = rae * cantidad;
                                    totalRAE = Math.round(totalRAE * 100) / 100; // Redondear a 2 decimales

                                    let totalCompra = cantidad * precioSinIva; // Total sin aplicar descuento

                                    // Sumar el total RAEE al total de la compra (sin o con descuento)
                                    const totalFinal = totalCompra + totalRAE; 
                                    totalInput.val(totalFinal.toFixed(2)); // Redondear a 2 decimales
                                });

                                // auto ajustar los textarea
                                $('#newLinesContainer').on('input', `#descripcion${globalLineas}`, function () {
                                    this.style.height = 'auto';
                                    this.style.height = (this.scrollHeight) + 'px';
                                });
                                
                                
                            });
                        }
                    },
                    error: function(error) {
                        closeLoader();
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al guardar la compra',
                            icon: 'error',
                            footer: error.message,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            });

            // Función para calcular la suma de los totales de las líneas existentes
            const calcularSumaTotalesLineas = () => {
                let sumaTotales = 0;
                $('#modalCreateCompra #elementsToShow tr').each(function() {
                    let total = parseFloat($(this).find('td:nth-last-child(2)').text());
                    if (!isNaN(total)) {
                        sumaTotales += total;
                    }
                });
                return sumaTotales;
            }

            // Delegar evento de guardado para las líneas dinámicas
            $('#modalCreateCompra #newLinesContainer').on('click', '.saveLinea', function () {
                const lineNumber = $(this).data('line');
                const form = $(`#modalCreateCompra #AddNewLineForm${lineNumber}`);
                const descripcion = form.find(`#descripcion${lineNumber}`).val();
                const cantidad = parseFloat(form.find(`#cantidad${lineNumber}`).val());
                const precioSIva = parseFloat(form.find(`#precioSinIva${lineNumber}`).val());
                const descuento = parseFloat(form.find(`#descuento${lineNumber}`).val());
                const total = parseFloat(form.find(`#total${lineNumber}`).val());
                const rae = parseFloat(form.find(`#RAE${lineNumber}`).val());
                const cod_prov = form.find(`#cod_prov${lineNumber}`).val();

                $('#modalCreateCompra #sumaTotalesLineas').data('value', calcularSumaTotalesLineas());

                let proveedor = {
                    idProveedor: form.find('#proveedor_id').val(),
                    nombreProveedor: form.find('#nameProovedorId').val(),
                    cifProveedor: form.find('#proveedor_cif').val()
                };

                let empresa = {
                    idEmpresa: form.find('#empresaId').val(),
                    EMP: form.find('#empresaNameId').val()
                };

                let archivos = {
                    idarchivos: form.find('#archivoId').val()
                };

                let compra = {
                    idCompra: form.find('#compra_id').val(),
                    totalFactura: parseFloat(form.find('#totalFactura').val()) // Asegurarse que se convierte a float
                };

                // Obtener la suma de las líneas existentes y agregar la nueva
                let sumaTotalesLineas = calcularSumaTotalesLineas() + total;

                // Validar si la suma total supera el total de la factura
                // if (sumaTotalesLineas > compra.totalFactura) {
                //     Swal.fire({
                //         title: 'Error',
                //         text: 'El total de las líneas no puede ser mayor al total de la factura',
                //         icon: 'error',
                //         confirmButtonText: 'Aceptar'
                //     });
                    
                //     return;
                // }

                // Validaciones de campos obligatorios
                if (proveedor.idProveedor === '' || proveedor.idProveedor === undefined || proveedor.idProveedor === null) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al guardar la línea, primero debe guardar la compra',
                        icon: 'error',
                        footer: 'No se han podido obtener los datos de la compra',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                // if (descripcion === '' || isNaN(cantidad) || isNaN(precioSIva) || isNaN(descuento) || isNaN(total)) {
                //     Swal.fire({
                //         title: 'Error',
                //         text: 'Todos los campos son requeridos y deben tener valores válidos',
                //         icon: 'error',
                //         confirmButtonText: 'Aceptar'
                //     });
                //     return;
                // }

                const table = $('#modalCreateCompra #tableToShowElements');
                const elements = $('#modalCreateCompra #elementsToShow');

                // Mostrar tabla de elementos
                table.show();

                $.ajax({
                    url: '<?php echo e(route("admin.lineas.store")); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        proveedor_id: proveedor.idProveedor,
                        descripcion,
                        cantidad,
                        precioSinIva: precioSIva,
                        descuento,
                        rae,
                        total,
                        cod_prov,
                        trazabilidad: `${empresa.EMP} - ${proveedor.cifProveedor} - ${archivos.idarchivos}`,
                        compra_id: compra.idCompra
                    },
                    beforeSend: function() {
                        openLoader();
                    },
                    success: function(response) {

                        const { linea } = response;

                        let newElement = `
                            <tr
                                id="linea-${linea.idLinea}"
                            >
                                <td>${linea.idLinea}</td>
                                <td style="font-weight: bold;">${linea.cod_proveedor}</td>
                                <td>${descripcion}</td>
                                <td>${cantidad}</td>
                                <td>${precioSIva}€</td>
                                <td>${rae}€</td>
                                <td>${descuento}%</td>
                                <td>${proveedor.nombreProveedor}</td>
                                <td>${formatTrazabilidad(linea.trazabilidad)}</td>
                                <td>${total}€</td>
                                <td>
                                    <?php $__env->startComponent('components.actions-button'); ?>
                                        <button 
                                            class="btn btn-outline-warning btn-sm editLinea" 
                                            data-id="${linea.idLinea}"
                                            data-lineainfo='${JSON.stringify(linea)}'
                                        >
                                            <ion-icon name="create-outline"></ion-icon>
                                        </button>
                                        <button 
                                            class="btn btn-outline-danger btn-sm deleteLinea" 
                                            data-id="${linea.idLinea}"
                                            data-lineainfo='${JSON.stringify(linea)}'
                                        >
                                            <ion-icon name="trash-outline"></ion-icon>
                                        </button>
                                    <?php echo $__env->renderComponent(); ?>    
                                </td>
                            </tr>
                        `;

                        elements.append(newElement);
                        closeLoader();
                        // Actualizar la suma total de las líneas
                        $('#modalCreateCompra #sumaTotalesLineas').data('value', sumaTotalesLineas);

                        // Actualizar valores de la compra
                        let nuevoImporte = parseFloat($('#modalCreateCompra #Importe').val()) + total;
                        $('#modalCreateCompra #Importe').val(nuevoImporte.toFixed(2));

                        calcularTotales( compra.idCompra ); // Recalcular los totales

                        Swal.fire({
                            title: 'Línea guardada',
                            text: 'La línea se ha guardado correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });

                        // Limpiar campos de la nueva línea y deshabilitarlos
                        form.find('textarea, input').val('').attr('disabled', true);

                        // Limpiar el contenedor de líneas nuevas
                        $('#modalCreateCompra #newLinesContainer').empty();

                        $('#modalCreateCompra #addNewLine').attr('disabled', false);
                    },
                    error: function(error) {
                        closeLoader();
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al guardar la línea',
                            icon: 'error',
                            footer: error.message,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            });

            // Mostrar modal para editar línea
            $('#modalCreateCompra #elementsToShow').on('click', '.editLinea', function () {
                let linea = $(this).data('lineainfo');
                let id = $(this).data('id');

                $('#modalEditLineaCreate #idLineaEdit').val(id);
                $('#modalEditLineaCreate #descripcionEdit').val(linea.descripcion);
                $('#modalEditLineaCreate #cantidadEdit').val(linea.cantidad);
                $('#modalEditLineaCreate #precioSinIvaEdit').val(linea.precioSinIva);
                $('#modalEditLineaCreate #descuentoEdit').val(linea.descuento);
                $('#modalEditLineaCreate #totalEdit').val(linea.total);
                $('#modalEditLineaCreate #raeEdit').val(linea.RAE);

                $('#modalEditLineaCreate').modal('show');

                // Delegar eventos para calcular el total de la línea
                $('#modalEditLineaCreate #cantidadEdit').change(function () {
                    let cantidad = parseFloat($(this).val());
                    let precioSinIva = parseFloat($('#modalEditLineaCreate #precioSinIvaEdit').val());
                    let descuento = parseFloat($('#modalEditLineaCreate #descuentoEdit').val());
                    let total = cantidad * precioSinIva;

                    $('#modalEditLineaCreate #totalEdit').val(total.toFixed(2));

                    if (cantidad === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'La cantidad es requerida',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    } else {
                        $('#modalEditLineaCreate #precioSinIvaEdit').attr('disabled', false);
                    }
                });

                $('#modalEditLineaCreate #precioSinIvaEdit').change(function () {
                    let precioSinIva = parseFloat($(this).val());
                    let cantidad = parseFloat($('#modalEditLineaCreate #cantidadEdit').val());
                    let descuento = parseFloat($('#modalEditLineaCreate #descuentoEdit').val());
                    let total = cantidad * precioSinIva;

                    $('#modalEditLineaCreate #totalEdit').val(total.toFixed(2));

                    if (precioSinIva === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'El precio sin IVA es requerido',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    } else {
                        $('#modalEditLineaCreate #descuentoEdit').attr('disabled', false);
                    }
                });

                $('#modalEditLineaCreate #descuentoEdit').change(function () {
                    let descuento = parseFloat($(this).val());
                    let precioSinIva = parseFloat($('#modalEditLineaCreate #precioSinIvaEdit').val());
                    let cantidad = parseFloat($('#modalEditLineaCreate #cantidadEdit').val());

                    // calcular el RAEE
                    let rae = parseFloat($('#modalEditLineaCreate #raeEdit').val());
                    let totalRAE = rae * cantidad;

                    let total = (cantidad * precioSinIva) - ((descuento * (cantidad * precioSinIva)) / 100);

                    // Sumar el total RAEE al total de la compra (sin o con descuento)
                    total = total + totalRAE;

                    $('#modalEditLineaCreate #totalEdit').val(total.toFixed(2));

                    if (descuento === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'El descuento es requerido',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    }
                });

                // Calculo del total de la línea en base al RAEE
                $('#modalEditLineaCreate #raeEdit').change(function () {
                    let rae = parseFloat($(this).val());
                    let precioSinIva = parseFloat($('#modalEditLineaCreate #precioSinIvaEdit').val());
                    let cantidad = parseFloat($('#modalEditLineaCreate #cantidadEdit').val());
                    let descuento = parseFloat($('#modalEditLineaCreate #descuentoEdit').val());
                    let total = (cantidad * precioSinIva) - ((descuento * (cantidad * precioSinIva)) / 100);

                    // Calcular el total RAEE
                    let totalRAE = rae * cantidad;
                    totalRAE = Math.round(totalRAE * 100) / 100; // Redondear a 2 decimales

                    // Sumar el total RAEE al total de la compra (sin o con descuento)
                    const totalFinal = total + totalRAE;

                    $('#modalEditLineaCreate #totalEdit').val(totalFinal.toFixed(2)); // Redondear a 2 decimales
                });

            });

            $('#modalCreateCompra #IvaCreateCompra').change(function () {
                let iva = parseFloat($(this).val());
                let importe = parseFloat($('#modalCreateCompra #Importe').val());
                let suplidos = parseFloat($('#modalCreateCompra #suplidosCompras').val());

                iva = iva / 100;

                let totalIva = (importe * iva).toFixed(2);
                let totalFactura = (importe + parseFloat(totalIva) + suplidos).toFixed(2);

                $('#modalCreateCompra #totalIvaCreateCompra').val(totalIva);
                $('#modalCreateCompra #totalFacturaCreateCompra').val(totalFactura);
            });

            $('#modalEditCompra #IvaEdit').change(function () {
                let iva = parseFloat($(this).val());
                let importe = parseFloat($('#modalEditCompra #ImporteEdit').val());
                let suplidos = parseFloat($('#modalEditCompra #suplidosComprasEdit').val());

                iva = iva / 100;

                let totalIva = (importe * iva).toFixed(2);
                let totalFactura = (importe + parseFloat(totalIva) + suplidos).toFixed(2);

                $('#modalEditCompra #totalIvaEdit').val(totalIva);
                $('#modalEditCompra #totalFacturaEdit').val(totalFactura);
            });

            // Guardar cambios en la línea
            $('#btnSaveEditLineaCreate').click(function () {
                openLoader();
                let id              = $('#modalEditLineaCreate #idLineaEdit').val();
                let descripcion     = $('#modalEditLineaCreate #descripcionEdit').val();
                let cantidad        = $('#modalEditLineaCreate #cantidadEdit').val();
                let precioSinIva    = $('#modalEditLineaCreate #precioSinIvaEdit').val();
                let descuento       = $('#modalEditLineaCreate #descuentoEdit').val();
                let total           = $('#modalEditLineaCreate #totalEdit').val();
                let rae             = $('#modalEditLineaCreate #raeEdit').val();

                $.ajax({
                    url: `<?php echo e(route('admin.lineas.update', ':id')); ?>`.replace(':id', id),
                    method: 'PUT',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        descripcion,
                        cantidad,
                        precioSinIva,
                        descuento,
                        total,
                        rae
                    },
                    success: function(response) {
                        const { linea: lineaResponse, proveedor: proveeedorResponse, compra } = response;
                        let test = $(`#linea-${lineaResponse.idLinea}`)
    
                        $(`#linea-${lineaResponse.idLinea}`).html(`
                            <td>${lineaResponse.idLinea}</td>
                            <td>No: ${compra.idCompra}</td>
                            <td>${lineaResponse.descripcion}</td>
                            <td>${lineaResponse.cantidad}</td>
                            <td>${lineaResponse.precioSinIva}€</td>
                            <td>${lineaResponse.RAE}€</td>
                            <td>${lineaResponse.descuento}%</td>
                            <td>${proveeedorResponse.nombreProveedor}</td>
                            <td>${lineaResponse.trazabilidad}</td>
                            <td>${lineaResponse.total}€</td>
                            <td>
                                <?php $__env->startComponent('components.actions-button'); ?>
                                    <button 
                                        class="btn btn-outline-warning btn-sm editLinea" 
                                        data-id="${lineaResponse.idLinea}"
                                        data-lineainfo='${JSON.stringify(lineaResponse)}'
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button 
                                        class="btn btn-outline-danger btn-sm deleteLinea" 
                                        data-id="${lineaResponse.idLinea}"
                                        data-lineainfo='${JSON.stringify(lineaResponse)}'
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php echo $__env->renderComponent(); ?>    
                            </td>
                        `);

                        // Recalcular los totales solo después de actualizar la línea
                        calcularTotales(compra.idCompra).then(() => {
                            // Cerrar loader y mostrar mensaje
                            closeLoader();
                            Swal.fire({
                                title: 'Línea actualizada',
                                text: 'La línea se ha actualizado correctamente',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            });
                        });

                        $('#modalEditLineaCreate').modal('hide');

                        // Actualizar la suma total de las líneas
                        $('#modalCreateCompra #elementsToShow #sumaTotalesLineas').data('value', calcularSumaTotalesLineas());

                        closeLoader();

                    },
                    error: function(error) {
                        closeLoader();
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al actualizar la línea',
                            icon: 'error',
                            footer: error.message,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            });

            // Eliminar línea
            $('#modalCreateCompra #elementsToShow').on('click', '.deleteLinea', function () {
                let id = $(this).data('id');
                let linea = $(this).data('lineainfo');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'La línea se eliminará de forma permanente',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `<?php echo e(route('admin.lineas.destroy', ':id')); ?>`.replace(':id', id),
                            method: 'DELETE',
                            data: {
                                _token: '<?php echo e(csrf_token()); ?>'
                            },
                            success: function(response) {
                                $(`#linea-${id}`).remove();

                                // Actualizar la suma total de las líneas
                                $('#sumaTotalesLineas').data('value', calcularSumaTotalesLineas());

                                // Actualizar valores de la compra
                                let nuevoImporte = parseFloat($('#Importe').val()) - parseFloat(linea.total);
                                $('#Importe').val(nuevoImporte.toFixed(2));

                                calcularTotales(); // Recalcular los totales

                                Swal.fire({
                                    title: 'Línea eliminada',
                                    text: 'La línea se ha eliminado correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                });
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Ha ocurrido un error al eliminar la línea',
                                    icon: 'error',
                                    footer: error.message,
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        });
                    }
                });
            });

            // Mostrar modal para ver detalles de compra
            table.on('click', '.modalDetailsCompras', function () {

                $('#modalDetailsCompra input').attr('readonly', true);
                $('#modalDetailsCompra select').attr('disabled', true);
                $('#modalDetailsCompra textarea').attr('readonly', true);

                let compraId    = $(this).data('id');
                let fecha       = $(this).data('fecha');
                let nFactura    = $(this).data('nfactura');
                let proveedor   = $(this).data('proveedor');
                let formaPago   = $(this).data('formapago');
                let importe     = $(this).data('importe');
                let iva         = $(this).data('iva');
                let totalIva    = $(this).data('totaliva');
                let retenciones = $(this).data('retenciones');
                let empresa     = $(this).data('empresa');
                let lineas      = $(this).data('lineas');
                let archivo     = $(this).data('archivo')[0];

                const previewOfPdfContainer = $('#previewOfPdf');
                previewOfPdfContainer.empty();

                let totalRetenciones    = $(this).data('totalretenciones');
                let total               = $(this).data('total');
                let suplidos            = $(this).data('suplidos');
                let nAsiento            = $(this).data('nasiento');
                let observaciones       = $(this).data('observaciones');
                let plazos              = $(this).data('plazos');

                let fechaFormateada = new Date(fecha).toISOString().split('T')[0];

                // Mostrar modal de detalles
                $('#modalDetailsCompra').modal('show');
                // $('#DetailsCompraTitle').text('Detalles de la compra');
                $('#modalDetailsCompra #DetailsCompraTitle').text(`Detalles de la compra No: ${compraId}`);

                // Rellenar campos del formulario de detalles
                $('#fechaCompraDetails').val(fechaFormateada);
                $('#NFacturaCompraDetails').val(nFactura);
                $('#empresa_idDetails').val(empresa);
                $('#proveedor_idDetails').val(proveedor);
                $('#formaPagoDetails').val(formaPago);
                $('#ImporteDetails').val(importe);
                $('#IvaCreateCompraDetails').val(iva);
                $('#totalIvaCreateCompraDetails').val(totalIva);
                $('#totalFacturaCreateCompraDetails').val(total);
                $('#suplidosComprasDetails').val(suplidos);
                $('#NAsientoContableDetails').val(nAsiento);
                $('#ObservacionesComprasDetails').val(observaciones);
                $('#PlazosDetails').val(plazos);

                // Mostrar tabla de elementos
                $('#tableToShowElements').show();

                // agregar lineas a la tabla
                let elements = $('#elementsToShowDetails');
                elements.empty();

                lineas.forEach(linea => {
                    let newElement = `
                        <tr>
                            <td>${linea.idLinea}</td>
                            <td>${compraId}</td>
                            <td
                                class="showHistorialArticulo"
                                data-id="${linea.articulo_id}"
                                data-nameart="${linea.descripcion}"
                                data-trazabilidad="${linea.trazabilidad}"
                                style="cursor: pointer; text-decoration: underline"
                            >${linea.descripcion}</td>
                            <td>${linea.cantidad}</td>
                            <td>${linea.precioSinIva}</td>
                            <td>${linea.descuento}</td>
                            <td>${proveedor}</td>
                            <td>${formatTrazabilidad(linea.trazabilidad)}</td>
                            <td>${linea.total}€</td>
                            <td>
                                <?php $__env->startComponent('components.actions-button', [
                                    'disabled' => true
                                ]); ?>
                                    <button 
                                        class="btn btn-outline-warning btn-sm editLinea" 
                                        data-id="${linea.idLinea}"
                                        data-lineainfo='${JSON.stringify(linea)}'
                                        disabled
                                    >
                                        <ion-icon name="create-outline"></ion-icon>
                                    </button>
                                    <button 
                                        class="btn btn-outline-danger btn-sm deleteLinea" 
                                        data-id="${linea.idLinea}"
                                        data-lineainfo='${JSON.stringify(linea)}'
                                        disabled
                                    >
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>
                                <?php echo $__env->renderComponent(); ?>    
                            </td>
                        </tr>
                    `;
                    elements.append(newElement);
                });

                // Mostrar vista previa del PDF
                if (archivo) {
                    let archivoUrl = archivo.pathFile; // /home/u657674604/domains/sebcompanyes.com/public_html/archivos/citas/2023TA683-002.FOTO1.212918.jpg

                    // obtener archivos/citas/2023TA683-002.FOTO1.212918.jpg
                    let archivoArray = archivoUrl.split('/');

                    // obtener el nombre del archivo
                    let archivoName = archivoArray[archivoArray.length - 1];

                    // obtener la ruta del archivo
                    let archivoPath = archivoArray[archivoArray.length - 2];

                    // obtener la ruta completa del archivo
                    let archivoFinal = archivoPath + '/' + archivoName;
                    

                    let pdfViewer = `
                        <embed src="<?php echo e(asset("archivos/compras/")); ?>/${ archivoFinal }" type="application/pdf" width="100%" height="600px">
                    `;
                    previewOfPdfContainer.html(pdfViewer);
                }

                // dejar de escuchar el evento de doble click de la tabla de elementos
                $('#elementsToShowDetails').off('dblclick', '.showHistorialArticulo');

                $('#elementsToShowDetails').on('dblclick', '.showHistorialArticulo', function(event){
                    openLoader();
                    const id = $(this).data('id');
                    const name = $(this).data('nameart');
                    const trazabilidad = $(this).data('trazabilidad');

                    getHistorial(id, name, trazabilidad);
                });


            });

            
            const calcularTotalesEdit = ( id ) => {
                let importe  = parseFloat($('#modalEditCompra #ImporteEdit').val()) || 0;
                let suplidos = parseFloat($('#modalEditCompra #suplidosComprasEdit').val()) || 0;
                let iva      = parseFloat($('#modalEditCompra #IvaEdit').val()) || 21;

                iva = iva / 100;

                let totalIva = (importe * iva).toFixed(2);
                let totalFactura = (importe + parseFloat(totalIva) + suplidos).toFixed(2);

                // sumar los totales de las lineas
                let sumaTotalesLineas = calcularSumaTotalesLineasEdit();
                
                // calcular el total del iva en base a las lineas
                let totalIvaLineas = (sumaTotalesLineas * iva).toFixed(2);

                // calcular el total de la factura en base a las lineas
                let totalFacturaLineas = (sumaTotalesLineas + parseFloat(totalIvaLineas) + suplidos).toFixed(2);

                console.log({sumaTotalesLineas, totalIvaLineas, totalFacturaLineas});

                $('#modalEditCompra #totalIvaCreateCompraEdit').val(totalIva);
                $('#modalEditCompra #totalFacturaEdit').val(totalFactura);

                const toSendBackend = sumaTotalesLineas.toFixed(2);
                if ( id ) {
                    $.ajax({
                        url: `<?php echo e(route('admin.compras.updatesum', ':id')); ?>`.replace(':id', id),
                        method: 'POST',
                        data:{
                            _token: '<?php echo e(csrf_token()); ?>',
                            importe: toSendBackend,
                            suplidos: suplidos,
                            totalIva: totalIvaLineas,
                            totalFactura: totalFacturaLineas
                        },
                        beforeSend: function() {
                            openLoader();
                        },
                        success: function(response) {
                            // console.log(response);
                            closeLoader();

                            $('#modalEditCompra #ImporteEdit').val(toSendBackend)
                            $('#modalEditCompra #totalIvaCreateCompraEdit').val(totalIvaLineas);
                            $('#modalEditCompra #totalFacturaEdit').val(totalFacturaLineas);

                        },
                        error: function(error) {
                            closeLoader();
                            console.log(error);
                        }
                    });
                }

            };

            const calcularSumaTotalesLineasEdit = () => {
                let sumaTotales = 0;
                $('#modalEditCompra #elementsToShowEdit tr').each(function() {
                    // Seleccionamos la penúltima columna, que es la que contiene el total que necesitas sumar
                    let total = parseFloat($(this).find('td:nth-last-child(3)').text());
                    if (!isNaN(total)) {
                        sumaTotales += total;
                    }
                });
                return sumaTotales;
            };

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
                        url: "<?php echo e(route('admin.partes.updatesum')); ?>",
                        method: 'POST',
                        data: {
                            parteTrabajoId: parteTrabajoId,
                            suma: totalSum,
                            _token: "<?php echo e(csrf_token()); ?>"
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
                        $('#editParteTrabajoModal #precio_hora').val(total.toFixed(2));
                    }else{
                        const totalDescuento = total - (total * (descuentoCliente / 100));
                        $('#editParteTrabajoModal #precio_hora').val(totalDescuento.toFixed(2));
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

            // Editar compra - Mostrar modal con datos de compra
            table.on('click', '.modalEditCompras', function (e) {
                e.preventDefault();
                let compraId = $(this).data('id');
                getInfoCompra(compraId, $(this));
            });

            table.on('dblclick', '.openEditCompraFast', function (e) {
                e.preventDefault();
                let compraId = $(this).data('parteid');
                getInfoCompra(compraId, $(this));
            });

            // Editar la línea de compra
            $('#elementsToShowEdit').on('click', '.editLineaCompra', function(event) {
                event.preventDefault();
                let lineaId = $(this).data('id');
                let lineaInfo = JSON.parse(JSON.stringify($(this).data('lineainfo')));

                // Mostrar modal de edición de línea
                $('#modalEditLinea').modal('show');
                $('#editLineaTitle').text('Editar línea de compra');

                // Rellenar campos del formulario de edición de línea
                $('#modalEditLinea #idLineaEdit').val(lineaId);
                $('#modalEditLinea #descripcionEdit').val(lineaInfo.descripcion);
                $('#modalEditLinea #cantidadEdit').val(lineaInfo.cantidad);
                $('#modalEditLinea #precioSinIvaEdit').val(lineaInfo.precioSinIva);
                $('#modalEditLinea #descuentoEdit').val(lineaInfo.descuento);
                $('#modalEditLinea #totalEdit').val(lineaInfo.total);
                $('#modalEditLinea #raeEdit').val(lineaInfo.RAE);
                $('#modalEditLinea #cod_provEdit').val(lineaInfo.cod_proveedor);

                // evento para cod_prov${globalLineas} y si existe en la base de datos, traer la descripcion y el precio sin iva
                $(`#cod_provEdit`).off('change').on('change', function() {
                    let cod_prov = $(this).val();
                    let form = $(this).closest('form');
                    let descripcion = form.find(`#descripcionEdit`);
                    let precioSinIva = form.find(`#precioSinIvaEdit`);

                    $.ajax({
                        url: `<?php echo e(route('admin.compras.getArticuloByCodigo')); ?>`,
                        method: 'GET',
                        data: {
                            cod_prov: cod_prov
                        },
                        beforeSend: function(){
                            openLoader();
                        },
                        success: function(response) {
                            closeLoader();
                            descripcion.val(response.articulo.descripcion);
                            precioSinIva.val(response.articulo.precioSinIva);
                            precioSinIva.attr('disabled', false);

                            // auto ajustar el textarea de la descripcion
                            descripcion.css('height', 'auto');
                            descripcion.css('height', descripcion[0].scrollHeight + 'px');

                            // calcular el total de la linea
                            let cantidad = parseFloat(form.find(`#cantidadEdit`).val());
                            let precio = parseFloat(form.find(`#precioSinIvaEdit`).val());
                            let descuento = parseFloat(form.find(`#descuentoEdit`).val());
                            let rae = parseFloat(form.find(`#raeEdit`).val());

                            let total = cantidad * precio;

                            if ( descuento > 0 ) {
                                const descuentoPorcentaje = (descuento * (precio * cantidad)) / 100;
                                total = (cantidad * precio) - descuentoPorcentaje;
                            }

                            if ( rae > 0 ) {
                                total = total + rae;
                            }

                            form.find(`#totalEdit`).val(total.toFixed(2));
                            
                        },
                        error: function(error) {
                            closeLoader();
                            console.log(error);
                        }
                    });
                });

                // Validación de campos
                $('#modalEditLinea #cantidadEdit').change(function() {
                    let cantidad = parseFloat($(this).val());
                    if (cantidad === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'La cantidad es requerida',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    }else if( cantidad < 0 ){
                        Swal.fire({
                            title: 'Error',
                            text: 'La cantidad no puede ser menor a 0',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        $('#modalEditLinea #cantidadEdit').val(1);
                        return;
                    }

                    let precioSinIva = parseFloat($('#modalEditLinea #precioSinIvaEdit').val());

                    // validar si la cantidad es un decimal
                    if ( cantidad % 1 !== 0 && !isNaN(precioSinIva) ) {
                        // tenemos que hacer el calculo agregando un 0 al precio sin iva para obtener el total de los articulos y cambiar la cantidad a entero
                        // agregar un 0 al precio sin iva
                        let valor = '';
                        let valorArray = '';
                        let valorEntero = '';
                        let valorDecimal = '';
                        let valorFinal = '';
                        let precioSinIvaFinal = '';

                        let cantidadString = cantidad.toString();
                        let cantidadArray = cantidadString.split('.');
                        let cantidadEntero = cantidadArray[0];
                        let cantidadDecimal = cantidadArray[1];

                        if ( cantidadDecimal.startsWith('0') ) {
                            // agregar un 0 al precio sin iva
                            valor = precioSinIva.toString();
                            valorArray = valor.split('.');
                            valorEntero = valorArray[0];
                            valorDecimal = valorArray[1];
                            valorFinal = '0.'+'0'+valorEntero+valorDecimal;
                            precioSinIvaFinal = parseFloat(valorFinal);
                        }else{
                            // agregar un 0 al precio sin iva
                            valor = precioSinIva.toString();
                            valorArray = valor.split('.');
                            valorEntero = valorArray[0];
                            valorDecimal = valorArray[1];
                            valorFinal = '0.'+valorEntero+valorDecimal;
                            precioSinIvaFinal = parseFloat(valorFinal);
                        }

                        
                        if (precioSinIva !== 0) {
                            $('#modalEditLinea #precioSinIvaEdit').val(precioSinIvaFinal);
                            const total = cantidad * precioSinIvaFinal;

                            cantidad = cantidad * 100;
                            $(this).val(cantidad);
                            $('#modalEditLinea #totalEdit').val(total.toFixed(2));
                            const descuentoInput = $(this).closest('form').find('.descuento');
                            descuentoInput.attr('disabled', false);
                            
                        }
                    }

                    let resultado = cantidad * precioSinIva;

                    // validar si el descuento es mayor a 0
                    const descuento = parseFloat($('#modalEditLinea #descuentoEdit').val());

                    if ( descuento > 0 ) {
                        const descuentoPorcentaje = (descuento * (precioSinIva * cantidad)) / 100;
                        resultado = (cantidad * precioSinIva) - descuentoPorcentaje;
                    }

                    $('#modalEditLinea #totalEdit').val(resultado.toFixed(2));                    

                });

                $('#modalEditLinea #precioSinIvaEdit').change(function() {
                    let precioSinIva = parseFloat($(this).val());
                    if (precioSinIva === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'El precio sin IVA es requerido',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    }

                    let cantidad = parseFloat($('#modalEditLinea #cantidadEdit').val());

                    // verificar si la cantidad es un decimal
                    if ( cantidad % 1 !== 0 ) {
                        // tenemos que hacer el calculo agregando un 0 al precio sin iva para obtener el total de los articulos y cambiar la cantidad a entero

                        // Verificar si la cantidad es tipo 0.06 0.06 porque al precio sin iva se le agrega un 0 mas

                        let valor = '';
                        let valorArray = '';
                        let valorEntero = '';
                        let valorDecimal = '';
                        let valorFinal = '';
                        let precioSinIvaFinal = '';
                        
                        let cantidadString = cantidad.toString();
                        let cantidadArray = cantidadString.split('.');
                        let cantidadEntero = cantidadArray[0];
                        let cantidadDecimal = cantidadArray[1];

                        if ( cantidadDecimal.startsWith('0') ) {
                            // agregar un 0 al precio sin iva
                            valor = precioSinIva.toString();
                            valorArray = valor.split('.');
                            valorEntero = valorArray[0];
                            valorDecimal = valorArray[1];
                            valorFinal = '0.'+'0'+valorEntero+valorDecimal;
                            precioSinIvaFinal = parseFloat(valorFinal);
                        }else{
                            // agregar un 0 al precio sin iva
                            valor = precioSinIva.toString();
                            valorArray = valor.split('.');
                            valorEntero = valorArray[0];
                            valorDecimal = valorArray[1];
                            valorFinal = '0.'+valorEntero+valorDecimal;
                            precioSinIvaFinal = parseFloat(valorFinal);
                        }

                        precioSinIva = precioSinIvaFinal;
                        $('#modalEditLinea').find('#precioSinIvaEdit').val(precioSinIva);

                        // cambiar la cantidad a entero es decir 0.39 se conviernte en 39
                        cantidad = cantidad * 100;
                        $('#modalEditLinea').find('#cantidadEdit').val(cantidad);
                    }

                    let resultado = cantidad * precioSinIva;

                    // validar si el descuento es mayor a 0
                    const descuento = parseFloat($('#modalEditLinea #descuentoEdit').val());

                    if ( descuento > 0 ) {
                        const descuentoPorcentaje = (descuento * (precioSinIva * cantidad)) / 100;
                        resultado = (cantidad * precioSinIva) - descuentoPorcentaje;
                    }

                    // validar si el total es menor a 0
                    if (resultado < 0) {
                        Swal.fire({
                            title: 'Error',
                            text: 'El total no puede ser menor a 0',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    }

                    $('#modalEditLinea #totalEdit').val(resultado.toFixed(2));
                });

                $('#modalEditLinea #descuentoEdit').change(function() {
                    let descuento = parseFloat($(this).val());
                    if (descuento === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'El descuento es requerido',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    }

                    let cantidad = parseFloat($('#modalEditLinea #cantidadEdit').val());
                    let precioSinIva = parseFloat($('#modalEditLinea #precioSinIvaEdit').val());
                    // calcular descuento en porcentaje 10% / 20% / 30% etc
                    const descuentoPorcentaje = (descuento * (precioSinIva * cantidad)) / 100;
                    let resultado = (cantidad * precioSinIva) - descuentoPorcentaje;

                    // añadir el total de RAEE
                    let rae = parseFloat($('#modalEditLinea #raeEdit').val());
                    let totalRAE = rae * cantidad;

                    // sumar el total RAEE al total de la compra (sin o con descuento)
                    const totalFinal = resultado + totalRAE;

                    // validar si el total es menor a 0
                    if (resultado < 0) {
                        Swal.fire({
                            title: 'Error',
                            text: 'El total no puede ser menor a 0',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    }
  
                    $('#modalEditLinea #totalEdit').val(resultado.toFixed(2));
                });

                $('#modalEditLinea #totalEdit').change(function() {
                    let total = $(this).val();
                    if (total === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'El total es requerido',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    }
                });

                // Validación de RAEE
                $('#modalEditLinea #raeEdit').change(function() {
                    let rae = parseFloat($(this).val());
                    if (rae === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'El RAEE es requerido',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    }

                    let precioSinIva = parseFloat($('#modalEditLinea #precioSinIvaEdit').val());
                    let cantidad = parseFloat($('#modalEditLinea #cantidadEdit').val());
                    let descuento = parseFloat($('#modalEditLinea #descuentoEdit').val());

                    let total = (cantidad * precioSinIva) - ((descuento * (cantidad * precioSinIva)) / 100);

                    // Calcular el total RAEE
                    let totalRAE = rae * cantidad;
                    totalRAE = Math.round(totalRAE * 100) / 100; // Redondear a 2 decimales

                    // Sumar el total RAEE al total de la compra (sin o con descuento)
                    const totalFinal = total + totalRAE;

                    $('#modalEditLinea #totalEdit').val(totalFinal.toFixed(2)); // Redondear a 2 decimales
                });
                
            });

            // Actualizar línea de compra
            $('#modalEditLinea #btnSaveEditLinea').click(function() {
                let formData = $('#formEditLinea').serialize();

                // verificar que los campos no estén vacíos
                let cantidad = $('#modalEditLinea #cantidadEdit').val();
                let precioSinIva = $('#modalEditLinea #precioSinIvaEdit').val();
                let descuento = $('#modalEditLinea #descuentoEdit').val();
                let total = $('#modalEditLinea #totalEdit').val();
                let rae = $('#modalEditLinea #raeEdit').val();
                let cod_prov = $('#modalEditLinea #cod_provEdit').val();

                if (cantidad === '' || precioSinIva === '' || descuento === '' || total === '') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Todos los campos son requeridos',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                const lineaId = $('#modalEditLinea #idLineaEdit').val();

                $.ajax({
                    url: `<?php echo e(route('admin.lineas.update', ':id')); ?>`.replace(':id', lineaId),
                    method: 'POST',
                    data: formData,
                    success: function(response) {

                        const { linea: lineaResponse, proveedor: proveeedorResponse } = response;
                        // Actualizar la fila de la tabla con los nuevos datos
                        $(`#linea${lineaResponse.idLinea}`).html(`
                            <td>${lineaResponse.idLinea}</td>
                            <td style="font-weight: bold;">${lineaResponse.cod_proveedor}/td>
                            <td>${lineaResponse.descripcion}</td>
                            <td>${lineaResponse.cantidad}</td>
                            <td>${lineaResponse.precioSinIva}€</td>
                            <td>${lineaResponse.RAE}€</td>
                            <td>${lineaResponse.descuento}%</td>
                            <td>${proveeedorResponse.nombreProveedor}</td>
                            <td
                                class="openHistorialArticulo"
                                data-id="${lineaResponse.articulo_id}"
                                data-nameart="${lineaResponse.descripcion}"
                                data-trazabilidad="${lineaResponse.trazabilidad}"
                            >${formatTrazabilidad(lineaResponse.trazabilidad)}</td>
                            <td>${lineaResponse.total}€</td>
                            <td>
                                <?php $__env->startComponent('components.actions-button'); ?>
                                    <button 
                                        class="btn btn-primary editLineaCompra" 
                                        data-id="${lineaId}" 
                                        data-lineainfo='${JSON.stringify(lineaResponse)}'
                                    >
                                        <ion-icon name="create-outline"></ion-icon>
                                    </button>
                                    <button 
                                        class="btn btn-danger deleteLineaCompra" 
                                        data-id="${lineaId}" 
                                        data-lineainfo='${JSON.stringify(lineaResponse)}'
                                    >
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>"
                                <?php echo $__env->renderComponent(); ?>
                            </td>
                        `);
                        $('#modalEditLinea').modal('hide');

                        // Actualizar la suma total de las líneas
                        $('#elementsToShowEdit #sumaTotalesLineas').data('value', calcularSumaTotalesLineasEdit());

                        // Actualizar valores de la compra
                        let nuevoImporte = parseFloat($('#modalEditCompra #ImporteEdit').val()) + parseFloat(total);
                        $('#modalEditCompra #ImporteEdit').val(nuevoImporte.toFixed(2));

                        calcularTotalesEdit( lineaResponse.compra_id ); // Recalcular los totales

                        Swal.fire({
                            title: 'Línea actualizada',
                            text: 'La línea se ha actualizado correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                        
                    },
                    error: function(error) {
                        console.error('Error al actualizar la línea:', error);
                    }
                });
            });
            
            // Eliminar línea de compra
            $('#elementsToShowEdit').on('click', '.deleteLineaCompra', function(event) {
                event.preventDefault();
                let lineaId = $(this).data('id');
                let lineaInfo = JSON.parse(JSON.stringify($(this).data('lineainfo')));

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `<?php echo e(route('admin.lineas.destroy', ':id')); ?>`.replace(':id', lineaId),
                            method: 'DELETE',
                            data: {
                                _token: '<?php echo e(csrf_token()); ?>'
                            },
                            success: function(response) {
                                // Eliminar la fila de la tabla
                                $(`#linea${lineaId}`).remove();

                                // Actualizar la suma total de las líneas
                                $('#elementsToShowEdit #sumaTotalesLineas').data('value', calcularSumaTotalesLineasEdit());

                                // Actualizar valores de la compra
                                let nuevoImporte = parseFloat($('#modalEditCompra #ImporteEdit').val()) - parseFloat(lineaInfo.total);
                                $('#modalEditCompra #ImporteEdit').val(nuevoImporte.toFixed(2));

                                calcularTotalesEdit( lineaInfo.compra_id ); // Recalcular los totales

                                Swal.fire({
                                    title: 'Línea eliminada',
                                    text: 'La línea se ha eliminado correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                });
                            },
                            error: function(error) {
                                console.error('Error al eliminar la línea:', error);
                            }
                        });
                    }
                });
            });

            // Añanañir nueva línea a la compra
            $('#modalEditCompra #addNewLineEdit').click(function() {
                let globalLineas = $('#elementsToShowEdit tr').length + 1;
                let newLine = `
                    <form id="AddNewLineFormEdit" class="mt-2 mb-2">
                        <small class="text-muted mb-2">Si ingresas una cantidad ( de articulos ) en decimales, se hará un calculo automatico, para colocar la cantidad en un número entero.</small>

                        <div>
                            <input type="hidden" id="compra_id" name="compra_id" value="${$('#modalEditCompra #idCompraEdit').val()}">
                            <input type="hidden" id="empresaId" name="empresa_id" value="${$('#modalEditCompra #empresa_idEdit').val()}">
                            <input type="hidden" id="empresaNameId" name="empresa_name" value="${$('#modalEditCompra #empresa_idEdit option:selected').text()}">
                            <input type="hidden" id="proveedor_id" name="proveedor_id" value="${$('#modalEditCompra #proveedor_idEdit').val()}">
                            <input type="hidden" id="proveedor_cif" name="proveedor_cif" value="${$('#modalEditCompra #proveedor_idEdit option:selected').data('cif')}">
                            <input type="hidden" id="nameProovedorId" name="proovedorName" value="${$('#modalEditCompra #proveedor_idEdit option:selected').text()}">
                            <input type="hidden" id="archivoId" name="archivo_id" value="${$('#modalEditCompra #archivo_idEdit').val()}">
                            <input type="hidden" id="totalFactura" name="totalFactura" value="${$('#modalEditCompra #totalFacturaEdit').val()}">
                            <input type="hidden" id="sumaTotalesLineas" data-value="0">
                            
                            <div class="form-row">

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input rows="3" class="form-control" placeholder="cod_prov" id="cod_provEdit">
                                        <label for="cod_provEdit">Código proveedor</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <textarea rows="3" class="form-control" placeholder="descripcion" id="descripcionEdit"></textarea>
                                        <label for="descripcionEdit">Descripcion</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cantidadEdit">Cantidad</label>
                                        <input type="number" class="form-control cantidad" id="cantidadEdit" name="cantidad" step="0.01" required>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="precioSinIvaEdit">Precio sin iva</label>
                                        <input type="number" class="form-control precioSinIva" id="precioSinIvaEdit" name="precioSIva" step="0.01" required disabled>    
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                               
                                <div class="form-group col-md-4">
                                    <label for="raeEdit">RAEE</label>
                                    <input type="number" value="0" class="form-control rae" id="raeEdit" name="rae">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="descuentoEdit">Descuento</label>
                                    <input type="number" value="0" class="form-control descuento" id="descuentoEdit" name="descuento" required disabled>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="totalEdit">Total</label>
                                    <input type="number" class="form-control total" id="totalEdit" name="total" required disabled>
                                </div>

                            </div>

                        </div>
                        <button type="button" class="btn btn-outline-warning saveLineaEdit" data-line="${globalLineas}">
                            <ion-icon name="save-outline"></ion-icon>
                            Guardar Linea
                        </button>
                    </form>
                `;
                
                $('#newLinesContainerEdit').append(newLine);

                // evento para cod_prov${globalLineas} y si existe en la base de datos, traer la descripcion y el precio sin iva
                $(`#cod_provEdit`).off('change').on('change', function() {
                    let cod_prov = $(this).val();
                    let form = $(this).closest('form');
                    let descripcion = form.find(`#descripcionEdit`);
                    let precioSinIva = form.find(`#precioSinIvaEdit`);

                    $.ajax({
                        url: `<?php echo e(route('admin.compras.getArticuloByCodigo')); ?>`,
                        method: 'GET',
                        data: {
                            cod_prov: cod_prov
                        },
                        beforeSend: function(){
                            openLoader();
                        },
                        success: function(response) {
                            closeLoader();
                            descripcion.val(response.articulo.descripcion);
                            precioSinIva.val(response.articulo.precioSinIva);
                            precioSinIva.attr('disabled', false);

                            // auto ajustar el textarea de la descripcion
                            descripcion.css('height', 'auto');
                            descripcion.css('height', descripcion[0].scrollHeight + 'px');

                        },
                        error: function(error) {
                            closeLoader();
                            console.log(error);
                        }
                    });
                });

                // Delegar eventos en el contenedor para manejar los cambios de los campos dinámicos
                $('#newLinesContainerEdit').on('change', `#cantidadEdit`, function () {
                    let cantidad = $(this).val();
                    let precioSinIvaInput = $(this).closest('form').find('.precioSinIva');
                    let totalCompra = parseFloat($('#modalEditCompra #totalFacturaEdit').val());
                    let totalInput = $(this).closest('form').find('.total');

                    // validar si precio sin iva es diferente de 0
                    let precioSinIva = parseFloat(precioSinIvaInput.val());

                    // validar si la cantidad es un decimal
                    if ( cantidad % 1 !== 0 && !isNaN(precioSinIva) ) {
                        // tenemos que hacer el calculo agregando un 0 al precio sin iva para obtener el total de los articulos y cambiar la cantidad a entero
                        // agregar un 0 al precio sin iva
                        let valor = '';
                        let valorArray = '';
                        let valorEntero = '';
                        let valorDecimal = '';
                        let valorFinal = '';
                        let precioSinIvaFinal = '';

                        let cantidadString = cantidad.toString();
                        let cantidadArray = cantidadString.split('.');
                        let cantidadEntero = cantidadArray[0];
                        let cantidadDecimal = cantidadArray[1];

                        if ( cantidadDecimal.startsWith('0') ) {
                            // agregar un 0 al precio sin iva
                            valor = precioSinIva.toString();
                            valorArray = valor.split('.');
                            valorEntero = valorArray[0];
                            valorDecimal = valorArray[1];
                            valorFinal = '0.'+'0'+valorEntero+valorDecimal;
                            precioSinIvaFinal = parseFloat(valorFinal);
                        }else{
                            // agregar un 0 al precio sin iva
                            valor = precioSinIva.toString();
                            valorArray = valor.split('.');
                            valorEntero = valorArray[0];
                            valorDecimal = valorArray[1];
                            valorFinal = '0.'+valorEntero+valorDecimal;
                            precioSinIvaFinal = parseFloat(valorFinal);
                        }

                        
                        if (precioSinIva !== 0) {
                            precioSinIvaInput.val(precioSinIvaFinal);
                            const total = cantidad * precioSinIvaFinal;

                            cantidad = cantidad * 100;
                            $(this).val(cantidad);
                            totalInput.val(total.toFixed(2));
                            const descuentoInput = $(this).closest('form').find('.descuento');
                            descuentoInput.attr('disabled', false);
                            
                        }
                    }

                    if( precioSinIva !== 0 && cantidad % 1 === 0 ){
                        const total = cantidad * precioSinIva;
                        const descuentoInput = $(this).closest('form').find('.descuento');

                        totalInput.val(total.toFixed(2));
                        descuentoInput.attr('disabled', false);
                    }

                    // validar si el descuento es diferente de 0
                    const descuento = parseFloat($(this).closest('form').find('.descuento').val());

                    if ( descuento !== 0 ) {
                        const descuentoPorcentaje = (descuento * (precioSinIva * cantidad)) / 100;
                        const resultado = (cantidad * precioSinIva) - descuentoPorcentaje;
                        const total = resultado.toFixed(2);

                        if (total < 0 ) {
                            Swal.fire({
                                title: 'Error',
                                text: 'El total no puede ser menor a 0',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        } else {
                            totalInput.val(total);
                        }
                    }

                    if (cantidad === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'La cantidad es requerida',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    } else {
                        precioSinIvaInput.attr('disabled', false);
                    }
                });

                $('#newLinesContainerEdit').on('change', `#precioSinIvaEdit`, function () {
                    let precioSinIva = parseFloat($(this).val());
                    let totalCompra = parseFloat($('#modalEditCompra #totalFacturaEdit').val());
                    let form = $(this).closest('form');
                    let cantidad = parseFloat(form.find('.cantidad').val());
                    let totalInput = form.find('.total');
                    let descuentoInput = form.find('.descuento');

                    // si el valor del descuento es diferente de 0, calcular el total

                    // verificar si la cantidad es un decimal
                    if ( cantidad % 1 !== 0 ) {
                        // tenemos que hacer el calculo agregando un 0 al precio sin iva para obtener el total de los articulos y cambiar la cantidad a entero

                        // Verificar si la cantidad es tipo 0.06 0.06 porque al precio sin iva se le agrega un 0 mas

                        let valor = '';
                        let valorArray = '';
                        let valorEntero = '';
                        let valorDecimal = '';
                        let valorFinal = '';
                        let precioSinIvaFinal = '';
                        
                        let cantidadString = cantidad.toString();
                        let cantidadArray = cantidadString.split('.');
                        let cantidadEntero = cantidadArray[0];
                        let cantidadDecimal = cantidadArray[1];

                        if ( cantidadDecimal.startsWith('0') ) {
                            // agregar un 0 al precio sin iva
                            valor = precioSinIva.toString();
                            valorArray = valor.split('.');
                            valorEntero = valorArray[0];
                            valorDecimal = valorArray[1];
                            valorFinal = '0.'+'0'+valorEntero+valorDecimal;
                            precioSinIvaFinal = parseFloat(valorFinal);
                        }else{
                            // agregar un 0 al precio sin iva
                            valor = precioSinIva.toString();
                            valorArray = valor.split('.');
                            valorEntero = valorArray[0];
                            valorDecimal = valorArray[1];
                            valorFinal = '0.'+valorEntero+valorDecimal;
                            precioSinIvaFinal = parseFloat(valorFinal);
                        }

                        precioSinIva = precioSinIvaFinal;
                        form.find('.precioSinIva').val(precioSinIva);

                        // cambiar la cantidad a entero es decir 0.39 se conviernte en 39
                        cantidad = cantidad * 100;
                        form.find('.cantidad').val(cantidad);
                    }

                    const descuento = parseFloat(form.find('.descuento').val());

                    if (precioSinIva === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'El precio sin iva es requerido',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    } else {

                        if ( descuento !== 0 ) {
                            const descuentoPorcentaje = (descuento * (precioSinIva * cantidad)) / 100;
                            const resultado = (cantidad * precioSinIva) - descuentoPorcentaje;
                            const total = resultado.toFixed(2);

                            if (total < 0) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'El total no puede ser menor a 0',
                                    icon: 'error',
                                    confirmButtonText: 'Aceptar'
                                });
                            } else {
                                totalInput.val(total);
                            }
                        }else{
                            const total = cantidad * precioSinIva;
                            const res = total.toFixed(2);
                            totalInput.val(res);
                        }

                        descuentoInput.attr('disabled', false);
                        
                    }
                });

                $('#newLinesContainerEdit').on('change', `#descuentoEdit`, function () {
                    const descuento = parseFloat($(this).val());
                    const totalCompra = parseFloat($('#modalEditCompra #totalFacturaEdit').val());
                    const form = $(this).closest('form');
                    const cantidad = parseFloat(form.find('.cantidad').val());
                    const precioSinIva = parseFloat(form.find('.precioSinIva').val());
                    const totalInput = form.find('.total');

                    const descuentoPorcentaje = (descuento * (precioSinIva * cantidad)) / 100;

                    if (descuento === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'El descuento es requerido',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    } else {
                        const resultado = (cantidad * precioSinIva) - descuentoPorcentaje;
                        const total = resultado.toFixed(2);
                        
                        if (total < 0) {
                            Swal.fire({
                                title: 'Error',
                                text: 'El total no puede ser menor a 0',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        } else {
                            totalInput.val(total);
                        }
                    }
                });

                // RAEE
                $('#newLinesContainerEdit').on('change', `#raeEdit`, function () {
                    const rae = parseFloat($(this).val());
                    const form = $(this).closest('form');
                    const cantidad = parseFloat(form.find('.cantidad').val());
                    const precioSinIva = parseFloat(form.find('.precioSinIva').val());
                    const descuento = parseFloat(form.find('.descuento').val());
                    const totalInput = form.find('.total');

                    const descuentoPorcentaje = (descuento * (precioSinIva * cantidad)) / 100;
                    let total = (cantidad * precioSinIva) - descuentoPorcentaje;

                    // Calcular el total RAEE
                    let totalRAE = rae * cantidad;
                    totalRAE = Math.round(totalRAE * 100) / 100; // Redondear a 2 decimales

                    // Verificamos si hay descuento
                    if (descuento !== 0) {
                        const descuentoPorcentaje = (descuento * total) / 100; // Descuento total
                        total -= descuentoPorcentaje; // Aplicamos el descuento
                    }

                    // Sumar el total RAEE al total de la compra (sin o con descuento)
                    const totalFinal = total + totalRAE;

                    totalInput.val(totalFinal.toFixed(2)); // Redondear a 2 decimales
                });

                globalLineas++;

            });

            // Evento para guardar la línea
            $('#newLinesContainerEdit').on('click', '.saveLineaEdit', function (event) {
                event.preventDefault();
                const lineNumber = $(this).data('line');
                const form = $(`#AddNewLineFormEdit`);
                const descripcion = form.find(`#descripcionEdit`).val();
                const cantidad = parseFloat(form.find(`#cantidadEdit`).val());
                const precioSIva = parseFloat(form.find(`#precioSinIvaEdit`).val());
                const descuento = parseFloat(form.find(`#descuentoEdit`).val());
                const total = parseFloat(form.find(`#totalEdit`).val());
                const rae = parseFloat(form.find(`#raeEdit`).val());
                const cod_prov = form.find(`#cod_provEdit`).val();

                $('#elementsToShowEdit #sumaTotalesLineas').data('value', calcularSumaTotalesLineasEdit());

                let proveedor = {
                    idProveedor: form.find('#proveedor_id').val(),
                    nombreProveedor: form.find('#nameProovedorId').val(),
                    cifProveedor: form.find('#proveedor_cif').val()
                };

                let empresa = {
                    idEmpresa: form.find('#empresaId').val(),
                    EMP: form.find('#empresaNameId').val()
                };

                let archivos = {
                    idarchivos: form.find('#archivoId').val()
                };

                let compra = {
                    idCompra: form.find('#compra_id').val(),
                    totalFactura: parseFloat(form.find('#totalFactura').val()) // Asegurarse que se convierte a float
                };

                // Obtener la suma de las líneas existentes y agregar la nueva
                let sumaTotalesLineas = calcularSumaTotalesLineasEdit() + total;
                // Validar si la suma total supera el total de la factura
                // if (sumaTotalesLineas > compra.totalFactura) {
                //     Swal.fire({
                //         title: 'Error',
                //         text: 'El total de las líneas no puede ser mayor al total de la factura',
                //         icon: 'error',
                //         confirmButtonText: 'Aceptar'
                //     });
                    
                //     return;
                // }

                // Validaciones de campos obligatorios
                if (proveedor.idProveedor === '' || proveedor.idProveedor === undefined || proveedor.idProveedor === null) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al guardar la línea, primero debe guardar la compra',
                        icon: 'error',
                        footer: 'No se han podido obtener los datos de la compra',
                        confirmButtonText: 'Aceptar'
                    });
                }

                // if (descripcion === '' || isNaN(cantidad) || isNaN(precioSIva) || isNaN(descuento) || isNaN(total)) {
                //     Swal.fire({
                //         title: 'Error',
                //         text: 'Todos los campos son requeridos y deben tener valores válidos',
                //         icon: 'error',
                //         confirmButtonText: 'Aceptar'
                //     });
                //     return;

                // }

                const table = $('#tableToShowElementsEdit');
                const elements = $('#elementsToShowEdit');

                // Mostrar tabla de elementos

                if ( proveedor.cifProveedor == undefined || proveedor.cifProveedor == null || proveedor.cifProveedor == 'undefined' || !proveedor.cifProveedor ) {
                    $.ajax({
                        'url': '<?php echo e(route("admin.lineas.getInfoToStore")); ?>',
                        'method': 'POST',
                        'data': {
                        _token: '<?php echo e(csrf_token()); ?>',
                        proveedor_id: proveedor.idProveedor,
                        empresa_id: empresa.idEmpresa,
                        archivo_id: archivos.idarchivos,
                        idCompra: compra.idCompra
                        },
                        beforeSend: function() {
                            openLoader();
                        },
                        success: function(response){
                            closeLoader();
                            proveedor.cifProveedor = response.compra.NFacturaCompra;
                            archivos.idarchivos    = response.archivo.archivo_id;

                            $.ajax({
                                url: '<?php echo e(route("admin.lineas.store")); ?>',
                                method: 'POST',
                                data: {
                                    _token: '<?php echo e(csrf_token()); ?>',
                                    proveedor_id: proveedor.idProveedor,
                                    descripcion,
                                    cantidad,
                                    precioSinIva: precioSIva,
                                    descuento,
                                    total,
                                    rae,
                                    cod_prov,
                                    trazabilidad: `${empresa.EMP} - ${proveedor.cifProveedor} - ${archivos.idarchivos}`,
                                    compra_id: compra.idCompra
                                },
                                beforeSend: function() {
                                    $('#addNewLineEdit').attr('disabled', true);
                                    openLoader();
                                },
                                success: function(response) {

                                    const { linea, proveedor, compra, archivos } = response;

                                    let newElement = `
                                        <tr>
                                            <td>${linea.idLinea}</td>
                                            <td style="font-weight: bold;">${linea.cod_proveedor}</td>
                                            <td>${descripcion}</td>
                                            <td>${cantidad}</td>
                                            <td>${precioSIva}</td>
                                            <td>${rae}€</td>
                                            <td>${descuento}</td>
                                            <td>${proveedor.nombreProveedor}</td>
                                            <td
                                                class="openHistorialArticulo"
                                                data-id="${linea.articulo_id}"
                                                data-nameart="${linea.descripcion}"
                                                data-trazabilidad="${linea.trazabilidad}"
                                            >${formatTrazabilidad(linea.trazabilidad)}</td>
                                            <td>${total}</td>
                                            <td><?php echo e(Auth::user()->name); ?></td>
                                            <td>
                                                <?php $__env->startComponent('components.actions-button'); ?>
                                                    <button 
                                                        class="btn btn-primary editLineaCompra" 
                                                        data-id="${linea.idLinea}" 
                                                        data-lineainfo='${JSON.stringify(linea)}'
                                                    >
                                                        <ion-icon name="create-outline"></ion-icon>
                                                    </button>
                                                    <button 
                                                        class="btn btn-danger deleteLineaCompra" 
                                                        data-id="${linea.idLinea}" 
                                                        data-lineainfo='${JSON.stringify(linea)}'
                                                    >
                                                        <ion-icon name="trash-outline"></ion-icon>
                                                    </button>
                                                <?php echo $__env->renderComponent(); ?>    
                                            </td>
                                        </tr>
                                    `;

                                    elements.append(newElement);
                                    closeLoader();
                                    $('#newLinesContainerEdit').empty();
                                    // Actualizar la suma total de las líneas
                                    $('#elementsToShowEdit #sumaTotalesLineas').data('value', sumaTotalesLineas);

                                    // Actualizar valores de la compra
                                    let nuevoImporte = parseFloat($('#modalEditCompra #ImporteEdit').val()) + total;
                                    $('#modalEditCompra #ImporteEdit').val(nuevoImporte.toFixed(2));

                                    calcularTotalesEdit( compra.idCompra ); // Recalcular los totales

                                    Swal.fire({
                                        title: 'Línea guardada',
                                        text: 'La línea se ha guardado correctamente',
                                        icon: 'success',
                                        confirmButtonText: 'Aceptar'
                                    });

                                    // Limpiar campos de la nueva línea y deshabilitarlos
                                    form.find('textarea, input').val('').attr('disabled', true);

                                    $('#addNewLineEdit').attr('disabled', false);
                                },
                                error: function(error) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Ha ocurrido un error al guardar la línea',
                                        icon: 'error',
                                        footer: error.message,
                                        confirmButtonText: 'Aceptar'
                                    });
                                }
                            });
                        },
                        error: function(response){
                            closeLoader();
                            Swal.fire({
                                title: 'Error',
                                text: 'Ha ocurrido un error al guardar la línea',
                                icon: 'error',
                                footer: response.message,
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    });
                    return;
                }

                $.ajax({
                    url: '<?php echo e(route("admin.lineas.store")); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        proveedor_id: proveedor.idProveedor,
                        descripcion,
                        cantidad,
                        precioSinIva: precioSIva,
                        descuento,
                        total,
                        rae,
                        cod_prov,
                        trazabilidad: `${empresa.EMP} - ${proveedor.cifProveedor} - ${archivos.idarchivos}`,
                        compra_id: compra.idCompra
                    },
                    beforeSend: function() {
                        $('#addNewLineEdit').attr('disabled', true);
                        openLoader();
                    },
                    success: function(response) {

                        const { linea, proveedor, compra, archivos } = response;

                        let newElement = `
                            <tr>
                                <td>${linea.idLinea}</td>
                                <td style="font-weight: bold;">${linea.cod_proveedor}</td>
                                <td>${descripcion}</td>
                                <td>${cantidad}</td>
                                <td>${precioSIva}</td>
                                <td>${rae}€</td>
                                <td>${descuento}</td>
                                <td>${proveedor.nombreProveedor}</td>
                                <td
                                    class="openHistorialArticulo"
                                    data-id="${linea.articulo_id}"
                                    data-nameart="${linea.descripcion}"
                                    data-trazabilidad="${linea.trazabilidad}"
                                >${formatTrazabilidad(linea.trazabilidad)}</td>
                                <td>${total}</td>
                                <td><?php echo e(Auth::user()->name); ?></td>
                                <td>
                                    <?php $__env->startComponent('components.actions-button'); ?>
                                        <button 
                                            class="btn btn-primary editLineaCompra" 
                                            data-id="${linea.idLinea}" 
                                            data-lineainfo='${JSON.stringify(linea)}'
                                        >
                                            <ion-icon name="create-outline"></ion-icon>
                                        </button>
                                        <button 
                                            class="btn btn-danger deleteLineaCompra" 
                                            data-id="${linea.idLinea}" 
                                            data-lineainfo='${JSON.stringify(linea)}'
                                        >
                                            <ion-icon name="trash-outline"></ion-icon>
                                        </button>
                                    <?php echo $__env->renderComponent(); ?>    
                                </td>
                            </tr>
                        `;

                        elements.append(newElement);
                        closeLoader();
                        $('#newLinesContainerEdit').empty();
                        // Actualizar la suma total de las líneas
                        $('#sumaTotalesLineas').data('value', sumaTotalesLineas);

                        // Actualizar valores de la compra
                        let nuevoImporte = parseFloat($('#Importe').val()) + total;
                        $('#Importe').val(nuevoImporte.toFixed(2));

                        calcularTotales( compra.idCompra ); // Recalcular los totales

                        Swal.fire({
                            title: 'Línea guardada',
                            text: 'La línea se ha guardado correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });

                        // Limpiar campos de la nueva línea y deshabilitarlos
                        form.find('textarea, input').val('').attr('disabled', true);

                        $('#addNewLineEdit').attr('disabled', false);
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al guardar la línea',
                            icon: 'error',
                            footer: error.message,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });

            });

            // Actualizar compra - Enviar formulario de edición
            $('#modalEditCompra #btnSaveEditCompra').click(function () {
                $('#formEditCompra').submit(); // Enviar formulario
            });

            // Función para manejar los cambios en el campo de plazos
            $('#modalEditCompra #PlazosEdit').change(function() {
                let plazos = $(this).val();

                // convertir a int
                plazos = parseInt(plazos);

                // Ocultar todos los campos relacionados con plazos
                $('#modalEditCompra .plazo-fields').hide();

                // Mostrar los campos según la selección de plazos
                if (plazos == '0') {
                    // Mostrar campos para plazo 0 (Pagado)
                    $('#modalEditCompra .plazo0').show();
                } else if (plazos == 1) {
                    // Mostrar campos para plazo 1
                    $('#modalEditCompra .plazo1').show();
                } else if ( plazos => 2) {
                    // Mostrar campos para plazo > 1
                    $('#modalEditCompra .plazo2').show();

                    let fechaActual = new Date();
                    fechaActual.setMonth(fechaActual.getMonth() + 1);

                    const fechaFormateada = fechaActual.toISOString().split('T')[0];

                    $('#modalEditCompra #siguienteCobroCreate').val(fechaFormateada);

                }
            });

            $('#modalEditCompra #frecuenciaPagoEdit').on('change', () =>{

                let fechaActual = new Date();
                let value = $('#frecuenciaPagoCreate').val();

                if (value == 'mensual') {
                    fechaActual.setMonth(fechaActual.getMonth() + 1);
                } else if (value == 'semanal') {
                    fechaActual.setDate(fechaActual.getDate() + 7);
                } else if (value == 'quincenal') {
                    fechaActual.setDate(fechaActual.getDate() + 15);
                }

                let fechaFormateada = fechaActual.toISOString().split('T')[0];


                $('#siguienteCobroCreate').val(fechaFormateada);
            })

            // Al cargar la página, verificar el valor inicial de plazos
            let plazosInicial = $('#modalEditCompra #PlazosEdit').val();
            if (plazosInicial == '0') {
                $('.plazo0').show();
            } else if (plazosInicial == '1') {
                $('#modalEditCompra .plazo1').show();
            } else if (plazosInicial == '2') {
                $('#modalEditCompra .plazo2').show();
            }

            // Implementación de AJAX para crear compra
            $('#modalEditCompra #btnCreateCompra').click(function() {
                // Aquí puedes implementar la lógica de AJAX para enviar los datos del formulario
                let formData = $('#formCreateCompra').serialize();
                $.ajax({
                    url: '<?php echo e(route("admin.compras.store")); ?>',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Manejar la respuesta del servidor
                        // Por ejemplo, mostrar un mensaje de éxito y cerrar el modal
                        $('#modalCreateCompra').modal('hide');
                        // Recargar la página o actualizar la tabla si es necesario
                        location.reload();
                    },
                    error: function(error) {
                        // Manejar errores de AJAX
                        console.error('Error al crear compra:', error);
                    }
                });
            });

            // eliminar la compra
            table.on('click', '.deleteCompra', function(event){

                const compraId = $(this).data('id');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `<?php echo e(route('admin.compras.destroy', ':id')); ?>`.replace(':id', compraId),
                            method: 'DELETE',
                            data: {
                                _token: '<?php echo e(csrf_token()); ?>'
                            },
                            success: function(response) {
                                // Eliminar la fila de la tabla
                                $(`#compra${compraId}`).remove();
                                Swal.fire({
                                    title: 'Compra eliminada',
                                    text: 'La compra se ha eliminado correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                });
                            },
                            error: function(error) {
                                console.error('Error al eliminar la compra:', error);
                            }
                        });
                    }
                })

            });

            // capturar el evento al cerrar el modal de crear compra
            $('#modalCreateCompra').on('hidden.bs.modal', function (e) {
                // verificar si hay elementos en la tabla
                let table = $('#modalCreateCompra #tableToShowElements');
                let elements = $('#modalCreateCompra #elementsToShow');

                if (elements.find('tr').length > 0) {
                    
                    // Limpiar los campos del formulario
                    $('#modalCreateCompra #formCreateCompra').trigger('reset');
                    $('#modalCreateCompra #elementsToShow').empty();

                    // Ocultar los campos de plazos
                    $('#modalCreateCompra .plazo-fields').hide();

                    const id = $('#modalCreateCompra #idCompraCreate').val();

                    // enviar copia de la compra a telegram
                    $.ajax({
                        url: '<?php echo e(route("admin.compras.sendTelegram")); ?>',
                        method: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            id
                        },
                        beforeSend: function() {
                            openLoader();
                        },
                        success: function(response) {
                            closeLoader();
                            window.location.reload();
                        },
                        error: function(error) {
                            closeLoader();
                            console.error('Error al enviar la compra a Telegram:', error);
                        }
                    });

                }

            });
            
        });
    </script>

    <?php if(session('success')): ?>
        <script>
            Swal.fire(
                '¡Éxito!',
                '<?php echo e(session('success')); ?>',
                'success'
            );
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Clases_Programacion\Clientes\MILECOSL\milecosl\resources\views/admin/compras/index.blade.php ENDPATH**/ ?>