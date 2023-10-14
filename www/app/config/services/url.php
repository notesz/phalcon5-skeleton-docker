<?php

/**
 * Setting up the URL component
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new Phalcon\Mvc\Url();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});
