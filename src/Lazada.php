<?php

namespace Onetech\EasyLazada;

use Hanson\Foundation\Foundation;
//use Onetech\EasyLazada\Application\DataMoat;
use Onetech\EasyLazada\Application\Finance;
use Onetech\EasyLazada\Application\Logistics;
use Onetech\EasyLazada\Application\Order;
use Onetech\EasyLazada\Application\Product;
use Onetech\EasyLazada\Application\Seller;
//use Onetech\EasyLazada\Application\System;
use Onetech\EasyLazada\Oauth\AccessToken;
use Onetech\EasyLazada\Oauth\Oauth;
use Onetech\EasyLazada\ServiceProvider\AccessTokenServiceProvider;
//use Onetech\EasyLazada\ServiceProvider\DataMoatServiceProvider;
//use Onetech\EasyLazada\ServiceProvider\FinanceServiceProvider;
use Onetech\EasyLazada\ServiceProvider\LogisticsServiceProvider;
use Onetech\EasyLazada\ServiceProvider\OrderServiceProvider;
use Onetech\EasyLazada\ServiceProvider\OauthServiceProvider;
use Onetech\EasyLazada\ServiceProvider\ProductServiceProvider;
use Onetech\EasyLazada\ServiceProvider\SellerServiceProvider;
//use Onetech\EasyLazada\ServiceProvider\SystemServiceProvider;

/**
 * Class Lazada
 * @package Onetech\EasyLazada
 * @property AccessToken $access_token
// * @property DataMoat $data_moat
 * @property Finance $finance
 * @property Logistics $logistics
 * @property Oauth $oauth
 * @property Order $order
 * @property Product $product
 * @property Seller $seller
 *
 */
class Lazada extends Foundation
{
    protected $providers = [
        AccessTokenServiceProvider::class,
//        DataMoatServiceProvider::class,
//        FinanceServiceProvider::class,
        LogisticsServiceProvider::class,
        OrderServiceProvider::class,
        OauthServiceProvider::class,
        ProductServiceProvider::class,
        SellerServiceProvider::class,
    ];
}