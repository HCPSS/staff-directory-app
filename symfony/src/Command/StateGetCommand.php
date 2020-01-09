<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Migration\NeoMigration;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Document\State;
use App\Service\StateService;
use Symfony\Component\Console\Input\InputArgument;

class StateGetCommand extends Command
{
    protected static $defaultName = 'app:state:get';

    /**
     * @var StateService
     */
    private $state;

    public function __construct(StateService $state)
    {
        $this->state = $state;

        parent::__construct();
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'The state name.')
            ->setDescription('Get the given state.');
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $key = $input->getArgument('name');
        $value = $this->state->get($key);

        $io = new SymfonyStyle($input, $output);
        $io->writeln($value);
    }
}
