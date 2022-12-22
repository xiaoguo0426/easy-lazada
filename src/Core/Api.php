<?php

namespace Onetech\EasyLazada\Core;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Hanson\Foundation\AbstractAPI;
use Hanson\Foundation\Exception\HttpException;
use Onetech\EasyLazada\Marketplace;
use Onetech\EasyLazada\Oauth\AccessToken;

class Api extends AbstractAPI
{

    /**
     * @var string
     */
    private $app_key;

    /**
     * @var string
     */
    private $app_secret;

    /**
     * @var
     */
    private $access_token;

    /**
     * @var string
     */
    private $sign_method;

    private $debug;

    private $sandbox;

    private $sdk_version = 'lazop-sdk-php-20180422';

    private $domain;

    /**
     * @throws \Onetech\EasyLazada\Exception\InvalidArgumentException
     */
    public function __construct(string $region, AccessToken $accessToken)
    {
        $this->checkRegion($region);

        $this->app_key = $accessToken->getAppId();
        $this->app_secret = $accessToken->getSecret();
        $this->sign_method = 'sha256';
        $this->access_token = $accessToken->getToken();

        $this->debug = $accessToken->getDebug();
        $this->sandbox = $accessToken->getSandbox();
    }

    /**
     * @throws \Onetech\EasyLazada\Exception\InvalidArgumentException
     */
    private function checkRegion(string $region)
    {
        $this->domain = Marketplace::fromCountry($region)->url();
    }


    /**
     * @param string $uri
     * @param string $method
     * @param array $params
     * @param array $files
     * @throws GuzzleException
     * @throws \JsonException
     * @return array
     */
    private function request(string $uri, string $method, array $params, array $files): array
    {

        $sysParams = [
            'app_key' => $this->app_key,
            'access_token' => $this->access_token,
            'sign_method' => $this->sign_method,
            'timestamp' => $this->msectime(),
            'partner_id' => $this->sdk_version
        ];

        $sysParams['sign'] = $this->signature('/' . $uri, array_merge($params, $sysParams));

        $option = [];
        if ($method === 'POST') {
            $multipart = [];

            foreach (array_merge($params, $files) as $key => $param) {
                $multipart[] = [
                    'name' => $key,
                    'content' => $param
                ];
            }

            $option['multipart'] = $multipart;

            $build = $sysParams;
        } else {
            $build = array_merge($sysParams, $params);
        }
        $query = http_build_query($build);

        $client = new HttpClient([
            'base_uri' => $this->domain,
            'query' => $query,
            'headers' => [
                'User-Agent' => $this->sdk_version
            ]
        ]);
        $res = $client->request($method, $uri, $option);

        return json_decode($res->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param $uri
     * @param array $params
     * @throws GuzzleException
     * @throws \JsonException
     * @return array
     */
    protected function get($uri, array $params = []): array
    {
        return $this->request($uri, 'GET', $params, []);
    }

    /**
     * @param $uri
     * @param array $params
     * @throws GuzzleException
     * @throws \JsonException
     * @return array
     */
    protected function post($uri, array $params = []): array
    {
        return $this->request($uri, 'POST', $params, []);
    }

    /**
     * @param $uri
     * @param array $params
     * @throws GuzzleException
     * @throws \JsonException
     * @return array
     */
    protected function upload($uri, array $params): array
    {
        return $this->request($uri, 'POST', [], $params);
    }

    /**
     * @param string $uri
     * @param array $params
     * @return string
     */
    private function signature(string $uri, array $params): string
    {
        ksort($params);

        $stringToBeSigned = $uri;
        foreach ($params as $k => $v) {
            $stringToBeSigned .= "$k$v";
        }
        return strtoupper($this->hmac_sha256($stringToBeSigned, $this->app_secret));
    }

    /**
     * @param $data
     * @param $key
     * @return false|string
     */
    private function hmac_sha256($data, $key)
    {
        return hash_hmac($this->sign_method, $data, $key);
    }

    /**
     * @return string
     */
    private function msectime()
    {
        [$millisecond, $second] = explode(' ', microtime());
        return $second . '000';
    }

    public function middlewares()
    {

    }

    /**
     * @param $array
     * @return string
     */
    protected function array2string($array): string
    {
        return '[' . implode(',', $array) . ']';
    }
}