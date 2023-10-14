<?php

/**
 * Registering a router
 */
$di->setShared('router', function () {
    $router = new Phalcon\Mvc\Router(false);

    $router->removeExtraSlashes(true);

    include __DIR__ . '/../routes.php';

    return $router;
});
