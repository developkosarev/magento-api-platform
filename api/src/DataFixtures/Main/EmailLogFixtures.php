<?php

namespace App\DataFixtures\Main;

use App\Entity\Main\EmailLog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class EmailLogFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $log = new EmailLog();
            $log->setEmailType('NEWSLETTER_SUBSCRIBE_CONFIRM');
            $manager->persist($log);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['main'];
    }
}
