<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Document\Filter;

class FilterRemoveCommand extends Command
{
    protected static $defaultName = 'app:filter:remove';
    
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
            ->addArgument('employee_id', InputArgument::REQUIRED, 'The employee id (E Number).')
            ->setDescription('Remove a filter.');
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $employee_id = $input->getArgument('employee_id');
        $filter = $this->dm
            ->getRepository(Filter::class)
            ->find($employee_id);
        
        if ($filter) {
            $this->dm->remove($filter);
            $this->dm->flush();
            
            $output->writeln('Success.');
        } else {
            $output->writeln('Not found.');
        }
    }
}
