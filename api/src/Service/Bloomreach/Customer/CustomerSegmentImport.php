<?php

namespace App\Service\Bloomreach\Customer;

interface CustomerSegmentImport
{
    public function execute(string $fileName): void;
}
