<?php

namespace Mchekanov\TradeApi\Api;

use Exception;
use \GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HttpClient
{
    private const HOST = 'https://payeer.com';

    private array $errors = [];
    private array $credentials;

    private Client $httpClient;

    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
        $this->httpClient = new Client([
            'base_uri' => static::HOST
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function request(string $httpMethod, string $uriMethod, $body = null): array
    {
        $jsonBody = json_encode($body);
        $sign = $this->getSignature($uriMethod, $jsonBody);

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'API-ID' => $this->credentials['id'],
                'API-SIGN' => $sign
            ],
            'body' => $jsonBody,
        ];

        $response = $this->httpClient->request($httpMethod, 'api/trade/' . $uriMethod, $options);

        $jsonContent = $response->getBody()->getContents();
        $content = json_decode($jsonContent, true);

        if (!static::isSuccessResponse($content)) {
            $this->errors = $content['error'];

            throw new Exception($content['error'], $content['error']['code']);
        }

        return $content;
    }

    private static function isSuccessResponse(array $response): bool
    {
        return $response['success'] === true;
    }

    private function getSignature(string $uriMethod, string $jsonBody): string
    {
        return hash_hmac('sha256', $uriMethod . $jsonBody, $this->credentials['key']);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
