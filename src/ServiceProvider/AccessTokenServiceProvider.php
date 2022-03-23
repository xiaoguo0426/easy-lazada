<?php


namespace Onetech\EasyLazada\ServiceProvider;


use Onetech\EasyLazada\Oauth\AccessToken;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AccessTokenServiceProvider implements ServiceProviderInterface
{

    /**
     * @param Container $pimple
     * @return mixed
     */
    public function register(Container $pimple)
    {
        $pimple['access_token'] = function ($pimple) {
            return new AccessToken($pimple->getConfig('app_key'), $pimple->getConfig('app_secret'), $pimple->getConfig('debug'), $pimple->getConfig('sandbox'));
        };
    }
}