<?php

namespace App\Service\BloomreachMailer;

use App\Email\EmailInterface;

class OptionsBuilder
{
    public const SECTION_INTEGRATION_ID = 'integration_id';
    public const SECTION_EMAIL_CONTENT = 'email_content';
    public const SECTION_RECIPIENT = 'recipient';
    public const SECTION_CAMPAIGN_NAME = 'campaign_name';
    public const KEY_EMAIL_CONTENT_TEMPLATE_ID = 'template_id';
    public const KEY_EMAIL_CONTENT_PARAMS = 'params';
    public const KEY_EMAIL = 'email';
    public const KEY_CUSTOMER_IDS = 'customer_ids';

    private const CAMPAIGN_NAME = '[POC] Transactional Email';
    private array $options = [];

    public function __construct(private readonly Config $config){}

    public function create(EmailInterface $email, int $websiteId): array
    {
        $this->setIntegrationIdSection($websiteId);
        $this->setCampaignSection();
        $this->setEmailContentSection($email, $websiteId);
        $this->setRecipientSection($email);

        return $this->options;
    }

    private function setIntegrationIdSection(int $websiteId): void
    {
        $this->options[self::SECTION_INTEGRATION_ID] = $this->config->getEmailIntegrationId($websiteId);
    }

    private function setCampaignSection(): void
    {
        $this->options[self::SECTION_CAMPAIGN_NAME] = self::CAMPAIGN_NAME;
    }

    private function setEmailContentSection(EmailInterface $email, int $websiteId): void
    {
        $this->options[self::SECTION_EMAIL_CONTENT] = [
            self::KEY_EMAIL_CONTENT_TEMPLATE_ID =>
                $this->config->getEmailTemplateIdByType($email->getEmailType(), $websiteId),
            self::KEY_EMAIL_CONTENT_PARAMS => $email->getBody(),
        ];
    }

    private function setRecipientSection(EmailInterface $email): void
    {
        $this->options[self::SECTION_RECIPIENT] = [
            self::KEY_EMAIL => $email->getEmail(),
            self::KEY_CUSTOMER_IDS => [self::KEY_EMAIL => $email->getEmail()]
        ];
    }
}
