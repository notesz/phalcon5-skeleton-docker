<?php

/**
 * Setting up image
 */
$di->setShared('image', function () {
    return new \Skeleton\Library\Image();
});
