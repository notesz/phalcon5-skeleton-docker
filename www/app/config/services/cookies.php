<?php

/**
 * Setting up cookies
 */
$di->set('cookies', function() {
    $cookies = new Phalcon\Http\Response\Cookies();

    $cookies->useEncryption(false);

    return $cookies;
});
