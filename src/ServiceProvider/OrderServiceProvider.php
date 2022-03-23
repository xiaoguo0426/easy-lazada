<?php

namespace Onetech\EasyLazada\ServiceProvider;

use Onetech\EasyLazada\Application\Order;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OrderServiceProvider implements ServiceProviderInterface
{

    /**
     * @param Container $pimple
     * @return mixed
     */
    public function register(Container $pimple)
    {
        $pimple['order'] = function ($pimple) {
            return new Order($pimple->access_token);
        };
    }
}