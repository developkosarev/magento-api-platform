<?php

namespace App\Service\BloomreachMailer;

use App\Email\EmailInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OptionsBuilder
{
    public function __construct(
        private Config $config,
        private ConfigTemplate $configTempldate,
        private SerializerInterface $serializer,
    ){}

    /**
     * @throws \Exception
     */
    public function create(EmailInterface $email, int $websiteId): array
    {
        $options = [];
        $params = $this->serializer->normalize($email, null, ['groups' => 'params']);

        $options['integration_id'] = $this->config->getEmailIntegrationId($websiteId);
        $options['campaign_name'] = '[POC] Transactional Email';
        $options['email_content'] = [
            'template_id' => $this->configTempldate->getTemplate($email->getEmailType()),
            'params' => $params,
        ];
        $options['recipient'] = [
            'email' => $email->getEmail(),
            'customer_ids' => ['email' => $email->getEmail()],
            'language' => $email->getLanguage(),
        ];

        return $options;
    }
}
