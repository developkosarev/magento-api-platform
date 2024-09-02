<?php

namespace App\Messenger;

use App\Message\ExternalEmail;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ExternalJsonMessengerSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        $properties = $encodedEnvelope['properties'];
        $body = $encodedEnvelope['body'];
        $data = json_decode($body, true);
        $message = new ExternalEmail($properties, $data);

        return new Envelope($message);
    }

    public function encode(Envelope $envelope): array
    {
        throw new \Exception('Transport & serializer not meant for sending messages');
    }
}
