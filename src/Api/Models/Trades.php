<?php

namespace Mchekanov\TradeApi\Api\Models;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

class Trades extends Model
{
    /**
     * Получение истории сделок по указанным парам.
     *
     * @api {post} /trades
     *
     * @param array $options ['pair' => string]
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function list(array $options): array
    {
        $timestamp = round(microtime(true) * 1000);
        $body = ['ts' => $timestamp];

        return $this->httpClient->request('POST', 'trades', $body);
    }

    /**
     * Получение своих сделок с возможностью фильтрации и постраничной загрузки.
     *
     * @api {post} /my_trades
     *
     * @param array $options [
     *                           'pair' => string,
     *                           'action' => 'buy'|'sell',
     *                           'date_from' => string,
     *                           'date_to' => string,
     *                           'append' => string,
     *                           'limit'=> int
     *                       ]
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function myList(array $options): array
    {
        $timestamp = round(microtime(true) * 1000);
        $body = array_merge($options, ['ts' => $timestamp]);

        return $this->httpClient->request('POST', 'my_trades', $body);
    }
}
