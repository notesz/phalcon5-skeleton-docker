<?php

/**
 * Bootstrap for cli.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */

use Phalcon\Cli\Console;
use Phalcon\Cli\Console\Exception as PhalconException;
use Phalcon\Di\FactoryDefault\Cli as CliDI;

error_reporting(0);

date_default_timezone_set('Europe/Budapest');

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

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
$di = new CliDI();

/**
 * Include general services
 */
include APP_PATH . '/config/services.php';

/**
 * Include cli environment specific services
 */
include APP_PATH . '/config/services_cli.php';

/**
 * Include Autoloader
 */
include APP_PATH . '/config/loader.php';

/**
 * Get config service for use in inline setup below
 */
$config = $di->getConfig();

/**
 * Create a console application
 */
$console = new Console($di);

/**
 * Register console modules
 */
$console->registerModules([
    'cli' => ['className' => 'Skeleton\Modules\Cli\Module']
]);

/**
 * Setup the arguments to use the 'cli' module
 */
$arguments = ['module' => 'cli'];

/**
 * Process the console arguments
 */
foreach ($argv as $k => $arg) {
    $arg = str_replace('-', '', $arg);

    if ($k == 1) {
        $arguments['task'] = $arg;
    } elseif ($k == 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

try {
    $console->handle($arguments);
} catch (PhalconException $e) {
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
