<?php

namespace App\Tests\Scheduler\Handler\Salesforce;

use App\Scheduler\Handler\Salesforce\LeadCustomerHandler;
use App\Scheduler\Message\Salesforce\LeadCustomer;
use App\Service\Salesforce\Customer\LeadCustomerServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LeadCustomerHandlerTest extends KernelTestCase
{
    public function testInvoke()
    {
        $leadCustomerHandler = new LeadCustomerHandler(
            $this->mockLeadCustomerService(),
            $this->mockLogger()
        );

        $leadCustomerHandler->__invoke(new LeadCustomer());

        $this->assertTrue(true);
    }

    private function mockLeadCustomerService(): LeadCustomerServiceInterface
    {
        $result = $this->createMock(LeadCustomerServiceInterface::class);
        $result->expects($this->any())
            ->method('populateCustomers')
            ->will($this->returnCallback(function($startDate, $endDate) {
                //var_dump($startDate);
                //var_dump($endDate);
            }));

        $result->expects($this->any())
            ->method('sendCustomers');

        return $result;
    }

    private function mockLogger(): LoggerInterface
    {
        $logger = $this->createMock(LoggerInterface::class);

        return $logger;
    }
}
