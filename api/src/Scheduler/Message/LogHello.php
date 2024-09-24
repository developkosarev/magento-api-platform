<?php

namespace App\Scheduler\Message;

final class LogHello
{
    public function __construct(public int $length)
    {
    }
}
