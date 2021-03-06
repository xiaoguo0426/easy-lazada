<?php

namespace Onetech\EasyLazada\Application;

use Onetech\EasyLazada\Core\Api;

class Order extends Api
{

    /**
     * 获取指定订单详情
     * @document  https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=8&path=/order/get
     * @param $order_id
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getOrder($order_id)
    {
        $uri = '/order/get';

        $params = ['order_id' => $order_id];

        return $this->get($uri, $params);
    }

    /**
     * 获取多个订单详情
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=8&path=/orders/get
     * @param $params
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getOrders($params)
    {
        $uri = '/orders/get';

        return $this->get($uri, $params);
    }

    /**
     * 获取指定订单商品列表
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=8&path=/order/items/get
     * @param $order_id
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getOrderItems($order_id)
    {
        $uri = '/order/items/get';

        $params = ['order_id' => $order_id];

        return $this->get($uri, $params);
    }

    /**
     * 获取多个订单商品列表
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=8&path=/orders/items/get
     * @param array $order_ids 订单id集合
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getMultipleOrderItems(array $order_ids)
    {
        $uri = '/orders/items/get';

        $params = ['order_ids' => $this->array2string($order_ids)];

        return $this->get($uri, $params);
    }

    /**
     * 标记订单商品已打包
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=8&path=/order/pack
     * @param string $shipping_provider
     * @param array $order_item_ids
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function setStatusToPackedByMarketplace(string $shipping_provider, array $order_item_ids)
    {
        $uri = '/order/pack';

        $params = [
            'shipping_provider' => $shipping_provider,
            'delivery_type' => 'dropship',//only support dropship
            'order_item_ids' => $this->array2string($order_item_ids)
        ];

        return $this->post($uri, $params);
    }

    /**
     * 标记订单商品为可以发货
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=8&path=/order/rts
     * @param string $delivery_type
     * @param array $order_item_ids
     * @param string $shipment_provider
     * @param string $tracking_number
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function setStatusToReadyToShip(string $delivery_type, array $order_item_ids, string $shipment_provider, string $tracking_number)
    {
        $uri = '/order/rts';

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
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=8&path=/order/cancel
     * @param int $order_item_id Order item ID. Mandatory
     * @param int $reason_id ID of the cancel reason.
     * @param string $reason_detail Reason detail. Optional
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function setStatusToCanceled(int $order_item_id, int $reason_id, string $reason_detail)
    {
        $uri = '/order/cancel';

        $params = [
            'reason_detail' => $reason_detail,
            'reason_id' => $reason_id,
            'order_item_id' => $order_item_id
        ];

        return $this->post($uri, $params);
    }

    /**
     * 检索与订单相关的文档，包括发票和运输标签
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=8&path=/order/document/get
     * @param string $doc_type invoice,shippingLabel,carrierManifest
     * @param array $order_item_ids
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getDocument(string $doc_type, array $order_item_ids)
    {
        $uri = '/order/document/get';

        $params = [
            'doc_type' => $doc_type,
            'order_item_ids' => $this->array2string($order_item_ids)
        ];

        return $this->get($uri, $params);
    }

    /**
     * 检索与订单相关的文档，仅用于运输标签
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=8&path=/order/document/awb/html/get
     * @param array $order_item_ids
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getAwbDocumentHtml(array $order_item_ids)
    {
        $uri = '/order/document/awb/html/get';

        $params = [
            'order_item_ids' => $this->array2string($order_item_ids)
        ];

        return $this->get($uri, $params);
    }

    /**
     * 设置指定订单的发票编号
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=8&path=/order/invoice_number/set
     * @param int $order_item_id
     * @param string $invoice_number
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function setInvoiceNumber(int $order_item_id, string $invoice_number)
    {
        $uri = '/order/invoice_number/set';

        $params = [
            'order_item_id' => $order_item_id,
            'invoice_number' => $invoice_number
        ];

        return $this->post($uri, $params);
    }
}