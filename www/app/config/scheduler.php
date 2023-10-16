<?php

defined('BASE_PATH') || define('BASE_PATH', realpath(dirname(__FILE__) . '/../..'));

$schedulerSettings = [
    BASE_PATH . '/cli --queue' => '* * * * *'
];
