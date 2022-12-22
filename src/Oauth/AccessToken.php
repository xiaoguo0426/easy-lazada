<?php

namespace Onetech\EasyLazada\Oauth;

use Hanson\Foundation\AbstractAccessToken;
use Hanson\Foundation\Foundation;
use Onetech\EasyLazada\Exception\AuthorizationException;
use Onetech\EasyLazada\Exception\TokenException;

class AccessToken extends AbstractAccessToken
{
    private string $region;
    private string $app_key;
    private string $app_secret;
    private bool $debug;
    private bool $sandbox;

    private string $code;

    protected $cacheKey;
    protected string $cacheRefreshKey;

    public function __construct(Foundation $app)
    {
        $this->region = $app->getConfig('region') ?? '';
        $this->app_key = $app->getConfig('app_key') ?? '';
        $this->app_secret = $app->getConfig('app_secret') ?? '';
        $this->debug = $app->getConfig('debug') ?? false;
        $this->sandbox = $app->getConfig('sandbox') ?? false;

        $this->tokenJsonKey = 'access_token';
        $this->expiresJsonKey = 'expires_in';

        $this->cacheKey = 'lza-access::' . $this->app_key . '::';
        $this->cacheRefreshKey = 'lza-refresh-access::' . $this->app_key . '::';

        $this->setAppId($this->app_key);
        $this->setSecret($this->app_secret);

        parent::__construct($app);
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getTokenFromServer(): array
    {
        return (new Api($this->region, $this->app_key, $this->app_secret, $this->debug, $this->sandbox))->post('/auth/token/create', [
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

    private function getCacheRefreshKey(): string
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
     * @throws AuthorizationException
     * @throws TokenException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return string
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

        $response = (new Api($this->region, $this->app_key, $this->app_secret, $this->debug, $this->sandbox))->post('/auth/token/refresh', [
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