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
        //‘“{\“properties\“:{\“header\“:\“email\“,\“type\“:\“NEWSLETTER_SUBSCRIBE_CONFIRM\“},\“body\“:{\“email\“:\“xx.yy@gmail.com\“,\“website_id\“:1,\“store_id\“:1,\“confirm_code\“:\“xxx\“,\“base_url\“:\“https:\\\/\\\/dev9.test.test\\\/\“,\“store_name\“:\“German\“,\“customer_name\“:\“\”}}“’

        $encodedEnvelope = [
            'properties' => [],
            'body' => '{"properties":
                        {"header":"email","type":"NEWSLETTER_SUBSCRIBE_CONFIRM"},
                        "body":
                        {"email":"xx.yy@gmail.com","website_id":1,"store_id":1,"confirm_code":"xxx","base_url":"URL","store_name":"German","customer_name":"name"}}'
        ];

        //array(2) {
        //["body"]=>
        //  string(184) "{"properties":"{\"header\":\"email\",\"type\":\"NEWSLETTER_SUBSCRIBE_CONFIRM\"}","body":"{\"confirmCode\":\"1\",\"email\":\"develop.kosarev@gmail.com\",\"websiteId\":1,\"storeId\":1}"}"
        //  ["headers"]=>
        //  array(0) {
        //  }
        //}

        $encodedEnvelope = [
           'body' => '',
           'header' => []
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
