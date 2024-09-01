<?php

namespace App\Tests\Email;

use App\Email\EmailSerializer;
use App\Email\Newsletter\SubscribeConfirm;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EmailSerializerTest extends KernelTestCase
{
    private const EMAIL = 'test@test.test';

    private static EmailSerializer $emailSerializer;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        self::$emailSerializer = $container->get(EmailSerializer::class);
    }


    public function testSubscribeConfirmSerialize()
    {
        $subscribeConfirm = new SubscribeConfirm();
        $subscribeConfirm
            ->setEmail(self::EMAIL)
            ->setWebsiteId(1)
            ->setStoreId(1);

        $result = self::$emailSerializer->serialize($subscribeConfirm);

        $body = '{"properties":{"header":"email","type":"NEWSLETTER_SUBSCRIBE_CONFIRM"},"body":{"email":"test@test.test","website_id":1}}';

        $this->assertEquals($body, $result);
    }

    //public function testSubscribeConfirmDeserialize()
    //{
    //    $body = '{"properties":{"header":"email","type":"NEWSLETTER_SUBSCRIBE_CONFIRM"},"body":{"email":"test@test.test","website_id":1}}';

    //    $result = self::$emailSerializer->deserialize($body);

    //    $this->assertEquals($body, $result);
    //}
}
