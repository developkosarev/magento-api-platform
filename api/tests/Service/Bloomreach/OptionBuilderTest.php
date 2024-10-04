<?php

namespace App\Tests\Service\Bloomreach;

use App\Email\Newsletter\SubscribeConfirm;
use App\Service\BloomreachMailer\OptionsBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OptionBuilderTest extends KernelTestCase
{
    private const EMAIL = 'test@test.test';
    private static OptionsBuilder $optionBuilder;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        self::$optionBuilder = $container->get(OptionsBuilder::class);
    }

    public function testCreate()
    {
        $subscribeConfirm = new SubscribeConfirm();
        $subscribeConfirm
            ->setEmail(self::EMAIL)
            ->setConfirmCode(1)
            ->setWebsiteId(1)
            ->setStoreId(1)
            ->setLanguage('de');

        $result = self::$optionBuilder->create($subscribeConfirm, 1);

        $this->assertIsArray($result);
    }
}
