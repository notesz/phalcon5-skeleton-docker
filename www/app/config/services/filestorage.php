<?php

/**
 * Setting up Filestorage
 */
$di->setShared('filestorage', function () {
    return new \Skeleton\Library\Filestorage();
});
