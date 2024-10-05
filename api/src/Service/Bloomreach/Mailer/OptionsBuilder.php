<?php

namespace App\Service\Bloomreach\Mailer;

use App\Email\EmailInterface;
use App\Service\Bloomreach\Common\Config;
use App\Service\Bloomreach\Common\ConfigTemplate;
use Symfony\Component\Serializer\SerializerInterface;

readonly class OptionsBuilder
{
    public function __construct(
        private Config              $config,
        private ConfigTemplate      $configTemplate,
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
            'template_id' => $this->configTemplate->getTemplate($email->getEmailType()),
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
