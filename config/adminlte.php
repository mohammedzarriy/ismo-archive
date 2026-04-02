<?php

return [

    'title' => 'ISMO Archive',
    'title_prefix' => '',
    'title_postfix' => ' | ISMO',

    'use_ico_only' => false,
    'use_full_favicon' => false,

    'google_fonts' => [
        'allowed' => true,
    ],

    'logo' => '<b>ISMO</b> Archive',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'ISMO Logo',

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'ISMO Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'ISMO Preloader',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

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

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    'use_route_url' => true,
    'dashboard_url' => 'dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => false,
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    'menu' => [

        // Navbar
        [
            'type' => 'navbar-search',
            'text' => 'Rechercher',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar Search
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Rechercher',
        ],

        // Dashboard
        [
            'text' => 'Tableau de bord',
            'url'  => 'dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
        ],

        // STAGIAIRES
        ['header' => 'GESTION DES STAGIAIRES'],
        [
            'text' => 'Stagiaires',
            'icon' => 'fas fa-fw fa-users',
            'submenu' => [
                [
                    'text' => 'Liste des stagiaires',
                    'url'  => 'trainees',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Ajouter un stagiaire',
                    'url'  => 'trainees/create',
                    'icon' => 'fas fa-fw fa-user-plus',
                ],
                [
                    'text' => 'Importer Excel',
                    'url'  => 'trainees/import',
                    'icon' => 'fas fa-fw fa-file-excel',
                ],
            ],
        ],

        // DOCUMENTS
        ['header' => 'GESTION DES DOCUMENTS'],
        [
            'text' => 'Baccalauréat',
            'icon' => 'fas fa-fw fa-graduation-cap',
            'submenu' => [
                [
                    'text' => 'Liste',
                    'url'  => 'documents/bac',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Retraits temporaires',
                    'url'  => 'documents/bac/temp-out',
                    'icon' => 'fas fa-fw fa-clock',
                    'label' => '!',
                    'label_color' => 'warning',
                ],
            ],
        ],
        [
            'text' => 'Diplômes',
            'icon' => 'fas fa-fw fa-certificate',
            'submenu' => [
                [
                    'text' => 'Liste',
                    'url'  => 'documents/diplome',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Prêts à remettre',
                    'url'  => 'documents/diplome/prets',
                    'icon' => 'fas fa-fw fa-check-circle',
                ],
            ],
        ],
        [
            'text' => 'Bulletins de notes',
            'url'  => 'documents/bulletin',
            'icon' => 'fas fa-fw fa-file-alt',
        ],
        [
            'text' => 'Attestations',
            'url'  => 'documents/attestation',
            'icon' => 'fas fa-fw fa-file-contract',
        ],

        // MOUVEMENTS
        ['header' => 'MOUVEMENTS'],
        [
            'text' => 'Historique',
            'url'  => 'movements',
            'icon' => 'fas fa-fw fa-exchange-alt',
        ],
        [
            'text' => 'Retraits du jour',
            'url'  => 'movements/today',
            'icon' => 'fas fa-fw fa-calendar-day',
        ],

        // VALIDATIONS (✔ ajouté)
        ['header' => 'VALIDATIONS'],
        [
            'text' => 'Registre des validations',
            'url'  => 'validations',
            'icon' => 'fas fa-fw fa-check-double',
        ],

        // ADMINISTRATION
        ['header' => 'ADMINISTRATION'],
        [
            'text' => 'Utilisateurs',
            'url'  => 'users',
            'icon' => 'fas fa-fw fa-user-cog',
            'can'  => 'manage-users',
        ],
        [
            'text' => 'Paramètres',
            'icon' => 'fas fa-fw fa-sitemap',
            'can'  => 'manage-users',
            'submenu' => [
                [
                    'text' => 'Secteurs',
                    'url'  => 'secteurs',
                    'icon' => 'fas fa-fw fa-building',
                ],
                [
                    'text' => 'Filières',
                    'url'  => 'filieres',
                    'icon' => 'fas fa-fw fa-code-branch',
                ],
            ],
        ],
    ],

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    'plugins' => [
        'Datatables' => ['active' => true],
        'Select2' => ['active' => true],
        'Sweetalert2' => ['active' => true],
        'Chartjs' => ['active' => true],
        'Pace' => ['active' => false],
    ],

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
    ],

    'livewire' => false,
];