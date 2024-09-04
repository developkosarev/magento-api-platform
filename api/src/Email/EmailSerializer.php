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
        $body = $this->serializer->normalize($email, null, ['groups' => 'body']);
        $data = ['properties' => $properties, 'body' => $body];

        return $this->serializer->serialize($data, JsonEncoder::FORMAT);
    }

    public function deserialize(string $message): EmailInterface
    {
        //$data = $this->serializer->deserialize($message, 'array', JsonEncoder::FORMAT);
        $data = json_decode($message, true);

        $properties = $data['properties'];
        $body = $data['body'];

        $emailObj = $this->emailFactory->create($properties['type']);
        //$emailObj = $this->serializer->denormalize($body, SubscribeConfirm::class);
        $emailObj = $this->serializer->denormalize($body, get_class($emailObj));

        return $emailObj;
    }
}
