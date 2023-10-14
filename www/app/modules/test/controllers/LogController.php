<?php

namespace Skeleton\Modules\Test\Controllers;

/**
 * Log controller.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class LogController extends \Skeleton\Modules\Test\Controllers\ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function logAction()
    {
        $this->di->get('log')->debug('Ouch... It is a debug.');
        $this->di->get('log')->info('Ouch... It is an info.');
        $this->di->get('log')->warning('Ouch... It is an warning.');
        $this->di->get('log')->error('Ouch... It is an error.');
        $this->di->get('log')->critical('Ouch... It is a critical.');
    }
}
