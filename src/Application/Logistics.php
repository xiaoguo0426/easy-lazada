<?php

namespace Onetech\EasyLazada\Application;

use Onetech\EasyLazada\Core\Api;

class Logistics extends Api
{
    /**
     * 使用卖家 ID、订单 ID 和区域信息查询卖家 erp 的物流详情
     * @document https://open.lazada.com/apps/doc/api?path=/logistic/order/trace
     * @param string $order_id
     * @param string $locale
     * @param array $ofcPackageIdList
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @return mixed
     */
    public function getOrderTrace(string $order_id, string $locale, array $ofcPackageIdList)
    {
        $uri = 'logistic/order/trace';

        $params = [
            'order_id' => $order_id,
            'locale' => $locale,
            'ofcPackageIdList' => $this->array2string($ofcPackageIdList),
        ];

        return $this->get($uri, $params);
    }

    /**
     * 获取所有活跃的运输提供商的列表，在使用 SetStatusToPackedByMarketplace API 时需要此列表
     * @document https://open.lazada.com/apps/doc/api?path=/shipment/providers/get
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getShipmentProviders()
    {
        $uri = 'shipment/providers/get';

        return $this->get($uri);
    }
}