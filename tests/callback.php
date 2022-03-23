<?php

use Onetech\EasyLazada\Lazada;

require 'vendor/autoload.php';


$lazada = new Lazada([
    'app_key' => '107684',
    'app_secret' => 'Hr2EAPgMKD0inFXrhXnyXry0cdwHQLL9',
    'redirect_uri' => 'https://admin.erp.local',
    'debug' => false,
    'sandbox' => true,
    'log' => [
        'name' => 'foundation',
        'file' => './foundation.log',
        'level' => 'debug',
        'permission' => 0777,
    ],
    'cache' => new Doctrine\Common\Cache\FilesystemCache(sys_get_temp_dir())
]);


//try {
//    $code = '0_107684_n2iiLMuWyyCEGWXkd9rupgyC1923';
//    echo $lazada->access_token->setCode($code)->getToken();
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