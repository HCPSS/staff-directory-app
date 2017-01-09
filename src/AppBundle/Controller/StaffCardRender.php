<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Staff;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class StaffCardRender extends Controller
{
  /**
   * @Route("/directory")
   */
  public function getStaffAction(request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $staff_list = $em->getRepository('AppBundle:Staff')
      ->findAllOrderedByName();

    $searchTerm = $request->query->get('department');
    var_dump($searchTerm);

    return $this->render(
    	'default/staff-card.html.twig', 
    	array('staff'=>$staff_list)
    );
  }

}
