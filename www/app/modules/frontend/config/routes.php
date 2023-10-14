<?php

// index
$router->add('/', [
    'namespace'  => 'Skeleton\Modules\Frontend\Controllers',
    'module'     => 'frontend',
    'controller' => 'index',
    'action'     => 'index'
])->setName('frontend-index');
