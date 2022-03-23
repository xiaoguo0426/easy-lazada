<?php

require '../vendor/autoload.php';

$lazada = new \Onetech\EasyLazada\Lazada([
    'app_key' => '107684',
    'app_secret' => 'Hr2EAPgMKD0inFXrhXnyXry0cdwHQLL9',
    'debug' => true,
    'log' => [
        'name' => 'foundation',
        'file' => './foundation.log',
        'level' => 'debug',
        'permission' => 0777,
    ],
    'cache' => new Doctrine\Common\Cache\FilesystemCache(sys_get_temp_dir())
]);

$lazada->order->getOrder(10086);