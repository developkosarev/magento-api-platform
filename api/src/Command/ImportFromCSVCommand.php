<?php
declare(strict_types=1);

namespace App\Command;

use App\Repository\OrdersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: "import:import-from-csv",
    description: 'This command imports from a csv file.'
)]
class ImportFromCSVCommand extends Command
{
    private const OPTION_FORCE = 'force';

    const OPTION_IMPORT_ORDERS = 'import-orders';

    private const FILE_ORDERS = '/app/var/data/orders.csv';

    private bool $force;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EntityManagerInterface $em,
        private readonly OrdersRepository $ordersRepository,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->force = $input->getOption(self::OPTION_FORCE);
    }

    protected function configure()
    {
        $this
            ->addOption(
                self::OPTION_FORCE,
                null,
                InputOption::VALUE_NONE,
                'Create records in DB'
            )
            ->addOption(
                self::OPTION_IMPORT_ORDERS,
                null,
                InputOption::VALUE_NONE,
                'It imports orders, invoices from csv file'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $msg = sprintf('Start execution command "%s %s"', $this->getName(), $this->toStringOptions($input));
        $this->logger->info($msg);
        $output->writeln($msg);

        if ($input->getOption(self::OPTION_IMPORT_ORDERS)) {
            $this->importOrdersFromCSV($output);
        }

        $msg = 'Execution finished';
        $this->logger->info($msg);
        $output->writeln($msg);

        return Command::SUCCESS;
    }

    /**
     * @throws \Exception
     */
    private function importOrdersFromCSV(OutputInterface $output)
    {
        if (!file_exists(self::FILE_ORDERS)) {
            throw new \Exception('File of orders "'.self::FILE_ORDERS.'" not found!');
        }

        $batchSize = 1000;

        $i = 0;
        $headerValid = false;
        $rowNo = 0;

        if (($fp = fopen(self::FILE_ORDERS, "r")) !== false) {
            while (($row = fgetcsv($fp, 2000, ",")) !== false) {
                $rowNo++;
                if ($rowNo === 1) {
                    if ($row[0] === 'entity_id' && $row[1] === 'mp_gift_cards') {
                        $headerValid = true;
                    }
                    continue;
                }

                if (!$headerValid) {
                    continue;
                }

                $entityId = $row[0];
                $mpGiftCards = $row[1];
                $mpGiftCards = str_replace('{','"{"',$mpGiftCards);

                $order = $this->ordersRepository->find($entityId);
                if ($order === null) {
                    continue;
                }

                if ($this->force) {
                    $order->setMpGiftCards($mpGiftCards);
                    $this->em->persist($order);

                    if (($i % $batchSize) === 0) {
                        $this->em->flush();
                        $this->em->clear();

                       $msg = sprintf('Updated order "%d"', $i);
                       $this->logger->info($msg);
                       $output->writeln($msg);
                    }
                }

                $i++;
            }
            fclose($fp);
        }

        if ($this->force) {
            $this->em->flush();

            $msg = sprintf('Updated "%d" orders', $i);
            $this->logger->info($msg);
            $output->writeln($msg);
        } else {
            $output->writeln(sprintf('We can import "%d" orders', $i));
        }
    }

    /**
     * @param InputInterface $input
     * @return string
     */
    private function toStringOptions(InputInterface $input): string
    {
        $options = '';
        $options .= $input->getOption(self::OPTION_IMPORT_ORDERS) ? ' --' . self::OPTION_IMPORT_ORDERS : '';
        $options .= $input->getOption(self::OPTION_FORCE) ? ' --' . self::OPTION_FORCE : '';

        return $options;
    }
}
