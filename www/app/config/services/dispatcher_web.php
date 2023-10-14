<?php

/**
 * Set the default namespace for dispatcher
 */
$di->setShared('dispatcher', function() {
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setDefaultNamespace('Skeleton\Modules\Frontend\Controllers');
    return $dispatcher;
});
