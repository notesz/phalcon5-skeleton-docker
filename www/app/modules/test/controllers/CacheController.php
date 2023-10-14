<?php

namespace Skeleton\Modules\Test\Controllers;

/**
 * Cache controller.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class CacheController extends \Skeleton\Modules\Test\Controllers\ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function cacheAction()
    {
        $cacheKey = $this->di->get('config')->redis->keyPrefix . '_teszt';

        $source = 'Cache';

        if ($this->di->get('redis')->get($cacheKey) === null) {

            $source = 'Non cache';

            $content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et placerat tellus. Aenean eleifend consequat tincidunt. Quisque a placerat est. Morbi mollis finibus ullamcorper. Integer odio purus, vestibulum sit amet sagittis ac, dignissim a lacus. Cras eget turpis ut quam aliquam malesuada vel sit amet libero. Aenean odio velit, pretium eget semper vitae, euismod quis elit. Quisque et sapien eu enim cursus ornare id in nisi. Nam et fringilla leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sollicitudin at enim eu efficitur. Sed in posuere sem, at lobortis quam. Etiam sed nisi et dui laoreet vestibulum.';

            $this->di->get('redis')->set($cacheKey, $content);
        }

        $content = $this->di->get('redis')->get($cacheKey);

        $this->view->setVar('content', $content);
        $this->view->setVar('source', $source);
    }
}
