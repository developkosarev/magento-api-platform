<?php

namespace App\Service\Salesforce\Customer;

use App\Entity\Magento\CustomerTherapist;
use App\Entity\Magento\CustomerAddress;
use App\Entity\Main\Salesforce\CustomerLead;
use App\Repository\Main\Salesforce\CustomerLeadRepository;
use App\Service\Salesforce\Common\Config;
use App\Service\Salesforce\Dto\CustomerLeadDto;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use League\Flysystem\FilesystemOperator;

class LeadCustomerService implements LeadCustomerServiceInterface
{
    private EntityRepository $mCustomerRepository;
    private EntityRepository $mCustomerAddressRepository;

    private array $certificateImages = [
        ['certificate.jpg', 'image/jpg'],
        ['certificate.png', 'image/png'],
        ['certificate.pdf', 'application/pdf']
    ];

    public function __construct(
        private readonly Config $config,
        private readonly EntityManagerInterface     $magentoEntityManager,
        private readonly CustomerLeadRepository     $customerLeadRepository,
        private readonly LeadSenderServiceInterface $leadSenderService,
        private readonly FilesystemOperator         $customerStorage,
    ) {
        $this->mCustomerRepository = $this->magentoEntityManager->getRepository(CustomerTherapist::class);
        $this->mCustomerAddressRepository = $this->magentoEntityManager->getRepository(CustomerAddress::class);
    }

    public function populateCustomers(DateTime $startDate, DateTime $endDate): void
    {
        $result = $this->mCustomerRepository->getLeads($startDate, $endDate);
        //var_dump($result);

        foreach ($result as $mCustomer) {
            //echo 'Id: ' . $mCustomer->getId() . ', Email: ' . $mCustomer->getEmail();
            //echo 'DefaultBilling: ' . $mCustomer->getDefaultBilling();

            $lead = $this->customerLeadRepository->findOneBy(['customerId' => $mCustomer->getId()]);
            if ($lead === null) {
                $address = $this->mCustomerAddressRepository->find($mCustomer->getDefaultBilling());

                $lead = new CustomerLead();
                $lead
                    ->setLeadStatus(CustomerLead::LEAD_STATUS_NEW)
                    ->setStatus(CustomerLead::STATUS_NEW);

                $lead
                    ->setEmail($mCustomer->getEmail())
                    ->setWebsiteId($mCustomer->getWebsiteId())
                    ->setCustomerId($mCustomer->getId())
                    ->setFirstName($mCustomer->getFirstName())
                    ->setLastName($mCustomer->getLastName())
                    ->setBirthday($mCustomer->getDob())
                    ->setSpecialties($mCustomer->getSpecialties());

                if ($address !== null) {
                    $lead
                        ->setCity($address->getCity())
                        ->setCompany($address->getCompany())
                        ->setCountryId($address->getCountryId())
                        ->setStreet($address->getStreet())
                        ->setHouseNumber($address->getHouseNumber())
                        ->setPostcode($address->getPostcode())
                        ->setTaxvat($address->getVatId());
                    if (!empty($address->getTelephone())) {
                        $lead
                            ->setPhone($address->getTelephone());
                    }
                }

                $this->customerLeadRepository->add($lead);
            }
        }
    }

    public function sendCustomers():void
    {
        $leads = $this->customerLeadRepository->findByStatusNew();

        foreach ($leads as $lead) {
            $leadDto = CustomerLeadDto::createByInterface($lead);
            $this->setCustomerCertificate($leadDto);

            $result = $this->leadSenderService->sendCustomer($leadDto);
            //var_dump($result);

            if (array_key_exists('leadId', $result[0])) {
                $lead
                    ->setFileName($leadDto->getFileName())
                    ->setLeadId($result[0]['leadId'])
                    ->setDescription($result[0]['type'])
                    ->setStatus($result[0]['status'])
                    ->setStatus(CustomerLead::STATUS_PROCESSED);

                if (array_key_exists('attachmentId', $result[0])) {
                    $lead->setAttachmentId($result[0]['attachmentId']);
                }

                $this->customerLeadRepository->add($lead);
            } elseif (array_key_exists('message', $result[0])) {
                $lead
                    ->setFileName($leadDto->getFileName())
                    ->setDescription(mb_substr($result[0]['message'], 0, 100))
                    ->setStatus($result[0]['status'])
                    ->setStatus(CustomerLead::STATUS_ERROR);

                $this->customerLeadRepository->add($lead);
            }
        }
    }

    private function setCustomerCertificate(CustomerLeadDto $leadDto): void
    {
        $customerId = $leadDto->getCustomerId();

        $resultFilename = null;
        $resultFullFilename = null;
        $resultContentType = null;
        foreach ($this->certificateImages as [$filename, $contentType]) {
            $fullFilename = $this->config->getS3Prefix() . "/{$customerId}/{$filename}";

            $fileExists = $this->customerStorage->fileExists($fullFilename);
            if ($fileExists) {
                $resultFilename = $filename;
                $resultFullFilename = $fullFilename;
                $resultContentType = $contentType;
                break;
            }
        }

        if ($resultFullFilename) {
            $content = $this->customerStorage->read($resultFullFilename);

            $leadDto
                ->setFileName($resultFilename)
                ->setContentType($resultContentType)
                ->setFileBase64(base64_encode($content));
        }
    }
}
