<?php
declare(strict_types=1);

namespace App\Command\Bloomreach;

use App\Service\Bloomreach\Customer\CustomerSegmentFileImport;
use App\Service\Bloomreach\Customer\CustomerSegmentImportInterface;
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
    private const SEGMENT_ID_ARGUMENT_NAME = 'segment_id';
    private const WEBSITE_ID_ARGUMENT_NAME = 'website_id';
    private const OPTION_FORCE = 'force';
    private bool $force;

    public function __construct(
        private readonly CustomerSegmentFileImport $fileImport,
        private readonly CustomerSegmentImportInterface $customerSegmentImport,
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
            ->addArgument(
                self::SEGMENT_ID_ARGUMENT_NAME,
                InputArgument::REQUIRED,
                'Segment ID for which customers should be imported'
            )
            ->addArgument(
                self::WEBSITE_ID_ARGUMENT_NAME,
                InputArgument::REQUIRED,
                'Website ID for which customers should be imported'
            )
            ->addOption(
                self::OPTION_FORCE,
                null,
                InputOption::VALUE_NONE,
                'Create records in DB'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = microtime(true);

        $segmentId = (int) $input->getArgument(self::SEGMENT_ID_ARGUMENT_NAME);
        $websiteId = (int) $input->getArgument(self::WEBSITE_ID_ARGUMENT_NAME);

        $msg = "<info>Starting import for segment #{$segmentId} and website {$websiteId}</info>";
        $this->logger->info($msg);
        $output->writeln($msg);

        //$fileName = $this->fileImport->getFileName($segmentId);
        //$output->writeln($fileName);

        if ($this->fileImport->uploadFile($segmentId)) {
            $fileNameLocal = $this->fileImport->getFileNameLocal($segmentId);
            $output->writeln($fileNameLocal);

            $this->customerSegmentImport->setForce($this->force);
            $this->customerSegmentImport->setOutput($output);
            $this->customerSegmentImport->execute($segmentId, $websiteId, $fileNameLocal);

            if (file_exists($fileNameLocal)) {
                unlink($fileNameLocal);
            }
        }

        //if ($input->getOption(self::OPTION_IMPORT_ORDERS)) {
        //    $this->importOrdersFromCSV($output);
        //}

        $msg = "<info>Import for segment #{$segmentId} and website {$websiteId} completed</info>";
        $output->writeln($msg);
        $this->logger->info($msg);

        $end = microtime(true);
        $executionTime = round($end - $start, 2);
        $output->writeln("<info>Memory: {$this->getMemoryUsage()}MB</info>", OutputInterface::VERBOSITY_VERBOSE);
        $output->writeln("<info>Time: {$executionTime}s</info>", OutputInterface::VERBOSITY_VERBOSE);

        return Command::SUCCESS;
    }

    private function getMemoryUsage(): float
    {
        $memUsage = memory_get_usage(true);
        return round($memUsage / 1048576, 2);
    }
}
