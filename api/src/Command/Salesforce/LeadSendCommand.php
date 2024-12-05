<?php
declare(strict_types=1);

namespace App\Command\Salesforce;

use App\Entity\Main\SalesforceCustomerLead;
use App\Repository\Main\SalesforceCustomerLeadRepository;
use App\Service\Salesforce\Common\ApiTokenService;
use App\Service\Salesforce\Customer\LeadSenderServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: "salesforce:lead:send",
    description: "Send lead",
    hidden: false
)]
class LeadSendCommand extends Command
{
    private string $token;
    private string $url;

    public function __construct(
        private readonly SalesforceCustomerLeadRepository $customerLeadRepository,
        private readonly ApiTokenService                  $apiTokenService,
        private readonly LeadSenderServiceInterface       $leadService,
        string                                            $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start execution', OutputInterface::VERBOSITY_VERBOSE);

        $this->getToken();

        $leads = $this->customerLeadRepository->findByStatusNew();
        foreach ($leads as $lead) {
            $result = $this->leadService->sendCustomer($lead, $this->url, $this->token);
            //var_dump($result);
            //$data = json_decode($result, true);

            //'[{"leadId":"00Q9V00000KTZ6wUAH","type":"Lead creation","status":"success"}]'
            //root@dfee02c6a92a:/app# php bin/console salesforce:lead:send
            //int(200)
            //string(75) "[{"leadId":"00Q9V00000KTaSnUAL","type":"Lead creation","status":"success"}]"

            $lead
                ->setLeadId($result[0]['leadId'])
                ->setDescription($result[0]['type'])
                ->setStatus($result[0]['status'])
                ->setStatus(SalesforceCustomerLead::STATUS_PROCESSED);

            $this->customerLeadRepository->add($lead);
        }

        $output->writeln('Done', OutputInterface::VERBOSITY_VERBOSE);
        return Command::SUCCESS;
    }

    private function createCustomer(InputInterface $input, OutputInterface $output): void
    {
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
