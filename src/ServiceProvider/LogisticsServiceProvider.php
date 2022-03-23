<?php

namespace Onetech\EasyLazada\ServiceProvider;

use Onetech\EasyLazada\Application\Logistics;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LogisticsServiceProvider implements ServiceProviderInterface
{

    /**
     * @param Container $pimple
     * @return mixed
     */
    public function register(Container $pimple)
    {
        $pimple['logistics'] = function ($pimple) {
            return new Logistics($pimple->access_token);
        };
    }
}