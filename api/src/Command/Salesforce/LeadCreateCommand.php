<?php
declare(strict_types=1);

namespace App\Command\Salesforce;

use App\Entity\Magento\Customer;
use App\Entity\Magento\CustomerAddress;
use App\Entity\Main\SalesforceCustomerLead;
use App\Repository\Main\SalesforceCustomerLeadRepository;
use App\Service\Salesforce\Common\ApiTokenService;
use App\Service\Salesforce\Customer\LeadServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use DateTime;

#[AsCommand(
    name: "salesforce:lead:create",
    description: "Create lead",
    hidden: false
)]
class LeadCreateCommand extends Command
{
    private const OPTION_START_DATE = 'start-date';
    private const OPTION_END_DATE = 'end-date';
    private const DEFAULT_START_DATE = '2024-01-01';
    private const DEFAULT_END_DATE = '2024-02-01';

    private string $token;
    private string $url;

    private DateTime $startDate;

    private DateTime $endDate;

    private EntityRepository $mCustomerRepository;
    private EntityRepository $mCustomerAddressRepository;

    public function __construct(
        private readonly EntityManagerInterface $magentoEntityManager,
        private readonly SalesforceCustomerLeadRepository $salesforceCustomerLeadRepository,
        private readonly ApiTokenService      $apiTokenService,
        private readonly LeadServiceInterface $leadService,
        string                                $name = null
    ) {
        $this->mCustomerRepository = $this->magentoEntityManager->getRepository(Customer::class);
        $this->mCustomerAddressRepository = $this->magentoEntityManager->getRepository(CustomerAddress::class);

        parent::__construct($name);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->startDate = DateTime::createFromFormat("Y-m-d", $input->getOption(self::OPTION_START_DATE));
        $this->endDate = DateTime::createFromFormat("Y-m-d", $input->getOption(self::OPTION_END_DATE));
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email of customer')
            ->addOption(
                self::OPTION_START_DATE,
                null,
                InputOption::VALUE_OPTIONAL,
                'Start. Format: Y-m-d. Example: 2024-01-01',
                self::DEFAULT_START_DATE
            )
            ->addOption(
                self::OPTION_END_DATE,
                null,
                InputOption::VALUE_OPTIONAL,
                'End. Format: Y-m-d. Example: 2024-02-01',
                self::DEFAULT_END_DATE
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start execution:', OutputInterface::VERBOSITY_VERBOSE);
        $msg = sprintf(
            'From "%s" to "%s"',
            $this->startDate->format('Y-m-d'),
            $this->endDate->format('Y-m-d')
        );
        $output->writeln($msg, OutputInterface::VERBOSITY_VERBOSE);

        $this->populateCustomers($input, $output);

        return Command::SUCCESS;
    }

    private function populateCustomers(InputInterface $input, OutputInterface $output): void
    {
        $result = $this->mCustomerRepository->getLeads($this->startDate, $this->endDate);
        //$output->writeln('Array: ' . var_dump($result));

        foreach ($result as $mCustomer) {
            //$output->writeln('Id: ' . $mCustomer->getId() . ', Email: ' . $mCustomer->getEmail(), OutputInterface::VERBOSITY_VERBOSE);
            //$output->writeln('DefaultBilling: ' . $mCustomer->getDefaultBilling(), OutputInterface::VERBOSITY_VERBOSE);

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

    private function createCustomer(InputInterface $input, OutputInterface $output): void
    {
        $email = $input->getArgument('email');

        $this->getToken();

        //$token = $this->apiTokenService->getToken();
        //$url = $this->apiTokenService->getInstanceUrl();
        //$output->writeln('Token: ' . $token);
        //$output->writeln('Url: ' . $url);

        $result = $this->leadService->createCustomer($email, $this->url, $this->token);
        if (!$result) {
            $output->writeln('Something went wrong!');
        }
        $output->writeln('Array: ' . var_dump($result));

        $output->writeln('The customer created!');
    }

    private function getToken(): void
    {
        $this->token = $this->apiTokenService->getToken();
        $this->url = $this->apiTokenService->getInstanceUrl();
    }
}
