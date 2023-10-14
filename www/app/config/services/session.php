<?php

/**
 * Starts the session the first time some component requests the session service
 */
$di->setShared('session', function () {
    $config = $this->getConfig();

    $options = [
        'host'       => $config->redis->host,
        'port'       => $config->redis->port,
        'persistent' => false,
        'lifetime'   => $config->session->expire
    ];

    $session           = new Phalcon\Session\Manager();
    $serializerFactory = new Phalcon\Storage\SerializerFactory();
    $factory           = new Phalcon\Storage\AdapterFactory($serializerFactory);
    $redis             = new Phalcon\Session\Adapter\Redis($factory, $options);

    $session
        ->setAdapter($redis)
        ->start();

    return $session;
});
