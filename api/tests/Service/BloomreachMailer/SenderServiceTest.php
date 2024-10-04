<?php

namespace App\Tests\Service\BloomreachMailer;

use App\Email\Newsletter\SubscribeConfirm;
use App\Service\Bloomreach\Common\Config;
use App\Service\Bloomreach\Common\RequestSenderInterface;
use App\Service\BloomreachMailer\OptionsBuilder;
use App\Service\BloomreachMailer\SenderService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use GuzzleHttp\Psr7\Response;

class SenderServiceTest extends KernelTestCase
{
    private const EMAIL = 'test@test.test';
    private static Config $config;
    private static OptionsBuilder $optionBuilder;
    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        self::$config = $container->get(Config::class);
        self::$optionBuilder = $container->get(OptionsBuilder::class);
    }

    public function testSendEmail()
    {
        $response = new Response();

        $requestSenderInterface = $this->createMock(RequestSenderInterface::class);
        $requestSenderInterface->expects($this->any())
            ->method('execute')
            ->willReturn($response);

        $subscribeConfirm = new SubscribeConfirm();
        $subscribeConfirm
            ->setEmail(self::EMAIL)
            ->setConfirmCode(1)
            ->setWebsiteId(1)
            ->setStoreId(1)
            ->setLanguage('de');

        $senderService = new SenderService(self::$config, self::$optionBuilder, $requestSenderInterface);
        $result = $senderService->sendEmail($subscribeConfirm);

        $this->assertTrue($result);
    }
}
