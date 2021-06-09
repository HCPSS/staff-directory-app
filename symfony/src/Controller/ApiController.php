<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Migration\NeoMigration;
use App\Service\StateService;
use App\Service\IndexService;

/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{
    /**
     * @var NeoMigration
     */
    private $migration;
    
    /**
     * @var StateService
     */
    private $state;
    
    /**
     * @var IndexService
     */
    private $indexService;
    
    public function __construct(NeoMigration $migration, StateService $state, IndexService $indexService)
    {
        $this->migrator = $migration;
        $this->state = $state;
        $this->indexService = $indexService;
    }
    
    /**
     * @Route("/data-refresh", name="data_refresh")
     */
    public function refresh()
    {
        $start = time();
        $activeConnection = $this->state->get('graph.connection.active');
        $this->migrator->migrate($activeConnection, true);
        $duration = time() - $start;
        
        return new Response("Data refresh complete in $duration seconds.");
    }
    
    /**
     * @Route("/data-index", name="data_index")
     */
    public function index()
    {        
        $start = time();
        $this->indexService->refresh();
        $duration = time() - $start;
        
        return new Response("Data index complete in $duration seconds.");
    }
}
