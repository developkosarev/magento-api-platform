<?php
declare(strict_types=1);

namespace App\Command\Salesforce;

use App\Service\Salesforce\Customer\LeadCustomerServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use DateTime;

#[AsCommand(
    name: "salesforce:lead:populate",
    description: "Populate lead",
    hidden: false
)]
class LeadPopulateCommand extends Command
{
    private const OPTION_START_DATE = 'start-date';
    private const OPTION_END_DATE = 'end-date';
    private const DEFAULT_START_DATE = '2024-01-01';
    private const DEFAULT_END_DATE = '2024-02-01';

    private DateTime $startDate;

    private DateTime $endDate;

    public function __construct(
        private readonly LeadCustomerServiceInterface     $leadCustomerService,
        string                                            $name = null
    ) {
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
        $msg = sprintf(
            'from "%s" to "%s"',
            $this->startDate->format('Y-m-d'),
            $this->endDate->format('Y-m-d')
        );
        $output->writeln('Start execution: ' . $msg, OutputInterface::VERBOSITY_VERBOSE);

        $this->leadCustomerService->populateCustomers($this->startDate, $this->endDate);

        $output->writeln('Done', OutputInterface::VERBOSITY_VERBOSE);
        return Command::SUCCESS;
    }
}
