<?php

namespace Skeleton\Common\Models;

/**
 * Contents model.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class ModelBase extends \Phalcon\Mvc\Model
{
    /**
     * Initialize
     */
    public function initialize()
    {
        $this->setWriteConnectionService("database");
        $this->setReadConnectionService("database_slave");
    }
}
