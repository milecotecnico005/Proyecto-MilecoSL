<?php $layoutHelper = app('JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper'); ?>
<?php $preloaderHelper = app('JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper'); ?>

<?php if($layoutHelper->isLayoutTopnavEnabled()): ?>
    <?php ( $def_container_class = 'container' ); ?>
<?php else: ?>
    <?php ( $def_container_class = 'container-fluid' ); ?>
<?php endif; ?>




    
    

    
    

    
    
    <main>
        
        <?php if (! empty(trim($__env->yieldContent('content_header')))): ?>
            <div class="head-title">
                <?php echo $__env->yieldContent('content_header'); ?>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldPushContent('content'); ?>
        <?php echo $__env->yieldContent('content'); ?>

    </main>


<?php /**PATH E:\Clases_Programacion\Clientes\MILECOSL\milecosl\vendor\jeroennoten\laravel-adminlte\src/../resources/views/partials/cwrapper/cwrapper-default.blade.php ENDPATH**/ ?>