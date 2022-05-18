<?php

namespace Mchekanov\TradeApi\Api\Models;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

class Info extends Model
{
    /**
     * Проверка соединения, получение времени сервера.
     *
     * @api {get} /time
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function time(): array
    {
        return $this->httpClient->request('GET', 'time');
    }

    /**
     * Получение лимитов, доступных пар и их параметров.
     *
     * @api {get|post} /info
     *
     * @param array|null $options [pair => string]
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function info(array $options = null): array
    {
        $httpMethod = $options === null ? 'GET' : 'POST';

        return $this->httpClient->request($httpMethod, 'info', $options);
    }

    /**
     * Получение статистики цен и их колебания за последние 24 часа.
     *
     * @api {get|post} /ticker
     *
     * @param array|null $options [pair => string]
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function ticker(array $options = null): array
    {
        $httpMethod = $options === null ? 'GET' : 'POST';

        return $this->httpClient->request($httpMethod, 'ticker', $options);
    }

    /**
     * Получение баланса пользователя.
     *
     * @api {post} /account
     *
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function balance(): array
    {
        $timestamp = round(microtime(true) * 1000);
        $body = ['ts' => $timestamp];

        return $this->httpClient->request('POST', 'account', $body);
    }
}
