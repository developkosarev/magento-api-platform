<?php

namespace App\Helper;

use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    public function __construct(
        private readonly FilesystemOperator $defaultStorage,
        private readonly FilesystemOperator $customerStorage,
        private readonly string $uploadPath
    )
    {
    }

    public function uploadCertificate(File $file): string
    {
        if ($file instanceof UploadedFile) {
            $originalFilename = $file->getClientOriginalName();
        } else {
            $originalFilename = $file->getFilename();
        }

        $this->defaultStorage->write($originalFilename, file_get_contents($file->getPathname()));

        //$file->move($this->uploadPath, $originalFilename);

        return $originalFilename;
    }

    public function uploadCertificateToS3(File $file, string $customerId): string
    {
        if ($file instanceof UploadedFile) {
            $originalFilename = $file->getClientOriginalName();
        } else {
            $originalFilename = $file->getFilename();
        }
        $filename = "/therapists/{$customerId}/{$originalFilename}";
        //dd($originalFilename);

        $this->customerStorage->write($filename, file_get_contents($file->getPathname()));

        return $filename;
    }

    public function readCertificateFromS3(string $customerId): string
    {
        $filename = "/therapists/{$customerId}/meteor-shower.jpg";
        $this->customerStorage->read($filename);

        return $filename;
    }
}
