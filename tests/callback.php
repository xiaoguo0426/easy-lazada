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
    'debug' => false,
    'sandbox' => true,
    'log' => [
        'name' => 'foundation',
        'file' => './foundation.log',
        'level' => 'debug',
        'permission' => 0777,
    ],
    'cache' => $cache
]);


//try {
//    $code = '0_114568_7CK5Cbah5868R5qBwJNyubrC32396';
//    echo $lazada->access_token->setCode($code)->getToken(true);
//} catch (\Onetech\EasyLazada\Exception\AuthorizationException $exception) {
//    echo $exception->getMessage();
//}
//
//try {
//    echo $lazada->access_token->getToken();
//} catch (\Onetech\EasyLazada\Exception\AuthorizationException $exception) {
//    echo $exception->getMessage();
//}

try {
    echo $lazada->access_token->refresh();

} catch (\Onetech\EasyLazada\Exception\TokenException $e) {
    var_dump($e->getMessage());
} catch (\Onetech\EasyLazada\Exception\AuthorizationException $e) {
    var_dump($e->getMessage());
}

//echo $lazada->access_token->getToken();
//var_dump($lazada->access_token->getToken());
//var_dump($lazada->access_token->getRefreshToken());
//$lazada->access_token->delToken();
//var_dump($lazada->access_token->getToken(false));