<?php

/**
 * Setting up helper
 */
$di->setShared('helper', function () {
    $helper = new \Skeleton\Library\Helper();

    return $helper;
});
