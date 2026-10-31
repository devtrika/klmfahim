<?php

/*
|--------------------------------------------------------------------------
| Admin modules & permissions
|--------------------------------------------------------------------------
|
| One entry per admin module. Each module gets the permission string
| "{key}" to open it, plus "{key}_add", "{key}_edit" and "{key}_delete"
| for the actions listed in "actions". The sidebar, the groups permission
| matrix and the CheckRole middleware all read from this file, so adding
| a module here is enough to make it manageable.
|
| section: sidebar heading   url: admin path   label: lang/{ar,en}/layout.php key
|
*/

return [
    'super_group' => 1,

    'sections' => ['menu_website', 'menu_sales', 'menu_inbox', 'menu_team'],

    'modules' => [
        'site' => ['section' => 'menu_website', 'url' => 'trika/site', 'icon' => 'fa-cog', 'label' => 'site', 'actions' => ['edit']],
        'services' => ['section' => 'menu_website', 'url' => 'trika/services', 'icon' => 'fa-briefcase', 'label' => 'services', 'actions' => ['add', 'edit', 'delete']],
        'features' => ['section' => 'menu_website', 'url' => 'trika/features', 'icon' => 'fa-check-square-o', 'label' => 'features', 'actions' => ['add', 'edit', 'delete']],
        'calculator' => ['section' => 'menu_website', 'url' => 'trika/calculator', 'icon' => 'fa-calculator', 'label' => 'calculator_items', 'actions' => ['add', 'edit', 'delete']],
        'clients' => ['section' => 'menu_website', 'url' => 'trika/clients', 'icon' => 'fa-handshake-o', 'label' => 'clients', 'actions' => ['add', 'edit', 'delete']],
        'news' => ['section' => 'menu_website', 'url' => 'trika/news', 'icon' => 'fa-newspaper-o', 'label' => 'blog', 'actions' => ['add', 'edit', 'delete']],
        'pages' => ['section' => 'menu_website', 'url' => 'trika/pages', 'icon' => 'fa-file-text-o', 'label' => 'pages', 'actions' => ['add', 'edit', 'delete']],
        'opinion' => ['section' => 'menu_website', 'url' => 'trika/opinions', 'icon' => 'fa-comments-o', 'label' => 'opinions', 'actions' => ['add', 'edit', 'delete']],
        'slider' => ['section' => 'menu_website', 'url' => 'trika/slider', 'icon' => 'fa-picture-o', 'label' => 'slider', 'actions' => ['add', 'edit', 'delete']],

        'invoices' => ['section' => 'menu_sales', 'url' => 'trika/invoices', 'icon' => 'fa-file-text', 'label' => 'invoices', 'actions' => ['add', 'edit', 'delete']],
        'requests' => ['section' => 'menu_sales', 'url' => 'trika/requests', 'icon' => 'fa-inbox', 'label' => 'requests', 'actions' => ['delete']],

        'contact' => ['section' => 'menu_inbox', 'url' => 'trika/contact', 'icon' => 'fa-envelope-o', 'label' => 'contact', 'actions' => ['edit', 'delete']],
        'booking' => ['section' => 'menu_inbox', 'url' => 'trika/booking', 'icon' => 'fa-phone', 'label' => 'booking', 'actions' => ['edit', 'delete']],
        'newsletter' => ['section' => 'menu_inbox', 'url' => 'trika/newsletter', 'icon' => 'fa-paper-plane-o', 'label' => 'newsletter', 'actions' => ['add', 'delete']],

        'admins' => ['section' => 'menu_team', 'url' => 'trika/admins', 'icon' => 'fa-user-secret', 'label' => 'admins', 'actions' => ['add', 'edit', 'delete']],
        'groups' => ['section' => 'menu_team', 'url' => 'trika/groups', 'icon' => 'fa-users', 'label' => 'groups', 'actions' => ['add', 'edit', 'delete']],
    ],
];
