<?php

/**
 * Bootstrap for web.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

ini_set('memory_limit', '512M');

error_reporting(0);

date_default_timezone_set('Europe/Budapest');

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    /**
     * Composer
     */
    require BASE_PATH . '/vendor/autoload.php';

    /**
     * Environment variables
     */
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();

    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Debugbar
     */
    if ($_ENV['DEBUGBAR'] == 'true') {
        $debugbar = new \DebugBar\StandardDebugBar();
    }

    /**
     * Include general services
     */
    require APP_PATH . '/config/services.php';

    /**
     * Include web environment specific services
     */
    require APP_PATH . '/config/services_web.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new Application($di);

    /**
     * Register application modules
     */
    foreach (explode(',', $_ENV['MODULES']) as $item) {
        $registerModules[$item] = ['className' => '\Skeleton\Modules\\' . \ucfirst($item) . '\Module'];
    }
    $application->registerModules($registerModules);

    $response = $application->handle(
        $_SERVER['REQUEST_URI']
    );

    $response->send();

    if ($_ENV['DEBUGBAR'] == 'true') {
        $debugbarRenderer = $debugbar->getJavascriptRenderer();
        echo \str_replace('/vendor/maximebf/debugbar/', '/debugbar/', $debugbarRenderer->renderHead());
        echo $debugbarRenderer->render();
    }

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
} catch (\Throwable $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
