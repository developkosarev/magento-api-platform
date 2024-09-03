<?php
declare(strict_types=1);

namespace App\Command;

use App\Email\Newsletter\SubscribeConfirm;
use App\Service\BloomreachMailer\SenderServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: "app:send:email",
    description: "Send email via service",
    hidden: false
)]
class SendEmailCommand extends Command
{
    public function __construct(
        private readonly SenderServiceInterface $senderService,
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

        $subscribeConfirm = new SubscribeConfirm();
        $subscribeConfirm
            ->setEmail($email)
            ->setConfirmCode('1')
            ->setWebsiteId(1)
            ->setStoreId(1);

        $this->senderService->sendEmail($subscribeConfirm);

        $output->writeln('The email was sent!');
        return Command::SUCCESS;
    }
}
