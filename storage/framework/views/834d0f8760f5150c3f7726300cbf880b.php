<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>

    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <?php echo $__env->yieldContent('meta_tags'); ?>

    
    <title>
        <?php echo $__env->yieldContent('title_prefix', config('adminlte.title_prefix', '')); ?>
        <?php echo $__env->yieldContent('title', config('adminlte.title', 'AdminLTE 3')); ?>
        <?php echo $__env->yieldContent('title_postfix', config('adminlte.title_postfix', '')); ?>
    </title>

    
    <?php echo $__env->yieldContent('adminlte_css_pre'); ?>

    
    <?php if(!config('adminlte.enabled_laravel_mix')): ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/fontawesome-free/css/all.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/adminlte.min.css')); ?>">

        <?php if(config('adminlte.google_fonts.allowed', true)): ?>
            <link rel="stylesheet"
                href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <?php endif; ?>
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(mix(config('adminlte.laravel_mix_css_path', 'css/app.css'))); ?>">
    <?php endif; ?>

    
    <?php echo $__env->make('adminlte::plugins', ['type' => 'css'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php if(config('adminlte.livewire')): ?>
        <?php if(intval(app()->version()) >= 7): ?>
            @livewireStyles
        <?php else: ?>
            <livewire:styles />
        <?php endif; ?>
    <?php endif; ?>

    
    <?php echo $__env->yieldContent('adminlte_css'); ?>

    
    <?php if(config('adminlte.use_ico_only')): ?>
        <link rel="shortcut icon" href="<?php echo e(asset('favicons/favicon.ico')); ?>" />
    <?php elseif(config('adminlte.use_full_favicon')): ?>
        <link rel="shortcut icon" href="<?php echo e(asset('favicons/favicon.ico')); ?>" />
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(asset('favicons/apple-icon-57x57.png')); ?>">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(asset('favicons/apple-icon-60x60.png')); ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(asset('favicons/apple-icon-72x72.png')); ?>">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('favicons/apple-icon-76x76.png')); ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(asset('favicons/apple-icon-114x114.png')); ?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('favicons/apple-icon-120x120.png')); ?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(asset('favicons/apple-icon-144x144.png')); ?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(asset('favicons/apple-icon-152x152.png')); ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('favicons/apple-icon-180x180.png')); ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('favicons/favicon-16x16.png')); ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('favicons/favicon-32x32.png')); ?>">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(asset('favicons/favicon-96x96.png')); ?>">
        <link rel="icon" type="image/png" sizes="192x192" href="<?php echo e(asset('favicons/android-icon-192x192.png')); ?>">
        <link rel="manifest" crossorigin="use-credentials" href="<?php echo e(asset('favicons/manifest.json')); ?>">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo e(asset('favicon/ms-icon-144x144.png')); ?>">
    <?php endif; ?>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.min.js"></script>

    <link rel="stylesheet" type="text/css" href="colReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/2.0.3/css/colReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.7.0/css/autoFill.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

    <link rel="shortcut icon" style="width: 50px; height: 50px;"
        href="https://sebcompanyes.com/vendor/adminlte/dist/img/MILECOLOGO.png" type="image/x-icon">

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

</head>

<body class="<?php echo $__env->yieldContent('classes_body'); ?>" <?php echo $__env->yieldContent('body_data'); ?>>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
        }

    </style>

    <style>
        a {
            text-decoration: none;
        }

        .brand-link {
            text-decoration: none;
        }

        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            min-height: 38px;
            /* Ajusta según la altura deseada */
            padding-top: 8px;
            /* Ajusta según sea necesario */
            padding-bottom: 8px;
            /* Ajusta según sea necesario */
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            color: #000;
            padding: 1rem;
            font-size: 14px;
            font-weight: 600;
        }
    </style>

   

    <style>
        .content-wrapper {
            overflow-y: auto;
        }

        /* ocultar scrollbar del content-wrapper */
        .content-wrapper::-webkit-scrollbar {
            display: none;
        }

        table.dataTable ion-icon {
            font-size: 1.5rem !important;
        }

        @media (max-width: 1300px) {
            table.dataTable {
                font-size: 10px !important;
            }
            table.dataTable ion-icon {
                font-size: .9rem !important;
            }
        }

        .card {
            overflow-x: auto; 
            white-space: nowrap;
        }

        /* Clase personalizada para campos requeridos */
        .required-field .form-label::after {
            content: '*';  /* Agrega un asterisco al label */
            color: red;    /* Cambia el color del asterisco */
            margin-left: 5px; /* Añade espacio entre el texto y el asterisco */
        }

        .required-field .form-control:invalid {
            border-color: red;  /* Cambia el borde del input a rojo cuando no es válido */
        }

        .required-field .form-control:invalid:focus {
            box-shadow: 0 0 5px red;  /* Añade un efecto de sombra cuando el campo es requerido */
        }


    </style>

    <style>
        .loaderAjaxContainer {
            display: none;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: fixed;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99999999;
        }

        .loaderAjax {
            --ANIMATION-DELAY-MULTIPLIER: 70ms;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .loaderAjax span {
            padding: 0;
            margin: 0;
            letter-spacing: -5rem;
            animation-delay: 0s;
            transform: translateY(4rem);
            animation: hideAndSeek 1s alternate infinite cubic-bezier(0.86, 0, 0.07, 1);
        }
        .loaderAjax .l {
            animation-delay: calc(var(--ANIMATION-DELAY-MULTIPLIER) * 0);
        }
        .loaderAjax .o {
            animation-delay: calc(var(--ANIMATION-DELAY-MULTIPLIER) * 1);
        }
        .loaderAjax .a {
            animation-delay: calc(var(--ANIMATION-DELAY-MULTIPLIER) * 2);
        }
        .loaderAjax .d {
            animation-delay: calc(var(--ANIMATION-DELAY-MULTIPLIER) * 3);
        }
        .loaderAjax .ispan {
            animation-delay: calc(var(--ANIMATION-DELAY-MULTIPLIER) * 4);
        }
        .loaderAjax .n {
            animation-delay: calc(var(--ANIMATION-DELAY-MULTIPLIER) * 5);
        }
        .loaderAjax .g {
            animation-delay: calc(var(--ANIMATION-DELAY-MULTIPLIER) * 6);
        }
        .letter {
            width: fit-content;
            height: 3rem;
        }
        .i {
            margin-inline: 5px;
        }
        
        @keyframes hideAndSeek {
        0% {
            transform: translateY(4rem);
        }
        100% {
            transform: translateY(0rem);
        }
        }
    </style>
    <div class="loaderAjaxContainer">
        <div class="loaderAjax">
            <span class="l">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 11 18"
                height="18"
                width="11"
                class="letter"
              >
                <path
                  fill="black"
                  d="M0.28 16.14V0.94L3.7 0.64L5.7 1.64V12.3L8.5 12.06L10.5 13.06V16.44L2.28 17.14L0.28 16.14ZM3.5 12.7V0.859999L0.48 1.12V15.94L8.3 15.26V12.28L3.5 12.7Z"
                ></path>
              </svg>
            </span>
            <span class="o">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 16 18"
                height="18"
                width="16"
                class="letter"
              >
                <path
                  fill="black"
                  d="M8.94 17.24C8.84667 17.2533 8.74667 17.26 8.64 17.26C8.54667 17.26 8.45333 17.26 8.36 17.26C7.66667 17.26 7.02667 17.16 6.44 16.96C5.86667 16.7733 5.30667 16.5533 4.76 16.3C3.33333 15.5933 2.28667 14.6 1.62 13.32C0.966667 12.0267 0.64 10.4933 0.64 8.72C0.64 7.68 0.766667 6.67333 1.02 5.7C1.28667 4.71333 1.68 3.82667 2.2 3.04C2.72 2.24 3.36667 1.58667 4.14 1.08C4.92667 0.573332 5.84667 0.273333 6.9 0.18C7.00667 0.166666 7.10667 0.159999 7.2 0.159999C7.29333 0.159999 7.38667 0.159999 7.48 0.159999C8.14667 0.159999 8.74 0.246666 9.26 0.419999C9.78 0.579999 10.3067 0.766666 10.84 0.979999C11.8 1.36667 12.6 1.94 13.24 2.7C13.88 3.46 14.36 4.35333 14.68 5.38C15 6.39333 15.16 7.48 15.16 8.64C15.16 9.72 15.0333 10.7533 14.78 11.74C14.5267 12.7267 14.14 13.62 13.62 14.42C13.1133 15.2067 12.4667 15.8467 11.68 16.34C10.9067 16.8467 9.99333 17.1467 8.94 17.24ZM6.92 16.04C7.94667 15.96 8.84 15.68 9.6 15.2C10.36 14.7067 10.9867 14.0733 11.48 13.3C11.9733 12.5133 12.34 11.64 12.58 10.68C12.8333 9.70667 12.96 8.69333 12.96 7.64C12.96 6.68 12.8467 5.76667 12.62 4.9C12.4067 4.02 12.0733 3.24 11.62 2.56C11.1667 1.88 10.5933 1.34667 9.9 0.959999C9.22 0.559999 8.41333 0.359999 7.48 0.359999C7.38667 0.359999 7.29333 0.359999 7.2 0.359999C7.12 0.359999 7.02667 0.366666 6.92 0.38C5.89333 0.473333 5 0.766666 4.24 1.26C3.48 1.74 2.84667 2.37333 2.34 3.16C1.83333 3.93333 1.45333 4.8 1.2 5.76C0.96 6.70667 0.84 7.69333 0.84 8.72C0.84 9.72 0.953333 10.6667 1.18 11.56C1.40667 12.44 1.74667 13.22 2.2 13.9C2.65333 14.5667 3.22667 15.0933 3.92 15.48C4.61333 15.8667 5.42 16.06 6.34 16.06C6.44667 16.06 6.54667 16.06 6.64 16.06C6.73333 16.06 6.82667 16.0533 6.92 16.04ZM6.92 12.94C6.86667 12.94 6.81333 12.9467 6.76 12.96C6.72 12.96 6.67333 12.96 6.62 12.96C5.82 12.96 5.18667 12.6133 4.72 11.92C4.26667 11.2267 4.04 10.0667 4.04 8.44C4.04 7.28 4.16667 6.34667 4.42 5.64C4.67333 4.93333 5.02 4.41333 5.46 4.08C5.9 3.73333 6.38667 3.54 6.92 3.5C6.97333 3.5 7.02667 3.5 7.08 3.5C7.13333 3.48667 7.18667 3.48 7.24 3.48C8.02667 3.48 8.64 3.82 9.08 4.5C9.52 5.16667 9.74 6.31333 9.74 7.94C9.74 9.67333 9.47333 10.9267 8.94 11.7C8.42 12.46 7.74667 12.8733 6.92 12.94ZM6.86 12.74C7.64667 12.6733 8.28667 12.2733 8.78 11.54C9.28667 10.8067 9.54 9.60667 9.54 7.94C9.54 7.18 9.49333 6.53333 9.4 6C9.30667 5.46667 9.16667 5.03333 8.98 4.7C8.91333 4.68667 8.84667 4.68 8.78 4.68C8.71333 4.66667 8.64667 4.66 8.58 4.66C7.79333 4.66 7.20667 5.07333 6.82 5.9C6.43333 6.71333 6.24 7.89333 6.24 9.44C6.24 10.2133 6.29333 10.8733 6.4 11.42C6.50667 11.9533 6.66 12.3933 6.86 12.74Z"
                ></path>
              </svg>
            </span>
            <span class="a">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 15 18"
                height="18"
                width="15"
                class="letter"
              >
                <path
                  fill="black"
                  d="M9.28 15.76L8.54 13.38L6.96 13.52L5.98 17.02L2.58 17.32L0.58 16.32L4.96 0.699999L8.26 0.419999L10.26 1.42L14.72 16.48L11.28 16.76L9.28 15.76ZM5.12 0.899999L0.88 16.08L3.8 15.84L4.8 12.34L8.36 12.02L9.42 15.56L12.44 15.3L8.1 0.64L5.12 0.899999ZM5.5 9.42C5.75333 8.59333 5.96 7.80667 6.12 7.06C6.29333 6.31333 6.44 5.56667 6.56 4.82H6.64C6.74667 5.55333 6.88 6.27333 7.04 6.98C7.21333 7.67333 7.42 8.42 7.66 9.22L5.5 9.42Z"
                ></path>
              </svg>
            </span>
            <span class="d">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 18"
                height="18"
                width="14"
                class="letter"
              >
                <path
                  fill="black"
                  d="M0.28 16.24V1.04L4.44 0.679999C4.61333 0.666666 4.78 0.66 4.94 0.66C5.1 0.646666 5.24667 0.64 5.38 0.64C6.11333 0.64 6.76667 0.726666 7.34 0.899999C7.92667 1.07333 8.56667 1.32667 9.26 1.66C10.1933 2.08667 10.9533 2.61333 11.54 3.24C12.1267 3.85333 12.56 4.61333 12.84 5.52C13.12 6.41333 13.26 7.50667 13.26 8.8C13.26 10.4933 12.9733 11.92 12.4 13.08C11.84 14.24 11.0667 15.1333 10.08 15.76C9.09333 16.3733 7.95333 16.74 6.66 16.86L2.28 17.24L0.28 16.24ZM4.64 15.68C5.89333 15.5733 7 15.2133 7.96 14.6C8.93333 13.9867 9.69333 13.1133 10.24 11.98C10.7867 10.8467 11.06 9.45333 11.06 7.8C11.06 5.53333 10.5733 3.80667 9.6 2.62C8.64 1.43333 7.21333 0.84 5.32 0.84C5.18667 0.84 5.04667 0.846666 4.9 0.859999C4.75333 0.859999 4.60667 0.866666 4.46 0.879999L0.48 1.22V16.02L4.64 15.68ZM3.5 3.9L4.08 3.86C4.22667 3.84667 4.36 3.84 4.48 3.84C4.61333 3.82667 4.74667 3.82 4.88 3.82C5.57333 3.82 6.14 3.94667 6.58 4.2C7.03333 4.45333 7.36667 4.88667 7.58 5.5C7.80667 6.11333 7.92 6.97333 7.92 8.08C7.92 9.65333 7.59333 10.8067 6.94 11.54C6.28667 12.26 5.4 12.6667 4.28 12.76L3.5 12.82V3.9ZM5.7 12.2C6.38 11.9067 6.88667 11.4333 7.22 10.78C7.55333 10.1133 7.72 9.21333 7.72 8.08C7.72 6.66667 7.52 5.65333 7.12 5.04C7.06667 5.02667 7.01333 5.02 6.96 5.02C6.90667 5.02 6.85333 5.02 6.8 5.02C6.68 5.02 6.56 5.02667 6.44 5.04C6.33333 5.04 6.22 5.04667 6.1 5.06L5.7 5.08V12.2Z"
                ></path>
              </svg>
            </span>
            <span class="ispan">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 6 17"
                height="18"
                width="6"
                class="letter i"
              >
                <path
                  fill="black"
                  d="M0.38 15.96V0.76L3.86 0.439999L5.86 1.44V16.64L2.38 16.94L0.38 15.96ZM0.58 0.94V15.74L3.66 15.46V0.66L0.58 0.94Z"
                ></path>
              </svg>
            </span>
            <span class="n">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 13 18"
                height="18"
                width="13"
                class="letter"
              >
                <path
                  fill="black"
                  d="M7.22 15.82L5.72 12.44V16.92L2.28 17.22L0.28 16.22V1.02L3.52 0.74L5.52 1.74L7 4.94V0.64L10.48 0.319999L12.48 1.32V16.54L9.22 16.82L7.22 15.82ZM7.2 0.819999V6.42C7.2 6.56667 7.20667 6.80667 7.22 7.14C7.23333 7.46 7.24667 7.8 7.26 8.16C7.28667 8.50667 7.30667 8.80667 7.32 9.06C7.33333 9.3 7.34 9.42 7.34 9.42L7.28 9.46C7.28 9.46 7.26 9.38667 7.22 9.24C7.19333 9.09333 7.14667 8.92 7.08 8.72C7.01333 8.50667 6.94 8.31333 6.86 8.14L3.4 0.959999L0.48 1.2V16L3.52 15.76V10.52C3.52 10.36 3.51333 10.0867 3.5 9.7C3.48667 9.31333 3.47333 8.90667 3.46 8.48C3.46 8.05333 3.45333 7.69333 3.44 7.4C3.42667 7.09333 3.42 6.94 3.42 6.94L3.48 6.92C3.48 6.92 3.51333 7.05333 3.58 7.32C3.66 7.57333 3.76667 7.84 3.9 8.12L7.4 15.62L10.28 15.36V0.539999L7.2 0.819999Z"
                ></path>
              </svg>
            </span>
            <span class="g">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 15 18"
                height="18"
                width="15"
                class="letter"
              >
                <path
                  fill="black"
                  d="M14.04 13.72C13.64 14.6533 12.9933 15.44 12.1 16.08C11.22 16.72 10.1333 17.0933 8.84 17.2C8.72 17.2133 8.6 17.22 8.48 17.22C8.36 17.22 8.24 17.22 8.12 17.22C7.12 17.22 6.16667 17.0467 5.26 16.7C4.36667 16.3533 3.57333 15.8333 2.88 15.14C2.18667 14.4333 1.64 13.54 1.24 12.46C0.84 11.38 0.64 10.1 0.64 8.62C0.64 7.48667 0.78 6.42667 1.06 5.44C1.34 4.44 1.74667 3.55333 2.28 2.78C2.82667 2.00667 3.48667 1.38667 4.26 0.92C5.03333 0.453333 5.90667 0.179999 6.88 0.0999997C6.96 0.0866657 7.04 0.0799987 7.12 0.0799987C7.2 0.0799987 7.28 0.0799987 7.36 0.0799987C8.33333 0.0799987 9.28 0.299999 10.2 0.74C11.1333 1.18 11.9467 1.78 12.64 2.54C13.3467 3.3 13.8467 4.16 14.14 5.12L11.76 6.46L12.04 6.44L14.04 7.44V13.72ZM5.9 7.16V10L8.98 9.74V11.46C8.80667 11.8067 8.52667 12.1067 8.14 12.36C7.76667 12.6 7.37333 12.7333 6.96 12.76C6.90667 12.7733 6.84667 12.78 6.78 12.78C6.72667 12.78 6.66667 12.78 6.6 12.78C5.73333 12.78 5.08 12.4333 4.64 11.74C4.2 11.0467 3.98 9.92 3.98 8.36C3.98 6.94667 4.20667 5.82 4.66 4.98C5.11333 4.14 5.84 3.68 6.84 3.6H7.06C7.60667 3.6 8.07333 3.76 8.46 4.08C8.86 4.4 9.14667 4.86667 9.32 5.48L11.9 4.02C11.6733 3.38 11.36 2.78 10.96 2.22C10.5733 1.64667 10.0867 1.18 9.5 0.819999C8.91333 0.459999 8.2 0.28 7.36 0.28C7.29333 0.28 7.22 0.28 7.14 0.28C7.06 0.28 6.98 0.286666 6.9 0.299999C5.63333 0.406666 4.54667 0.846666 3.64 1.62C2.73333 2.38 2.04 3.37333 1.56 4.6C1.08 5.81333 0.84 7.15333 0.84 8.62C0.84 10.14 1.06 11.4533 1.5 12.56C1.94 13.6667 2.56667 14.52 3.38 15.12C4.19333 15.72 5.16 16.02 6.28 16.02C6.37333 16.02 6.46 16.02 6.54 16.02C6.63333 16.02 6.72667 16.0133 6.82 16C8.07333 15.8933 9.12667 15.54 9.98 14.94C10.8467 14.3267 11.4733 13.5733 11.86 12.68V6.66L5.9 7.16ZM9.2 5.78C9.14667 5.59333 9.08667 5.42 9.02 5.26C8.95333 5.08667 8.88 4.93333 8.8 4.8C8.2 4.85333 7.70667 5.06667 7.32 5.44C6.94667 5.8 6.66667 6.29333 6.48 6.92L10.8 6.56L9.2 5.78ZM7.8 11.26L6.24 10.46C6.26667 10.9933 6.32 11.4133 6.4 11.72C6.49333 12.0133 6.62667 12.3 6.8 12.58C6.84 12.5667 6.88667 12.56 6.94 12.56C7.28667 12.5333 7.63333 12.4267 7.98 12.24C8.32667 12.04 8.59333 11.8067 8.78 11.54V11.14L7.8 11.26Z"
                ></path>
              </svg>
            </span>
        </div>          
    </div>

    <script>
        const player = new Plyr('video', {
            autoplay: true,
            muted: true,
            controls: ['play', 'pause', 'volume', 'mute', 'fullscreen']
        });

        const audioPlayer = new Plyr('audio', {
            autoplay: true,
            muted: true,
            controls: ['play', 'pause', 'volume', 'mute', 'fullscreen']
        });
    </script>

    <style>
        .filtered-column {
            background-color: #246ffa !important; /* Color de fondo para indicar filtro activo */
            color: white !important; /* Color del texto para mejor visibilidad */
            font-weight: bold !important; /* Resaltar el texto */
        }
    </style>

    
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'editProfileModal',
        'modalTitle' => 'Editar Perfil',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'editProfileTitle',
        'btnSaveId' => 'btnSaveEditProfile',
        'otherButtonsContainer' => 'buttonsContainerEditProfile'
    ]); ?>
        
    <?php echo $__env->renderComponent(); ?>

    
    <?php $__env->startComponent('components.modal-component',[
        'modalId' => 'filterModal',
        'modalTitleId' => 'filtroId',
        'modalTitle' => 'Filtro',
        'modalSize' => 'modal-md',
        'hideButton' => true,
        'otherButtonsContainer' => 'filterModalFooter',
        'modalBody' => 'filterInputContainer'
    ]); ?>

        <div class="row col-sm-12" id="showAccordeons">

        </div>
        
    <?php echo $__env->renderComponent(); ?>

    
    <?php $__env->startComponent('components.modal-component',[
        'modalId' => 'desfragmentarFormModal',
        'modalTitle' => 'Titulo del input',
        'modalSize' => 'modal-sm',
        'modalTitleId' => 'desfragmentarFormTitle',
        'btnSaveId' => 'saveDesfragmentarFormBtn',
        'modalTop' => true	
    ]); ?>

        <div class="form-row">
            <div class="col-sm-12" id="inputContainer"></div>
        </div>
        
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'showHistorialClienteModal',
        'modalTitle' => 'Historial de cliente',
        'modalTitleId' => 'showHistorialClienteModalLabel',
        'modalSize' => 'modal-xl',
        'hideButton' => true
    ]); ?>

        
        <div class="row col-sm-12" id="inputsLabelsContainer">
        </div>

        <div id="VentasGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>
        
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'createVentaModal',
        'modalTitle' => 'Crear Venta',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveVentaBtn',
        'disabledSaveBtn' => true,
        'hideButton' => true
    ]); ?>
        <?php echo $__env->make('admin.ventas.partials.create-edit-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'editVentaModal',
        'modalTitle' => 'Editar venta',
        'modalTitleId' => 'editVentaTitle',
        'modalSize' => 'modal-xl',
        'btnSaveId' => 'saveEditVentaBtn',
        'otherButtonsContainer' => 'buttonsContainerEditVenta',
        // 'disabledSaveBtn' => true
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

        <?php if(!isset($bancos)): ?>
            <?php
                $bancos = \App\Models\Banco::all();
            ?>
        <?php endif; ?>

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
                    <?php if(isset($bancos)): ?>
                        <?php $__currentLoopData = $bancos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($banco->idbanco); ?>"><?php echo e($banco->nameBanco); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>
            <input type="hidden" id="plazoId" name="plazoId">
            <input type="hidden" id="totalPlazo" name="totalPlazo">
            <input type="hidden" id="cobradoActual" name="cobradoActual">
        </form>
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component', [
        'modalId'    => 'modal-cliente-edit',
        'modalTitle' => 'Editar Cliente',
        'modalSize'  => 'modal-lg',
        'btnSaveId'  => 'btn-save-cliente-edit',
        'modalTitleId' => 'modalTitleEdit',
        'otherButtonsContainer' => 'buttonsContainerClienteEdit',
    ]); ?>

        <?php
            if (!isset($ciudades)) {
                $ciudades = \App\Models\Ciudad::all();
            }

            if (!isset($tiposClientes)) {
                $tiposClientes = \App\Models\TipoCliente::all();
            }

            if (!isset($bancos)) {
                $bancos = \App\Models\Banco::all();
            }

            if (!isset($users)) {
                $users = \App\Models\User::all();
            }

        ?>

        <form id="form-cliente-edit" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group required-field">
                                <label class="form-label" for="cif">CIF</label>
                                <input type="text" name="cif" id="cifEdit" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required-field">
                                <label class="form-label" for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombreEdit" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="apellido">Apellido</label>
                                <input type="text" name="apellido" id="apellidoEdit" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="telefonosContainerEdit">
                            </div>
                            <button type="button" class="btn btn-outline-primary" id="btnAddTelefonoEdit">Agregar otro telefono</button>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="direccion">Direccion</label>
                                <div class="d-flex justify-content-between">
                                    <input type="text" name="direccion" id="direccionEdit" class="form-control direccion" required>
                                    <button type="button" class="btn btn-outline-primary direccion-btnSearch" id="btnSearch">Buscar</button>
                                </div>
                                <div id="suggestions"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="codPostal">Código Postal</label>
                                <input type="text" name="codPostal" id="codPostalEdit" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="cidade_id">Ciudad</label>
                                <select name="cidades_id" id="cidade_idEdit" class="form-select" required>
                                    <option value="">seleccione una ciudad</option>
                                    <?php $__currentLoopData = $ciudades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ciudad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($ciudad->idCiudades); ?>"><?php echo e($ciudad->nameCiudad); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" id="emailEdit" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="agente">Agente</label>
                                <input type="text" name="agente" id="agenteEdit" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="tipoClienteId">Tipo de Cliente</label>
                                <select name="tipoClienteId" id="tipoClienteIdEdit" class="form-select" required>
                                    <option value="">Tipo de cliente</option>
                                    <?php $__currentLoopData = $tiposClientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tipo->idTiposClientes); ?>"><?php echo e($tipo->nameTipoCliente); ?> | descuento: <?php echo e($tipo->descuento); ?>%</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="banco_id">Banco</label>
                                <select name="banco_id" id="banco_idEdit" class="form-select" required>
                                    <option value="">Seleccione un banco</option>
                                    <?php $__currentLoopData = $bancos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($banco->idbanco); ?>"><?php echo e($banco->nameBanco); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small class="text-muted createBancoFast">¿no encuentras el banco? crearlo aquí</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="sctaContable">Cuenta Contable</label>
                                <input type="text" name="sctaContable" id="sctaContableEdit" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="observaciones">Observaciones</label>
                                <textarea name="observaciones" id="observacionesEdit" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="user_id">Usuario</label>
                                <select name="user_id" id="user_idEdit" class="user_id p-3 form-select">
                                    <option selected value="">Ninguno</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> | <?php echo e($user->email); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small class="text-muted mb-2 createUserFast">¿quieres crearle un usuario a este cliente? Click aqui</small>
                                <small class="text-muted">Se selecciona un usuario si el cliente está registrado en el aplicativo</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
    <?php echo $__env->renderComponent(); ?>

    <!-- Modal para Editar Compra -->
    <?php $__env->startComponent('components.modal-component', [
        'modalId' => 'modalEditCompra',
        'modalTitle' => 'Editar Compra',
        'modalSize' => 'modal-xl',
        'modalTitleId' => 'editCompraTitle',
        'btnSaveId' => 'btnSaveEditCompra'
    ]); ?>
        
        <?php
            if (!isset($empresas)) {
                $empresas = \App\Models\Empresa::all();
            }

            if (!isset($proveedores)) {
                $proveedores = \App\Models\Proveedor::all();
            }
        ?>

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
        'modalId' => 'modalCreatePlazo',
        'modalTitle' => 'Crear Plazo',
        'modalSize' => 'modal-lg',
        'modalTitleId' => 'createPlazoTitle',
        'btnSaveId' => 'btnSaveCreatePlazo',
        'otherButtonsContainer' => 'buttonsContainerCreatePlazo'
    ]); ?>

        <?php
            if (!isset($bancos)) {
                $bancos = \App\Models\Banco::all();
            }
        ?>

        <form id="formCreatePlazo">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control" id="fechaPago" name="fechaPago" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="banco">Banco</label>
                        <select class="form-select" id="banco" name="banco" required>
                            <?php if(isset($bancos)): ?>
                                <?php $__currentLoopData = $bancos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($banco->idbanco); ?>"><?php echo e($banco->nameBanco); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="monto">Monto</label>
                        <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="observaciones">Notas</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </form>
        
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.modal-component',[
        'modalId' => 'addOrdersModal',
        'modalTitleId' => 'addOrdersModaltitle',
        'modalTitle' => 'Agregar Ordenes',
        'btnSaveId' => 'btnSaveOrders',
        'modalSize' => 'modal-xl',
        'hideButton' => true,
    ]); ?>

        <div class="form-group">
            <label class="form-label" for="orderName">Partes de trabajo</label>
            <select class="form-select" id="orderName" name="orderName[]">
            </select>
        </div>
        <hr>
        <h5>Partes del Proyecto:</h5>
        <div id="ordersContainer" 
            class="form-group d-flex flex-column gap-2" 
            style="max-height: 350px; overflow-y: auto; overflow-x: hidden;">

        </div>
    <?php echo $__env->renderComponent(); ?>

    <style>
        /* Asegura que el contenedor de desplazamiento horizontal permita la visualización */
        .dt-scroll-head, .dt-scroll-body {
            overflow: auto; /* Permitir desplazamiento */
        }

        /* Asegura que las barras de desplazamiento no se oculten */
        .dt-scroll-headInner {
            width: auto !important; /* Ajustar el ancho según el contenido */
        }

        /* Estilo adicional para la barra de desplazamiento personalizada */
        .customScroll {
            height: 10px;
            background-color: #888;
            border-radius: 5px;
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: 9999;
            transition: width 0.2s ease-in-out;
        }

        /* Asegura que el ancho del contenedor sea suficiente para el contenido */
        .dt-scroll-headInner {
            box-sizing: content-box;
            width: 100%;  /* Debería adaptarse al contenido */
        }

        td:focus {
            outline: 2px solid #00f; /* Resaltar la celda con un borde azul */
            background-color: #e0e0e0; /* Cambiar el color de fondo para resaltar */
        }

        .dropdown-menu {
            z-index: 1055 !important; /* Asegura que el menú esté sobre otros elementos */
            position: absolute !important;
        }

    </style>

    <style>
        #tableCard {
            background: rgba( 255, 255, 255, 0.7 );
            box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
            backdrop-filter: blur( 8.5px );
            -webkit-backdrop-filter: blur( 8.5px );
            border-radius: 10px;
            border: 1px solid rgba( 255, 255, 255, 0.18 );
            margin-top: 10px;
            border: 1px solid rgb(220,53,69);
            /* ocupar todo el alto de la pantalla */
            min-height: 100vh;
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

        #suggestions {
            border: 1px solid #ddd;
            max-height: 150px;
            overflow-y: auto;
            width: 300px;
            background: white;
            position: absolute;
            z-index: 1000;
        }
        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }
        .suggestion-item:hover {
            background-color: #f0f0f0;
        }

        .acciones-column{
            /* position: absolute !important; */
            z-index: 1 !important;
            overflow: visible !important;
        }

        .ag-center-cols-container{
            position: relative !important;
            z-index: 0 !important;
        }


        .actions-button-cell { 
            overflow:visible; 
        }

        .ag-row {
            z-index: 0;
        }

        .ag-row.ag-row-focus {
            z-index: 1;
        }

        .ag-root,
        .ag-body-viewport,
        .ag-body-viewport-wrapper {
            overflow: scroll !important;
            font-size: clamp(0.6rem, 1.5vw, 1rem);
        }

        .dropdown-menu{
            font-size: clamp(0.6rem, 1.5vw, 1rem);
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
 
    </style>

    <script>

        const globalBaseUrl = "<?php echo e(asset('')); ?>"

        // Probando la libreria AG GRID (table)

        function fastEditForm(table, name) {
            table.off('dblclick', '.openqQuickEdit').on('dblclick', '.openqQuickEdit', function(event) {
                const parteId = $(this).data('parteid');
                const fieldName = $(this).data('fieldname');
                const fieldType = $(this).data('type');

                // Lee siempre el valor actualizado del atributo data-fulltext
                const fullText = $(this).attr('data-bs-original-title');

                $('#desfragmentarFormModal #desfragmentarFormTitle').html(`Editar ${fieldName} de ${name} #${parteId}`);
                $('#desfragmentarFormModal #inputContainer').empty();

                let inputElement;
                switch (fieldType) {
                    case 'textarea':
                    case 'text':
                        inputElement = $(`<textarea class="form-control" id="edit${fieldName}Textarea" rows="3">${fullText}</textarea>`);
                        break;
                    case 'date':
                    
                        // verificar en que formato esta la fecha
                        if (fullText.includes('/')) {
                            const formattedDate = moment(fullText, 'DD/MM/YYYY').format('YYYY-MM-DD');
                            inputElement = $(`<input type="date" class="form-control" id="edit${fieldName}Input" value="${formattedDate}" />`);
                        } else {
                            inputElement = $(`<input type="date" class="form-control" id="edit${fieldName}Input" value="${fullText}" />`);
                        }
                        break;
                    case 'time':
                        inputElement = $(`<input type="time" class="form-control" id="edit${fieldName}Input" value="${fullText}" />`);
                        break;
                    case 'select':
                        inputElement = $(`<select class="form-control" id="edit${fieldName}Select"></select>`);
                        inputElement.append(`<option value="opcion1">Opción 1</option>`);
                        inputElement.append(`<option value="opcion2">Opción 2</option>`);
                        break;
                    default:
                        inputElement = $(`<input type="text" class="form-control" id="edit${fieldName}Input" value="${fullText}" />`);
                }
                $('#desfragmentarFormModal #inputContainer').append(inputElement);

                $('#desfragmentarFormModal').modal('show');

                // Asegurarse de que el evento solo se registre una vez
                $('#desfragmentarFormModal #saveDesfragmentarFormBtn').off('click').on('click', function() {
                    let editedValue = (fieldType === 'select')
                        ? $(`#edit${fieldName}Select`).val()
                        : $(`#edit${fieldName}Input, #edit${fieldName}Textarea`).val();

                    $.ajax({
                        url: "<?php echo e(route('admin.partes.SoloUnCampo')); ?>",
                        method: 'POST',
                        data: {
                            id: parteId,
                            fieldName: fieldName,
                            value: editedValue,
                            name,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            const newValue = response.updatedValue;

                            showToast('Cambios guardados exitosamente', 'success');

                            const tdElement = $(`td[data-fieldname="${fieldName}"][data-parteid="${parteId}"]`);

                            const palabraFormatted = acortarPalabra(newValue, 10);

                            tdElement.text(palabraFormatted);

                            tdElement.attr('data-fulltext', newValue);
                            tdElement.attr('title', newValue);
                            tdElement.attr('data-original-title', newValue);
                            tdElement.attr('data-bs-original-title', newValue);

                            $('#desfragmentarFormModal').modal('hide');
                        },
                        error: function(error) {
                            showToast('Error al guardar los cambios', 'danger');
                        }
                    });
                });
            });
        }

        function getClientesFromBd(){
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "<?php echo e(route('admin.clientes.getClientes')); ?>",
                    method: 'GET',
                    success: function(response) {
                        resolve(response.clientes);
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }

        function getProveedoresFromBd(){
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "<?php echo e(route('admin.proveedores.getProveedores')); ?>",
                    method: 'GET',
                    success: function(response) {
                        resolve(response.proveedores);
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }

        function getProjectsFromBd(){
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "<?php echo e(route('admin.projects.getAllApi')); ?>",
                    method: 'GET',
                    success: function(response) {
                        resolve(response.projects);
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }
        
        class CustomButtonComponent {
            eGui;
            eButton;
            eventListener;

            init() {
                // Crear el contenedor del botón y del menú dropdown
                this.eGui = document.createElement("div");
                this.eGui.className = "btn-group";
                this.eGui.setAttribute("data-bs-toggle", "tooltip");
                this.eGui.setAttribute("data-bs-placement", "top");
                this.eGui.setAttribute("title", "Acciones");

                // Botón principal con icono de rueda
                this.eButton = document.createElement("button");
                this.eButton.type = "button";
                this.eButton.className = "btn btn-dark dropdown-toggle btn-sm";
                this.eButton.setAttribute("data-bs-toggle", "dropdown");
                this.eButton.setAttribute("aria-expanded", "false");

                // Si hay un id, lo asignamos
                if (id) {
                    this.eButton.setAttribute("id", id);
                }

                // Si está deshabilitado, lo añadimos
                if (disabled) {
                    this.eButton.setAttribute("disabled", "true");
                }

                // Añadir el icono de rueda (ion-icon)
                const icon = document.createElement("ion-icon");
                icon.setAttribute("name", "settings-outline");
                this.eButton.appendChild(icon);

                this.eGui.appendChild(this.eButton);

                // Menú desplegable con los botones pasados como argumento
                const dropdownMenu = document.createElement("ul");
                dropdownMenu.className = "dropdown-menu p-3 align-items-md-start dropdown-menuActions position-relative";

                // Crear contenedor para los botones dentro del dropdown
                const dropdownContent = document.createElement("div");
                dropdownContent.className = "d-flex flex-row justify-content-center-flex-wrap position-absolute z-10";
                dropdownContent.style.gap = "1rem";


                // Añadir el contenedor con los botones al menú desplegable
                dropdownMenu.appendChild(dropdownContent);

                // Añadir el menú desplegable al contenedor principal
                this.eGui.appendChild(dropdownMenu);

                // Inicializar Bootstrap Dropdown (esto habilita la funcionalidad del dropdown)
                new bootstrap.Dropdown(this.eButton);

                // Retornar el contenedor con el dropdown
                return this.eGui;
            }

            getGui() {
                return this.eGui;
            }

            refresh() {
                return true;
            }

            destroy() {
                if (this.eButton) {
                    this.eButton.removeEventListener("click", this.eventListener);
                }
            }
        }

        document.addEventListener('shown.bs.dropdown', function (event) {
            const dropdownMenu = event.target.nextElementSibling;

            // Solo recalcular la posición si es necesario
            const rect = event.target.getBoundingClientRect();
            dropdownMenu.style.top = `${rect.bottom}px`;
            dropdownMenu.style.left = `${rect.left}px`;
            dropdownMenu.style.position = 'absolute';
            dropdownMenu.style.zIndex = '9999';
        });

        async function armarCabecerasDinamicamente(cabeceras, fieldNamePersonalizado = false) {
            let cabecerasAG = [];
            let id = '';
            let principalField = '';

            for (const cabecera of cabeceras) {
                // Definir la columna básica con propiedades comunes
                let columna = '';   

                if (cabecera.principal) {
                    principalField = cabecera.fieldName;
                }

                // verificar si el nombre de la columna es Acciones
                if (cabecera.name === 'Acciones') {
                    columna = {
                        headerName: cabecera.name,
                        field: cabecera.name,
                        filter: false,
                        sortable: false,
                        resizable: true,
                        suppressSizeToFit: true,
                        width: 250,
                        flex: 1,
                        minWidth: 100,
                        // menuTabs: ['filterMenuTab', 'generalMenuTab', 'columnsMenuTab'],
                        cellRenderer: function(params) {
                            return params.value; // Renderiza el HTML que enviaste en `Acciones`
                        },
                        suppressAutoSize: true,
                    };
                }else{
                    columna = {
                        headerName: cabecera.name,
                        field: (fieldNamePersonalizado) ? cabecera.fieldName : cabecera.name,
                        filter: 'agTextColumnFilter',
                        sortable: true,
                        resizable: true,
                        suppressSizeToFit: true,
                        width: 150,
                        flex: 1,
                        fieldName: cabecera.fieldName ?? '',
                        fieldType: cabecera.fieldType ?? '',
                        minWidth: 100,
                        enableCellTextSelection: true,
                        // menuTabs: ['filterMenuTab', 'generalMenuTab', 'columnsMenuTab'],
                        cellStyle: (params) => {
                            let type = '';

                            // Detectar el tipo basado en el valor de params
                            if (params.value) {
                                type = typeof params.value;

                                // Verificar si el string es una fecha
                                if (type === 'string' && moment(params.value, 'YYYY-MM-DD', true).isValid()) {
                                    type = 'date';
                                }
                                // Verificar si el string es un timestamp o datetime
                                else if (type === 'string' && moment(params.value, 'YYYY-MM-DD HH:mm:ss', true).isValid()) {
                                    type = 'datetime';
                                }
                                // Verificar si el string es un número
                                else if (type === 'string' && !isNaN(params.value)) {
                                    type = 'number';
                                }
                                // Verificar si el string incluye un porcentaje
                                else if (type === 'string' && params.value.includes('%')) {
                                    type = 'percentage';
                                }
                                // Verificar si el string es un booleano
                                else if (type === 'string' && (params.value === 'true' || params.value === 'false')) {
                                    type = 'boolean';
                                }
                                // Verificar si el string contiene símbolos monetarios
                                else if (type === 'string' && (params.value.includes('$') || params.value.includes('€'))) {
                                    type = 'money';
                                }

                                // verificar si es 0
                                else if (type === 'string' && params.value === '0') {
                                    type = '0';
                                }

                            }

                            // Estilos personalizados basados en valores específicos
                            const statusStyles = {
                                'Pendiente': { color: '#ffc107', fontWeight: 'bold' },
                                'En proceso': { color: '#0d6efd', fontWeight: 'bold' },
                                'En Proceso': { color: '#0d6efd', fontWeight: 'bold' },
                                'Finalizado': { color: '#198754', fontWeight: 'bold' },
                                'No vendido': { color: '#dc3545', fontWeight: 'bold' },
                                'Vendido': { color: '#198754', fontWeight: 'bold' },
                                'Facturado': { color: '#198754', fontWeight: 'bold' },
                                'Albarán': { color: '#0d6efd', fontWeight: 'bold' },
                                'Factura': { color: '#198754', fontWeight: 'bold' },
                                'Presupuesto': { color: '#ffc107', fontWeight: 'bold' }
                            };

                            if (params.value in statusStyles) {
                                return statusStyles[params.value];
                            }

                            // Estilos generales basados en el tipo
                            switch (type) {
                                case 'number':
                                case 'money':
                                    return { textAlign: 'right' };
                                case 'date':
                                case 'datetime':
                                    return { textAlign: 'center' };
                                case 'percentage':
                                    return { textAlign: 'right' };
                                case 'boolean':
                                    return { textAlign: 'center' };
                                case '0':
                                    return { textALign: 'right' };
                                    
                                default:
                                    return null;
                            }
                        },
                    };

                    if (cabecera.principal) {
                        columna.sort = 'desc';
                    }

                    if (cabecera.editable) {
                        columna.editable = true;
                    }

                }

                if (cabecera.name === 'Enlace' || cabecera.name === 'Link' || cabecera.name === 'URL' || cabecera.name === 'enlace') {
                    columna.cellRenderer = function(params) {
                        return `<a class="link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="${params.value}" target="_blank">
                            <div class="w-100 d-flex justify-content-center align-items-center flex-row" style="font-size: clamp(0.6rem, 1.5vw, 1rem);">
                                <ion-icon name="link-outline"></ion-icon>
                                <small class="ms-2">Abrir</small>
                            </div>
                        </a>`;
                    };
                }

                if (cabecera.fieldName == 'cliente_id') {
                    cabecera.className = 'OpenHistorialCliente';
                    // aplicar estilos de subrayado
                    columna.cellStyle = { 'text-decoration': 'underline', 'cursor': 'pointer' };
                }

                // Asignar clase personalizada, si existe
                if (cabecera.className) {
                    columna.cellClass = cabecera.className;
                }

                // Configurar la columna de cliente con datos asincrónicos
                // if (cabecera.name === 'Cliente') {
                //     try {
                //         const clientes = await getClientesFromBd();

                //         const clienteOptions = clientes.map(cliente => ({
                //             value: cliente.idClientes,
                //             label: cliente.NombreCliente + ' ' + cliente.ApellidoCliente
                //         }));

                //         const clienteValueMap = clienteOptions.reduce((map, option) => {
                //             map[option.value] = option.label;
                //             return map;
                //         }, {});

                //         columna.cellEditor = 'agSelectCellEditor';
                //         columna.fieldName = 'cliente_id';
                //         columna.cellEditorParams = {
                //             values: clienteOptions.map(option => option.label),
                //             formatValue: (value) => clienteValueMap[label] || value,
                //         };

                //         columna.cellRenderer = (params) => {
                //             return clienteValueMap[params.label] || ''; // Mostrar nombres en lugar de IDs
                //         };

                //         columna.editable = true;

                //     } catch (error) {
                //         console.error('Error cargando clientes: ', error);
                //     }
                // }
                // configurar la columna de proyectos con datos asincrónicos
                if (cabecera.name === 'Proyecto') {
                    try {
                        const proyectos = await getProjectsFromBd();

                        const proyectosOptions = proyectos.map(proyecto => ({
                            value: proyecto.idProyecto,
                            label: proyecto.name
                        }));

                        const clienteValueMap = proyectosOptions.reduce((map, option) => {
                            map[option.value] = option.label;
                            return map;
                        }, {});

                        columna.cellEditor = 'agSelectCellEditor';
                        columna.fieldName = 'proyecto_id';
                        columna.cellEditorParams = {
                            values: proyectosOptions.map(option => option.label),
                            formatValue: (value) => clienteValueMap[label] || value,
                        };

                        columna.cellRenderer = (params) => {
                            return clienteValueMap[params.label] || ''; // Mostrar nombres en lugar de IDs
                        };

                        columna.editable = true;

                        // estilo de la celda ya que el nombre del proyecto es muy largo
                        columna.cellStyle = { 'white-space': 'normal' };

                    } catch (error) {
                        console.error('Error cargando clientes: ', error);
                    }
                }

                // configurar la columna de proveedor con datos asincrónicos
                if (cabecera.name === 'Proveedor') {
                    const proveedores = await getProveedoresFromBd();

                    const proveedorOptions = proveedores.map(proveedor => ({
                        value: proveedor.idProveedor,
                        label: proveedor.nombreProveedor
                    }));

                    const proveedorValueMap = proveedorOptions.reduce((map, option) => {
                        map[option.value] = option.label;
                        return map;
                    }, {});

                    columna.cellEditor = 'agSelectCellEditor';
                    columna.fieldName = 'proveedor_id';
                    columna.cellEditorParams = {
                        values: proveedorOptions.map(option => option.label),
                        allowTyping: true,
                        filterList: true,
                        highlightMatch: true,
                        formatValue: (value) => proveedorValueMap[label] || value,
                    };

                    columna.cellRenderer = (params) => {
                        return proveedorValueMap[params.label] || ''; // Mostrar nombres en lugar de IDs
                    };

                    columna.editable = true; 
                }

                if (cabecera.type === 'image') {
                    columna.cellRenderer = function(params) {
                        // verificar si viene diferente de null
                        const cellValue = params.value;

                        if (cellValue != '' ) {
                            return `<img src="${params.value}" alt="imagen" style="width: 70px; height: 70px;" />`;
                        } else {
                            return '';
                        }
                    };
                }

                // verificar si se puede editar y el campo (fieldType) es un tipo date
                if (cabecera.editable && cabecera.fieldType === 'date' || cabecera.fieldType === 'timestamp') {
                    columna.cellEditor = 'agDateCellEditor';
                    columna.filter = 'agDateColumnFilter';

                    // Configurar el comparador para fechas en formato 'YYYY-MM-DD'
                    columna.filterParams = {
                        browserDatePicker: true,
                        comparator: function(filterLocalDateAtMidnight, cellValue) {
                            if (!cellValue) {
                                return 0; // Si no hay valor, no se filtra
                            }

                            // Convertir la fecha de la celda (YYYY-MM-DD) a un objeto Date
                            const cellDate = moment(cellValue, 'YYYY-MM-DD').toDate();

                            if (filterLocalDateAtMidnight.getTime() === cellDate.getTime()) {
                                return 0;
                            }
                            return cellDate < filterLocalDateAtMidnight ? -1 : 1;
                        },
                    };

                    // Opcional: Formatear el valor mostrado al usuario en el formato 'DD/MM/YYYY'
                    columna.valueFormatter = function(params) {
                        if (!params.value) return ''; // Si no hay valor, devolver una cadena vacía.

                        let dateValue;

                        // Verificar si el valor es un objeto Date o una cadena
                        if (params.value instanceof Date) {
                            dateValue = moment(params.value); // Convertir el objeto Date a moment
                        } else if (typeof params.value === 'string') {
                            dateValue = moment(params.value, [moment.ISO_8601, 'YYYY-MM-DD', 'DD/MM/YYYY'], true);
                        } else {
                            return params.value; // Devolver el valor original si no es reconocible como fecha
                        }

                        return dateValue.isValid() ? dateValue.format('DD/MM/YYYY') : params.value;
                    };

                    columna.valueParser = function(params) {
                        if (!params.newValue) return null; // Si no hay valor, devolver null.

                        const parsedDate = moment(params.newValue, ['DD/MM/YYYY', 'YYYY-MM-DD'], true);
                        return parsedDate.isValid() ? parsedDate.format('YYYY-MM-DD') : params.newValue;
                    };

                }

                // Si se deben agregar atributos 'data-' o customDatasets, configurar el cellRenderer
                if (cabecera.addAttributes || cabecera.attrclassName || cabecera.styles ) {
                    columna.cellRenderer = function (params) {
                        const cellValue = params.value;
                        const attributes = cabecera.dataAttributes || {};
                        const styles = cabecera.styles || {};
                        // buscar la columna con principalField
                        const columnaPrincipal = cabeceras.find(cabecera => cabecera.fieldName === principalField);
                        // obtener el valor de la columna principal
                        const parteId = params.data[columnaPrincipal.name];
                        let cellContent = `
                            <span 
                                data-parteid="${parteId}"
                                class="${ (cabecera.attrclassName) ? cabecera.attrclassName : '' }" 
                                ${Object.entries(attributes).map(([key, value]) => `${key}="${cellValue}"`).join(' ')}
                                style="${ (cabecera.styles) ? Object.entries(styles).map(([key, value]) => `${key}:${value};`).join(' ') : '' }"
                            >
                                ${(cellValue) ? cellValue : ''}
                            </span>`;
                        return cellContent;
                    };
                }

                // Agregar la columna configurada al arreglo final
                cabecerasAG.push(columna);
            }

            return cabecerasAG;
        }

        const traduccionAGGrid = {
            // Traducción para las opciones de filtrado
            // Filtros
            filterOoo: 'Filtrar...',
            equals: 'Es igual a',
            notEqual: 'No es igual a',
            lessThan: 'Menor que',
            greaterThan: 'Mayor que',
            contains: 'Contiene',
            notContains: 'No contiene',
            startsWith: 'Empieza con',
            endsWith: 'Termina con',
            // Filtro de texto
            filter: 'Filtrar',
            // Menú de ordenar
            sortAscending: 'Ordenar ascendente',
            sortDescending: 'Ordenar descendente',
            // Menú de acciones
            columnMenu: 'Menú de columna',
            // Menú contextual
            resetColumns: 'Restablecer columnas',
            pinColumn: 'Fijar columna',
            valueAggregation: 'Agregación de valor',
            // Más traducciones si es necesario
            selectAll: 'Seleccionar todo',
            clearFilter: 'Limpiar filtro',
            apply: 'Aplicar',
            cancel: 'Cancelar',
            // Otros
            noRowsToShow: 'No hay filas para mostrar',
            loadingOoo: 'Cargando...',
            page: 'Página',
            more: 'Más',
            less: 'Menos',
            blank: 'En blanco',
            NotBlank: 'No en blanco',
            Between: 'Entre',
            After: 'Después',
            Before: 'Antes',
            Equals: 'Igual a',
            DoesNotEqual: 'No igual a',
            // Para las fechas
            dateFormatOoo: 'yyyy-mm-dd',
            // Para las columnas
            columns: 'Columnas',
            // Para las filas
            rowGroupColumnsEmptyMessage: 'Arrastre aquí para agrupar',
            // Para los grupos
            valueColumnsEmptyMessage: 'Arrastre aquí para agregar',
            pivotColumnsEmptyMessage: 'Arrastre aquí para pivotar',
            // Para los valores
            valueColumnsEmptyMessage: 'Arrastre aquí para agregar',
            pivotColumnsEmptyMessage: 'Arrastre aquí para pivotar',
            // Para los filtros
            noFilter: 'Sin filtro',
            // Para las columnas
            columns: 'Columnas',
            inRange: 'En rango',
        };

        function inicializarAGtable(elemento, datos, cabeceras, titulo, customButtons, model, itinerario = false, mostrarFinalizadosBtn = null) {
            let opcionesDeLaTablaGlobal = {};

            const contenedorTabla = document.createElement("div");
            contenedorTabla.className = "ag-table-container";

            // Crear y añadir título y botones
            const headerContainer = document.createElement("div");
            headerContainer.className = "d-flex justify-content-between align-items-center mb-3 flex-wrap";
            const elementoTitulo = document.createElement("h3");
            elementoTitulo.className = "table-title mb-0"; 
            elementoTitulo.textContent = titulo || "Título Personalizado";
            const customButtonsContainer = document.createElement("div");
            customButtonsContainer.className = "d-flex gap-2 flex-wrap";

            customButtonsContainer.insertAdjacentHTML('beforeend', customButtons);
            const resetButton = document.createElement("button");
            resetButton.className = "btn btn-outline-danger";
            resetButton.textContent = "Limpiar filtros";
            const resetColumnButton = document.createElement("button");
            resetColumnButton.className = "btn btn-outline-dark";
            resetColumnButton.textContent = "Restaurar columnas";

            // si itinerario es diferente de false
            let itinerarioButton = '';
            if (itinerario) {
                itinerarioButton = document.createElement("button");
                itinerarioButton.className = "btn btn-outline-primary";
                itinerarioButton.textContent = "Itinerario";
                customButtonsContainer.appendChild(itinerarioButton);
            }

            let mostrarFinalizadosButton = '';
            // si mostrarFinalizadosBtn es diferente de null
            if (mostrarFinalizadosBtn) {
                // Crear el contenedor para el checkbox y su etiqueta
                const checkboxContainer = document.createElement("div");
                checkboxContainer.className = "form-check";

                // Crear el checkbox
                const mostrarFinalizadosCheckbox = document.createElement("input");
                mostrarFinalizadosCheckbox.type = "checkbox";
                mostrarFinalizadosCheckbox.className = "form-check-input";
                mostrarFinalizadosCheckbox.id = "mostrarFinalizadosCheckbox";

                // Crear la etiqueta para el checkbox
                const checkboxLabel = document.createElement("label");
                checkboxLabel.className = "form-check-label";
                checkboxLabel.htmlFor = "mostrarFinalizadosCheckbox";
                checkboxLabel.textContent = "Mostrar finalizados";

                // Agregar el checkbox y la etiqueta al contenedor
                checkboxContainer.appendChild(mostrarFinalizadosCheckbox);
                checkboxContainer.appendChild(checkboxLabel);

                // Agregar el contenedor al contenedor de botones personalizados
                customButtonsContainer.appendChild(checkboxContainer);
            }


            customButtonsContainer.appendChild(resetButton);
            customButtonsContainer.appendChild(resetColumnButton);
            headerContainer.appendChild(elementoTitulo);
            headerContainer.appendChild(customButtonsContainer);
            contenedorTabla.appendChild(headerContainer);
            elemento.appendChild(contenedorTabla);

            const filtrosGuardados = obtenerFiltrosGuardados(titulo);
            const estadoColumnasGuardado = obtenerEstadoColumnasGuardado(titulo);

            // Historial de cambios
            let cambiosHistorial = [];
            let preventCellValueChanged = false;


            const opcionesDeLaTabla = {
                columnDefs: cabeceras,
                defaultColDef: {
                    flex: 1,
                    filter: true,
                    sortable: true,
                    resizable: true,
                },
                rowData: datos,
                pagination: true,
                paginationPageSize: 100,
                onCellValueChanged: function(event) {

                    if (preventCellValueChanged) {
                        preventCellValueChanged = false; // Reiniciar la bandera y evitar doble ejecución.
                        return;
                    }

                    const parteId = event.data.ID;
                    let value = event.newValue;
                    const fieldName = event.colDef.fieldName;
                    
                    // Manejar campos de tipo fecha
                    if (event.colDef.fieldType === 'date' || event.colDef.fieldType === 'timestamp') {
                        if (typeof value === 'string' && value.includes('GMT')) {
                            // Convertir desde formato largo de fecha a 'YYYY-MM-DD'
                            value = moment(value).format('YYYY-MM-DD');
                        } else if (moment(value, 'DD/MM/YYYY', true).isValid()) {
                            // Convertir desde formato 'DD/MM/YYYY' a 'YYYY-MM-DD'
                            value = moment(value, 'DD/MM/YYYY').format('YYYY-MM-DD');
                        } else if (!moment(value, 'YYYY-MM-DD', true).isValid()) {
                            showToast('Formato de fecha inválido', 'danger');
                            event.node.setDataValue(fieldName, event.oldValue);
                            return;
                        } else if (!moment(value, 'YYYY-MM-DD', true).isValid() || !value) {
                            // Si el nuevo valor no es válido o está vacío, restaurar el valor anterior
                            showToast('Formato de fecha inválido o sin cambios detectados. Restaurando valor original.', 'warning');
                            event.node.setDataValue(fieldName, event.oldValue);
                            return;
                        }
                    }

                    // Guardar cambio en historial
                    cambiosHistorial.push({
                        id: parteId,
                        fieldName: fieldName,
                        oldValue: event.oldValue,
                        newValue: value,
                        rowData: event.data,
                        column: event.colDef,
                        user: "<?php echo e(auth()->user()->name); ?>", // Guardar el nombre del usuario que hizo el cambio
                    });

                    let payload = {};
                    // verificar si el campo que quiero actualizar proviene del model Modelo347
                    if (model === 'Modelo347') {
                        let numberTrim = '';
                        const getTrimestre = (event.data.unotrim !== '' && event.data.unotrim !== '0') 
                            ? numberTrim = 1 
                            : (event.data.dostrim !== '' && event.data.dostrim !== '0') 
                                ? numberTrim = 2 : 
                                    (event.data.trestrim !== '' && event.data.trestrim !== '0') 
                                        ? numberTrim = 3 : 
                                            (event.data.cuatrotrim !== '' && event.data.cuatrotrim !== '0') 
                                                ? numberTrim = 4 : '';

                                                
                        payload = {
                            cliente_id: event.data.ID,
                            empresa_id: event.data.Empresa,
                            trimestre: getTrimestre,
                            correo: event.data.correo,
                            year: event.data.year,
                            agente: event.data.agente,
                            notasmodelo347: event.data.notasmodelo347,
                        }
                    }

                    // Actualizar el valor en la tabla
                    try {
                        event.node.setDataValue(fieldName, value);
                    } catch (error) {
                        console.error('Error al actualizar el valor de la celda:', error);
                    }

                    // Enviar el cambio al servidor
                    $.ajax({
                        url: "<?php echo e(route('admin.partes.SoloUnCampo')); ?>",
                        method: 'POST',
                        data: {
                            id: parteId,
                            fieldName: fieldName,
                            value: value,
                            name: model,
                            payload,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            showToast('Cambios guardados exitosamente', 'success');
                        },
                        error: function() {
                            showToast('Error al guardar los cambios', 'danger');
                        }
                    });
                },
                onGridReady: function(params) {
                    params.api.sizeColumnsToFit();
                    opcionesDeLaTablaGlobal.params = params;

                    if (filtrosGuardados) {
                        params.api.setFilterModel(filtrosGuardados);
                    }

                    if (estadoColumnasGuardado) {
                        params.api.applyColumnState({
                            state: estadoColumnasGuardado,
                            applyOrder: true,
                        });
                    }

                    resetButton.addEventListener('click', function() {
                        params.api.setFilterModel(null);
                        localStorage.removeItem(`ag-grid-filters-${titulo}`);
                        document.cookie = `ag-grid-filters-${titulo}=;path=/;expires=Thu, 01 Jan 1970 00:00:00 UTC;`;
                        showToast('Filtros limpiados', 'success');
                    });

                    resetColumnButton.addEventListener('click', function() {
                        params.api.resetColumnState();
                        localStorage.removeItem(`ag-grid-column-state-${titulo}`);
                        document.cookie = `ag-grid-column-state-${titulo}=;path=/;expires=Thu, 01 Jan 1970 00:00:00 UTC;`;
                        showToast('Columnas restauradas', 'success');
                    });

                    if (itinerario) {
                        itinerarioButton.addEventListener('click', function () {
                            $('#showReportModalInAGGRID').modal('show');

                            $('#generateReportBtnAGGRID').off('click').on('click', function () {
                                // Capturar los valores de los inputs
                                let fechaInicio = $('#showReportModalInAGGRID #fechaInicio').val();
                                let fechaFin = $('#showReportModalInAGGRID #fechaFin').val();
                                let operario = $('#showReportModalInAGGRID #users_id').val();
                                let autorid  = $('#showReportModalInAGGRID #autorid').val();

                                // Verificar si los campos están vacíos
                                if (!fechaInicio || !fechaFin || !operario) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: 'Debes seleccionar fechas válidas y al menos un operario',
                                    });
                                    return;
                                }

                                // Convertir las fechas y ajustar horas
                                const fechaInicioParsed = new Date(`${fechaInicio}T00:00:00`);
                                let fechaFinParsed = new Date(`${fechaFin}T23:59:59`);

                                if (isNaN(fechaInicioParsed.getTime()) || isNaN(fechaFinParsed.getTime())) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error de formato',
                                        text: 'Las fechas ingresadas no son válidas.',
                                    });
                                    return;
                                }

                                // Si las fechas son iguales, ajustar la fecha de fin al final del día
                                if (fechaInicioParsed.toISOString().split('T')[0] === fechaFinParsed.toISOString().split('T')[0]) {
                                    fechaFinParsed = new Date(`${fechaInicio}T23:59:59`);
                                }

                                // Configurar modelo de filtro
                                let filterModel = {
                                    FechaVisita: {
                                        filterType: 'date',
                                        type: 'inRange',
                                        dateFrom: fechaInicioParsed.toISOString().split('T')[0], // Solo la fecha (YYYY-MM-DD)
                                        dateTo: fechaFinParsed.toISOString().split('T')[0],     // Solo la fecha (YYYY-MM-DD)
                                    },
                                };

                                if (operario !== '0') {
                                    // Agregar filtro por operario
                                    let operarioName = $('#showReportModalInAGGRID #users_id option:selected').text().trim();
                                    filterModel.Operarios = {
                                        filterType: 'text',
                                        type: 'contains',
                                        filter: operarioName,
                                    };
                                }

                                // verificar si el autorid es diferente de 0 o null
                                if (autorid !== '0' && autorid !== null) {
                                    // Agregar filtro por autor
                                    let autorName = $('#showReportModalInAGGRID #autorid option:selected').text().trim();
                                    filterModel.Autor = {
                                        filterType: 'text',
                                        type: 'contains',
                                        filter: autorName,
                                    };
                                }


                                // ordenar la columna Hinicio de forma ascendente
                                params.api.applyColumnState({
                                    state: [
                                        { colId: 'HInicio', sort: 'asc' }
                                    ],
                                });

                                // Aplicar modelo de filtro
                                params.api.setFilterModel(filterModel);

                                // Aplicar cambios de filtrado y ordenación
                                params.api.onFilterChanged();
                            });
                        });
                    }

                    if (mostrarFinalizadosBtn) {
                        // Agregar un evento al checkbox para manejar los filtros
                        mostrarFinalizadosCheckbox.addEventListener('change', function () {
                            // Obtener el estado actual del checkbox
                            const isChecked = !mostrarFinalizadosCheckbox.checked;

                            // Obtener el modelo de filtros actual
                            const filterModel = params.api.getFilterModel();

                            if (isChecked) {
                                // Activar el filtro de estado para excluir "Finalizado"
                                filterModel.Estado = {
                                    filterType: 'text',
                                    type: 'notContains',
                                    filter: 'Finalizado',
                                };
                            } else {
                                // Desactivar el filtro de estado
                                delete filterModel.Estado;
                                // actualizar el modelo de filtros en localStorage
                                localStorage.setItem(`ag-grid-filters-${titulo}`, JSON.stringify(filterModel));
                            }

                            // Aplicar los filtros
                            params.api.setFilterModel(filterModel);
                            params.api.onFilterChanged();
                        });
                    }

                    // Escuchar combinación de teclas Ctrl + Z
                    $(document).off('keydown').on('keydown', function(event) {
                        if ( 
                            event.ctrlKey && event.key === 'z' ||
                            event.ctrlKey && event.key === 'Z'
                        ) {
                            
                            // Verificar si hay cambios en el historial
                            if (cambiosHistorial.length > 0) {
                                // Obtener el último cambio
                                const ultimoCambio = cambiosHistorial[cambiosHistorial.length - 1];

                                // Evitar que se ejecute el evento onCellValueChanged
                                preventCellValueChanged = true;

                                try {
                                    // Restaurar el valor anterior en la tabla
                                    params.api.forEachNode(node => {
                                        if (node.data.ID === ultimoCambio.id) {
                                            // Obtener el nombre de la columna
                                            const column = ultimoCambio.column.field;

                                            // Restaurar el valor anterior
                                            node.setDataValue(column, ultimoCambio.oldValue);

                                            // Forzar la actualización de la celda para reflejar el valor restaurado
                                            params.api.refreshCells({ rowNodes: [node], force: true });
                                            
                                        }
                                    });
                                } catch (error) {
                                    console.error('Error al restaurar el valor de la celda:', error);
                                }

                                // Verificar si el cambio es de tipo fecha
                                if (ultimoCambio.column.fieldType === 'date' || ultimoCambio.column.fieldType === 'timestamp') {
                                    // Asegurarse de que la fecha esté correctamente formateada
                                    ultimoCambio.oldValue = moment(ultimoCambio.oldValue, 'DD/MM/YYYY').format('YYYY-MM-DD');
                                }

                                // Petición al servidor para sincronización
                                $.ajax({
                                    url: "<?php echo e(route('admin.partes.SoloUnCampo')); ?>",
                                    method: 'POST',
                                    data: {
                                        id: ultimoCambio.id,
                                        fieldName: ultimoCambio.fieldName,
                                        value: ultimoCambio.oldValue,
                                        name: model,
                                        _token: $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function() {
                                        showToast('Cambio deshecho exitosamente', 'success');
                                        preventCellValueChanged = false; // Restablecer la bandera una vez que la petición se haya completado
                                    },
                                    error: function() {
                                        showToast('Error al deshacer el cambio', 'danger');
                                        preventCellValueChanged = false; // Restablecer la bandera en caso de error
                                    }
                                });

                                // Eliminar el cambio del historial solo después de que se haya procesado
                                cambiosHistorial.pop(); // Mover esta línea después de la llamada a la petición AJAX
                            } else {
                                // Mostrar notificación si no hay más cambios para deshacer
                                showToast('No hay más cambios para deshacer', 'info');
                                new Audio('https://sebcompanyes.com/archivos/notify.mp3').play();
                            }
                        }
                    });

                    inicializarFuncionesPersonalizadas(params);

                },
                // evento para guardar el estado de las columnas
                onColumnMoved: function(event) {
                    const columnState = event.api.getColumnState();
                    guardarEstadoColumnas(columnState, titulo); // Llama a tu función para guardar el estado
                },
                // evento para guardar los filtros
                onFilterChanged: function(event) {
                    const filterModel = event.api.getFilterModel();
                    guardarFiltros(filterModel, titulo);
                },
                // enableCellTextSelection: true,
                // traducciones
                localeText: traduccionAGGrid,
            };

            agGrid.createGrid(elemento, opcionesDeLaTabla);
            opcionesDeLaTablaGlobal = opcionesDeLaTabla;
            return opcionesDeLaTablaGlobal;
        }

        function inicializarFuncionesPersonalizadas(params){
            function limpiarTabla(){
                setTimeout(() => {
                    const allDisplayedRows = [];
                    const rowCount = params.api.getDisplayedRowCount();

                    for (let i = 0; i < rowCount; i++) {
                        const rowNode = params.api.getDisplayedRowAtIndex(i);
                        if (rowNode) {
                            allDisplayedRows.push(rowNode.data);
                        }
                    }
            
                    // Eliminar todas las filas visibles
                    params.api.applyTransaction({ remove: allDisplayedRows });
                }, 100);
            }

            function agregarDatosDinamicos(datos){
                setTimeout(() => {
                    params.api.applyTransaction({ add: datos });
                }, 200);
            }
        }

        function obtenerFiltrosGuardados(name) {
            // Verificar si localStorage está disponible
            if (typeof localStorage !== "undefined") {
                const filtrosGuardados = localStorage.getItem(`ag-grid-filters-${name}`);
                return filtrosGuardados ? JSON.parse(filtrosGuardados) : null;
            } else {
                // Si localStorage no está disponible, usar cookies
                const cookies = document.cookie.split("; ");
                const cookieFiltro = cookies.find(cookie => cookie.startsWith(`ag-grid-filters-${name}=`));
                return cookieFiltro ? JSON.parse(decodeURIComponent(cookieFiltro.split("=")[1])) : null;
            }
        }

        function guardarEstadoColumnas(estado, titulo) {
            const estadoJSON = JSON.stringify(estado);
            
            // Guardar en localStorage si está disponible
            if (typeof localStorage !== "undefined") {
                localStorage.setItem(`ag-grid-column-state-${titulo}`, estadoJSON);
            } else {
                // Si no hay localStorage, guardar en cookies
                document.cookie = `ag-grid-column-state-${titulo}=${encodeURIComponent(estadoJSON)};path=/;max-age=31536000`; // 1 año
            }
        }

        function obtenerEstadoColumnasGuardado(titulo) {
            // Verificar si localStorage está disponible
            if (typeof localStorage !== "undefined") {
                const estadoColumnas = localStorage.getItem(`ag-grid-column-state-${titulo}`);
                return estadoColumnas ? JSON.parse(estadoColumnas) : null;
            } else {
                // Si localStorage no está disponible, usar cookies
                const cookies = document.cookie.split("; ");
                const cookieEstadoColumnas = cookies.find(cookie => cookie.startsWith(`ag-grid-column-state-${titulo}=`));
                return cookieEstadoColumnas ? JSON.parse(decodeURIComponent(cookieEstadoColumnas.split("=")[1])) : null;
            }
        }

        function guardarFiltros(filtros, name) {
            const filtrosJSON = JSON.stringify(filtros);
            
            // Guardar en localStorage si está disponible
            if (typeof localStorage !== "undefined") {
                localStorage.setItem(`ag-grid-filters-${name}`, filtrosJSON);
            } else {
                // Si no hay localStorage, guardar en cookies
                document.cookie = `ag-grid-filters-${name}=${encodeURIComponent(filtrosJSON)};path=/;max-age=31536000`; // 1 año
            }
        }

        document.addEventListener('click', function (event) {
            const dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(event.target)) {
                    const bsDropdown = new bootstrap.Dropdown(dropdown);
                    bsDropdown.hide();
                }
            });
        });

        // funcion para obtener los gridOptions segun el id de la tabla

        function limpiarTableAgGrid(gridOptions, nuevosDatos) {

            setTimeout(() => {
                const params = gridOptions.params;
                const allDisplayedRows = [];
                const rowCount = params.api.getDisplayedRowCount();

                for (let i = 0; i < rowCount; i++) {
                    const rowNode = params.api.getDisplayedRowAtIndex(i);
                    if (rowNode) {
                        allDisplayedRows.push(rowNode.data);
                    }
                }
        
                // Eliminar todas las filas visibles
                params.api.applyTransaction({ remove: allDisplayedRows });

                console.log('Tabla limpiada', allDisplayedRows);
                
            }, 100);
  
            setTimeout(() => {
                const params = gridOptions.params;
                // Agregar los nuevos datos a la tabla
                params.api.applyTransaction({ add: nuevosDatos });

                console.log('Datos agregados', nuevosDatos);

            }, 200);

        }

        let opcionesPersonalizadas;

        function inicializarVentasTable( datos, tabId = null, isModuleVentas = false){
            // Inicializar la tabla de citas
            const agTablediv = document.querySelector('#VentasGrid');

            let rowData = {};
            let data = [];

            let ventas;

            if (!isModuleVentas) {
                ventas = datos;
            }else{
                ventas = <?php if(isset($ventas)): ?> <?php echo json_encode($ventas, 15, 512) ?> <?php else: ?> [] <?php endif; ?>;
            }

            if (ventas.length <= 0) {
                ventas = datos;
            }

            const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
                { 
                    name: 'ID',
                    fieldName: 'Venta',
                    addAttributes: true, 
                    addcustomDatasets: true,
                    dataAttributes: { 
                        'data-id': ''
                    },
                    attrclassName: 'openEditVentaFast',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                    principal: true
                },
                { 
                    name: 'Fecha',
                    className: 'fecha-alta-column',
                    fieldName: 'FechaVenta',
                    fieldType: 'date',
                    editable: true,
                }, 
                { 
                    name: 'Emp',
                    // addAttributes: true,
                    // fieldName: 'NFacturaCompra',
                    // fieldType: 'textarea',
                    // dataAttributes: { 
                    //     'data-order': 'order-column' 
                    // },
                    // editable: true,
                    // attrclassName: 'openProjectDetails',
                    // styles: {
                    //     'cursor': 'pointer',
                    //     'text-decoration': 'underline'
                    // },
                },
                { 
                    name: 'Cliente',
                    fieldName: 'cliente_id',
                    fieldType: 'select',
                    addAttributes: true,
                },
                { 
                    name: 'Agente',
                    fieldName: 'AgenteVenta',
                    fieldType: 'text',
                    addAttributes: true,
                    editable: true,
                },
                { name: 'FPago' },
                { name: 'Enlace' },
                { name: 'Estado' },
                { name: 'Importe' },
                { name: 'IVA' },
                { name: 'TIva' },
                { 
                    name: 'Plazo',
                    fieldName: 'Plazos',
                    attrclassName: 'openModalPlazos',
                    addAttributes: true,
                    dataAttributes: { 
                        'data-venta': ''
                    },
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                },
                { name: 'Retenciones' },
                { name: 'Cobrado' },
                { name: 'AContable' },
                { name: 'Observaciones' },
                { name: 'Total' },
                { name: 'Pendiente' },
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

            function prepareRowData(ventas) {
                ventas.forEach(venta => {
                    // console.log(venta)
                    // console.log(parte);
                    // if (parte.proyecto_n_m_n && parte.proyecto_n_m_n.length > 0) {
                    //     console.log({proyecto: parte.proyecto_n_m_n[0].proyecto.name});
                    // }
                    const rutaEnlace = (venta.venta_confirm) ? `/admin/ventas/download_factura/${venta.idVenta}` : `/admin/ventas/albaran/${venta.idVenta}`;
                    const nombreCliente = `${venta.cliente.NombreCliente} ${venta.cliente.ApellidoCliente}`;
                    rowData[venta.idVenta] = {
                        ID: venta.idVenta,
                        Fecha: formatDateYYYYMMDD(venta.FechaVenta),
                        Emp: venta.empresa.EMP,
                        Cliente: nombreCliente,
                        Agente: venta.AgenteVenta,
                        FPago: (venta.formaPago == 1) ? 'Banco' : 'Efectivo',
                        Estado: (venta.venta_confirm) ? 'Facturado' : 'Albarán',
                        Enlace: rutaEnlace,
                        Importe: formatPrice(venta.ImporteVenta),
                        IVA: venta.IVAVenta+'%',
                        Plazo: venta.Plazos,
                        TIva: formatPrice(venta.TotalIvaVenta),
                        Retenciones: venta.RetencionesVenta+'%',
                        Cobrado: formatPrice(venta.Cobrado),
                        AContable: venta.NAsientoContable,
                        Observaciones: venta.Observaciones,
                        Total: formatPrice(venta.TotalFacturaVenta),
                        Pendiente: formatPrice(venta.PendienteVenta),
                        Notas1: venta.notas1,
                        Notas2: venta.notas2,
                        Acciones: 
                        `
                            <?php $__env->startComponent('components.actions-button'); ?>
                                <button 
                                    type="button" 
                                    class="btn btn-outline-primary detailsVentaBtn" 
                                    data-id="${venta.idVenta}"
                                    data-bs-placement="top"
                                    title="Detalles de la Venta"
                                    data-bs-toggle="tooltip"
                                >
                                    <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                        <ion-icon name="information-circle-outline"></ion-icon>
                                        <small>Detalles</small>
                                    </div>
                                </button>
                                    ${ (venta.venta_confirm == null) ? `
                                        <button 
                                            type="button" 
                                            class="btn btn-info editVentaBtn" 
                                            data-id="${venta.idVenta}"
                                            data-bs-placement="top"
                                            title="Editar Venta"
                                            data-bs-toggle="tooltip"
                                        >
                                            <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                                <ion-icon name="create-outline"></ion-icon>
                                                <small>Editar</small>
                                            </div>
                                        </button>
                                        <a 
                                            class="btn btn-success generateAlbaran" 
                                            href="/admin/ventas/albaran/${venta.idVenta}" 
                                            target="_blank"
                                            data-bs-placement="top"
                                            title="Albarán"
                                            data-bs-toggle="tooltip"
                                        >
                                            <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                                <ion-icon name="document-attach-outline"></ion-icon>
                                                <small>Albarán</small>
                                            </div>
                                        </a>
                                    ` : ''}
                                <a 
                                    class="btn btn-warning ${ (venta.venta_confirm == null) ? 'generateFactura' : '' }" 
                                    href="${ (venta.venta_confirm == null) ? `/admin/ventas/factura/${venta.idVenta}` : `/admin/ventas/download_factura/${venta.idVenta}` }" 
                                    target="_blank"
                                    data-bs-placement="top"
                                    data-ventaid="${venta.idVenta}"
                                    title="${ (venta.venta_confirm !== null) ? 'Descargar Factura' : 'Facturar' }"
                                    data-bs-toggle="tooltip"
                                >
                                    <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                        ${ (venta.venta_confirm == null) ? `
                                            <ion-icon name="cash-outline"></ion-icon>
                                        ` : `
                                            <ion-icon name="cloud-download-outline"></ion-icon>
                                        `}
                                        <small>${ (venta.venta_confirm == null) ? 'Facturar' : 'Descargar' }</small>
                                    </div>
                                </a>
                            <?php echo $__env->renderComponent(); ?>
                        
                        `
                    }
                });

                data = Object.values(rowData);
            }

            prepareRowData(ventas);

            const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
                const customButtons = `
                    <button type="button" class="btn btn-outline-warning createVentaBtn">
                        <div class="d-flex justify-between align-items-center align-content-center">
                            <small>Crear Venta</small>
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                    </button>
                `;

                // Inicializar la tabla de citas
                const api = inicializarAGtable( agTablediv, data, result, 'Ventas', customButtons, 'Ventas');

                if (api) {
                    opcionesPersonalizadas = api;
                }
            });

            let tableVentasGlobal = tabId ? $(`${tabId} #VentasGrid`) : $('#VentasGrid');

            tableVentasGlobal.off(); // Limpiar todos los eventos previos

            const calcularTotales = ( id ) => {
                let totalFactura = 0;
                let totalIva = parseFloat($('#IvaVenta').val()) || 0;
                let suplidos = parseFloat($('#SuplidosVenta').val()) || 0;
                let retenciones = parseFloat($('#RetencionesVenta').val()) || 0;
                let totalRetenciones = parseFloat($('#TotalRetencionesVenta').val()) || 0;
    
                $('#elementsToShow tr').each(function() {
                    let totalLinea = parseFloat($(this).find('.total-linea').text());
                    totalFactura += totalLinea;
                });

                const totalIvaParte = totalFactura - (totalFactura / (1 + (totalIva / 100)));
    
                totalIva = totalIvaParte;
                totalIva = parseFloat(totalIva.toFixed(2));

                totalRetenciones = totalFactura * (retenciones / 100);
                totalRetenciones = parseFloat(totalRetenciones.toFixed(2));
    
                totalFactura += suplidos - totalRetenciones;
                totalFactura = parseFloat(totalFactura.toFixed(2));

                let pendienteVenta = totalFactura - parseFloat( $('#Cobrado').val() );
                let cobrado = parseFloat($('#Cobrado').val());

                totalFactura.toFixed(2);
                totalIva.toFixed(2);
                totalRetenciones.toFixed(2);
                pendienteVenta.toFixed(2);
                cobrado.toFixed(2);

    
                $('#TotalIvaVenta').val(totalIva.toFixed(2));
                $('#TotalRetencionesVenta').val(totalRetenciones.toFixed(2));
                $('#TotalFacturaVenta').val(totalFactura.toFixed(2));
                $('#PendienteVenta').val(pendienteVenta.toFixed(2));
    
                if ( id ) {
                    $.ajax({
                        url: '/admin/lineasventas/update/' + id,
                        method: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            totalFactura,
                            totalIva,
                            suplidos,
                            retenciones,
                            totalRetenciones,
                            cobrado,
                            pendiente: pendienteVenta,
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
    
            }

            const calcularTotalesEdit = ( id ) => {
                let totalFactura = 0;
                let totalIva = parseFloat($('#editVentaModal #IvaVenta').val()) || 0;
                let suplidos = parseFloat($('#editVentaModal #SuplidosVenta').val()) || 0;
                let retenciones = parseFloat($('#editVentaModal #RetencionesVenta').val()) || 0;
                let totalRetenciones = parseFloat($('#editVentaModal #TotalRetencionesVenta').val()) || 0;
    
                $('#editVentaModal #elementsToShow tr').each(function() {
                    let totalLinea = parseFloat($(this).find('.total-linea').text());
                    totalFactura += totalLinea;
                });
    
                const totalIvaParte = totalFactura - (totalFactura / (1 + (totalIva / 100)));
    
                totalIva = totalIvaParte;
                totaliva = parseFloat(totalIva.toFixed(2));

                totalRetenciones = totalFactura * (retenciones / 100);
                totalRetenciones = parseFloat(totalRetenciones.toFixed(2));
    
                totalFactura += totalIva + suplidos - totalRetenciones;
                totalFactura = parseFloat(totalFactura.toFixed(2));

                let pendienteVenta = totalFactura - parseFloat( $('#editVentaModal #Cobrado').val() );
                let cobrado = parseFloat($('#editVentaModal #Cobrado').val());

                totalFactura.toFixed(2);
                totalIva.toFixed(2);
                totalRetenciones.toFixed(2);
                pendienteVenta.toFixed(2);
                cobrado.toFixed(2);

                $('#editVentaModal #TotalIvaVenta').val(totalIva.toFixed(2));
                $('#editVentaModal #TotalRetencionesVenta').val(totalRetenciones.toFixed(2));
                $('#editVentaModal #TotalFacturaVenta').val(totalFactura.toFixed(2));
                $('#editVentaModal #PendienteVenta').val(pendienteVenta.toFixed(2));
    
                if ( id ) {
                    $.ajax({
                        url: '/admin/lineasventas/update/' + id,
                        method: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            totalFactura,
                            totalIva,
                            suplidos,
                            retenciones,
                            totalRetenciones,
                            cobrado,
                            pendiente: pendienteVenta
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
    
            }
    
            // Mostrar modal para crear nueva venta
            tableVentasGlobal.on('click','.createVentaBtn', function (e) {
                e.preventDefault();
                $('#createVentaModal').modal('show');
                $('#createVentaTitle').text('Crear Venta');
                $('#createVentaForm')[0].reset(); // Reiniciar formulario

                // Limpiar tabla de elementos
                $('#createVentaModal #elementsToShow').empty();

                $('#createVentaModal #FechaVenta').val(new Date().toISOString().split('T')[0]);
                $('#createVentaModal #AgenteVenta').val('<?php echo e(Auth::user()->name); ?>');
                $('#createVentaModal #EnviadoVenta').val('<?php echo e(Auth::user()->email); ?>');
                $('#createVentaModal #NAsientoContable').val(1);
                $('#createVentaModal #Observaciones').val('Sin observaciones');
                $('#createVentaModal #TotalIvaVenta').val(0);
                $('#createVentaModal #TotalRetencionesVenta').val(0);
                $('#createVentaModal #TotalFacturaVenta').val(0);
                $('#v #Observaciones').val('Sin observaciones');

                // Inicializar Select2

                // Destruir la instancia de Select2, si existe
                if ($('#createVentaModal .form-select').data('select2')) {
                    $('#createVentaModal .form-select').select2('destroy');
                }

                // Inicializa Select2
                $('#createVentaModal .form-select').select2({
                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                    dropdownParent: $('#createVentaModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                    placeholder: 'Seleccione un cliente',
                });


            });
    
            // Calcular el total del IVA a partir del importe y almacenarlo
            $('#IvaVenta').on('change', function() {
                calcularTotales();
            });
    
            // calcular el valor a partir de las retenciones
            $('#RetencionesVenta').on('change', function() {
                calcularTotales();
            });
    
            $('#createVentaModal #Cobrado').on('focusout', function() {
                if ( $('#Cobrado').val() === '' ) {
                    Swal.fire({
                        title: 'Advertencia',
                        text: 'El valor cobrado no puede estar vacío',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
            });
    
            // Calcular el cobrado y el pendiente a partir del total de la factura
            $('#createVentaModal #Cobrado').on('change', function() {
                let totalFactura = parseFloat($('#TotalFacturaVenta').val());
    
                if ( $('#Cobrado').val() === '' ) {
                    Swal.fire({
                        title: 'Advertencia',
                        text: 'El valor cobrado no puede estar vacío',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
    
                let cobrado = parseFloat($('#Cobrado').val());
    
                cobrado = isNaN(cobrado) ? 0 : cobrado;
    
                if ( cobrado < 0 ) {
                    Swal.fire({
                        title: 'Error',
                        text: 'El valor cobrado no puede ser menor a 0',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
    
                if ( isNaN(cobrado) ) {
                    $('#Cobrado').val(0);
                }
    
                let pendiente = totalFactura - cobrado;
    
                if (pendiente < 0) {
                    Swal.fire({
                        title: 'Error',
                        text: 'El valor cobrado no puede ser mayor al total de la factura',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
    
                $('#PendienteVenta').val(pendiente);
            });
    
            // Actualizar el total de la factura con los suplidos
            $('#SuplidosVenta').on('change', function() {
                calcularTotales();
            });
    
            // Guardar nueva venta
            $('#guardarVenta').click(function () {
                openLoader();
                const table = $('#tableToShowElements');
                const elements = $('#elementsToShow');
    
                // Ocultar tabla de elementos
                table.hide();
                
                // Obtener los datos del formulario en un objeto FormData
                const formData = new FormData($('#createVentaForm')[0]);
    
                // Agregar el token CSRF manualmente si no se incluye automáticamente en el formulario
                formData.append('_token', '<?php echo e(csrf_token()); ?>');
    
                $.ajax({
                    url: '<?php echo e(route("admin.ventas.store")); ?>',
                    method: 'POST',
                    data: formData,
                    processData: false,  // No procesar los datos (FormData no necesita ser procesado)
                    contentType: false,  // No establecer automáticamente el tipo de contenido
                    success: function({ message, venta, cliente, archivos, articulos, ordenes, partes, proyectos, ventaEmp }) {
                        closeLoader();
                        // Cerrar primer acordeón y abrir el segundo
                        $('#collapseDetallesVenta').collapse('hide');
                        $('#collapseLineasVenta').collapse('show');
    
                        Swal.fire({
                            title: 'Venta guardada',
                            text: message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });

                        partes = Object.values(partes);
    
                        ventaGuardadaGlobal = true;
                        $('#guardarVenta').attr('disabled', true);
    
                        if (ventaGuardadaGlobal) {
                            // Desactivar todos los inputs del formulario de venta
                            $('#createVentaForm input, #createVentaForm select, #createVentaForm textarea').attr('disabled', true);
    
                            $('#addNewLine').off('click').on('click', function() {
                                globalLineas++;
    
                                let newLine = `
                                    <form id="AddNewLineForm${globalLineas}" class="mt-2 mb-2">
                                        <div class="row">
                                            <input type="hidden" id="venta_id" name="venta_id" value="${venta.idVenta}">
                                            <input type="hidden" id="clienteId" name="cliente_id" value="${cliente.idCliente}">
                                            <input type="hidden" id="clienteNameId" name="cliente_name" value="${cliente.nombre}">
                                            <input type="hidden" id="archivoId" name="archivo_id" value="${venta.archivoId}">
                                            <input type="hidden" id="totalFactura" name="totalFactura" value="${venta.TotalFacturaVenta}">
                                            <input type="hidden" id="sumaTotalesLineas" data-value="0">
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="venderProyecto${globalLineas}">
                                                        <input type="checkbox" id="venderProyecto${globalLineas}" class="venderProyectoCheckbox"> Vender Proyecto
                                                    </label>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group select-container" id="ordenTrabajoContainer${globalLineas}">
                                                    <label for="ordenTrabajo${globalLineas}">Parte de trabajo</label>
                                                    <select class="form-select ordenTrabajo" id="ordenTrabajo${globalLineas}" name="ordenTrabajo" required>
                                                        <option value="" selected>Seleccione un parte de trabajo</option>
                                                        ${partes.map(parte => `
                                                            <option 
                                                                data-tipo="parte" 
                                                                data-lineas="${parte.lineas}" 
                                                                data-valorparte="${parte.totalParte}" 
                                                                value="${parte.idParteTrabajo}"
                                                            >
                                                                Num ${parte.idParteTrabajo} | ${( parte.tituloParte) ? parte.tituloParte : parte.Asunto }
                                                            </option>`
                                                        ).join('')}
                                                    </select>
                                                </div>
    
                                                <div class="form-group select-container" id="proyectoContainer${globalLineas}" style="display: none;">
                                                    <label for="proyecto${globalLineas}">Proyecto</label>
                                                    <select class="form-select proyecto" id="proyecto${globalLineas}" name="proyecto">
                                                        <option value="">Seleccione un proyecto</option>
                                                        ${proyectos.map(proyecto => `
                                                            <option 
                                                                value="${proyecto.idProyecto}"
                                                            >
                                                                Num ${proyecto.idProyecto} | ${proyecto.name}
                                                            </option>
                                                        `).join('')}
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div id="containerArticulo${globalLineas}" class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label for="articulo${globalLineas}">Artículo</label>
                                                    <select class="form-select articulo" id="articulo${globalLineas}" name="articulo[]" required disabled>
                                                        <option value="">Seleccione un artículo</option>
                                                        ${articulos.map(articulo => `<option data-trazabilidad="${articulo.TrazabilidadArticulos}" value="${articulo.idArticulo}">${articulo.nombreArticulo}</option>`).join('')}
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cantidad${globalLineas}">Cantidad</label>
                                                    <input type="number" class="form-control cantidad" id="cantidad${globalLineas}" name="cantidad" value="1" step="0.01" required disabled>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="precioSinIva${globalLineas}">Precio sin iva</label>
                                                    <input type="number" class="form-control precioSinIva" id="precioSinIva${globalLineas}" name="precioSIva" step="0.01" required disabled>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="descuento${globalLineas}">Descuento</label>
                                                    <input type="number" class="form-control descuento" id="descuento${globalLineas}" name="descuento" step="0.01" value="0" required disabled>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="total${globalLineas}">Total</label>
                                                    <input type="number" class="form-control total" id="total${globalLineas}" name="total" step="0.01" required disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-success saveLinea" data-line="${globalLineas}">Guardar</button>    
                                    </form>
                                `;
    
                                $('#newLinesContainer').append(newLine);

                                // Inicializa Select2
                                $('select.form-select').select2({
                                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                                    dropdownParent: $('#createVentaModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                                });

                                $(`ordenTrabajoContainer${globalLineas}`).off('change').on('change', function(){
                                    // desbloquear el campo descuento
                                    $(`#descuento${globalLineas}`).prop('disabled', false);

                                    // si el valor de la orden de trabajo cambia a un valor vacio, limpiar los campos y bloquearlos
                                    if ( $(this).val() === '' ) {
                                        $(`#cantidad${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#precioSinIva${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#descuento${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#total${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#containerArticulo${globalLineas}`).addClass('d-none');
                                        $(`#articulo${globalLineas}`).val('').trigger('change').prop('disabled', true);
                                    }

                                });
    
                                // Toggle visibility based on checkbox state
                                $(`#venderProyecto${globalLineas}`).off('change').on('change', function() {
                                    if ($(this).is(':checked')) {
                                        $(`#proyectoContainer${globalLineas}`).show();
                                        $(`#ordenTrabajoContainer${globalLineas}`).hide();
                                        $(`#articulo${globalLineas}`).prop('disabled', false).show();
                                        $(`#cantidad${globalLineas}`).prop('disabled', false);
                                        $(`#precioSinIva${globalLineas}`).prop('disabled', false);
                                        $(`#descuento${globalLineas}`).prop('disabled', false);
                                        $(`#total${globalLineas}`).prop('disabled', false);
                                        $(`#containerArticulo${globalLineas}`).removeClass('d-none');
                                    } else {
                                        $(`#proyectoContainer${globalLineas}`).hide();
                                        $(`#ordenTrabajoContainer${globalLineas}`).show();
                                        $(`#cantidad${globalLineas}`).prop('disabled', true).val('');
                                        $(`#precioSinIva${globalLineas}`).prop('disabled', true).val('');
                                        $(`#descuento${globalLineas}`).prop('disabled', true).val('');
                                        $(`#total${globalLineas}`).prop('disabled', true).val('');
                                        $(`#containerArticulo${globalLineas}`).addClass('d-none');
                                        $(`#articulo${globalLineas}`).prop('disabled', true).val('').trigger('change').hide();
                                    }
                                });
    
                                // cargar en articulos los partes de trabajo correspondientes al proyecto seleccionado
                                $(`#proyecto${globalLineas}`).off('change').on('change', function() {
                                    const proyectoId = $(this).val();
                                    const form = $(this).closest('form');
                                    const articuloSelect = form.find('.articulo');
                                    let sumaTotalVentas = 0;
                                    if (proyectoId) {
                                        articuloSelect.attr('disabled', false);
                                        $.ajax({
                                            url: `/admin/proyectos/${proyectoId}/partes`,
                                            method: 'GET',
                                            beforeSend: function() {
                                                articuloSelect.empty();
                                                articuloSelect.append('<option>Cargando...</option>');
                                                openLoader();
                                            },
                                            success: function(response) {
                                                articuloSelect.empty();
                                                articuloSelect.attr('disabled', false);
                                                articuloSelect.attr('multiple', "multiple");
                                                response.partes.forEach(parte => {

                                                    // validar si algun parte de trabajo aun no se ha finalizado
                                                    if (parte.parte_trabajo.Estado == '2') {
                                                        Swal.fire({
                                                            title: 'Error',
                                                            text: 'El parte de trabajo con asunto ' + parte.parte_trabajo.Asunto + ' aún no ha sido finalizado',
                                                            icon: 'error',
                                                            confirmButtonText: 'Aceptar'
                                                        });
                                                        articuloSelect.val('').trigger('change');
                                                        closeLoader();
                                                        return;
                                                    }

                                                    // TODO: validar que los partes de trabajo, sus articulos pertenecen a la empresa que esta creando la venta
                                                    articuloSelect.append(`
                                                    <option 
                                                        data-tipo="parte"
                                                        data-lineas=${JSON.stringify(parte.parte_trabajo.partes_trabajo_lineas)}
                                                        data-suma="${parte.parte_trabajo.totalParte}"
                                                        value="${parte.parte_trabajo.idParteTrabajo}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="${parte.parte_trabajo.Asunto} | Visita: ${parte.parte_trabajo.FechaVisita}"
                                                    >
                                                        Num ${parte.parte_trabajo.idParteTrabajo} | ${ (parte.parte_trabajo.tituloParte) ? parte.parte_trabajo.tituloParte : parte.parte_trabajo.Asunto }
                                                    </option>
                                                    `);
                                                    sumaTotalVentas += parte.parte_trabajo.totalParte;
                                                });

                                                // seleccionar todos los articulos
                                                articuloSelect.val(response.partes.map(parte => parte.parte_trabajo.idParteTrabajo));
                                                closeLoader();

                                                //convertir el selector de articulos en un select2
                                                // Destruir la instancia de Select2, si existe
                                                if ($('.articulo').data('select2')) {
                                                    $('.articulo').select2('destroy');
                                                }
                                                // Inicializa Select2
                                                $('.articulo').select2({
                                                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                                                    dropdownParent: $('#createVentaModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                                                });

                                                // seleccionar todos los articulos
                                                articuloSelect.val(response.partes.map(parte => parte.parte_trabajo.idParteTrabajo));

                                                $(`#precioSinIva${globalLineas}`).val(sumaTotalVentas).attr('disabled', true);
                                                $(`#cantidad${globalLineas}`).val(response.partes.length).attr('disabled', true);
                                                $(`#total${globalLineas}`).val(sumaTotalVentas).attr('disabled', true);
                                                $('#sumaTotalesLineas').data('value', sumaTotalVentas).attr('disabled', true);
                                                
                                                // Calcular el total de ventas de los partes seleccionados si quito una parte restarle el valor al total

                                                articuloSelect.on('change', function() {
                                                    let total           = 0;
                                                    let selectedOptions = $(this).find('option:selected');
                                                    let lineas          = [];

                                                    selectedOptions.each(function() {
                                                        total += parseFloat($(this).data('suma'));
                                                        lineas.push($(this).data('lineas'));
                                                    });

                                                    lineas = lineas.map((linea) => {
                                                        if (linea.length > 0) {
                                                            return linea;
                                                        }
                                                    })

                                                    console.log({
                                                        lineas
                                                    })

                                                    const validateEmp = lineas.every((linea) => linea.articulo.empresa_id === ventaEmp);
                                                    const idsQueNoPertenecen = lineas.filter((linea) => linea.articulo.empresa_id !== ventaEmp).map((linea) => linea.articulo.empresa_id);

                                                    console.log({
                                                        validateEmp,
                                                        idsQueNoPertenecen
                                                    })

                                                    if (!validateEmp) {
                                                        Swal.fire({
                                                            title: 'Warning',
                                                            text: 'Hay partes de trabajo con materiales de otra empresa, ¿quieres realizar un traspaso de materiales?',
                                                            icon: 'warning',
                                                            confirmButtonText: 'Aceptar',
                                                            showCancelButton: true,
                                                            cancelButtonText: 'Cancelar'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // redirigir a la vista de traspaso de materiales
                                                                
                                                                $.ajax({
                                                                    url: "<?php echo e(route('admin.traspasos.store')); ?>",
                                                                    method: 'POST',
                                                                    data: {
                                                                        _token: '<?php echo e(csrf_token()); ?>',
                                                                        ids: idsQueNoPertenecen
                                                                    },
                                                                    success: function(response) {
                                                                        Swal.fire({
                                                                            title: 'Traspaso realizado',
                                                                            text: response.message,
                                                                            icon: 'success',
                                                                            confirmButtonText: 'Aceptar'
                                                                        })

                                                                    },
                                                                    error: function(error) {
                                                                        console.error(error);
                                                                    }
                                                                });

                                                            } else {
                                                                articuloSelect.val('').trigger('change');
                                                            }
                                                        });
                                                    }

                                                    $(`#precioSinIva${globalLineas}`).val(total).attr('disabled', true);
                                                    $(`#cantidad${globalLineas}`).val(selectedOptions.length).attr('disabled', true);
                                                    $(`#total${globalLineas}`).val(total).attr('disabled', true);
                                                    $('#sumaTotalesLineas').data('value', total).attr('disabled', true);
                                                });
                                                
                                            },
                                            error: function(error) {
                                                console.error(error);
                                                closeLoader();
                                            }
                                        });
                                    } else {
                                        articuloSelect.attr('disabled', true);
                                    }
                                });
    
                                // Activar el selector de artículos solo cuando se selecciona una orden de trabajo
                                $('#newLinesContainer').off('change', `#ordenTrabajo${globalLineas}`).on('change', `#ordenTrabajo${globalLineas}`, function () {
                                    const ordenTrabajoId = $(this).val();
                                    const form = $(this).closest('form');
                                    const articuloSelect = form.find('.articulo');
                                    
                                    // obtener el valor de la orden de trabajo
                                    let tipo = $(this).find('option:selected').data('tipo') || 'Parte';
                                    let suma = $(this).find('option:selected').data('valorparte') || 0;

                                    suma = parseFloat(suma);
                                    suma = suma.toFixed(2);
    
                                    // añadir el valor de la orden de trabajo al precio sin iva
                                    $(`#precioSinIva${globalLineas}`).val(suma).attr('disabled', true);
                                    $(`#cantidad${globalLineas}`).val(1).attr('disabled', true);
                                    $(`#total${globalLineas}`).val(suma).attr('disabled', true);
                                    $(`#descuento${globalLineas}`).val(0).attr('disabled', false);
                                });
    
                                // Delegar eventos en el contenedor para manejar los cambios de los campos dinámicos
                                $('#newLinesContainer').on('change', `#articulo${globalLineas}`, function () {
                                    const articuloId = parseInt($(this).val());
                                    const form = $(this).closest('form');
                                    const precioSinIvaInput = form.find('.precioSinIva');
                                    const cantidadInput = form.find('.cantidad');
                                    const totalInput = form.find('.total');
                                    const descuentoInput = form.find('.descuento');
    
                                    // Buscar el artículo seleccionado para obtener su precio
                                    const articulo = articulos.find(art => art.idArticulo === articuloId);
                         
                                    if (articulo) {
                                        precioSinIvaInput.val(articulo.ptsVenta).attr('disabled', false);
                                        cantidadInput.attr('disabled', false);
                                        descuentoInput.attr('disabled', false);
                                        totalInput.val(cantidadInput.val() * articulo.ptsVenta);
                                        calcularTotales();
                                    }
                                });
    
                                $('#newLinesContainer').on('change', `#cantidad${globalLineas}`, function () {
                                    const cantidad = $(this).val();
                                    const form = $(this).closest('form');
                                    const precioSinIvaInput = form.find('.precioSinIva').val();
                                    const descuentoInput = form.find('.descuento').val();
                                    const totalInput = form.find('.total');
    
                                    if (cantidad && precioSinIvaInput) {
                                        const total = cantidad * precioSinIvaInput - descuentoInput;
                                        totalInput.val(total);
                                        calcularTotales();
                                    }
                                });
    
                                $('#newLinesContainer').on('change', `#precioSinIva${globalLineas}`, function () {
                                    const precioSinIva = $(this).val();
                                    const form = $(this).closest('form');
                                    const cantidad = form.find('.cantidad').val();
                                    const descuentoInput = form.find('.descuento').val();
                                    const totalInput = form.find('.total');
    
                                    if (precioSinIva && cantidad) {
                                        const total = cantidad * precioSinIva - descuentoInput;
                                        totalInput.val(total);
                                        calcularTotales();
                                    }
                                });
    
                                $('#newLinesContainer').on('change', `#descuento${globalLineas}`, function () {
                                    const descuento = parseFloat($(this).val());
                                    const form      = $(this).closest('form');
                                    const cantidad  = parseFloat(form.find('.cantidad').val());
                                    const precioSinIvaInput = parseFloat(form.find('.precioSinIva').val());
                                    const totalInput = form.find('.total');

                                    // validar si es un proyecto
                                    const proyecto = form.find('.proyecto').val();

                                    // el valor del descuento no puede ser mayor al 100%
                                    if (descuento > 100 || descuento < 0) {
                                        Swal.fire({
                                            title: 'warning',
                                            text: 'El descuento no puede ser mayor al 100%',
                                            icon: 'error',
                                            confirmButtonText: 'Aceptar'
                                        });
                                        $(this).val(0);
                                        return;
                                    }

                                    if (descuento == 0) {
                                        totalInput.val(cantidad * precioSinIvaInput);
                                        calcularTotales();
                                        return;
                                    }

                                    if (proyecto) {
                                        // const porcentaje = parseFloat(descuento);
                                        // const precioSinIva = parseFloat(precioSinIvaInput);
                                        // const total = precioSinIva - (precioSinIva * (porcentaje / 100));
                                        let precio = precioSinIvaInput * cantidad;
                                        let descuentoAplicado = precio * (descuento / 100);
                                        let lineaDescuento = precio - descuentoAplicado;
                                        let total = lineaDescuento;

                                        totalInput.val(total.toFixed(2));
                                        calcularTotales();
                                        return;
                                    }
                                    
                                    if (descuento && cantidad && precioSinIvaInput) {
                                        let precio = precioSinIvaInput * cantidad;
                                        let descuentoAplicado = precio * (descuento / 100);
                                        let lineaDescuento = precio - descuentoAplicado;
                                        let total = lineaDescuento;

                                        totalInput.val(total.toFixed(2));
                                        calcularTotales();
                                    }
                                });
                            });
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al guardar la venta',
                            icon: 'error',
                            footer: error.message,
                            confirmButtonText: 'Aceptar'
                        });
                        closeLoader();
                    }
                });
            });
    
            // Función para calcular la suma de los totales de las líneas existentes
            const calcularSumaTotalesLineas = () => {
                let sumaTotales = 0;
                $('#elementsToShow tr').each(function() {
                    let total = parseFloat($(this).find('td:last-child').text());
                    if (!isNaN(total)) {
                        sumaTotales += total;
                    }
                });
                return sumaTotales;
            }
    
            // Delegar evento de guardado para las líneas dinámicas
            $('#collapseLineasVenta').on('click', '.saveLinea', function () {
                const lineNumber = $(this).data('line');
                const form = $(`#AddNewLineForm${lineNumber}`);
                const ordenTrabajoId = form.find(`#ordenTrabajo${lineNumber}`).val();
                const articuloId = form.find(`#articulo${lineNumber}`).val();
                const cantidad = parseFloat(form.find(`#cantidad${lineNumber}`).val());
                const precioSIva = parseFloat(form.find(`#precioSinIva${lineNumber}`).val());
                const descuento = parseFloat(form.find(`#descuento${lineNumber}`).val());
                const total = parseFloat(form.find(`#total${lineNumber}`).val());
    
                $('#sumaTotalesLineas').data('value', calcularSumaTotalesLineas());
    
                let cliente = {
                    idCliente: form.find('#clienteId').val(),
                    nombreCliente: form.find('#clienteNameId').val()
                };
    
                let archivos = {
                    idarchivos: form.find('#archivoId').val()
                };
    
                let venta = {
                    idVenta: form.find('#venta_id').val(),
                    totalFactura: parseFloat(form.find('#totalFactura').val()) // Asegurarse que se convierte a float
                };
    
                // Obtener la suma de las líneas existentes y agregar la nueva
                let sumaTotalesLineas = calcularSumaTotalesLineas() + total;
    
                // Validar si la suma total supera el total de la factura
                // if (sumaTotalesLineas > venta.totalFactura) {
                //     Swal.fire({
                //         title: 'Error',
                //         text: 'El total de las líneas no puede ser mayor al total de la factura',
                //         icon: 'error',
                //         confirmButtonText: 'Aceptar'
                //     });
                    
                //     return;
                // }
    
                // Validaciones de campos obligatorios
                if (cliente.idCliente === '' || cliente.idCliente === undefined || cliente.idCliente === null) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al guardar la línea, primero debe guardar la venta',
                        icon: 'error',
                        footer: 'No se han podido obtener los datos de la venta',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }
    
                const table = $('#tableToShowElements');
                const elements = $('#elementsToShow');
    
                // Mostrar tabla de elementos
                table.show();
    
                //obtener el tipo de orden
                let tipo = $(`#ordenTrabajo${lineNumber} option:selected`).data('tipo');
    
                $.ajax({
                    url: '<?php echo e(route("admin.lineasventas.store")); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        orden_trabajo_id: ordenTrabajoId,
                        articulo_id: articuloId,
                        cantidad,
                        precioSinIva: precioSIva,
                        descuento,
                        total,
                        venta_id: venta.idVenta,
                        tipo,
                    },
                    success: function({ status, message, venta, articulos, ordenes, cliente, linea, code, ok, lineas }) {
    
                        if ( ok == false ) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ha ocurrido un error al guardar la línea',
                                icon: 'error',
                                footer: message,
                                confirmButtonText: 'Aceptar'
                            });
                            return;
                        }
    
                        if ( lineas ) {
                            
                            lineas.forEach(linea => {
                            
                                const newElement = `
                                    <tr>
                                        <td>${lineNumber}</td>
                                        <td>${linea.parte_trabajo.Asunto}</td>
                                        <td>${linea.Descripcion}</td>
                                        <td>${linea.Cantidad}</td>
                                        <td>${linea.descuento}</td>
                                        <td class="total-linea">${linea.total}€</td>
                                    </tr>
                                `;
                                elements.append(newElement);
                            });
    
                        }else{
                            //remover "Descripcion de la parte" de linea.Descripcion
                            let descripcion = linea.Descripcion;
                            let separarPorEspacios = descripcion.split(' ');
                            // eliminar desde la posicion 0 hasta la posicion 3
                            separarPorEspacios.splice(0, 3);
                            descripcion = separarPorEspacios.join(' ');
                            
                            let newElement = `
                            <tr>
                                <td>${lineNumber}</td>
                                <td>${descripcion}</td>
                                <td>${linea.Descripcion}</td>
                                <td>${linea.Cantidad}</td>
                                <td>${linea.descuento}</td>
                                <td class="total-linea">${linea.total}€</td>
                                </tr>
                            `;
                            elements.append(newElement);
                        }
    
    
                        calcularTotales(venta.idVenta);
    
                        Swal.fire({
                            title: 'Línea guardada',
                            text: message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
    
                        // Limpiar campos de la nueva línea y deshabilitarlos
                        form.find('textarea, input').val('').attr('disabled', true);
    
                        // Limpiar el contenedor de líneas nuevas
                        $('#newLinesContainer').empty();
    
                        $('#addNewLine').attr('disabled', false);
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
    
                $('#saveVentaBtn').on('click', function() {
                if (ventaGuardadaGlobal) {
                    
                    
    
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Primero debe guardar la venta antes de guardar las líneas',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
                });
    
            });
    
            tableVentasGlobal.on('click','.detailsVentaBtn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: `/admin/ventas/edit/${id}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.status === 'success') {
                            let venta = response.venta;
                            $('#createVentaForm #FechaVenta').val(venta.FechaVenta).attr('disabled', true);
                            $('#createVentaForm #AgenteVenta').val(venta.AgenteVenta).attr('disabled', true);
                            $('#createVentaForm #EnviadoVenta').val(venta.EnviadoVenta).attr('disabled', true);
                            $('#createVentaForm #cliente_id').val(venta.cliente_id).attr('disabled', true);
                            $('#createVentaForm #empresa_id').val(venta.empresa_id).attr('disabled', true);
                            $('#createVentaForm #FormaPago').val(venta.FormaPago).attr('disabled', true);
                            $('#createVentaForm #IvaVenta').val(venta.IVAVenta).attr('disabled', true);
                            $('#createVentaForm #TotalIvaVenta').val(venta.TotalIvaVenta).attr('disabled', true);
                            $('#createVentaForm #RetencionesVenta').val(venta.RetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalRetencionesVenta').val(venta.TotalRetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalFacturaVenta').val(venta.TotalFacturaVenta).attr('disabled', true);
                            $('#createVentaForm #SuplidosVenta').val(venta.SuplidosVenta).attr('disabled', true);
                            $('#createVentaForm #Plazos').val(venta.Plazos).attr('disabled', true);
                            $('#createVentaForm #Cobrado').val(venta.Cobrado).attr('disabled', true);
                            $('#createVentaForm #PendienteVenta').val(venta.PendienteVenta).attr('disabled', true);
                            $('#createVentaForm #NAsientoContable').val(venta.NAsientoContable).attr('disabled', true);
                            $('#createVentaForm #Observaciones').val(venta.Observaciones).attr('disabled', true);
    
                            // Limpiar y cargar las líneas de venta
                            $('#elementsToShow').empty();
                            venta.venta_lineas.forEach(linea => {
    
                                //remover "Descripcion de la parte" de linea.Descripcion
                                let descripcion = linea.Descripcion;
                                let separarPorEspacios = descripcion.split(' ');
                                // eliminar desde la posicion 0 hasta la posicion 3
                                separarPorEspacios.splice(0, 3);
                                descripcion = separarPorEspacios.join(' ');
    
                                $('#elementsToShow').append(`
                                    <tr>
                                        <td>${linea.idLineaVenta}</td>
                                        <td>${descripcion}</td>
                                        <td>${linea.Descripcion}</td>
                                        <td>${linea.Cantidad}</td>
                                        <td>${linea.descuento}</td>
                                        <td class="total-linea">${linea.total}€</td>
                                    </tr>
                                `);
                            });
    
                            $('#createVentaModal').modal('show');
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
    
            // Edit venta
            tableVentasGlobal.on('click', '.editVentaBtn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                getEditVenta(id);
            });

            tableVentasGlobal.on('dblclick', '.OpenHistorialCliente', function(event){
                const elemento  = $(this);
                const span      = elemento.find('span')[1]
                const parteid   = span.getAttribute('data-parteid');

                getEditCliente(parteid, 'Ventas');
            });

            // detalle de la venta
            $("#ventas").on('click', '.detailsVentaBtn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: `/admin/ventas/edit/${id}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.status === 'success') {
                            let venta = response.venta;
                            $('#createVentaForm #FechaVenta').val(venta.FechaVenta).attr('disabled', true);
                            $('#createVentaForm #AgenteVenta').val(venta.AgenteVenta).attr('disabled', true);
                            $('#createVentaForm #EnviadoVenta').val(venta.EnviadoVenta).attr('disabled', true);
                            $('#createVentaForm #cliente_id').val(venta.cliente_id).attr('disabled', true);
                            $('#createVentaForm #empresa_id').val(venta.empresa_id).attr('disabled', true);
                            $('#createVentaForm #FormaPago').val(venta.FormaPago).attr('disabled', true);
                            $('#createVentaForm #IvaVenta').val(venta.IVAVenta).attr('disabled', true);
                            $('#createVentaForm #TotalIvaVenta').val(venta.TotalIvaVenta).attr('disabled', true);
                            $('#createVentaForm #RetencionesVenta').val(venta.RetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalRetencionesVenta').val(venta.TotalRetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalFacturaVenta').val(venta.TotalFacturaVenta).attr('disabled', true);
                            $('#createVentaForm #SuplidosVenta').val(venta.SuplidosVenta).attr('disabled', true);
                            $('#createVentaForm #Plazos').val(venta.Plazos).attr('disabled', true);
                            $('#createVentaForm #Cobrado').val(venta.Cobrado).attr('disabled', true);
                            $('#createVentaForm #PendienteVenta').val(venta.PendienteVenta).attr('disabled', true);
                            $('#createVentaForm #NAsientoContable').val(venta.NAsientoContable).attr('disabled', true);
                            $('#createVentaForm #Observaciones').val(venta.Observaciones).attr('disabled', true);
    
                            // Limpiar y cargar las líneas de venta
                            $('#elementsToShow').empty();

                            // cambiar el titulo del modal
                            $('#createVentaModal .modal-title').text('Detalles de la venta');
                            
                            venta.venta_lineas.forEach(linea => {
    
                                //remover "Descripcion de la parte" de linea.Descripcion
                                let descripcion = linea.Descripcion;
                                let separarPorEspacios = descripcion.split(' ');
                                // eliminar desde la posicion 0 hasta la posicion 3
                                separarPorEspacios.splice(0, 3);
                                descripcion = separarPorEspacios.join(' ');
    
                                $('#elementsToShow').append(`
                                    <tr>
                                        <td>${linea.idLineaVenta}</td>
                                        <td>${descripcion}</td>
                                        <td>${linea.Descripcion}</td>
                                        <td>${linea.Cantidad}</td>
                                        <td>${linea.descuento}</td>
                                        <td class="total-linea">${linea.total}€</td>
                                    </tr>
                                `);

                            });

                            $('#createVentaForm button').hide();

                            $('#createVentaModal').modal('show');
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }

                });
            });

            tableVentasGlobal.on('dblclick', '.openEditVentaFast', function (e) {
                e.preventDefault();
                let id = $(this).data('parteid');
                getEditVenta(id);
            });

            // abrir modal con los plazos de la venta
            tableVentasGlobal.on('dblclick', '.openModalPlazos', function(event) {
                const ventaId = $(this).data('parteid');

                // limpiar el contenido del modal
                $('#plazosModal #plazosContainer').empty();

                getPlazosVenta(ventaId);
            });

            // Abrir el segundo modal para registrar cobro
            $(document).on('click', '.btnRegistrarCobro', function() {
                const plazoId = $(this).data('plazo-id');
                const total = parseFloat($(this).data('total'));
                const cobrado = parseFloat($(this).data('cobrado'));

                $('#plazoId').val(plazoId);
                $('#totalPlazo').val(total);
                $('#cobradoActual').val(cobrado);

                // autocomepltar el input de total a cobrar
                $('#montoCobro').val(total - cobrado);

                // fecha de cobro
                $('#fechaCobro').val(new Date().toISOString().split('T')[0]);

                $('#montoCobro').attr('max', total - cobrado); // Asegurar que no se supere el total
                $('#cobroModal').modal('show');

                $('#cobroModal').on('show.bs.modal', function() {
                    $('#montoCobro').focus();
                    // inicializar el select2
                    $('#cobroModal select.form-select').select2({
                        width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                        dropdownParent: $('#cobroModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                    });
                });

                $('#cobroModal').on('hidden.bs.modal', function() {
                    $('#montoCobro').val('');
                });

            });

            // Guardar el cobro
            $('#btnGuardarCobro').on('click', function() {
                const plazoId       = $('#plazoId').val();
                const montoCobro    = parseFloat($('#montoCobro').val());
                const total         = parseFloat($('#totalPlazo').val());
                const cobradoActual = parseFloat($('#cobradoActual').val());
   
                if (montoCobro + cobradoActual > total) {
                    Swal.fire({
                        title: 'Error',
                        text: 'El monto cobrado no puede superar el total del plazo.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                // Realizar el POST a la API
                $.ajax({
                    url: `/api/plazos/${plazoId}/cobros`, // Ajusta esta URL
                    method: 'POST',
                    data: {
                        monto: montoCobro,
                        fecha: $('#fechaCobro').val(),
                        banco: $('#bancoCobro').val(),
                        _token: '<?php echo e(csrf_token()); ?>',
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Exitoso',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });

                        $('#cobroModal').modal('hide');
                        $('#plazosModal').modal('hide'); // Opcional, para recargar plazos
                        
                    },
                    error: function(error) {
                        alert('Error al registrar el cobro.');
                    }
                });
            });

            // Evento para capturar el cierre del modal de #createVentaModal
            $('#createVentaModal').on('hidden.bs.modal', function () {
                $('#createVentaModal #elementsToShow').empty();
                $('#createVentaModal #createVentaForm textarea, input').val('').attr('disabled', false);

                

            });

            $('#saveEditVentaBtn').on('click', function(event){

                // tomar formulario y enviarlo por submit
                const id = $('#editVentaModal #idVenta').val();
                // cambiarle el attr de action para enviario al editar
                $('#createVentaForm').attr('action', `/admin/ventas/update/${id}`);

                // cambiar el metodo a POST
                $('#createVentaForm').attr('method', 'POST');

                // añaadir el token
                $('#createVentaForm').append('<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">');

                $('#createVentaForm').submit();

            });

            return data;

        }

        function inicializarVentasTableEstadisticas(ventas, tableGrid){
            // Inicializar la tabla de citas
            const agTablediv = document.querySelector(tableGrid);

            let rowData = {};
            let data = [];

            const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
                { 
                    name: 'ID',
                    fieldName: 'Venta',
                    addAttributes: true, 
                    addcustomDatasets: true,
                    dataAttributes: { 
                        'data-id': ''
                    },
                    attrclassName: 'openEditVentaFast',
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                    principal: true
                },
                { 
                    name: 'Fecha',
                    className: 'fecha-alta-column',
                    fieldName: 'FechaVenta',
                    fieldType: 'date',
                    editable: true,
                }, 
                { 
                    name: 'Emp',
                    // addAttributes: true,
                    // fieldName: 'NFacturaCompra',
                    // fieldType: 'textarea',
                    // dataAttributes: { 
                    //     'data-order': 'order-column' 
                    // },
                    // editable: true,
                    // attrclassName: 'openProjectDetails',
                    // styles: {
                    //     'cursor': 'pointer',
                    //     'text-decoration': 'underline'
                    // },
                },
                { 
                    name: 'Cliente',
                    fieldName: 'cliente_id',
                    fieldType: 'select',
                    addAttributes: true,
                },
                { 
                    name: 'Agente',
                    fieldName: 'AgenteVenta',
                    fieldType: 'text',
                    addAttributes: true,
                    editable: true,
                },
                { name: 'FPago' },
                { name: 'Enlace' },
                { name: 'Estado' },
                { name: 'Importe' },
                { name: 'IVA' },
                { name: 'TIva' },
                { 
                    name: 'Plazo',
                    fieldName: 'Plazos',
                    attrclassName: 'openModalPlazos',
                    addAttributes: true,
                    dataAttributes: { 
                        'data-venta': ''
                    },
                    styles: {
                        'cursor': 'pointer',
                        'text-decoration': 'underline'
                    },
                },
                { name: 'Retenciones' },
                { name: 'Cobrado' },
                { name: 'AContable' },
                { name: 'Observaciones' },
                { name: 'Total' },
                { name: 'Pendiente' },
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

            function prepareRowData(ventas) {
                ventas.forEach(venta => {
                    // console.log(venta)
                    // console.log(parte);
                    // if (parte.proyecto_n_m_n && parte.proyecto_n_m_n.length > 0) {
                    //     console.log({proyecto: parte.proyecto_n_m_n[0].proyecto.name});
                    // }
                    const rutaEnlace = (venta.venta_confirm) ? `/admin/ventas/download_factura/${venta.idVenta}` : `/admin/ventas/albaran/${venta.idVenta}`;
                    const nombreCliente = `${venta.cliente.NombreCliente} ${venta.cliente.ApellidoCliente}`;
                    rowData[venta.idVenta] = {
                        ID: venta.idVenta,
                        Fecha: formatDateYYYYMMDD(venta.FechaVenta),
                        Emp: venta.empresa.EMP,
                        Cliente: nombreCliente,
                        Agente: venta.AgenteVenta,
                        FPago: (venta.formaPago == 1) ? 'Banco' : 'Efectivo',
                        Estado: (venta.venta_confirm) ? 'Facturado' : 'Albarán',
                        Enlace: rutaEnlace,
                        Importe: formatPrice(venta.ImporteVenta),
                        IVA: venta.IVAVenta+'%',
                        Plazo: venta.Plazos,
                        TIva: formatPrice(venta.TotalIvaVenta),
                        Retenciones: venta.RetencionesVenta+'%',
                        Cobrado: formatPrice(venta.Cobrado),
                        AContable: venta.NAsientoContable,
                        Observaciones: venta.Observaciones,
                        Total: formatPrice(venta.TotalFacturaVenta),
                        Pendiente: formatPrice(venta.PendienteVenta),
                        Notas1: venta.notas1,
                        Notas2: venta.notas2,
                        Acciones: 
                        `
                            <?php $__env->startComponent('components.actions-button'); ?>
                                <button 
                                    type="button" 
                                    class="btn btn-outline-primary detailsVentaBtn" 
                                    data-id="${venta.idVenta}"
                                    data-bs-placement="top"
                                    title="Detalles de la Venta"
                                    data-bs-toggle="tooltip"
                                >
                                    <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                        <ion-icon name="information-circle-outline"></ion-icon>
                                        <small>Detalles</small>
                                    </div>
                                </button>
                                    ${ (venta.venta_confirm == null) ? `
                                        <button 
                                            type="button" 
                                            class="btn btn-info editVentaBtn" 
                                            data-id="${venta.idVenta}"
                                            data-bs-placement="top"
                                            title="Editar Venta"
                                            data-bs-toggle="tooltip"
                                        >
                                            <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                                <ion-icon name="create-outline"></ion-icon>
                                                <small>Editar</small>
                                            </div>
                                        </button>
                                        <a 
                                            class="btn btn-success generateAlbaran" 
                                            href="/admin/ventas/albaran/${venta.idVenta}" 
                                            target="_blank"
                                            data-bs-placement="top"
                                            title="Albarán"
                                            data-bs-toggle="tooltip"
                                        >
                                            <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                                <ion-icon name="document-attach-outline"></ion-icon>
                                                <small>Albarán</small>
                                            </div>
                                        </a>
                                    ` : ''}
                                <a 
                                    class="btn btn-warning ${ (venta.venta_confirm == null) ? 'generateFactura' : '' }" 
                                    href="${ (venta.venta_confirm == null) ? `/admin/ventas/factura/${venta.idVenta}` : `/admin/ventas/download_factura/${venta.idVenta}` }" 
                                    target="_blank"
                                    data-bs-placement="top"
                                    data-ventaid="${venta.idVenta}"
                                    title="${ (venta.venta_confirm !== null) ? 'Descargar Factura' : 'Facturar' }"
                                    data-bs-toggle="tooltip"
                                >
                                    <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                        ${ (venta.venta_confirm == null) ? `
                                            <ion-icon name="cash-outline"></ion-icon>
                                        ` : `
                                            <ion-icon name="cloud-download-outline"></ion-icon>
                                        `}
                                        <small>${ (venta.venta_confirm == null) ? 'Facturar' : 'Descargar' }</small>
                                    </div>
                                </a>
                            <?php echo $__env->renderComponent(); ?>
                        
                        `
                    }
                });

                data = Object.values(rowData);
            }

            prepareRowData(ventas);

            const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
                const customButtons = `
                    <button type="button" class="btn btn-outline-warning createVentaBtn">
                        <div class="d-flex justify-between align-items-center align-content-center">
                            <small>Crear Venta</small>
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                    </button>
                `;

                // Inicializar la tabla de citas
                inicializarAGtable( agTablediv, data, result, 'Ventas', customButtons, 'Ventas');
            });

            let table = $(tableGrid);

            table.off(); // Limpiar todos los eventos previos

            const calcularTotales = ( id ) => {
                let totalFactura = 0;
                let totalIva = parseFloat($('#IvaVenta').val()) || 0;
                let suplidos = parseFloat($('#SuplidosVenta').val()) || 0;
                let retenciones = parseFloat($('#RetencionesVenta').val()) || 0;
                let totalRetenciones = parseFloat($('#TotalRetencionesVenta').val()) || 0;
    
                $('#elementsToShow tr').each(function() {
                    let totalLinea = parseFloat($(this).find('.total-linea').text());
                    totalFactura += totalLinea;
                });

                const totalIvaParte = totalFactura - (totalFactura / (1 + (totalIva / 100)));
    
                totalIva = totalIvaParte;
                totalIva = parseFloat(totalIva.toFixed(2));

                totalRetenciones = totalFactura * (retenciones / 100);
                totalRetenciones = parseFloat(totalRetenciones.toFixed(2));
    
                totalFactura += suplidos - totalRetenciones;
                totalFactura = parseFloat(totalFactura.toFixed(2));

                let pendienteVenta = totalFactura - parseFloat( $('#Cobrado').val() );
                let cobrado = parseFloat($('#Cobrado').val());

                totalFactura.toFixed(2);
                totalIva.toFixed(2);
                totalRetenciones.toFixed(2);
                pendienteVenta.toFixed(2);
                cobrado.toFixed(2);

    
                $('#TotalIvaVenta').val(totalIva.toFixed(2));
                $('#TotalRetencionesVenta').val(totalRetenciones.toFixed(2));
                $('#TotalFacturaVenta').val(totalFactura.toFixed(2));
                $('#PendienteVenta').val(pendienteVenta.toFixed(2));
    
                if ( id ) {
                    $.ajax({
                        url: '/admin/lineasventas/update/' + id,
                        method: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            totalFactura,
                            totalIva,
                            suplidos,
                            retenciones,
                            totalRetenciones,
                            cobrado,
                            pendiente: pendienteVenta,
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
    
            }

            const calcularTotalesEdit = ( id ) => {
                let totalFactura = 0;
                let totalIva = parseFloat($('#editVentaModal #IvaVenta').val()) || 0;
                let suplidos = parseFloat($('#editVentaModal #SuplidosVenta').val()) || 0;
                let retenciones = parseFloat($('#editVentaModal #RetencionesVenta').val()) || 0;
                let totalRetenciones = parseFloat($('#editVentaModal #TotalRetencionesVenta').val()) || 0;
    
                $('#editVentaModal #elementsToShow tr').each(function() {
                    let totalLinea = parseFloat($(this).find('.total-linea').text());
                    totalFactura += totalLinea;
                });
    
                const totalIvaParte = totalFactura - (totalFactura / (1 + (totalIva / 100)));
    
                totalIva = totalIvaParte;
                totaliva = parseFloat(totalIva.toFixed(2));

                totalRetenciones = totalFactura * (retenciones / 100);
                totalRetenciones = parseFloat(totalRetenciones.toFixed(2));
    
                totalFactura += totalIva + suplidos - totalRetenciones;
                totalFactura = parseFloat(totalFactura.toFixed(2));

                let pendienteVenta = totalFactura - parseFloat( $('#editVentaModal #Cobrado').val() );
                let cobrado = parseFloat($('#editVentaModal #Cobrado').val());

                totalFactura.toFixed(2);
                totalIva.toFixed(2);
                totalRetenciones.toFixed(2);
                pendienteVenta.toFixed(2);
                cobrado.toFixed(2);

                $('#editVentaModal #TotalIvaVenta').val(totalIva.toFixed(2));
                $('#editVentaModal #TotalRetencionesVenta').val(totalRetenciones.toFixed(2));
                $('#editVentaModal #TotalFacturaVenta').val(totalFactura.toFixed(2));
                $('#editVentaModal #PendienteVenta').val(pendienteVenta.toFixed(2));
    
                if ( id ) {
                    $.ajax({
                        url: '/admin/lineasventas/update/' + id,
                        method: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            totalFactura,
                            totalIva,
                            suplidos,
                            retenciones,
                            totalRetenciones,
                            cobrado,
                            pendiente: pendienteVenta
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
    
            }
    
            // Mostrar modal para crear nueva venta
            table.on('click','.createVentaBtn', function (e) {
                e.preventDefault();
                $('#createVentaModal').modal('show');
                $('#createVentaTitle').text('Crear Venta');
                $('#createVentaForm')[0].reset(); // Reiniciar formulario

                // Limpiar tabla de elementos
                $('#createVentaModal #elementsToShow').empty();

                $('#createVentaModal #FechaVenta').val(new Date().toISOString().split('T')[0]);
                $('#createVentaModal #AgenteVenta').val('<?php echo e(Auth::user()->name); ?>');
                $('#createVentaModal #EnviadoVenta').val('<?php echo e(Auth::user()->email); ?>');
                $('#createVentaModal #NAsientoContable').val(1);
                $('#createVentaModal #Observaciones').val('Sin observaciones');
                $('#createVentaModal #TotalIvaVenta').val(0);
                $('#createVentaModal #TotalRetencionesVenta').val(0);
                $('#createVentaModal #TotalFacturaVenta').val(0);
                $('#v #Observaciones').val('Sin observaciones');

                // Inicializar Select2

                // Destruir la instancia de Select2, si existe
                if ($('#createVentaModal .form-select').data('select2')) {
                    $('#createVentaModal .form-select').select2('destroy');
                }

                // Inicializa Select2
                $('#createVentaModal .form-select').select2({
                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                    dropdownParent: $('#createVentaModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                    placeholder: 'Seleccione un cliente',
                });


            });
    
            // Calcular el total del IVA a partir del importe y almacenarlo
            $('#IvaVenta').on('change', function() {
                calcularTotales();
            });
    
            // calcular el valor a partir de las retenciones
            $('#RetencionesVenta').on('change', function() {
                calcularTotales();
            });
    
            $('#createVentaModal #Cobrado').on('focusout', function() {
                if ( $('#Cobrado').val() === '' ) {
                    Swal.fire({
                        title: 'Advertencia',
                        text: 'El valor cobrado no puede estar vacío',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
            });
    
            // Calcular el cobrado y el pendiente a partir del total de la factura
            $('#createVentaModal #Cobrado').on('change', function() {
                let totalFactura = parseFloat($('#TotalFacturaVenta').val());
    
                if ( $('#Cobrado').val() === '' ) {
                    Swal.fire({
                        title: 'Advertencia',
                        text: 'El valor cobrado no puede estar vacío',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
    
                let cobrado = parseFloat($('#Cobrado').val());
    
                cobrado = isNaN(cobrado) ? 0 : cobrado;
    
                if ( cobrado < 0 ) {
                    Swal.fire({
                        title: 'Error',
                        text: 'El valor cobrado no puede ser menor a 0',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
    
                if ( isNaN(cobrado) ) {
                    $('#Cobrado').val(0);
                }
    
                let pendiente = totalFactura - cobrado;
    
                if (pendiente < 0) {
                    Swal.fire({
                        title: 'Error',
                        text: 'El valor cobrado no puede ser mayor al total de la factura',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    $('#Cobrado').val(0);
                    $('#PendienteVenta').val(totalFactura);
                    return;
                }
    
                $('#PendienteVenta').val(pendiente);
            });
    
            // Actualizar el total de la factura con los suplidos
            $('#SuplidosVenta').on('change', function() {
                calcularTotales();
            });
    
            // Guardar nueva venta
            $('#guardarVenta').click(function () {
                openLoader();
                const table = $('#tableToShowElements');
                const elements = $('#elementsToShow');
    
                // Ocultar tabla de elementos
                table.hide();
                
                // Obtener los datos del formulario en un objeto FormData
                const formData = new FormData($('#createVentaForm')[0]);
    
                // Agregar el token CSRF manualmente si no se incluye automáticamente en el formulario
                formData.append('_token', '<?php echo e(csrf_token()); ?>');
    
                $.ajax({
                    url: '<?php echo e(route("admin.ventas.store")); ?>',
                    method: 'POST',
                    data: formData,
                    processData: false,  // No procesar los datos (FormData no necesita ser procesado)
                    contentType: false,  // No establecer automáticamente el tipo de contenido
                    success: function({ message, venta, cliente, archivos, articulos, ordenes, partes, proyectos, ventaEmp }) {
                        closeLoader();
                        // Cerrar primer acordeón y abrir el segundo
                        $('#collapseDetallesVenta').collapse('hide');
                        $('#collapseLineasVenta').collapse('show');
    
                        Swal.fire({
                            title: 'Venta guardada',
                            text: message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });

                        partes = Object.values(partes);
    
                        ventaGuardadaGlobal = true;
                        $('#guardarVenta').attr('disabled', true);
    
                        if (ventaGuardadaGlobal) {
                            // Desactivar todos los inputs del formulario de venta
                            $('#createVentaForm input, #createVentaForm select, #createVentaForm textarea').attr('disabled', true);
    
                            $('#addNewLine').off('click').on('click', function() {
                                globalLineas++;
    
                                let newLine = `
                                    <form id="AddNewLineForm${globalLineas}" class="mt-2 mb-2">
                                        <div class="row">
                                            <input type="hidden" id="venta_id" name="venta_id" value="${venta.idVenta}">
                                            <input type="hidden" id="clienteId" name="cliente_id" value="${cliente.idCliente}">
                                            <input type="hidden" id="clienteNameId" name="cliente_name" value="${cliente.nombre}">
                                            <input type="hidden" id="archivoId" name="archivo_id" value="${venta.archivoId}">
                                            <input type="hidden" id="totalFactura" name="totalFactura" value="${venta.TotalFacturaVenta}">
                                            <input type="hidden" id="sumaTotalesLineas" data-value="0">
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="venderProyecto${globalLineas}">
                                                        <input type="checkbox" id="venderProyecto${globalLineas}" class="venderProyectoCheckbox"> Vender Proyecto
                                                    </label>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group select-container" id="ordenTrabajoContainer${globalLineas}">
                                                    <label for="ordenTrabajo${globalLineas}">Parte de trabajo</label>
                                                    <select class="form-select ordenTrabajo" id="ordenTrabajo${globalLineas}" name="ordenTrabajo" required>
                                                        <option value="" selected>Seleccione un parte de trabajo</option>
                                                        ${partes.map(parte => `
                                                            <option 
                                                                data-tipo="parte" 
                                                                data-lineas="${parte.lineas}" 
                                                                data-valorparte="${parte.totalParte}" 
                                                                value="${parte.idParteTrabajo}"
                                                            >
                                                                Num ${parte.idParteTrabajo} | ${( parte.tituloParte) ? parte.tituloParte : parte.Asunto }
                                                            </option>`
                                                        ).join('')}
                                                    </select>
                                                </div>
    
                                                <div class="form-group select-container" id="proyectoContainer${globalLineas}" style="display: none;">
                                                    <label for="proyecto${globalLineas}">Proyecto</label>
                                                    <select class="form-select proyecto" id="proyecto${globalLineas}" name="proyecto">
                                                        <option value="">Seleccione un proyecto</option>
                                                        ${proyectos.map(proyecto => `
                                                            <option 
                                                                value="${proyecto.idProyecto}"
                                                            >
                                                                Num ${proyecto.idProyecto} | ${proyecto.name}
                                                            </option>
                                                        `).join('')}
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div id="containerArticulo${globalLineas}" class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label for="articulo${globalLineas}">Artículo</label>
                                                    <select class="form-select articulo" id="articulo${globalLineas}" name="articulo[]" required disabled>
                                                        <option value="">Seleccione un artículo</option>
                                                        ${articulos.map(articulo => `<option data-trazabilidad="${articulo.TrazabilidadArticulos}" value="${articulo.idArticulo}">${articulo.nombreArticulo}</option>`).join('')}
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cantidad${globalLineas}">Cantidad</label>
                                                    <input type="number" class="form-control cantidad" id="cantidad${globalLineas}" name="cantidad" value="1" step="0.01" required disabled>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="precioSinIva${globalLineas}">Precio sin iva</label>
                                                    <input type="number" class="form-control precioSinIva" id="precioSinIva${globalLineas}" name="precioSIva" step="0.01" required disabled>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="descuento${globalLineas}">Descuento</label>
                                                    <input type="number" class="form-control descuento" id="descuento${globalLineas}" name="descuento" step="0.01" value="0" required disabled>
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="total${globalLineas}">Total</label>
                                                    <input type="number" class="form-control total" id="total${globalLineas}" name="total" step="0.01" required disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-success saveLinea" data-line="${globalLineas}">Guardar</button>    
                                    </form>
                                `;
    
                                $('#newLinesContainer').append(newLine);

                                // Inicializa Select2
                                $('select.form-select').select2({
                                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                                    dropdownParent: $('#createVentaModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                                });

                                $(`ordenTrabajoContainer${globalLineas}`).off('change').on('change', function(){
                                    // desbloquear el campo descuento
                                    $(`#descuento${globalLineas}`).prop('disabled', false);

                                    // si el valor de la orden de trabajo cambia a un valor vacio, limpiar los campos y bloquearlos
                                    if ( $(this).val() === '' ) {
                                        $(`#cantidad${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#precioSinIva${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#descuento${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#total${globalLineas}`).val(0).prop('disabled', true);
                                        $(`#containerArticulo${globalLineas}`).addClass('d-none');
                                        $(`#articulo${globalLineas}`).val('').trigger('change').prop('disabled', true);
                                    }

                                });
    
                                // Toggle visibility based on checkbox state
                                $(`#venderProyecto${globalLineas}`).off('change').on('change', function() {
                                    if ($(this).is(':checked')) {
                                        $(`#proyectoContainer${globalLineas}`).show();
                                        $(`#ordenTrabajoContainer${globalLineas}`).hide();
                                        $(`#articulo${globalLineas}`).prop('disabled', false).show();
                                        $(`#cantidad${globalLineas}`).prop('disabled', false);
                                        $(`#precioSinIva${globalLineas}`).prop('disabled', false);
                                        $(`#descuento${globalLineas}`).prop('disabled', false);
                                        $(`#total${globalLineas}`).prop('disabled', false);
                                        $(`#containerArticulo${globalLineas}`).removeClass('d-none');
                                    } else {
                                        $(`#proyectoContainer${globalLineas}`).hide();
                                        $(`#ordenTrabajoContainer${globalLineas}`).show();
                                        $(`#cantidad${globalLineas}`).prop('disabled', true).val('');
                                        $(`#precioSinIva${globalLineas}`).prop('disabled', true).val('');
                                        $(`#descuento${globalLineas}`).prop('disabled', true).val('');
                                        $(`#total${globalLineas}`).prop('disabled', true).val('');
                                        $(`#containerArticulo${globalLineas}`).addClass('d-none');
                                        $(`#articulo${globalLineas}`).prop('disabled', true).val('').trigger('change').hide();
                                    }
                                });
    
                                // cargar en articulos los partes de trabajo correspondientes al proyecto seleccionado
                                $(`#proyecto${globalLineas}`).off('change').on('change', function() {
                                    const proyectoId = $(this).val();
                                    const form = $(this).closest('form');
                                    const articuloSelect = form.find('.articulo');
                                    let sumaTotalVentas = 0;
                                    if (proyectoId) {
                                        articuloSelect.attr('disabled', false);
                                        $.ajax({
                                            url: `/admin/proyectos/${proyectoId}/partes`,
                                            method: 'GET',
                                            beforeSend: function() {
                                                articuloSelect.empty();
                                                articuloSelect.append('<option>Cargando...</option>');
                                                openLoader();
                                            },
                                            success: function(response) {
                                                articuloSelect.empty();
                                                articuloSelect.attr('disabled', false);
                                                articuloSelect.attr('multiple', "multiple");
                                                response.partes.forEach(parte => {

                                                    // validar si algun parte de trabajo aun no se ha finalizado
                                                    if (parte.parte_trabajo.Estado == '2') {
                                                        Swal.fire({
                                                            title: 'Error',
                                                            text: 'El parte de trabajo con asunto ' + parte.parte_trabajo.Asunto + ' aún no ha sido finalizado',
                                                            icon: 'error',
                                                            confirmButtonText: 'Aceptar'
                                                        });
                                                        articuloSelect.val('').trigger('change');
                                                        closeLoader();
                                                        return;
                                                    }

                                                    // TODO: validar que los partes de trabajo, sus articulos pertenecen a la empresa que esta creando la venta
                                                    articuloSelect.append(`
                                                    <option 
                                                        data-tipo="parte"
                                                        data-lineas=${JSON.stringify(parte.parte_trabajo.partes_trabajo_lineas)}
                                                        data-suma="${parte.parte_trabajo.totalParte}"
                                                        value="${parte.parte_trabajo.idParteTrabajo}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="${parte.parte_trabajo.Asunto} | Visita: ${parte.parte_trabajo.FechaVisita}"
                                                    >
                                                        Num ${parte.parte_trabajo.idParteTrabajo} | ${ (parte.parte_trabajo.tituloParte) ? parte.parte_trabajo.tituloParte : parte.parte_trabajo.Asunto }
                                                    </option>
                                                    `);
                                                    sumaTotalVentas += parte.parte_trabajo.totalParte;
                                                });

                                                // seleccionar todos los articulos
                                                articuloSelect.val(response.partes.map(parte => parte.parte_trabajo.idParteTrabajo));
                                                closeLoader();

                                                //convertir el selector de articulos en un select2
                                                // Destruir la instancia de Select2, si existe
                                                if ($('.articulo').data('select2')) {
                                                    $('.articulo').select2('destroy');
                                                }
                                                // Inicializa Select2
                                                $('.articulo').select2({
                                                    width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                                                    dropdownParent: $('#createVentaModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                                                });

                                                // seleccionar todos los articulos
                                                articuloSelect.val(response.partes.map(parte => parte.parte_trabajo.idParteTrabajo));

                                                $(`#precioSinIva${globalLineas}`).val(sumaTotalVentas).attr('disabled', true);
                                                $(`#cantidad${globalLineas}`).val(response.partes.length).attr('disabled', true);
                                                $(`#total${globalLineas}`).val(sumaTotalVentas).attr('disabled', true);
                                                $('#sumaTotalesLineas').data('value', sumaTotalVentas).attr('disabled', true);
                                                
                                                // Calcular el total de ventas de los partes seleccionados si quito una parte restarle el valor al total

                                                articuloSelect.on('change', function() {
                                                    let total           = 0;
                                                    let selectedOptions = $(this).find('option:selected');
                                                    let lineas          = [];

                                                    selectedOptions.each(function() {
                                                        total += parseFloat($(this).data('suma'));
                                                        lineas.push($(this).data('lineas'));
                                                    });

                                                    lineas = lineas.map((linea) => {
                                                        if (linea.length > 0) {
                                                            return linea;
                                                        }
                                                    })

                                                    console.log({
                                                        lineas
                                                    })

                                                    const validateEmp = lineas.every((linea) => linea.articulo.empresa_id === ventaEmp);
                                                    const idsQueNoPertenecen = lineas.filter((linea) => linea.articulo.empresa_id !== ventaEmp).map((linea) => linea.articulo.empresa_id);

                                                    console.log({
                                                        validateEmp,
                                                        idsQueNoPertenecen
                                                    })

                                                    if (!validateEmp) {
                                                        Swal.fire({
                                                            title: 'Warning',
                                                            text: 'Hay partes de trabajo con materiales de otra empresa, ¿quieres realizar un traspaso de materiales?',
                                                            icon: 'warning',
                                                            confirmButtonText: 'Aceptar',
                                                            showCancelButton: true,
                                                            cancelButtonText: 'Cancelar'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // redirigir a la vista de traspaso de materiales
                                                                
                                                                $.ajax({
                                                                    url: "<?php echo e(route('admin.traspasos.store')); ?>",
                                                                    method: 'POST',
                                                                    data: {
                                                                        _token: '<?php echo e(csrf_token()); ?>',
                                                                        ids: idsQueNoPertenecen
                                                                    },
                                                                    success: function(response) {
                                                                        Swal.fire({
                                                                            title: 'Traspaso realizado',
                                                                            text: response.message,
                                                                            icon: 'success',
                                                                            confirmButtonText: 'Aceptar'
                                                                        })

                                                                    },
                                                                    error: function(error) {
                                                                        console.error(error);
                                                                    }
                                                                });

                                                            } else {
                                                                articuloSelect.val('').trigger('change');
                                                            }
                                                        });
                                                    }

                                                    $(`#precioSinIva${globalLineas}`).val(total).attr('disabled', true);
                                                    $(`#cantidad${globalLineas}`).val(selectedOptions.length).attr('disabled', true);
                                                    $(`#total${globalLineas}`).val(total).attr('disabled', true);
                                                    $('#sumaTotalesLineas').data('value', total).attr('disabled', true);
                                                });
                                                
                                            },
                                            error: function(error) {
                                                console.error(error);
                                                closeLoader();
                                            }
                                        });
                                    } else {
                                        articuloSelect.attr('disabled', true);
                                    }
                                });
    
                                // Activar el selector de artículos solo cuando se selecciona una orden de trabajo
                                $('#newLinesContainer').off('change', `#ordenTrabajo${globalLineas}`).on('change', `#ordenTrabajo${globalLineas}`, function () {
                                    const ordenTrabajoId = $(this).val();
                                    const form = $(this).closest('form');
                                    const articuloSelect = form.find('.articulo');
                                    
                                    // obtener el valor de la orden de trabajo
                                    let tipo = $(this).find('option:selected').data('tipo') || 'Parte';
                                    let suma = $(this).find('option:selected').data('valorparte') || 0;

                                    suma = parseFloat(suma);
                                    suma = suma.toFixed(2);
    
                                    // añadir el valor de la orden de trabajo al precio sin iva
                                    $(`#precioSinIva${globalLineas}`).val(suma).attr('disabled', true);
                                    $(`#cantidad${globalLineas}`).val(1).attr('disabled', true);
                                    $(`#total${globalLineas}`).val(suma).attr('disabled', true);
                                    $(`#descuento${globalLineas}`).val(0).attr('disabled', false);
                                });
    
                                // Delegar eventos en el contenedor para manejar los cambios de los campos dinámicos
                                $('#newLinesContainer').on('change', `#articulo${globalLineas}`, function () {
                                    const articuloId = parseInt($(this).val());
                                    const form = $(this).closest('form');
                                    const precioSinIvaInput = form.find('.precioSinIva');
                                    const cantidadInput = form.find('.cantidad');
                                    const totalInput = form.find('.total');
                                    const descuentoInput = form.find('.descuento');
    
                                    // Buscar el artículo seleccionado para obtener su precio
                                    const articulo = articulos.find(art => art.idArticulo === articuloId);
                         
                                    if (articulo) {
                                        precioSinIvaInput.val(articulo.ptsVenta).attr('disabled', false);
                                        cantidadInput.attr('disabled', false);
                                        descuentoInput.attr('disabled', false);
                                        totalInput.val(cantidadInput.val() * articulo.ptsVenta);
                                        calcularTotales();
                                    }
                                });
    
                                $('#newLinesContainer').on('change', `#cantidad${globalLineas}`, function () {
                                    const cantidad = $(this).val();
                                    const form = $(this).closest('form');
                                    const precioSinIvaInput = form.find('.precioSinIva').val();
                                    const descuentoInput = form.find('.descuento').val();
                                    const totalInput = form.find('.total');
    
                                    if (cantidad && precioSinIvaInput) {
                                        const total = cantidad * precioSinIvaInput - descuentoInput;
                                        totalInput.val(total);
                                        calcularTotales();
                                    }
                                });
    
                                $('#newLinesContainer').on('change', `#precioSinIva${globalLineas}`, function () {
                                    const precioSinIva = $(this).val();
                                    const form = $(this).closest('form');
                                    const cantidad = form.find('.cantidad').val();
                                    const descuentoInput = form.find('.descuento').val();
                                    const totalInput = form.find('.total');
    
                                    if (precioSinIva && cantidad) {
                                        const total = cantidad * precioSinIva - descuentoInput;
                                        totalInput.val(total);
                                        calcularTotales();
                                    }
                                });
    
                                $('#newLinesContainer').on('change', `#descuento${globalLineas}`, function () {
                                    const descuento = parseFloat($(this).val());
                                    const form      = $(this).closest('form');
                                    const cantidad  = parseFloat(form.find('.cantidad').val());
                                    const precioSinIvaInput = parseFloat(form.find('.precioSinIva').val());
                                    const totalInput = form.find('.total');

                                    // validar si es un proyecto
                                    const proyecto = form.find('.proyecto').val();

                                    // el valor del descuento no puede ser mayor al 100%
                                    if (descuento > 100 || descuento < 0) {
                                        Swal.fire({
                                            title: 'warning',
                                            text: 'El descuento no puede ser mayor al 100%',
                                            icon: 'error',
                                            confirmButtonText: 'Aceptar'
                                        });
                                        $(this).val(0);
                                        return;
                                    }

                                    if (descuento == 0) {
                                        totalInput.val(cantidad * precioSinIvaInput);
                                        calcularTotales();
                                        return;
                                    }

                                    if (proyecto) {
                                        // const porcentaje = parseFloat(descuento);
                                        // const precioSinIva = parseFloat(precioSinIvaInput);
                                        // const total = precioSinIva - (precioSinIva * (porcentaje / 100));
                                        let precio = precioSinIvaInput * cantidad;
                                        let descuentoAplicado = precio * (descuento / 100);
                                        let lineaDescuento = precio - descuentoAplicado;
                                        let total = lineaDescuento;

                                        totalInput.val(total.toFixed(2));
                                        calcularTotales();
                                        return;
                                    }
                                    
                                    if (descuento && cantidad && precioSinIvaInput) {
                                        let precio = precioSinIvaInput * cantidad;
                                        let descuentoAplicado = precio * (descuento / 100);
                                        let lineaDescuento = precio - descuentoAplicado;
                                        let total = lineaDescuento;

                                        totalInput.val(total.toFixed(2));
                                        calcularTotales();
                                    }
                                });
                            });
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al guardar la venta',
                            icon: 'error',
                            footer: error.message,
                            confirmButtonText: 'Aceptar'
                        });
                        closeLoader();
                    }
                });
            });
    
            // Función para calcular la suma de los totales de las líneas existentes
            const calcularSumaTotalesLineas = () => {
                let sumaTotales = 0;
                $('#elementsToShow tr').each(function() {
                    let total = parseFloat($(this).find('td:last-child').text());
                    if (!isNaN(total)) {
                        sumaTotales += total;
                    }
                });
                return sumaTotales;
            }
    
            // Delegar evento de guardado para las líneas dinámicas
            $('#collapseLineasVenta').on('click', '.saveLinea', function () {
                const lineNumber = $(this).data('line');
                const form = $(`#AddNewLineForm${lineNumber}`);
                const ordenTrabajoId = form.find(`#ordenTrabajo${lineNumber}`).val();
                const articuloId = form.find(`#articulo${lineNumber}`).val();
                const cantidad = parseFloat(form.find(`#cantidad${lineNumber}`).val());
                const precioSIva = parseFloat(form.find(`#precioSinIva${lineNumber}`).val());
                const descuento = parseFloat(form.find(`#descuento${lineNumber}`).val());
                const total = parseFloat(form.find(`#total${lineNumber}`).val());
    
                $('#sumaTotalesLineas').data('value', calcularSumaTotalesLineas());
    
                let cliente = {
                    idCliente: form.find('#clienteId').val(),
                    nombreCliente: form.find('#clienteNameId').val()
                };
    
                let archivos = {
                    idarchivos: form.find('#archivoId').val()
                };
    
                let venta = {
                    idVenta: form.find('#venta_id').val(),
                    totalFactura: parseFloat(form.find('#totalFactura').val()) // Asegurarse que se convierte a float
                };
    
                // Obtener la suma de las líneas existentes y agregar la nueva
                let sumaTotalesLineas = calcularSumaTotalesLineas() + total;
    
                // Validar si la suma total supera el total de la factura
                // if (sumaTotalesLineas > venta.totalFactura) {
                //     Swal.fire({
                //         title: 'Error',
                //         text: 'El total de las líneas no puede ser mayor al total de la factura',
                //         icon: 'error',
                //         confirmButtonText: 'Aceptar'
                //     });
                    
                //     return;
                // }
    
                // Validaciones de campos obligatorios
                if (cliente.idCliente === '' || cliente.idCliente === undefined || cliente.idCliente === null) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al guardar la línea, primero debe guardar la venta',
                        icon: 'error',
                        footer: 'No se han podido obtener los datos de la venta',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }
    
                const table = $('#tableToShowElements');
                const elements = $('#elementsToShow');
    
                // Mostrar tabla de elementos
                table.show();
    
                //obtener el tipo de orden
                let tipo = $(`#ordenTrabajo${lineNumber} option:selected`).data('tipo');
    
                $.ajax({
                    url: '<?php echo e(route("admin.lineasventas.store")); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        orden_trabajo_id: ordenTrabajoId,
                        articulo_id: articuloId,
                        cantidad,
                        precioSinIva: precioSIva,
                        descuento,
                        total,
                        venta_id: venta.idVenta,
                        tipo,
                    },
                    success: function({ status, message, venta, articulos, ordenes, cliente, linea, code, ok, lineas }) {
    
                        if ( ok == false ) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ha ocurrido un error al guardar la línea',
                                icon: 'error',
                                footer: message,
                                confirmButtonText: 'Aceptar'
                            });
                            return;
                        }
    
                        if ( lineas ) {
                            
                            lineas.forEach(linea => {
                            
                                const newElement = `
                                    <tr>
                                        <td>${lineNumber}</td>
                                        <td>${linea.parte_trabajo.Asunto}</td>
                                        <td>${linea.Descripcion}</td>
                                        <td>${linea.Cantidad}</td>
                                        <td>${linea.descuento}</td>
                                        <td class="total-linea">${linea.total}€</td>
                                    </tr>
                                `;
                                elements.append(newElement);
                            });
    
                        }else{
                            //remover "Descripcion de la parte" de linea.Descripcion
                            let descripcion = linea.Descripcion;
                            let separarPorEspacios = descripcion.split(' ');
                            // eliminar desde la posicion 0 hasta la posicion 3
                            separarPorEspacios.splice(0, 3);
                            descripcion = separarPorEspacios.join(' ');
                            
                            let newElement = `
                            <tr>
                                <td>${lineNumber}</td>
                                <td>${descripcion}</td>
                                <td>${linea.Descripcion}</td>
                                <td>${linea.Cantidad}</td>
                                <td>${linea.descuento}</td>
                                <td class="total-linea">${linea.total}€</td>
                                </tr>
                            `;
                            elements.append(newElement);
                        }
    
    
                        calcularTotales(venta.idVenta);
    
                        Swal.fire({
                            title: 'Línea guardada',
                            text: message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
    
                        // Limpiar campos de la nueva línea y deshabilitarlos
                        form.find('textarea, input').val('').attr('disabled', true);
    
                        // Limpiar el contenedor de líneas nuevas
                        $('#newLinesContainer').empty();
    
                        $('#addNewLine').attr('disabled', false);
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
    
                $('#saveVentaBtn').on('click', function() {
                if (ventaGuardadaGlobal) {
                    
                    
    
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Primero debe guardar la venta antes de guardar las líneas',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
                });
    
            });
    
            table.on('click','.detailsVentaBtn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: `/admin/ventas/edit/${id}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.status === 'success') {
                            let venta = response.venta;
                            $('#createVentaForm #FechaVenta').val(venta.FechaVenta).attr('disabled', true);
                            $('#createVentaForm #AgenteVenta').val(venta.AgenteVenta).attr('disabled', true);
                            $('#createVentaForm #EnviadoVenta').val(venta.EnviadoVenta).attr('disabled', true);
                            $('#createVentaForm #cliente_id').val(venta.cliente_id).attr('disabled', true);
                            $('#createVentaForm #empresa_id').val(venta.empresa_id).attr('disabled', true);
                            $('#createVentaForm #FormaPago').val(venta.FormaPago).attr('disabled', true);
                            $('#createVentaForm #IvaVenta').val(venta.IVAVenta).attr('disabled', true);
                            $('#createVentaForm #TotalIvaVenta').val(venta.TotalIvaVenta).attr('disabled', true);
                            $('#createVentaForm #RetencionesVenta').val(venta.RetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalRetencionesVenta').val(venta.TotalRetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalFacturaVenta').val(venta.TotalFacturaVenta).attr('disabled', true);
                            $('#createVentaForm #SuplidosVenta').val(venta.SuplidosVenta).attr('disabled', true);
                            $('#createVentaForm #Plazos').val(venta.Plazos).attr('disabled', true);
                            $('#createVentaForm #Cobrado').val(venta.Cobrado).attr('disabled', true);
                            $('#createVentaForm #PendienteVenta').val(venta.PendienteVenta).attr('disabled', true);
                            $('#createVentaForm #NAsientoContable').val(venta.NAsientoContable).attr('disabled', true);
                            $('#createVentaForm #Observaciones').val(venta.Observaciones).attr('disabled', true);
    
                            // Limpiar y cargar las líneas de venta
                            $('#elementsToShow').empty();
                            venta.venta_lineas.forEach(linea => {
    
                                //remover "Descripcion de la parte" de linea.Descripcion
                                let descripcion = linea.Descripcion;
                                let separarPorEspacios = descripcion.split(' ');
                                // eliminar desde la posicion 0 hasta la posicion 3
                                separarPorEspacios.splice(0, 3);
                                descripcion = separarPorEspacios.join(' ');
    
                                $('#elementsToShow').append(`
                                    <tr>
                                        <td>${linea.idLineaVenta}</td>
                                        <td>${descripcion}</td>
                                        <td>${linea.Descripcion}</td>
                                        <td>${linea.Cantidad}</td>
                                        <td>${linea.descuento}</td>
                                        <td class="total-linea">${linea.total}€</td>
                                    </tr>
                                `);
                            });
    
                            $('#createVentaModal').modal('show');
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
    
            // Edit venta
            table.on('click', '.editVentaBtn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                getEditVenta(id);
            });

            table.on('dblclick', '.openEditVentaFast', function (e) {
                e.preventDefault();
                let id = $(this).data('parteid');
                getEditVenta(id);
            });

            table.on('dblclick', '.OpenHistorialCliente', function(event){
                const elemento  = $(this);
                const span      = elemento.find('span')[1]
                const parteid   = span.getAttribute('data-parteid');

                getEditCliente(parteid, 'Ventas');
            });

            // detalle de la venta
            $("#ventas").on('click', '.detailsVentaBtn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: `/admin/ventas/edit/${id}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.status === 'success') {
                            let venta = response.venta;
                            $('#createVentaForm #FechaVenta').val(venta.FechaVenta).attr('disabled', true);
                            $('#createVentaForm #AgenteVenta').val(venta.AgenteVenta).attr('disabled', true);
                            $('#createVentaForm #EnviadoVenta').val(venta.EnviadoVenta).attr('disabled', true);
                            $('#createVentaForm #cliente_id').val(venta.cliente_id).attr('disabled', true);
                            $('#createVentaForm #empresa_id').val(venta.empresa_id).attr('disabled', true);
                            $('#createVentaForm #FormaPago').val(venta.FormaPago).attr('disabled', true);
                            $('#createVentaForm #IvaVenta').val(venta.IVAVenta).attr('disabled', true);
                            $('#createVentaForm #TotalIvaVenta').val(venta.TotalIvaVenta).attr('disabled', true);
                            $('#createVentaForm #RetencionesVenta').val(venta.RetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalRetencionesVenta').val(venta.TotalRetencionesVenta).attr('disabled', true);
                            $('#createVentaForm #TotalFacturaVenta').val(venta.TotalFacturaVenta).attr('disabled', true);
                            $('#createVentaForm #SuplidosVenta').val(venta.SuplidosVenta).attr('disabled', true);
                            $('#createVentaForm #Plazos').val(venta.Plazos).attr('disabled', true);
                            $('#createVentaForm #Cobrado').val(venta.Cobrado).attr('disabled', true);
                            $('#createVentaForm #PendienteVenta').val(venta.PendienteVenta).attr('disabled', true);
                            $('#createVentaForm #NAsientoContable').val(venta.NAsientoContable).attr('disabled', true);
                            $('#createVentaForm #Observaciones').val(venta.Observaciones).attr('disabled', true);
    
                            // Limpiar y cargar las líneas de venta
                            $('#elementsToShow').empty();

                            // cambiar el titulo del modal
                            $('#createVentaModal .modal-title').text('Detalles de la venta');
                            
                            venta.venta_lineas.forEach(linea => {
    
                                //remover "Descripcion de la parte" de linea.Descripcion
                                let descripcion = linea.Descripcion;
                                let separarPorEspacios = descripcion.split(' ');
                                // eliminar desde la posicion 0 hasta la posicion 3
                                separarPorEspacios.splice(0, 3);
                                descripcion = separarPorEspacios.join(' ');
    
                                $('#elementsToShow').append(`
                                    <tr>
                                        <td>${linea.idLineaVenta}</td>
                                        <td>${descripcion}</td>
                                        <td>${linea.Descripcion}</td>
                                        <td>${linea.Cantidad}</td>
                                        <td>${linea.descuento}</td>
                                        <td class="total-linea">${linea.total}€</td>
                                    </tr>
                                `);

                            });

                            $('#createVentaForm button').hide();

                            $('#createVentaModal').modal('show');
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }

                });
            });

            // abrir modal con los plazos de la venta
            table.on('dblclick', '.openModalPlazos', function(event) {
                const ventaId = $(this).data('parteid');

                // limpiar el contenido del modal
                $('#plazosModal #plazosContainer').empty();

                getPlazosVenta(ventaId);
            });

            // Abrir el segundo modal para registrar cobro
            $(document).on('click', '.btnRegistrarCobro', function() {
                const plazoId = $(this).data('plazo-id');
                const total = parseFloat($(this).data('total'));
                const cobrado = parseFloat($(this).data('cobrado'));

                $('#plazoId').val(plazoId);
                $('#totalPlazo').val(total);
                $('#cobradoActual').val(cobrado);

                // autocomepltar el input de total a cobrar
                $('#montoCobro').val(total - cobrado);

                // fecha de cobro
                $('#fechaCobro').val(new Date().toISOString().split('T')[0]);

                $('#montoCobro').attr('max', total - cobrado); // Asegurar que no se supere el total
                $('#cobroModal').modal('show');

                $('#cobroModal').on('show.bs.modal', function() {
                    $('#montoCobro').focus();
                    // inicializar el select2
                    $('#cobroModal select.form-select').select2({
                        width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                        dropdownParent: $('#cobroModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                    });
                });

                $('#cobroModal').on('hidden.bs.modal', function() {
                    $('#montoCobro').val('');
                });

            });

            // Guardar el cobro
            $('#btnGuardarCobro').on('click', function() {
                const plazoId       = $('#plazoId').val();
                const montoCobro    = parseFloat($('#montoCobro').val());
                const total         = parseFloat($('#totalPlazo').val());
                const cobradoActual = parseFloat($('#cobradoActual').val());
   
                if (montoCobro + cobradoActual > total) {
                    Swal.fire({
                        title: 'Error',
                        text: 'El monto cobrado no puede superar el total del plazo.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                // Realizar el POST a la API
                $.ajax({
                    url: `/api/plazos/${plazoId}/cobros`, // Ajusta esta URL
                    method: 'POST',
                    data: {
                        monto: montoCobro,
                        fecha: $('#fechaCobro').val(),
                        banco: $('#bancoCobro').val(),
                        _token: '<?php echo e(csrf_token()); ?>',
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Exitoso',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });

                        $('#cobroModal').modal('hide');
                        $('#plazosModal').modal('hide'); // Opcional, para recargar plazos
                        
                    },
                    error: function(error) {
                        alert('Error al registrar el cobro.');
                    }
                });
            });

            // Evento para capturar el cierre del modal de #createVentaModal
            $('#createVentaModal').on('hidden.bs.modal', function () {
                $('#createVentaModal #elementsToShow').empty();
                $('#createVentaModal #createVentaForm textarea, input').val('').attr('disabled', false);

                

            });

            $('#saveEditVentaBtn').on('click', function(event){

                // tomar formulario y enviarlo por submit
                const id = $('#editVentaModal #idVenta').val();
                // cambiarle el attr de action para enviario al editar
                $('#createVentaForm').attr('action', `/admin/ventas/update/${id}`);

                // cambiar el metodo a POST
                $('#createVentaForm').attr('method', 'POST');

                // añaadir el token
                $('#createVentaForm').append('<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">');

                $('#createVentaForm').submit();

            });

        }

        function inicializarComprasTableEstadisticas(compras, tableGrid){
            // Inicializar la tabla de citas
            const agTablediv = document.querySelector(tableGrid);

            let rowData = {};
            let data = [];

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
                    rowData[compra.idCompra] = {
                        ID: compra.idCompra,
                        FechaCompra: formatDateYYYYMMDD(compra.fechaCompra),
                        NºFactura: compra.NFacturaCompra,
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

            let table = $(tableGrid);

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

                            $('#addNewLine').click(function() {
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

                                $('#newLinesContainer').append(newLine);

                                // evento para cod_prov${globalLineas} y si existe en la base de datos, traer la descripcion y el precio sin iva
                                $(`#cod_prov${globalLineas}`).off('change').on('change', function() {
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
                                $('#newLinesContainer').on('change', `#cantidad${globalLineas}`, function () {
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
                                $('#newLinesContainer').on('change', `#precioSinIva${globalLineas}`, function () {
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
                                $('#newLinesContainer').on('change', `#descuento${globalLineas}`, function () {
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
                                $('#newLinesContainer').on('change', `#RAE${globalLineas}`, function () {
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
            $('#newLinesContainer').on('click', '.saveLinea', function () {
                const lineNumber = $(this).data('line');
                const form = $(`#AddNewLineForm${lineNumber}`);
                const descripcion = form.find(`#descripcion${lineNumber}`).val();
                const cantidad = parseFloat(form.find(`#cantidad${lineNumber}`).val());
                const precioSIva = parseFloat(form.find(`#precioSinIva${lineNumber}`).val());
                const descuento = parseFloat(form.find(`#descuento${lineNumber}`).val());
                const total = parseFloat(form.find(`#total${lineNumber}`).val());
                const rae = parseFloat(form.find(`#RAE${lineNumber}`).val());
                const cod_prov = form.find(`#cod_prov${lineNumber}`).val();

                $('#sumaTotalesLineas').data('value', calcularSumaTotalesLineas());

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

                const table = $('#tableToShowElements');
                const elements = $('#elementsToShow');

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

                        // Limpiar el contenedor de líneas nuevas
                        $('#newLinesContainer').empty();

                        $('#addNewLine').attr('disabled', false);
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

            table.on('dblclick', '.openEditCompraFast', function (e) {
                e.preventDefault();
                let compraId = $(this).data('parteid');
                getInfoCompra(compraId, $(this));
            });

            table.on('dblclick', '.openEditCompraFast', function (e) {
                e.preventDefault();
                let id = $(this).data('parteid');
                getInfoCompra(compraId, $(this));
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
        }

        function getPlazosVenta(ventaId){
            // Obtener datos de la API (simulación)
            $.ajax({
                url: `/admin/ventas/${ventaId}/plazos`, // Ajusta esta URL según tu backend
                method: 'GET',
                beforeSend: function() {
                    openLoader();
                },
                success: function(response) {
                    closeLoader();
                    const plazos        = response.plazos; // Array de plazos devueltos por la API
                    const totalFactura  = response.totalFactura;
                    const venta         = response.venta;

                    // calcular el total dividido entre los plazos
                    const totalPlazos   = plazos.length;
                    const totalPorPlazo = totalFactura / totalPlazos;

                    $('#plazosModalTitle').text(`Plazos de la venta #${ventaId} con un total de ${totalFactura}€ al cliente ${venta.cliente.NombreCliente} ${venta.cliente.ApellidoCliente}`);

                    let html = '';

                    // insertar un ag grid con los plazos
                    $('#plazosContainer').append('<div id="PlazosVentasGrid" class="ag-theme-quartz" style="height: 90vh; z-index: 0"></div>');

                    // preparar los datos para el ag grid
                    let rowData = [];
                    let data = [];

                    const cobrado = venta.Cobrado;
                    const pendiente = venta.PendienteVenta;

                    // inicializar el ag grid

                    const agTablediv = document.querySelector('#PlazosVentasGrid');

                    const cabeceras = [ // className: 'id-column-class' PARA darle una clase a la celda
                        { 
                            name: 'ID',
                            fieldName: 'Plazo',
                            addAttributes: true, 
                            addcustomDatasets: true,
                            dataAttributes: { 
                                'data-id': ''
                            },
                            principal: true
                        },
                        { 
                            name: 'Fecha',
                            className: 'fecha-column'
                        },
                        { 
                            name: 'Total',
                            className: 'total-column'
                        },
                        { 
                            name: 'Cobrado',
                            className: 'cobrado-column'
                        },
                        {
                            name: 'Banco',
                            className: 'banco-column'
                        },
                        { 
                            name: 'Pendiente',
                            className: 'pendiente-column'
                        },
                        {
                            name: "FechaOperacion",
                            fieldName: 'fecha_operacion',
                        },
                        {
                            name: "ImporteOperacion",
                            fieldName: 'importe_operacion',
                        },
                        {
                            name: "SaldoOperacion",
                            fieldName: 'saldo_operacion',
                        },
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

                    function prepareRowData(plazos) {
                        plazos.forEach(plazo => {
                            
                            let fechaOperacion = '';
                            let importeOperacion = '';
                            let saldoOperacion = '';

                            if (plazo.banco) {

                                plazo.banco.banco_detail.filter(p => {
                                    if (p.plazo_id == plazo.plazo_id) {
                                        fechaOperacion = p.fecha_operacion;
                                        importeOperacion = p.importe;
                                        saldoOperacion = p.saldo;
                                    }
                                })
                                
                            }

                            rowData[plazo.plazo_id] = {
                                ID: plazo.plazo_id,
                                Fecha: plazo.fecha_pago,
                                Total: formatPrice(totalPorPlazo),
                                Cobrado: formatPrice(cobrado),
                                Pendiente: formatPrice(pendiente),
                                Banco: (plazo.banco) ? plazo.banco.nameBanco : 'No registrado',
                                FechaOperacion: (plazo.banco) ? fechaOperacion : 'No registrado',
                                ImporteOperacion: (plazo.banco) ? importeOperacion : 'No registrado',
                                SaldoOperacion: (plazo.banco) ? saldoOperacion : 'No registrado',
                                Notas1: plazo.notas1,
                                Notas2: plazo.notas2,
                                Acciones: `
                                    <?php $__env->startComponent('components.actions-button'); ?>
                                        <button 
                                            ${plazo.estadoPago == 2 ? 'disabled' : ''}
                                            class="btn btn-outline-primary btnRegistrarCobro" 
                                            data-plazo-id="${plazo.plazo_id}" 
                                            data-total="${totalFactura}" 
                                            data-cobrado="${venta.Cobrado}"
                                        >
                                            <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                                <small>Registrar Cobro</small>
                                                <ion-icon name="add-outline"></ion-icon>
                                            </div>
                                        </button>
                                    <?php echo $__env->renderComponent(); ?>
                                `
                            }
                        });

                        data = Object.values(rowData);
                    }

                    prepareRowData(plazos);

                    const resultCabeceras = armarCabecerasDinamicamente(cabeceras).then(result => {
                        const customButtons = `
                            <button type="button" class="btn btn-outline-warning createPlazobtn">
                                <div class="d-flex justify-between align-items-center align-content-center">
                                    <small>Crear Plazo</small>
                                    <ion-icon name="add-outline"></ion-icon>
                                </div>
                            </button>
                        `;

                        // Inicializar la tabla de citas
                        inicializarAGtable( agTablediv, data, result, 'Plazos', customButtons, 'PlazoCompra');
                    });

                    let table = $('#PlazosVentasGrid');

                    $('#plazosModal').modal('show');

                    table.on('click', '.createPlazobtn', function() {
                        $('#modalCreatePlazo').modal('show');
                    });

                    // registrar un nuevo plazo
                    $('#modalCreatePlazo').on('shown.bs.modal', function() {

                        // si pendienteVenta es 0, deshabilitar el campo monto cerrar el modal y mostrar mensaje
                        if (venta.PendienteVenta == 0) {
                            Swal.fire({
                                title: 'Venta saldada',
                                text: 'La venta ya ha sido saldada, no se pueden añadir más plazos',
                                icon: 'info',
                                confirmButtonText: 'Aceptar'
                            });

                            $('#modalCreatePlazo').modal('hide');

                            return;
                        }

                        const fechaHoy = moment().format('YYYY-MM-DD');
                        $('#modalCreatePlazo #fechaPago').val(fechaHoy);
                        $('#modalCreatePlazo #monto').val(venta.PendienteVenta);
                        
                        // hacer focus en el textarea de notas
                        $('#modalCreatePlazo #observaciones').focus();

                        // hacer validaciones en el campo monto no mayor al pendiente
                        $('#modalCreatePlazo #monto').off('change').on('change', function() {
                            const monto = parseFloat($(this).val());
                            const pendiente = parseFloat(venta.PendienteVenta);

                            if (monto > pendiente) {
                                $(this).val(pendiente);
                            }
                        });
                    });

                    // guardar el plazo
                    $('#btnSaveCreatePlazo').off('click').on('click', function(event){

                        const fechaPago = $('#modalCreatePlazo #fechaPago').val();
                        const monto     = $('#modalCreatePlazo #monto').val();
                        const notas1    = $('#modalCreatePlazo #observaciones').val();
                        const banco     = $('#modalCreatePlazo #banco').val();
                        const idVenta = venta.idVenta;

                        $.ajax({
                            url: '<?php echo e(route("admin.ventas.crearPlazoVenta")); ?>',
                            method: 'POST',
                            data: {
                                _token: '<?php echo e(csrf_token()); ?>',
                                fechaPago,
                                monto,
                                notas1,
                                idVenta,
                                banco
                            },
                            beforeSend: function() {
                                openLoader();
                            },
                            success: function(response) {
                                closeLoader();
                                Swal.fire({
                                    title: 'Plazo creado',
                                    text: 'El plazo se ha creado correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                });

                                $('#modalCreatePlazo').modal('hide');

                                // cerrar el modal de plazos recargar la tabla principal que contiene los plazos
                                $('#plazosModal').modal('hide');
                                getPlazosVenta(ventaId);
                            },
                            error: function(error) {
                                closeLoader();
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Ha ocurrido un error al crear el plazo',
                                    icon: 'error',
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        });

                    });

                },
                error: function(error) {
                    closeLoader();
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al cargar los plazos de la venta',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }

        function getHistorialCliente(id, table, soloVentas = false, porTrimestre = false, VentaEspecificaParte = null){
            
            openLoader();

            let soloVentasQuery = '';
            let porTrimQuery = '';
            let ventasEspecificaParte = '';

            if (soloVentas) {
                soloVentasQuery = 'soloFacturas';
            }

            if (porTrimestre) {
                porTrimQuery = porTrimestre;
            }

            if (VentaEspecificaParte) {
                ventasEspecificaParte = VentaEspecificaParte;
            }

            $.ajax({
                url: `/admin/clientes/${id}/historial`,
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    table,
                    id,
                    soloVentasQuery,
                    porTrimQuery,
                    ventasEspecificaParte
                },
                success: function(response) {
                    closeLoader();
                    if (opcionesPersonalizadas) {
                        setTimeout(() => {
                            const gridOptions = opcionesPersonalizadas.params; 
                            const allDisplayedRows = [];
                            const rowCount = gridOptions.api.getDisplayedRowCount();

                            for (let i = 0; i < rowCount; i++) {
                                const rowNode = gridOptions.api.getDisplayedRowAtIndex(i);
                                if (rowNode) {
                                    allDisplayedRows.push(rowNode.data);
                                }
                            }
                    
                            // Eliminar todas las filas visibles
                            gridOptions.api.applyTransaction({ remove: allDisplayedRows });

                        }, 100);
                    }
                    $('#showHistorialClienteModal').modal('show');
                    $('#showHistorialClienteModalLabel').text(`Historial de ventas de ${response.cliente.NombreCliente} ${response.cliente.ApellidoCliente}`);

                    let newData = [];
                    
                    if (!opcionesPersonalizadas) {
                        newData = inicializarVentasTable(response.historial);
                    }else{

                        let rowData = {};
                        let data = [];

                        function prepareRowData(ventas) {
                            ventas.forEach(venta => {
                                // console.log(venta)
                                // console.log(parte);
                                // if (parte.proyecto_n_m_n && parte.proyecto_n_m_n.length > 0) {
                                //     console.log({proyecto: parte.proyecto_n_m_n[0].proyecto.name});
                                // }
                                const rutaEnlace = (venta.venta_confirm) ? `/admin/ventas/download_factura/${venta.idVenta}` : `/admin/ventas/albaran/${venta.idVenta}`;
                                const nombreCliente = `${venta.cliente.NombreCliente} ${venta.cliente.ApellidoCliente}`;
                                rowData[venta.idVenta] = {
                                    ID: venta.idVenta,
                                    Fecha: formatDateYYYYMMDD(venta.FechaVenta),
                                    Emp: venta.empresa.EMP,
                                    Cliente: nombreCliente,
                                    Agente: venta.AgenteVenta,
                                    FPago: (venta.formaPago == 1) ? 'Banco' : 'Efectivo',
                                    Estado: (venta.venta_confirm) ? 'Facturado' : 'Albarán',
                                    Enlace: rutaEnlace,
                                    Importe: formatPrice(venta.ImporteVenta),
                                    IVA: venta.IVAVenta+'%',
                                    Plazo: venta.Plazos,
                                    TIva: formatPrice(venta.TotalIvaVenta),
                                    Retenciones: venta.RetencionesVenta+'%',
                                    Cobrado: formatPrice(venta.Cobrado),
                                    AContable: venta.NAsientoContable,
                                    Observaciones: venta.Observaciones,
                                    Total: formatPrice(venta.TotalFacturaVenta),
                                    Pendiente: formatPrice(venta.PendienteVenta),
                                    Notas1: venta.notas1,
                                    Notas2: venta.notas2,
                                    Acciones: 
                                    `
                                        <?php $__env->startComponent('components.actions-button'); ?>
                                            <button 
                                                type="button" 
                                                class="btn btn-outline-primary detailsVentaBtn" 
                                                data-id="${venta.idVenta}"
                                                data-bs-placement="top"
                                                title="Detalles de la Venta"
                                                data-bs-toggle="tooltip"
                                            >
                                                <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                                    <ion-icon name="information-circle-outline"></ion-icon>
                                                    <small>Detalles</small>
                                                </div>
                                            </button>
                                                ${ (venta.venta_confirm == null) ? `
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-info editVentaBtn" 
                                                        data-id="${venta.idVenta}"
                                                        data-bs-placement="top"
                                                        title="Editar Venta"
                                                        data-bs-toggle="tooltip"
                                                    >
                                                        <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                                            <ion-icon name="create-outline"></ion-icon>
                                                            <small>Editar</small>
                                                        </div>
                                                    </button>
                                                    <a 
                                                        class="btn btn-success generateAlbaran" 
                                                        href="/admin/ventas/albaran/${venta.idVenta}" 
                                                        target="_blank"
                                                        data-bs-placement="top"
                                                        title="Albarán"
                                                        data-bs-toggle="tooltip"
                                                    >
                                                        <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                                            <ion-icon name="document-attach-outline"></ion-icon>
                                                            <small>Albarán</small>
                                                        </div>
                                                    </a>
                                                ` : ''}
                                            <a 
                                                class="btn btn-warning ${ (venta.venta_confirm == null) ? 'generateFactura' : '' }" 
                                                href="${ (venta.venta_confirm == null) ? `/admin/ventas/factura/${venta.idVenta}` : `/admin/ventas/download_factura/${venta.idVenta}` }" 
                                                target="_blank"
                                                data-bs-placement="top"
                                                data-ventaid="${venta.idVenta}"
                                                title="${ (venta.venta_confirm !== null) ? 'Descargar Factura' : 'Facturar' }"
                                                data-bs-toggle="tooltip"
                                            >
                                                <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                                    ${ (venta.venta_confirm == null) ? `
                                                        <ion-icon name="cash-outline"></ion-icon>
                                                    ` : `
                                                        <ion-icon name="cloud-download-outline"></ion-icon>
                                                    `}
                                                    <small>${ (venta.venta_confirm == null) ? 'Facturar' : 'Descargar' }</small>
                                                </div>
                                            </a>
                                        <?php echo $__env->renderComponent(); ?>
                                    
                                    `
                                }
                            });

                            data = Object.values(rowData);
                        }

                        prepareRowData(response.historial);

                        newData = data;
                    }

                    let inputsContainer = $('#showHistorialClienteModal #inputsLabelsContainer');

                    inputsContainer.empty();

                    // Genera el contenido dinámico de los inputs
                    let inputs = `
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="totalImporte" class="form-label">Total Importe</label>
                                    <input type="text" id="totalImporte" class="form-control" value="${formatPrice(response.sumatoriaImporte)}" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="totalIva" class="form-label">Total Iva</label>
                                    <input type="text" id="totalIva" class="form-control" value="${formatPrice(response.sumatoriaIva)}" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="totalFacturado" class="form-label">Total Facturado</label>
                                    <input type="text" id="totalFacturado" class="form-control" value="${formatPrice(response.sumatoria)}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="totalRetenciones" class="form-label">Total Retenciones</label>
                                    <input type="text" id="totalRetenciones" class="form-control" value="${formatPrice(response.sumatoriaRetenciones)}" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="totalSuplidos" class="form-label">Total Suplidos</label>
                                    <input type="text" id="totalSuplidos" class="form-control" value="${formatPrice(response.sumatoriaSuplidos)}" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="totalPendiente" class="form-label">Total Pendiente</label>
                                    <input type="text" id="totalPendiente" class="form-control" value="${formatPrice(response.sumatoriaPendiente)}" readonly>
                                </div>
                            </div>
                        </div>
                    `;

                    // Agrega los inputs al contenedor
                    inputsContainer.html(inputs);

                    if (opcionesPersonalizadas) {
                        setTimeout(() => {
                            const gridOptions = opcionesPersonalizadas.params; 
                            gridOptions.api.applyTransaction({ add: newData });
                        }, 200);
                    }

                },
                error: function(error) {
                    closeLoader();
                    console.error(error);
                }
            });
        }

        function getEditVenta(id){
            $.ajax({
                url: `/admin/ventas/edit/${id}`,
                method: 'GET',
                beforeSend: function() {
                    openLoader();
                },
                success: function (response) {
                    closeLoader();
                    if (response.status === 'success') {
                        
                        let venta = response.venta;
                        let cliente = venta.cliente;
                        let partes  = response.partes;
                        let proyectos = response.proyectos;
                        let articulos = response.articulos;

                        $('#editVentaModal #FechaVenta').val(venta.FechaVenta);
                        $('#editVentaModal #AgenteVenta').val(venta.AgenteVenta);
                        $('#editVentaModal #EnviadoVenta').val(venta.EnviadoVenta);
                        $('#editVentaModal #cliente_id').val(venta.cliente_id);
                        $('#editVentaModal #empresa_id').val(venta.empresa_id);
                        $('#editVentaModal #FormaPago').val(venta.FormaPago);
                        $('#editVentaModal #IvaVenta').val(venta.IVAVenta);
                        $('#editVentaModal #TotalIvaVenta').val(venta.TotalIvaVenta);
                        $('#editVentaModal #RetencionesVenta').val(venta.RetencionesVenta);
                        $('#editVentaModal #TotalRetencionesVenta').val(venta.TotalRetencionesVenta);
                        $('#editVentaModal #TotalFacturaVenta').val(venta.TotalFacturaVenta);
                        $('#editVentaModal #SuplidosVenta').val(venta.SuplidosVenta);
                        $('#editVentaModal #Plazos').val(venta.Plazos);
                        $('#editVentaModal #Cobrado').val(venta.Cobrado);
                        $('#editVentaModal #PendienteVenta').val(venta.PendienteVenta);
                        $('#editVentaModal #NAsientoContable').val(venta.NAsientoContable);
                        $('#editVentaModal #Observaciones').val(venta.Observaciones);
                        $('#editVentaModal #idVenta').val(id);

                        // construir estos botones

                        const buttonsContainer = $('#editVentaModal #buttonsContainerEditVenta');

                        buttonsContainer.empty();

                        let buttons = `
  
                            ${ (venta.venta_confirm == null) ? `
                                <a 
                                    class="btn btn-success generateAlbaran" 
                                    href="/admin/ventas/albaran/${venta.idVenta}" 
                                    target="_blank"
                                    data-bs-placement="top"
                                    title="Albarán"
                                    data-bs-toggle="tooltip"
                                >
                                    <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                        <ion-icon name="document-attach-outline"></ion-icon>
                                        <small>Albarán</small>
                                    </div>
                                </a>
                            ` : ''}
                            <a 
                                class="btn btn-warning ${ (venta.venta_confirm == null) ? 'generateFactura' : '' }" 
                                href="${ (venta.venta_confirm == null) ? `/admin/ventas/factura/${venta.idVenta}` : `/admin/ventas/download_factura/${venta.idVenta}` }" 
                                target="_blank"
                                data-bs-placement="top"
                                data-ventaid="${venta.idVenta}"
                                title="${ (venta.venta_confirm !== null) ? 'Descargar Factura' : 'Facturar' }"
                                data-bs-toggle="tooltip"
                            >
                                <div class="d-flex justify-between align-items-center align-content-center flex-column">
                                    ${ (venta.venta_confirm == null) ? `
                                        <ion-icon name="cash-outline"></ion-icon>
                                    ` : `
                                        <ion-icon name="cloud-download-outline"></ion-icon>
                                    `}
                                    <small>${ (venta.venta_confirm == null) ? 'Facturar' : 'Descargar' }</small>
                                </div>
                            </a>
                        `;

                        buttonsContainer.html(buttons);

                        // cambiar el titulo del modal
                        $('#editVentaTitle').text(`Editar venta ${venta.idVenta}`);

                        // Limpiar y cargar las líneas de venta
                        $('#editVentaModal #elementsToShow').empty();
                        venta.venta_lineas.forEach(linea => {

                            //remover "Descripcion de la parte" de linea.Descripcion
                            let descripcion = linea.Descripcion;
                            // let separarPorEspacios = descripcion.split(' ');
                            // // eliminar desde la posicion 0 hasta la posicion 3
                            // separarPorEspacios.splice(0, 3);
                            // descripcion = separarPorEspacios.join(' ');

                            $('#editVentaModal #elementsToShow').append(`
                                <tr>
                                    <td
                                        class="openEditParteTrabajoModal"
                                        data-id="${linea.parte_trabajo}"
                                        data-venta-id="${venta.idVenta}"
                                        style="cursor: pointer; text-decoration: underline;"
                                    >
                                        ${linea.idLineaVenta}
                                    </td>
                                    <td>Parte #${linea.parte_trabajo} ${descripcion}</td>
                                    <td>${linea.observaciones}</td>
                                    <td>${linea.Cantidad}</td>
                                    <td>${linea.descuento}</td>
                                    <td class="total-linea">${linea.total}€</td>
                                </tr>
                            `);
                        });

                        $('#editVentaModal').modal('show');

                        $('#editVentaModal #guardarVenta').off('click').on('click', function () {
                            let formData = new FormData($('#editVentaModal #createVentaForm')[0]);
                            formData.append('type', 'edit');
                            formData.append('_token', '<?php echo e(csrf_token()); ?>');
                            formData.append('_method', 'PUT');
                            $.ajax({
                                url: `/admin/ventas/${id}`,
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (response) {
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            title: 'Venta actualizada',
                                            text: response.message,
                                            icon: 'success',
                                            confirmButtonText: 'Aceptar'
                                        });
                                        $('#editVentaModal').modal('hide');
                                        location.reload();
                                    }
                                },
                                error: function (error) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Ha ocurrido un error al actualizar la venta',
                                        icon: 'error',
                                        footer: error.message,
                                        confirmButtonText: 'Aceptar'
                                    });
                                }
                            });
                        });

                        $('#editVentaModal .openEditParteTrabajoModal').off('dblclick').on('dblclick', function() {
                            let parteId = $(this).data('id');
                            openDetailsParteTrabajoModal(parteId);
                        });

                        // Habilitar la adición de nuevas líneas en el modo de edición
                        $('#editVentaModal #addNewLine').off('click').on('click', function() {
                            globalLineas++;
                            let newLine = `
                                <form id="AddNewLineForm${globalLineas}" class="mt-2 mb-2">
                                    <div class="row">
                                        <input type="hidden" id="venta_id" name="venta_id" value="${venta.idVenta}">
                                        <input type="hidden" id="clienteId" name="cliente_id" value="${cliente.idCliente}">
                                        <input type="hidden" id="clienteNameId" name="cliente_name" value="${cliente.nombre}">
                                        <input type="hidden" id="archivoId" name="archivo_id" value="${venta.archivoId}">
                                        <input type="hidden" id="totalFactura" name="totalFactura" value="${venta.TotalFacturaVenta}">
                                        <input type="hidden" id="sumaTotalesLineas" data-value="0">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="venderProyecto${globalLineas}">
                                                    <input type="checkbox" id="venderProyecto${globalLineas}" class="venderProyectoCheckbox"> Vender Proyecto
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group select-container" id="ordenTrabajoContainer${globalLineas}">
                                                <label for="ordenTrabajo${globalLineas}">Parte de trabajo</label>
                                                <select class="form-select ordenTrabajo" id="ordenTrabajo${globalLineas}" name="ordenTrabajo" required>
                                                    <option value="">Parte de trabajo</option>
                                                    ${partes.map(parte => `
                                                        <option 
                                                            data-tipo="parte" 
                                                            data-lineas="${parte.lineas}" 
                                                            data-valorparte="${parte.totalParte}" 
                                                            value="${parte.idParteTrabajo}"
                                                        >
                                                            Num ${parte.idParteTrabajo} | ${( parte.tituloParte) ? parte.tituloParte : parte.Asunto }
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            </div>

                                            <div class="form-group select-container" id="proyectoContainer${globalLineas}" style="display: none;">
                                                <label for="proyecto${globalLineas}">Proyecto</label>
                                                <select class="form-select proyecto" id="proyecto${globalLineas}" name="proyecto">
                                                    <option value="">Seleccione un proyecto</option>
                                                    ${proyectos.map(proyecto => `<option value="${proyecto.idProyecto}">${proyecto.name}</option>`).join('')}
                                                </select>
                                            </div>
                                        </div>

                                        <div id="containerArticulo${globalLineas}" class="col-md-4 d-none">
                                            <div class="form-group">
                                                <label for="articulo${globalLineas}">Artículo</label>
                                                <select class="form-select articulo" id="articulo${globalLineas}" name="articulo[]" required disabled>
                                                    <option value="">Seleccione un artículo</option>
                                                    ${articulos.map(articulo => `<option data-trazabilidad="${articulo.TrazabilidadArticulos}" value="${articulo.idArticulo}">${articulo.nombreArticulo}</option>`).join('')}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cantidad${globalLineas}">Cantidad</label>
                                                <input type="number" class="form-control cantidad" id="cantidad${globalLineas}" name="cantidad" value="1" step="0.01" required disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="precioSinIva${globalLineas}">Precio sin iva</label>
                                                <input type="number" class="form-control precioSinIva" id="precioSinIva${globalLineas}" name="precioSIva" step="0.01" required disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="descuento${globalLineas}">Descuento</label>
                                                <input type="number" class="form-control descuento" id="descuento${globalLineas}" name="descuento" step="0.01" value="0" required disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="total${globalLineas}">Total</label>
                                                <input type="number" class="form-control total" id="total${globalLineas}" name="total" step="0.01" required disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-success saveLinea" data-line="${globalLineas}">Guardar</button>    
                                </form>
                            `;

                            $('#editVentaModal #collapseLineasVenta #newLinesContainer').append(newLine);

                            // Inicializa Select2
                            $('#editVentaModal select.form-select').select2({
                                width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                                dropdownParent: $('#editVentaModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                            });

                            // Toggle visibility based on checkbox state
                            $(`#editVentaModal #venderProyecto${globalLineas}`).change(function() {
                                if ($(this).is(':checked')) {
                                    $(`#proyectoContainer${globalLineas}`).show();
                                    $(`#ordenTrabajoContainer${globalLineas}`).hide();
                                    $(`#articulo${globalLineas}`).prop('disabled', false).show();
                                    $(`#cantidad${globalLineas}`).prop('disabled', false);
                                    $(`#precioSinIva${globalLineas}`).prop('disabled', false);
                                    $(`#descuento${globalLineas}`).prop('disabled', false);
                                    $(`#total${globalLineas}`).prop('disabled', false);
                                    $(`#containerArticulo${globalLineas}`).removeClass('d-none');

                                    // limpiar todos los campos
                                    $(`#ordenTrabajo${globalLineas}`).val('');
                                    $(`#cantidad${globalLineas}`).val('');
                                    $(`#precioSinIva${globalLineas}`).val('');
                                    $(`#descuento${globalLineas}`).val(0);
                                    $(`#total${globalLineas}`).val('');

                                } else {
                                    $(`#proyectoContainer${globalLineas}`).hide();
                                    $(`#ordenTrabajoContainer${globalLineas}`).show();
                                    $(`#cantidad${globalLineas}`).prop('disabled', true).val('');
                                    $(`#precioSinIva${globalLineas}`).prop('disabled', true).val('');
                                    $(`#descuento${globalLineas}`).prop('disabled', false).val('');
                                    $(`#total${globalLineas}`).prop('disabled', true).val('');
                                    $(`#containerArticulo${globalLineas}`).addClass('d-none');
                                    $(`#articulo${globalLineas}`).prop('disabled', true).val('').trigger('change').hide();
                                }
                            });

                            // cargar en articulos los partes de trabajo correspondientes al proyecto seleccionado
                            $(`#editVentaModal #proyecto${globalLineas}`).on('change', function() {
                                const proyectoId = $(this).val();
                                const form = $(this).closest('form');
                                const articuloSelect = form.find('.articulo');
                                let sumaTotalVentas = 0;
                                if (proyectoId) {
                                    articuloSelect.attr('disabled', false);
                                    $.ajax({
                                        url: `/admin/proyectos/${proyectoId}/partes`,
                                        method: 'GET',
                                        beforeSend: function() {
                                            articuloSelect.empty();
                                            articuloSelect.append('<option>Cargando...</option>');
                                            openLoader();
                                        },
                                        success: function(response) {
                                            articuloSelect.empty();
                                            articuloSelect.attr('disabled', false);
                                            articuloSelect.attr('multiple', "multiple");
                                            response.partes.forEach(parte => {

                                                // validar si algun parte de trabajo aun no se ha finalizado
                                                if (parte.parte_trabajo.Estado == '2') {
                                                    Swal.fire({
                                                        title: 'Error',
                                                        text: 'El parte de trabajo con asunto ' + parte.parte_trabajo.Asunto + ' aún no ha sido finalizado',
                                                        icon: 'error',
                                                        confirmButtonText: 'Aceptar'
                                                    });
                                                    articuloSelect.val('').trigger('change');
                                                    closeLoader();
                                                    return;
                                                }

                                                // TODO: validar que los partes de trabajo, sus articulos pertenecen a la empresa que esta creando la venta
                                                articuloSelect.append(`
                                                <option 
                                                    data-tipo="parte"
                                                    data-lineas=${JSON.stringify(parte.parte_trabajo.partes_trabajo_lineas)}
                                                    data-suma="${parte.parte_trabajo.totalParte}"
                                                    value="${parte.parte_trabajo.idParteTrabajo}"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="${parte.parte_trabajo.Asunto} | Visita: ${parte.parte_trabajo.FechaVisita}"
                                                >
                                                    Num ${parte.parte_trabajo.idParteTrabajo} | ${ (parte.parte_trabajo.tituloParte) ? parte.parte_trabajo.tituloParte : parte.parte_trabajo.Asunto }
                                                </option>
                                                `);
                                                sumaTotalVentas += parte.parte_trabajo.totalParte;
                                            });

                                            // seleccionar todos los articulos
                                            articuloSelect.val(response.partes.map(parte => parte.parte_trabajo.idParteTrabajo));
                                            closeLoader();

                                            //convertir el selector de articulos en un select2
                                            // Destruir la instancia de Select2, si existe
                                            if ($('.articulo').data('select2')) {
                                                $('.articulo').select2('destroy');
                                            }
                                            // Inicializa Select2
                                            $('.articulo').select2({
                                                width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                                                dropdownParent: $('#createVentaModal'), // Asocia el dropdown con el modal para evitar problemas de superposición
                                            });

                                            // seleccionar todos los articulos
                                            articuloSelect.val(response.partes.map(parte => parte.parte_trabajo.idParteTrabajo));

                                            $(`#precioSinIva${globalLineas}`).val(sumaTotalVentas).attr('disabled', true);
                                            $(`#cantidad${globalLineas}`).val(response.partes.length).attr('disabled', true);
                                            $(`#total${globalLineas}`).val(sumaTotalVentas).attr('disabled', true);
                                            $('#sumaTotalesLineas').data('value', sumaTotalVentas).attr('disabled', true);
                                            
                                            // Calcular el total de ventas de los partes seleccionados si quito una parte restarle el valor al total

                                            articuloSelect.on('change', function() {
                                                let total           = 0;
                                                let selectedOptions = $(this).find('option:selected');
                                                let lineas          = [];

                                                selectedOptions.each(function() {
                                                    total += parseFloat($(this).data('suma'));
                                                    lineas.push($(this).data('lineas'));
                                                });

                                                lineas = lineas.map((linea) => {
                                                    if (linea.length > 0) {
                                                        return linea;
                                                    }
                                                })

                                                console.log({
                                                    lineas
                                                })

                                                const validateEmp = lineas.every((linea) => linea.articulo.empresa_id === ventaEmp);
                                                const idsQueNoPertenecen = lineas.filter((linea) => linea.articulo.empresa_id !== ventaEmp).map((linea) => linea.articulo.empresa_id);

                                                console.log({
                                                    validateEmp,
                                                    idsQueNoPertenecen
                                                })

                                                if (!validateEmp) {
                                                    Swal.fire({
                                                        title: 'Warning',
                                                        text: 'Hay partes de trabajo con materiales de otra empresa, ¿quieres realizar un traspaso de materiales?',
                                                        icon: 'warning',
                                                        confirmButtonText: 'Aceptar',
                                                        showCancelButton: true,
                                                        cancelButtonText: 'Cancelar'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // redirigir a la vista de traspaso de materiales
                                                            
                                                            $.ajax({
                                                                url: "<?php echo e(route('admin.traspasos.store')); ?>",
                                                                method: 'POST',
                                                                data: {
                                                                    _token: '<?php echo e(csrf_token()); ?>',
                                                                    ids: idsQueNoPertenecen
                                                                },
                                                                success: function(response) {
                                                                    Swal.fire({
                                                                        title: 'Traspaso realizado',
                                                                        text: response.message,
                                                                        icon: 'success',
                                                                        confirmButtonText: 'Aceptar'
                                                                    })

                                                                },
                                                                error: function(error) {
                                                                    console.error(error);
                                                                }
                                                            });

                                                        } else {
                                                            articuloSelect.val('').trigger('change');
                                                        }
                                                    });
                                                }

                                                $(`#precioSinIva${globalLineas}`).val(total).attr('disabled', true);
                                                $(`#cantidad${globalLineas}`).val(selectedOptions.length).attr('disabled', true);
                                                $(`#total${globalLineas}`).val(total).attr('disabled', true);
                                                $('#sumaTotalesLineas').data('value', total).attr('disabled', true);
                                            });
                                            
                                        },
                                        error: function(error) {
                                            console.error(error);
                                            closeLoader();
                                        }
                                    });
                                } else {
                                    articuloSelect.attr('disabled', true);
                                }
                            });

                            // Activar el selector de artículos solo cuando se selecciona una orden de trabajo
                            $('#editVentaModal #newLinesContainer').off('change', `#ordenTrabajo${globalLineas}`).on('change', `#ordenTrabajo${globalLineas}`, function () {
                                const ordenTrabajoId = $(this).val();
                                const form = $(this).closest('form');
                                const articuloSelect = form.find('.articulo');

                                // obtener el tipo y el precio de la orden de trabajo
                                const tipo = $(this).find('option:selected').data('tipo');
                                const precio = $(this).find('option:selected').data('valorparte');

                                // autocompletar el campo precio sin iva y total
                                $(`#precioSinIva${globalLineas}`).val(precio).attr('disabled', true);
                                $(`#total${globalLineas}`).val(precio).attr('disabled', true);

                                if (ordenTrabajoId) {
                                    articuloSelect.attr('disabled', false);
                                } else {
                                    articuloSelect.attr('disabled', true);
                                }
                            });

                            // Delegar eventos en el contenedor para manejar los cambios de los campos dinámicos
                            $('#editVentaModal #newLinesContainer').off('change', `#articulo${globalLineas}`).on('change', `#articulo${globalLineas}`, function () {
                                const articuloId = parseInt($(this).val());
                                const form = $(this).closest('form');
                                const precioSinIvaInput = form.find('.precioSinIva');
                                const cantidadInput = form.find('.cantidad');
                                const totalInput = form.find('.total');
                                const descuentoInput = form.find('.descuento');

                                // Buscar el artículo seleccionado para obtener su precio
                                const articulo = response.articulos.find(art => art.idArticulo === articuloId);
                        
                                if (articulo) {
                                    precioSinIvaInput.val(articulo.ptsVenta).attr('disabled', false);
                                    cantidadInput.attr('disabled', false);
                                    descuentoInput.attr('disabled', false);
                                    totalInput.val(cantidadInput.val() * articulo.ptsVenta);
                                    calcularTotales();
                                }
                            });

                            $('#editVentaModal #newLinesContainer').off('change', `#cantidad${globalLineas}`).on('change', `#cantidad${globalLineas}`, function () {
                                const cantidad = $(this).val();
                                const form = $(this).closest('form');
                                const precioSinIvaInput = form.find('.precioSinIva').val();
                                const descuentoInput = form.find('.descuento').val();
                                const totalInput = form.find('.total');

                                if (cantidad && precioSinIvaInput) {
                                    const total = cantidad * precioSinIvaInput - descuentoInput;
                                    totalInput.val(total);
                                    calcularTotales();
                                }
                            });

                            $('#editVentaModal #newLinesContainer').off('change', `#precioSinIva${globalLineas}`).on('change', `#precioSinIva${globalLineas}`, function () {
                                const precioSinIva = $(this).val();
                                const form = $(this).closest('form');
                                const cantidad = form.find('.cantidad').val();
                                const descuentoInput = form.find('.descuento').val();
                                const totalInput = form.find('.total');

                                if (precioSinIva && cantidad) {
                                    const total = cantidad * precioSinIva - descuentoInput;
                                    totalInput.val(total);
                                    calcularTotales();
                                }
                            });

                            $('#editVentaModal #newLinesContainer').off('change', `#descuento${globalLineas}`).on('change', `#descuento${globalLineas}`, function () {
                                const descuento = parseFloat($(this).val());
                                const form      = $(this).closest('form');
                                const cantidad  = parseFloat(form.find('.cantidad').val());
                                const precioSinIvaInput = parseFloat(form.find('.precioSinIva').val());
                                const totalInput = form.find('.total');

                                // el valor del descuento no puede ser mayor al 100%
                                if (descuento > 100 || descuento < 0) {
                                    Swal.fire({
                                        title: 'warning',
                                        text: 'El descuento no puede ser mayor al 100%',
                                        icon: 'error',
                                        confirmButtonText: 'Aceptar'
                                    });
                                    $(this).val(0);
                                    return;
                                }

                                if (descuento == 0) {
                                    totalInput.val(cantidad * precioSinIvaInput);
                                    calcularTotales();
                                    return;
                                }

                                if (cantidad && precioSinIvaInput) {

                                    let precio = precioSinIvaInput * cantidad;
                                    let descuentoAplicado = precio * (descuento / 100);
                                    let lineaDescuento = precio - descuentoAplicado;
                                    // const lineaDescuento = (descuento * (precioSinIvaInput * cantidad)) / 100;

                                    const total = lineaDescuento;
                                    totalInput.val(total);
                                    calcularTotales();
                                }
                            });

                            $('#editVentaModal #collapseLineasVenta').off('click', '.saveLinea').on('click', '.saveLinea', function () {
                                const lineNumber = $(this).data('line');
                                const form = $(`#AddNewLineForm${lineNumber}`);
                                const ordenTrabajoId = form.find(`#ordenTrabajo${lineNumber}`).val();
                                const articuloId = form.find(`#articulo${lineNumber}`).val();
                                const cantidad = parseFloat(form.find(`#cantidad${lineNumber}`).val());
                                const precioSIva = parseFloat(form.find(`#precioSinIva${lineNumber}`).val());
                                const descuento = parseFloat(form.find(`#descuento${lineNumber}`).val());
                                const total = parseFloat(form.find(`#total${lineNumber}`).val());
                    
                                $('#sumaTotalesLineas').data('value', calcularSumaTotalesLineas());
                    
                                let cliente = {
                                    idCliente: form.find('#clienteId').val(),
                                    nombreCliente: form.find('#clienteNameId').val()
                                };
                    
                                let archivos = {
                                    idarchivos: form.find('#archivoId').val()
                                };
                    
                                let venta = {
                                    idVenta: form.find('#venta_id').val(),
                                    totalFactura: parseFloat(form.find('#totalFactura').val()) // Asegurarse que se convierte a float
                                };
                    
                                // Obtener la suma de las líneas existentes y agregar la nueva
                                let sumaTotalesLineas = calcularSumaTotalesLineas() + total;
                    
                                // Validar si la suma total supera el total de la factura
                                // if (sumaTotalesLineas > venta.totalFactura) {
                                //     Swal.fire({
                                //         title: 'Error',
                                //         text: 'El total de las líneas no puede ser mayor al total de la factura',
                                //         icon: 'error',
                                //         confirmButtonText: 'Aceptar'
                                //     });
                                    
                                //     return;
                                // }
                    
                                // Validaciones de campos obligatorios
                                if (cliente.idCliente === '' || cliente.idCliente === undefined || cliente.idCliente === null) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Ha ocurrido un error al guardar la línea, primero debe guardar la venta',
                                        icon: 'error',
                                        footer: 'No se han podido obtener los datos de la venta',
                                        confirmButtonText: 'Aceptar'
                                    });
                                    return;
                                }
                    
                                const table = $('#editVentaModal #tableToShowElements');
                                const elements = $('#editVentaModal #elementsToShow');
                    
                                // Mostrar tabla de elementos
                                table.show();
                    
                                //obtener el tipo de orden
                                let tipo = $(`#editVentaModal #ordenTrabajo${lineNumber} option:selected`).data('tipo');
                    
                                $.ajax({
                                    url: '<?php echo e(route("admin.lineasventas.store")); ?>',
                                    method: 'POST',
                                    data: {
                                        _token: '<?php echo e(csrf_token()); ?>',
                                        orden_trabajo_id: ordenTrabajoId,
                                        articulo_id: articuloId,
                                        cantidad,
                                        precioSinIva: precioSIva,
                                        descuento,
                                        total,
                                        venta_id: venta.idVenta,
                                        tipo,
                                    },
                                    beforeSend: function() {
                                        openLoader();
                                    },
                                    success: function({ status, message, venta, articulos, ordenes, cliente, linea, code, ok, lineas }) {
                                        closeLoader();
                                        if ( ok == false ) {
                                            Swal.fire({
                                                title: 'Error',
                                                text: 'Ha ocurrido un error al guardar la línea',
                                                icon: 'error',
                                                footer: message,
                                                confirmButtonText: 'Aceptar'
                                            });
                                            return;
                                        }
                    
                                        if ( lineas ) {
                                            
                                            lineas.forEach(linea => {
                                            
                                                const newElement = `
                                                    <tr>
                                                        <td>${lineNumber}</td>
                                                        <td>${linea.parte_trabajo.Asunto}</td>
                                                        <td>${linea.Descripcion}</td>
                                                        <td>${linea.Cantidad}</td>
                                                        <td>${linea.descuento}</td>
                                                        <td class="total-linea">${linea.total}€</td>
                                                    </tr>
                                                `;
                                                elements.append(newElement);
                                            });
                    
                                        }else{
                                            //remover "Descripcion de la parte" de linea.Descripcion
                                            let descripcion = linea.Descripcion;
                                            let separarPorEspacios = descripcion.split(' ');
                                            // eliminar desde la posicion 0 hasta la posicion 3
                                            separarPorEspacios.splice(0, 3);
                                            descripcion = separarPorEspacios.join(' ');
                                            
                                            let newElement = `
                                            <tr>
                                                <td>${lineNumber}</td>
                                                <td>${descripcion}</td>
                                                <td>${linea.Descripcion}</td>
                                                <td>${linea.Cantidad}</td>
                                                <td>${linea.descuento}</td>
                                                <td class="total-linea">${linea.total}€</td>
                                                </tr>
                                            `;
                                            elements.append(newElement);
                                        }
                    
                    
                                        calcularTotalesEdit(venta.idVenta);
                    
                                        Swal.fire({
                                            title: 'Línea guardada',
                                            text: message,
                                            icon: 'success',
                                            confirmButtonText: 'Aceptar'
                                        });
                    
                                        // Limpiar campos de la nueva línea y deshabilitarlos
                                        form.find('#editVentaModal textarea, input').val('').attr('disabled', true);
                    
                                        // Limpiar el contenedor de líneas nuevas
                                        $('#editVentaModal #newLinesContainer').empty();
                    
                                        $('#editVentaModal #addNewLine').attr('disabled', false);
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
                    
                                $('#saveVentaBtn').on('click', function() {
                                if (ventaGuardadaGlobal) {
                                    
                                    
                    
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Primero debe guardar la venta antes de guardar las líneas',
                                        icon: 'error',
                                        confirmButtonText: 'Aceptar'
                                    });
                                }
                                });
                    
                            });

                        });
                    }
                },
                error: function (error) {
                    console.error(error);
                    closeLoader();
                }
            });
        }

        function getResumenDetails(total, totaliva, totalimporte, cantidad, periodo, tipo, selector, empresa, iva){
            $.ajax({
                url: '<?php echo e(route("admin.estadisticas.resumendetails")); ?>',
                method: 'POST',
                data: {
                    total: total,
                    totaliva: totaliva,
                    totalimporte: totalimporte,
                    cantidad: cantidad,
                    periodo: periodo,
                    tipo: tipo,
                    selector: selector,
                    empresa: empresa,
                    iva: iva,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function ({ datos, empresa, periodo }) {
                    // Verificar si los datos vienen correctamente estructurados
                    $('#modalDetailsEstadisticas').modal('show');

                    $('#modalDetailsEstadisticas #containerModal').empty();

                    // cambiar el titulo del modal
                    $('#modalDetailsEstadisticasTitle').text(`Detalles de ${tipo} del periodo ${periodo} - ${empresa.EMP} - IVA: ${iva}%`);

                    // crear agGrid
                    const html = `
                        <div class="row">
                            <div class="col-md-4">
                                <label for="totalimporte">Total Importe:</label>
                                <input type="text" class="form-control" value="${formatPrice(totalimporte)}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="totaliva">Total IVA:</label>
                                <input type="text" class="form-control" value="${formatPrice(totaliva)}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="total">Total:</label>
                                <input type="text" class="form-control" value="${formatPrice(total)}" readonly>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label for="cantidad">Cantidad:</label>
                                <input type="text" class="form-control" value="${cantidad}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="periodo">Periodo:</label>
                                <input type="text" class="form-control" value="${periodo}" readonly>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div id="detailsGrid" style="width: 100%; height: 500px;" class="ag-theme-quartz"></div>    
                        </div>
                    `;

                    $('#modalDetailsEstadisticas #containerModal').append(html);

                    // Configuración de las columnas y opciones de la cuadrícula
                    switch (tipo) {
                        case 'venta':
                            inicializarVentasTableEstadisticas(datos, '#detailsGrid');
                            break;
                        case 'Albaran':
                            inicializarVentasTableEstadisticas(datos, '#detailsGrid');
                            break;
                        case 'compra':
                            inicializarComprasTableEstadisticas(datos, '#detailsGrid');
                            break;
                    
                        default:
                            break;
                    }

                },
                error: function (error) {
                    console.error('Error al cargar el resumen:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al cargar los datos. Por favor, intente nuevamente.'
                    });
                }
            });
        }

        function getResumenModelo347Details(){

        }

    </script>
    

    <script>

        function acortarPalabra(palabra, longitud) {
            return palabra.length > longitud ? `${palabra.substring(0, longitud)}...` : palabra;
        }

        function htmlRenderer(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.dom.empty(td); // Limpia el contenido de la celda
            td.innerHTML = value; // Establece el contenido HTML
            return td;
        }

        function toggleExpandElement(element, tableId) {
            // Obtener el texto completo del atributo data-bs-original-title
            let fullText = element.getAttribute('data-bs-original-title');
            let isExpanded = element.getAttribute('data-expanded') === 'true';  // Verificar estado actual

            // Generar el texto truncado
            let truncatedText = fullText.length > 10 ? fullText.substring(0, 10) + '...' : fullText;

            // Reemplazar saltos de línea con <br> para renderizar correctamente
            fullText = fullText.replace(/\n/g, '<br>');
            truncatedText = truncatedText.replace(/\n/g, '<br>');

            // Alternar entre el texto expandido y truncado
            if (isExpanded) {
                element.innerHTML = truncatedText;  // Mostrar truncado
                element.setAttribute('data-expanded', 'false');  // Actualizar estado
            } else {
                element.innerHTML = fullText;  // Mostrar completo
                element.setAttribute('data-expanded', 'true');  // Actualizar estado
            }

            // Agregar el grip si no lo tiene
            if (!element.querySelector('.resize-grip')) {
                addResizeGrips(tableId);
            }
        }

        function addResizeGrips(id) {
            $(`${id} tbody td`).each(function () {
                const $th = $(this);

                // Añadir un manejador de redimensionamiento en el borde derecho
                const $grip = $('<div class="resize-grip"></div>');
                $th.css('position', 'relative');
                $grip.css({
                    position: 'absolute',
                    top: 0,
                    right: 0,
                    width: '5px',
                    height: '100%',
                    cursor: 'col-resize',
                    zIndex: 999,
                });

                $th.append($grip);
            });
        }

        function enableColumnResizeWithGrip(id) {
            let isResizing = false;
            let startX, startWidth, columnIndex;

            $(document).on('mousedown', '.resize-grip', function (e) {
                isResizing = true;

                const $grip = $(this);
                const $th = $grip.closest('td');

                startX = e.pageX;
                columnIndex = $th.index();
                startWidth = $th.width();

                e.preventDefault();

                $(document).on('mousemove', handleResize);
                $(document).on('mouseup', stopResizing);
            });

            function handleResize(e) {
                if (!isResizing) return;
                const newWidth = startWidth + (e.pageX - startX);
                $(`${id} thead th:nth-child(${columnIndex + 1})`).css('min-width', `${newWidth}px`, '!important');
                $(`${id} tbody td:nth-child(${columnIndex + 1})`).css('min-width', `${newWidth}px`, '!important');
            }

            function stopResizing() {
                isResizing = false;
                $(document).off('mousemove', handleResize);
                $(document).off('mouseup', stopResizing);
                $(document).off('.resizeColumn');
            }
        }

        function enableRowResize(id) {
            $(`${id} tbody tr`).resizable({
                handles: 's', // Handle para redimensionar desde la parte inferior
                minHeight: 30,
                resize: function(event, ui) {
                    $(this).height(ui.size.height);
                }
            });
        }

        function configureInitComplete(table, tableId, tableTitle, color) {
            // Establecer el título de la tabla
            $('.table-title').html(`<h3 class="text-${color}">${tableTitle}</h3>`);

            table.columns().every(function () {
                let column = this;
                const savedFilter = loadFilter(tableId, column.index());
                if (savedFilter) {
                    // Si el filtro está basado en letios valores, lo dividimos
                    const selectedValues = savedFilter.split(',');

                    let filterExpression = '';

                    // Si hay valores seleccionados, generar una expresión regular
                    if (selectedValues.length > 0) {
                        // Crear una expresión regular que busque cualquiera de los valores seleccionados
                        filterExpression = selectedValues.map(value => {
                            // Evitar escapar valores que no contienen caracteres especiales
                            if (/[^a-zA-Z0-9]/.test(value)) {
                                // Escapar solo si el valor contiene caracteres especiales
                                return `(${$.escapeSelector(value)})`;
                            } else {
                                // De lo contrario, usar el valor tal cual
                                return `(${value})`;
                            }
                        }).join('|');
                    }

                    // Aplicar el filtro usando la expresión regular
                    column.search(filterExpression || savedFilter, true, false).draw(); // 'true' para búsqueda regex

                    // Resaltar columna si hay filtro
                    $(column.header()).addClass('filtered-column');
                } else {
                    $(column.header()).removeClass('filtered-column');
                }

                // Evento para abrir el modal de filtro
                $(column.header()).on('dblclick touchstart', function (event) {
                    if (event.type === 'touchstart') {
                        let timer = setTimeout(() => openFilterModal(column, tableId, table), 500);
                        $(this).on('touchend', () => clearTimeout(timer));
                    } else {
                        openFilterModal(column, tableId, table);
                    }
                });
            });

            // Verificar y resaltar columnas después de cerrar el modal
            $('#filterModal').on('hidden.bs.modal', function () {
                table.columns().every(function () {
                    const column = this;
                    const savedFilter = loadFilter(tableId, column.index());
                    if (savedFilter) {
                        $(column.header()).addClass('filtered-column');
                    } else {
                        $(column.header()).removeClass('filtered-column');
                    }
                });
            });

            // Al cargar la tabla, guardar los datos originales en cada celda
            table.rows().every(function() {
                $(this.node()).find('td').each(function() {
                    const $cell = $(this);
                    if (!$cell.attr('data-original-html')) {
                        $cell.attr('data-original-html', $cell.html());
                        $cell.attr('data-original-text', $cell.text());

                        // verificar si es la columna de proyecto, ya que tiene un badge personalizado es un td y dentro un span con el badge y data-fulltext
                        if ($cell.html().includes('badgeProject')) {
                            const badgeHtml = $('<div>').html($cell.html()).find('.badgeProject');
                            $cell.attr('data-fulltext', $cell.html()); // Actualiza el contenido original
                        }else{
                            $cell.attr('data-fulltext', $cell.text()); // Asegúrate de tener fulltext aquí
                        }

                    }
                });
            });

            // Evento para manejar column-reorder
            table.on('column-reorder', function() {
                table.rows().every(function() {
                    $(this.node()).find('td').each(function() {
                        const $cell = $(this);

                        // Restaurar el contenido original de la celda
                        const originalHtml = $cell.attr('data-original-html');
                        const originalText = $cell.attr('data-original-text');

                        $cell.html(originalHtml);

                        // Volver a aplicar atributos como tooltip y texto truncado
                        const fullText = $cell.attr('data-fulltext') || originalText;
                        const dataFulltextContent = $cell.attr('data-bs-original-title');
                        const truncatedText = acortarPalabra(fullText, 10);

                        $cell.text(truncatedText);
                        if (fullText.length > 10) {
                            $cell.attr('title', fullText);
                            $cell.attr('data-bs-toggle', 'tooltip');
                            $cell.attr('data-bs-placement', 'top');
                        }

                        // Restaurar badges y otros estilos personalizados
                        const badge = $cell.find('.badge');
                        if (badge.length) {
                            $cell.append(badge);
                        }

                        // Restaurar badges y otros estilos personalizados
                        if (originalHtml.includes('badgeProject')) {
                            const badgeHtml = $('<div>').html(originalHtml).find('.badgeProject');
                            // Verificar si realmente el badge existe
                            if (badgeHtml.length) {
                                $cell.append(badgeHtml[0]);  // Inserta el primer elemento de jQuery como DOM
                            }
                        }

                    });
                });
            });

            // evento para acortar o extender palabras
            table.on('click', '.text-truncate', function(e){
                toggleExpandElement(e.target, tableId);
            });

            addResizeGrips(tableId);
            enableColumnResizeWithGrip(tableId);
            enableRowResize(tableId);
        }

        function openFilterModal(column, tableId, table) {
            $('#filterModal').modal('show');

            // Vaciar contenedor de entrada
            $('#filterInputContainer').empty();
            $('#filterInputContainer').append(`
                <input type="text" id="filterInput" class="form-control" placeholder="Ingrese valor(es)">
            `);

            $('#filtroId').text(`Filtrar por ${column.header().textContent}`);
            $('#filterModalFooter').empty();
            $('#filterModalFooter').append(`
                <button type="button" class="btn btn-primary" id="applyFilter">Aplicar</button>
            `);

            const columnIndex = column.index();
            const currentSearch = localStorage.getItem(`columnFilter-${tableId}-${columnIndex}`);
            const savedCheckboxes = JSON.parse(localStorage.getItem(`checkboxFilter-${tableId}-${columnIndex}`)) || [];

            $('#filterInput').val(currentSearch || '');

            // Obtener todos los valores únicos normalizados de la columna para el filtro
            const uniqueValues = [];
            table.column(column.index()).nodes().each(function (node) {
                const cell = $(node);
                const text = (cell.attr('data-bs-original-title') || cell.attr('data-fulltext') || cell.text()).trim(); // Normalizar texto
                const normalizedText = text.replace(/\s+/g, ' '); // Quitar saltos de línea y múltiples espacios
                if (normalizedText && !uniqueValues.includes(normalizedText)) {
                    uniqueValues.push(normalizedText);
                }
            });

            // Crear los checkboxes para cada valor único
            $('#filterInputContainer').append(`<div id="filterModalBody"></div>`);
            $('#filterModalBody').empty().css({
                'max-height': '300px',
                'overflow-y': 'scroll',
                'margin-top': '20px',
            });

            uniqueValues.forEach(value => {
                const isChecked = savedCheckboxes.includes(value) ? 'checked' : '';
                
                $('#filterModalBody').append(`
                    <div class="form-check mb-1" style="word-wrap: break-word;">
                        <input class="form-check-input" type="checkbox" value="${value}" id="filter-${value}" ${isChecked}>
                        <label class="form-check-label" for="filter-${value}" style="word-wrap: break-word;">
                            ${value}
                        </label>
                    </div>
                `);

                // evitar que el label se salga del contenedor
                $('#filterModalBody .form-check-label').css('max-width', '100%');
            });

            $('#applyFilter').off('click').on('click', function () {
                let searchValue = $('#filterInput').val().trim();
                const selectedValues = [];

                // Recoger los valores seleccionados de los checkboxes
                $('#filterModalBody input:checked').each(function () {
                    selectedValues.push($(this).val());
                });

                let filterExpression = '';

                if (selectedValues.length > 0) {
                    // Usar un filtro simple que busque por texto exacto
                    filterExpression = selectedValues.map(value => {
                        return `(?=.*${value})`;  // 'Lookahead' para asegurarse que contenga todos los valores seleccionados
                    }).join('');
                }

                if (searchValue) {
                    const searchExpression = searchValue.split(',').map(term => {
                        return `(?=.*${term.trim()})`;  // Compatibilidad con múltiples valores separados
                    }).join('');
                    filterExpression = filterExpression ? `${searchExpression}|${filterExpression}` : searchExpression;
                }

                // Aplicar búsqueda exacta en cada columna y visible
                column.search(filterExpression, true, false).draw();

                // Resaltar columna si hay filtro activo
                if (searchValue || selectedValues.length > 0) {
                    $(column.header()).addClass('filtered-column');
                } else {
                    $(column.header()).removeClass('filtered-column');
                }

                // Guardar filtros en localStorage
                saveFilter(tableId, columnIndex, searchValue || selectedValues.join(',') );
                localStorage.setItem(`checkboxFilter-${tableId}-${columnIndex}`, JSON.stringify(selectedValues));

                $('#filterModal').modal('hide');
            });

            // Filtrar checkboxes al escribir en el input
            $('#filterInput').off('input').on('input', function () {
                const searchValue = $(this).val().toLowerCase();
                $('#filterModalBody .form-check').each(function () {
                    const value = $(this).find('label').text().toLowerCase();
                    $(this).toggle(value.includes(searchValue));
                });
            });

            // Escuchar la tecla Enter
            $('#filterInput').off('keypress').on('keypress', function (e) {
                if (e.key === 'Enter') {
                    $('#applyFilter').click();
                }
            });
        }

        function restoreFilters(table, tableId) {
            table.columns().every(function () {
                const column = this;
                const columnIndex = column.index();
                const savedFilter = loadFilter(tableId, columnIndex);
                const savedCheckboxes = JSON.parse(localStorage.getItem(`checkboxFilter-${tableId}-${columnIndex}`)) || [];

                if (savedFilter) {
                    const selectedValues = savedFilter.split(',');
                    let filterExpression = selectedValues.map(value => {
                        if (/[^a-zA-Z0-9]/.test(value)) {
                            return `(${$.escapeSelector(value)})`;
                        } else {
                            return `(${value})`;
                        }
                    }).join('|');

                    column.search(filterExpression || savedFilter, true, false).draw();
                    $(column.header()).addClass('filtered-column');
                } else {
                    $(column.header()).removeClass('filtered-column');
                }
            });
        }

        // Función para guardar los filtros en localStorage o cookies
        function saveFilter(tableId, columnIndex, searchValue) {
            if (typeof(Storage) !== "undefined") {
                // Usar localStorage si está disponible
                localStorage.setItem(`columnFilter-${tableId}-${columnIndex}`, searchValue);
            } else {
                // Si no está disponible, usar cookies
                document.cookie = `columnFilter-${tableId}-${columnIndex}=${encodeURIComponent(searchValue)};path=/;max-age=3600`; // Expira en 1 hora
            }
        }

        // Función para recuperar los filtros de localStorage o cookies
        function loadFilter(tableId, columnIndex) {
            if (typeof(Storage) !== "undefined") {
                // Recuperar del localStorage si está disponible
                return localStorage.getItem(`columnFilter-${tableId}-${columnIndex}`);
            } else {
                // Si no está disponible, buscar en cookies
                const name = `columnFilter-${tableId}-${columnIndex}=`;
                const decodedCookies = decodeURIComponent(document.cookie);
                const cookies = decodedCookies.split(';');
                for (let i = 0; i < cookies.length; i++) {
                    let cookie = cookies[i];
                    while (cookie.charAt(0) === ' ') {
                        cookie = cookie.substring(1);
                    }
                    if (cookie.indexOf(name) === 0) {
                        return cookie.substring(name.length, cookie.length);
                    }
                }
            }
            return null; // Si no se encuentra el filtro
        }

        // Función para borrar los filtros de localStorage o cookies
        function clearFilter(tableId, columnIndex) {
            if (typeof(Storage) !== "undefined") {
                // Eliminar del localStorage si está disponible
                localStorage.removeItem(`columnFilter-${tableId}-${columnIndex}`);
            } else {
                // Si no está disponible, eliminar de cookies
                document.cookie = `columnFilter-${tableId}-${columnIndex}=;path=/;max-age=0`; // Expira inmediatamente
            }
        }

        function clearFiltrosFunction(dt, tableId){
            // Limpiar los filtros de la tabla
            dt.search('').columns().search('').draw(); 

            // Eliminar las clases de columna filtrada
            $('.filtered-column').removeClass('filtered-column');

            // Limpiar los filtros de localStorage para cada columna
            dt.columns().every(function () {
                const column = this;
                localStorage.removeItem(`columnFilter-${tableId}-${column.index()}`);
                document.cookie = `columnFilter-${tableId}-${column.index()}=; path=/; max-age=0`; // Eliminar cookies
            });

            // limpiar los filtros de los checkboxes
            $('.form-check-input').prop('checked', false);

            // Limpiar los filtros de los checkboxes en localStorage
            dt.columns().every(function () {
                const column = this;
                localStorage.removeItem(`checkboxFilter-${tableId}-${column.index()}`);
            });

        }

        function mantenerFilaYsubrayar(table){

            let touchStartY = 0;
            let touchStartX = 0;
            let timer;

            // evento para mantenerPulsadoParaSubrayar
            table.off('dblclick touchstart touchmove touchend').on('dblclick touchstart', '.mantenerPulsadoParaSubrayar', function(event) {
                
                let element = $(this);

                // Detectar si es un toque prolongado
                if (event.type === 'touchstart') {

                    touchStartY = event.originalEvent.touches[0].clientY;
                    touchStartX = event.originalEvent.touches[0].clientX;
                    
                    timer = setTimeout(function() {
                        
                        // Cambiar el borde del textarea para indicar que está en modo edición
                        element.css('border', '1px solid #007bff', '!important');
                        element.css('border-radius', '5px', '!important');
                        element.css('border-top', '1px solid #007bff', '!important');

                        // quitar el borde después de 5 segundos con un fadeOut
                        setTimeout(() => {
                            element.css('border', 'none' , '!important');
                            element.css('border-bottom', '1px solid #ddd' , '!important');
                            element.css('border-radius', '0', '!important');
                            element.css('border-top', 'none', '!important');
                        }, 6000);

                    }, 1000); // 500 ms para considerar que es un toque prolongado

                    // Cancelar el temporizador si el usuario levanta el dedo antes de los 500 ms
                    element.on('touchend', function() {
                        clearTimeout(timer);
                    });

                } else {
                    // Caso de doble clic (para dispositivos de escritorio)
                    $(this).css('border', '1px solid #007bff', '!important');
                    $(this).css('border-radius', '5px', '!important');
                    $(this).css('border-top', '1px solid #007bff', '!important');

                    // quitar el borde después de 5 segundos con un fadeOut
                    setTimeout(() => {
                        $(this).css('border', 'none', '!important');
                        $(this).css('border-bottom', '1px solid #ddd', '!important');
                        $(this).css('border-radius', '0', '!important');
                        $(this).css('border-top', 'none', '!important');
                    }, 6000);
                }

                table.on('touchmove', function(event) {
                    // Detectar si el usuario está desplazándose
                    let currentY = event.originalEvent.touches[0].clientY;
                    let currentX = event.originalEvent.touches[0].clientX;

                    if (Math.abs(currentY - touchStartY) > 10 || Math.abs(currentX - touchStartX) > 10) {
                        clearTimeout(timer); // Cancelar el temporizador si hay scroll
                    }
                });

                table.on('touchend', function() {
                    clearTimeout(timer); // Cancelar el temporizador si el toque termina antes del tiempo requerido
                });

            });
        }

        function getHistorial (id, name, trazabilidad){
            $.ajax({
                url: `/admin/articulos/historial/${id}`,
                type: 'GET',
                success: function(response) {

                    closeLoader();
                    $('#showDetailsModal').modal('show');
                    
                    const container = $('#showDetailsModal #showAccordeons');
                    container.empty();  // Limpiar el contenedor antes de agregar nuevos elementos

                    $('#showDetailsModalLabel').text(`Historial del articulo ${name} y trazabilidad: ${trazabilidad}`);

                    const { status, success, data, articulo: artPortada } = response;

                    // Información general del articulo Cuando fue la ultima vez que se compró, el stock actual, el stock minimo y maximo
                    const { stock, created_at, TrazabilidadArticulos, empresa, compras: compra, imgArticulo } = artPortada;

                    let elementsToSlider = [];

                    if ( imgArticulo.length ) {
                        elementsToSlider = imgArticulo.map( (item, index) => {
                            const { archivo } = item;
                            const { idarchivos, nameFile, typeFile, pathFile } = archivo;
                            return {
                                id: idarchivos,
                                src: globalBaseUrl + pathFile,
                                alt: nameFile,
                                title: nameFile
                            }
                        });
                    }

                    if (compra) {
                        const { archivos: archivosCompras = [] , lineas, totalFactura: infoFactura, Importe: infoImporte, Iva: infoIva, Plazos: infoPlazos, totalIva: infoTotalIva, totalFactura: infoTotalFac } = compra;
                    }

                    const InfoItem = `
                        <div class="accordion mb-3" id="showAccordeonsElements">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingInfo">
                                    <button 
                                        class="accordion-button" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapseInfo" 
                                        aria-expanded="true" 
                                        aria-controls="collapseInfo"
                                    >
                                        <ion-icon style="font-size: 28px; margin-right: 10px" name="information-circle-outline"></ion-icon> Información General
                                    </button>
                                </h2>
                                <div id="collapseInfo" class="accordion-collapse collapse show" aria-labelledby="headingInfo" data-bs-parent="#showAccordeons">
                                    <div class="accordion-body">
                                        ${
                                            imgArticulo.length > 0 ? `
                                                <h6
                                                    class="text-center"
                                                    style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem;"
                                                >
                                                    <ion-icon name="images-outline"></ion-icon> 
                                                    Imágenes del Artículo
                                                </h6>
                                                <div id="sliderContainer"></div>
                                            ` : ''
                                        }
                                        <!-- Información General en 2 columnas -->
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <h5>Última Compra: ${stock.ultimaCompraDate}</h5>
                                                <p><strong>Stock Actual:</strong> ${stock.cantidad}</p>
                                                <p><strong>Stock Mínimo:</strong> ${stock.existenciasMin}</p>
                                                <p><strong>Stock Máximo:</strong> ${stock.existenciasMax}</p>
                                                <p><strong>Trazabilidad:</strong> ${formatTrazabilidad(TrazabilidadArticulos)}</p>
                                                ${ artPortada.proveedor ? `<p><strong>Proveedor:</strong> ${artPortada.proveedor.nombreProveedor}</p>` : '' }
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                ${
                                                    compra ? `
                                                        <p><strong>Empresa:</strong> ${(empresa) ? empresa.EMP : artPortada.categoria.nameCategoria}</p>
                                                        <p><strong>Importe:</strong> ${compra.Importe}€</p>
                                                        <p><strong>IVA:</strong> ${compra.Iva}%</p>
                                                        <p><strong>Total IVA:</strong> ${compra.totalIva}€</p>
                                                        <p><strong>Total de Factura:</strong> ${compra.totalFactura}€</p>
                                                        <p><strong>Plazos:</strong> ${compra.Plazos}</p>
                                                    ` : `
                                                        <div class="alert alert-warning" role="alert">
                                                            No hay compras asociadas a este artículo
                                                        </div>
                                                    `
                                                }
                                            </div>
                                        </div>
                                        <hr>
                                        <!-- Archivos Asociados -->
                                        <h6><ion-icon name="file-tray-stacked-outline"></ion-icon> Archivos Asociados</h6>
                                        <div class="d-flex flex-wrap gap-3">
                                            ${ (compra) && compra.archivos.map((archivo, idx) => {
                                                const { idarchivos, nameFile, typeFile, pathFile } = archivo;

                                                const url = globalBaseUrl + pathFile;
                                                let icon = 'document-text-outline';
                                                return `
                                                    <a href="${url}" target="_blank" class="btn btn-outline-info">
                                                        <ion-icon name="${icon}"></ion-icon> ${nameFile}
                                                    </a>
                                                `;
                                            }).join('')}
                                        </div>
                                        <hr>
                                        <!-- Líneas de Compra -->
                                        <h6><ion-icon name="time-outline"></ion-icon> Líneas de compra</h6>
                                        <div class="col-sm-12">
                                            <table id="lineasTableInfo" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Id</th>
                                                        <th scope="col">Descripción</th>
                                                        <th scope="col">Cantidad</th>
                                                        <th scope="col">Descuento</th>
                                                        <th scope="col">Precio</th>
                                                        <th scope="col">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${ (compra) && compra.lineas.map((linea, idx) => {
                                                        const { idLinea, cantidad, precio, total, descripcion: descLinea, descuento: descuentoLinea, precioSinIva: preLinea } = linea;
                                                        return `
                                                            <tr>
                                                                <td>${idLinea}</td>
                                                                <td>${descLinea}</td>
                                                                <td>${cantidad}</td>
                                                                <td>${descuentoLinea}</td>
                                                                <td>${preLinea}€</td>
                                                                <td>${total}€</td>
                                                            </tr>
                                                        `;
                                                    }).join('')}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    container.append(InfoItem);

                    if (imgArticulo.length > 0) {
                        $('#sliderContainer').html('');  // Limpiar el contenedor antes de agregar nuevos elementos
                        $('#sliderContainer').css("margin-bottom", "1rem", "margin-top", "1rem");
                        renderSlider("sliderContainer", elementsToSlider);
                    }

                    const infoTable = $('#lineasTableInfo').DataTable({
                        colReorder: {
                            realtime: false
                        },
                        // responsive: true,
                        // autoFill: true,
                        // fixedColumns: true,
                        order: [[1, 'desc']],
                        columnDefs: [
                            {
                                targets: [0], // Columna de "Seleccionar"
                                visible: false, // Ocultarla inicialmente
                                searchable: false
                            },
                            
                        ],
                        language: {
                            processing: "Procesando...",
                            search: "Buscar:",
                            lengthMenu: "Mostrar _MENU_ ",
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
                                sortAscending: ": actilet para ordenar la columna en orden ascendente",
                                sortDescending: ": actilet para ordenar la columna en orden descendente"
                            }
                        },

                        pageLength: 50,  // Mostrar 50 registros por defecto
                        lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opciones para seleccionar cantidad de registros
                        dom:    "<'row'<'col-12 col-md-6 col-sm-6 left-buttons'B><'col-12 col-md-6 col-sm-6 d-flex justify-content-end right-filter'f>>" +
                                "<'row'<'col-12 col-md-6'l><'d-flex justify-content-end col-12 col-md-6'p>>" + // l para el selector de cantidad de registros
                                "<'row'<'col-12'tr>>" +
                                "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>",
                        buttons: [

                        ],
                    });

                    if( data.length <= 0 ) {
                        container.append(`
                            <div class="alert alert-warning" role="alert">
                                No hay historial de usos para este articulo
                            </div>
                        `);
                    }

                    data.forEach((element, index) => {
                        const { parte_trabajo, articulo, cantidad, total, precioSinIva } = element;
                        const { nombreArticulo, ptsCosto, ptsVenta, beneficio, TrazabilidadArticulos } = articulo;
                        const { archivos, cliente, orden, trabajo, archivos_many } = parte_trabajo;
                        const { operarios, proyecto } = orden;

                        const iconSet = `
                            <ion-icon style="font-size: 28px; margin-right: 10px" name="document-text-outline"></ion-icon>
                        `;

                        const estadoParte = parte_trabajo.Estado == 1 ? 'Pendiente' : (parte_trabajo.Estado == 2 ? 'En Proceso' : 'Finalizado');
                        const colorBadge  = parte_trabajo.Estado == 1 ? 'bg-warning' : (parte_trabajo.Estado == 2 ? 'bg-info' : 'bg-success');

                        // obtener los nombres de los operarios
                        let operariosNames = '';
                        operarios.forEach((operario, index) => {
                            operariosNames += `<p>- ${operario.nameOperario}</p>`;
                        });

                        // Acordeón para el parte de trabajo
                        const accordionItem = `
                            <div class="accordion mb-2" id="showAccordeonsElements">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading${index}">
                                        <button 
                                            class="accordion-button" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse${index}" 
                                            aria-expanded="true" 
                                            aria-controls="collapse${index}"
                                        >
                                            ${iconSet} #${parte_trabajo.idParteTrabajo} Parte de Trabajo: ${parte_trabajo.Asunto} 
                                            <span class="badge ${colorBadge} ml-2">${estadoParte}</span>
                                        </button>
                                    </h2>
                                    <div id="collapse${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading${index}" data-bs-parent="#showAccordeons">
                                        <div class="accordion-body">
                                            <h5>Artículo Usado: <strong>${nombreArticulo}</strong></h5>
                                            <p><strong>Cantidad:</strong> ${cantidad}</p>
                                            <p><strong>Precio sin IVA:</strong> €${precioSinIva}</p>
                                            <p><strong>Total:</strong> €${total}</p>
                                            <p><strong>Encargado/s:</strong>${operariosNames}</p>
                                            <button 
                                                class="btn btn-outline-warning showDetailsParteTrabajo"
                                                data-parteid="${parte_trabajo.idParteTrabajo}"
                                            >
                                                Ver parte
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        container.append(accordionItem);
                    });

                    $('.showDetailsParteTrabajo').click(function() {
                        const parteId = $(this).data('parteid');
                        openDetailsParteTrabajoModal(parteId);
                    });

                },
                error: function(error) {
                    console.error(error);
                    closeLoader();
                }
            });
        }

    </script>

    
    <script>
        function editarCitaAjax(id){
            $.ajax({
                url: `/admin/citas/${id}`,
                method: 'GET',
                beforeSend: function() {
                    
                    // limpiar los campos del modal
                    $('#editCitaModal #filesPreviewContainer').html('');

                },
                success: function(response) {
                    
                    $('#editCitaModal #estadoEdit').next('p').remove();

                    if ( response.success ) {

                        let cita     = response.cita;
                        let userCita = response.cita.user;
                        let archivos = response.archivos;
                        let orden    = response.orden;


                        // cambiar el titulo del modal
                        $('#editCitaModal .modal-title').text(`Editar cita: ${cita.idCitas}`);

                        $('#editCitaModal #fechaCitaEdit').val(cita.fechaDeAlta);
                        $('#editCitaModal #asuntoEdit').val(cita.asunto);
                        $('#editCitaModal #tipoCitaEdit').val(cita.tipoCita);
                        $('#editCitaModal #usuarioQueCreaLaCitaEdit').val(userCita.id);
                        $('#editCitaModal #nameToShow').val(userCita.name);
                        $('#editCitaModal #estadoEdit').val(cita.estado);
                        $('#editCitaModal #enlaceDoc').val(cita.enlaceDoc);
                        $('#editCitaModal #cliente_id').val(cita.cliente_id);

                        let archivosContainer = $('#editCitaModal #filesPreviewContainer');
                        archivosContainer.html('');

                        if (archivos.length == 0) {
                            archivosContainer.append('<p>No hay archivos adjuntos</p>');
                        } else {
                            for (let i = 0; i < archivos.length; i++) {
                                let archivo = archivos[i];
                                let type = archivo.typeFile;
                                let url = archivo.pathFile;
                                let comentario = archivo.comentarioArchivo || ''; // Si no hay comentario, asignar cadena vacía

                                let urlFinal = globalBaseUrl + url;
                                let finalType = '';

                                switch (type) {
                                    case 'jpg':
                                    case 'jpeg':
                                    case 'png':
                                    case 'gif':
                                        finalType = 'image';
                                        break;
                                    case 'mp4':
                                    case 'avi':
                                    case 'mov':
                                    case 'wmv':
                                    case 'flv':
                                    case '3gp':
                                    case 'webm':
                                        finalType = 'video';
                                        break;
                                    case 'mp3':
                                    case 'wav':
                                    case 'ogg':
                                    case 'm4a':
                                    case 'flac':
                                    case 'wma':
                                        finalType = 'audio';
                                        break;
                                    case 'pdf':
                                        finalType = 'pdf';
                                        break;
                                    case 'doc':
                                    case 'docx':
                                        finalType = 'word';
                                        break;
                                    case 'xls':
                                    case 'xlsx':
                                        finalType = 'excel';
                                        break;
                                    case 'ppt':
                                    case 'pptx':
                                        finalType = 'powerpoint';
                                        break;
                                    default:
                                        finalType = 'image';
                                        break;
                                }

                                // Wrapper for each file and comment
                                const fileWrapper = $(`<div class="file-wrapper"></div>`).css({
                                    'display': 'inline-block',
                                    'text-align': 'center',
                                    'margin': '10px',
                                    'width': '100%',
                                    'max-width': '350px',
                                    'height': 'auto',
                                    'vertical-align': 'top',
                                    'border': '1px solid #ddd',
                                    'padding': '10px',
                                    'border-radius': '5px',
                                    'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                                    'overflow': 'hidden',
                                    'position': 'relative',
                                    'box-sizing': 'border-box' // Ensure padding is included within width
                                });

                                // Content wrapper to maintain consistent dimensions for different media types
                                const contentWrapper = $('<div class="contentFiles-wrapper"></div>').css({
                                    'width': '100%',
                                    'height': '250px',  // Set a fixed height for the container
                                    'display': 'flex',
                                    'align-items': 'center',
                                    'justify-content': 'center',
                                    'margin-bottom': '10px',
                                    'overflow': 'hidden'
                                });

                                let fileContent;

                                switch (finalType) {
                                    case 'image':
                                        fileContent = `<img src="${urlFinal}" style="width: 100%; height: 100%; object-fit: contain;">`;
                                        break;
                                    case 'video':
                                        fileContent = `<video controls style="width: 100%; height: 100%; object-fit: contain;"><source src="${urlFinal}" type="video/mp4" /></video>`;
                                        break;
                                    case 'audio':
                                        fileContent = `<audio controls style="width: 100%;"><source src="${urlFinal}" type="audio/mpeg" /></audio>`;
                                        break;
                                    case 'pdf':
                                        fileContent = `<embed src="${urlFinal}" type="application/pdf" style="width: 100%; height: 100%; object-fit: contain;">`;
                                        break;
                                    case 'word':
                                    case 'excel':
                                    case 'powerpoint':
                                        fileContent = `<iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${urlFinal}" style="width: 100%; height: 100%; object-fit: contain;" frameborder="0"></iframe>`;
                                        break;
                                    default:
                                        fileContent = `<img src="${urlFinal}" style="width: 100%; height: 100%; object-fit: contain;">`;
                                        break;
                                }

                                contentWrapper.append(fileContent);
                                fileWrapper.append(contentWrapper);

                                const commentBox = $(`<textarea class="form-control editCommentario" data-archivoid="${archivo.idarchivos}" name="comentario[${i + 1}]" placeholder="Comentario archivo ${i + 1}" rows="2" readonly></textarea>`).val(comentario);

                                const buttonDelete = $(`<button type="button" class="btn btn-danger removeFileServer" data-archivoid="${archivo.idarchivos}"><ion-icon name="trash-outline"></ion-icon></button>`);
                                const buttonDeleteContainer = $(`<div style="position: absolute; top: 0; right: 0;" class="d-flex justify-content-end"></div>`);
                                
                                buttonDeleteContainer.append(buttonDelete);
                                fileWrapper.append(buttonDeleteContainer);
                                fileWrapper.append(commentBox);

                                archivosContainer.append(fileWrapper);
                            }
                        }

                         // evento para eliminar archivo
                         $('#editCitaModal .removeFileServer').off('click').on('click', function() {
                            const archivoId = $(this).data('archivoid');
                            // buscar el contenedor del archivo que tiene el atributo data-archivoid
                            const archivoWrapper = $(`#editCitaModal .file-wrapper[data-archivoid="${archivoId}"]`);

                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: "¡No podrás revertir esto!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminarlo!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    openLoader();
                                    $.ajax({
                                        url: "<?php echo e(route('admin.parte.deletefile')); ?>",
                                        method: 'POST',
                                        data: {
                                            archivoId: archivoId,
                                            _token: "<?php echo e(csrf_token()); ?>"
                                        },
                                        success: function(response) {
                                            closeLoader();
                                            if (response.success) {
                                                archivoWrapper.remove();
                                                Swal.fire(
                                                    '¡Eliminado!',
                                                    'El archivo ha sido eliminado.',
                                                    'success'
                                                );
                                            } else {
                                                Swal.fire(
                                                    'Error',
                                                    'No se ha podido eliminar el archivo.',
                                                    'error'
                                                );
                                            }
                                        },
                                        error: function(err) {
                                            closeLoader();
                                            console.error(err);
                                            Swal.fire(
                                                'Error',
                                                'No se ha podido eliminar el archivo.',
                                                'error'
                                            );
                                        }
                                    });
                                }
                            });
                        });

                        // evento doble click para habilitar la edición del comentario
                        $('#editCitaModal .editCommentario').off('dblclick touchstart').on('dblclick touchstart', function(event) {
                            // Detectar si es un toque prolongado
                            if (event.type === 'touchstart') {
                                let element = $(this);
                                let timer = setTimeout(function() {
                                    element.attr('readonly', false);
                                    element.focus();
                                }, 500); // 500 ms para considerar que es un toque prolongado

                                // cambiar el borde del textarea para indicar que está en modo edición
                                element.css('border', '1px solid #007bff');

                                // Cancelar el temporizador si el usuario levanta el dedo antes de los 500 ms
                                element.on('touchend', function() {
                                    clearTimeout(timer);
                                });
                            } else {
                                // Caso de doble clic (para dispositivos de escritorio)
                                $(this).attr('readonly', false);
                                $(this).focus();
                            }
                        });

                        // evento para editar comentario
                        $('#editCitaModal .editCommentario').off('change').on('change', function() {
                            const archivoId = $(this).data('archivoid');
                            const comentario = $(this).val();
                            openLoader();

                            $.ajax({
                                url: "<?php echo e(route('admin.parte.updatefile')); ?>",
                                method: 'POST',
                                data: {
                                    archivoId: archivoId,
                                    comentario: comentario,
                                    _token: "<?php echo e(csrf_token()); ?>"
                                },
                                success: function(response) {
                                    closeLoader();
                                    if (response.success) {
                                        showToast('Comentario actualizado correctamente', 'success');
                                        // Deshabilitar el textarea
                                        $('#editCitaModal .editCommentario').attr('readonly', true);
                                    } else {
                                        showToast('Error al actualizar el comentario', 'error');
                                    }
                                },
                                error: function(err) {
                                    openLoader();
                                    showToast('Error al actualizar el comentario', 'error');
                                }
                            });
                        });

                        if (cita.enlaceDoc) {
                            archivosContainer.append('<a href="' + cita.enlaceDoc + '" target="_blank">Enlace a documento</a>');
                        }

                        // Asignar el id de la cita al formulario de edición
                        $('#editCitaModal #formUpdate').attr('action', '<?php echo e(route('admin.citas.update', '')); ?>/' + cita.idCitas);

                        // deshabilitar el estado si la cita tiene una orden asociada
                        if (orden) {
                            $('#editCitaModal #estadoEdit').prop('disabled', true);

                            // Elimina cualquier mensaje previo antes de añadir uno nuevo
                            $('#editCitaModal .messageAlertCustom').remove();

                            // Mostrar un mensaje de que no se puede cambiar el estado
                            $('#editCitaModal #estadoEdit').after('<p class="text-danger messageAlertCustom">No se puede cambiar el estado de la cita porque tiene una orden asociada</p>');
                        } else {
                            $('#editCitaModal #estadoEdit').prop('disabled', false);

                            // Elimina cualquier mensaje previo de alerta
                            $('#editCitaModal .messageAlertCustom').remove();
                        }
                    }

                    closeLoader();
                },
                error: function(error) {
                    console.log(error);
                    closeLoader();
                }
            });
        }

        function detailsCitaAjax(id){
            $.ajax({
                url: `/admin/citas/${id}`,
                method: 'GET',
                beforeSend: function() {
                    
                    // limpiar los campos del modal
                    $('#detailsCitaModal #filesPreviewContainer').html('');

                    // limpiar todos los inputs del modal
                    $('#detailsCitaModal input, #detailsCitaModal select').val('');
                },
                success: function(response) {
                    
                    $('#detailsCitaModal #estado').next('p').remove();

                    if ( response.success ) {

                        let cita     = response.cita;
                        let userCita = response.cita.user;
                        let archivos = response.archivos;
                        let orden    = response.orden;


                        // cambiar el titulo del modal
                        $('#detailsCitaModal .modal-title').text(`Detalles de la cita: ${cita.idCitas}`);

                        $('#detailsCitaModal #fechaCita').val(cita.fechaDeAlta);
                        $('#detailsCitaModal #asunto').val(cita.asunto);
                        $('#detailsCitaModal #tipoCita').val(cita.tipoCita);
                        $('#detailsCitaModal #usuarioQueCreaLaCita').val(userCita.id);
                        $('#detailsCitaModal #nameToShow').val(userCita.name);
                        $('#detailsCitaModal #estado').val(cita.estado);
                        $('#detailsCitaModal #enlaceDoc').val(cita.enlaceDoc);
                        $('#detailsCitaModal #cliente').val(cita.cliente_id);

                        let archivosContainer = $('#detailsCitaModal #archivosDetalles');
                        archivosContainer.html('');

                        if (archivos.length == 0) {
                            archivosContainer.append('<p>No hay archivos adjuntos</p>');
                        } else {
                            for (let i = 0; i < archivos.length; i++) {
                                let archivo = archivos[i];
                                // mostrar vista previa de la imagen, video o audio o documento subido
                                
                                let fileType = archivo.typeFile; // jpg, jpeg, png, gif, mp4, mp3, pdf, doc, docx, xls, xlsx, wav, mov, ogg, webm
                                let fileExtension = archivo.nameFile.split('.').pop();
                
                                let filePreview = '';

                                switch (fileType) {
                                    case 'jpg' || 'jpeg' || 'png' || 'gif':
                                        fileType = 'image';
                                        break;
                                    case 'mp4' || 'mov' || 'webm' || 'avi':
                                        fileType = 'video';
                                        break;
                                    case 'mp3' || 'wav' || 'ogg':
                                        fileType = 'audio';
                                        break;
                                    case 'pdf' || 'doc' || 'docx' || 'xls' || 'xlsx':
                                        fileType = 'application';
                                        break;
                                    default:
                                        fileType = 'image';
                                        break;
                                }

                                const url = globalBaseUrl + archivo.pathFile;

                                if (fileType == 'image') {
                                    filePreview = `<img src='${url}' style="max-width: 300px; max-height: 300px; margin: 5px; object-fit: contain;">`;
                                } else if (fileType == 'video') {
                                    filePreview = `<video src='${url}' style="max-width: 300px; max-height: 300px; margin: 5px" controls></video>`;
                                } else if (fileType == 'application') {
                                    if (fileExtension == 'pdf') {
                                        filePreview = `<embed src='${url}' style="max-width: 300px; max-height: 300px; margin: 5px">`;
                                    } else if (fileExtension == 'doc' || fileExtension == 'docx') {
                                        filePreview = `<ion-icon name="document" style="max-width: 300px; max-height: 300px; margin: 5px"></ion-icon>`;
                                    }
                                }

                                // verificar si la imagen o video está en formato horizontal para ordernar todas las verticales primero y luego las horizontales

                                if(fileType == 'image'){

                                    const img = new Image();
                                    img.src = url;

                                    img.onload = function() {
                                        if (this.width > this.height) {
                                            archivosContainer.prepend('<div class="file-preview-item d-flex justify-content-between g-2 flex-wrap flex-column align-items-center align-self-center">' + filePreview + '<a href="<?php echo e(route('admin.citas.download', '')); ?>/' + archivo.idarchivos + '" class="btn btn-outline-primary m-1">Descargar</a>');
                                        } else {
                                            archivosContainer.append('<div class="file-preview-item d-flex justify-content-between g-2 flex-wrap flex-column align-items-center align-self-center">' + filePreview + '<a href="<?php echo e(route('admin.citas.download', '')); ?>/' + archivo.idarchivos + '" class="btn btn-outline-primary m-1">Descargar</a>');
                                        }
                                    }

                                }else{
                                    archivosContainer.append('<div class="file-preview-item d-flex justify-content-between g-2 flex-wrap flex-column align-items-center align-self-center">' + filePreview + '<a href="<?php echo e(route('admin.citas.download', '')); ?>/' + archivo.idarchivos + '" class="btn btn-outline-primary m-1">Descargar</a>');
                                }

                                // añadir boton para descargar el archivo

                                archivosContainer.append('');

                                console.log(archivosContainer);

                                archivosContainer.find('img, video').css('cursor', 'pointer');

                                // añadir evento a la imagen o video para que se abra en una nueva pestaña
                                archivosContainer.find('img, video').on('click', function() {
                                    window.open(url, '_blank');
                                });
                            }
                        }

                        if (cita.enlaceDoc) {
                            archivosContainer.append('<a href="' + cita.enlaceDoc + '" target="_blank">Enlace a documento</a>');
                        }

                        // deshabilitar el estado si la cita tiene una orden asociada
                        if (orden) {
                            $('#detailsCitaModal #estado').prop('disabled', true);

                            // Elimina cualquier mensaje previo antes de añadir uno nuevo
                            $('#detailsCitaModal .messageAlertCustom').remove();

                            // Mostrar un mensaje de que no se puede cambiar el estado
                            $('#detailsCitaModal #estado').after('<p class="text-danger messageAlertCustom">No se puede cambiar el estado de la cita porque tiene una orden asociada</p>');
                        } else {
                            $('#detailsCitaModal #estado').prop('disabled', false);

                            // Elimina cualquier mensaje previo de alerta
                            $('#detailsCitaModal .messageAlertCustom').remove();
                        }
                    }

                    closeLoader();
                },
                error: function(error) {
                    console.log(error);
                    closeLoader();
                }
            });
        }

        function editOrdenTrabajo(orderId){
            $.ajax({
                url: `/admin/ordenes/showApi`,
                method: 'post',
                data: {
                    ordenId: orderId,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                beforeSend: function() {
                    openLoader();
                    // Limpiar y resetear los inputs de archivos
                    $('#modalEditOrden #inputsToUploadFilesContainer').empty();
                    $('#modalEditOrden #files1').val('');  // Resetear el input principal de archivos
                    $('#modalEditOrden #previewImage1').empty();
                },
                success: function(response) {
                    if (response.success) {
                    
                        const ordenTrabajo = response.orden;

                        let idOrden         = orderId;
                        let asunto          = ordenTrabajo.Asunto;
                        let fechaAlta       = ordenTrabajo.FechaAlta;
                        let fechaVisita     = ordenTrabajo.FechaVisita;
                        let estado          = ordenTrabajo.Estado;
                        let cliente         = ordenTrabajo.cliente_id;
                        let departamento    = ordenTrabajo.Departamento;
                        let trabajos        = ordenTrabajo.trabajo;
                        let operarios       = ordenTrabajo.operarios;
                        let observaciones   = ordenTrabajo.Observaciones;
                        let archivos        = ordenTrabajo.archivos;

                        $('#modalEditOrden #formEditOrden').attr('action', `/admin/ordenes/update/${idOrden}`);

                        // Limpiar los select múltiples
                        $('#modalEditOrden #trabajo_idEdit').val(null);
                        $('#modalEditOrden #operario_idEdit').val(null);

                        // Asignar los valores a los campos del modal
                        $('#editOrdenTitle').text(`Editar Orden ${idOrden}`);

                        // asignar los valores al select múltiple de trabajos select2
                        trabajos.forEach(({idTrabajo, nameTrabajo}) => {
                            $('#trabajo_idEdit').append(new Option(nameTrabajo, idTrabajo, true, true));
                        });

                        // asignar los valores al select múltiple de operarios select2
                        operarios.forEach(({idOperario, nameOperario}) => {
                            $('#operario_idEdit').append(new Option(nameOperario, idOperario, true, true));
                        });

                        $('#modalEditOrden #asuntoEdit').val(asunto);
                        $('#modalEditOrden #fecha_altaEdit').val(fechaAlta);
                        $('#modalEditOrden #fecha_visitaEdit').val(fechaVisita);
                        $('#modalEditOrden #estadoEdit').val(estado);
                        $('#modalEditOrden #cliente_idEdit').val(cliente);
                        $('#modalEditOrden #departamentoEdit').val(departamento);
                        $('#modalEditOrden #observacionesEdit').val(observaciones);

                        $('#modalEditOrden #btnEditOrden').off('click').on('click', function() {
                            openLoader();
                            $('#formEditOrden').append(`<input type="hidden" name="idOrden" value="${idOrden}">`);
                            $('#formEditOrden').submit();
                        });

                        const imagesContainer = $('#modalEditOrden #previewImage1');
                        imagesContainer.empty();

                        archivos.forEach((imagen, index) => {
                            const archivo = imagen;

                            const fileWrapper = $(`<div class="file-wrapper" data-archivoid="${archivo.idarchivos}"></div>`).css({
                                'display': 'flex',
                                'flex-direction': 'column',
                                'justify-content': 'center',
                                'text-align': 'center',
                                'margin': '10px',
                                'width': '250px',
                                'max-height': '650px',
                                'border': '1px solid #ddd',
                                'padding': '10px',
                                'border-radius': '5px',
                                'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                                'overflow': 'hidden',
                                'gap': '15px',
                                'align-items': 'center',
                                'flex-wrap': 'wrap',
                                'position': 'relative'
                            });

                            const type = archivo.typeFile;
                            let fileName = '';

                            let url = archivo.pathFile;

                            url = globalBaseUrl + url;

                            if (type === 'pdf') {
                                fileName = $(`<embed src="${url}" type="application/pdf" width="250" height="300">`);
                            } else if (type === 'mp4' || type === 'webm' || type === 'ogg') {
                                fileName = $(`<video width="250" height="300" controls><source src="${url}" type="video/${type}"></video>`);
                            } else if (type === 'mp3' || type === 'wav') {
                                fileName = $(`<audio controls><source src="${url}" type="audio/${type}"></audio>`);
                            } else {
                                fileName = $(`<img src="${url}" alt="Archivo ${index + 1}" style="max-width: 100%; max-height: 100%; object-fit: contain">`);
                            }

                            fileName.css('margin-bottom', '15px');

                            const commentBox = $(`<textarea class="form-control mb-2 editCommentario" data-archivoid="${archivo.idarchivos}" name="comentario[${index + 1}]" placeholder="Comentario archivo ${index + 1}" rows="2" readonly></textarea>`).val(archivo.comentarioArchivo);

                            const buttonDelete = $(`<button type="button" class="btn btn-danger removeFileServer" data-archivoid="${archivo.idarchivos}"><ion-icon name="trash-outline"></ion-icon></button>`);
                            const buttonDeleteContainer = $(`<div style="position: absolute; top: 0; right: 0;" class="d-flex justify-content-end"></div>`);

                            buttonDeleteContainer.append(buttonDelete);
                            fileWrapper.append(fileName);
                            fileWrapper.append(commentBox);
                            fileWrapper.append(buttonDeleteContainer);

                            imagesContainer.append(fileWrapper);
                        });

                        // evento para eliminar archivo
                        $('#modalEditOrden').off('click', '.removeFileServer').on('click', '.removeFileServer', function() {
                            const archivoId = $(this).data('archivoid');
                            const archivoWrapper = $(`#modalEditOrden .file-wrapper[data-archivoid="${archivoId}"]`);

                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: "¡No podrás revertir esto!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminarlo!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    openLoader();
                                    $.ajax({
                                        url: "<?php echo e(route('admin.parte.deletefile')); ?>",
                                        method: 'POST',
                                        data: {
                                            archivoId: archivoId,
                                            _token: "<?php echo e(csrf_token()); ?>"
                                        },
                                        success: function(response) {
                                            closeLoader();
                                            if (response.success) {
                                                archivoWrapper.remove();
                                                Swal.fire(
                                                    '¡Eliminado!',
                                                    'El archivo ha sido eliminado.',
                                                    'success'
                                                );
                                            } else {
                                                Swal.fire('Error', 'No se ha podido eliminar el archivo.', 'error');
                                            }
                                        },
                                        error: function(err) {
                                            closeLoader();
                                            Swal.fire('Error', 'No se ha podido eliminar el archivo.', 'error');
                                        }
                                    });
                                }
                            });
                        });

                        // Evento para habilitar edición del comentario con doble clic o toque largo
                        $('#modalEditOrden').off('dblclick touchstart', '.editCommentario').on('dblclick touchstart', '.editCommentario', function(event) {
                            if (event.type === 'touchstart') {
                                let element = $(this);
                                let timer = setTimeout(function() {
                                    element.attr('readonly', false).css('border', '1px solid #007bff').focus();
                                }, 500);

                                element.on('touchend', function() {
                                    clearTimeout(timer);
                                });
                            } else {
                                $(this).attr('readonly', false).css('border', '1px solid #007bff').focus();
                            }
                        });

                        // Evento para guardar el comentario editado
                        $('#modalEditOrden').off('change', '.editCommentario').on('change', '.editCommentario', function() {
                            const archivoId = $(this).data('archivoid');
                            const comentario = $(this).val();
                            openLoader();

                            $.ajax({
                                url: "<?php echo e(route('admin.parte.updatefile')); ?>",
                                method: 'POST',
                                data: {
                                    archivoId: archivoId,
                                    comentario: comentario,
                                    _token: "<?php echo e(csrf_token()); ?>"
                                },
                                success: function(response) {
                                    closeLoader();
                                    if (response.success) {
                                        showToast('Comentario actualizado correctamente', 'success');
                                        $('.editCommentario[data-archivoid="' + archivoId + '"]').attr('readonly', true).css('border', '1px solid #ccc');
                                    } else {
                                        showToast('Error al actualizar el comentario', 'error');
                                    }
                                },
                                error: function(err) {
                                    closeLoader();
                                    showToast('Error al actualizar el comentario', 'error');
                                }
                            });
                        });

                        // Subir archivos y mostrar una vista previa de la imagen o icono si es un archivo
                        $('#modalEditOrden #files1').off('change').on('change', function() {
                            const files = $(this)[0].files;
                            const filesContainer = $('#modalEditOrden #previewImage1');

                            // Añadir previsualización
                            previewFiles(files, filesContainer, 0);
                        });

                        $('#modalEditOrden #files1').off('change').on('click', function(e) {
                            // verificar si hay archivos cargados
                            if ($('#modalEditOrden #previewImage1').children().length > 0) {
                                e.preventDefault();
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'warning',
                                    title: 'Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                return;
                            }
                        });

                        $('#modalEditOrden #inputsToUploadFilesContainer').empty();

                        // Evento para añadir más inputs de archivos
                        $('#modalEditOrden #btnAddFiles').off('click').on('click', function() {
                            const newInputContainer = $('<div class="form-group col-md-12"></div>');
                            const inputIndex = $('#modalEditOrden #inputsToUploadFilesContainer input').length + 1; // Índice del nuevo input
                            const newInputId = `input_${inputIndex}`;

                            // Como máximo se pueden añadir 5 inputs
                            if (inputIndex >= 5) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'warning',
                                    title: 'No puedes añadir más de 5 archivos',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                return;
                            }

                            const newInput = $(`<input type="file" class="form-control" name="file[]" id="${newInputId}">`);
                            newInputContainer.append(newInput);
                            $('#modalEditOrden #inputsToUploadFilesContainer').append(newInputContainer);

                            newInput.val('');  // Resetear el input de archivos

                            // Manejar la previsualización para los nuevos inputs
                            newInput.on('change', function() {
                                const files = $(this)[0].files;
                                const filesContainer = $('#modalEditOrden #previewImage1');

                                // Añadir previsualización
                                previewFiles(files, filesContainer, inputIndex);
                            });

                            newInput.on('click', function(e) {
                                // verificar si hay archivos cargados
                                if ($('#modalEditOrden #previewImage1').children().length > inputIndex) {
                                    e.preventDefault();
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'warning',
                                        title: 'Ya has cargado archivos. Si deseas cargar más, utiliza el botón "Añadir más archivos"',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    return;
                                }
                            });
                        });

                        // Evento para eliminar archivos de la previsualización
                        $(document).off('click').on('click', '.btnRemoveFile', function() {
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
                    }

                    $('#modalEditOrden').modal('show');

                    $('#modalEditOrden').on('shown.bs.modal', () => {

                        $('select.form-select').select2({
                            width: '100%',  // Asegura que el select ocupe el 100% del contenedor
                            dropdownParent: $('#modalEditOrden')  // Asocia el dropdown con el modal para evitar problemas de superposición
                        });

                    });

                    closeLoader();
                },
                error: function(err) {
                    console.log(err);
                    closeLoader();
                }
            });
        }

        function HandleProjectsPartesAddDelete(projectId){

            $('#addOrdersModal').modal('show');
            $('#orderName').empty();
            $('#ordersContainer').empty();
            $('#addOrdersModaltitle').text('Agregar Partes al Proyecto #' + projectId);

            $.ajax({
                url: '/admin/proyectos/ordenes/' + projectId,
                type: 'GET',
                beforeSend: function() {
                    openLoader();
                },
                success: function(response) {
                    closeLoader();
                    const { ordenesDisponibles, ordenesProyecto, status } = response;

                    $('#ordersContainer').empty();

                    ordenesProyecto.forEach(order => {
                        $('#ordersContainer').append(`
                            <div class="card" style="overflow: unset">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-truncate" style="max-width: 70%;">#${order.idOrdenTrabajo} - Asunto: ${order.Asunto}</span>
                                        <div class="d-flex justify-between align-items-center gap-1">
                                            <button class="btn btn-outline-primary showOrder" data-orderid="${order.idOrdenTrabajo}">
                                                <ion-icon name="eye-outline"></ion-icon>
                                            </button>
                                            <button class="btn btn-outline-danger removeOrder" data-orderid="${order.idOrdenTrabajo}" data-projectid="${projectId}">
                                                <ion-icon name="trash-outline"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    });

                    // evento para mostrar la orden
                    $('#ordersContainer').off('click', '.showOrder').on('click', '.showOrder', function() {
                        const orderId = $(this).data('orderid');
                        openDetailsParteTrabajoModal(orderId);
                    });

                    ordenesDisponibles.forEach(order => {
                        $('#orderName').append(`<option value="${order.idOrdenTrabajo}"> #${order.idOrdenTrabajo} - ${order.Asunto}</option>`);
                    });

                    $('#orderName').val(null);

                    // evento para añadir ordenes
                    $('#orderName').off('change').on('change', function() {
                        const orderId = $('#orderName').val();
                        if (!orderId) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Debes seleccionar una orden para añadirla al proyecto'
                            });
                            return;
                        }

                        Swal.fire({
                            title: '¿Estás seguro de añadir esta orden al proyecto?',
                            text: `¡Vas a añadir la orden ${orderId} al proyecto ${projectId} si la orden tiene parte de trabajo, se asignará de manera automatica!`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, añadirlo!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/admin/proyectos/addOrder',
                                    type: 'POST',
                                    data: {
                                        projectId: projectId,
                                        orderId: orderId,
                                        _token: "<?php echo e(csrf_token()); ?>"
                                    },
                                    beforeSend: function() {
                                        openLoader();
                                    },
                                    success: function(response) {
                                        closeLoader();
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Orden añadida correctamente',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                            
                                            // añadir la orden a la lista
                                            $('#ordersContainer').append(`
                                                <div class="card" style="overflow: unset">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="text-truncate" style="max-width: 70%;">#${response.order.idOrdenTrabajo} - ${response.order.Asunto}</span>
                                                            <div class="d-flex justify-between align-items-center gap-1">
                                                                <button class="btn btn-outline-primary showOrder" data-orderid="${response.order.idOrdenTrabajo}">
                                                                    <ion-icon name="eye-outline"></ion-icon>
                                                                </button>
                                                                <button class="btn btn-outline-danger removeOrder" data-orderid="${response.order.idOrdenTrabajo}" data-projectid="${projectId}">
                                                                    <ion-icon name="trash-outline"></ion-icon>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `);

                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: response.message
                                            });
                                        }
                                    },
                                    error: function(response) {
                                        closeLoader();
                                        console.log(response);
                                    }
                                });
                            }
                        })

                    });
                    
                    // evento para eliminar la asignación de la orden del proyecto
                    $('#ordersContainer').off('click', '.removeOrder').on('click', '.removeOrder', function() {
                        const orderId = $(this).data('orderid');
                        const projectId = $(this).data('projectid');

                        Swal.fire({
                            title: '¿Estás seguro de eliminar la orden del proyecto?',
                            text: `¡Vas a eliminar la orden ${orderId} del proyecto ${projectId}!`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, eliminarlo!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/admin/proyectos/removeOrder',
                                    type: 'POST',
                                    data: {
                                        projectId: projectId,
                                        orderId: orderId,
                                        _token: "<?php echo e(csrf_token()); ?>"
                                    },
                                    beforeSend: function() {
                                        openLoader();
                                    },
                                    success: function(response) {
                                        closeLoader();
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Orden eliminada correctamente',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });

                                            // eliminar la orden de la lista
                                            $(`#ordersContainer .card .card-body .d-flex .showOrder[data-orderid="${orderId}"]`).closest('.card').remove();
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: response.message
                                            });
                                        }
                                    },
                                    error: function(response) {
                                        closeLoader();
                                        console.log(response);
                                    }
                                });
                            }
                        });
                    });

                },
                error: function(response){
                    closeLoader();
                    console.log(response);
                }
            });
        }

        function getDetailsProject(id, isProjectModule = false){
            let projectid = id;

            let table = '';
            if (isProjectModule) {
                table = 'Project';
            }

            openLoader();
            $.ajax({
                url: "<?php echo e(route('admin.parte.getProjectDetails')); ?>",
                method: 'post',
                data: {
                    'projectid': projectid,
                    'table': table,
                    '_token': "<?php echo e(csrf_token()); ?>"
                },
                success: function(response){
                    closeLoader();
                    if(response.success){

                        const proyectoIdRes = response.proyecto.idProyecto;
                        projectid = proyectoIdRes;
                        const proyectoNameResponse = response.proyecto.name;

                        $('#showProjectDetailsModal #showProjectDetailsTitle').html(`Detalles del proyecto ${projectid}`);
                        
                        const container = $('#showProjectDetailsModal #showAccordeonsProject');
                        container.empty();
                        

                        let totalSumaPartes     = 0;
                        let costoMateriales     = 0;
                        let ventaMateriales     = 0;
                        let beneficioMateriales = 0;
                        let horasTrabajadas     = 0;
                        let manoDeObra          = 0;
                        let rentabilidad        = 0;
                        let desplazamiento      = 0;

                        response.proyecto.partes.forEach((element) => {
                            totalSumaPartes += parseFloat(element.suma);
                            horasTrabajadas += parseFloat(element.horas_trabajadas);
                            manoDeObra      += parseFloat(element.precio_hora);
                            desplazamiento  += parseFloat(element.desplazamiento);

                            element.partes_trabajo_lineas.forEach((linea) => {
                                costoMateriales     += parseFloat(linea.articulo.ptsCosto);
                                ventaMateriales     += parseFloat(linea.total);
                                beneficioMateriales += parseFloat(linea.total) - parseFloat(linea.articulo.ptsCosto) * parseFloat(linea.cantidad);
                            });


                        });

                        rentabilidad = totalSumaPartes - costoMateriales - manoDeObra - desplazamiento;


                        const InfoItem = `
                            <div class="accordion mb-3" id="showAccordeonsElements">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingInfo">
                                        <button 
                                            class="accordion-button" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapseInfo" 
                                            aria-expanded="true" 
                                            aria-controls="collapseInfo"
                                        >
                                            <ion-icon style="font-size: 28px; margin-right: 10px" name="information-circle-outline"></ion-icon> Información General
                                        </button>
                                    </h2>
                                    <div id="collapseInfo" class="accordion-collapse collapse" aria-labelledby="headingInfo" data-bs-parent="#showAccordeons">
                                        <div class="accordion-body">
                                            <!-- Información General en 2 columnas -->
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <p><strong>Proyecto:</strong> ${response.proyecto.name}</p>
                                                    <p><strong>Fecha de Inicio:</strong> ${response.proyecto.start_date}</p>
                                                    <p><strong>Fecha de Fin:</strong> ${response.proyecto.end_date || 'Sin terminar'}</p>
                                                    <p><strong>Estado:</strong> ${(response.proyecto.status == 1) ? 'Pendiente' : 'Finalizado'}</p>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <p><strong>Cliente: </strong> ${response.proyecto.ordenes[0]?.cliente.NombreCliente} ${response.proyecto.ordenes[0]?.cliente.ApellidoCliente}</p>
                                                    <p><strong>Descripcion: </strong>${response.proyecto.description}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- Información General en 2 columnas -->
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <p><strong>Total: </strong> ${formatPrice(totalSumaPartes)}</p>
                                                    <p><strong>Costo total de Materiales utilizados: </strong> ${formatPrice(costoMateriales)}</p>
                                                    <p><strong>Venta Materiales: </strong> ${formatPrice(ventaMateriales)}</p>
                                                    <p><strong>Beneficio Materiales: </strong> ${formatPrice(beneficioMateriales)}</p>    
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <p><strong>Desplazamiento: </strong> ${formatPrice(desplazamiento)}</p>
                                                    <p><strong>Horas Trabajadas: </strong> ${horasTrabajadas.toFixed(2)}h</p>
                                                    <p><strong>Mano de Obra: </strong> ${formatPrice(manoDeObra)}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        const division = `
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <hr>
                                </div>
                            </div>
                        `;

                        container.append(InfoItem);

                        container.append(division);

                        const titulo = `
                            <h6 class="mt-2 mb-2 d-flex justify-content-start align-items-center gap-1">
                                <ion-icon style="font-size: 28px; margin-right: 10px" name="document-text-outline"></ion-icon>
                                Partes de Trabajo
                            </h6>
                        `;

                        container.append(titulo);

                        response.proyecto.partes.forEach((element, index) => {
                            const {
                                Asunto,
                                Departamento,
                                Estado,
                                FechaAlta,
                                FechaVisita,
                                NFactura,
                                Observaciones,
                                cliente_id,
                                desplazamiento,
                                estadoVenta,
                                hora_fin,
                                hora_inicio,
                                horas_trabajadas,
                                idParteTrabajo,
                                nombre_firmante,
                                orden_id,
                                precio_hora,
                                solucion,
                                suma,
                                trabajo_id,
                                totalParte,
                                ivaParte
                            } = element;

                            const iconSet = `
                                <ion-icon style="font-size: 28px; margin-right: 10px" name="document-text-outline"></ion-icon>
                            `;

                            const estadoParte = Estado == 1 ? 'Pendiente' : (Estado == 2 ? 'En Proceso' : 'Finalizado');
                            const colorBadge  = Estado == 1 ? 'bg-warning' : (Estado == 2 ? 'bg-info' : 'bg-success');

                            const accordionItem = `
                                <div class="accordion mb-2" id="showAccordeonsElements">
                                    <div class="accordion-item"
                                        data-rowToDelete="${idParteTrabajo}"
                                    >
                                        <h2 class="accordion-header" id="heading${index}">
                                            <button 
                                                class="accordion-button" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#collapse${index}" 
                                                aria-expanded="true" 
                                                aria-controls="collapse${index}"
                                            >
                                                ${iconSet} #${idParteTrabajo} Parte de Trabajo: ${Asunto} 
                                                <span class="badge ${colorBadge} ml-2">${estadoParte}</span>
                                            </button>
                                        </h2>
                                        <div id="collapse${index}" class="accordion-collapse collapse" aria-labelledby="heading${index}" data-bs-parent="#showAccordeons">
                                            <div class="accordion-body" style="white-space: normal; overflow-wrap: break-word; word-wrap: break-word;">
                                                <p><strong>Asunto:</strong> ${Asunto}</p>
                                                <p><strong>Departamento:</strong> ${Departamento}</p>
                                                <p><strong>Hora Inicio:</strong>${hora_inicio}</p>
                                                <p><strong>Hora Fin:</strong>${hora_fin}</p>
                                                <p><strong>Horas Trabajadas:</strong>${horas_trabajadas}</p>
                                                <p><strong>Mano de obra:</strong>${precio_hora}</p>
                                                <p><strong>B.I:</strong> ${formatPrice(suma)}</p>
                                                <p><strong>Iva%:</strong> ${ivaParte}</p>
                                                <p><strong>Total I.I:</strong> ${ ( totalParte ) ? formatPrice(totalParte) : ''}</p>
                                                <button 
                                                    class="btn btn-outline-warning showDetailsParteTrabajo"
                                                    data-parteid="${idParteTrabajo}"
                                                >
                                                    Ver parte
                                                </button>
                                                <button
                                                    class="btn btn-outline-danger removeOrder"
                                                    data-parteid="${idParteTrabajo}"
                                                    data-projectid="${projectid}"
                                                >
                                                    Quitar parte
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            container.append(accordionItem);
                        });

                        $('#showProjectDetailsModal').modal('show');

                        $('#showProjectDetailsModal .showDetailsParteTrabajo').click(function() {
                            const parteId = $(this).data('parteid');
                            openDetailsParteTrabajoModal(parteId);
                        });

                        $('#showProjectDetailsModal .removeOrder').off('click').on('click', function() {
                            const orderId = $(this).data('parteid');
                            const projectId = $(this).data('projectid');

                            Swal.fire({
                                title: '¿Estás seguro de quitar el parte del proyecto?',
                                text: `¡Vas a eliminar el parte ${orderId} del proyecto ${proyectoNameResponse}!`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminarlo!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: '/admin/proyectos/removeOrder',
                                        type: 'POST',
                                        data: {
                                            projectId: projectId,
                                            orderId: orderId,
                                            _token: "<?php echo e(csrf_token()); ?>"
                                        },
                                        beforeSend: function() {
                                            openLoader();
                                        },
                                        success: function(response) {
                                            closeLoader();
                                            if (response.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Parte eliminado correctamente',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });

                                                // eliminar la orden de la lista
                                                $(`#showProjectDetailsModal .accordion-item[data-rowToDelete="${orderId}"]`).remove();
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Oops...',
                                                    text: response.message
                                                });
                                            }
                                        },
                                        error: function(response) {
                                            closeLoader();
                                            console.log(response);
                                        }
                                    });
                                }
                            });
                        });

                        $('#showProjectDetailsModal .showDetailsOrdenTrabajo').click(function() {
                            const ordenId = $(this).data('ordenid');
                            openDetailsOrdersTrabajoModal(ordenId);
                        });

                        const otherButtonsContainer = $('#showProjectDetailsModal #showProjectDetailsFooter');
                        otherButtonsContainer.empty();

                        // Boton para generar albaran
                        const buttonAlbaran = `
                            <a href="/proyecto/${proyectoIdRes}/albaran" class="btn btn-success" target="_blank">
                                Albarán <ion-icon name="document-text-outline"></ion-icon>
                            </a>
                        `;

                        const buttonToAddNewParte = `
                            <button class="btn btn-primary" onclick="HandleProjectsPartesAddDelete(${proyectoIdRes})">
                                Añadir Parte <ion-icon name="add-outline"></ion-icon>
                            </button>
                        `;

                        // botones para descargar el zip con todos los partes de trabajo
                        const buttonZIP = `
                            <a href="/proyecto/${proyectoIdRes}/bundle" class="btn btn-warning" target="_blank">
                                ZIP <ion-icon name="download-outline"></ion-icon>
                            </a>
                        `;

                        otherButtonsContainer.append(buttonToAddNewParte);
                        otherButtonsContainer.append(buttonAlbaran);
                        otherButtonsContainer.append(buttonZIP);

                    }else{
                        showToast('Error al cargar los detalles del proyecto', 'danger');
                    }
                },
                error: function(error){
                    closeLoader();
                    showToast('Error al cargar los detalles del proyecto', 'danger');
                }
            });
        }

        function getImagesArticulos( id, nameArticulo ) {
            let idArticulo = id;
            $.ajax({
                url: `/admin/articulos/${idArticulo}/images`,
                method: 'GET',
                beforeSend: function() {
                    openLoader();
                },
                success: function(response) {
                    closeLoader();
                    if (response.success) {
                        const images = response.data;
                        const modal = $('#showImagesArticuloModal');
                        modal.find('#showImagesModalLabel').text(`Imágenes del artículo: ${nameArticulo}`);
                        modal.find('#showImages').empty();

                        modal.find('#showImages').css({
                            'display': 'flex',
                            'flex-wrap': 'wrap',
                            'justify-content': 'center',
                            'align-items': 'center',
                            'gap': '10px'
                        });

                        images.forEach(({archivo}) => {
                            const {pathFile, nameFile, typeFile} = archivo;

                            const fullUrl = globalBaseUrl + pathFile;

                            modal.find('#showImages').append(`
                                <img src="${fullUrl}" class="img-fluid"
                                    style="max-width: 100%; max-height: 100%; object-fit: contain;"
                                >
                            `);
                            modal.modal('show');
                        });

                    } else {
                        closeLoader();
                        console.error('Error al cargar las imágenes del artículo');
                    }
                },
                error: function(error) {
                    closeLoader();
                    console.error('Error al cargar las imágenes del artículo:', error);
                }
            });
        }

        function getEditCliente(id, name){
            let idClientes = id;
            $.ajax({
                url: `/admin/clientes/showApi/${idClientes}`,
                data: {
                    idClientes: idClientes,
                    _token: '<?php echo e(csrf_token()); ?>',
                    name: name
                },
                success: function(response) {

                    let cliente = response.cliente;

                    let cliente_id      = cliente.idClientes;
                    let cif             = cliente.CIF;
                    let nombre          = cliente.NombreCliente;
                    let apellido        = cliente.ApellidoCliente;
                    let direccion       = cliente.Direccion;
                    let codPostal       = cliente.CodPostalCliente;
                    let ciudad          = cliente.ciudad_Id;
                    let email           = cliente.EmailCliente;
                    let agente          = cliente.Agente;
                    let tipoCliente     = cliente.TipoClienteId;
                    let banco           = cliente.banco_id;
                    let sctaContable    = cliente.SctaContable;
                    let observaciones   = cliente.Observaciones;
                    let user            = cliente.user_id;
                    let movil           = cliente.telefonos;

                    const buttonsContainer = $('#buttonsContainerClienteEdit');

                    $('#modalTitleEdit').text('Editar Cliente: ' + nombre + ' ' + apellido);

                    // Limpia el contenedor de telefonos
                    $('#telefonosContainerEdit').empty();

                    buttonsContainer.empty();

                    buttonsContainer.css({
                        'display': 'flex',
                        'flex-wrap': 'wrap',
                        'justify-content': 'center',
                        'align-items': 'center',
                        'gap': '5px'
                    });

                    const havePermission = "<?php echo e(Auth::user()->can('admin.ventas.index')); ?>";

                    if ( havePermission == 1 ) {
                        buttonToShowVenta = document.createElement('a');
                        buttonToShowVenta.classList.add('btn', 'btn-primary');
                        buttonToShowVenta.innerHTML = 'Historial <ion-icon name="cash-outline"></ion-icon>';
                        buttonToShowVenta.setAttribute('data-bs-toggle', 'tooltip');
                        buttonToShowVenta.setAttribute('data-bs-placement', 'top');
                        buttonToShowVenta.setAttribute('title', 'Ver Historial');

                        buttonToShowVenta.addEventListener('click', function(event) {
                            event.preventDefault();
                            const button = this;
                            Swal.fire({
                                title: '¿Estás seguro de abrir el historial del cliente?',
                                text: 'Acceso solo para usuarios con permisos',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, abrir historial',
                                cancelButtonText: 'Cancelar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    // cerrar el modal
                                    $('#modal-cliente-edit').modal('hide');
                                    getHistorialCliente(cliente_id, 'Cliente');
                                }
                            })
                        });

                    }

                    // Agrega el boton de historial
                    buttonsContainer.append(buttonToShowVenta);

                    // Agrega los telefonos al contenedor

                    movil.forEach(( {telefono}, index ) => {
                        const indice = index + 1;
                        let btnDelete = $('<button type="button" class="btn btn-outline-danger btnDeleteTelefono mt-2 mb-2">Eliminar</button>');
                        let input = $('<input type="number" name="telefono[]" placeholder="Telefono  '+ indice +'" class="form-control" value="' + telefono + '" required>');
                        $('#telefonosContainerEdit').append(input).append(btnDelete);

                        btnDelete.click(function() {

                            // validar que no pueda eliminar todos los inputs, por lo menos debe haber uno
                            if ($('#telefonosContainerEdit').children().length <= 2) {
                                alert('No se pueden eliminar todos los telefonos');
                                return;
                            }

                            input.remove();
                            btnDelete.remove();
                            $('#btnAddTelefonoEdit').prop('disabled', false);
                        });
                    });

                    $('#btnAddTelefonoEdit').off('click').on('click', function() {

                        //como maximo se pueden agregar 3 telefonos
                        if ($('#telefonosContainerEdit').children().length >= 3) {
                            alert('No se pueden agregar más de 3 telefonos');
                            $(this).prop('disabled', true);
                            return;
                        }

                        // agrega un boton para eliminar el input
                        let btnDelete = $('<button type="button" class="btn btn-outline-danger btnDeleteTelefono mt-2 mb-2">Eliminar</button>');

                        // agrega un input para agregar otro telefono
                        let input = $('<input type="number" name="telefono[]" class="form-control" required>');

                        // agrega el input y el boton al contenedor
                        $('#telefonosContainerEdit').append(input).append(btnDelete);

                        // elimina el input y el boton
                        btnDelete.click(function() {
                            input.remove();
                            btnDelete.remove();
                            $('#btnAddTelefonoEdit').prop('disabled', false);
                        });

                    });

                    $('#modal-cliente-edit').on('shown.bs.modal', function() {
                        // Destruir la instancia de Select2, si existe
                        if ($('#user_idEdit').data('select2')) {
                            $('#user_idEdit').select2('destroy');
                        }

                        // Inicializa Select2
                        $('#user_idEdit').select2({
                            width: '100%', // Se asegura de que el select ocupe el 100% del contenedor
                            height: '150px', // Se asegura de que el select ocupe el 100% del contenedor
                            dropdownParent: $('#modal-cliente-edit') // Asocia el dropdown con el modal para evitar problemas de superposición
                        });

                        $('#modal-cliente-edit .direccion-btnSearch').off('click').on('click', function(){
                            const street = $('#modal-cliente-edit .direccion').val();

                            if( street.length > 0 ){
                                $.ajax({
                                    url: 'https://nominatim.openstreetmap.org/search',
                                    data: {
                                        q: `${street}, Córdoba, España`,
                                        format: 'json',
                                        adressdetails: 1,
                                        limit: 10
                                    },
                                    beforeSend: function(){
                                        // mostrar un spinner de carga en el input

                                        const suggestionsClose = $('#modal-cliente-edit #suggestions');

                                        suggestionsClose.empty();

                                        const suggestionItem = $('<div class="suggestion">Cargando...</div>');

                                        suggestionsClose.append(suggestionItem);

                                    },
                                    success: function(data){
                                        
                                        const suggestionsClose = $('#modal-cliente-edit #suggestions');

                                        suggestionsClose.empty();

                                        if ( data.length > 0 ) {
                                            data.forEach( suggestion => {
                                                suggestionsClose.append(
                                                    `
                                                        <div data-name="${suggestion.display_name}" class="suggestion-item">${suggestion.display_name}</div>
                                                    `
                                                )
                                            });

                                            $('#modal-cliente-edit .suggestion-item').off('click').on('click', function(){
                                                const selectedStreet = $(this).attr('data-name');
                                                $('#modal-cliente-edit input.direccion').val(selectedStreet); 
                                                suggestionsClose.empty();

                                                // agregar el codigo postal al input correspondiente y seleccionar la ciudad 1

                                                const postalCode = selectedStreet.split(',')

                                                postalCode.forEach( (item, index) => {
                                                    // convertir a numero y verificar si es un numero para agregarlo al input
                                                    if( !isNaN(parseInt(item)) ){
                                                        $('#modal-cliente-edit #codPostal').val(parseInt(item));
                                                    }
                                                })

                                                $('#modal-cliente-edit #ciudad_id').val(1);

                                            })
                                            
                                        }else{
                                            suggestionsClose.empty();

                                            const suggestionItem = $('<div class="suggestion">No se encontraron sugerencias</div>');
                                        }
                                        

                                    },
                                    error: function(error){
                                        console.log(error);
                                    }
                                })
                            }

                        })

                    });

                    $('#cifEdit').val(cif);
                    $('#nombreEdit').val(nombre);
                    $('#apellidoEdit').val(apellido);
                    $('#direccionEdit').val(direccion);
                    $('#codPostalEdit').val(codPostal);
                    $('#cidade_idEdit').val(ciudad);
                    $('#emailEdit').val(email);
                    $('#agenteEdit').val(agente);
                    $('#tipoClienteIdEdit').val(tipoCliente);
                    $('#banco_idEdit').val(banco);
                    $('#sctaContableEdit').val(sctaContable);
                    $('#observacionesEdit').val(observaciones);
                    $('#user_idEdit').val(user);

                    $('#form-cliente-edit').attr('action', '/admin/clientes/update/' + idClientes);

                    $('#modal-cliente-edit').modal('show');

                    // evento para ver si el cif ya existe
                    $('#cifEdit').on('change', function() {
                        const cif = $(this).val();
                        $.ajax({
                            url: '/admin/clientes/validate-cif',
                            data: {
                                cif: cif
                            },
                            success: function(response) {
                                if (response.existente === true) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: 'El CIF ya existe',
                                    });
                                    // limpiar el input
                                    $('#cifEdit').val('');
                                }
                            }
                        });
                    });

                    // Evento para crear banco rápido
                    $('.createBancoFast').off('dblclick').on('dblclick', function () {
                        
                        // abrir el modal de modal-fast-create
                        $('#modal-fast-create').modal('show');

                        // cambiar el titulo del modal
                        $('#modalTitleFastCreate').text('Crear Banco');

                        // agregar el formulario para crear el banco
                        $('#modal-fast-create .modal-body').html(`
                            <form id="form-create-banco" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-group required-field">
                                    <label class="form-label" for="nameBanco">Nombre del Banco</label>
                                    <input type="text" name="nameBanco" class="form-control" required>
                                </div>
                            </form>
                        `);

                        // escuchar el evento de guardar el banco
                        $('#btn-save-fast-create').off('click').on('click', function() {
                            
                            // enviar ajax para crear el banco y agregarlo al select
                            const nameBanco = $('#modal-fast-create input[name="nameBanco"]').val();

                            $.ajax({
                                url: '/admin/bancos/storeApi',
                                method: 'POST',
                                data: {
                                    nameBanco: nameBanco,
                                    _token: '<?php echo e(csrf_token()); ?>'
                                },
                                success: function(response) {
                                    // agregar el banco al select
                                    $('#banco_idEdit').append(`
                                        <option value="${response.id}" selected>${response.name}</option>
                                    `);

                                    // cerrar el modal
                                    $('#modal-fast-create').modal('hide');
                                }
                            });

                        });

                    });

                    // Evento para crear usuario rápido
                    $('.createUserFast').off('dblclick').on('dblclick', function () {
                        
                        // abrir el modal de modal-fast-create
                        $('#modal-fast-create').modal('show');

                        // cambiar el titulo del modal
                        $('#modalTitleFastCreate').text('Crear Usuario');

                        // agregar el formulario para crear el usuario
                        $('#modal-fast-create .modal-body').html(`
                            <form id="form-create-user" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label class="form-label" for="name">Nombre</label>
                                    <input type="text" name="name" class="form-control" required placeholder="nombre">    
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" class="form-control" required placeholder="Email">    
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password">Contraseña</label>
                                    <input type="password" name="password" class="form-control" required placeholder="Contraseña">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="confirmpass">Confirmar Contraseña</label>
                                    <input type="password" name="confirmpass" placeholder="Confirma la contraseña" class="form-control" required>
                                </div>
                            </form>
                        `);

                        // agregar evento al confirmar contraseña para validar que coincida con la contraseña
                        $('#modal-fast-create input[name="confirmpass"]').off('input').on('input', function() {
                            const password = $('#modal-fast-create input[name="password"]').val();
                            const confirmpass = $(this).val();

                            if (password !== confirmpass) {
                                $(this).css('border', '1px solid red');
                            } else {
                                $(this).css('border', '1px solid #ced4da');
                            }
                        });

                        // agregar evento para validar que el email tenga el formato correcto
                        $('#modal-fast-create input[name="email"]').off('input').on('input', function() {
                            const email = $(this).val();
                            const emailFormat = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

                            if (!email.match(emailFormat)) {
                                $(this).css('border', '1px solid red');
                            } else {
                                $(this).css('border', '1px solid #ced4da');
                            }
                        });

                        // agregar evento para validar que el email no exista
                        $('#modal-fast-create input[name="email"]').off('change').on('change', function() {
                            const email = $(this).val();
                            $.ajax({
                                url: '/admin/users/validate-email',
                                data: {
                                    email: email
                                },
                                success: function(response) {
                                    if (response.existente === true) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Oops...',
                                            text: 'El email ya existe',
                                        });
                                        // limpiar el input
                                        $('#modal-fast-create input[name="email"]').val('');
                                    }
                                }
                            });
                        });

                        // escuchar el evento de guardar el usuario
                        $('#btn-save-fast-create').off('click').on('click', function() {
                            
                            // enviar ajax para crear el usuario y agregarlo al select
                            const name = $('#modal-fast-create input[name="name"]').val();
                            const email = $('#modal-fast-create input[name="email"]').val();
                            const password = $('#modal-fast-create input[name="password"]').val();
                            const confirmpass = $('#modal-fast-create input[name="confirmpass"]').val();

                            if (password !== confirmpass) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Las contraseñas no coinciden',
                                });
                                return;
                            }

                            $.ajax({
                                url: '/admin/users/storeApi',
                                method: 'POST',
                                data: {
                                    name: name,
                                    email: email,
                                    password: password,
                                    _token: '<?php echo e(csrf_token()); ?>'
                                },
                                success: function(response) {
                                    // agregar el usuario al select
                                    $('#user_idEdit').append(`
                                        <option value="${response.id}" selected>${response.name} | ${response.email}</option>
                                    `);

                                    // cerrar el modal
                                    $('#modal-fast-create').modal('hide');
                                }
                            });

                        });

                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function openDetailsParteTrabajoModal(idParteTrabajo) {
            openLoader();
            const parteId = idParteTrabajo;
            $('#editParteTrabajoModal #signature-pad').hide();
            $('#editParteTrabajoModal #collapseMaterialesEmpleados').find('.total-suma').remove();

            let canvas = document.getElementById('signature-pad');
            let signaturePad = new SignaturePad(canvas);
            
            let fileCounter = 0; // Contador para los archivos, asegurando nombres únicos para los comentarios
            let fileCounterParte = 0;
            let materialCounter = 0;
            let parteTrabajoId = null;
            let selectedFiles = [];

            const previewFilesParte = (files, container, inputIndex) => {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
                    const currentIndex = fileCounterParte++;
                    const uniqueId = `file_${inputIndex}_${currentIndex}`;

                    reader.onload = function(e) {
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

                        fileWrapper.append(img);
                        fileWrapper.append(fileName);
                        fileWrapper.append(commentBox);
                        fileWrapper.append(removeBtn);

                        container.append(fileWrapper);
                    }

                    reader.onerror = function(error) {
                        console.error('Error al leer el archivo:', error);
                    };

                    reader.readAsDataURL(file);
                }
            }

            const calculateTotalSum = (parteTrabajoId = null) => {
                let totalSum = 0;
                const precioHora = parseFloat($('#createParteTrabajoModal #precio_hora').val());
                const desplazamiento = parseFloat($('#createParteTrabajoModal #desplazamiento').val());
                $('#createParteTrabajoModal #elementsToShow tr').each(function() {
                    const total = parseFloat($(this).find('.material-total').text());
                    if (!isNaN(total)) {
                        totalSum += total;
                    }
                });

                if (!isNaN(precioHora)) {
                    totalSum += precioHora;
                }

                if (!isNaN(desplazamiento)) {
                    totalSum += desplazamiento;
                }

                $('#createParteTrabajoModal #suma').val(totalSum.toFixed(2));

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
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: 'Suma actualizada correctamente',
                                    howConfirmButton: false,
                                    timer: 1500
                                });
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
                        // $('#precio_hora').val(total.toFixed(2));
                        $('#precio_hora').val(0);
                    }else{
                        const totalDescuento = total - (total * (descuentoCliente / 100));
                        // $('#precio_hora').val(totalDescuento.toFixed(2));
                        $('#precio_hora').val(0);
                        $('#precioHoraHelp').fadeIn().text(`Precio con descuento del ${descuentoCliente}%`);
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

            function resizeCanvas() {
                const canvas = $('#editParteTrabajoModal #signature-pad');
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                
                // Ajustar el tamaño del canvas al contenedor padre
                const canvasParentWidth = canvas.parent().width();
                
                // Guardar el contenido existente antes de redimensionar
                const data = signaturePad ? signaturePad.toData() : null;

                // Establecer el tamaño del canvas con el ratio correcto
                canvas.width = canvasParentWidth * ratio;
                canvas.height = 200 * ratio;  // Altura fija
                
                // Restaurar el contenido después de redimensionar
                if (data) {
                    signaturePad.fromData(data);
                }
            }

            function recalculateTotalAndShowInPopOverTop(button) {
                let totalSum = 0;

                const precioHora = parseFloat($('#editParteTrabajoModal #precio_hora').val());
                const desplazamiento = parseFloat($('#editParteTrabajoModal #desplazamiento').val());

                $('#editParteTrabajoModal #elementsToShow tr').each(function () {
                    let text = $(this).find('.material-total').text();
                    text = text.replace('€', '').replace(',', '.').trim();

                    const total = parseFloat(text);
                    if (!isNaN(total)) {
                        totalSum += total;
                    }
                });

                if (!isNaN(precioHora)) {
                    totalSum += precioHora;
                }

                if (!isNaN(desplazamiento)) {
                    totalSum += desplazamiento;
                }

                // obtener el id del parte de trabajo
                const parteId = $(button).attr('data-parteid');
                const url = `<?php echo e(route('admin.parte.getInforIva', ':parteId')); ?>`.replace(':parteId', parteId);

                // buscar en el servidor el parte de trabajo 
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        suma: totalSum,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    beforeSend: function() {
                        openLoader();
                    },
                    success: function(response) {
                        closeLoader();
                        if (response.success) {
                            // Mostrar el popover con el nuevo contenido

                            $('#editParteTrabajoModal #suma').val(response.totalSuma.toFixed(2));

                            // dentro del div con id collapseMaterialesEmpleados despues de la tabla con id tableToShowElements crear un div con los totalizadores
                            // y mostrar el total de la suma

                            const totalSuma = response.totalSuma;
                            const iva       = response.iva;
                            const total     = response.precioVenta;
                            const diferencia= response.diferencia;

                            const totalSumaDiv = `
                                <div 
                                    class="total-suma d-flex justify-content-end align-items-center gap-2"
                                >
                                    <h4>Importe: ${formatPrice(totalSuma)}</h4>
                                    <h4>IVA: ${iva}%</h4>
                                    <h4>Total: ${formatPrice(total)}</h4>
                                    <h4>M.Obra: ${diferencia.manoObra.toFixed(2)}% / Mat: ${diferencia.materiales.toFixed(2)}%</h4>
                                </div>
                            `;

                            $('#editParteTrabajoModal #collapseMaterialesEmpleados').find('.total-suma').remove();

                            $('#editParteTrabajoModal #collapseMaterialesEmpleados').find('#tableToShowElements').after(totalSumaDiv);

                        } else {
                            console.error('Error al actualizar la suma');
                        }
                    },
                    error: function(err) {
                        closeLoader();
                        console.error(err);
                    }
                });

            }

            const tableBody = document.querySelector('#editParteTrabajoModal #elementsToShow');
            const sortable = new Sortable(tableBody, {
                animation: 150,
                handle: '.drag-handle', // Limita el arrastre al ícono específico
                touchStartThreshold: 10, // Evita iniciar arrastres accidentales en dispositivos móviles
                onStart: function () {
                    // Desactivar interacciones durante el arrastre
                    document.body.style.pointerEvents = 'none';
                },
                onEnd: function (event) {
                    // Restaurar interacciones
                    document.body.style.pointerEvents = 'auto';

                    // Obtener el nuevo orden
                    const rows = tableBody.querySelectorAll('tr');
                    const newOrder = Array.from(rows).map((row, index) => ({
                        idMaterial: row.id.split('_')[1],
                        order: index + 1,
                    }));

                    // Enviar el nuevo orden al servidor con AJAX
                    $.ajax({
                        url: "<?php echo e(route('admin.parte.reorderLineas')); ?>",
                        method: 'POST',
                        data: {
                            newOrder: newOrder,
                            parte: parteId,
                            _token: '<?php echo e(csrf_token()); ?>'
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: 'Líneas reordenadas correctamente',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                console.error('Error al reordenar las líneas');
                            }
                        },
                        error: function (err) {
                            console.error(err);
                        }
                    });
                }
            });
            
            $(window).on('resize', resizeCanvas);
            
            $.ajax({
                url: `/admin/partes/${parteId}/edit`,
                method: 'GET',
                success: function(response) {
                    if (response.success) {

                        const parte = response.parte_trabajo;
                        const proyectoCounter = parte.proyecto;
                        parteTrabajoId = parte.idParteTrabajo;
                        closeLoader();

                        const buttonToDownloadPdf = document.createElement('a');
                        buttonToDownloadPdf.href = `/parte-trabajo/${parte.idParteTrabajo}/pdf`;
                        buttonToDownloadPdf.classList.add('btn', 'btn-danger');
                        buttonToDownloadPdf.setAttribute('data-bs-toggle', 'tooltip');
                        buttonToDownloadPdf.setAttribute('data-bs-placement', 'top');
                        buttonToDownloadPdf.setAttribute('title', 'Descargar PDF');
                        buttonToDownloadPdf.innerHTML = 'PDF <ion-icon name="download-outline"></ion-icon>';

                        const buttonToDownloadExcel = document.createElement('a');
                        buttonToDownloadExcel.href = `/parte-trabajo/${parte.idParteTrabajo}/excel`;
                        buttonToDownloadExcel.classList.add('btn', 'btn-success');
                        buttonToDownloadExcel.setAttribute('data-bs-toggle', 'tooltip');
                        buttonToDownloadExcel.setAttribute('data-bs-placement', 'top');
                        buttonToDownloadExcel.setAttribute('title', 'Descargar Excel');
                        buttonToDownloadExcel.innerHTML = 'Excel <ion-icon name="download-outline"></ion-icon>';

                        const buttonToDownloadZip = document.createElement('a');
                        buttonToDownloadZip.href = `/parte-trabajo/${parte.idParteTrabajo}/bundle`;
                        buttonToDownloadZip.classList.add('btn', 'btn-warning');
                        buttonToDownloadZip.setAttribute('data-bs-toggle', 'tooltip');
                        buttonToDownloadZip.setAttribute('data-bs-placement', 'top');
                        buttonToDownloadZip.setAttribute('title', 'Descargar ZIP');
                        buttonToDownloadZip.innerHTML = 'ZIP <ion-icon name="download-outline"></ion-icon>';

                        const buttonToRecalculateAndShowInPopOverTop = document.createElement('button');
                        buttonToRecalculateAndShowInPopOverTop.classList.add('btn', 'btn-info');
                        buttonToRecalculateAndShowInPopOverTop.innerHTML = 'Recalcular <ion-icon name="refresh-outline"></ion-icon>';
                        buttonToRecalculateAndShowInPopOverTop.setAttribute('data-parteid', parte.idParteTrabajo);
                        

                        let buttonToSellParte = null;
                        let buttonToShowVenta = null;
                        // Boton para vender el parte de trabajo si el estado es = 3 el estado de venta a 1 y no pertenece a un proyecto
                        if( parte.Estado == 3 && proyectoCounter == null && parte.estadoVenta == 1 ){
                            buttonToSellParte = document.createElement('a');
                            buttonToSellParte.classList.add('btn', 'btn-success');
                            buttonToSellParte.innerHTML = 'Vender Parte <ion-icon name="cash-outline"></ion-icon>';
                            buttonToSellParte.setAttribute('href', `/parte-trabajo/${parte.idParteTrabajo}/sell`);
                            buttonToSellParte.setAttribute('data-bs-toggle', 'tooltip');
                            buttonToSellParte.setAttribute('data-bs-placement', 'top');
                            buttonToSellParte.setAttribute('title', 'Vender Parte');
                            buttonToSellParte.setAttribute('target', '_blank');

                            buttonToSellParte.addEventListener('click', function(event) {
                                event.preventDefault();
                                const button = this;
                                Swal.fire({
                                    title: '¿Estás seguro de querer vender este parte de trabajo?',
                                    text: 'Una vez vendido, no podrás modificarlo',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, vender',
                                    cancelButtonText: 'Cancelar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        openLoader();
                                        // ejecutar la accion del <a> en una nueva pestaña
                                        window.open(button.href, '_blank');
                                        closeLoader();
                                        window.location.reload();
                                    }
                                })
                            });
                        }

                        // verificar si tiene el permiso admin.ventas.index

                        const havePermission = "<?php echo e(Auth::user()->can('admin.ventas.index')); ?>";

                        if ( parte.Estado == 3 && parte.estadoVenta != 1 && havePermission == 1 ) {
                            buttonToShowVenta = document.createElement('a');
                            buttonToShowVenta.classList.add('btn', 'btn-info');
                            buttonToShowVenta.innerHTML = 'Ver Venta <ion-icon name="cash-outline"></ion-icon>';
                            buttonToShowVenta.setAttribute('href', `/parte-trabajo/${parte.idParteTrabajo}/venta`);
                            buttonToShowVenta.setAttribute('data-bs-toggle', 'tooltip');
                            buttonToShowVenta.setAttribute('data-bs-placement', 'top');
                            buttonToShowVenta.setAttribute('title', 'Ver Venta');
                            buttonToShowVenta.setAttribute('target', '_blank');

                            buttonToShowVenta.addEventListener('click', function(event) {
                                event.preventDefault();
                                const button = this;
                                Swal.fire({
                                    title: '¿Estás seguro de querer ver la venta de este parte de trabajo?',
                                    text: 'Una vez vendido, no podrás modificarlo',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, ver venta',
                                    cancelButtonText: 'Cancelar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        // cerrar el modal
                                        getHistorialCliente(parte.idParteTrabajo, 'PartesTrabajo', false, false, parte.idParteTrabajo);
                                    }
                                })
                            });

                        }

                        const buttonsContainer = $('#editParteTrabajoModal #editParteTrabajoFooter')

                        buttonsContainer.empty();

                        // hacer responsive el buttonsContainer
                        buttonsContainer.css({
                            'display': 'flex',
                            'flex-wrap': 'wrap',
                            'justify-content': 'center',
                            'align-items': 'center',
                            'gap': '5px'
                        });

                        if( buttonToSellParte ){
                            buttonsContainer.append(buttonToSellParte);
                        }

                        if( buttonToShowVenta ){
                            buttonsContainer.append(buttonToShowVenta);
                        }

                        buttonsContainer.append(buttonToRecalculateAndShowInPopOverTop);
                        buttonsContainer.append(buttonToDownloadPdf);
                        buttonsContainer.append(buttonToDownloadExcel);
                        buttonsContainer.append(buttonToDownloadZip);

                        // Agregar eventos a los botones
                        buttonToRecalculateAndShowInPopOverTop.addEventListener('click', function() {
                            recalculateTotalAndShowInPopOverTop(this);
                        });

                        let calculateTotalSum = (parteTrabajoId = null) => {
                            let totalSum = 0;
                            const precioHora = parseFloat($('#editParteTrabajoModal #precio_hora').val());
                            const desplazamiento = parseFloat($('#editParteTrabajoModal #desplazamiento').val());
                            $('#editParteTrabajoModal #elementsToShow tr').each(function() {
                                let text = $(this).find('.material-total').text();
                                
                                // eliminar 6,30 € y convertirlo a número
                                text = text.replace('€', '');
                                text = text.replace(',', '.');

                                text = text.trim();

                                const total = parseFloat(text);
                                if (!isNaN(total)) {
                                    totalSum += total;
                                }
                            });

                            if (!isNaN(precioHora)) {
                                totalSum += precioHora;
                            }

                            if (!isNaN(desplazamiento)) {
                                totalSum += desplazamiento;
                            }

                            $('#editParteTrabajoModal #suma').val(totalSum.toFixed(2));

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

                        let materialCounterEdit = 0;

                        $('#editParteTrabajoModal').modal('show');
                        // cambiar el nombre del modal
                        $('#editParteTrabajoModal #editParteTrabajoTitle').text(`Editar Parte de Trabajo No. ${parte.idParteTrabajo}`);
                        $('#editParteTrabajoModal #formCreateOrden')[0].reset();
                        $('#editParteTrabajoModal #btnCreateOrdenButton').hide();

                        $('#editParteTrabajoModal #formCreateOrden').attr('action', ``);

                        if ( parte.cita ) {
                            $('#editParteTrabajoModal #citasPendigSelect').parent().show();
                            $('#editParteTrabajoModal #citasPendigSelect').val(parte.cita.idProyecto);


                            $('#editParteTrabajoModal #citasPendigSelect').off('change').on('change', function() {
                                $('#editParteTrabajoModal #citasPendigSelect').val(parte.cita.idProyecto);
                            });

                        }else{
                            $('#editParteTrabajoModal #citasPendigSelect').parent().hide();
                        }

                        // hora de inicio y hora de fin con moment.js
                        let horaInicio = moment(parte.hora_inicio, 'HH:mm:ss').format('HH:mm');
                        let horaFin = moment(parte.hora_fin, 'HH:mm:ss').format('HH:mm');

                        let valorHoraAcumulado = 0;

                        parte.operarios.forEach(operario => {
                            valorHoraAcumulado += operario.operarios.salario.salario_hora;
                        });

                        if( horaInicio || horaFin ){
                            $('#editParteTrabajoModal #hora_inicio').val(horaInicio);
                            $('#editParteTrabajoModal #hora_fin').val(horaFin);
                        }

                        if ( horaInicio && horaFin ) {
                            calculateDifHours(
                                '#editParteTrabajoModal #hora_inicio', 
                                '#editParteTrabajoModal #hora_fin', 
                                '#editParteTrabajoModal #horas_trabajadas',
                                valorHoraAcumulado,
                                parte.cliente.tipo_cliente.descuento
                            );
                        }

                        $('#editParteTrabajoModal #hora_inicio').off('change').on('change', function() {
                            calculateDifHours(
                                this, 
                                '#editParteTrabajoModal #hora_fin', 
                                '#editParteTrabajoModal #horas_trabajadas',
                                valorHoraAcumulado,
                                parte.cliente.tipo_cliente.descuento
                            );
                            
                        });

                        $('#editParteTrabajoModal #hora_fin').off('change').on('change', function() {
                            calculateDifHours(
                                '#editParteTrabajoModal #hora_inicio', 
                                this, 
                                '#editParteTrabajoModal #horas_trabajadas',
                                valorHoraAcumulado,
                                parte.cliente.tipo_cliente.descuento
                            );
                            calculateTotalSum(parteTrabajoId);
                        });

                        $('#editParteTrabajoModal #precio_hora').off('change').on('change', function() {
                            calculateTotalSum(parteTrabajoId);
                        });

                        // inputs tipo time
                        $('#editParteTrabajoModal #hora_inicio').val(horaInicio);
                        $('#editParteTrabajoModal #hora_fin').val(horaFin);

                        // input tipo number
                        $('#editParteTrabajoModal #horas_trabajadas').val(parte.horas_trabajadas);
                        $('#editParteTrabajoModal #precio_hora').val(parte.precio_hora);
                        $('#editParteTrabajoModal #desplazamiento').val(parte.desplazamiento);

                        $('#editParteTrabajoModal #asunto').val(parte.Asunto);
                        $('#editParteTrabajoModal #fecha_alta').val(parte.FechaAlta);
                        $('#editParteTrabajoModal #fecha_visita').val(parte.FechaVisita);
                        $('#editParteTrabajoModal #estado').val(parte.Estado);
                        $('#editParteTrabajoModal #cliente_id').val(parte.cliente_id);
                        $('#editParteTrabajoModal #departamento').val(parte.Departamento);
                        $('#editParteTrabajoModal #observaciones').val(parte.Observaciones);
                        $('#editParteTrabajoModal #trabajo_id').val(parte.trabajo.idTrabajo);
                        $('#editParteTrabajoModal #suma').val(Number(parte.suma).toFixed(2));
                        $('#editParteTrabajoModal #descuento').val(parte.descuentoParte);
                        $('#editParteTrabajoModal #solucion').val(parte.solucion);

                        if (parseFloat(parte.descuentoParte) !== 0) {
                            $('#editParteTrabajoModal #sumaHelp').fadeIn();
                            
                            const sumaParte = parseFloat(parte.suma); // Precio con descuento
                            const descuentoParte = parseFloat(parte.descuentoParte); // Porcentaje de descuento

                            // Calcular el precio original sin descuento
                            const precioSinDescuento = sumaParte / (1 - descuentoParte / 100);
                            
                            // Formatear y mostrar el resultado
                            $('#editParteTrabajoModal #sumaHelp').text(`Precio sin descuento: ${formatPrice(precioSinDescuento.toFixed(2))}`);
                        }

                        // evento cuando cambie el valor del descuento, aplicar descuento
                        $('#editParteTrabajoModal #descuento').off('change').on('change', function() {

                            let descuento   = parseFloat($(this).val());
                            let suma        = parseFloat(Number(parte.suma));

                            if (isNaN(suma)) {
                                suma = 0;
                            }

                            // el descuento no puede ser mayor al 100%
                            if (descuento > 100) {
                                $(this).val(100);
                                descuento = 100;
                            }

                            if (descuento == 0 || descuento == '' || descuento == null || descuento == undefined || isNaN(descuento)) {
                                $('#editParteTrabajoModal #sumaHelp').fadeOut();
                                $(this).val(0);
                                $('#editParteTrabajoModal #suma').val(suma.toFixed(2));
                                calculateTotalSum();
                                return;
                            }

                            if (suma != 0) {

                                const resultadoDescuento = suma * descuento / 100;
                                let total = suma - resultadoDescuento;

                                if (isNaN(total)) {
                                    total = 0;
                                }
                                
                                $('#editParteTrabajoModal #suma').val(total.toFixed(2));

                                // verificar si el help text esta visible
                                if( !$('#editParteTrabajoModal #sumaHelp').is(':visible') ){
                                    $('#editParteTrabajoModal #sumaHelp').fadeIn();
                                    $('#editParteTrabajoModal #sumaHelp').text(`Precio sin descuento: ${formatPrice(parte.suma)}`);
                                }else{
                                    $('#editParteTrabajoModal #sumaHelp').text(`Precio sin descuento: ${formatPrice(parte.suma)}`);
                                }
                            }else{
                                $('#editParteTrabajoModal #sumaHelp').text(``);
                                $('#editParteTrabajoModal #suma').val(suma.toFixed(2));
                                $('#editParteTrabajoModal #descuento').val(0);
                                calculateTotalSum();
                            }

                            

                        });

                        // cargar los operarios asignados
                        $('#editParteTrabajoModal #operario_id').select2({
                            placeholder: 'Seleccionar...',
                            allowClear: true,
                            multiple: true,
                            width: '100%',
                            dropdownParent: $('#editParteTrabajoModal')  // Asocia el dropdown con el modal para evitar problemas de superposición
                        });

                        $('#editParteTrabajoModal select.form-select').select2({
                            placeholder: 'Seleccionar...',
                            width: '100%',
                            dropdownParent: $('#editParteTrabajoModal')  // Asocia el dropdown con el modal para evitar problemas de superposición
                        });
                        
                        $('#editParteTrabajoModal #operario_id').val(parte.operarios.map(operario => operario.operario_id)).trigger('change');

                        // ajustar el alto del select multiple de operario_id

                        $('#editParteTrabajoModal #operario_id').next().find('.select2-selection--multiple').css('height', 'auto');

                        $('#editParteTrabajoModal #elementsToShow').empty();
                        parte.partes_trabajo_lineas.forEach(linea => {
                            // Calcular precios y beneficios
                            let precioFinal = linea.descuento
                                ? linea.precioSinIva * (1 - linea.descuento / 100)
                                : linea.precioSinIva;

                            let beneficio = (precioFinal - linea.articulo.ptsCosto) * linea.cantidad;

                            let totalPrecioVenta = precioFinal * linea.cantidad;
                            let beneficioPorcentaje = totalPrecioVenta > 0
                                ? (beneficio / totalPrecioVenta) * 100
                                : 0;

                            $('#editParteTrabajoModal #elementsToShow').append(`
                                <tr id="material_${linea.idMaterial}">
                                    <td
                                        class="showImagesArticulo drag-handle"
                                        data-id="${linea.articulo.idArticulo}"
                                        data-nameart="${linea.articulo.nombreArticulo}"
                                        data-trazabilidad="${linea.articulo.TrazabilidadArticulos}"
                                    >${linea.idMaterial}</td>
                                    <td
                                        class="showHistorialArticulo"
                                        data-id="${linea.articulo.idArticulo}"
                                        data-nameart="${linea.articulo.nombreArticulo}"
                                        data-trazabilidad="${linea.articulo.TrazabilidadArticulos}"
                                    >${linea.articulo.nombreArticulo}</td>
                                    <td>${linea.cantidad}</td>
                                    <td>${formatPrice(linea.precioSinIva)}</td>
                                    <td>${linea.descuento}</td>
                                    <td class="material-total">${formatPrice(linea.total)}</td>
                                    <td>${beneficio.toFixed(2)}€ | ${beneficioPorcentaje.toFixed(2)}%</td>
                                    <td>
                                        <?php $__env->startComponent('components.actions-button'); ?>
                                            <button type="button" class="btn btn-outline-danger btnRemoveMaterial"
                                                data-linea='${JSON.stringify(linea)}'
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Eliminar"
                                            >
                                                <ion-icon name="trash-outline"></ion-icon>    
                                            </button>
                                            <button type="button" class="btn btn-outline-primary btnEditMaterial"
                                                data-linea='${JSON.stringify(linea)}'
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Editar"
                                            >
                                                <ion-icon name="create-outline"></ion-icon>
                                            </button>
                                        <?php echo $__env->renderComponent(); ?>
                                    </td>
                                </tr>
                            `);
                        });

                        $('#editParteTrabajoModal #elementsToShow .showImagesArticulo').css('cursor', 'pointer', '!important');
                        $('#editParteTrabajoModal #elementsToShow .showImagesArticulo').css('text-decoration', 'underline', '!important');

                        // evento doble click para mostrar las imagenes del articulo
                        $('#editParteTrabajoModal #elementsToShow .showImagesArticulo').off('dblclick').on('dblclick', function() {
                            const idArticulo = $(this).data('id');
                            const nameArticulo = $(this).data('nameart');

                            getImagesArticulos(idArticulo, nameArticulo);
                        });

                        $('#editParteTrabajoModal #showSignatureFromClient').empty();
                        // mostrar vista previa de las imagenes / videos o audios
                        $('#editParteTrabajoModal #imagesEdit').empty();
                        $('#editParteTrabajoModal #imagesDetails').empty();

                        $('#editParteTrabajoModal #cliente_firmaid').val('').attr('readonly', true);

                        let tieneFirma = false;

                        if (parte.partes_trabajo_archivos.length > 0) {
                            parte.partes_trabajo_archivos.forEach((archivo, index) => {
                                let type = archivo.typeFile;
                                let url = archivo.pathFile;
                                let comentario = archivo.comentarioArchivo || ''; // Si no hay comentario, asignar cadena vacía

                                let urlFinal = '';
                                let finalType = '';

                                if (url != '') {
                                    urlFinal = globalBaseUrl + url;
                                    finalType = '';
                                }


                                switch (type) {
                                    case 'jpg':
                                    case 'jpeg':
                                    case 'png':
                                    case 'gif':
                                        finalType = 'image';
                                        break;
                                    case 'mp4':
                                    case 'avi':
                                    case 'mov':
                                    case 'wmv':
                                    case 'flv':
                                    case '3gp':
                                    case 'webm':
                                        finalType = 'video';
                                        break;
                                    case 'mp3':
                                    case 'wav':
                                    case 'ogg':
                                    case 'm4a':
                                    case 'flac':
                                    case 'wma':
                                        finalType = 'audio';
                                        break;
                                    case 'pdf':
                                        finalType = 'pdf';
                                        break;
                                    case 'doc':
                                    case 'docx':
                                        finalType = 'word';
                                        break;
                                    case 'xls':
                                    case 'xlsx':
                                        finalType = 'excel';
                                        break;
                                    case 'ppt':
                                    case 'pptx':
                                        finalType = 'powerpoint';
                                        break;
                                    default:
                                        finalType = 'image';
                                        break;
                                }

                                // Wrapper for each file and comment
                                const fileWrapper = $(`<div class="file-wrapper"></div>`).css({
                                    'display': 'inline-block',
                                    'text-align': 'center',
                                    'margin': '10px',
                                    'width': '100%',
                                    'max-width': '350px',
                                    'height': 'auto',
                                    'vertical-align': 'top',
                                    'border': '1px solid #ddd',
                                    'padding': '10px',
                                    'border-radius': '5px',
                                    'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.1)',
                                    'overflow': 'hidden',
                                    'position': 'relative',
                                    'box-sizing': 'border-box' // Ensure padding is included within width
                                });

                                // Content wrapper to maintain consistent dimensions for different media types
                                const contentWrapper = $('<div class="contentFiles-wrapper"></div>').css({
                                    'width': '100%',
                                    'height': '250px',  // Set a fixed height for the container
                                    'display': 'flex',
                                    'align-items': 'center',
                                    'justify-content': 'center',
                                    'margin-bottom': '10px',
                                    'overflow': 'hidden'
                                });

                                let fileContent;

                                switch (finalType) {
                                    case 'image':
                                        fileContent = `<img src="${urlFinal}" style="width: 100%; height: 100%; object-fit: contain;">`;
                                        break;
                                    case 'video':
                                        fileContent = `<video controls style="width: 100%; height: 100%; object-fit: contain;"><source src="${urlFinal}" type="video/mp4" /></video>`;
                                        break;
                                    case 'audio':
                                        fileContent = `<audio controls style="width: 100%;"><source src="${urlFinal}" type="audio/mpeg" /></audio>`;
                                        break;
                                    case 'pdf':
                                        fileContent = `<embed src="${urlFinal}" type="application/pdf" style="width: 100%; height: 100%; object-fit: contain;">`;
                                        break;
                                    case 'word':
                                    case 'excel':
                                    case 'powerpoint':
                                        fileContent = `<iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${urlFinal}" style="width: 100%; height: 100%; object-fit: contain;" frameborder="0"></iframe>`;
                                        break;
                                    default:
                                        fileContent = `<img src="${urlFinal}" style="width: 100%; height: 100%; object-fit: contain;">`;
                                        break;
                                }

                                // verficar si el archivo es una firma
                                if (comentario === 'firma_digital_bd') {
                                    tieneFirma = true;
                                    $('#editParteTrabajoModal #cliente_firmaid').val(parte.nombre_firmante).attr('readonly', true);
                                    $('#editParteTrabajoModal #showSignatureFromClient').append(fileContent);

                                    // Deshabilitar la firma del cliente
                                    $('#editParteTrabajoModal #cliente_firmaid').attr('readonly', true);

                                    // Deshabilitar el botón de limpiar firma
                                    $('#editParteTrabajoModal #clear-signature').attr('disabled', true);
                                    
                                    return;
                                }

                                contentWrapper.append(fileContent);
                                fileWrapper.append(contentWrapper);

                                const commentBox = $(`<textarea class="form-control editCommentario" data-archivoid="${archivo.idarchivos}" name="comentario[${index + 1}]" placeholder="Comentario archivo ${index + 1}" rows="2" readonly></textarea>`).val(comentario);

                                const buttonDelete = $(`<button type="button" class="btn btn-danger removeFileServer" data-archivoid="${archivo.idarchivos}"><ion-icon name="trash-outline"></ion-icon></button>`);
                                const buttonDeleteContainer = $(`<div style="position: absolute; top: 0; right: 0;" class="d-flex justify-content-end"></div>`);
                                
                                buttonDeleteContainer.append(buttonDelete);
                                fileWrapper.append(buttonDeleteContainer);
                                fileWrapper.append(commentBox);

                                $('#editParteTrabajoModal #imagesDetails').append(fileWrapper);
                            });
                        }

                        // evento para eliminar archivo
                        $('#editParteTrabajoModal .removeFileServer').off('click').on('click', function() {
                            const archivoId = $(this).data('archivoid');
                            // buscar el contenedor del archivo que tiene el atributo data-archivoid
                            const archivoWrapper = $(`#editParteTrabajoModal .file-wrapper[data-archivoid="${archivoId}"]`);

                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: "¡No podrás revertir esto!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminarlo!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    openLoader();
                                    $.ajax({
                                        url: "<?php echo e(route('admin.parte.deletefile')); ?>",
                                        method: 'POST',
                                        data: {
                                            archivoId: archivoId,
                                            _token: "<?php echo e(csrf_token()); ?>"
                                        },
                                        success: function(response) {
                                            closeLoader();
                                            if (response.success) {
                                                archivoWrapper.remove();
                                                Swal.fire(
                                                    '¡Eliminado!',
                                                    'El archivo ha sido eliminado.',
                                                    'success'
                                                );
                                            } else {
                                                Swal.fire(
                                                    'Error',
                                                    'No se ha podido eliminar el archivo.',
                                                    'error'
                                                );
                                            }
                                        },
                                        error: function(err) {
                                            closeLoader();
                                            console.error(err);
                                            Swal.fire(
                                                'Error',
                                                'No se ha podido eliminar el archivo.',
                                                'error'
                                            );
                                        }
                                    });
                                }
                            });
                        });

                        // evento doble click para habilitar la edición del comentario
                        $('#editParteTrabajoModal .editCommentario').off('dblclick touchstart').on('dblclick touchstart', function(event) {
                            // Detectar si es un toque prolongado
                            if (event.type === 'touchstart') {
                                let element = $(this);
                                let timer = setTimeout(function() {
                                    element.attr('readonly', false);
                                    element.focus();
                                }, 500); // 500 ms para considerar que es un toque prolongado

                                // cambiar el borde del textarea para indicar que está en modo edición
                                element.css('border', '1px solid #007bff');

                                // Cancelar el temporizador si el usuario levanta el dedo antes de los 500 ms
                                element.on('touchend', function() {
                                    clearTimeout(timer);
                                });
                            } else {
                                // Caso de doble clic (para dispositivos de escritorio)
                                $(this).attr('readonly', false);
                                $(this).focus();
                            }
                        });

                        // evento para editar comentario
                        $('#editParteTrabajoModal .editCommentario').off('change').on('change', function() {
                            const archivoId = $(this).data('archivoid');
                            const comentario = $(this).val();
                            openLoader();

                            $.ajax({
                                url: "<?php echo e(route('admin.parte.updatefile')); ?>",
                                method: 'POST',
                                data: {
                                    archivoId: archivoId,
                                    comentario: comentario,
                                    _token: "<?php echo e(csrf_token()); ?>"
                                },
                                success: function(response) {
                                    closeLoader();
                                    if (response.success) {
                                        showToast('Comentario actualizado correctamente', 'success');
                                        // Deshabilitar el textarea
                                        $('#editParteTrabajoModal .editCommentario').attr('readonly', true);
                                    } else {
                                        showToast('Error al actualizar el comentario', 'error');
                                    }
                                },
                                error: function(err) {
                                    openLoader();
                                    showToast('Error al actualizar el comentario', 'error');
                                }
                            });
                        });

                        // Si no tiene firma, habilitar canvas para firmar
                        if (!tieneFirma) {
                            canvas = document.querySelector('#editParteTrabajoModal #signature-pad');
                            signaturePad = new SignaturePad(canvas);

                            $('#editParteTrabajoModal #unlock-signature').show();

                            $('#editParteTrabajoModal #clear-signature').off('click').on('click', function(event) {
                                event.preventDefault();
                                signaturePad.clear();
                            });

                            function resizeCanvas() {
                                const canvas = $('#editParteTrabajoModal #signature-pad');
                                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                                
                                // Ajustar el tamaño del canvas al contenedor padre
                                const canvasParentWidth = canvas.parent().width();
                                
                                // Guardar el contenido existente antes de redimensionar
                                const data = signaturePad ? signaturePad.toData() : null;

                                // Establecer el tamaño del canvas con el ratio correcto
                                canvas.width = canvasParentWidth * ratio;
                                canvas.height = 200 * ratio;  // Altura fija
                                
                                // Restaurar el contenido después de redimensionar
                                if (data) {
                                    signaturePad.fromData(data);
                                }
                            }

                            $(window).on('resize', resizeCanvas);

                            $('#editParteTrabajoModal #cliente_firmaid').val('').attr('readonly', false);

                            resizeCanvas();

                            // Doble clic para desbloquear la firma
                            $('#editParteTrabajoModal #unlock-signature').on('dblclick', function () {
                                $(this).hide();  // Ocultar el mensaje de desbloqueo
                                $('#editParteTrabajoModal #signature-pad').show();  // Mostrar el canvas
                                $('#editParteTrabajoModal #clear-signature').prop('disabled', false);  // Habilitar el botón de limpiar
                            });

                        } else {
                            // Mostrar la firma del cliente y ocultar la opción de firmar
                            $('#editParteTrabajoModal #unlock-signature').hide();
                            const canvas = $('#editParteTrabajoModal #signature-pad');
                            canvas.hide();  // Ocultar el canvas si ya existe una firma
                            $('#editParteTrabajoModal #clear-signature').prop('disabled', true);
                        }

                        $('#editParteTrabajoModal #clear-signature').off('click').on('click', function(event) {
                            event.preventDefault();
                        });

                        let previewFiles = (files, container, inputIndex) => {
                            openLoader();
                            let filesLoaded = 0;

                            const MAX_PREVIEW_SIZE = 5 * 1024 * 1024; // 5MB

                            for (let i = 0; i < files.length; i++) {
                                const file = files[i];
                                const reader = new FileReader();
                                const currentIndex = fileCounter++;
                                const uniqueId = `file_${inputIndex}_${currentIndex}`;

                                // if (file.size > MAX_PREVIEW_SIZE) {
                                //     Swal.fire({
                                //         icon: 'warning',
                                //         title: 'Oops...',
                                //         text: 'El archivo es demasiado grande. no se puede previsualizar pero.'
                                //     });
                                //     continue;
                                // }

                                reader.onload = function(e) {
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

                                    let previewElement;

                                    if (file.type.startsWith("image/")) {
                                        previewElement = $('<img>').attr('src', e.target.result).css({
                                            'max-width': '300px',
                                            'max-height': '300px',
                                            'margin-bottom': '5px',
                                            'object-fit': 'cover',
                                            'border': '1px solid #ddd',
                                            'padding': '5px',
                                            'border-radius': '5px'
                                        });
                                    } else if (file.type.startsWith("video/")) {
                                        const videoUrl = URL.createObjectURL(file);
                                        previewElement = `
                                            <video class="plyr-video" controls autoplay muted poster="https://sebcompanyes.com/vendor/adminlte/dist/img/mileco.jpeg"
                                                style="max-width: 300px; max-height: 300px; margin-bottom: 5px;">
                                                <source src="${videoUrl}" type="${file.type}">
                                            </video>`;
                                    } else if (file.type.startsWith("audio/")) {
                                        previewElement = `
                                            <audio class="plyr-audio" id="plyr-audio-${uniqueId}" controls
                                                style="width: 300px; margin-bottom: 5px;">
                                                <source src="${e.target.result}" type="audio/mp3">
                                            </audio>`;
                                    } else {
                                        previewElement = $('<div>').text("Vista previa no disponible para este tipo de archivo.").css({
                                            'color': '#888',
                                            'margin-bottom': '5px'
                                        });
                                    }

                                    const fileName = $('<span></span>').text(file.name).css('display', 'block');
                                    const commentBox = $(`<textarea class="form-control mb-2" name="comentario[${currentIndex + 1}]" placeholder="Comentario archivo ${currentIndex + 1}" rows="2"></textarea>`);
                                    const removeBtn = $(`<button type="button" class="btn btn-danger btnRemoveFile">Eliminar</button>`).attr('data-unique-id', uniqueId).attr('data-input-id', `input_${inputIndex}`);

                                    fileWrapper.append(previewElement);
                                    fileWrapper.append(fileName);
                                    fileWrapper.append(commentBox);
                                    fileWrapper.append(removeBtn);

                                    container.append(fileWrapper);

                                    filesLoaded++;

                                    if (filesLoaded === files.length) {
                                        closeLoader();
                                    }

                                };

                                reader.readAsDataURL(file);
                            }
                        };

                        $('#editParteTrabajoModal #files1').off('change').on('change', function() {
                            openLoader();
                            const files = $(this)[0].files;
                            const filesContainer = $('#editParteTrabajoModal #previewImage1');

                            // Añadir previsualización
                            previewFiles(files, filesContainer, 0);
                            closeLoader();
                        });

                        $('#editParteTrabajoModal #files1').off('click').on('click', function(e) {
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
                        $('#editParteTrabajoModal #btnAddFiles').off('click').on('click', function() {
                            const newInputContainer = $('<div class="form-group col-md-12"></div>');
                            const inputIndex = $('#inputsToUploadFilesContainer input').length + 1; // Índice del nuevo input
                            const newInputId = `input_${inputIndex}`;

                            // como maximo se pueden añadir 5 inputs
                            if (inputIndex >= 5) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: 'No puedes añadir más de 5 archivos'
                                });
                                return;
                            }
                            
                            const newInput = $(`<input type="file" class="form-control" name="file[]" id="${newInputId}">`);
                            newInputContainer.append(newInput);
                            $('#editParteTrabajoModal #inputsToUploadFilesContainer').append(newInputContainer);

                            // Manejar la previsualización para los nuevos inputs
                            newInput.off('change').on('change', function() {
                                openLoader();
                                const files = $(this)[0].files;
                                const filesContainer = $('#editParteTrabajoModal #previewImage1');

                                // Añadir previsualización
                                previewFiles(files, filesContainer, inputIndex);
                                closeLoader();
                            });

                            newInput.off('click').on('click', function(e) {
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

                        $(document).off('click', '.btnRemoveFile').on('click', '.btnRemoveFile', function() {
                            openLoader();
                            const uniqueId = $(this).data('unique-id');  // ID único del archivo a eliminar
                            const inputId = $(this).data('input-id');    // ID del input asociado

                            if ( uniqueId === 'file_0_0' || inputId === 'input_0' ) {
                                $('#editParteTrabajoModal #files1').val('');                           
                            }

                            // Eliminar el contenedor de previsualización del archivo
                            $(`#preview_${uniqueId}`).remove();

                            // limpiar el input de archivos
                            $(`#${inputId}`).val('');

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
                            closeLoader();
                        });

                        $('#editParteTrabajoModal #addNewMaterial').off('click').on('click', function() {
                            materialCounterEdit++;
                            let newMaterial = `
                                <form id="AddNewMaterialForm${materialCounter}" class="mt-2 mb-2">
                                    <input type="hidden" id="parteTrabajo_id" name="parteTrabajo_id" value="">
                                    <input type="hidden" id="materialCounter" name="materialCounter" value="${materialCounter}">
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="articulo_id${materialCounter}">Artículo</label>
                                                <select class="form-select articulo" id="articulo_id${materialCounter}" name="articulo_id" required>
                                                    <option value="">Seleccione un artículo</option>
                                                    <?php if(isset($articulos)): ?>
                                                        <?php $__currentLoopData = $articulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option data-namearticulo="<?php echo e($articulo->nombreArticulo); ?>" value="<?php echo e($articulo->idArticulo); ?>">
                                                                <?php echo e($articulo->nombreArticulo); ?> | <?php echo e(formatTrazabilidad($articulo->TrazabilidadArticulos)); ?> | stock: <?php echo e($articulo->stock->cantidad); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                                <small class="text-muted addDatasetToShowImages">Ver imagenes</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cantidad${materialCounter}">Cantidad</label>
                                                <input type="number" class="form-control cantidad" id="cantidad${materialCounter}" name="cantidad" value="1" step="0.01" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="precioSinIva${materialCounter}">Precio sin IVA</label>
                                                <input type="number" class="form-control precioSinIva" id="precioSinIva${materialCounter}" name="precioSinIva" step="0.01" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="descuento${materialCounter}">Descuento</label>
                                                <input type="number" class="form-control descuento" id="descuento${materialCounter}" name="descuento" step="0.01" value="0" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="total${materialCounter}">Total</label>
                                                <input type="number" class="form-control total" id="total${materialCounter}" name="total" step="0.01" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end justify-content-center align-items-end align-content-end">
                                            <button type="button" class="btn btn-outline-success saveMaterial" data-material="${materialCounter}">
                                                Guardar Linea
                                                <ion-icon name="save-outline"></ion-icon>
                                            </button>    
                                        </div>
                                    </div>
                                </form>
                            `;

                            $('#editParteTrabajoModal #newMaterialsContainer').append(newMaterial);

                            if ($('#newMaterialsContainer select.form-select').data('select2')) {
                                $('#newMaterialsContainer select.form-select').select2('destroy');
                            }

                            $('#newMaterialsContainer select.form-select').select2({
                                width: '100%',  // Asegura que el select ocupe el 100% del contenedor
                                dropdownParent: $('#editParteTrabajoModal')  // Asocia el dropdown con el modal para evitar problemas de superposición
                            });

                            $('#editParteTrabajoModal .addDatasetToShowImages').hide();

                            // evento doble click para mostrar las imagenes del articulo
                            $('#editParteTrabajoModal .addDatasetToShowImages').off('dblclick').on('dblclick', function() {
                                const idArticulo = $(this).data('id');
                                const nameArticulo = $(this).data('nameart');

                                getImagesArticulos(idArticulo, nameArticulo);
                            });

                            $('#editParteTrabajoModal #newMaterialsContainer ').off('change', `#articulo_id${materialCounter}`).on('change', `#articulo_id${materialCounter}`, function () {
                                openLoader();
                                const articuloId = $(this).val();
                                const form = $(this).closest('form');
                                const precioSinIvaInput = form.find('.precioSinIva');
                                const cantidadInput = form.find('.cantidad');
                                const totalInput = form.find('.total');
                                const descuentoInput = form.find('.descuento');
                                <?php if(isset($articulos)): ?>
                                    let Articulos = <?php echo json_encode($articulos, 15, 512) ?>;
                                <?php endif; ?>

                                const nameArticulo = $(this).find(':selected').data('namearticulo');
                                // añadir al small el id del articulo .addDatasetToShowImages
                                $('.addDatasetToShowImages').attr('data-id', articuloId);
                                $('.addDatasetToShowImages').attr('data-nameart', nameArticulo);
                                
                                $.ajax({
                                    url: "/admin/articulos/getStock/" + articuloId,
                                    method: 'GET',
                                    data: {
                                        articulo_id: articuloId,
                                    },
                                    success: function(response) {
                                        closeLoader();
                                        if (response.success) {
                                            if (response.stock.cantidad <= 0) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Oops...',
                                                    text: 'No hay stock disponible para este artículo',
                                                });
                                                $(`#editParteTrabajoModal #newMaterialsContainer #articulo_id${materialCounter}`).val('');
                                                return;
                                            }

                                            // verificar si el articulo tiene imagenes
                                            const articuloImagenes = response.stock.articulo.imagenes;

                                            if ( articuloImagenes.length > 0 ) {
                                                // mostrar el small
                                                $('.addDatasetToShowImages').removeClass('d-none').show();

                                                $('#editParteTrabajoModal .addDatasetToShowImages').css('cursor', 'pointer', '!important');
                                                $('#editParteTrabajoModal .addDatasetToShowImages').css('text-decoration', 'underline', '!important');

                                                // evento doble click para mostrar las imagenes del articulo
                                                $('#editParteTrabajoModal .addDatasetToShowImages').off('dblclick').on('dblclick', function() {
                                                    const idArticulo = $(this).data('id');
                                                    const nameArticulo = $(this).data('nameart');

                                                    getImagesArticulos(idArticulo, nameArticulo);
                                                });

                                            }else{
                                                $('.addDatasetToShowImages').addClass('d-none').hide();
                                            }

                                            const venta = Number(response.stock.articulo.ptsVenta);
                                            $(`#editParteTrabajoModal #newMaterialsContainer #precioSinIva${materialCounter}`).val(venta.toFixed(2));
                                            $(`#editParteTrabajoModal #newMaterialsContainer #total${materialCounter}`).val(venta.toFixed(2));
                                        } else {
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Oops...',
                                                text: response.message,
                                            });
                                        }
                                    },
                                    error: function(err) {
                                        console.error(err);
                                        closeLoader();
                                    }
                                });

                                const articulo = Articulos.find(art => art.idArticulo === parseInt(articuloId));
                        
                                if (articulo) {
                                    precioSinIvaInput.val(articulo.precio).attr('disabled', false);
                                    cantidadInput.attr('disabled', false);
                                    descuentoInput.attr('disabled', false);
                                    totalInput.val(cantidadInput.val() * articulo.precio);
                                }
                            });

                            $('#editParteTrabajoModal #newMaterialsContainer').off('change', `#cantidad${materialCounter}`).on('change', `#cantidad${materialCounter}`, function () {
                                const cantidad = parseFloat($(this).val());
                                const form = $(this).closest('form');
                                const precio = parseFloat(form.find('.precioSinIva').val());
                                const descuento = parseFloat(form.find('.descuento').val());
                                const totalInput = form.find('.total');

                                if ( cantidad <= 0 ) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: 'La cantidad no puede ser menor o igual a 0',
                                    });
                                    $(this).val(1);
                                }

                                let total = 0;

                                if ( descuento !== 0 ) {
                                    const lineaDescuento = (descuento * (precio * cantidad)) / 100;
                                    total = (precio * cantidad) - lineaDescuento;
                                    totalInput.val(total.toFixed(2));
                                    return;
                                }

                                if ( descuento === 0 ) {
                                    total = precio * cantidad;
                                }

                                totalInput.val(total.toFixed(2));
                            });

                            $('#editParteTrabajoModal #newMaterialsContainer').off('change', `#precioSinIva${materialCounter}`).on('change', `#precioSinIva${materialCounter}`, function () {
                                const precio = parseFloat($(this).val());
                                const form = $(this).closest('form');
                                const cantidad = parseFloat(form.find('.cantidad').val());
                                const descuentoInput = parseFloat(form.find('.descuento').val());
                                const totalInput = form.find('.total');

                                let total = 0;

                                if ( descuentoInput !== 0 ) {
                                    const lineaDescuento = (descuentoInput * (precio * cantidad)) / 100;
                                    total = (precio * cantidad) - lineaDescuento;
                                    totalInput.val(total.toFixed(2));
                                    return;
                                }

                                if ( descuentoInput === 0 ) {
                                    total = precio * cantidad;
                                }

                                totalInput.val(total.toFixed(2));
                                return;
                            });

                            $('#editParteTrabajoModal #newMaterialsContainer').off('change', `#descuento${materialCounter}`).on('change', `#descuento${materialCounter}`, function () {
                                const descuento = parseFloat($(this).val());
                                const form = $(this).closest('form');
                                const cantidad = parseFloat(form.find('.cantidad').val());
                                const precio = parseFloat(form.find('.precioSinIva').val());
                                const totalInput = form.find('.total');

                                let total = 0;

                                if ( descuento !== 0 ) {
                                    const lineaDescuento = (descuento * (precio * cantidad)) / 100;
                                    total = (precio * cantidad) - lineaDescuento;
                                    totalInput.val(total.toFixed(2));
                                    return;
                                }

                                if ( descuento === 0 ) {
                                    total = precio * cantidad;
                                }

                                totalInput.val(total.toFixed(2));
                            });
                        });

                        $('#editParteTrabajoModal #collapseMaterialesEmpleados').off('click', '.saveMaterial').on('click', '.saveMaterial', function () {
                            const materialNumber    = $(this).data('material');
                            const form              = $(`#AddNewMaterialForm${materialNumber}`);
                            const articuloId        = form.find(`#articulo_id${materialNumber}`).val();
                            const cantidad          = parseFloat(form.find(`#cantidad${materialNumber}`).val());
                            const precioSinIva      = parseFloat(form.find(`#precioSinIva${materialNumber}`).val());
                            const descuento         = parseFloat(form.find(`#descuento${materialNumber}`).val());
                            const total             = parseFloat(form.find(`#total${materialNumber}`).val());

                            if (!articuloId || isNaN(cantidad) || isNaN(precioSinIva) || isNaN(descuento) || isNaN(total)) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Todos los campos son requeridos',
                                });
                                return;
                            }

                            const nombreArticulo = $(`#articulo_id${materialNumber} option:selected`).data('namearticulo');

                            
                            form.remove();

                            $.ajax({
                                url: "<?php echo e(route('admin.lineaspartes.store')); ?>",
                                method: 'POST',
                                data: {
                                    parteTrabajo_id: parteTrabajoId,
                                    articulo_id: articuloId,
                                    cantidad: cantidad,
                                    precioSinIva: precioSinIva,
                                    descuento: descuento,
                                    total: total,
                                    _token: "<?php echo e(csrf_token()); ?>"
                                },
                                success: function(response) {
                                    if (response.success) {

                                        const linea = response.linea;
                                        // Calcular el beneficio teniendo en cuenta el descuento
                                        let precioFinal = linea.descuento 
                                            ? linea.precioSinIva * (1 - linea.descuento / 100) 
                                            : linea.precioSinIva;

                                        let beneficio = (precioFinal - linea.articulo.ptsCosto) * linea.cantidad;

                                        // Evitar división por cero
                                        let totalPrecioVenta = precioFinal * linea.cantidad;
                                        let beneficioPorcentaje = totalPrecioVenta > 0 
                                            ? (beneficio / totalPrecioVenta) * 100 
                                            : 0;

                                        const newRow = `
                                        <tr
                                            id="material_${response.linea.idMaterial}"
                                        >
                                            <td
                                                class="showImagesArticulo"
                                                data-id="${linea.articulo.idArticulo}"
                                                data-nameart="${linea.articulo.nombreArticulo}"
                                                data-trazabilidad="${linea.articulo.TrazabilidadArticulos}"
                                            >${response.linea.idMaterial}</td>
                                            <td
                                                class="showHistorialArticulo"
                                                data-id="${linea.articulo.idArticulo}"
                                                data-nameart="${linea.articulo.nombreArticulo}"
                                                data-trazabilidad="${linea.articulo.TrazabilidadArticulos}"
                                            >${nombreArticulo}</td>
                                            <td>${cantidad}</td>
                                            <td>${formatPrice(precioSinIva)}</td>
                                            <td>${descuento}</td>
                                            <td class="material-total">${formatPrice(total)}</td>
                                            <td>${beneficio.toFixed(2)}€ | ${beneficioPorcentaje.toFixed(2)}%</td>
                                            <td>
                                                <?php $__env->startComponent('components.actions-button'); ?>
                                                    <button type="button" class="btn btn-outline-danger btnRemoveMaterial"
                                                        data-linea='${JSON.stringify(response.linea)}'
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Eliminar"
                                                    >
                                                        <ion-icon name="trash-outline"></ion-icon>    
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary btnEditMaterial"
                                                        data-linea='${JSON.stringify(response.linea)}'
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Editar"
                                                    >
                                                        <ion-icon name="create-outline"></ion-icon>
                                                    </button>
                                                <?php echo $__env->renderComponent(); ?>
                                            </td>
                                        </tr>
                                        `;

                                        $('#editParteTrabajoModal #elementsToShow').append(newRow);
                                        calculateTotalSum(parteTrabajoId);
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Línea de material guardada correctamente',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    } else {
                                        console.error('Error al guardar la línea de material');
                                    }
                                },
                                error: function(err) {
                                    console.error(err);
                                }
                            });
                        });

                        $('#editParteTrabajoModal #elementsToShow').off('click', '.btnRemoveMaterial').on('click', '.btnRemoveMaterial', function() {
                            
                            const linea = $(this).data('linea');
                            const rowId = `#elementsToShow #material_${linea.idMaterial}`;
                            const row   = $(rowId);
                            const lineaId = linea.idMaterial;
                            const articuloId = linea.articulo.idArticulo || linea.articulo_id;
                            const cantidad = linea.cantidad;

                            Swal.fire({
                                title: '¿Estás seguro de eliminar la linea del material?',
                                text: "¡El articulo se devolverá al stock correspondiente!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminarlo!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    openLoader();
                                    $.ajax({
                                        url: "<?php echo e(route('admin.lineaspartes.destroy')); ?>",
                                        method: 'POST',
                                        data: {
                                            articulo_id: articuloId,
                                            lineaId: lineaId,
                                            cantidad,
                                            _token: "<?php echo e(csrf_token()); ?>"
                                        },
                                        success: function(response) {
                                            closeLoader();
                                            if (response.success) {
                                                row.remove();
                                                calculateTotalSum(parteTrabajoId);
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Línea de material eliminada correctamente',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                            } else {
                                                closeLoader();
                                                console.error('Error al eliminar la línea de material');
                                            }
                                        },
                                        error: function(err) {
                                            closeLoader();
                                            console.error(err);
                                        }
                                    });
                                }
                            })
                            
                        });

                        $('#editParteTrabajoModal #elementsToShow').off('click', '.btnEditMaterial');

                        $('#editParteTrabajoModal #elementsToShow').on('click', '.btnEditMaterial', function() {
                            const linea = $(this).data('linea');
                            const row   = $(this).closest('tr');
                            const lineaId = linea.idMaterial;
                            const articuloId = linea.articulo.idArticulo || linea.articulo_id;

                            // abrir modal para editar la linea de material
                            $('#editMaterialLineModal').modal('show');

                            $('#editMaterialLineModal #editMaterialLineTitle').text(`Editar Línea de Material No. ${lineaId}`);
                            $('#editMaterialLineModal #formEditMaterialLine')[0].reset();


                            $('#editMaterialLineModal #material_id').val(articuloId);
                            $('#editMaterialLineModal #cantidad').val(linea.cantidad);
                            $('#editMaterialLineModal #precio').val(linea.precioSinIva);
                            $('#editMaterialLineModal #descuento').val(linea.descuento);
                            $('#editMaterialLineModal #total').val(linea.total);
                            $('#editMaterialLineModal #lineaId').val(lineaId);

                            // inicializar select2
                            $('#editMaterialLineModal select.form-select').select2({
                                width: '100%',
                                dropdownParent: $('#editMaterialLineModal')
                            });

                        });

                        // dejar de escuchar el evento del material seleccionado
                        $('#editParteTrabajoModal #material_id').off('change', 'select.form-select');

                        $('#editMaterialLineModal #material_id').on('change', function() {
                            openLoader();
                            const articuloId = $(this).val();
                            const precioSinIvaInput = $('#editMaterialLineModal #precio');
                            const cantidadInput = $('#editMaterialLineModal #cantidad');
                            const totalInput = $('#editMaterialLineModal #total');
                            const descuentoInput = $('#editMaterialLineModal #descuento');
                            <?php if(isset($articulos)): ?>
                                let Articulos = <?php echo json_encode($articulos, 15, 512) ?>;
                            <?php endif; ?>
                            
                            $.ajax({
                                url: "/admin/articulos/getStock/" + articuloId,
                                method: 'GET',
                                data: {
                                    articulo_id: articuloId,
                                },
                                success: function(response) {
                                    closeLoader();
                                    if (response.success) {
                                        if (response.stock.cantidad <= 0) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'No hay stock disponible para este artículo',
                                            });
                                            $('#editMaterialLineModal #material_id').val('');
                                            return;
                                        }
                                        const venta = Number(response.stock.articulo.ptsVenta);
                                        precioSinIvaInput.val(venta.toFixed(2));
                                        totalInput.val(venta.toFixed(2));
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: response.message,
                                        });
                                    }
                                },
                                error: function(err) {
                                    console.error(err);
                                    closeLoader();
                                }
                            });

                            const articulo = Articulos.find(art => art.idArticulo === parseInt(articuloId));
                    
                            if (articulo) {
                                precioSinIvaInput.val(articulo.precio).attr('disabled', false);
                                cantidadInput.attr('disabled', false);
                                descuentoInput.attr('disabled', false);
                                totalInput.val(cantidadInput.val() * articulo.precio);
                            }
                        });

                        $('#editMaterialLineModal #cantidad').off('change').on('change', function() {
                            const cantidad  = parseFloat($(this).val());
                            const precio    = parseFloat($('#editMaterialLineModal #precio').val());
                            const descuento = parseFloat($('#editMaterialLineModal #descuento').val());
                            const select    = $('#editMaterialLineModal #material_id').find(':selected').text();

                            // extraer el stock del select TEST | EMP-03-FACPRUEBA -33 | stock: 2
                            let stock = select.split('|').pop().trim().split(':').pop().trim();
                            stock = parseInt(stock);
    
                            if ( cantidad > stock ) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: 'La cantidad no puede ser mayor al stock disponible',
                                });
                                $(this).val(stock);
                            }

                            if ( cantidad <= 0 ) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: 'La cantidad no puede ser menor o igual a 0',
                                });
                                $(this).val(1);
                            }

                            let total = 0;

                            if ( descuento !== 0 ) {
                                const lineaDescuento = (descuento * (precio * cantidad)) / 100;
                                total = (precio * cantidad) - lineaDescuento;
                                $('#editMaterialLineModal #descuento').val(descuento);
                            }

                            if ( descuento === 0 ) {
                                total = precio * cantidad;
                            }

                            $('#editMaterialLineModal #total').val(total.toFixed(2));
                        });

                        $('#editMaterialLineModal #precio').off('change').on('change', function() {
                            const precio    = parseFloat($(this).val());
                            const cantidad  = parseFloat($('#editMaterialLineModal #cantidad').val());
                            const descuento = parseFloat($('#editMaterialLineModal #descuento').val());

                            let total = 0;

                            if ( descuento !== 0 ) {
                                const lineaDescuento = (descuento * (precio * cantidad)) / 100;
                                total = (precio * cantidad) - lineaDescuento;
                                $('#editMaterialLineModal #descuento').val(descuento);
                            }

                            if ( descuento === 0 ) {
                                total = precio * cantidad;
                            }

                            $('#editMaterialLineModal #total').val(total.toFixed(2));
                        });

                        $('#editMaterialLineModal #descuento').off('change').on('change', function() {
                            const descuento = parseFloat($(this).val())
                            const cantidad  = parseFloat($('#editMaterialLineModal #cantidad').val())
                            const precio    = parseFloat($('#editMaterialLineModal #precio').val())

                            let total = 0;

                            if ( descuento !== 0 ) {
                                const lineaDescuento = (descuento * (precio * cantidad)) / 100;
                                total = (precio * cantidad) - lineaDescuento;
                                $('#editMaterialLineModal #descuento').val(descuento);
                            }

                            if ( descuento === 0 ) {
                                total = precio * cantidad;
                            }

                            $('#editMaterialLineModal #total').val(total.toFixed(2));
                        });
                        
                        $('#editMaterialLineModal #saveEditMaterialLineBtn').off('click').on('click', function() {
                            const form = $('#editMaterialLineModal #formEditMaterialLine');
                            const articuloId = form.find('#material_id').val();
                            const cantidad = form.find('#cantidad').val();
                            const precio = form.find('#precio').val();
                            const descuento = form.find('#descuento').val();
                            const total = form.find('#total').val();
                            const lineaId = form.find('#lineaId').val();

                            if (!articuloId || !cantidad || !precio || !descuento || !total) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Todos los campos son requeridos',
                                });
                                return;
                            }

                            $.ajax({
                                url: "<?php echo e(route('admin.lineaspartes.update', ':lineaId')); ?>".replace(':lineaId', lineaId),
                                method: 'PUT',
                                data: {
                                    parteTrabajo_id: parteTrabajoId,
                                    articulo_id: articuloId,
                                    cantidad: cantidad,
                                    precioSinIva: precio,
                                    descuento: descuento,
                                    total: total,
                                    _token: "<?php echo e(csrf_token()); ?>"
                                },
                                beforeSend: function () {
                                    openLoader();
                                },
                                success: function(response) {
                                    closeLoader();
                                    if (response.success) {

                                        const linea = response.linea;

                                        // Calcular el beneficio teniendo en cuenta el descuento
                                        let precioFinal = linea.descuento 
                                            ? linea.precioSinIva * (1 - linea.descuento / 100) 
                                            : linea.precioSinIva;

                                        let beneficio = (precioFinal - linea.articulo.ptsCosto) * linea.cantidad;

                                        // Evitar división por cero
                                        let totalPrecioVenta = precioFinal * linea.cantidad;
                                        let beneficioPorcentaje = totalPrecioVenta > 0 
                                            ? (beneficio / totalPrecioVenta) * 100 
                                            : 0;

                                        // Actualizar la fila de la tabla
                                        const updatedRow = `
                                            <td
                                                class="showImagesArticulo"
                                                data-id="${linea.articulo.idArticulo}"
                                                data-nameart="${linea.articulo.nombreArticulo}"
                                                data-trazabilidad="${linea.articulo.TrazabilidadArticulos}"
                                            >
                                                ${linea.idMaterial}
                                            </td>
                                            <td
                                                class="showHistorialArticulo"
                                                data-id="${linea.articulo.idArticulo}"
                                                data-nameart="${linea.articulo.nombreArticulo}"
                                                data-trazabilidad="${linea.articulo.TrazabilidadArticulos}"
                                            >
                                                ${linea.articulo.nombreArticulo}
                                            </td>
                                            <td>${linea.cantidad}</td>
                                            <td>${formatPrice(linea.precioSinIva)}</td>
                                            <td>${linea.descuento}</td>
                                            <td
                                                class="material-total"
                                            >${formatPrice(linea.total)}</td>
                                            <td>${beneficio.toFixed(2)}€ | ${beneficioPorcentaje.toFixed(2)}%</td>
                                            <td>
                                                <?php $__env->startComponent('components.actions-button'); ?>
                                                    <button type="button" class="btn btn-outline-danger btnRemoveMaterial"
                                                        data-linea='${JSON.stringify(linea)}'
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Eliminar"
                                                    >
                                                        <ion-icon name="trash-outline"></ion-icon>    
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary btnEditMaterial"
                                                        data-linea='${JSON.stringify(linea)}'
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Editar"
                                                    >
                                                        <ion-icon name="create-outline"></ion-icon>
                                                    </button>
                                                <?php echo $__env->renderComponent(); ?>
                                        `;

                                        // Verificar que el elemento existe
                                        const materialElement = $(`#editParteTrabajoModal #elementsToShow #material_${linea.idMaterial}`);

                                        materialElement.html(updatedRow);

                                        // Recalcular el total
                                        calculateTotalSum(parteTrabajoId);

                                        // Cerrar el modal
                                        $('#editMaterialLineModal').modal('hide');

                                        // Mostrar la notificación de éxito
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Línea de material actualizada correctamente',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    

                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: response.message,
                                        });
                                    }
                                },
                                error: function(err) {
                                    closeLoader();
                                    console.error(err);
                                }
                            });
                            
                        });

                        // dejar de escuchar el evento de doble click de la tabla de elementos
                        $('#editParteTrabajoModal #elementsToShow').off('dblclick', '.showHistorialArticulo');
                        
                        $('#editParteTrabajoModal #elementsToShow .showHistorialArticulo').css('cursor', 'pointer');
                        $('#editParteTrabajoModal #elementsToShow .showHistorialArticulo').css('text-decoration', 'underline');


                        $('#editParteTrabajoModal #elementsToShow').off('dblclick', '.showHistorialArticulo').on('dblclick', '.showHistorialArticulo', function(event){
                            openLoader();
                            const id = $(this).data('id');
                            const name = $(this).data('nameart');
                            const trazabilidad = $(this).data('trazabilidad');

                            getHistorial(id, name, trazabilidad);
                        });

                    }
                },
                error: function(err) {
                    console.error(err);
                    closeLoader();
                }
            });

            $('#saveEditParteTrabajoBtn').off('click').on('click', function() {
                const formData = new FormData($('#editParteTrabajoModal #formCreateOrden')[0]);

                // capturar los valores de los inputs de archivos
                const files = $('#editParteTrabajoModal #formCreateOrden input[type="file"]');

                // añadir los archivos al formData
                for (let i = 0; i < files.length; i++) {
                    const input = files[i];
                    const inputName = $(input).attr('name')+'parte';
                    const filesToUpload = input.files;

                    for (let j = 0; j < filesToUpload.length; j++) {
                        formData.append(inputName, filesToUpload[j]);
                    }
                }

                // verificar si se ha firmado el parte de trabajo
                if ( signaturePad ) {
                    const signature = signaturePad.isEmpty();
                    const clienteFirma = $('#editParteTrabajoModal #cliente_firma').val();
    
                    if ( !signature ) {
                        const signatureData = signaturePad.toDataURL();
                        formData.append('signature', signatureData);
                    }
    
                    if ( clienteFirma ) {
                        formData.append('cliente_firma', clienteFirma);
                    }
                }

                $.ajax({
                    url: `/admin/partes/update/${idParteTrabajo}`,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        openLoader();
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Parte de trabajo actualizado correctamente',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            
                            $('#editParteTrabajoModal').modal('hide');
                            window.location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo salió mal',
                            });
                        }
                        closeLoader();
                    },
                    error: function(err) {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo salió mal',
                        });
                        closeLoader();
                    }
                });
            });

        }

        const getInfoCompra = ( id, element ) => {

            let compraId = id;

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
                $('#modalEditCompra #totalIvaEdit').val(totalIva);
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

            $.ajax({
                url: `<?php echo e(route('admin.compras.show', ':id')); ?>`.replace(':id', compraId),
                method: 'GET',
                beforeSend: function() {
                    openLoader();
                },
                success: function(response) {
                    closeLoader();
                    if (response.success) {
                        
                        const compra        = response.compra;
                        const proveedorRes  = response.proveedor;
                        const archivoRes       = response.archivo;

                        let fecha               = compra.fechaCompra;
                        let nFactura            = compra.NFacturaCompra;
                        let proveedor           = proveedorRes.idProveedor;
                        let formaPago           = compra.formaPago;
                        let importe             = compra.Importe;
                        let iva                 = compra.Iva;
                        let totalIva            = compra.totalIva;
                        let retenciones         = compra.retencionesCompras;
                        let totalRetenciones    = compra.totalRetenciones;
                        let total               = compra.totalFactura;
                        let suplidos            = compra.suplidosCompras;
                        let nAsiento            = compra.NAsientoContable;
                        let observaciones       = compra.ObservacionesCompras;
                        let plazos              = compra.Plazos;
                        let empresa             = compra.empresa_id;
                        let archivo             = archivoRes;
                        let totalFacturaExacto  = compra.totalExacto;

                        let fechaFormateada = moment(fecha).format('YYYY-MM-DD');
                        $('#previewOfPdfEdit').empty();

                        $('#modalEditCompra #formEditCompra').attr('action', '/admin/compras/update/' + compraId);
                        $('#modalEditCompra #formEditCompra').attr('enctype', 'multipart/form-data');

                        // Mostrar modal de edición
                        $('#modalEditCompra').modal('show');
                        $('#editCompraTitle').text('Editar Compra Nº ' + compraId);

                        // Inicializar Select2
                        $('#modalEditCompra select.form-select').select2({
                            width: '100%',
                            placeholder: 'Seleccione una opción',
                            dropdownParent: $('#modalEditCompra')
                        });

                        $('#modalEditCompra #IvaEdit').attr('disabled', false).attr('readonly', false);

                        // Rellenar campos del formulario de edición
                        $('#modalEditCompra #idCompraEdit').val(compraId);
                        $('#modalEditCompra #fechaCompraEdit').val(fechaFormateada);
                        $('#modalEditCompra #NFacturaCompraEdit').val(nFactura);
                        $('#modalEditCompra #empresa_idEdit').val(empresa).trigger('change');
                        $('#modalEditCompra #proveedor_idEdit').val(proveedor).trigger('change');
                        $('#modalEditCompra #formaPagoEdit').val(formaPago).trigger('change');
                        $('#modalEditCompra #ImporteEdit').val(importe);
                        $('#modalEditCompra #IvaEdit').val(iva);
                        $('#modalEditCompra #IvaCreateCompraEdit').val(iva);
                        $('#modalEditCompra #totalIvaEdit').val(totalIva);
                        $('#modalEditCompra #totalFacturaEdit').val(total);
                        $('#modalEditCompra #suplidosComprasEdit').val(suplidos);
                        $('#modalEditCompra #NAsientoContableEdit').val(nAsiento);
                        $('#modalEditCompra #ObservacionesComprasEdit').val(observaciones);
                        $('#modalEditCompra #PlazosEdit').val(plazos).trigger('change');
                        $('#modalEditCompra #totalFacturaExactoEdit').val(totalFacturaExacto);

                        $('#modalEditCompra #proveedorHelpCreateCompra').css('cursor', 'pointer', 'text-decoration', 'underline');

                        // Mostrar vista previa del PDF
                        if (archivo) {

                            let archivoUrl = archivo.pathFile; 

                            // obtener la ruta completa del archivo
                            let archivoFinal = globalBaseUrl + archivo.pathFile;

                            let pdfViewer = `
                                <embed src="${ archivoFinal }" type="application/pdf" width="100%" height="600px">
                            `;
                            $('#previewOfPdfEdit').html(pdfViewer);
                        }

                        // Mostrar tabla de elementos
                        $('#tableToShowElementsEdit').show();

                        // agregar lineas a la tabla
                        let elements = $('#elementsToShowEdit');
                        elements.empty();

                        // <input type="hidden" id="sumaTotalesLineas" data-value="0">
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.id = 'sumaTotalesLineas';
                        input.dataset.value = '0';

                        elements.append(input);

                        let lineas = response.lineas;

                        lineas.forEach(linea => {
                            let newElement = `
                                <tr id="linea${linea.idLinea}">
                                    <td>${linea.idLinea}</td>
                                    <td style="font-weight: bold;">${linea.cod_proveedor}</td>
                                    <td>${linea.descripcion}</td>
                                    <td>${linea.cantidad}</td>
                                    <td>${linea.precioSinIva}</td>
                                    <td>${linea.RAE}</td>
                                    <td>${linea.descuento}</td>
                                    <td>${linea.proveedor.nombreProveedor}</td>
                                    <td
                                        class="openHistorialArticulo"
                                        data-id="${linea.articulo_id}"
                                        data-nameart="${linea.descripcion}"
                                        data-trazabilidad="${linea.trazabilidad}"
                                    >${formatTrazabilidad(linea.trazabilidad)}</td>
                                    <td>${parseFloat(linea.total).toFixed(2)}€</td>
                                    <td>${ linea.user?.name ?? 'Sin registro' }</td>
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
                        });

                        // aplicar estilo al openHistorialArticulo
                        $('#modalEditCompra #elementsToShowEdit .openHistorialArticulo').css('cursor', 'pointer');
                        $('#modalEditCompra #elementsToShowEdit .openHistorialArticulo').css('text-decoration', 'underline');

                        $('#modalEditCompra #elementsToShowEdit').off('dblclick', '.openHistorialArticulo');

                        $('#modalEditCompra #elementsToShowEdit').on('dblclick', '.openHistorialArticulo', function(event){
                            openLoader();
                            const id = $(this).data('id');
                            const name = $(this).data('nameart');
                            const trazabilidad = $(this).data('trazabilidad');

                            getHistorial(id, name, trazabilidad);
                        });

                        // eliminar el pdf actual y agregar el nuevo
                        $('#modalEditCompra #fileEdit').change(function() {
                            $('#previewOfPdfEdit').empty();
                            let file = $(this)[0].files[0];
                            let reader = new FileReader();
                            reader.onload = function(e) {
                                let pdfViewer = `
                                    <embed src="${e.target.result}" type="application/pdf" width="100%" height="600px">
                                `;
                                $('#previewOfPdfEdit').html(pdfViewer);
                            };
                            reader.readAsDataURL(file);
                        });

                        // Editar la línea de compra
                        $('#elementsToShowEdit').off('click', '.editLineaCompra').on('click', '.editLineaCompra', function(event) {
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
                            $('#modalEditLinea #cantidadEdit').off('change').on('change',function() {
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

                            $('#modalEditLinea #precioSinIvaEdit').off('change').on('change',function() {
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

                            $('#modalEditLinea #descuentoEdit').off('change').on('change',function() {
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

                            $('#modalEditLinea #totalEdit').off('change').on('change',function() {
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
                            $('#modalEditLinea #raeEdit').off('change').on('change',function() {
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
                        $('#modalEditLinea #btnSaveEditLinea').off('click').on('click',function() {
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
                                            <td style="font-weight: bold;">${lineaResponse.cod_proveedor}</td>
                                            <td>${lineaResponse.descripcion}</td>
                                            <td>${lineaResponse.cantidad}</td>
                                            <td>${lineaResponse.precioSIva}</td>
                                            <td>${lineaResponse.RAE}€</td>
                                            <td>${lineaResponse.descuento}</td>
                                            <td>${lineaResponse.proveedor.nombreProveedor}</td>
                                            <td
                                                class="openHistorialArticulo"
                                                data-id="${lineaResponse.articulo_id}"
                                                data-nameart="${lineaResponse.descripcion}"
                                                data-trazabilidad="${lineaResponse.trazabilidad}"
                                            >${formatTrazabilidad(lineaResponse.trazabilidad)}</td>
                                            <td>${total}</td>
                                            <td><?php echo e(Auth::user()->name); ?></td>
                                            <td>
                                                <?php $__env->startComponent('components.actions-button'); ?>
                                                    <button 
                                                        class="btn btn-primary editLineaCompra" 
                                                        data-id="${lineaResponse.idLinea}" 
                                                        data-lineainfo='${JSON.stringify(lineaResponse)}'
                                                    >
                                                        <ion-icon name="create-outline"></ion-icon>
                                                    </button>
                                                    <button 
                                                        class="btn btn-danger deleteLineaCompra" 
                                                        data-id="${lineaResponse.idLinea}" 
                                                        data-lineainfo='${JSON.stringify(lineaResponse)}'
                                                    >
                                                        <ion-icon name="trash-outline"></ion-icon>
                                                    </button>
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
                        $('#elementsToShowEdit').off('click', '.deleteLineaCompra').on('click', '.deleteLineaCompra', function(event) {
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
                        $('#modalEditCompra #addNewLineEdit').off('click').on('click', function() {
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
                            $('#cantidadEdit').off('change').on('change', function () {
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

                            $(`#precioSinIvaEdit`).off('change').on('change', function () {
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

                            $('#descuentoEdit').off('change').on('change', function () {
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
                            $('#raeEdit').off('change').on('change', function () {
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
                        $('#newLinesContainerEdit').off('click', '.saveLineaEdit').on('click', '.saveLineaEdit', function (event) {
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
                                                    <tr id="linea${linea.idLinea}">
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
                                        <tr id="linea${linea.idLinea}">
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
                        $('#modalEditCompra #btnSaveEditCompra').off('click').on('click', function () {
                            $('#formEditCompra').submit(); // Enviar formulario
                        });

                        // Función para manejar los cambios en el campo de plazos
                        $('#modalEditCompra #PlazosEdit').off('change').on('change',function() {
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

                        $('#modalEditCompra #frecuenciaPagoEdit').off('change').on('change', () =>{

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
                        $('#modalEditCompra #btnCreateCompra').off('click').on('click', function() {
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

                    }
                },
                error: function(error) {
                    closeLoader();
                    console.log(error);
                }
            });

        }

        function getEditArticle(id, idModal){
            
            $.ajax({
                url: `/admin/articulos/edit/${id}`,
                method: 'GET',
                beforeSend: function() {
                    openLoader();
                },
                success: function(response) {
                    closeLoader();
                    if (response.success) {
                        
                        const articulo = response.articulo;

                        const articulo_id   = articulo.idArticulo;
                        const name          = articulo.nombreArticulo;
                        const trazabilidad  = articulo.TrazabilidadArticulos;
                        const stockinfo     = articulo.stock;
                        const empresa       = articulo.empresa;
                        const categoria     = articulo.categoria;
                        const proveedor     = articulo.proveedor;
                        const ptscosto      = articulo.ptsCosto;
                        const ptsventa      = articulo.ptsVenta;
                        const beneficio     = articulo.Beneficio;
                        const subctainicio  = articulo.SubctaInicio;
                        const observaciones = articulo.observaciones;
                        const images        = articulo.imagenes;

                        const imagesToUpload = [];

                        // limpiar la vista previa de imagenes
                        $('#editArticleModal #previewImages').empty();

                        // verificar si hay imagenes y mostrar la vista previa
                        if (images.length > 0) {
                            const container = $('#editArticleModal #previewImages');
                            container.empty();

                            $('#editArticleModal #previewImages').css('margin-bottom', '10px');

                            // mostrar vista previa de las imagenes
                            images.forEach((image, index) => {
                                const { pivot, pathFile } = image;
                                const { archivo_id } = pivot;

                                const url = `${globalBaseUrl}${pathFile}`;
                                const img = $(`<img src="${url}" class="img-thumbnail" style="width: 100px; height: 100px; margin-right: 10px;">`);

                                // boton para eliminar la imagen
                                const deleteBtn = $(`<button class="btn btn-danger deleteImage" data-id="${archivo_id}">Eliminar</button>`);

                                const imageContainer = $(`<div class="d-flex align-items-center" style="margin-bottom: 10px;"></div>`);
                                imageContainer.append(img);
                                imageContainer.append(deleteBtn);

                                container.append(imageContainer);
                            });

                            $('#editArticleModal #previewImages').off('click').on('click', '.deleteImage', function(event) {
                                event.preventDefault();
                                const id = $(this).data('id');
                                const item = $(this);
                                
                                Swal.fire({
                                    title: '¿Estás seguro?',
                                    text: "No podrás revertir esto!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, eliminar!',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // ajax para eliminar la imagen
                                        $.ajax({
                                            url: `/admin/articulos/deleteimage/${id}`,
                                            method: 'POST',
                                            data:{
                                                _token: '<?php echo e(csrf_token()); ?>'
                                            },
                                            beforeSend: function() {
                                                openLoader();
                                            },
                                            success: function(response) {
                                                closeLoader();
                                                if (response.success) {
                                                    
                                                    const index = imagesToUpload.findIndex(file => file.name === id);
                                                    imagesToUpload.splice(index, 1);
                                                    
                                                    item.parent().remove();
                                                    
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Imagen eliminada correctamente',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    });
                                                } else {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error al eliminar la imagen',
                                                        text: response.message
                                                    });
                                                }
                                            },
                                            error: function(err) {
                                                closeLoader();
                                                console.error(err);
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error al eliminar la imagen',
                                                    text: 'Ocurrió un error al intentar eliminar la imagen'
                                                });
                                            }
                                        });
                                    }
                                })
                            });
                            
                        }

                        idModal.find('input[name="id"]').val(id);
                        idModal.find('input[name="nombre"]').val(name);
                        idModal.find('input[name="ptsCosto"]').val(ptscosto);
                        idModal.find('input[name="ptsVenta"]').val(ptsventa);
                        idModal.find('input[name="Beneficio"]').val(beneficio);
                        idModal.find('input[name="SubctaInicio"]').val(subctainicio);
                        idModal.find('textarea[name="observaciones"]').val(observaciones);
                        idModal.find('input[name="cantidad"]').val(stockinfo.cantidad);
                        idModal.find('input[name="existenciasMin"]').val(stockinfo.existenciasMin);
                        idModal.find('input[name="existenciasMax"]').val(stockinfo.existenciasMax);
                        idModal.find('input[name="ultimaCompraDate"]').val(stockinfo.ultimaCompraDate);

                        idModal.find('select[name="empresa_id"]').val(empresa.idEmpresa).trigger('change');
                        idModal.find('select[name="categoria_id"]').val(categoria.idArticuloCategoria).trigger('change');
                        idModal.find('select[name="proveedor_id"]').val(proveedor.idProveedor).trigger('change');

                        idModal.find('select[name="TrazabilidadArticulos"] option').each(function() {
                            if ($(this).text() === trazabilidad) {
                                $(this).attr('selected', 'selected');
                            }
                        });

                        // agregar action al form
                        idModal.find('form').attr('action', `/admin/articulos/update/${id}`);

                        $('#editArticleModal #ptsVenta').keyup(function() {
                            const costo = $('#editArticleModal #ptsCosto').val();
                            const venta = $(this).val();

                            const beneficio = venta - costo;
                                
                            $('#editArticleModal #Beneficio').val(beneficio);
                        });

                        $('#editArticleModal #ptsCosto').keyup(function() {
                            const costo = $(this).val();
                            const venta = $('#editArticleModal #ptsVenta').val();

                            const beneficio = venta - costo;

                            $('#editArticleModal #Beneficio').val(beneficio);
                        });

                        $('#saveEditArticleBtn').off('click').on('click',function() {

                            // subir las imagenes
                            const formData = new FormData();
                            imagesToUpload.forEach((file, index) => {
                                formData.append(`images[${index}]`, file);
                            });

                            // agregar el token
                            formData.append('_token', '<?php echo e(csrf_token()); ?>');

                            // agregar los datos del formulario
                            idModal.find('form').find('input, select, textarea').each(function() {
                                const name = $(this).attr('name');
                                const value = $(this).val();

                                formData.append(name, value);
                            });

                            // enviar el formulario
                            $.ajax({
                                url: idModal.find('form').attr('action'),
                                method: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Articulo actualizado correctamente',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });

                                        idModal.modal('hide');
                                        window.location.reload();
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error al actualizar el articulo',
                                            text: response.message
                                        });
                                    }
                                },
                                error: function(err) {
                                    console.error(err);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error al actualizar el articulo',
                                        text: 'Ocurrió un error al intentar actualizar el articulo'
                                    });
                                }
                            })
                        });

                        let previewFiles = (files, container, inputIndex) => {
                            openLoader();
                            let filesLoaded = 0;
                            let fileCounter = 0;

                            const MAX_PREVIEW_SIZE = 5 * 1024 * 1024; // 5MB

                            for (let i = 0; i < files.length; i++) {
                                const file = files[i];
                                const reader = new FileReader();
                                const currentIndex = fileCounter++;
                                const uniqueId = `${file.name}_${file.size}`;

                                reader.onload = function(e) {
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

                                    let previewElement;

                                    if (file.type.startsWith("image/")) {
                                        previewElement = $('<img>').attr('src', e.target.result).css({
                                            'max-width': '300px',
                                            'max-height': '300px',
                                            'margin-bottom': '5px',
                                            'object-fit': 'cover',
                                            'border': '1px solid #ddd',
                                            'padding': '5px',
                                            'border-radius': '5px'
                                        });
                                    } else if (file.type.startsWith("video/")) {
                                        const videoUrl = URL.createObjectURL(file);
                                        previewElement = `
                                            <video class="plyr-video" controls autoplay muted poster="https://sebcompanyes.com/vendor/adminlte/dist/img/mileco.jpeg"
                                                style="max-width: 300px; max-height: 300px; margin-bottom: 5px;">
                                                <source src="${videoUrl}" type="${file.type}">
                                            </video>`;
                                    } else if (file.type.startsWith("audio/")) {
                                        previewElement = `
                                            <audio class="plyr-audio" id="plyr-audio-${uniqueId}" controls
                                                style="width: 300px; margin-bottom: 5px;">
                                                <source src="${e.target.result}" type="audio/mp3">
                                            </audio>`;
                                    } else {
                                        previewElement = $('<div>').text("Vista previa no disponible para este tipo de archivo.").css({
                                            'color': '#888',
                                            'margin-bottom': '5px'
                                        });
                                    }

                                    const fileName = $('<span></span>').text(file.name).css('display', 'block');
                                    const commentBox = $(`<textarea class="form-control mb-2" name="comentario[${currentIndex + 1}]" placeholder="Comentario archivo ${currentIndex + 1}" rows="2"></textarea>`);
                                    const removeBtn = $(`<button type="button" class="btn btn-danger btnRemoveFile">Eliminar</button>`).attr('data-unique-id', uniqueId).attr('data-input-id', `input_${inputIndex}`);

                                    fileWrapper.append(previewElement);
                                    fileWrapper.append(fileName);
                                    fileWrapper.append(removeBtn);

                                    container.append(fileWrapper);

                                    filesLoaded++;

                                    if (filesLoaded === files.length) {
                                        closeLoader();
                                    }

                                };

                                reader.readAsDataURL(file);
                            }
                        };

                        // evento para mostrar la vista previa de las imagenes subidas en el input file
                        $('#editArticleModal #images').off('change').on('change', function() {
                            const files = Array.from(this.files);

                            // Filtrar archivos duplicados
                            files.forEach(file => {
                                file.uniqueId = `${file.name}_${file.size}`;

                                if (!imagesToUpload.some(existingFile => existingFile.name === file.name)) {
                                    imagesToUpload.push(file);
                                }
                            });


                            previewFiles(files, $('#editArticleModal #previewImages'), 1);
                        });

                        // Evento para eliminar un archivo de la vista previa
                        $('#editArticleModal').off('click', '.btnRemoveFile').on('click', '.btnRemoveFile', function() {
                            const uniqueId = $(this).data('unique-id');
                            const inputId = $(this).data('input-id');

                            const previewImagesContainer = $('#editArticleModal #previewImages');

                            const escapedUniqueId = uniqueId.replace(/[.#\[\]():\s]/g, "\\$&");
                            const elementToDelete = $(`#preview_${escapedUniqueId}`);

                            elementToDelete.remove();

                            // Limpiar el valor del input
                            $(`#${inputId}`).val('');

                            // Buscar y eliminar el archivo del array imagesToUpload
                            const index = imagesToUpload.findIndex(file => {
                                const fileUniqueId = `${file.name}_${file.size}`;
                                return fileUniqueId === uniqueId; // Comparación corregida
                            });

                            if (index !== -1) {
                                imagesToUpload.splice(index, 1); // Eliminar del array
                            }

                            // Limpieza del input de archivos
                            $('#editArticleModal #images').val('');
                        });

                        $('#editArticleModal').modal('show');
                    }
                },
                error: function(err) {
                    console.error(err);
                    closeLoader();
                }
            });

        }

        function editProveedor(proveedorId){
            // Realizar la solicitud AJAX
            $.ajax({
                url: '/admin/proveedores/show/' + proveedorId, // Endpoint para obtener los datos del proveedor
                method: 'GET',
                dataType: 'json',
                success: function (response) {

                    const proveedor = response.proveedor;
                    // Rellenar los campos del formulario con los datos recibidos
                    $('#editProveedorId').val(proveedor.idProveedor);
                    $('#editCifProveedor').val(proveedor.cifProveedor);
                    $('#editNombreProveedor').val(proveedor.nombreProveedor);
                    $('#editDireccionProveedor').val(proveedor.direccionProveedor);
                    $('#editCodigoPostalProveedor').val(proveedor.codigoPostalProveedor);
                    $('#editCiudad_id').val(proveedor.ciudad_id);
                    $('#editEmailProveedor').val(proveedor.emailProveedor);
                    $('#editAgenteProveedor').val(proveedor.agenteProveedor);
                    $('#editTipoProveedor').val(proveedor.tipoProveedor);
                    $('#editBanco_id').val(proveedor.banco_id);
                    $('#editScta_ConInicio').val(proveedor.Scta_ConInicio);
                    $('#editScta_Contable').val(proveedor.Scta_Contable);
                    $('#editObservacionesProveedor').val(proveedor.observacionesProveedor);

                    // dependiendo de la longitud de los telefonos se agregan inputs
                    const telefonos = proveedor.telefonos;

                    if( telefonos.length > 0 ){
                        telefonos.forEach( (telefono, index) => {
                            if( index === 0 ){
                                $('#modalEditProveedor #telefono').val(telefono.telefono);
                            }else{
                                const btnDelete = $('<button type="button" class="btn btn-outline-danger btnDeleteTelefono mt-2 mb-2">Eliminar</button>');
                                const input = $(`<input type="number" name="telefono[]" class="form-control" value="${telefono.telefono}" required>`);
                                $('#modalEditProveedor #telefonosContainer').append(input).append(btnDelete);

                                btnDelete.click(function() {
                                    input.remove();
                                    btnDelete.remove();
                                    $('#btnAddTelefono').prop('disabled', false);
                                });
                            }
                        })
                    }

                    // Actualizar la acción del formulario
                    $('#formEditProveedor').attr('action', '/admin/proveedores/update/' + proveedor.idProveedor);

                    // Mostrar el modal
                    $('#modalEditProveedor').modal('show');
                },
                error: function (xhr, status, error) {
                    // Manejar errores
                    console.error('Error al obtener los datos del proveedor:', error);
                    alert('Hubo un error al cargar los datos del proveedor. Por favor, inténtalo de nuevo.');
                }
            });
        }

    </script>

    <script>

        function formatPrice(price) {
            if (typeof price !== 'number') {
                console.warn('El valor proporcionado no es un número:', price);
                return price;
            }

            // Asegúrate de redondear a dos decimales
            const roundedPrice = Math.round((price + Number.EPSILON) * 100) / 100;

            return new Intl.NumberFormat('es-ES', {
                style: 'currency',
                currency: 'EUR',
                minimumFractionDigits: 2, // Asegura que siempre haya dos decimales
                maximumFractionDigits: 2  // Limita a dos decimales
            }).format(roundedPrice);
        }

        function formatDateYYYYMMDD(date) {
            return new Intl.DateTimeFormat('es-ES').format(new Date(date));
        }

        let isNavigatingInternally = false; // Indicador de navegación interna

        function bloquearBotonRegreso() {
            window.history.pushState(null, null, window.location.href);
        }

        function manejarBotonRegreso() {
            window.addEventListener('popstate', function (event) {
                if (isNavigatingInternally) {
                    // Si es una navegación interna, no mostrar alerta
                    isNavigatingInternally = false;
                    return;
                }

                if (document.querySelector('.modal.show')) {
                    event.preventDefault();
                    $('.modal').modal('hide');
                    bloquearBotonRegreso();
                } else {
                    // Mostrar alerta de confirmación
                    Swal.fire({
                        title: '¿Estás seguro de salir?',
                        text: "Si sales, perderás los cambios no guardados",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, salir'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.history.back(); // Permitir retroceso
                        } else {
                            bloquearBotonRegreso(); // Volver a bloquear si cancela
                        }
                    });
                }
            });
        }

        // Manejar enlaces internos
        document.querySelectorAll('li a').forEach(anchor => {
            anchor.addEventListener('click', function (event) {
                isNavigatingInternally = true; // Marcar navegación interna
                setTimeout(() => {
                    isNavigatingInternally = false; // Reiniciar el indicador
                }, 500); // Tiempo para permitir el cambio de ruta
            });
        });

        // Inicialización
        bloquearBotonRegreso();
        manejarBotonRegreso();

    </script>

    
    <?php echo $__env->yieldContent('body'); ?>
    
    
    <script>
     
        // Función para manejar la selección de checkbox y guardar en localStorage
        function handleCheckboxSelection(tableId) {
            const CHECKBOX_KEY = `selectedCheckboxes_${tableId}`;
            let selectedCheckboxes = JSON.parse(localStorage.getItem(CHECKBOX_KEY)) || [];

            // Cargar el estado de los checkboxes desde localStorage
            $(`#${tableId} tbody input[type="checkbox"]`).each(function () {
                const checkboxId = $(this).data('id'); // Usamos el data-id en lugar de value
                if (checkboxId && selectedCheckboxes.includes(checkboxId.toString())) {
                    $(this).prop("checked", true);
                }
            });

            // Guardar/Eliminar checkbox seleccionado al hacer clic
            $(`#${tableId} tbody`).on("change", "input[type='checkbox']", function () {
                const checkboxId = $(this).data('id'); // Usamos el data-id

                // Solo procesamos si checkboxId tiene un valor válido
                if (checkboxId) {
                    const checkboxIdStr = checkboxId.toString();

                    if ($(this).is(":checked")) {
                        if (!selectedCheckboxes.includes(checkboxIdStr)) {
                            selectedCheckboxes.push(checkboxIdStr);
                        }
                    } else {
                        selectedCheckboxes = selectedCheckboxes.filter(id => id !== checkboxIdStr);
                    }

                    // Guardar el estado actualizado en localStorage
                    localStorage.setItem(CHECKBOX_KEY, JSON.stringify(selectedCheckboxes));
                }
            });
        }

        // Función para mostrar los elementos seleccionados
        function showSelectedItems(tableId) {
            const CHECKBOX_KEY = `selectedCheckboxes_${tableId}`;
            const selectedCheckboxes = JSON.parse(localStorage.getItem(CHECKBOX_KEY)) || [];

            // Obtener la instancia de DataTable
            const table = $(`#${tableId}`).DataTable();

            // Verificar si hay elementos seleccionados
            if (selectedCheckboxes.length > 0) {
                // Iterar sobre todas las filas de la tabla
                table.rows().every(function () {
                    const row = this.node(); // Nodo de la fila actual
                    const checkbox = $(row).find('input[type="checkbox"]');
                    const checkboxId = checkbox.data('id').toString();

                    // Mostrar u ocultar la fila según si está en los seleccionados
                    if (selectedCheckboxes.includes(checkboxId)) {
                        $(row).show();
                    } else {
                        $(row).hide();
                    }
                });

                // Redibujar la tabla después de ocultar/mostrar las filas
                table.draw();
            } else {
                Swal.fire({
                    icon: 'info',
                    title: `No hay elementos seleccionados en ${tableId}.`,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }

        function filterSelectedItemsOnLoad(tableId) {
            const CHECKBOX_KEY = `selectedCheckboxes_${tableId}`;
            const selectedCheckboxes = JSON.parse(localStorage.getItem(CHECKBOX_KEY)) || [];

            // Obtener la instancia de DataTable
            const table = $(`#${tableId}`).DataTable();

            // Si hay checkboxes seleccionados en localStorage, aplicar el filtro
            if (selectedCheckboxes.length > 0) {
                // Iterar sobre todas las filas de la tabla
                table.rows().every(function () {
                    const row = this.node(); // Nodo de la fila actual
                    const checkbox = $(row).find('input[type="checkbox"]');
                    const checkboxId = checkbox.data('id').toString();

                    // Mostrar u ocultar la fila según si está en los seleccionados
                    if (selectedCheckboxes.includes(checkboxId)) {
                        $(row).show();
                        checkbox.prop('checked', true);  // Mantener el checkbox marcado
                    } else {
                        $(row).hide();
                    }
                });

                // Redibujar la tabla después de ocultar/mostrar las filas
                table.draw();
            }
        }

        // Función global para inicializar la funcionalidad en cualquier tabla
        function initializeSelectableTable(tableId, buttonId, showAllBtn) {
            handleCheckboxSelection(tableId);
            filterSelectedItemsOnLoad(tableId);

            // Manejar el botón para mostrar los elementos seleccionados
            $(`#${buttonId}`).click(function () {
                showSelectedItems(tableId);
            });

            // Manejar el botón para mostrar todos los elementos
            $(`#${showAllBtn}`).click(function () {
                const table = $(`#${tableId}`).DataTable();
                table.rows().every(function () {
                    $(this.node()).show();
                });
                table.draw();
                localStorage.removeItem(`selectedCheckboxes_${tableId}`);

                // desmarcar todos los checkboxes
                $(`#${tableId} tbody input[type="checkbox"]`).prop('checked', false);

            });

        }

        // Inicialización de tablas

        // Puedes inicializar más tablas si es necesario
        // initializeSelectableTable("otraTablaId", "otroBotonId");


    </script>

    <script>
        const loader = document.querySelector('.loaderAjaxContainer');

        const openLoader = () => {
            loader.style.display = 'flex';
        }

        const closeLoader = () => {
            loader.style.display = 'none';
        }

        function formatTrazabilidad(traceability) {
            // Dividir el string en partes usando el guion como delimitador
            const traceabilityFormat = traceability.split('-');

            // Verificar que hay al menos 5 elementos en el array
            if (traceabilityFormat.length < 5) {
                return traceability; // Si no cumple con el formato esperado, retornamos el original
            }

            // Eliminar el tercer elemento (que corresponde al año)
            traceabilityFormat.splice(2, 1);

            // Asegurarse de que el segundo elemento tenga un "0" delante si es necesario
            traceabilityFormat[1] = traceabilityFormat[1].padStart(2, '0');

            // Volver a unir los elementos con guiones
            return traceabilityFormat.join('-');
        }

        function rearrangeToasts() {
            $('.toast').each(function(index) {
                const newTop = index * 50;  // Recalcular la posición de cada toast en función de su nuevo índice
                $(this).css('top', `${newTop}px`);
            });
        }

        function showToast(message, type) {
            const toastId = `toast${Math.floor(Math.random() * 1000)}`;
            const existingToasts = $('.toast').length; // Contar cuántos toasts ya están en pantalla

            let topOffset = existingToasts * 50; // Desplazamiento vertical entre los toasts (ajusta este valor para la separación)

            if ( topOffset >= window.innerHeight - 100 ) {
                // Si se supera el límite inferior de la pantalla, reorganizar los toasts
                rearrangeToasts();
            }

            if ( topOffset == 0 ) {
                topOffset = 50;
            }

            // hacer que el toast se pueda ver en dispositivos móviles
            if (window.innerWidth <= 768) {
                topOffset = 10;
            }
    
            const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-bg-${type} fade show" role="alert" aria-live="assertive" aria-atomic="true" 
                style="position: absolute; top: ${topOffset}px; right: 20px; z-index: 9999999999999999;">
                <div class="d-flex justify-between flex-wrap gap-2 align-items-center align-content-center">
                    <div class="toast-body d-flex justify-between flex-wrap gap-2 align-items-center align-content-center">
                        ${message}
                        <ion-icon name="${type === 'success' ? 'checkmark-circle' : 'close-circle'}" class="me-2"></ion-icon>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`;

            $('body').append(toastHtml);

            // Mostrar y luego ocultar el toast después de 5 segundos
            $(`#${toastId}`).fadeIn(300).delay(5000).fadeOut(300, function() {
                $(this).remove();
                // Reorganizar toasts después de que uno se elimine
                rearrangeToasts();
            });
        }

        $(document).ready(function(){

            const buttonEditProfile = $('#editMyProfile');

            buttonEditProfile.off('click').on('click', function(event){
                event.preventDefault();

                // abrir el modal de edición de perfil
                $('#editProfileModal').modal('show');

                // cambiar titulo del modal
                $('#editProfileTitle').text(`Editar perfil de ${$(this).data('name')}`);

            });

        });


    </script>

    <script>
        $(document).ready(function () {
            // Escuchar cuando se abre cualquier modal
            $('.modal').on('shown.bs.modal', function () {
                const modal = $(this); // El modal actual que se abrió

                // Inicializar select2 para los select dentro de este modal
                modal.find('select.form-select').each(function () {
                    if (!$(this).hasClass('select2-initialized')) {
                        $(this).select2({
                            width: '100%',
                            dropdownParent: modal // Limitar el dropdown al modal actual
                        }).addClass('select2-initialized'); // Evitar inicialización múltiple
                    }
                });

                // hacer que todos los textarea se autoexpandan y se ajusten a su contenido
                modal.find('textarea').each(function () {
                    const textarea = this;
                    textarea.style.height = 'auto'; // Restablecer la altura a 'auto' para recalcular
                    textarea.style.height = `${textarea.scrollHeight}px`; // Establecer la altura al desplazamiento

                    // Escuchar el evento de entrada para ajustar la altura en tiempo real
                    textarea.addEventListener('input', function () {
                        textarea.style.height = 'auto'; // Restablecer la altura a 'auto' para recalcular
                        textarea.style.height = `${textarea.scrollHeight}px`; // Establecer la altura al desplazamiento
                    });

                });

                // Calcular el nuevo z-index basado en la cantidad de modales visibles
                let zIndex = 1050 + (10 * $('.modal:visible').length);
                
                // Aplicar el nuevo z-index al modal actual
                $(this).css('z-index', zIndex);

                // Ajustar el z-index del backdrop asociado
                setTimeout(function () {
                    $('.modal-backdrop')
                        .not('.modal-stack') // Evitar ajustar los ya apilados
                        .css('z-index', zIndex - 1) // Un nivel detrás del modal actual
                        .addClass('modal-stack'); // Marcar el backdrop como apilado
                }, 0);

            });

            $('.modal').on('hidden.bs.modal', function () {
                
                // Verificar si quedan otros modales visibles
                if ($('.modal:visible').length) {
                    $('body').addClass('modal-open'); // Rehabilitar el scroll-lock si corresponde
                }
            });

            $(document).on('click', '.generateFactura', function(event){
                event.preventDefault();
                const id = $(this).data('id');
                // obtener el href del enlace
                const url = $(this).attr('href');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Al generar la factura, no podrás deshacer esta acción y el/los partes o servicios facturados no podrán ser modificados",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, generar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // redirigir a la ruta de generación de factura
                        window.location.href = url;
                    }
                });

            })

        });

        // $(document).ready(function () {

        //     $('.modal').on('shown.bs.modal', function () {
        //         let modalDialog = $(this).find('.modal-dialog');
                
        //         // Hacemos el modal arrastrable desde la cabecera
        //         modalDialog.draggable({
        //             handle: '.modal-header', // Solo se puede arrastrar desde la cabecera
        //             containment: 'document',   // Limitar el movimiento dentro de la ventana del navegador
        //             scroll: false,           // Evitar el desplazamiento cuando arrastras
        //         });
        //     });
        // });

        function renderSlider(containerId, slides, customConfig = {}) {
            // Verifica si el contenedor existe en el DOM
            const container = document.getElementById(containerId);

            if (!container) {
                return;
            }

            // Genera el HTML del slider
            container.innerHTML = `
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        ${slides.map(slide => `
                            <div class="swiper-slide">
                                <img 
                                    src="${slide.src}" 
                                    alt="${slide.alt}" 
                                    style="max-height: 300px; max-width: 100%; object-fit: contain;"
                                >
                            </div>
                        `).join('')}
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            `;

            const defaultConfig = {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    dynamicBullets: true,
                },
            };

            // Combina la configuración predeterminada con la personalizada
            const swiperConfig = { ...defaultConfig, ...customConfig };

            // Inicializa Swiper
            new Swiper(`#${containerId} .mySwiper`, swiperConfig);
        }

    </script>

    
    <?php if(!config('adminlte.enabled_laravel_mix')): ?>
        <script src="<?php echo e(asset('vendor/jquery/jquery.min.js')); ?>"></script>
        <script src="<?php echo e(asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js')); ?>"></script>
        <script src="<?php echo e(asset('vendor/adminlte/dist/js/adminlte.min.js')); ?>"></script>
    <?php else: ?>
        <script src="<?php echo e(mix(config('adminlte.laravel_mix_js_path', 'js/app.js'))); ?>"></script>
    <?php endif; ?>


    
    <?php echo $__env->make('adminlte::plugins', ['type' => 'js'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(asset('js/dashboard.js')); ?>"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/colreorder/2.0.3/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/autofill/2.7.0/js/dataTables.autoFill.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                // Detectar si es un dispositivo táctil
                const isTouchDevice = 'ontouchstart' in document.documentElement;

                const tooltipInstance = new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: isTouchDevice ? 'click' : 'hover' // Usar 'click' en dispositivos táctiles
                });

                // Destruir el tooltip cuando el elemento sea removido
                tooltipTriggerEl.addEventListener('remove', function () {
                    tooltipInstance.dispose();
                });

                if (isTouchDevice) {
                    // Escuchar el evento 'click' fuera del tooltip para cerrarlo en dispositivos móviles
                    document.addEventListener('touchstart', function (e) {
                        if (!tooltipTriggerEl.contains(e.target)) {
                            tooltipInstance.hide();
                        }
                    });
                }
            });

            // script para detectar si la sesión ha expirado
            setTimeout(function() {
                $.ajax({
                    url: "<?php echo e(route('admin.configApp.checkSession')); ?>",
                    method: 'GET',
                    success: function(response) {
                        if (!response.active) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Sesión expirada',
                                text: 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                willClose: function() {
                                    window.location.href = "<?php echo e(route('login')); ?>";
                                }
                            });
                        }
                    },
                    error: function(err) {
                        console.error(err);
                    }
                });
            }, 1000 * 60 * 5); // Cada 5 minutos

        });
    </script>


    
    <?php if(config('adminlte.livewire')): ?>
        <?php if(intval(app()->version()) >= 7): ?>
            @livewireScripts
        <?php else: ?>
            <livewire:scripts />
        <?php endif; ?>
    <?php endif; ?>

    
    <?php echo $__env->yieldContent('adminlte_js'); ?>

</body>

</html>
<?php /**PATH D:\milecosl\vendor\jeroennoten\laravel-adminlte\src/../resources/views/master.blade.php ENDPATH**/ ?>