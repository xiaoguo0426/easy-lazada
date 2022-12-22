<?php

namespace Onetech\EasyLazada\Oauth;

use Onetech\EasyLazada\Lazada;
use Pimple\Container;

/**
 * Class Oauth
 * @package Onetech\EasyLazada\Oauth
 * @property Authorizer authorizer
 */
class Oauth
{
    /**
     * Container.
     *
     * @var \Pimple\Container
     */
    protected $container;
    /**
     * @var mixed
     */

    /**
     * Oauth constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Create an instance of the Lazada for the given authorizer.
     *
     * @param $token
     *
     * @return Lazada
     */
    public function createAuthorizerApplication($token)
    {
        $this->fetch('authorizer_access_token', function (Authorizer $accessToken) use ($token) {
            //            $accessToken->setToken($token);
        });

        return $this->fetch('app', function ($app) use ($token) {
            //            $app['access_token'] = $this->fetch('authorizer_access_token');
        });
    }

    /**
     * Fetches from pimple container.
     *
     * @param $key
     * @param callable|null $callable
     *
     * @return mixed
     */
    private function fetch($key, callable $callable = null)
    {
        $instance = $this->$key;

        if (! is_null($callable)) {
            $callable($instance);
        }

        return $instance;
    }

    /**
     * magic method.
     *
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->api, $method], $args);
    }

    /**
     * magic method.
     *
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        $className = basename(str_replace('\\', '/', static::class));

        $name = strtolower($className) . '.' . $key;

        return $this->container->offsetGet($name);
    }
}