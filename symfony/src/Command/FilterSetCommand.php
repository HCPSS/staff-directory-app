<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Document\Filter;

class FilterSetCommand extends Command
{
    protected static $defaultName = 'app:filter:set';
    
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
            ->addArgument('filter', InputArgument::REQUIRED, 'The JSON formatted filter.')
            ->setDescription('Set a filter.');
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filter = (new Filter())
            ->setId($input->getArgument('employee_id'))
            ->setDocument(json_decode($input->getArgument('filter'), true));
        
        $this->dm->persist($filter);
        $this->dm->flush();
    }
}
