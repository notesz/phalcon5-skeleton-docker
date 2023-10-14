<?php

namespace Skeleton\Modules\Test\Controllers;

/**
 * Debugbar controller.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class DebugbarController extends \Skeleton\Modules\Test\Controllers\ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function DebugbarAction()
    {
        if ($_ENV['DEBUGBAR'] == 'true') {
            $debugbar = $this->di->get('debugbar');
        }

        // Message
        if ($_ENV['DEBUGBAR'] == 'true') {
            $debugbar["messages"]->addMessage("Hello Debug bar!");
        }
    }
}
