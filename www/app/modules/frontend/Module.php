<?php

namespace Skeleton\Modules\Frontend;

use Phalcon\Di\DiInterface;
use Phalcon\Autoload\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * Frontend module.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class Module implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null) {
        $loader = new Loader();

        $loader->setNamespaces([
            __NAMESPACE__ . '\Controllers' => __DIR__ . '/controllers/',
            __NAMESPACE__ . '\Models'      => __DIR__ . '/models/',
            'Skeleton\Common\Models'       => __DIR__ . '/../../common/models/',
            'Skeleton\Common\Controllers'  => __DIR__ . '/../../common/controllers/'
        ]);

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        /**
         * Setting up the view component
         */
        $di->set('view', function () {
            $view = new View();

            $view->setDI($this);
            $view->setViewsDir(__DIR__ . '/views/');
            $view->setLayoutsDir($this->getConfig()->application->viewsDir->layout);
            $view->setTemplateAfter('layout');
            $view->registerEngines([
                '.phtml' => PhpEngine::class
            ]);

            return $view;
        });
    }
}
