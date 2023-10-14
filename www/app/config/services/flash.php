<?php

/**
 * Register the session flash service with Bootstrap classes
 */
$di->set('flash', function () {

    $flash = new Phalcon\Flash\Session();

    $flash->setCssClasses([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'warning' => 'alert alert-info',
        'notice'  => 'alert alert-info'
    ]);

    $flash->setCustomTemplate('
        <div class="%cssClass%">
            %message%
        </div>'
    );

    $flash->setAutoescape(false);

    return $flash;
});
