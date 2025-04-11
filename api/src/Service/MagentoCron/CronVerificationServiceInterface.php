<?php

namespace App\Service\MagentoCron;

interface CronVerificationServiceInterface
{
    public function execute(bool $force = true): void;
}
