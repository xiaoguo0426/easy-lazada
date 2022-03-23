<?php

namespace Onetech\EasyLazada\ServiceProvider;

use Onetech\EasyLazada\Application\Finance;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class FinanceServiceProvider implements ServiceProviderInterface
{

    /**
     * @param Container $pimple
     * @return mixed
     */
    public function register(Container $pimple)
    {
        $pimple['finance'] = function ($pimple) {
            return new Finance($pimple->access_token);
        };
    }
}