<?php

namespace App\Helper;

use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    public function __construct(
        private readonly FilesystemOperator $defaultStorage,
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
}
