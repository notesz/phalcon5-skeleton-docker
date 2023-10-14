<?php

/**
 * Setting up logger
 */
$di->setShared('log', function () {
    $config = $this->getConfig();

    $log = new \Skeleton\Library\Log($config);

    return $log;
});
