<?php

use Onetech\EasyLazada\Lazada;

require '../vendor/autoload.php';

$lazada = new Lazada([
    'app_key' => '',
    'app_secret' => '',
    'debug' => true,
    'sandbox' => true,
    'log' => [
        'name' => 'foundation',
        'file' => './foundation.log',
        'level' => 'debug',
        'permission' => 0777,
    ],
    'cache' => new Doctrine\Common\Cache\FilesystemCache(sys_get_temp_dir())
]);

//$res = $lazada->order->getOrder(10086);
//var_dump($res);

//$eleme = new Eleme([
//    'app_id' => '',
//    'secret' => '',
//    'debug'  => true,
//    'log' => [
//        'file' => './logs/eleme.log',
//        'level'      => 'debug',
//        'permission' => 0777,
//    ]
//]);
//
//$eleme->oauth->getToken();