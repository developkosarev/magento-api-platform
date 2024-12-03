<?php

namespace App\Scheduler\Handler\Salesforce;

use App\Scheduler\Message\Salesforce\LeadCustomer;
use App\Service\Salesforce\Customer\LeadCustomerServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Psr\Log\LoggerInterface;

#[AsMessageHandler]
final class LeadCustomerHandler
{
    public function __construct(
        private readonly LeadCustomerServiceInterface $leadCustomerService,
        private readonly LoggerInterface $logger
    )
    {
    }
    public function __invoke(LeadCustomer $message)
    {
        //Current month
        $startDate = \DateTime::createFromFormat('Y-m-d', date('Y-m-01'))
            ->setTime(0, 0);
        $endDate = \DateTime::createFromFormat('Y-m-d', date("Y-m-01", strtotime('+1 month')))
            ->setTime(0, 0);

        //https://unicode-explorer.com/emoji/brown-heart
        $this->logger->warning(str_repeat('🤎', 5) . ' New customer lead');

        $this->leadCustomerService->populateCustomers($startDate, $endDate);
    }
}
