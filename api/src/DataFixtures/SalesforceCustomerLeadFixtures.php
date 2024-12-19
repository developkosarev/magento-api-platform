<?php

namespace App\DataFixtures;

use App\Entity\Main\SalesforceCustomerLead;
use App\Helper\UploaderHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class SalesforceCustomerLeadFixtures extends Fixture
{
    public function __construct(private readonly UploaderHelper $uploader)
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

            $fs = new Filesystem();
            $targetPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'meteor-shower.jpg';
            $fs->copy(__DIR__ . '/images/meteor-shower.jpg', $targetPath, true);
            //var_dump($targetPath);

            //$this->uploader->uploadCertificate(new File($targetPath));

            $this->uploader->uploadCertificateToS3(new File($targetPath), $i);

            $lead
                ->setEmail('customer' . $lead->getId() . '@example.com')
                ->setCustomerId($lead->getId())
                ->setFirstName('FirstName' . $lead->getId())
                ->setLastName('LastName' . $lead->getId());
        }

        $manager->flush();
    }
}
