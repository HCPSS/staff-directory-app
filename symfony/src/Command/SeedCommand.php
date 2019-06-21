<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Location;
use App\Entity\Department;
use App\Entity\Staff;

class SeedCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:seed';
    
    /**
     * @var Client
     */
    private $directoryClient;
    
    /**
     * @var Client
     */
    private $samClient;
    
    /**
     * @var EntityManagerInterface
     */
    private $em;
    
    public function __construct(Client $directoryClient, Client $samClient, EntityManagerInterface $em)
    {
        $this->directoryClient = $directoryClient;
        $this->samClient = $samClient;
        $this->em = $em;
        
        parent::__construct();
    }
    
    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this->setDescription('Seeds data.');
    }
    
    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {        
        $response = $this->directoryClient->get('/dump');
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        
        $this->createLocations();
        $departments = $this->createDepartments($data['departments']);
        $this->setRelatedDepartments($departments);
        $this->createStaff($data['staff'], $departments);
    }
    
    /**
     * Set related departments.
     * 
     * @param Department[] $departments
     */
    private function setRelatedDepartments(array $departments)
    {
        foreach ($departments as $id => $department) {
            if (!$department->getDescription()) {
                continue;
            }
            
            $description = $department->getDescription();
            $parts = explode('|', $description);
            foreach ($parts as $part) {
                $matches = [];
                preg_match('/\<a href=".+"\>(.+)\<\/a\>/', $part, $matches);
                $name = $matches[1];
                $related = $this->em
                    ->getRepository(Department::class)
                    ->findOneBy(['name' => $name]);
                
                if ($related) {
                    $department->addRelatedDepartment($related);
                }
            }
            
            $this->em->persist($department);
        }
        
        $this->em->flush();
    }
    
    /**
     * Create departments.
     * 
     * @param array $departmentsData
     * @return Department[]
     */
    private function createDepartments(array $departmentsData) : array
    {
        $departments = [];
        
        foreach ($departmentsData as $data) {
            $department = new Department();
            $department->setName($data['name']);
            $department->setDescription($data['description']);
            
            $location = $this->getLocationByName($data['location']);            
            if (!$location) {
                throw new \Exception('no location for ' . $data['location']);
            }            
            $department->setLocation($location);
            
            if ($data['phone']) {
                $phone = preg_replace('/[^0-9]/', '', $data['phone']);
                $department->setPhone($phone);
            }
            
            $this->em->persist($department);
            
            $departments[$data['id']] = $department;
        }
        
        $this->em->flush();
        
        return $departments;
    }
    
    /**
     * Get the location from the given name.
     * 
     * @param string $name
     * @return Location|NULL
     */
    private function getLocationByName(string $name) : ?Location
    {
        $name = trim($name);
        
        $locations = $this->em->getRepository(Location::class)->findBy([
            'name' => $name,
        ], null, 1);
        
        return empty($locations) ? null : $locations[0];
    }
    
    /**
     * Create staff.
     * 
     * @param array $staffData
     */
    private function createStaff(array $staffData, array $departments)
    {        
        foreach ($staffData as $data) {
            $staff = $this->em
                ->getRepository(Staff::class)
                ->findBy(['employeeId' => $data['employee_id']]);
            
            if (!$staff) {
                $staff = new Staff();
                $staff
                    ->setFirstName($data['first_name'])
                    ->setLastName($data['last_name'])
                    ->setPosition($data['position'])
                    ->setEmail($data['email'])
                    ->setPhone($data['phone'])
                    ->setEmployeeId($data['employee_id']);
                
                $location = $this->getLocationByName($data['location']);
                if (!$location) {
                    throw new \Exception("Location {$data['location']} not found");
                }
                $staff->setLocation($location);
            }
            
            $staff->addDepartment($departments[$data['department']]);
            
            $this->em->persist($staff);
        }
        
        $this->em->flush();
    }
    
    /**
     * Create the locations.
     * 
     * @return Location[]
     */
    private function createLocations() : array
    {
        $locations = [];
        
        foreach ([
            [
                'name' => 'Central Office',
                'address' => '10910 Clarksville Pike',
                'city' => 'Ellicott City',
                'zip' => '21042',
                'latitude' => '39.2356777',
                'longitude' => '-76.8918174',
            ],[
                'name' => 'Ascend One Center',
                'address' => '8930 Stanford Blvd',
                'city' => 'Columbia',
                'zip' => '21045',
                'latitude' => '39.1927517',
                'longitude' => '-76.8194123',
            ],[
                'name' => 'Old Cedar Lane School',
                'address' => '5451 Beaverkill Road',
                'city' => 'Columbia',
                'zip' => '21044',
                'latitude' => '39.2248897',
                'longitude' => '-76.8883324',
            ],[
                'name' => 'Mendenhall Building',
                'address' => '9020 Mendenhall Court',
                'city' => 'Columbia',
                'zip' => '21045',
                'latitude' => '39.1866241',
                'longitude' => '-76.8300463',
            ],[
                'name' => 'Ridge Road',
                'address' => '8800 Ridge Road',
                'city' => 'Ellicott City',
                'zip' => '21043',
                'latitude' => '39.2788725',
                'longitude' => '-76.8169346',
            ],[
                'name' => 'Dorsey Building',
                'address' => '9250 Bendix Road',
                'city' => 'Columbia',
                'zip' => '21045',
                'latitude' => '39.2372089',
                'longitude' => '-76.8304969',
            ],[
                'name' => 'Judy Center',
                'address' => '6700 Cradlerock Way',
                'city' => 'Columbia',
                'zip' => '21045',
                'latitude' => '39.1916389',
                'longitude' => '-76.8453511',
            ],[
                'name' => 'Warehouse',
                'address' => '6675 Amberton Drive',
                'city' => 'Elkridge',
                'zip' => '21075',
                'latitude' => '39.188286',
                'longitude' => '-76.7497146',
            ],[
                'name' => 'Applications and Research Lab',
                'address' => '10920 Clarksville Pike',
                'city' => 'Ellicott City',
                'zip' => '21042',
                'latitude' => '39.2355139',
                'longitude' => '-76.8946194',
            ],[
                'name' => 'Wilde Lake High School',
                'address' => '5460 Trumpeter Road',
                'city' => 'Columbia',
                'zip' => '21044',
                'latitude' => '39.2173793',
                'longitude' => '-76.8748253',
            ],[
                'name' => 'Berger Road Building',
                'address' => '9200 Berger Rd.',
                'city' => 'Columbia',
                'zip' => '21046',
                'latitude' => '39.177795',
                'longitude' => '-76.8307197',
            ],
        ] as $data) {
            $location = new Location();
            
            $location
                ->setName($data['name'])
                ->setAddressStreet1($data['address'])
                ->setCity($data['city'])
                ->setState('MD')
                ->setZip($data['zip'])
                ->setLatitude($data['latitude'])
                ->setLongitude($data['longitude']);
            
            $this->em->persist($location);
            
            $locations[] = $location;
        }
        
        $this->em->flush();
        
        return $locations;
    }
}
