<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'MILECO SL',
    'title_prefix' => 'MILECO |',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>MILECO</b>SL',
    'logo_img' => 'https://sebcompanyes.com/vendor/adminlte/dist/img/MILECOLOGO.gif',
    'logo_img_class' => 'brand-image img-circle elevation-3 imgNavMaster',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'MILECO SL',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => true,
        'img' => [
            'path' => 'https://sebcompanyes.com/vendor/adminlte/dist/img/MILECOLOGO.gif',
            'alt' => 'Mileco S.L',
            'class' => '',
            'width' => 100,
            'height' => 100,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => false,
        // 'mode' => 'cwrapper',
        // 'img' => [
        //     'path' => 'https://sebcompanyes.com/vendor/adminlte/dist/img/MILECOLOGO.gif',
        //     'alt' => 'MILECO S.L',
        //     'effect' => 'animation__shake',
        //     'width' => 500,
        //     'height' => 500,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [

        ['header' => 'Módulos'],
        [
            'text' => 'Inicio',
            'url' => '/home',
            'icon' => 'home',
        ],
        
        [
            'text' => 'Citas',
            'url' => 'admin/citas',
            'icon' => 'copy',
            'can' => 'admin.citas.index',
        ],

        // Menú de Servicios
        [
            'text' => 'Servicios',
            'icon' => 'hammer',
            'submenu' => [
                [
                    'text' => 'Orden de trabajo',
                    'url' => 'admin/orders',
                    'icon' => 'build-outline',
                    'can' => 'admin.ordenes.index',
                ],
                [
                    'text' => 'Partes de trabajo',
                    'url' => 'admin/partes',
                    'icon' => 'file-tray-full-outline',
                    'can' => 'admin.partes.index',
                ],
                [
                    'text' => 'Proyectos',
                    'icon' => 'hammer',
                    'can' => 'admin.proyectos.index',
                    'submenu' => [
                        [
                            'text' => 'Proyectos',
                            'url' => 'admin/proyectos',
                            'icon' => 'ellipse-outline',
                        ],
                        [
                            'text' => 'GeoLocalización',
                            'url' => 'admin/geolocalizacion',
                            'icon' => 'ellipse-outline',
                        ],
                    ],
                ],
                [
                    'text' => 'Operarios',
                    'icon' => 'accessibility',
                    'can' => 'admin.operarios.index',
                    'submenu' => [
                        [
                            'text' => 'Operarios',
                            'url' => 'admin/operarios',
                            'icon' => 'ellipse-outline',
                        ],
                        [
                            'text' => 'Trabajos',
                            'url' => 'admin/trabajos',
                            'icon' => 'ellipse-outline',
                        ],
                    ],
                ],
            ],
        ],

        // Menú de Gestión
        [
            'text' => 'Gestión',
            'icon' => 'settings',
            'submenu' => [
                [
                    'text' => 'Clientes',
                    'icon' => 'happy',
                    'can' => 'admin.clientes.index',
                    'submenu' => [
                        [
                            'text' => 'Clientes',
                            'url' => 'admin/clientes',
                            'icon' => 'ellipse-outline',
                        ],
                        [
                            'text' => 'Tipos de Clientes',
                            'url' => 'admin/tiposclientes',
                            'icon' => 'ellipse-outline',
                        ],
                        [
                            'text' => 'Ciudades',
                            'url' => 'admin/cities',
                            'icon' => 'ellipse-outline',
                        ],
                        [
                            'text' => 'Proveedores',
                            'url' => 'admin/proveedores',
                            'icon' => 'ellipse-outline',
                        ],
                    ],
                ],
                [
                    'text' => 'Artículos',
                    'icon' => 'cart',
                    'can' => 'admin.articulos.index',
                    'submenu' => [
                        [
                            'text' => 'Artículos',
                            'url' => 'admin/articulos',
                            'icon' => 'ellipse-outline',
                        ],
                        [
                            'text' => 'Categorías',
                            'url' => '/admin/categorias',
                            'icon' => 'ellipse-outline',
                        ],
                        [
                            'text' => 'Traspasos',
                            'url' => '/admin/traspasos',
                            'icon' => 'ellipse-outline',
                        ],
                    ],
                ],
                [
                    'text' => 'Compras',
                    'url' => 'admin/compras',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.compras.index',
                ],
            ],
        ],
        
        [
            'text' => 'Admin',
            'icon' => 'card',
            'can' => 'home',
            'submenu' => [
                [
                    'text' => 'Configuraciones',
                    'url' => 'admin/configApp',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.configApp.index',
                ],
                [
                    'text' => 'Backups',
                    'url' => 'admin/backups',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.backups.index',
                ],
                [
                    'text' => 'Empresas',
                    'url' => 'admin/empresas',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.backups.index',
                ],
                [
                    'text' => 'Estadisticas',
                    'url' => 'admin/analytics',
                    'icon' => 'ellipse-outline',
                ],
                [
                    'text' => 'Modelo 347',
                    'url' => '/modelo347',
                    'icon' => 'ellipse-outline',
                ],
                [
                    'text' => 'Usuarios',
                    'url' => 'admin/users',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.users.index',
                ],
                [
                    'text' => 'Roles',
                    'url' => '/admin/roles',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.roles.index',
                ],
                [
                    'text' => 'Bancos',
                    'url' => 'admin/banks',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.bancos.index',
                ],
                [
                    'text' => 'Compras',
                    'url' => 'admin/compras',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.compras.index',
                ],
                [
                    'text' => 'Ventas',
                    'url' => 'admin/ventas',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.ventas.index',
                ],
                [
                    'text' => 'Gestor de archivos',
                    'url' => 'admin/file-manager',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.users.index',
                ],
                [
                    'text' => 'Presupuestos',
                    'url' => 'admin/presupuestos',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.presupuestos.index',
                ],
                [
                    'text' => 'Pagos/Cobros',
                    'url' => 'admin/pagoscompras',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.pagoscompras.index',
                ],
                [
                    'text' => 'Salarios',
                    'url' => 'admin/salarios',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.salarios.index',
                ],
                [
                    'text' => 'Desplazamientos',
                    'url' => 'admin/desplazamientos',
                    'icon' => 'ellipse-outline',
                    'can' => 'admin.desplazamientos.index',
                ],
                [
                    'text' => 'Contabilidad',
                    'icon' => 'server',
                    'can' => 'admin.contabilidad.index',
                    'submenu' => [
                        [
                            'text' => 'ejemplo',
                            'url' => 'ejemplo',
                        ],
                        [
                            'text' => 'level_one',
                            'url' => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_two',
                                    'url' => '#',
                                ],
                                [
                                    'text' => 'level_two',
                                    'url' => '#',
                                    'submenu' => [
                                        [
                                            'text' => 'level_three',
                                            'url' => '#',
                                        ],
                                        [
                                            'text' => 'level_three',
                                            'url' => '#',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'text' => 'level_one',
                            'url' => '#',
                        ],
                    ],
                ],
            ],
        ],

        
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/2.1.7/js/dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/2.1.7/js/dataTables.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
