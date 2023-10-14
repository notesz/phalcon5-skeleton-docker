<?php

function dumpp(...$vars) {
    foreach ($vars as $var) {
        echo (new \Phalcon\Support\Debug\Dump())->variable($var);
    }
}

function ddd(...$vars) {
    dumpp(...$vars);
    exit;
}
