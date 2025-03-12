<?php

namespace App\Service\Bloomreach\Customer;

use Symfony\Component\Console\Output\OutputInterface;

interface CustomerSegmentImportInterface
{
    public function setForce(bool $force): void;

    public function setOutput(OutputInterface $output): void;

    public function setLimit(int $limit): void;

    public function execute(int $segmentId, int $websiteId, string $fileName): void;
}
