<?php

namespace Skeleton\Modules\Frontend\Controllers;

/**
 * Index controller.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class IndexController extends \Skeleton\Modules\Frontend\Controllers\ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Index.
     *
     * @return void
     */
    public function indexAction()
    {
    }

    public function testcacheAction()
    {
        $cacheKey = $this->di->get('config')->redis->keyPrefix . '_teszt';

        $source = 'Cache';

        if ($this->di->get('redis')->get($cacheKey) === null) {

            $source = 'Nem cache';

            sleep(10);

            $content = 'Lorem ipsum...';

            $this->di->get('redis')->set($cacheKey, $content);
        }

        $content = $this->di->get('redis')->get($cacheKey);

        $this->view->setVar('content', $content);
        $this->view->setVar('source', $source);
    }
}
