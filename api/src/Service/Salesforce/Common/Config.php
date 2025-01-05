<?php

namespace App\Service\Salesforce\Common;

class Config
{
    public function getS3Prefix(): string
    {
        return $_ENV["SALESFORCE_S3_PREFIX"];
    }
}
