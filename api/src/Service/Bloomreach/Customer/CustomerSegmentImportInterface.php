<?php

namespace App\Service\Bloomreach\Customer;

interface CustomerSegmentImportInterface
{
    public function execute(int $segmentId, int $websiteId, string $fileName, bool $force): void;
}
