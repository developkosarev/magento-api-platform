<?php
declare(strict_types=1);

namespace App\Command\Salesforce;

use App\Service\Salesforce\Common\ApiTokenService;
use App\Service\Salesforce\Customer\CustomerServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: "salesforce:customer:create",
    description: "Create customer",
    hidden: false
)]
class CustomerCreateCommand extends Command
{
    public function __construct(
        private readonly ApiTokenService $apiTokenService,
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

        $token = $this->apiTokenService->getToken();
        $url = $this->apiTokenService->getInstanceUrl();
        //$output->writeln('Token: ' . $token);
        //$output->writeln('Url: ' . $url);

        $result = $this->customerService->createCustomer($email, $url, $token);
        if (!$result) {
            $output->writeln('Something went wrong!');
        }
        $output->writeln('Array: ' . var_dump($result));

        $output->writeln('The customer created!');
        return Command::SUCCESS;
    }
}
