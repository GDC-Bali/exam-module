<?php

return [
    'name' => 'Exam',
    'navbar-class' => 'bg-dark',
    'gcs' => [
        'active' => false,
        'disk' => 'gcs',
    ],
    'middleware' => [
        
    ],
    'route' => [
        'filter' => false,
        'key' => null,
        'name' => null,
        'domain_main' => 'localhost',
        'domain_attempt' => 'exam.localhost'
    ],
    'layout' => [
        'master' => 'adminlte::page',
        'title' => 'title',
        'header' => 'content_header',
        'content' => 'content',
        'attempt' => 'content',
        'style' => 'css',
        'script' => 'js',
    ],
    'plugins' => [
        'ionicons' => true,
        'select2' => true,
        'icheck' => true,
        'sweetalert2' => true,
        'datatables' => true,
        'smartwizard' => true,
        'bootstrap4-toggle' => true,
    ],
];
