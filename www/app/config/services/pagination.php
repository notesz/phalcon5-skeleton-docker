<?php

/**
 * Setting up Pagination
 */
$di->setShared('pagination', function () {
    return new \Skeleton\Library\Pagination();
});
