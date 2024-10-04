<?php

namespace App\Service\Bloomreach\Common;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;

class RequestSender implements RequestSenderInterface
{
    public const CONFIG_BASE_URI = 'base_uri';
    public const CONFIG_AUTH = 'auth';
    public const CONFIG_HEADERS = 'headers';
    public const OPTIONS_CONTENT_TYPE_JSON = 'json';

    private const STATUS_CODE_500 = 500;
    private const MAP_ERROR_MESSAGE_TO_CODE = [
        'curl error 28' => 504,
        'curl error 5' => 503,
        'curl error 6' => 502,
        'curl error 7' => 502
    ];

    public function __construct(
        private readonly Config $config,
        private readonly LoggerInterface $logger
    ){}

    public function execute(string $endpoint, string $requestType, array $options, int $websiteId): Response
    {
        $client = new Client(
            [
                self::CONFIG_BASE_URI => $endpoint,
                self::CONFIG_AUTH => $this->config->getAuthData($websiteId),
                self::CONFIG_HEADERS => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ]
        );

        try {
            $response = $client->post($endpoint, $this->getRequestOptions($options, $websiteId));
        } catch (ConnectException $e) {
            $this->logger->error($e->getMessage(), ['error' => $e]);
            $statusCode = $e->getCode() ?: $this->getErrorCode($e->getMessage());
            $response = $this->getResponse($statusCode, $e->getMessage());
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage(), ['error' => $e]);
            $response = $this->getResponse((int)$e->getCode(), $e->getMessage());
        }
        return $response;
    }

    private function getRequestOptions(array $params, int $websiteId): array
    {
        return [
            RequestOptions::TIMEOUT => 2.0,
            'json' => $params,
        ];
    }

    private function getResponse(int $statusCode, string $reason): Response
    {
        return new Response($statusCode, ['status' => $statusCode, 'reason' => $reason]);
    }

    private function getErrorCode(string $errorMessage): int
    {
        $errorMessage = strtolower($errorMessage);
        foreach (self::MAP_ERROR_MESSAGE_TO_CODE as $message => $statusCode) {
            if (preg_match('#' . $message . '#', $errorMessage)) {
                return $statusCode;
            }
        }
        return self::STATUS_CODE_500;
    }
}
