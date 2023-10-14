<?php

/**
 * Set the default namespace for dispatcher
 */
$di->setShared('dispatcher', function() {
    $dispatcher = new Phalcon\Cli\Dispatcher();
    $dispatcher->setDefaultNamespace('Skeleton\Modules\Cli\Tasks');
    return $dispatcher;
});
