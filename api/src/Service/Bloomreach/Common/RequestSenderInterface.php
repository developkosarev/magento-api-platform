<?php

declare(strict_types=1);

namespace App\Service\Bloomreach\Common;

use GuzzleHttp\Psr7\Response;

interface RequestSenderInterface
{
    public function execute(string $endpoint, string $requestType, array $options, int $websiteId): Response;
}
