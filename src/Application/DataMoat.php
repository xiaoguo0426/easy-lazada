<?php

namespace Onetech\EasyLazada\Application;

use Onetech\EasyLazada\Core\Api;

class DataMoat extends Api
{
    /**
     *
     * @param string $time
     * @param string $appName
     * @param string $userIp
     * @param string $ati
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function computeRisk(string $time, string $appName, string $userIp, string $ati)
    {
        $uri = '/datamoat/compute_risk';

        $params = [
            'time' => $time,
            'appName' => $appName,
            'userIp' => $userIp,
            'ati' => $ati
        ];

        return $this->post($uri, $params);
    }

    /**
     * 请注意，目前所有区域都必须使用域“api.lazada.com”来调用此 API。该API用于访问敏感数据过程中需要的DataMoat Account Security Service。
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=15&path=/datamoat/login
     * @param string $time
     * @param string $appName
     * @param string $userIp
     * @param string $ati
     * @param string $loginResult
     * @param string $loginMessage
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function login(string $time, string $appName, string $userIp, string $ati, string $loginResult, string $loginMessage)
    {
        $uri = '/datamoat/login';

        $params = [
            'time' => $time,
            'appName' => $appName,
            'userIp' => $userIp,
            'ati' => $ati,
            'loginResult' => $loginResult,
            'loginMessage' => $loginMessage
        ];

        return $this->post($uri, $params);
    }

}