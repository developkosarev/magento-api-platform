<?php
declare(strict_types=1);

namespace App\Command;

use App\Email\Newsletter\SubscribeConfirm;
use App\Message\ExternalEmail;
use App\Repository\Main\EmailLogRepository;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\Bloomreach\Mailer\SenderServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: "magento:cron:verification",
    description: "Magento cron schedule verification",
    hidden: false
)]
class MagentoCronVerificationCommand extends Command
{
    public function __construct(
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email of customer')
            ->addArgument('language', InputArgument::REQUIRED, 'Language')
            ->addArgument('queue', InputArgument::OPTIONAL, 'Send via queue', true);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $language = $input->getArgument('language');



        return Command::SUCCESS;
    }
}
