<?php

namespace App\Tests\Service\Salesforce;

use App\Entity\Magento\Customer;
use App\Entity\Magento\CustomerAddress;
use App\Repository\Magento\CustomerAddressRepository;
use App\Repository\Magento\CustomerRepository;
use App\Repository\Main\SalesforceCustomerLeadRepository;
use App\Service\Salesforce\Customer\LeadCustomerService;
use App\Service\Salesforce\Customer\LeadSenderServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LeadCustomerServiceTest extends KernelTestCase
{
    private const EMAIL = 'test@test.test';
    private const BIRTHDAY = '2000-01-01';

    private static SalesforceCustomerLeadRepository $salesforceCustomerLeadRepository;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        self::$salesforceCustomerLeadRepository = $container->get(SalesforceCustomerLeadRepository::class);
    }

    public function testLeadCustomerSerialize()
    {
        $leadCustomerService = new LeadCustomerService(
            $this->mockEntityManager(),
            self::$salesforceCustomerLeadRepository,
            $this->mockLeadSenderService()
        );

        $startDate = \DateTime::createFromFormat("Y-m-d", '2024-01-01');
        $endDate = \DateTime::createFromFormat("Y-m-d", '2024-02-01');
        $leadCustomerService->populateCustomers($startDate, $endDate);

        $result = [];

        $body = [];

        $this->assertEquals($body, $result);
    }

    private function mockEntityManager(): EntityManagerInterface
    {
        $mCustomerRepository = $this->createMock(CustomerRepository::class);
        $mCustomerRepository->expects($this->any())
            ->method('getLeads')
            ->willReturn([$this->createCustomer()]);

        $mCustomerAddressRepository = $this->createMock(CustomerAddressRepository::class);
        $mCustomerAddressRepository->expects($this->any())
            ->method('find')
            ->willReturn($this->createCustomerAddress());

        $objectManager = $this->createMock(EntityManagerInterface::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnCallback(function($class) use (
                $mCustomerRepository,
                $mCustomerAddressRepository
            ) {
                switch ($class) {
                    case 'App\Entity\Magento\Customer':
                        $repository = $mCustomerRepository;
                        break;
                    case 'App\Entity\Magento\CustomerAddress':
                        $repository = $mCustomerAddressRepository;
                        break;
                    default:
                        throw new \Exception("Repository not found for the class '" . $class . "'");
                }

                return $repository;
            }));

        return $objectManager;
    }

    private function mockLeadSenderService(): LeadSenderServiceInterface
    {
        $result = $this->createMock(LeadSenderServiceInterface::class);

        return $result;
    }

    private function createCustomer(): Customer
    {
        $customer = $this->createMock(Customer::class);
        $customer->expects($this->any())
            ->method('getId')
            ->willReturn(1);

        $customer->expects($this->any())
            ->method('getEmail')
            ->willReturn(self::EMAIL);

        $customer->expects($this->any())
            ->method('getWebsiteId')
            ->willReturn(1);

        $customer->expects($this->any())
            ->method('getFirstName')
            ->willReturn('FirstName');

        $customer->expects($this->any())
            ->method('getLastName')
            ->willReturn('LastName');

        $customer->expects($this->any())
            ->method('getDob')
            ->willReturn(self::BIRTHDAY);
            //->willReturn(\DateTime::createFromFormat('Y-m-d', self::BIRTHDAY));

        $customer->expects($this->any())
            ->method('getSpecialties')
            ->willReturn(1);

        $customer->expects($this->any())
            ->method('getTaxVat')
            ->willReturn('11111111111');

        return $customer;
    }

    private function createCustomerAddress(): CustomerAddress
    {
        $customerAddress = $this->createMock(CustomerAddress::class);
        $customerAddress->expects($this->any())
            ->method('getId')
            ->willReturn(1);

        $customerAddress->expects($this->any())
            ->method('getCountryId')
            ->willReturn('DE');

        $customerAddress->expects($this->any())
            ->method('getCity')
            ->willReturn('Berlin');

        $customerAddress->expects($this->any())
            ->method('getCompany')
            ->willReturn('Company');

        $customerAddress->expects($this->any())
            ->method('getStreet')
            ->willReturn('Kurfürstendamm');

        $customerAddress->expects($this->any())
            ->method('getHouseNumber')
            ->willReturn('2');

        $customerAddress->expects($this->any())
            ->method('getPostcode')
            ->willReturn('200000');

        $customerAddress->expects($this->any())
            ->method('getTelephone')
            ->willReturn('+123456789');

        return $customerAddress;
    }
}
