<?php

namespace Onetech\EasyLazada\Oauth;

use Hanson\Foundation\AbstractAccessToken;
use Onetech\EasyLazada\Exception\AuthorizationException;
use Onetech\EasyLazada\Exception\TokenException;

class AccessToken extends AbstractAccessToken
{

    private $app_key;
    private $app_secret;
    private $debug;
    private $sandbox;

    private $code;

    protected $cacheKey;
    protected $cacheRefreshKey;

    public function __construct($app_key, $app_secret, $debug = false, $sandbox = false)
    {
        $this->app_key = $app_key;
        $this->app_secret = $app_secret;
        $this->debug = $debug;
        $this->sandbox = $sandbox;

        $this->tokenJsonKey = 'access_token';
        $this->expiresJsonKey = 'expires_in';

        $this->cacheKey = 'lza-access::';
        $this->cacheRefreshKey = 'lza-refresh-access::';

        $this->setAppId($app_key);
        $this->setSecret($app_secret);
    }

    public function getDebug()
    {
        return $this->debug;
    }

    public function getSandbox()
    {
        return $this->sandbox;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * 用code交换access_token
     * @return mixed
     */
    public function getTokenFromServer()
    {
        return (new Api($this->app_key, $this->app_secret, $this->debug, $this->sandbox))->post('/auth/token/create', [
            'code' => $this->code
        ]);
    }

    /**
     * @param $result
     * @throws AuthorizationException
     */
    public function checkTokenResponse($result): void
    {
        if ('0' !== $result['code']) {
            throw new AuthorizationException($result['message']);
        }

        $this->setRefreshToken($result);
    }

    private function getCacheRefreshKey()
    {
        return $this->cacheRefreshKey . $this->appId;
    }

    public function setRefreshToken($result)
    {
        $refresh_token = $result['refresh_token'];
        $this->getCache()->save($this->getCacheRefreshKey(), $refresh_token, $result['refresh_expires_in']);

        return $this;
    }

    public function getRefreshToken(): string
    {
        return $this->getCache()->fetch($this->getCacheRefreshKey()) ?: '';
    }

    /**
     * 使用refresh_token去刷新access_token
     * @param string $refresh_token
     * @throws TokenException
     * @throws AuthorizationException
     */
    public function refresh(string $refresh_token = ''): string
    {

        if ($refresh_token === '') {
            //使用默认存储方式获取
            $refresh_token = $this->getRefreshToken();
            if (! $refresh_token) {
                throw new TokenException('refresh token not exist.');
            }
        }

        $response = (new Api($this->app_key, $this->app_secret, $this->debug, $this->sandbox))->post('/auth/token/refresh', [
            'refresh_token' => $refresh_token
        ]);

        $this->checkTokenResponse($response);

        $token = $response[$this->tokenJsonKey];
        $this->setToken(
            $token,
            $this->expiresJsonKey ? $response[$this->expiresJsonKey] : null
        );

        return $token;
    }

    public function delToken(): bool
    {
        return $this->getCache()->delete($this->getCacheKey());
    }

    public function delRefreshToken(): bool
    {
        return $this->getCache()->delete($this->getCacheRefreshKey());
    }

    public function tokenStats(): ?array
    {
        return $this->getCache()->getStats();
    }

}