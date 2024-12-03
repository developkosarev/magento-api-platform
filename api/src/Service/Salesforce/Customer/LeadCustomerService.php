<?php

namespace App\Service\Salesforce\Customer;

use App\Entity\Magento\Customer;
use App\Entity\Magento\CustomerAddress;
use App\Entity\Main\SalesforceCustomerLead;
use App\Repository\Main\SalesforceCustomerLeadRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class LeadCustomerService implements LeadCustomerServiceInterface
{
    private EntityRepository $mCustomerRepository;
    private EntityRepository $mCustomerAddressRepository;

    public function __construct(
        private readonly EntityManagerInterface           $magentoEntityManager,
        private readonly SalesforceCustomerLeadRepository $salesforceCustomerLeadRepository
    ) {
        $this->mCustomerRepository = $this->magentoEntityManager->getRepository(Customer::class);
        $this->mCustomerAddressRepository = $this->magentoEntityManager->getRepository(CustomerAddress::class);
    }

    public function populateCustomers(DateTime $startDate, DateTime $endDate): void
    {
        $result = $this->mCustomerRepository->getLeads($startDate, $endDate);
        //var_dump($result);

        foreach ($result as $mCustomer) {
            //echo 'Id: ' . $mCustomer->getId() . ', Email: ' . $mCustomer->getEmail();
            //echo 'DefaultBilling: ' . $mCustomer->getDefaultBilling();

            $lead = $this->salesforceCustomerLeadRepository->findOneBy(['customerId' => $mCustomer->getId()]);
            if ($lead === null) {
                $address = $this->mCustomerAddressRepository->find($mCustomer->getDefaultBilling());

                $lead = new SalesforceCustomerLead();
                $lead
                    ->setLeadStatus(SalesforceCustomerLead::LEAD_STATUS_NEW)
                    ->setStatus(SalesforceCustomerLead::STATUS_NEW);

                $lead
                    ->setEmail($mCustomer->getEmail())
                    ->setWebsiteId($mCustomer->getWebsiteId())
                    ->setCustomerId($mCustomer->getId())
                    ->setFirstName($mCustomer->getFirstName())
                    ->setLastName($mCustomer->getLastName());

                if ($address !== null) {
                    $lead
                        ->setCity($address->getCity())
                        ->setCompany($address->getCompany())
                        ->setCountryId($address->getCountryId())
                        ->setStreet($address->getStreet())
                        ->setHouseNumber($address->getHouseNumber())
                        ->setPostcode($address->getPostcode());
                }

                $this->salesforceCustomerLeadRepository->add($lead);
            }
        }
    }
}
