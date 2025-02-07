

<li <?php if(isset($item['id'])): ?> id="<?php echo e($item['id']); ?>" <?php endif; ?>>
    <a href="<?php echo e($item['href']); ?>" <?php if(isset($item['target'])): ?> target="<?php echo e($item['target']); ?>" <?php endif; ?>>
        <ion-icon style="font-size: 15px; margin-right: 5px" name="<?php echo e($item['icon'] ?? 'far fa-fw fa-circle'); ?><?php echo e(isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''); ?>"></ion-icon>
        <span class="text"><?php echo e($item['text']); ?></span>
    </a>
</li><?php /**PATH D:\milecosl\vendor\jeroennoten\laravel-adminlte\src/../resources/views/partials/sidebar/menu-item-link.blade.php ENDPATH**/ ?>