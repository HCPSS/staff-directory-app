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
  public function getDepartmentStaffAction(request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $staff_list = $em->getRepository('AppBundle:Staff');

    $searchTerm = $request->query->get('given-name');

    if ($searchTerm != null) {
      $name = $staff_list->findAllOrderedByName($searchTerm);
    } else {
      $name = null;
    }

    return $this->render(
      'default/staff-search.html.twig', 
      array('staff'=>$name)
    );
  }
}
