<?php
declare(strict_types=1);

namespace App\Service\Bloomreach\Customer;

use Iterator;

class CsvReader
{
    public function read(string $file): Iterator
    {
        $fileHandle = fopen($file, 'r');
        // extract header
        fgetcsv($fileHandle);
        while (($row = fgetcsv($fileHandle)) !== false) {
            if (!$this->isRowValid($row)) {
                continue;
            }
            yield $row;
        }
        fclose($fileHandle);
    }
    private function isRowValid(array $row): bool
    {
        return !empty($row[0]) && !empty($row[1]);
    }
}
