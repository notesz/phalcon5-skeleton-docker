<?php

namespace Skeleton\Common\Controllers;

/**
 * Base controller.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class ControllerBase extends \Phalcon\Mvc\Controller
{
    /**
     * Initialize.
     */
    public function initialize()
    {
    }

    /**
     * Forward to error 404
     *
     * @return bool
     */
    public function forward404()
    {
        $this->dispatcher->forward([
            'controller' => 'error',
            'action'     => 'error404'
        ]);

        return false;
    }

    /**
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     */
    public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
    {
    }
}
