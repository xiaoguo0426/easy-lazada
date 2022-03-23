<?php

namespace Onetech\EasyLazada\ServiceProvider;

use Onetech\EasyLazada\Oauth\Authorizer;
use Onetech\EasyLazada\Oauth\Oauth;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OauthServiceProvider implements ServiceProviderInterface
{

    /**
     * @param Container $pimple
     * @return mixed
     */
    public function register(Container $pimple)
    {

        $pimple['oauth'] = function ($pimple) {
            return new Oauth($pimple);
        };

        $pimple['oauth.authorizer'] = function ($pimple) {
            return new Authorizer($pimple->getConfig('app_key'), $pimple->getConfig('redirect_uri'));
        };

    }
}