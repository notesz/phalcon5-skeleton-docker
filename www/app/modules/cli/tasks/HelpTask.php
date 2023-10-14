<?php

namespace Skeleton\Modules\Cli\Tasks;

/**
 * Help task.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class HelpTask extends \Phalcon\Cli\Task
{
    public function mainAction()
    {
        echo 'Use: ./cli [OPTIONS][FUNCTION][PARAMETERS]' . PHP_EOL;
        echo '' . PHP_EOL;
        echo 'Options:' . PHP_EOL;
        echo ' --queue       process queue tasks' . PHP_EOL;
        echo ' --version     show version information' . PHP_EOL;
        echo ' --test        some test' . PHP_EOL;
        echo ' --help        show this help' . PHP_EOL;
    }
}
