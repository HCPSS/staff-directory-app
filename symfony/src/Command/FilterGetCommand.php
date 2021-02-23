<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Document\Filter;

class FilterGetCommand extends Command
{
    protected static $defaultName = 'app:filter:get';
    
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
        
        parent::__construct();
    }
    
    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this
            ->addArgument('employee_id', InputArgument::OPTIONAL, 'The employee id (E Number).')
            ->setDescription('Get a filter.');
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filters = [];
        if ($id = $input->getArgument('employee_id')) {
            $filter = $this->dm->getRepository(Filter::class)->find($id);
            if ($filter) {
                $filters[] = $filter;
            }
        } else {
            $filters = $this->dm->getRepository(Filter::class)->findAll();
        }
        
        if (empty($filters)) {
            $output->writeln('No filters found.');
        } else {
            foreach ($filters as $filter) {
                $output->writeln($filter->getId());
                $output->writeln(json_encode($filter->getDocument(), JSON_PRETTY_PRINT));
                $output->writeln('');
            }
        }
    }
}
