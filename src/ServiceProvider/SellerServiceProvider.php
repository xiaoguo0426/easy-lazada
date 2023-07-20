<?php

namespace Onetech\EasyLazada\ServiceProvider;

use Onetech\EasyLazada\Application\Seller;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class SellerServiceProvider implements ServiceProviderInterface
{

    /**
     * @param Container $pimple
     * @return mixed
     */
    public function register(Container $pimple)
    {
        $pimple['seller'] = function ($pimple) {
            return new Seller($pimple->getConfig('region'), $pimple->access_token);
        };
    }
}