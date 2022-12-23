<?php

use Onetech\EasyLazada\Lazada;

require '../vendor/autoload.php';

$redis = new Redis();
$redis->connect('redis',6379,1);//短链接，本地host，端口为6379，超过1秒放弃链接
$redis->auth('secret');

$cache = new \Doctrine\Common\Cache\RedisCache();
$cache->setRedis($redis);

$lazada = new Lazada([
    'region' => 'th',
    'app_key' => '',
    'app_secret' => '',
    'redirect_uri' => 'https://backend.erp.local/lazada/callback',
    'debug' => true,
    'sandbox' => true,
    'log' => [
        'name' => 'foundation',
        'file' => sys_get_temp_dir() . '/foundation.log',
        'level' => 'debug',
        'permission' => 0777,
    ],
    'cache' => $cache
]);

//引导用户到授权页面进行授权。授权成功后，页面会跳转到redirect_uri，url参数会有一个code参数，再使用code去换取access_token

echo $lazada->oauth->authorizer->create() . PHP_EOL;