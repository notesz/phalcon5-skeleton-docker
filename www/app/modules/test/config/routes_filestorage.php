<?php

$router->add('/test/filestorage', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'filestorage',
    'action'     => 'list'
])->setName('test-filestorage-list');

$router->add('/test/filestorage/edit/{code}', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'filestorage',
    'action'     => 'edit'
])->setName('test-filestorage-edit');

$router->add('/test/filestorage/delete/{code}', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'filestorage',
    'action'     => 'delete'
])->setName('test-filestorage-delete');

$router->add('/test/filestorage/upload', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'filestorage',
    'action'     => 'upload'
])->setName('test-filestorage-upload');

$router->add('/test/filestorage/download/{code}', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'filestorage',
    'action'     => 'download'
])->setName('test-filestorage-download');
