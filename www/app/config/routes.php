<?php

// 404
$router->notFound([
    'namespace'  => 'Skeleton\Modules\Frontend\Controllers',
    'module'     => 'frontend',
    'controller' => 'error',
    'action'     => 'error404'
]);

foreach (explode(',', $_ENV['MODULES']) as $item) {
    if (is_file(APP_PATH . '/modules/' . $item . '/config/routes.php')) {
        include_once APP_PATH . '/modules/' . $item . '/config/routes.php';
    }
}
