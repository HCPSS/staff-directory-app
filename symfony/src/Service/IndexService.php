<?php

namespace App\Service;

use Elastica\Client as EsClient;
use GraphAware\Neo4j\Client\ClientInterface as NeoClient;
use Elastica\Index;
use GraphAware\Bolt\Record\RecordView;
use Elastica\Document;

class IndexService
{
    /**
     * @var EsClient
     */
    private $es;
    
    /**
     * @var NeoClient
     */
    private $neo;
    
    /**
     * @var StateService
     */
    private $state;
    
    public function __construct(EsClient $es, NeoClient $neo, StateService $state)
    {
        $this->es = $es;
        $this->neo = $neo;
        $this->state = $state;
    }
    
    /**
     * Refresh the index.
     */
    public function refresh()
    {
        $index          = $this->refreshIndex('directory');
        $employeeType   = $index->getType('employee');
        
        $empDocs = array_map(function ($employee) {
            return new Document($employee['id'], $employee);
        }, $this->getAllEmployees());
            
        $employeeType->addDocuments($empDocs);
            
        $employeeType->getIndex()->refresh();
    }
    
    /**
     * Render the employee as a string.
     *
     * @param array $employee
     * @return string
     */
    public function render(array $employee): string
    {
        $e = $employee;
        
        $out = $e['display_name'] ?: $e['first_name'] . ' ' . $e['last_name'];
        $out .= "\n";
        $out .= $e['phone'] . "\n";
        $out .= $e['email'] . "\n";
        $out .= implode("\n", $e['positions']) . "\n";
        $out .= implode("\n", $e['locations']);
        
        return $out;
    }
    
    /**
     * get all departments as a data array ready for elasticsearch.
     *
     * @return array
     */
    private function getAllDepartments(): array
    {
        $response = $this->neo->run("MATCH (d:Department) RETURN d");
        
        return array_map(function (RecordView $record) {
            $node = $record->get('d');
            $department = $node->asArray();
            $department['id'] = $node->identity();
            $department['fulltext'] = $department['name'];
            
            return $department;
        }, $response->records());
    }
    
    /**
     * Get all the employees as a data array ready for elasticsearch.
     *
     * @return array
     */
    private function getAllEmployees(): array
    {
        $response = $this->neo->run("
            MATCH (e:Employee)-[:HAS_POSITION]->(p:Position)-[:IS_LOCATED_AT]->(l:Location)
            RETURN e, p.description, l.name
        ", null, null, $this->state->get('graph.connection.active'));
        
        $employees = [];
        foreach ($response->records() as $record) {
            $eNode = $record->get('e');
            if (!in_array($eNode->identity(), array_keys($employees))) {
                $id = $eNode->identity();
                
                $employees[$id] = $eNode->asArray();
                $employees[$id]['id'] = $eNode->identity();
            }
            
            $employees[$id]['positions'][] = $record->get('p.description');
            $employees[$id]['locations'][] = $record->get('l.name');
        }
        
        return array_map(function ($employee) {
            $employee['fulltext'] = $this->render($employee);
            
            return $employee;
        }, array_values($employees));
    }
    
    /**
     * Refresh index.
     *
     * @param string $name
     * @return \Elastica\Index
     */
    private function refreshIndex(string $name): Index
    {
        $index = $this->es->getIndex($name);
        
        $index->create([
            'number_of_shards' => 4,
            'number_of_replicas' => 1,
        ], true);
        
        return $index;
    }
}
