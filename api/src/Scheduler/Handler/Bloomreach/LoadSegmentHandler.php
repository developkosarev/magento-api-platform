<?php

namespace App\Scheduler\Handler\Bloomreach;

use App\Scheduler\Message\Bloomreach\LoadSegment;
use App\Service\Bloomreach\Customer\CustomerSegmentFileImport;
use App\Service\Bloomreach\Customer\CustomerSegmentImportInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class LoadSegmentHandler
{
    public function __construct(
        private readonly CustomerSegmentFileImport $fileImport,
        private readonly CustomerSegmentImportInterface $customerSegmentImport,
        private readonly LoggerInterface $logger
    )
    {
    }
    public function __invoke(LoadSegment $message)
    {
        $segmentId = 2;
        $websiteId = 1;

        $msg = " Load segments #{$segmentId} website #{$websiteId}";
        $this->logger->warning(str_repeat('🤎', 1) . $msg);

        if ($this->fileImport->uploadFile($segmentId)) {
            $fileNameLocal = $this->fileImport->getFileNameLocal($segmentId);

            $this->customerSegmentImport->setForce(true);
            $this->customerSegmentImport->execute($segmentId, $websiteId, $fileNameLocal);

            if (file_exists($fileNameLocal)) {
                unlink($fileNameLocal);
            }
        }
    }
}
