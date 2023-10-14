<?php

namespace Skeleton\Modules\Cli\Tasks;

/**
 * Test task.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class TestTask extends \Phalcon\Cli\Task
{
    public function mainAction()
    {
        echo 'Use: ./cli [OPTIONS][FUNCTION][PARAMETERS]' . PHP_EOL;
        echo '' . PHP_EOL;
        echo 'Options:' . PHP_EOL;
        echo ' --test progress 1000            show version information' . PHP_EOL;
        echo ' --test random 16                show a random string' . PHP_EOL;
        echo ' --test uuid                     show a random uuid' . PHP_EOL;
        echo ' --test mail test@example.com    send an email' . PHP_EOL;
    }

    public function progressAction($count)
    {
        $bar = new \Dariuszp\CliProgressBar($count);
        $bar->display();

        for ($i = 0; $i < $count+1; $i++) {
            $bar->progress();
            usleep(1000);
        }

        $bar->end();
    }

    public function randomAction(int $length = 16)
    {
        echo $this->di->get('helper')->getRandomString($length);
    }

    public function uuidAction()
    {
        echo $this->di->get('helper')->getuuid();
    }

    public function mailAction(string $mail = 'test@example.com')
    {
        $queueId = $this->di->get('queue')->add(\Skeleton\Queue\Mail::TYPE, [
            'to'          => [
                'email' => $mail,
                'name'  => $mail
            ],
            'from'        => [
                'email' => $this->di->get('config')->mailer->senderEmail,
                'name'  => $this->di->get('config')->mailer->senderName
            ],
            'subject'     => 'Test',
            'body'        => '<p>This is a test...</p>',
            'attachments' => [
                [
                    'filepath' => BASE_PATH . '/data/dummy.pdf',
                    'name'     => 'dummy.pdf',
                    'type'     => 'application/pdf'
                ]
            ]
        ]);

        echo 'Added ' . $mail . PHP_EOL;
        echo '[DONE]' . PHP_EOL;
    }
}
