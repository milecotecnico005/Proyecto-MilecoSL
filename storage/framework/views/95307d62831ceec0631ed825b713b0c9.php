<div class="modal fade <?php echo e($modalSize); ?>" id="<?php echo e($modalId); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div 
        <?php if(isset($modalTop)): ?>
            class="modal-dialog"
        <?php else: ?>
            class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        <?php endif; ?>
        >
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="<?php echo e(isset($modalTitleId) ? $modalTitleId : ''); ?>"><?php echo e($modalTitle); ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="<?php echo e(isset($modalBody) ? $modalBody: 'modalBodyId'); ?>" class="modal-body">
                <?php echo e($slot); ?>

            </div>
            <div class="modal-footer" id="<?php echo e(isset($footerId) ? $footerId : ''); ?>">
                <div class="d-flex justify-content-center align-items-center gap-2 mr-2" id="<?php echo e(isset($otherButtonsContainer) ? $otherButtonsContainer : ''); ?>"></div>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
                <button 
                    type="button" 
                    id="<?php echo e(isset($btnSaveId) ? $btnSaveId : ''); ?>" 
                    <?php echo e(isset($disabledSaveBtn) ? 'disabled' : ''); ?>

                    class="<?php echo e(isset($hideButton) ? "btn btn-outline-primary d-none" : "btn btn-outline-warning"); ?>"
                >
                    <?php echo e(isset($nameButtonSave) ? $nameButtonSave : 'Guardar'); ?>

                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal {
        min-width: 100vw;
    }
    .modal-body {
        scroll-behavior: smooth;
    }
</style>
<?php /**PATH D:\milecosl\resources\views/components/modal-component.blade.php ENDPATH**/ ?>