<?php $__env->startSection('title', 'Empresas'); ?>

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
            <table class="table table-striped" id="EmpresasTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>EMP</th>
                        <th>Año</th>
                        <th>Tipo</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($empresa->idEmpresa); ?></td>
                            <td><?php echo e($empresa->EMP); ?></td>
                            <td><?php echo e(( $empresa->añoEmpresa ) ? formatDate($empresa->añoEmpresa) : ''); ?></td>
                            <td><?php echo e(( $empresa->tipo ) ? $empresa->tipo->nameTipo : 'Sin tipo'); ?></td>
                            <td><?php echo e($empresa->observacionesEmpresa); ?></td>
                            <td>
                                <?php $__env->startComponent('components.actions-button'); ?>
                                    <button 
                                        data-id="<?php echo e($empresa->idEmpresa); ?>"
                                        data-ano="<?php echo e($empresa->añoEmpresa); ?>"
                                        data-emp="<?php echo e($empresa->EMP); ?>"
                                        data-tipo="<?php echo e(( $empresa->tipo ) ? $empresa->tipo->nameTipo : 'Sin tipo'); ?>"
                                        data-observaciones="<?php echo e($empresa->observacionesEmpresa); ?>"
                                        class="btn btn-outline-primary btnOpenEditModal"
                                        data-toggle="modal"
                                        data-target="#modalEditEmpresa">
                                        <ion-icon name="create-outline"></ion-icon>
                                    </button>
                                <?php echo $__env->renderComponent(); ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Crear Empresa -->
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalCreateEmpresa',
        'modalTitle' => 'Crear Empresa',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'createEmpresaTitle',
        'btnSaveId' => 'btnCreateEmpresa'
    ]); ?>
        <form id="formCreateEmpresa" action="<?php echo e(route('admin.empresas.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
       
            <div class="form-group">
                <div class="form-group">
                    <label for="createEMP">EMP</label>
                    <input type="text" class="form-control" id="createEMP" name="EMP" placeholder="EMP">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="createAnoEmpresa">Año</label>
                    <input type="date" class="form-control" id="createAnoEmpresa" name="anoEmpresa" placeholder="Año">
                </div>
                <div class="form-group col-md-6">
                    <label for="createTipoEmpresa">Tipo</label>
                    <select id="createTipoEmpresa" name="tipoEmpresa" class="form-control">
                        <option selected>Seleccionar...</option>
                        <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipoEmpresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tipoEmpresa->idtiposEmpresa); ?>"><?php echo e($tipoEmpresa->nameTipo); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="createObservaciones">Observaciones</label>
                    <textarea class="form-control" id="createObservaciones" name="observacionesEmpresa" rows="3"></textarea>
                </div>
            </div>
        </form>
    <?php echo $__env->renderComponent(); ?>

    <!-- Modal para Editar Empresa -->
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalEditEmpresa',
        'modalTitle' => 'Editar Empresa',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editEmpresaTitle',
        'btnSaveId' => 'btnEditEmpresa'
    ]); ?>
        <form id="formEditEmpresa" action="<?php echo e(route('admin.empresas.update', 0)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" id="editEmpresaId" name="idEmpresa">

            <div class="form-group">
                <div class="form-group">
                    <label for="editEMP">EMP</label>
                    <input type="text" class="form-control" id="editEMP" name="EMP" placeholder="EMP">
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="editAnoEmpresa">Año</label>
                    <input type="date" class="form-control" id="editAnoEmpresa" name="anoEmpresa" placeholder="Año">
                </div>
                <div class="form-group col-md-6">
                    <label for="editTipoEmpresa">Tipo</label>
                    <select id="editTipoEmpresa" name="tipoEmpresa" class="form-control">
                        <option selected>Seleccionar...</option>
                        <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipoEmpresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tipoEmpresa->idtiposEmpresa); ?>"><?php echo e($tipoEmpresa->nameTipo); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="editObservaciones">Observaciones</label>
                    <textarea class="form-control" id="editObservaciones" name="observacionesEmpresa" rows="3"></textarea>
                </div>
            </div>
        </form>
    <?php echo $__env->renderComponent(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!-- Estilos personalizados aquí si es necesario -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

    <?php if(session('success')): ?>
        <script>
            Swal.fire(
                '¡Éxito!',
                '<?php echo e(session('success')); ?>',
                'success'
            );
        </script>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <script>
            Swal.fire(
                '¡Error!',
                '<?php echo e(session('error')); ?>',
                'error'
            );
        </script>
    <?php endif; ?>

    <script>
        $(document).ready(function () {
            // Inicialización de DataTables
            let table = $('#EmpresasTable').DataTable({
                colReorder: {
                    realtime: false
                },
                responsive: true,
                // autoFill: true,
                // fixedColumns: true,
                order: [[0, 'desc']],
                // responsive: true,

                // Ajuste para mostrar los botones a la izquierda, el filtro a la derecha, y el selector de cantidad de registros
                dom: "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
                "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
                "<'row'<'col-12'tr>>" +
                "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",

                buttons: [
                    {
                        text: 'Crear Empresa',
                        className: 'btn btn-outline-warning createEmpresaBtn mb-2',
                        action: function (e, dt, node, config) {
                            $('#modalCreateEmpresa').modal('show');
                        }
                    },
                    
                    // {
                    //     extend: 'pdf',
                    //     text: 'Exportar a PDF',
                    //     className: 'btn btn-danger',
                    //     exportOptions: {
                    //         columns: [0, 1, 2, 3, 4, 5]
                    //     }
                    // },
                    // {
                    //     extend: 'excel',
                    //     text: 'Exportar a Excel',
                    //     className: 'btn btn-success',
                    //     exportOptions: {
                    //         columns: [0, 1, 2, 3, 4, 5]
                    //     }
                    // }
                ],

                // Mostrar el selector de cantidad de entidades y establecer 50 como valor por defecto
                pageLength: 50,  // Mostrar 50 registros por defecto
                lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opciones para seleccionar cantidad de registros

                // Traducción manual al español
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros por página",
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
                // Ocultar la columna de ID y ordenar por la fecha de alta con este formato 'DD/MM/YY'
                columnDefs: [
                    // {
                    //     targets: [1],
                    //     render: function(data, type, row) {
                    //         return moment(data).format('YYYY-MM-DD');
                    //     }
                    // }
                ],
            });

            $('.createEmpresaBtn').removeClass('dt-button');

            // Abrir el modal de detalles y rellenar campos
            table.on('click', '.btnOpenDetailsModal', function () {
                $('#detailsAnoEmpresa').val($(this).data('ano'));
                $('#detailsCIF').val($(this).data('cif'));
                $('#detailsTipoEmpresa').val($(this).data('tipo'));
                $('#detailsObservaciones').val($(this).data('observaciones'));

                $('#modalDetallesEmpresa').modal('show');
            });

            $('#createEMP').on('input', function () {
                let EMP = $(this).val();
                let regex = /^[a-zA-Z0-9-]*$/;

                if (!regex.test(EMP)) {
                    $(this).val(EMP.slice(0, -1));
                }

            });

            $('#createEMP').on('click', function(){
                $(this).val('EMP-');
            });
            
            $('#editEMP').on('input', function () {
                let EMP = $(this).val();
                let regex = /^[a-zA-Z0-9-]*$/;

                if (!regex.test(EMP)) {
                    $(this).val(EMP.slice(0, -1));
                }
            });

            // Abrir el modal de edición y rellenar campos
            table.on('click','.btnOpenEditModal', function () {

                let EMP = $(this).data('emp');
                let EmpName = EMP.split('-');

                $('#editEmpresaId').val($(this).data('id'));
                $('#editAnoEmpresa').val($(this).data('ano'));
                $('#editTipoEmpresa').val($(this).data('tipo'));
                $('#editEMP').val(EmpName[0]+'-'+EmpName[1]);
                $('#editObservaciones').val($(this).data('observaciones'));

                $('#modalEditEmpresa').modal('show');
            });

            // Mostrar modal para crear empresa
            $('.createEmpresaBtn').on('click', function () {
                $('#modalCreateEmpresa').modal('show');
            });

            $('#btnCreateEmpresa').on('click', function () {
                $('#formCreateEmpresa').submit();
            });

            $('#btnEditEmpresa').on('click', function () {
                $('#formEditEmpresa').attr('action', '/admin/empresas/update/' + $('#editEmpresaId').val());
                $('#formEditEmpresa').submit();
            });

        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Clases_Programacion\Clientes\MILECOSL\milecosl\resources\views/admin/empresas/index.blade.php ENDPATH**/ ?>