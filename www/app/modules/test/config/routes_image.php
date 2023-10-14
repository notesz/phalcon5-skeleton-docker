<?php

$router->add('/test/images', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'image',
    'action'     => 'list'
])->setName('test-image-list');

$router->add('/test/images/edit/{code}', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'image',
    'action'     => 'edit'
])->setName('test-image-edit');

$router->add('/test/images/delete/{code}', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'image',
    'action'     => 'delete'
])->setName('test-image-delete');

$router->add('/test/images/upload', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'image',
    'action'     => 'upload'
])->setName('test-image-upload');
