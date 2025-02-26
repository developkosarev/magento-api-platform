<?php

namespace App\Service\Bloomreach\Customer;

interface CustomerSegmentImportInterface
{
    public function execute(string $fileName): void;
}
