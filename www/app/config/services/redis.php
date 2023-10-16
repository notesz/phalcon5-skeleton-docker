<?php

/**
 * Setting up redis
 */
$di->setShared('redis', function() {
    $config = $this->getConfig();

    $serializerFactory = new Phalcon\Storage\SerializerFactory();

    $adapter = new Phalcon\Cache\Adapter\Redis($serializerFactory, [
        'lifetime'          => $config->redis->lifetime,
        'host'              => $config->redis->host,
        'port'              => $config->redis->port,
        'persistent'        => false,
        'index'             => 1,
    ]);


    return $adapter;
});
