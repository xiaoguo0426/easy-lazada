<?php

use Onetech\EasyLazada\Lazada;

require 'vendor/autoload.php';

$lazada = new Lazada([
    'app_key' => '',
    'app_secret' => '',
    'redirect_uri' => 'https://admin.erp.local',
    'debug' => true,
    'sandbox' => true,
    'log' => [
        'name' => 'foundation',
        'file' => sys_get_temp_dir() . '/foundation.log',
        'level' => 'debug',
        'permission' => 0777,
    ],
    'cache' => new Doctrine\Common\Cache\FilesystemCache(sys_get_temp_dir())
]);

//引导用户到授权页面进行授权。授权成功后，页面会跳转到redirect_uri，url参数会有一个code参数，再使用code去换取access_token

echo $lazada->oauth->authorizer->create();