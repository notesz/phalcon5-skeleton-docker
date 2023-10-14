<?php

namespace Skeleton\Traits;

/**
 * HttpBehavior trait.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
trait HttpBehavior
{

    /**
     * Set JSON response for AJAX, API request
     *
     * @param  string  $content
     * @param  integer $statusCode
     * @param  string  $statusMessage
     *
     * @return \Phalcon\Http\Response
     */
    public function jsonResponse($content, $statusCode = 200, $statusMessage = 'OK')
    {
        $content = json_encode($content);

        $response = new \Phalcon\Http\Response();
        $response->setStatusCode($statusCode, $statusMessage);
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent($content);

        return $response;
    }

}
