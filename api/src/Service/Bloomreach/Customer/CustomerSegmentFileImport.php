<?php

namespace App\Service\Bloomreach\Customer;

use League\Flysystem\FilesystemOperator;
use Psr\Log\LoggerInterface;

class CustomerSegmentFileImport
{
    private const FILE_SEGMETN = '/segments/segment_%s.csv';
    private const FILE_SEGMETN_LOCAL = '/app/var/data/segment_%s.csv';
    private const DIR_SEGMETN_LOCAL = '/app/var/data';

    public function __construct(
        private readonly FilesystemOperator $bloomreachStorage,
        private readonly LoggerInterface $logger,
    ) {}

    public function uploadFile(int $segmentId): bool
    {
        $fileName = $this->getFileName($segmentId);
        $fileNameLocal = $this->getFileNameLocal($segmentId);

        if (!$this->bloomreachStorage->fileExists($fileName)) {
            return false;
        }

        if (!file_exists(self::DIR_SEGMETN_LOCAL)) {
            mkdir(self::DIR_SEGMETN_LOCAL, 0777, true);
        }

        // Copy file from S3 to Local using streaming
        try {
            $readStream = $this->bloomreachStorage->readStream($fileName);
            $writeStream = fopen($fileNameLocal, 'wb');

            stream_copy_to_stream($readStream, $writeStream);

            fclose($readStream);
            fclose($writeStream);
        } catch (\Exception $e) {
            $this->logger->warning('Error copying file  from S3 to Local', ['message' => $e->getMessage()]);

            return false;
        }

        return true;
    }

    public function getFileName(int $segmentId): string
    {
        return sprintf(self::FILE_SEGMETN, $segmentId);
    }

    public function getFileNameLocal(int $segmentId): string
    {
        return sprintf(self::FILE_SEGMETN_LOCAL, $segmentId);
    }
}
