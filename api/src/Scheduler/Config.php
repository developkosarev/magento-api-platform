<?php

namespace App\Scheduler;

class Config
{
    public function getSchedulerHello(): string
    {
        return $_ENV["SCHEDULER_HELLO"];
    }

    public function getSchedulerLeadCustomer(): string
    {
        return $_ENV["SCHEDULER_LEAD_CUSTOMER"];
    }

    public function getSchedulerLoadSegment(): string
    {
        return $_ENV["SCHEDULER_LOAD_SEGMENT"];
    }
}
