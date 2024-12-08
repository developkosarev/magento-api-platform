<?php

namespace App\Service\Salesforce\Customer;

use App\Entity\Magento\Customer;
use App\Entity\Magento\CustomerAddress;
use App\Entity\Main\SalesforceCustomerLead;
use App\Repository\Main\SalesforceCustomerLeadRepository;
use App\Service\Salesforce\Dto\CustomerLeadDto;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class LeadCustomerService implements LeadCustomerServiceInterface
{
    private EntityRepository $mCustomerRepository;
    private EntityRepository $mCustomerAddressRepository;

    public function __construct(
        private readonly EntityManagerInterface           $magentoEntityManager,
        private readonly SalesforceCustomerLeadRepository $salesforceCustomerLeadRepository,
        private readonly LeadSenderServiceInterface       $leadSenderService
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

    public function sendCustomers():void
    {
        $leads = $this->salesforceCustomerLeadRepository->findByStatusNew();

        foreach ($leads as $lead) {
            $leadDto = CustomerLeadDto::createByInterface($lead);
            $result = $this->leadSenderService->sendCustomer($leadDto);

            if (array_key_exists('leadId', $result[0])) {
                $lead
                    ->setLeadId($result[0]['leadId'])
                    ->setDescription($result[0]['type'])
                    ->setStatus($result[0]['status'])
                    ->setStatus(SalesforceCustomerLead::STATUS_PROCESSED);

                $this->salesforceCustomerLeadRepository->add($lead);
            } elseif (array_key_exists('message', $result[0])) {
                $lead
                    ->setDescription(mb_substr($result[0]['message'], 0, 100))
                    ->setStatus($result[0]['status'])
                    ->setStatus(SalesforceCustomerLead::STATUS_ERROR);

                $this->salesforceCustomerLeadRepository->add($lead);
            }
        }
    }
}
