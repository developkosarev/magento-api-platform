<?php

namespace App\Scheduler;

use App\Scheduler\Message\Bloomreach\LoadSegment;
use App\Scheduler\Message\CronVerification;
use App\Scheduler\Message\LogHello;
use App\Scheduler\Message\Salesforce\LeadCustomer;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Component\Scheduler\RecurringMessage;

#[AsSchedule]
class MainSchedule implements ScheduleProviderInterface
{
    public function __construct(
        private readonly Config $config
    )
    {
    }
    public function getSchedule(): Schedule
    {
        return (new Schedule())->add(
            RecurringMessage::every($this->config->getSchedulerHello(), new LogHello(4)),
            RecurringMessage::every($this->config->getSchedulerCronVerification(), new CronVerification()),
            RecurringMessage::every($this->config->getSchedulerLeadCustomer(), new LeadCustomer()), //1 hours

            RecurringMessage::every($this->config->getSchedulerLoadSegment(), new LoadSegment()) //82800 seconds=23 hours
            //RecurringMessage::cron('0 10 * * *', new LoadSegment()) //10:00 //composer require dragonmantank/cron-expression
        );
    }
}
