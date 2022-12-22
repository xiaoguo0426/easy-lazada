<?php

namespace Onetech\EasyLazada\Oauth;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Hanson\Foundation\AbstractAPI;

class Api extends AbstractAPI
{

    /**
     * @var
     */
    private $region;

    /**
     * @var string
     */
    private $app_key;

    /**
     * @var string
     */
    private $app_secret;

    /**
     * @var string
     */
    private $sign_method;

    private $debug;

    private $sandbox;

    private $sdk_version = 'lazop-sdk-php-20180422';

    public const API_URL = 'https://api.lazada.com/rest';

    /**
     * @throws GuzzleException
     */

    public function __construct($region, $app_key, $app_secret, $debug, $sandbox)
    {
        $this->region = $region;
        $this->app_key = $app_key;
        $this->app_secret = $app_secret;
        $this->sign_method = 'sha256';

        $this->debug = $debug;
        $this->sandbox = $sandbox;
    }

    public function request(string $uri, string $method, $params)
    {

        $sysParams = [
            'app_key' => $this->app_key,
            'sign_method' => $this->sign_method,
            'timestamp' => $this->msectime(),
            'partner_id' => $this->sdk_version
        ];

        $url = self::API_URL . $uri . '?';

        $this->debug && $sysParams['debug'] = 'true';

        $sysParams['sign'] = $this->signature($uri, array_merge($params, $sysParams));

        foreach ($sysParams as $sysParamKey => $sysParamValue) {
            $url .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
        }
        unset($sysParams);

        $url = substr($url, 0, -1);

        $client = new HttpClient();

        if ($method === 'POST') {
            $res = $client->request('POST', $url, [
                'form_params' => $params
            ]);
        } else {
            $res = $client->get($url, $params);
        }
        return json_decode($res->getBody()->getContents(), true);
    }

    public function get($uri, $params)
    {
        return $this->request($uri, 'GET', $params);
    }

    public function post($uri, $params)
    {
        return $this->request($uri, 'POST', $params);
    }

    public function signature(string $uri, array $params): string
    {
        ksort($params);

        $stringToBeSigned = $uri;
        foreach ($params as $k => $v) {
            $stringToBeSigned .= "$k$v";
        }
        unset($k, $v);
        return strtoupper($this->hmac_sha256($stringToBeSigned, $this->app_secret));
    }

    private function hmac_sha256($data, $key)
    {
        return hash_hmac($this->sign_method, $data, $key);
    }

    private function msectime()
    {
        [$millisecond, $second] = explode(' ', microtime());
        return $second . '000';
    }
}