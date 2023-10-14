<?php

namespace Skeleton\Library;

/**
 * Log.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class Log
{
    protected $config;

    protected $logger;

    protected $logFilePath;

    public function __construct($config)
    {
        $this->config = $config;

        if (!is_dir($this->config->log->dir . \date('Y') . '/')) {
            mkdir($this->config->log->dir . \date('Y') . '/');
        }

        $this->logFilePath = $this->config->log->dir . \date('Y') . '/' . $this->config->project . '.' . \date('Ymd') . '.log';

        $this->logger  = new \Phalcon\Logger\Logger(
            'messages', [
                'main' => new \Phalcon\Logger\Adapter\Stream($this->logFilePath),
            ]
        );
    }

    public function debug($string = '')
    {
        $this->logger->debug($string);
    }

    public function info($string = '')
    {
        $this->logger->info($string);
    }

    public function warning($string = '')
    {
        $this->logger->warning($string);
    }

    public function error($string = '')
    {
        $this->logger->error($string);
    }

    public function critical($string = '')
    {
        $this->logger->critical($string);
    }
}
