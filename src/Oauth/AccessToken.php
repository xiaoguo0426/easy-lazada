<?php

namespace Onetech\EasyLazada\Oauth;

use GuzzleHttp\Exception\GuzzleException;
use Hanson\Foundation\AbstractAccessToken;
use Hanson\Foundation\Foundation;
use Onetech\EasyLazada\Exception\AuthorizationException;
use Onetech\EasyLazada\Exception\InvalidArgumentException;
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

        $this->setAppId($this->app_key);
        $this->setSecret($this->app_secret);

        $this->setCache($app->getConfig('cache'));

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

    public function setCode($code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * 获取token
     * @param false $forceRefresh
     * @throws AuthorizationException
     * @throws InvalidArgumentException
     * @throws TokenException
     * @throws GuzzleException
     * @return string|null
     */
    public function getToken($forceRefresh = false): ?string
    {
        if (true === $forceRefresh) {
            $result = $this->getTokenFromServer();

            $this->checkTokenResponse($result);

            $this->setToken(
                $token = $result[$this->tokenJsonKey],
                $this->expiresJsonKey ? $result[$this->expiresJsonKey] : null
            );

            return $token;
        }

        if (false === $forceRefresh) {
            $token = $this->getCache()->fetch($this->getCacheKey());
            if (empty($token)) {
                throw new TokenException("access_token doesn't exist");
            }
            return $token;
        }

        throw new InvalidArgumentException('Invalid Argument');
    }

    /**
     * 用code交换access_token
     * @throws GuzzleException
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

        $this->region = $result['country'];//重置region

        $this->setRefreshToken($result);
    }

    public function getCacheKey(): string
    {
        return 'lza-access::' . $this->app_key . '::' . $this->region;
    }

    private function getCacheRefreshKey(): string
    {
        return 'lza-refresh-access::' . $this->app_key . '::' . $this->region;
    }

    public function setRefreshToken($result): void
    {
        $refresh_token = $result['refresh_token'];
        $this->getCache()->save($this->getCacheRefreshKey(), $refresh_token, $result['refresh_expires_in']);
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
     * @throws GuzzleException
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

    public function checkToken(): bool
    {
        return (bool) $this->getCache()->fetch($this->getCacheKey());
    }

}