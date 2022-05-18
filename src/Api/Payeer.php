<?php

namespace Mchekanov\TradeApi\Api;

class Payeer
{
    const HOST = 'https://payeer.com';

    private array $errors = [];
    private array $authParams = [];

    private \GuzzleHttp\Client $httpClient;

    public function __construct(array $authParams = [])
    {
        $this->authParams = $authParams;
        $this->httpClient = new \GuzzleHttp\Client([
            'base_uri' => static::HOST
        ]);
    }

    private static function isSuccessResponse(array $response): bool
    {
        $isSuccess = $response['success'] === true;

        return $isSuccess;
    }

    private function getSignature(string $uriMethod, string $jsonBody): string
    {
        $signature = hash_hmac('sha256', $uriMethod . $jsonBody, $this->authParams['key']);

        return $signature;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function request(string $httpMethod, string $uriMethod, $body = null): array
    {
        $jsonBody = json_encode($body);
        $sign = $this->getSignature($uriMethod, $jsonBody);

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'API-ID' => $this->authParams['id'],
                'API-SIGN' => $sign
            ],
            'body' => $jsonBody,
        ];

        $response = $this->httpClient->request($httpMethod, 'api/trade/' . $uriMethod, $options);

        $jsonContent = $response->getBody()->getContents();
        $content = json_decode($jsonContent, true);

        if (!static::isSuccessResponse($content)) {
            $this->errors = $content['error'];

            throw new \Exception($content['error'], $content['error']['code']);
        }

        return $content;
    }


    public function GetError()
    {
        return $this->arError;
    }


    public function Info()
    {
        $response = $this->request('GET', 'info');

        return $response;
    }


    public function Orders($pair = 'BTC_USDT')
    {
        $body = ['pair' => $pair];

        $response = $this->request('POST', 'orders', $body);

        return $response['pairs'];
    }


    public function Account()
    {
        $timestamp = round(microtime(true) * 1000);
        $body = ['ts' => $timestamp];

        $response = $this->request('POST', 'account', $body);

        return $response['balances'];
    }


    public function OrderCreate($options = array())
    {
        $timestamp = round(microtime(true) * 1000);
        $body = array_merge($options, ['ts' => $timestamp]);

        $response = $this->request('POST', 'order_create', $body);

        return $response;
    }


    public function OrderStatus($options = array())
    {
        $timestamp = round(microtime(true) * 1000);
        $body = array_merge($options, ['ts' => $timestamp]);

        $response = $this->request('POST', 'order_status', $body);

        return $response['order'];
    }


    public function MyOrders($options = array())
    {
        $timestamp = round(microtime(true) * 1000);
        $body = array_merge($options, ['ts' => $timestamp]);

        $response = $this->request('POST', 'my_orders', $body);

        return $response['items'];
    }
}
