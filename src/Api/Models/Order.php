<?php

namespace Mchekanov\TradeApi\Api\Models;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

class Order extends Model
{
    /**
     * Получение доступных ордеров по указанным парам.
     *
     * @api {post} /orders
     *
     * @param array $pair ['pair' => string]
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function list(array $pair = ['pair' => 'BTC_USDT']): array
    {
        return $this->httpClient->request('POST', 'orders', $pair);
    }

    /**
     * Создание ордера поддерживаемых типов: лимит, маркет, стоп-лимит.
     *
     * @api {post} /order_create
     *
     * @param array $options [
     *                           'pair' => string,
     *                           'type' => 'limit'|'market'|'stop_limit',
     *                           'action' => string,
     *                           'amount' => int,
     *                           'price' => float,
     *                           'stop_price' => float
     *                       ]
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function create(array $options): array
    {
        $timestamp = round(microtime(true) * 1000);
        $body = array_merge($options, ['ts' => $timestamp]);

        return $this->httpClient->request('POST', 'order_create', $body);
    }

    /**
     * Получение подробной информации о своем ордере по его id.
     *
     * @api {post} /order_status
     *
     * @param array $options ['order_id' => string]
     *
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function status(array $options): array
    {
        $timestamp = round(microtime(true) * 1000);
        $body = array_merge($options, ['ts' => $timestamp]);

        return $this->httpClient->request('POST', 'order_status', $body);
    }

    /**
     * Отмена своего ордера по его id.
     *
     * @api {post} /order_cancel
     *
     * @param array $options ['order_id' => string]
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function cancel(array $options): array
    {
        $timestamp = round(microtime(true) * 1000);
        $body = array_merge($options, ['ts' => $timestamp]);

        return $this->httpClient->request('POST', 'order_cancel', $body);
    }

    /**
     * Отмена всех/части своих ордеров.
     *
     * @api {post} /order_cancel
     *
     * @param array $options ['pair' => string, 'action' => 'buy'|'sell']
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function cancelMany(array $options = []): array
    {
        $timestamp = round(microtime(true) * 1000);
        $body = array_merge($options, ['ts' => $timestamp]);

        return $this->httpClient->request('POST', 'order_cancel', $body);
    }

    /**
     * Получение своих открытых ордеров с возможностью фильтрации.
     *
     * @api {post} /my_orders
     *
     * @param array $options ['pair' => string, 'action' => 'buy'|'sell']
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function myList(array $options = []): array
    {
        $timestamp = round(microtime(true) * 1000);
        $body = array_merge($options, ['ts' => $timestamp]);

        return $this->httpClient->request('POST', 'my_orders', $body);
    }

    /**
     * Получение истории своих ордеров с возможностью фильтрации и постраничной загрузки.
     *
     * @api {post} /my_history
     *
     * @param array $options [
     *                           'pair' => string,
     *                           'action' => 'buy'|'sell',
     *                           'status' => 'success'|'processing'|'waiting'|'canceled',
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
    public function myHistory(array $options = []): array
    {
        $timestamp = round(microtime(true) * 1000);
        $body = array_merge($options, ['ts' => $timestamp]);

        return $this->httpClient->request('POST', 'my_history', $body);
    }
}
