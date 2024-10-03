<?php
declare(strict_types=1);

namespace App\Command\Bloomreach;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: "bloomreach:customer:create",
    description: "Create customer",
    hidden: false
)]
class CustomerCreateCommand extends Command
{
    public function __construct(
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email of customer');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');


        $output->writeln('The customer created!');
        return Command::SUCCESS;
    }
}
