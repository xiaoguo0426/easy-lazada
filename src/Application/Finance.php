<?php

namespace Onetech\EasyLazada\Application;

use Onetech\EasyLazada\Core\Api;

class Finance extends Api
{
    /**
     * 在提供的日期之后创建您的交易报表
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=9&path=/finance/payout/status/get
     * @param string $created_after
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getPayoutStatus(string $created_after)
    {
        $uri = '/finance/payout/status/get';

        $params = ['created_after' => $created_after];

        return $this->get($uri, $params);
    }

    /**
     * 获取指定时间段内的交易或费用详情
     * @document https://open.lazada.com/doc/api.htm?spm=a2o9m.11193531.0.0.17216bbeoSj7y1#/api?cid=9&path=/finance/transaction/detail/get
     * @param string $start_time
     * @param string $end_time
     * @param string $trans_type
     * @param string $limit
     * @param string $offset
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getTransactionDetails(string $start_time, string $end_time, string $trans_type, string $limit, string $offset)
    {
        $uri = '/finance/transaction/detail/get';

        $params = [
            'trans_type' => $trans_type,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'limit' => $limit,
            'offset' => $offset,
        ];

        return $this->get($uri, $params);
    }

    /**
     * @param string $start_time
     * @param string $end_time
     * @param string $trade_order_line_id
     * @param string $trans_type
     * @param string $trade_order_id
     * @param string $limit
     * @param string $offset
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function queryTransactionDetails(string $start_time, string $end_time, string $trade_order_line_id, string $trans_type, string $trade_order_id, string $limit, string $offset)
    {
        $uri = '/finance/transaction/details/get';

        $params = [
            'trans_type' => $trans_type,
            'trade_order_id' => $trade_order_id,
            'trade_order_line_id' => $trade_order_line_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'limit' => $limit,
            'offset' => $offset
        ];

        return $this->get($uri, $params);
    }
}