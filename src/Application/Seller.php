<?php

namespace Onetech\EasyLazada\Application;

use Onetech\EasyLazada\Core\Api;

class Seller extends Api
{
    /**
     * 查询这些客户是否关注该卖家
     * @document https://open.lazada.com/apps/doc/api?path=/shop/follow/status/batch/query
     * @param array $buyer_ids
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function batchQueryFollowStatus(array $buyer_ids)
    {
        $uri = 'shop/follow/status/batch/query';

        $params = [
            'buyer_ids' => $this->array2string($buyer_ids)
        ];

        return $this->get($uri, $params);
    }

    /**
     * 提供特定卖家的卖家多仓库地址数据，如仓库代码、仓库名称等
     * @document https://open.lazada.com/apps/doc/api?path=/seller/warehouse/get
     * @param array $addressTypes
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getMultiWarehouseBySeller(array $addressTypes)
    {
        $uri = 'seller/warehouse/get';

        $params = [
            'addressTypes' => $this->array2string($addressTypes)
        ];

        return $this->get($uri, $params);
    }

    /**
     * 返回所请求卖家的提货商店信息列表
     * @document https://open.lazada.com/apps/doc/api?path=/rc/store/list/get
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getPickUpStoreList()
    {
        $uri = 'rc/store/list/get';

        return $this->get($uri);
    }

    /**
     * 通过当前卖家 ID 获取卖家信息
     * @document https://open.lazada.com/apps/doc/api?path=/seller/get
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getSeller()
    {
        $uri = 'seller/get';

        return $this->get($uri);
    }

    /**
     * 提供特定卖家的卖家指标数据，如卖家好评、准时发货率等
     * @document https://open.lazada.com/apps/doc/api?path=/seller/metrics/get
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getSellerMetricsById()
    {
        $uri = 'seller/metrics/get';

        return $this->get($uri);
    }

    /**
     * 提供当前卖家的绩效指标，例如卖家好评、准时发货等
     * @document https://open.lazada.com/apps/doc/api?path=/seller/performance/get
     * @param string $language
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getSellerPerformance(string $language = 'en-US')
    {
        $uri = 'seller/performance/get';

        $params = [
            'language' => $language
        ];

        return $this->get($uri, $params);
    }

    /**
     * 获取卖家政策信息
     * https://open.lazada.com/apps/doc/api?path=/seller/policy/fetch
     * @param string $venture
     * @param string $locale
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getSellerPolicyFetch(string $venture, string $locale)
    {
        $uri = 'seller/policy/fetch';

        $params = [
            'venture' => $venture,
            'locale' => $locale,
        ];

        return $this->get($uri, $params);
    }

    /**
     * 使用此 API 更新拨打电话的卖家的电子邮件地址
     * @param string $payload
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function updateSeller(string $payload)
    {
        $uri = 'seller/update';

        $params = [
            'payload' => $payload
        ];

        return $this->get($uri, $params);
    }

    /**
     * 更新卖家账户下用户的电子邮件地址
     * @document https://open.lazada.com/apps/doc/api?path=/user/update
     * @param string $payload
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function updateUser(string $payload)
    {
        $uri = 'seller/update';

        $params = [
            'payload' => $payload
        ];

        return $this->get($uri, $params);
    }

    /**
     * 通过卖家id获取仓库
     * @document https://open.lazada.com/apps/doc/api?path=/rc/warehouse/get
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getWarehouseBySellerId()
    {
        $uri = 'rc/warehouse/get';

        return $this->get($uri);
    }

    /**
     * 根据卖家id查询仓库详细信息
     * @document https://open.lazada.com/apps/doc/api?path=/rc/warehouse/detail/get
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function queryWarehouseDetailInfoBySellerId()
    {
        $uri = 'rc/warehouse/detail/get';

        return $this->get($uri);
    }
}