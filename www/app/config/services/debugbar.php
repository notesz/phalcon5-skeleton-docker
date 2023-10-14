<?php

/**
 * Setting up Debug bar
 */
if ($_ENV['DEBUGBAR'] == 'true') {
    $di->setShared('debugbar', $debugbar);
}
