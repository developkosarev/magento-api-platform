<?php
declare(strict_types=1);

namespace App\Command\Bloomreach;

use App\Service\Bloomreach\Customer\CustomerServiceInterface;
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
        private readonly CustomerServiceInterface $customerService,
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

        $result = $this->customerService->createCustomer($email);

        if (!$result) {
            $output->writeln('Something went wrong!');
        }
        $output->writeln('The customer created!');
        return Command::SUCCESS;
    }
}
