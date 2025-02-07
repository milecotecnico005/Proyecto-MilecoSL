<li <?php if(isset($item['id'])): ?> id="<?php echo e($item['id']); ?>" <?php endif; ?> class="nav-item has-treeview">
    <a href="#" class="nav-link" data-toggle="collapse" 
       data-target="#submenu<?php echo e($item['id'] ?? ''); ?>" 
       aria-expanded="false" 
       aria-controls="submenu<?php echo e($item['id'] ?? ''); ?>">
       <ion-icon style="font-size: 15px; margin-right: 5px" 
                 name="<?php echo e($item['icon'] ?? 'far fa-fw fa-circle'); ?><?php echo e(isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''); ?>"></ion-icon>
        <span class="text"><?php echo e($item['text']); ?></span>
        <i class="fas fa-angle-right ml-1"></i>
    </a>
    
    <ul id="submenu<?php echo e($item['id'] ?? ''); ?>" 
        class="nav nav-treeview collapse dropDownPersonalizado"
        style="position: absolute; z-index: 9999; 
               box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); width: 250px; left: 0;">
        <?php echo $__env->renderEach('adminlte::partials.sidebar.menu-item', $item['submenu'], 'item'); ?>
    </ul>
</li>
<?php /**PATH E:\Clases_Programacion\Clientes\MILECOSL\milecosl\vendor\jeroennoten\laravel-adminlte\src/../resources/views/partials/sidebar/menu-item-treeview-menu.blade.php ENDPATH**/ ?>