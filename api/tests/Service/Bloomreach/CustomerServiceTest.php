<?php

namespace App\Tests\Service\Bloomreach;

use App\Service\Bloomreach\Common\RequestSenderInterface;
use App\Service\Bloomreach\Common\Config;
use App\Service\Bloomreach\Customer\CustomerService;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomerServiceTest extends KernelTestCase
{
    private const EMAIL = 'test@test.test';

    private static Config $config;
    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        self::$config = $container->get(Config::class);
    }

    public function testSendEmail()
    {
        $response = new Response();

        $requestSenderInterface = $this->createMock(RequestSenderInterface::class);
        $requestSenderInterface->expects($this->any())
            ->method('execute')
            ->willReturn($response);

        $senderService = new CustomerService(self::$config, $requestSenderInterface);
        $result = $senderService->createCustomer(self::EMAIL);

        $this->assertTrue($result);
    }
}
