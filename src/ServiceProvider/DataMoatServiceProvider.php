<?php

namespace Onetech\EasyLazada\ServiceProvider;

use Onetech\EasyLazada\Application\DataMoat;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DataMoatServiceProvider implements ServiceProviderInterface
{

    /**
     * @param Container $pimple
     * @return mixed
     */
    public function register(Container $pimple)
    {
        $pimple['data_moat'] = function ($pimple) {
            return new DataMoat($pimple->access_token);
        };
    }
}