<form id="formCreateProveedor" action="<?php echo e(route('admin.proveedores.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="form-row">
        <div class="form-group col-md-6 required-field">
            <label class="form-label" for="cifProveedor">CIF</label>
            <input type="text" class="form-control" id="cifProveedor" name="cifProveedor" placeholder="CIF">
        </div>
        <div class="form-group col-md-6 required-field">
            <label class="form-label" for="nombreProveedor">Nombre</label>
            <input type="text" class="form-control" id="nombreProveedor" name="nombreProveedor" placeholder="Nombre">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6 ">
            <label class="form-label" for="direccionProveedor">Dirección</label>
            <div class="d-flex justify-content-between">
                <input type="text" class="form-control direccion" id="direccionProveedor" name="direccionProveedor" placeholder="Dirección">
                <button type="button" class="btn btn-outline-primary direccion-btnSearch" id="btnSearch">Buscar</button>
            </div>
            <div id="suggestions"></div>
        </div>
        <div class="form-group col-md-6 ">
            <label class="form-label" for="codigoPostalProveedor">Código Postal</label>
            <input type="text" class="form-control" id="codigoPostalProveedor" name="codigoPostalProveedor" placeholder="Código Postal">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6 ">
            <label class="form-label" for="ciudad_id">Ciudad</label>
            <select id="ciudad_id" name="ciudad_id" class="form-select">
                <option value="" selected>Seleccionar...</option>
                <?php $__currentLoopData = $ciudades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ciudad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ciudad->idCiudades); ?>"><?php echo e($ciudad->nameCiudad); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group col-md-6 ">
            <label class="form-label" for="emailProveedor">Email</label>
            <input type="email" class="form-control" id="emailProveedor" name="emailProveedor" placeholder="Email">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6 ">
            <label class="form-label" for="agenteProveedor">Agente</label>
            <input type="text" class="form-control" id="agenteProveedor" name="agenteProveedor" placeholder="Agente">
        </div>
        <div class="form-group col-md-6 ">
            <label class="form-label" for="tipoProveedor">Tipo</label>
            <select id="tipoProveedor" name="tipoProveedor" class="form-select">
                <option value="" selected>Seleccionar...</option>
                <option value="2">Proveedor</option>
                <option value="3">Acreedor</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6 ">
            <label class="form-label" for="banco_id">Banco</label>
            <select id="banco_id" name="banco_id" class="form-select">
                <option value="" selected>Seleccionar...</option>
                <?php $__currentLoopData = $bancos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($banco->idbanco); ?>"><?php echo e($banco->nameBanco); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group col-md-6 ">
            <label class="form-label" for="Scta_ConInicio">Cuenta Contable Inicial</label>
            <input type="text" class="form-control" id="Scta_ConInicio" name="Scta_ConInicio" placeholder="Cuenta Contable Inicial">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6 ">
            <label class="form-label" for="Scta_Contable">Cuenta Contable</label>
            <input type="text" class="form-control" id="Scta_Contable" name="Scta_Contable" placeholder="Cuenta Contable">
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="observacionesProveedor">Observaciones</label>
            <textarea class="form-control" id="observacionesProveedor" name="observacionesProveedor" rows="3"></textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="telefono">Telefono</label>
                <input type="number" name="telefono[]" id="telefono" class="form-control">
            </div>
            
            <div class="form-group mb-2" id="telefonosContainer"></div>
            <button type="button" class="btn btn-outline-primary" id="btnAddTelefono">Agregar otro telefono</button>
        </div>
    </div>
</form>

<script>
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
</script><?php /**PATH E:\Clases_Programacion\Clientes\MILECOSL\milecosl\resources\views/admin/proveedores/formcreate.blade.php ENDPATH**/ ?>