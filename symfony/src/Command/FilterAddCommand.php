<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Document\Filter;

class FilterAddCommand extends Command
{
    protected static $defaultName = 'app:filter:add';
    
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
            ->addArgument('key', InputArgument::REQUIRED, 'The key.')
            ->addArgument('value', InputArgument::REQUIRED, 'The value.')
            ->setDescription('Add a filter.');
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
        
        if (!$filter) {
            $filter = (new Filter())->setId($employee_id);
        }
        
        $document = $filter->getDocument();
        $document[$input->getArgument('key')] = $input->getArgument('value');
        $filter->setDocument($document);
        
        $this->dm->persist($filter);
        $this->dm->flush();
    }
}
