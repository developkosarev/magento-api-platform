<?php

namespace App\Scheduler;

class Config
{
    public function getSchedulerLoadSegment(): string
    {
        return $_ENV["SCHEDULER_LOAD_SEGMENT"];
    }
}
