<?php

namespace App\Service\BloomreachMailer;

use App\Email\EmailInterface;

class OptionsBuilder
{
    public function __construct(private readonly Config $config){}

    public function create(EmailInterface $email, int $websiteId): array
    {
        $options = [];

        $options['integration_id'] = $this->config->getEmailIntegrationId($websiteId);
        $options['campaign_name'] = '[POC] Transactional Email';
        $options['email_content'] = [
            'template_id' => $this->config->getEmailTemplateIdByType($email->getEmailType(), $websiteId),
            'params' => [],
        ];
        $options['recipient'] = [
            'email' => $email->getEmail(),
            'customer_ids' => ['email' => $email->getEmail()]
        ];

        return $options;
    }
}
