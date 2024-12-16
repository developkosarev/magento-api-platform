<?php

namespace App\Helper;

use League\Flysystem\FilesystemOperator;

class UploaderHelper
{
    private FilesystemOperator $storage;

    // The variable name $defaultStorage matters: it needs to be the camelized version
    // of the name of your storage.
    public function __construct(FilesystemOperator $defaultStorage)
    {
        $this->storage = $defaultStorage;
    }
}
