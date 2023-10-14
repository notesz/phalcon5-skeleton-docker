<?php

namespace Skeleton\Queue;

/**
 * Class Mail
 *
 * @package Skeleton\Queue
 */
class Mail
{
    const TYPE = 'mail';

    protected $parameters;

    public function __construct($parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @return bool|string   Return true or a string with the error message.
     */
    public function process()
    {
        $parameters = $this->parameters;

        // $parameters example:
        // [
        //     'to'          => [
        //         'email' => 'test@example.com',
        //         'name'  => 'Joe Example'
        //     ],
        //     'from'        => [
        //         'email' => 'sales@mycompany.com',
        //         'name'  => 'My Company'
        //     ],
        //     'subject'     => 'Test',
        //     'body'        => '<p>This is a test email</p>',
        //     'attachments' => [
        //         [
        //             'filepath' => BASE_PATH . '/data/document.pdf',
        //             'name'     => 'document.pdf',
        //             'type'     => 'application/pdf'
        //         ]
        //     ]
        // ]

        try {

            $mailer = new \PHPMailer\PHPMailer\PHPMailer();

            $mailer->IsSMTP();

            $mailer->SMTPAuth    = true;
            $mailer->CharSet     = 'UTF-8';
            $mailer->SMTPSecure  = \Phalcon\Di\Di::getDefault()->getConfig()->mailer->smtpSecure;
            $mailer->Host        = \Phalcon\Di\Di::getDefault()->getConfig()->mailer->smtpHost;
            $mailer->Port        = \Phalcon\Di\Di::getDefault()->getConfig()->mailer->smtpPort;
            $mailer->Username    = \Phalcon\Di\Di::getDefault()->getConfig()->mailer->smtpUsername;
            $mailer->Password    = \Phalcon\Di\Di::getDefault()->getConfig()->mailer->smtpPassword;
            $mailer->XMailer     = \Phalcon\Di\Di::getDefault()->getConfig()->mailer->XMailer;

            $mailer->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                ]
            ];

            $mailer->isHTML(true);

            $mailer->setFrom(
                $parameters['from']['email'],
                $parameters['from']['name']
            );

            $mailer->addAddress(
                $parameters['to']['email'],
                $parameters['to']['name']
            );

            $mailer->Subject = $parameters['subject'];

            $mailer->Body = $parameters['body'];

            if (!empty($parameters['attachments'])) {
                foreach ($parameters['attachments'] as $attachments) {
                    if (\is_file($attachments['filepath'])) {
                        $mailer->AddAttachment(
                            $attachments['filepath'],
                            $attachments['name'],
                            $encoding = 'base64',
                            $type = $attachments['type']
                        );
                    }
                }
            }

            if (!$mailer->send()) {
                throw new \Exception($mailer->ErrorInfo);
            }

            return true;

        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return '?';
    }
}
