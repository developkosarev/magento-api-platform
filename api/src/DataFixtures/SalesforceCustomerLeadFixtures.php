<?php

namespace App\DataFixtures;

use App\Entity\Main\Salesforce\SalesforceCustomerLead;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Flysystem\FilesystemOperator;

class SalesforceCustomerLeadFixtures extends Fixture
{
    public function __construct(
        private readonly FilesystemOperator $customerStorage
    )
    {}

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 3; $i++) {
            $lead = new SalesforceCustomerLead();
            $lead
                ->setLeadStatus(SalesforceCustomerLead::LEAD_STATUS_NEW)
                ->setEmail('customer' . $i . '@example.com')
                ->setWebsiteId(1)
                ->setCustomerId($i)
                ->setFirstName('FirstName' . $i)
                ->setLastName('LastName' . $i)
                ->setBirthday(\DateTime::createFromFormat('Y-m-d', '2000-01-01'))
                ->setSpecialties(1871)
                ->setCity('Berlin')
                ->setCountryId('DE')
                ->setStreet('Kurfürstendamm')
                ->setHouseNumber($i)
                ->setFileName('meteor-shower.jpg')
                ->setPostcode('10000')
                ->setLeadId('00Q9V00000KTZdBUAX')
                ->setStatus(SalesforceCustomerLead::STATUS_PROCESSED);

            $manager->persist($lead);
            $manager->flush();

            $this->createUnique($lead);
            //$this->uploadCertificate($lead);
            $this->uploadFile($lead);
        }

        $manager->flush();
    }

    private function uploadFile(SalesforceCustomerLead $lead): void
    {
        $fixtureFilename = __DIR__ . '/images/meteor-shower.jpg';

        $customerId = $lead->getCustomerId();
        $originalFilename = 'meteor-shower.jpg';
        $filename = "/therapists/{$customerId}/{$originalFilename}";

        $this->customerStorage->write($filename, file_get_contents($fixtureFilename));
    }

    private function createUnique(SalesforceCustomerLead $lead): void
    {
        $firstname = sha1('FirstName' . $lead->getId());
        $lastname = sha1('FirstName' . $lead->getId());
        $lead
            ->setEmail('customer' . $lead->getId() . '@example.com')
            ->setCustomerId($lead->getId())
            ->setFirstName($firstname)
            ->setLastName($lastname);
    }

    //private function uploadCertificate(SalesforceCustomerLead $lead): void
    //{
    //    $fs = new Filesystem();
    //    $targetPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'meteor-shower.jpg';
    //    $fs->copy(__DIR__ . '/images/meteor-shower.jpg', $targetPath, true);
    //    //var_dump($targetPath);
    //
    //    //$this->uploader->uploadCertificate(new File($targetPath));
    //
    //    $this->uploader->uploadCertificateToS3(new File($targetPath), $lead->getCustomerId());
    //}
}
