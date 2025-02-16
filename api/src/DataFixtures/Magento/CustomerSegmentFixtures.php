<?php

namespace App\DataFixtures\Magento;

use App\Entity\Magento\CustomerSegment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

class CustomerSegmentFixtures extends Fixture implements FixtureGroupInterface
{
    public const CUSTOMER_SEGMENT1_REFERENCE = 'customer-segment-1';
    public const SEGMENT_ID = 1;
    public const SEGMENT_NAME = 'segment1';
    private EntityRepository $mCustomerSegmentRepository;

    public function __construct(
        private readonly EntityManagerInterface $magentoEntityManager
    ) {
        $this->mCustomerSegmentRepository = $this->magentoEntityManager->getRepository(CustomerSegment::class);
        $this->magentoEntityManager
            ->getClassMetadata(CustomerSegment::class)
            ->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
    }

    public function load(ObjectManager $manager): void
    {
        $item = $this->mCustomerSegmentRepository->find(self::SEGMENT_ID);
        if (null === $item) {
            $item = new CustomerSegment();
            $item->setId(self::SEGMENT_ID);
        }

        $item->setName(self::SEGMENT_NAME);
        $item->setIsActive(true);
        $this->magentoEntityManager->persist($item);
        $this->magentoEntityManager->flush();

        $this->addReference(self::CUSTOMER_SEGMENT1_REFERENCE, $item);
    }

    public static function getGroups(): array
    {
        return ['magento'];
    }
}
