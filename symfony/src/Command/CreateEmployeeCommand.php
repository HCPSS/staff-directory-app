<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Staff;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Department;
use App\Entity\Location;
use Symfony\Component\Console\Input\InputOption;

class CreateEmployeeCommand extends Command
{
    protected static $defaultName = 'app:employee:create';
    
    /**
     * @var EntityManager
     */
    private $em;
    
    /**
     * @var Client
     */
    private $client;
    
    public function __construct(Client $client, EntityManagerInterface $em)
    {
        $this->client = $client;
        $this->em = $em;
        
        parent::__construct();
    }
    
    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this
            ->addArgument('employee_id', InputArgument::REQUIRED, 'The employee ID.')
            ->addArgument('location_id', InputArgument::REQUIRED, 'The location ID.')
            ->addArgument('department_ids', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The department IDs.')
            ->addOption('position', 'p', InputOption::VALUE_REQUIRED, 'Specify the position.');
    }
    
    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->client->get('search/user', ['query' => ['q' => [
            'Employee_ID' => $input->getArgument('employee_id'),
        ]]]);
        
        $data = json_decode($response->getBody()->getContents(), true);
        
        if (count($data['message']) < 1) {
            throw new \Exception('Not found.');
        }
        
        if (count($data['message']) > 1) {
            throw new \Exception('Not found.');
        }
        
        $employee = $data['message'][0];
        
        $staff = new Staff();
        $staff
            ->setEmail($employee['mail'])
            ->setPhone($employee['Work_Phone'])
            ->setEmployeeId($employee['Employee_ID'])
            ->setFirstName($employee['First_Name'])
            ->setLastName($employee['Last_Name']);
        
        if ($position = $input->getOption('position')) {
            $staff->setPosition($position);
        } else {
            $staff->setPosition($employee['Primary_Position_Job_Description']);
        }
        
        $location = $this->em
            ->getRepository(Location::class)
            ->find($input->getArgument('location_id'));
        
        $staff->setLocation($location);
            
        foreach ($input->getArgument('department_ids') as $department_id) {
            $department = $this->em
                ->getRepository(Department::class)
                ->find($department_id);
            
            $staff->addDepartment($department);
        }
        
        $this->em->persist($staff);
        $this->em->flush();
    }
}
