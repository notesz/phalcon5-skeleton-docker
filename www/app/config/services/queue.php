<?php

/**
 * Setting up Queue
 */
$di->setShared('queue', function () {
    return new \Skeleton\Library\Queue($this->getConfig());
});
