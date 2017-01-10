<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Staff;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class StaffCardRenderController extends Controller
{

  /**
   * @Route("/directory")
   */
  public function getStaffAction(request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $staff_list = $em->getRepository('AppBundle:Staff');

    $searchTerm = $request->query->get('department');

    $department = $staff_list->findByDepartment($searchTerm);

    return $this->render(
    	'default/staff-card.html.twig', 
    	array('staff'=>$department)
    );
  }

}
