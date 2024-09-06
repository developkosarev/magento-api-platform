<?php

namespace App\Messenger;

use App\Message\ExternalEmail;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ExternalJsonMessengerSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        $bodyEnvelope = $encodedEnvelope['body'];
        //$headersEnvelope = $encodedEnvelope['headers'];

        $data = json_decode($bodyEnvelope, true);

        $properties = ['header' => $data['header'], 'type' => $data['type']];
        $body = json_decode($data['body'], true);

        $message = new ExternalEmail($properties, $body);

        return new Envelope($message);
    }

    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();
        //$stamps = $envelope->all();

        if (!($message instanceof ExternalEmail)) {
            throw new \Exception(sprintf('Serializer does not support message of type %s.', $message::class));
        }

        $data = [
            'header' => $message->getProperties()['header'],
            'type' => $message->getProperties()['type'],
            'body' => json_encode($message->getBody())
        ];

        return [
            'body' => json_encode($data),
            //'headers' => [
            //    'stamps' => serialize($stamps)
            //]
        ];

        //throw new \Exception('Transport & serializer not meant for sending messages');
    }
}
