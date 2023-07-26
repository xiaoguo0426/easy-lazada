<?php

namespace Onetech\EasyLazada\Core;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Handler\CurlHandler;
use Hanson\Foundation\AbstractAPI;
use JetBrains\PhpStorm\ArrayShape;
use JsonException;
use Onetech\EasyLazada\Exception\AuthorizationException;
use Onetech\EasyLazada\Exception\InvalidArgumentException;
use Onetech\EasyLazada\Exception\TokenException;
use Onetech\EasyLazada\Marketplace;
use Onetech\EasyLazada\Oauth\AccessToken;
use function GuzzleHttp\Promise\all;

class Api extends AbstractAPI
{

    /**
     * @var string
     */
    private string $app_key;

    /**
     * @var string
     */
    private string $app_secret;

    /**
     * @var string
     */
    private string $access_token;

    /**
     * @var string
     */
    private string $sign_method;

    private bool $debug;

    private bool $sandbox;

    private $sdk_version = 'lazop-sdk-php-20180422';

    private $domain;

    private HttpClient $client;
    private HttpClient $clientNormal;

    /**
     * Api constructor.
     * @param string $region
     * @param AccessToken $accessToken
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws AuthorizationException
     * @throws TokenException
     */
    public function __construct(string $region, AccessToken $accessToken)
    {
        $this->checkRegion($region);

        $this->app_key = (string) $accessToken->getAppId();
        $this->app_secret = (string) $accessToken->getSecret();
        $this->sign_method = 'sha256';
        $this->access_token = (string) $accessToken->getToken();

        $this->debug = $accessToken->getDebug();
        $this->sandbox = $accessToken->getSandbox();

        // 创建一个 HandlerStack，并启用 keep-alive 选项
        $handlerStack = HandlerStack::create(new CurlHandler());
        $handlerStack->setHandler(new CurlHandler());
        $handlerStack->push(function (callable $handler) {
            return function (Request $request, array $options) use ($handler) {
                // 添加 keep-alive 头部信息
                $options['headers']['Connection'] = 'keep-alive';
                return $handler($request, $options);
            };
        });

        $this->client = new HttpClient([
            'base_uri' => $this->domain,
            'headers' => [
                'User-Agent' => $this->sdk_version
            ],
            'handler' => $handlerStack,
        ]);

        $this->clientNormal = new HttpClient([
            'base_uri' => $this->domain,
            'headers' => [
                'User-Agent' => $this->sdk_version
            ],
        ]);
    }

    /**
     * @throws InvalidArgumentException
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
     * @return array
     */
    #[ArrayShape(['timeout' => "int", 'query' => "string", 'multipart' => "array"])]
    private function buildOption(string $uri, string $method, array $params, array $files): array
    {
        $sysParams = [
            'app_key' => $this->app_key,
            'access_token' => $this->access_token,
            'sign_method' => $this->sign_method,
            'timestamp' => $this->msectime(),
            'partner_id' => $this->sdk_version
        ];

        $sysParams['sign'] = $this->signature('/' . $uri, array_merge($params, $sysParams));

        $option = [
            'timeout' => 60, // 设置超时时间为 60 秒
        ];

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

        $option['query'] = $query;

        return $option;

    }

    /**
     * @param string $uri
     * @param string $method
     * @param array $params
     * @param array $files
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    private function request(string $uri, string $method, array $params, array $files): array
    {
        $option = $this->buildOption($uri, $method, $params, $files);

        $res = $this->client->request($method, $uri, $option);

        return json_decode($res->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param string $uri
     * @param string $method
     * @param array $params
     * @param array $files
     * @return PromiseInterface
     */
    private function requestAsync(string $uri, string $method, array $params, array $files): PromiseInterface
    {
        $option = $this->buildOption($uri, $method, $params, $files);
        return $this->clientNormal->requestAsync($method, $uri, $option);
    }

    /**
     * @param string $uri
     * @param array $params
     * @return PromiseInterface
     */
    public function getAsync(string $uri, array $params): PromiseInterface
    {
        return $this->requestAsync($uri, 'GET', $params, []);
    }

    /**
     * @param string $uri
     * @param array $params
     * @return PromiseInterface
     */
    public function postAsync(string $uri, array $params): PromiseInterface
    {
        return $this->requestAsync($uri, 'POST', $params, []);
    }

    /**
     * @param PromiseInterface[] $requests
     * @param callable $func
     */
    public function promise(array $requests, callable $func)
    {
        Utils::all($requests)->then(function ($responses) use ($func) {
            foreach ($responses as $key => $response) {
                // 处理响应结果
                $func(json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR));
            }
        })->wait();
    }

    /**
     * @param $uri
     * @param array $params
     * @throws GuzzleException
     * @throws JsonException
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
     * @throws JsonException
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
     * @throws JsonException
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
        return strtoupper($this->hmacSha256($stringToBeSigned, $this->app_secret));
    }

    /**
     * @param $data
     * @param $key
     * @return string
     */
    private function hmacSha256($data, $key): string
    {
        return (string) hash_hmac($this->sign_method, $data, $key);
    }

    /**
     * @return string
     */
    private function msectime(): string
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