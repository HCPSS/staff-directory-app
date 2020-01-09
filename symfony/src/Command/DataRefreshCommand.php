<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Migration\NeoMigration;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\State;
use App\Service\StateService;
use Symfony\Component\Console\Input\InputArgument;

class DataRefreshCommand extends Command
{
    protected static $defaultName = 'app:data:refresh';

    /**
     * @var NeoMigration
     */
    protected $migrator;

    /**
     * @var StateService
     */
    protected $state;

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this
            ->addArgument('latency', InputArgument::OPTIONAL, 'Latency in milliseconds. Increase to avoid overloading the SAM service.', 100)
            ->setDescription('Refresh app data.');
    }

    public function __construct(NeoMigration $migrator, StateService $state)
    {
        $this->migrator = $migrator;
        $this->state = $state;

        parent::__construct();
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = time();

        $activeConnection = $this->state->get('graph.connection.active', 'green');
        $passiveConnection = $activeConnection == 'green' ? 'blue' : 'green';
        $latency = $input->getArgument('latency');

        $this->migrator->migrate($passiveConnection, true, $latency);

        $this->state->set('graph.connection.active', $passiveConnection);

        $duration = time() - $start;

        $io = new SymfonyStyle($input, $output);
        $io->writeln("Data refresh complete in $duration seconds.");
    }
}
