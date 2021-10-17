<?php

$GLOBALS['timeStart'] = ( 1 ) ? microtime() : '';
define( 'paymentCMS' , true);
define('payment_path' , __DIR__.DIRECTORY_SEPARATOR);
define('debugger' , 0);
require_once __DIR__ . '/core/boot/init.php';
app::init();