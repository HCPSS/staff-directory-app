<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataController extends Controller {
    
    /**
     * @Route("dump")
     */
    public function dumpAction()
    {
        $em = $this->getDoctrine()->getManager();
        $depts = $em->getRepository('AppBundle:Department')->findAll();
        $people = $em->getRepository('AppBundle:Staff')->findAll();

        $data = [
            'departments' => [],
            'staff' => [],
        ];
        
        foreach ($depts as $department) {
            $data['departments'][] = $department->toArray();
        }
        
        foreach ($people as $person) {
            $data['staff'][] = $person->toArray();
        }
            
        return new JsonResponse($data);
    }
}
