<?php

namespace App\Scheduler;

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
            RecurringMessage::every('43200 seconds', new LeadCustomer()) //12 hours
        );
    }
}
