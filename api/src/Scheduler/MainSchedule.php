<?php

namespace App\Scheduler;

use App\Scheduler\Message\Bloomreach\LoadSegment;
use App\Scheduler\Message\LogHello;
use App\Scheduler\Message\Salesforce\LeadCustomer;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Component\Scheduler\RecurringMessage;

#[AsSchedule]
class MainSchedule implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return (new Schedule())->add(
            RecurringMessage::every('60 seconds', new LogHello(4)),
            RecurringMessage::every('3600 seconds', new LeadCustomer()), //1 hours

            RecurringMessage::every($_ENV["SCHEDULER_LOAD_SEGMENT"], new LoadSegment()) //82800 seconds=23 hours
            //RecurringMessage::cron('0 10 * * *', new LoadSegment()) //10:00 //composer require dragonmantank/cron-expression
        );
    }
}
