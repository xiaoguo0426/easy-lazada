<?php

namespace Onetech\EasyLazada\Application;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Onetech\EasyLazada\Core\Api;

class Order extends Api
{

    /**
     * 获取指定订单详情
     * @document  https://open.lazada.com/apps/doc/api?path=/order/get
     * @param $order_id
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function getOrder($order_id): array
    {
        $uri = 'order/get';

        $params = ['order_id' => $order_id];

        return $this->get($uri, $params);
    }

    /**
     * 获取多个订单详情
     * @document https://open.lazada.com/apps/doc/api?path=/orders/get
     * @param $params
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function getOrders($params): array
    {
        $uri = 'orders/get';

        return $this->get($uri, $params);
    }

    /**
     * 获取指定订单商品列表
     * @document https://open.lazada.com/apps/doc/api?path=/order/items/get
     * @param $order_id
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function getOrderItems($order_id): array
    {
        $uri = 'order/items/get';

        $params = ['order_id' => $order_id];

        return $this->get($uri, $params);
    }

    /**
     * 获取多个订单商品列表
     * @document https://open.lazada.com/apps/doc/api?path=/orders/items/get
     * @param array $order_ids
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function getMultipleOrderItems(array $order_ids): array
    {
        $uri = 'orders/items/get';

        $params = ['order_ids' => $this->array2string($order_ids)];

        return $this->get($uri, $params);
    }

    /**
     * 标记订单商品已打包
     * @document https://open.lazada.com/apps/doc/api?path=/order/pack
     * @param string $shipping_provider
     * @param array $order_item_ids
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function setStatusToPackedByMarketplace(string $shipping_provider, array $order_item_ids): array
    {
        $uri = 'order/pack';

        $params = [
            'shipping_provider' => $shipping_provider,
            'delivery_type' => 'dropship',//only support dropship
            'order_item_ids' => $this->array2string($order_item_ids)
        ];

        return $this->post($uri, $params);
    }

    /**
     * 标记订单商品为可以发货
     * @document https://open.lazada.com/apps/doc/api?path=/order/rts
     * @param string $delivery_type
     * @param array $order_item_ids
     * @param string $shipment_provider
     * @param string $tracking_number
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function setStatusToReadyToShip(string $delivery_type, array $order_item_ids, string $shipment_provider, string $tracking_number): array
    {
        $uri = 'order/rts';

        $params = [
            'delivery_type' => $delivery_type,
            'order_item_ids' => $this->array2string($order_item_ids),
            'shipment_provider' => $shipment_provider,
            'tracking_number' => $tracking_number,
        ];

        return $this->post($uri, $params);
    }

    /**
     * 取消单个订单项目
     * @document https://open.lazada.com/apps/doc/api?path=/order/cancel
     * @param int $order_item_id
     * @param int $reason_id
     * @param string $reason_detail
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function setStatusToCanceled(int $order_item_id, int $reason_id, string $reason_detail): array
    {
        $uri = 'order/cancel';

        $params = [
            'reason_detail' => $reason_detail,
            'reason_id' => $reason_id,
            'order_item_id' => $order_item_id
        ];

        return $this->post($uri, $params);
    }

    /**
     * 检索与订单相关的文档，包括发票和运输标签
     * @document https://open.lazada.com/apps/doc/api?path=/order/document/get
     * @param string $doc_type
     * @param array $order_item_ids
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function getDocument(string $doc_type, array $order_item_ids): array
    {
        $uri = 'order/document/get';

        $params = [
            'doc_type' => $doc_type,
            'order_item_ids' => $this->array2string($order_item_ids)
        ];

        return $this->get($uri, $params);
    }

    /**
     * 检索与订单相关的文档，仅用于运输标签
     * @document https://open.lazada.com/apps/doc/api?path=/order/document/awb/html/get
     * @param array $order_item_ids
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function getAwbDocumentHtml(array $order_item_ids): array
    {
        $uri = 'order/document/awb/html/get';

        $params = [
            'order_item_ids' => $this->array2string($order_item_ids)
        ];

        return $this->get($uri, $params);
    }

    /**
     * @param array $order_item_ids
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function getAwbDocumentPDF(array $order_item_ids)
    {
        $uri = 'order/document/awb/pdf/get';

        $params = [
            'order_item_ids' => $this->array2string($order_item_ids)
        ];

        return $this->get($uri, $params);
    }

    /**
     * 设置指定订单的发票编号
     * @document https://open.lazada.com/apps/doc/api?path=/order/invoice_number/set
     * @param int $order_item_id
     * @param string $invoice_number
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function setInvoiceNumber(int $order_item_id, string $invoice_number): array
    {
        $uri = 'order/invoice_number/set';

        $params = [
            'order_item_id' => $order_item_id,
            'invoice_number' => $invoice_number
        ];

        return $this->post($uri, $params);
    }

    /**
     * 卖家可以通过此API查看订单是否可以取消，如果不能，则获取相应的原因。
     * @document https://open.lazada.com/apps/doc/api?path=%2Forder%2Freverse%2Fcancel%2Fvalidate
     * @param string $order_id
     * @param array $order_item_id_list
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function orderCancelValidate(string $order_id, array $order_item_id_list): array
    {
        $uri = 'order/reverse/cancel/validate';

        $params = [
            'order_id' => $order_id,
            'order_item_id_list' => $order_item_id_list
        ];

        return $this->get($uri, $params);
    }
}