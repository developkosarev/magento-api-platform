<?php

namespace App\Messenger;

use App\Message\Email;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ExternalMagentoJsonMessengerSerializer implements SerializerInterface
{
    //{
    //   "email_type":"NEWSLETTER_SUBSCRIBE_CONFIRM",
    //   "store_id":1
    //}

    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $data = json_decode($body, true);
        $message = new Email($data);

        return new Envelope($message);
    }

    public function encode(Envelope $envelope): array
    {
        return [];
        //throw new \Exception('Transport & serializer not meant for sending messages');
    }
}
