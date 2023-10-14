<?php

/**
 * Setting up master and slave database connection
 */
$di->setShared('database', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $connection = new $class([
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ]);

    return $connection;
});

$di->setShared('database_slave', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database_slave->adapter;
    $connection = new $class([
        'host'     => $config->database_slave->host,
        'username' => $config->database_slave->username,
        'password' => $config->database_slave->password,
        'dbname'   => $config->database_slave->dbname,
        'charset'  => $config->database_slave->charset
    ]);

    return $connection;
});
