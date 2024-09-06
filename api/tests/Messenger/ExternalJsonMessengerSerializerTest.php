<?php

namespace App\Tests\Messenger;

use App\Message\ExternalEmail;
use App\Messenger\ExternalJsonMessengerSerializer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;

class ExternalJsonMessengerSerializerTest extends KernelTestCase
{
    private const EMAIL = 'test@test.test';

    private static ExternalJsonMessengerSerializer $serializer;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        self::$serializer = $container->get(ExternalJsonMessengerSerializer::class);
    }

    public function testDecode()
    {
        //{"header":"email","type":"NEWSLETTER_SUBSCRIBE_CONFIRM","body":"{\"email\":\"xxx.yyy+test3@test.de\",\"website_id\":1,\"language\":\"de\",\"store_id\":1,\"confirm_code\":\"l6hv5igvlzzv1t35qo5egpdq91uedryx\",\"base_url\":\"https:\\\/\\\/s.de.ddev.site\\\/\",\"store_name\":\"German\",\"customer_name\":\"\",\"confirm_url\":\"https:\\\/\\\/s.de.ddev.site\\\/newsletter\\\/subscriber\\\/confirm\\\/?code=l6hv5igvlzzv1t35qo5egpdq91uedryx\"}"}

        $encodedEnvelope = [
            'body' => '{"header":"email","type":"NEWSLETTER_SUBSCRIBE_CONFIRM","body":"{\"email\":\"xxx.yyy+test3@test.de\",\"website_id\":1,\"language\":\"de\",\"store_id\":1,\"confirm_code\":\"l6hv5igvlzzv1t35qo5egpdq91uedryx\",\"base_url\":\"https:\\\/\\\/s.de.ddev.site\\\/\",\"store_name\":\"German\",\"customer_name\":\"\",\"confirm_url\":\"https:\\\/\\\/s.de.ddev.site\\\/newsletter\\\/subscriber\\\/confirm\\\/?code=l6hv5igvlzzv1t35qo5egpdq91uedryx\"}"}'
        ];

        $result = self::$serializer->decode($encodedEnvelope);

        $this->assertInstanceOf(Envelope::class, $result);
    }

    public function testEncode()
    {
        $properties = ['header' => 'email', 'type' => 'NEWSLETTER_SUBSCRIBE_CONFIRM'];
        $data = ['email' => 'xx.yy@gmail.com'];

        $message = new ExternalEmail($properties, $data);

        $result = self::$serializer->encode(new Envelope($message));
        $this->assertIsArray($result);
    }
}
