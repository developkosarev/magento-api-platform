<?php

namespace App\DataFixtures\Magento;

use App\Entity\Magento\CustomerSegment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CustomerSegmentFixtures extends Fixture implements FixtureGroupInterface
{
    //private EntityRepository $mCustomerSegmentRepository;

    public function __construct(
        private readonly EntityManagerInterface $magentoEntityManager
    ) {
        //$this->mCustomerSegmentRepository = $this->magentoEntityManager->getRepository(CustomerSegment::class);
    }

    public function load(ObjectManager $manager): void
    {
        $item = new CustomerSegment();
        $item->setName('segment1');
        $item->setIsActive(true);
        $this->magentoEntityManager->persist($item);
        $this->magentoEntityManager->flush();
    }

    public static function getGroups(): array
    {
        return ['magento'];
    }
}
