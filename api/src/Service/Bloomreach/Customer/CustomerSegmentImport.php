<?php

namespace App\Service\Bloomreach\Customer;

use App\Entity\Magento\Customer;
use App\Entity\Magento\CustomerSegment;
use App\Entity\Magento\CustomerSegmentCustomer;
use App\Entity\Magento\CustomerSegmentWebsite;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CustomerSegmentImport implements CustomerSegmentImportInterface
{
    private const INSERT_BATCH_SIZE = 100000;

    private EntityRepository $mCustomerRepository;
    private EntityRepository $mCustomerSegmentRepository;
    private EntityRepository $mCustomerSegmentWebsiteRepository;
    private EntityRepository $mCustomerSegmentCustomerRepository;

    public function __construct(
        private readonly CsvReader $csvReader,
        private readonly EntityManagerInterface $magentoEntityManager
    ) {
        $this->mCustomerRepository = $this->magentoEntityManager->getRepository(Customer::class);
        $this->mCustomerSegmentRepository = $this->magentoEntityManager->getRepository(CustomerSegment::class);
        $this->mCustomerSegmentWebsiteRepository = $this->magentoEntityManager->getRepository(CustomerSegmentWebsite::class);
        $this->mCustomerSegmentCustomerRepository = $this->magentoEntityManager->getRepository(CustomerSegmentCustomer::class);
    }

    /**
     * @throws \Exception
     */
    public function execute(int $segmentId, int $websiteId, string $fileName, bool $force): void
    {
        if (!file_exists($fileName)) {
            throw new \Exception("File of segments \"{$fileName}\" not found!");
        }

        $segment = $this->mCustomerSegmentRepository->find($segmentId);
        if ($segment === null) {
            throw new \Exception("Segment \"{$segmentId}\" not found!");
        }

        $segmentWebsite = $this->mCustomerSegmentWebsiteRepository->findOneBy(['segment' => $segmentId, 'website' => $websiteId]);
        if ($segmentWebsite === null) {
            throw new \Exception("Website \"{$websiteId}\" not found!");
        }

        $i = 0;
        foreach ($this->csvReader->read($fileName) as $row) {
            $email = $row[0];
            $customer = $this->mCustomerRepository->findOneBy(['email' => $email, 'websiteId' => $websiteId]);
            if ($customer === null) {
                continue;
            }

            $item = $this->mCustomerSegmentCustomerRepository->findOneBy([
                'segment' => $segment->getId(),
                'website' => $segmentWebsite->getWebsite(),
                'customer' => $customer->getId()
            ]);

            if ($item !== null) {
                continue;
            }

            if ($force) {
                $item = new CustomerSegmentCustomer();
                $item
                    ->setSegment($segment)
                    ->setWebsite($segmentWebsite->getWebsite())
                    ->setCustomer($customer);

                $this->magentoEntityManager->persist($item);

                if (($i % self::INSERT_BATCH_SIZE) === 0) {
                    $this->magentoEntityManager->flush();
                    $this->magentoEntityManager->clear();
                }
            }

            $i++;
        }

        if ($force) {
            $this->magentoEntityManager->flush();
        }
    }
}
