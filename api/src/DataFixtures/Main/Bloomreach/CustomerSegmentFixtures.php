<?php

namespace App\DataFixtures\Main\Bloomreach;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use League\Flysystem\FilesystemOperator;

class CustomerSegmentFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly FilesystemOperator $bloomreachStorage
    )
    {}

    public function load(ObjectManager $manager): void
    {
        $this->uploadFile();
    }

    private function uploadFile(): void
    {
        $fixtureFilename = __DIR__ . '/../../data/segment_99.csv';
        $filenameDev = "/dev/segments/segment_99.csv";
        $filename = "/segments/segment_99.csv";

        $this->bloomreachStorage->write($filenameDev, file_get_contents($fixtureFilename));
        $this->bloomreachStorage->write($filename, file_get_contents($fixtureFilename));
    }

    public static function getGroups(): array
    {
        return ['main'];
    }
}
