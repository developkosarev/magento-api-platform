<?php

namespace App\Service\BloomreachMailer;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;

class RequestSender implements RequestSenderInterface
{
    private const STATUS_CODE_500 = 500;
    private const MAP_ERROR_MESSAGE_TO_CODE = [
        'curl error 28' => 504,
        'curl error 5' => 503,
        'curl error 6' => 502,
        'curl error 7' => 502
    ];

    private ClientFactoryInterface $clientFactory;
    private ResponseFactory $responseFactory;

    public function __construct(
        private readonly Config $config,
        private readonly LoggerInterface $logger,
        ClientFactoryInterface $clientFactory,
        ResponseFactory $responseFactory
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
    }

    public function execute(string $endpoint, string $requestType, array $options, int $websiteId): Response
    {
        try {
            $client = $this->clientFactory->create($endpoint, $websiteId);
            $response = $client->request(
                $requestType,
                $client->getConfig(ClientFactoryInterface::CONFIG_BASE_URI),
                $this->getRequestOptions($options, $websiteId)
            );
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
            RequestOptions::TIMEOUT => $this->config->getRequestTimeout($websiteId),
            ClientFactoryInterface::OPTIONS_CONTENT_TYPE_JSON => $params,
        ];
    }

    private function getResponse(int $statusCode, string $reason): Response
    {
        return $this->responseFactory->create(
            [
                'status' => $statusCode,
                'reason' => $reason
            ]
        );
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
