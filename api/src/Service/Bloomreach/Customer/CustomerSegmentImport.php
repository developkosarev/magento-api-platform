<?php

namespace App\Service\Bloomreach\Customer;

use App\Entity\Magento\Customer;
use App\Entity\Magento\CustomerSegment;
use App\Entity\Magento\CustomerSegmentCustomer;
use App\Entity\Magento\CustomerSegmentWebsite;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Output\OutputInterface;

class CustomerSegmentImport implements CustomerSegmentImportInterface
{
    private const INSERT_BATCH_SIZE = 10000;

    private bool $force;
    private ?OutputInterface $output = null;
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
    public function execute(int $segmentId, int $websiteId, string $fileName): void
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

            $i++;
            if (($i % self::INSERT_BATCH_SIZE) === 0) {
                if ($this->force) {
                    $this->magentoEntityManager->flush();
                }
                $this->magentoEntityManager->clear();

                $segment = $this->mCustomerSegmentRepository->find($segmentId);
                $segmentWebsite = $this->mCustomerSegmentWebsiteRepository->findOneBy(['segment' => $segmentId, 'website' => $websiteId]);
                if ($this->output !== null) {
                    $msg = "<info>Count #{$i} Memory: {$this->getMemoryUsage()}MB</info>";
                    $this->output->writeln($msg);
                }
            }

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

            $item = new CustomerSegmentCustomer();
            $item
                ->setSegment($segment)
                ->setWebsite($segmentWebsite->getWebsite())
                ->setCustomer($customer);

            $this->magentoEntityManager->persist($item);
        }

        if ($this->force) {
            $this->magentoEntityManager->flush();
        }
        $this->magentoEntityManager->clear();

        $this->force = false;
    }

    public function setForce(bool $force): void
    {
        $this->force = $force;
    }

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    private function getMemoryUsage(): float
    {
        $memUsage = memory_get_usage(true);
        return round($memUsage / 1048576, 2);
    }
}
