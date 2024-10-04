<?php

namespace App\Service\Bloomreach\Customer;

use App\Service\Bloomreach\Common\Config;
use App\Service\Bloomreach\Common\RequestSenderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerService implements CustomerServiceInterface
{
    private const URL_ENDPOINT_PATTERN = '%s/track/v2/projects/%s/customers';

    public function __construct(
        private readonly Config $config,
        private readonly RequestSenderInterface $requestSender
    ) {}

    public function createCustomer(string $email): bool
    {
        $websiteId = 1;

        $options = $this->getOptions($email);

        $response = $this->requestSender
            ->execute(
                $this->getEndpoint($websiteId),
                Request::METHOD_POST,
                $options,
                $websiteId
            );

        return $response->getStatusCode() == Response::HTTP_OK;
    }

    private function getOptions(string $email): array
    {
        $options['customer_ids'] = [
            'email' => $email
        ];
        $options['properties'] = [
            'first_name' => 'test',
            'last_name' => 'test',
            'email' => $email
        ];

        return $options;
    }

    private function getEndpoint(int $websiteId): string
    {
        $token = $this->config->getProjectTokenId($websiteId);

        return sprintf(self::URL_ENDPOINT_PATTERN, Config::API_URL, $token);
    }
}
