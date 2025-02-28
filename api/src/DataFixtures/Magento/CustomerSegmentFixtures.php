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
    public const CUSTOMER_SEGMENT_1_REFERENCE = 'customer-segment-1';
    public const CUSTOMER_SEGMENT_99_REFERENCE = 'customer-segment-99';
    public const SEGMENT_1_ID = 1;
    public const SEGMENT_99_ID = 99;
    public const SEGMENT_1_NAME = 'segment1';
    public const SEGMENT_99_NAME = 'segment99';
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
        foreach ($this->getSegments() as [$id, $name, $reference]) {
            $item = $this->mCustomerSegmentRepository->find($id);
            if (null === $item) {
                $item = new CustomerSegment();
                $item->setId($id);
            }

            $item->setName($name);
            $item->setIsActive(true);
            $this->magentoEntityManager->persist($item);

            $this->addReference($reference, $item);
        }
        $this->magentoEntityManager->flush();
    }

    private function getSegments(): array
    {
        return [
            [self::SEGMENT_1_ID, self::SEGMENT_1_NAME, self::CUSTOMER_SEGMENT_1_REFERENCE],
            [self::SEGMENT_99_ID, self::SEGMENT_99_NAME, self::CUSTOMER_SEGMENT_99_REFERENCE],
        ];
    }

    public static function getGroups(): array
    {
        return ['magento'];
    }
}
