<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">

    <!--=============== BOXICONS ===============-->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    
    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="<?php echo e(asset('css/swiper-bundle.min.css')); ?>">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">

    <title>MILECO SL</title>
</head>
    <body>
        <!--==================== HEADER ====================-->
        <header class="header" id="header">
            <nav class="nav container">
                <a href="#" class="nav__logo">
                    Mileco S.L <i class='bx bxs-home-alt-2'></i>
                </a>

                <div class="nav__menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="<?php echo e(route('index')); ?>#home" class="nav__link active-link">
                                <i class='bx bx-home-alt-2'></i>
                                <span>Inicio</span>
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="<?php echo e(route('index')); ?>#popular" class="nav__link">
                                <i class='bx bx-building-house' ></i>
                                <span>Nuestros trabajos</span>
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="<?php echo e(route('index')); ?>#value" class="nav__link">
                                <i class='bx bx-award' ></i>
                                <span>Ventajas</span>
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="<?php echo e(route('index')); ?>#contact" class="nav__link">
                                <span>Contacto</span>
                                <i class='bx bx-phone' ></i>
                            </a>
                        </li>
                        
                        <?php if(Route::has('login')): ?>
                            <?php if(auth()->guard()->check()): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('home')): ?>
                                    <li class="nav__item">
                                        <a
                                            href="<?php echo e(url('/home')); ?>"
                                            class="nav__link"
                                        >
                                            <span>Administrador</span>
                                            <i class='bx bx-user' ></i>
                                            
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php else: ?>
                            <li class="nav__item">
                                <a
                                    href="<?php echo e(route('login')); ?>"
                                    class="nav__link"
                                >
                                    <span>Login</span>
                                    <i class='bx bx-log-in'></i>
                                </a>
                            </li>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                    </ul>
                </div>

                <!-- Theme change button -->
                <i class='bx bx-moon change-theme' id="theme-button"></i>

            </nav>
        </header>

        <!--==================== MAIN ====================-->
        <main class="main">
            <?php echo $__env->yieldContent('content'); ?>
        </main>


        <!--==================== FOOTER ====================-->
        <footer class="footer section">
            <div class="footer__container container grid">
                <div>
                    <a href="" class="footer__logo">
                        Mileco S.L <i class='bx bxs-home-alt-2'></i>
                    </a>
                    <p class="footer__description">
                        Nuestra visión es hacer que todas <br> las personas
                        encuentren un experto <br> en soluciones para tu hogar.
                    </p>
                </div>
        
                <div class="footer__content">
                    <div>
                        <h3 class="footer__title">
                            Sobre Nosotros
                        </h3>
        
                        <ul class="footer__links">
                            <li>
                                <a href="<?php echo e(route('politicas')); ?>" class="footer__link">Politicas de privacidad</a>
                            </li>
                        </ul>
                    </div>
        
                    <div>
                        <h3 class="footer__title">
                            Empresa
                        </h3>
        
                        <ul class="footer__links">
                            <li>
                                <a href="#" class="footer__link">¿Cómo Trabajamos?</a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">Capital</a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">Seguridad</a>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="footer__title">
                            Soporte
                        </h3>
        
                        <ul class="footer__links">
                            <li>
                                <a href="#" class="footer__link">Contáctanos</a>
                            </li>
                        </ul>
                    </div>
        
                    <div>
                        <h3 class="footer__title">
                            Síguenos
                        </h3>
        
                        <ul class="footer__social">
                            <a href="https://www.facebook.com/" target="_blank" class="footer__social-link">
                                <i class='bx bx-phone' ></i>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" class="footer__social-link">
                                <i class='bx bxl-whatsapp' ></i>
                            </a>
                            <a href="https://www.pinterest.com/" target="_blank" class="footer__social-link">
                                <i class='bx bxl-telegram'></i>
                            </a>    
                        </ul>
                    </div>
                </div>
            </div>
        
            <div class="footer__info container">
                <span class="footer__copy">
                    &#169; Mileco S.L. Todos los derechos reservados.
                </span>
            </div>
        </footer>

        <!--========== SCROLL UP ==========-->
        <a href="#" class="scrollup" id="scroll-up">
            <i class='bx bx-chevrons-up'></i>
        </a>

        <!--=============== SCROLLREVEAL ===============-->
        <script src="<?php echo e(asset('js/scrollreveal.min.js')); ?>"></script>

        <!--=============== SWIPER JS ===============-->
        <script src="<?php echo e(asset('js/swiper-bundle.min.js')); ?>"></script>

        <!--=============== MAIN JS ===============-->
        <script src="<?php echo e(asset('js/main.js')); ?>"></script>

        <?php echo $__env->yieldContent('scripts'); ?>

    </body>
</html><?php /**PATH D:\milecosl\resources\views/layouts/clientlayout.blade.php ENDPATH**/ ?>