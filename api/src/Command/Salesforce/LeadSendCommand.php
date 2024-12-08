<?php
declare(strict_types=1);

namespace App\Command\Salesforce;

use App\Service\Salesforce\Customer\LeadCustomerServiceInterface;
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
    public function __construct(
        private readonly LeadCustomerServiceInterface $leadCustomerService,
        string                                        $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start execution', OutputInterface::VERBOSITY_VERBOSE);

        $this->leadCustomerService->sendCustomers();;

        $output->writeln('Done', OutputInterface::VERBOSITY_VERBOSE);
        return Command::SUCCESS;
    }
}
