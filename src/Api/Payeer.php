<?php

namespace Mchekanov\TradeApi\Api;

class Payeer
{
    private HttpClient $httpClient;

    public function __construct(array $credentials = [])
    {
        $this->httpClient = new HttpClient($credentials);
    }

    public function getHttpClientError(): array
    {
        return $this->httpClient->getErrors();
    }

    public function order(): Models\Order
    {
        return new Models\Order($this->httpClient);
    }

    public function info(): Models\Info
    {
        return new Models\Info($this->httpClient);
    }

    public function account(): Models\Account
    {
        return new Models\Account($this->httpClient);
    }
}
