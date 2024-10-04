<?php

namespace App\Service\BloomreachMailer;

use App\Email\EmailInterface;
use App\Service\Bloomreach\Common\Config;
use App\Service\Bloomreach\Common\RequestSenderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SenderService implements SenderServiceInterface
{
    private const URL_ENDPOINT_PATTERN = '%s/email/v2/projects/%s/sync';

    public function __construct(
        private readonly Config $config,
        private readonly OptionsBuilder $optionsBuilder,
        private readonly RequestSenderInterface $requestSender
    ) {}

    public function sendEmail(EmailInterface $email): bool
    {
        $websiteId = $email->getWebsiteId();

        $response = $this->requestSender
            ->execute(
                $this->getEndpoint($websiteId),
                Request::METHOD_POST,
                $this->optionsBuilder->create($email, $websiteId),
                $websiteId
            );
        return $response->getStatusCode() == Response::HTTP_OK;
    }

    private function getEndpoint(int $websiteId): string
    {
        $token = $this->config->getProjectTokenId($websiteId);

        return sprintf(self::URL_ENDPOINT_PATTERN, Config::API_URL, $token);
    }
}
