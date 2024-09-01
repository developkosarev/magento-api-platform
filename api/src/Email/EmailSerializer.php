<?php

namespace App\Email;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

readonly class EmailSerializer implements EmailSerializerInterface
{
    public function __construct(
        private SerializerInterface   $serializer,
        private EmailFactoryInterface $emailFactory
    ) {}

    public function serialize(EmailInterface $email): string
    {
        $properties = [
            'header' => 'email',
            'type' => $email->getEmailType()
        ];

        $body = [
            'email' => $email->getEmail(),
            'website_id' => $email->getWebsiteId(),
        ];

        $body = array_merge($body, $email->getBody());
        $data=  ['properties' => $properties, 'body' => $body];

        return $this->serializer->serialize($data, JsonEncoder::FORMAT);
    }

    public function deserialize(string $message): EmailInterface
    {
        $data = $this->serializer->deserialize($message, 'array', JsonEncoder::FORMAT);

        $type = $data['properties']['type'];

        $emailObj = $this->emailFactory->create($type);
        //$emailObj->addData($data['body']);

        return $emailObj;
    }
}
