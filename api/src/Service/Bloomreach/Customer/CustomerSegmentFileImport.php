<?php

namespace App\Service\Bloomreach\Customer;

use League\Flysystem\FilesystemOperator;

class CustomerSegmentFileImport
{
    private const FILE_SEGMETN = '/app/var/data/segment_%.csv';

    public function __construct(
        private readonly FilesystemOperator $bloomreachStorage,
    ) {}

    public function execute(string $fileName): void
    {
        //
    }

    private function uploadFile(string $filePath): void
    {
        $fileExists = $this->bloomreachStorage->fileExists($fullFilename);

        //$this->bloomreachStorage->copy(); read($resultFullFilename);

    }
}
