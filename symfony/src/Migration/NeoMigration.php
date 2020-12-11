<?php

namespace App\Migration;

use GraphAware\Neo4j\Client\ClientInterface;
use App\Connection\SamConnection;
use App\Service\SlugifyService;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\Employee;
use App\Normalizer\EmployeeNormalizer;
use App\Document\Position;

class NeoMigration
{
    /**
     * @var ClientInterface
     */
    private $graphClient;

    /**
     * @var SamConnection
     */
    private $samClient;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var SlugifyService
     */
    private $slugify;
    
    /**
     * @var DocumentManager
     */
    private $dm;

    /**
     * The alias for the Neo4j connection we are working with.
     *
     * @var string
     */
    private $connectionAlias = 'default';

    /**
     * Hard coded employee id of the superintendent.
     *
     * @todo Move to configuration.
     * @var string
     */
    private $superintendentEmployeeId = 'E07715';

    /**
     * @var array
     */
    private $centralLocations = [
        44,  // Central Office
        45,  // Old Cedar Lane School
        99,  // Mendenhall Building
        100, // Berger Road Building
        96,  // Dorsey Building
        95,  // Ascend One Center
        80,  // Ridge Road Building
        85,  // Warehouse
        13,  // Applications and Research Lab (ARL)
    ];

    public function __construct(ClientInterface $graphClient, SamConnection $samClient, Validator $validator, SlugifyService $slugify, DocumentManager $dm)
    {
        $this->graphClient = $graphClient;
        $this->samClient = $samClient;
        $this->validator = $validator;
        $this->slugify = $slugify;
        $this->dm = $dm;
    }

    /**
     * Perform the migration.
     */
    public function migrate($connectionAlias = null, bool $deleteOld = true, int $latency = 100)
    {
        $this->samClient->setLatency($latency);

        if ($connectionAlias) {
            $this->connectionAlias = $connectionAlias;
        }

        if ($deleteOld) {
            $this->graphClient->run('MATCH (n) DETACH DELETE n', null, null, $this->connectionAlias);
        }

        $superData = $this->samClient->findOne(['Employee_ID' => $this->superintendentEmployeeId]);
        $this->createEmployee($superData);
    }

    /**
     * Create the employee and all subordinates from the data array.
     *
     * @param array $data
     */
    private function createEmployee(array $data, $include_subordinates = true)
    {
        $positionKeys = [
            'Primary_Position', 'Position_2', 'Position_3', 'Position_4',
            'Position_5',
        ];

        $connection = 'default';

        $stack = $this->graphClient->stack(null, $this->connectionAlias);
        
        $employee = EmployeeNormalizer::normalize((new Employee())
            ->setId($data['Employee_ID'])
            ->setFirstName($data['First_Name'])
            ->setLastName($data['Last_Name'])
            ->setDisplayName($data['Display_Name'])
            ->setPhone($data['Work_Phone'])
            ->setEmail($data['mail'])
        , false);
        
        $override = $this->dm
            ->getRepository(Employee::class)
            ->find($data['Employee_ID']);

        if ($override) {
            $filter = EmployeeNormalizer::normalize($override);
            $employee = array_merge($employee, $filter);
        }
            
        $stack->push("CREATE (e:Employee {
            display_name: {display_name},
            employee_id:  {employee_id},
            first_name:   {first_name},
            last_name:    {last_name},
            email:        {email},
            phone:        {phone}
        })", $employee);

        foreach ($positionKeys as $weight => $positionKey) {
            if ($data[$positionKey . '_Job_Description']) {
                if (!$this->validator->validatePosition($positionKey, $data)) {
                    continue;
                }

                $locationCode = $data[$positionKey . '_Location_Code'];
                $location     = $data[$positionKey . '_Location'];
                $jobTitle     = $data[$positionKey . '_Job_Description'];
                $positionId   = $data['Employee_ID'] . "-$weight";

                // Create the location if it doesn't exist.
                $stack->push("MERGE (l$locationCode:Location {
                    code: {code},
                    name: {name}
                })", ['code' => $locationCode, 'name' => $location]);

                // Create the position and relate it to the location and
                // employee all at once.
                if ($filter = $this->dm->getRepository(Position::class)->find($positionId)) {
                    if ($description = $filter->getDescription()) {
                        $jobTitle = $description;
                    }
                }
                
                $stack->push("
                    MATCH (e:Employee),(l:Location)
                    WHERE e.employee_id = {employee_id} AND l.code = {code}
                    CREATE (e)-[:HAS_POSITION {primary: {primary}}]->(p:Position {
                        description: {description},
                        position_id: {position_id},
                        weight:      {weight}
                    })-[:IS_LOCATED_AT]->(l)
                ", [
                    'employee_id' => $data['Employee_ID'],
                    'description' => $jobTitle,
                    'code'        => $locationCode,
                    'position_id' => $positionId,
                    'weight'      => $weight,
                    'primary'     => $weight === 0,
                ]);

                // Create a relationship to the manager.
                if ($data[$positionKey . '_Manager']) {
                    $managerPosId = $data[$positionKey . '_Manager'] . '-0';

                    $stack->push("
                        MATCH (sp:Position),(mp:Position)
                        WHERE sp.position_id = {pid} AND mp.position_id = {mpid}
                        CREATE (sp)-[r:REPORTS_TO]->(mp)
                    ", ['pid' => $positionId, 'mpid' => $managerPosId]);
                }
            }
        }

        if ($departmentName = $data['Manager_s_Default_Supervisory_Organization']) {
            // Create the department.
            $stack->push("MERGE (d:Department {
                name: {name},
                slug: {slug}
            })", ['name' => $departmentName, 'slug' => $this->slugify->slugify($departmentName)]);

            // Associate this employee's primary position with the department.
            $stack->push("
                MATCH (d:Department),(p:Position)
                WHERE d.name = {name} AND p.position_id = {id}
                CREATE (d)-[r:IS_HEADED_BY]->(p)
            ", [
                'name' => $departmentName,
                'id'   => $data['Employee_ID'] . '-0',
            ]);

            // Associate the department with it's parent.
            $stack->push("
                MATCH
                    (p:Position)-[:REPORTS_TO]->(hp:Position)<-[:IS_HEADED_BY]-(pd:Department),
                    (d:Department)
                WHERE p.position_id = {position_id} AND d.name = {name}
                CREATE (d)-[:IS_DIVISION_OF]->(pd)
            ", [
                'position_id' => $data['Employee_ID'] . '-0',
                'name' => $departmentName,
            ]);
        }

        $this->graphClient->runStack($stack);

        if ($include_subordinates) {
            $subordinateData = $this->samClient->find([
                'Primary_Position_Manager' => $data['Employee_ID'],
            ]);

            if (!empty($subordinateData)) {
                foreach ($subordinateData as $report) {
                    if ($this->validator->validateEmployee($report)) {
                        $this->createEmployee($report);
                    }
                }
            }
        }
    }
}
