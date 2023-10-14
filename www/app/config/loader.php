<?php

$loader = new Phalcon\Autoload\Loader();

/**
 * Register Namespaces
 */
$loader->setNamespaces([
    'Skeleton\Common\Models' => APP_PATH . '/common/models/',
    'Skeleton\Traits'        => APP_PATH . '/common/traits/',
    'Skeleton\Library'       => APP_PATH . '/libraries/',
    'Skeleton\Queue'         => APP_PATH . '/queue/',
]);

/**
 * Register module classes
 */
$registerClasses['Skeleton\Modules\Cli\Module'] = APP_PATH . '/modules/cli/Module.php';
foreach (explode(',', $_ENV['MODULES']) as $item) {
    $registerClasses['Skeleton\Modules\\' . \ucfirst($item) . '\Module'] = APP_PATH . '/modules/' . $item . '/Module.php';
}
$loader->setClasses($registerClasses);

$loader->register();
