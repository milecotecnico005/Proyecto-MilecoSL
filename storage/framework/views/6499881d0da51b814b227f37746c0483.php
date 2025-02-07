<?php ($logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout')); ?>
<?php ($profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout')); ?>

<?php if(config('adminlte.usermenu_profile_url', false)): ?>
    <?php ($profile_url = Auth::user()->adminlte_profile_url()); ?>
<?php endif; ?>

<?php if(config('adminlte.use_route_url', false)): ?>
    <?php ($profile_url = $profile_url ? route($profile_url) : ''); ?>
    <?php ($logout_url = $logout_url ? route($logout_url) : ''); ?>
<?php else: ?>
    <?php ($profile_url = $profile_url ? url($profile_url) : ''); ?>
    <?php ($logout_url = $logout_url ? url($logout_url) : ''); ?>
<?php endif; ?>

<style>
    .profile {
        position: relative;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        text-align: end;
    }

    .profile h3 {
        text-align: end;
        line-height: 1;
        margin-bottom: 4px;
        font-weight: 600;
    }

    .profile p {
        line-height: 1;
        font-size: 14px;
        opacity: .6;
    }

    .profile .img-box {
        position: relative;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        overflow: hidden;
    }

    .profile .img-box img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* menu (the right one) */

    .menu {
        position: absolute;
        top: calc(100% + 24px);
        right: 16px;
        width: 280px;
        /* min-height: 100px; */
        background: #fff;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .2);
        opacity: 0;
        transform: translateY(-10px);
        visibility: hidden;
        transition: 300ms;
    }

    .menu::before {
        content: '';
        position: absolute;
        top: -10px;
        right: 14px;
        width: 20px;
        height: 20px;
        background: #fff;
        transform: rotate(45deg);
        z-index: -1;
    }

    .menu.active {
        opacity: 1;
        transform: translateY(0);
        visibility: visible;
    }

    /* menu links */

    .menu ul {
        position: relative;
        display: flex;
        flex-direction: column;
        z-index: 10;
        justify-content: center;
    }

    .menu ul li {
        list-style: none;
    }

    .menu ul li:hover {
        background: #eee;
    }

    .menu ul li a {
        text-decoration: none;
        color: #000;
        display: flex;
        align-items: center;
        padding: 15px 20px;
        gap: 6px;
    }

    .menu ul li a i {
        font-size: 1.2em;
    }

    /* ajustar modo oscuro */

    .menu ul li a i {
        color: var(--dark);
    }

    .menu ul li a:hover i {
        color: var(--dark);
    }

    .menu ul li a:hover {
        background: var(--dark);
        color: #fff;
    }

    .menu ul li a:hover i {
        color: #fff;
    }

    .menu ul li a:hover {
        background: var(--dark);
        color: #fff;
    }

    .profile .img-box img {
        border-radius: 50%;
    }

    .profile .user{
        text-align: right;
        color: var(--dark);
    }

    .menu {
        background: var(--light);
        color: var(--dark);
    }

    .menu-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .menu-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        color: inherit;
    }

    .menu-button {
        display: flex;
        align-items: center;
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
    }

    .menu-icon {
        font-size: 1.5rem;
        color: inherit;
    }

    .theme-icon {
        font-size: 1.2rem;
        margin-right: 5px;
    }

    .menu-form {
        margin: 0;
    }

    /* hovers dark/ligth */

    .menu-button:hover {
        background: var(--dark);
        color: var(--light);
    }

    .menu-button:hover .menu-icon {
        color: var(--light);
    }

    /* li */

    .menu-item:hover{
        background: var(--dark);
        color: var(--light);
    }


</style>

<li class="nav-item dropdown user-menu">

    
    

    <div class="profile">
        <div class="user">
            <h6><?php echo e(Auth::user()->name); ?></h6>
            <p><?php echo e(Auth::user()->roles[0]->name); ?></p>
        </div>
        <div class="img-box">
            <img src="https://sebcompanyes.com/vendor/adminlte/dist/img/mileco.jpeg" alt="some user image">
        </div>
    </div>
    <div class="menu" style="padding: 10px; background: var(--light); color: var(--dark);">
        <ul class="menu-list">
            <!-- Mi Perfil -->
            <li class="menu-item">
                <button class="btn menu-button" id="editMyProfile" data-name="<?php echo e(Auth::user()->name); ?>" data-email="<?php echo e(Auth::user()->email); ?>">
                    <ion-icon name="person-outline" class="menu-icon"></ion-icon>
                    <span>Mi perfil</span>
                </button>
            </li>
    
            <!-- Modo Oscuro/Claro -->
            <li class="menu-item">
                <span>Modo oscuro/Claro</span>
                <div class="d-flex align-items-center">
                    <input type="checkbox" id="switch-mode" hidden>
                    <label for="switch-mode" class="switch-mode">
                        <ion-icon name="sunny-outline" class="theme-icon"></ion-icon>
                        <ion-icon name="moon-outline" class="theme-icon"></ion-icon>
                    </label>
                </div>
            </li>
    
            <!-- Recargar Página Sin Caché -->
            <li class="menu-item">
                <span>Limpiar Caché del navegador</span>
                <button id="clearCache" class="menu-button">
                    <ion-icon name="refresh-outline" class="menu-icon"></ion-icon>
                </button>
            </li>
    
            <!-- Limpiar Caché de la Aplicación -->
            <li class="menu-item">
                <span>Limpiar caché de la aplicación</span>
                <button id="clearCacheApp" class="menu-button">
                    <ion-icon name="trash-outline" class="menu-icon"></ion-icon>
                </button>
            </li>
    
            <!-- Cerrar Sesión -->
            <li class="menu-item">
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="menu-form">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn menu-button">
                        <ion-icon name="log-out-outline" class="menu-icon"></ion-icon>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>   

    
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        
        <?php if(!View::hasSection('usermenu_header') && config('adminlte.usermenu_header')): ?>
            <li
                class="user-header <?php echo e(config('adminlte.usermenu_header_class', 'bg-primary')); ?>

                <?php if(!config('adminlte.usermenu_image')): ?> h-auto <?php endif; ?>">
                <?php if(config('adminlte.usermenu_image')): ?>
                    <img src="<?php echo e(Auth::user()->adminlte_image()); ?>" class="img-circle elevation-2"
                        alt="<?php echo e(Auth::user()->name); ?>">
                <?php endif; ?>
                <p class="<?php if(!config('adminlte.usermenu_image')): ?> mt-0 <?php endif; ?>">
                    <?php echo e(Auth::user()->name); ?>

                    <?php if(config('adminlte.usermenu_desc')): ?>
                        <small><?php echo e(Auth::user()->adminlte_desc()); ?></small>
                    <?php endif; ?>
                </p>
            </li>
        <?php else: ?>
            <?php echo $__env->yieldContent('usermenu_header'); ?>
        <?php endif; ?>

        
        <?php echo $__env->renderEach('adminlte::partials.navbar.dropdown-item', $adminlte->menu('navbar-user'), 'item'); ?>

        
        <?php if (! empty(trim($__env->yieldContent('usermenu_body')))): ?>
            <li class="user-body">
                <?php echo $__env->yieldContent('usermenu_body'); ?>
            </li>
        <?php endif; ?>

        
        <li class="user-footer">
            <?php if($profile_url): ?>
                <a href="<?php echo e($profile_url); ?>" class="nav-link btn btn-default btn-flat d-inline-block">
                    <i class="fa fa-fw fa-user text-lightblue"></i>
                    <?php echo e(__('adminlte::menu.profile')); ?>

                </a>
            <?php endif; ?>
            <a class="btn btn-default btn-flat float-right <?php if(!$profile_url): ?> btn-block <?php endif; ?>"
                href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-fw fa-power-off text-red"></i>
                <?php echo e(__('adminlte::adminlte.log_out')); ?>

            </a>
            <form id="logout-form" action="<?php echo e($logout_url); ?>" method="POST" style="display: none;">
                <?php if(config('adminlte.logout_method')): ?>
                    <?php echo e(method_field(config('adminlte.logout_method'))); ?>

                <?php endif; ?>
                <?php echo e(csrf_field()); ?>

            </form>
        </li>

    </ul>

</li>

<script>
    let profile = document.querySelector('.profile');
    let menu = document.querySelector('.menu');

    profile.onclick = function() {
        menu.classList.toggle('active');
    }

    menu.onmouseleave = function() {
        menu.classList.remove('active');
    }

    profile.onmouseover = function() {
        menu.classList.add('active');
    }
    

</script>
<?php /**PATH D:\milecosl\vendor\jeroennoten\laravel-adminlte\src/../resources/views/partials/navbar/menu-item-dropdown-user-menu.blade.php ENDPATH**/ ?>