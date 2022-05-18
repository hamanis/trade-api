<?php

namespace Mchekanov\TradeApi\Api\Models;

abstract class Model
{
    protected \Mchekanov\TradeApi\Api\HttpClient $httpClient;

    public function __construct(\Mchekanov\TradeApi\Api\HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
