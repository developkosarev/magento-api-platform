<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\MagentoCron\CronVerificationServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: "magento:cron:verification",
    description: "Magento cron schedule verification",
    hidden: false
)]
class MagentoCronVerificationCommand extends Command
{
    private const OPTION_FORCE = 'force';

    private bool $force;

    public function __construct(
        private readonly CronVerificationServiceInterface $cronVerificationService,
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
        $this->cronVerificationService->execute($this->force);

        return Command::SUCCESS;
    }
}
