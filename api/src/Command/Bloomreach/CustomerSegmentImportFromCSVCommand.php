<?php
declare(strict_types=1);

namespace App\Command\Bloomreach;

use App\Service\Bloomreach\Customer\CustomerServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: "bloomreach:customer-segment:import",
    description: "Import customer segment from CSV file",
    hidden: false
)]
class CustomerSegmentImportFromCSVCommand extends Command
{
    private const OPTION_FORCE = 'force';
    private bool $force;

    public function __construct(
        private readonly LoggerInterface $logger,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->force = $input->getOption(self::OPTION_FORCE);
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                self::OPTION_FORCE,
                null,
                InputOption::VALUE_NONE,
                'Create records in DB'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $msg = sprintf('Start execution command "%s"', $this->getName());
        $this->logger->info($msg);
        $output->writeln($msg);

        //if ($input->getOption(self::OPTION_IMPORT_ORDERS)) {
        //    $this->importOrdersFromCSV($output);
        //}

        $msg = 'Execution finished';
        $this->logger->info($msg);
        $output->writeln($msg);

        return Command::SUCCESS;
    }
}
