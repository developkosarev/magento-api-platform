<?php

namespace App\DataFixtures\Magento;

use App\Entity\Magento\StoreWebsite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class StoreWebsiteFixtures extends Fixture implements FixtureGroupInterface
{
    public const WEBSITE_1_REFERENCE = 'website-1';
    private EntityRepository $mStoreWebsiteRepository;

    public function __construct(
        private readonly EntityManagerInterface $magentoEntityManager
    ) {
        $this->mStoreWebsiteRepository = $this->magentoEntityManager->getRepository(StoreWebsite::class);
    }

    public function load(ObjectManager $manager): void
    {
        $item = $this->mStoreWebsiteRepository->find(1);

        $this->addReference(self::WEBSITE_1_REFERENCE, $item);
    }

    public static function getGroups(): array
    {
        return ['magento'];
    }
}
