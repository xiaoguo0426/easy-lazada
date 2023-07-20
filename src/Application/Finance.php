<?php

namespace Onetech\EasyLazada\Application;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Onetech\EasyLazada\Core\Api;

class Finance extends Api
{
    /**
     * 在提供的日期之后创建您的交易报表
     * @document https://open.lazada.com/apps/doc/api?path=/finance/payout/status/get
     * @param string $created_after
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function getPayoutStatus(string $created_after): array
    {
        $uri = 'finance/payout/status/get';

        $params = ['created_after' => $created_after];

        return $this->get($uri, $params);
    }

    /**
     * 获取指定时间段内的交易或费用详情
     * @document https://open.lazada.com/apps/doc/api?path=/finance/transaction/detail/get
     * @param string $start_time
     * @param string $end_time
     * @param string $trans_type
     * @param string $limit
     * @param string $offset
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function getTransactionDetails(string $start_time, string $end_time, string $trans_type, string $limit, string $offset): array
    {
        $uri = 'finance/transaction/detail/get';

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
     * @throws GuzzleException
     * @throws JsonException
     * @return array
     */
    public function queryTransactionDetails(string $start_time, string $end_time, string $trade_order_line_id, string $trans_type, string $trade_order_id, string $limit, string $offset): array
    {
        $uri = 'finance/transaction/details/get';

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