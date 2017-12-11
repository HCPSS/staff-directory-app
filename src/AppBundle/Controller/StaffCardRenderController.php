<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Staff;
use AppBundle\Entity\Department;
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
    $dept_list = $em->getRepository('AppBundle:Department');

    $searchTerm = $request->query->get('given-name');
    $searchDeptTerm = $request->query->get('given-dept');

    if ($searchTerm != null) {
      $name = $staff_list->findAllOrderedByName($searchTerm);
      $deptName = null;
    } elseif ($searchDeptTerm != null) {
      $deptName = $dept_list->findByName($searchDeptTerm);
      $name = null;
    } else {
      $name = null;
      $deptName = null;
    }

    $isAjax = $request->isXmlHttpRequest();

    return $this->render(
      'default/staff-name-render.html.twig', 
        ['staff'=>$name, 'dept'=>$deptName, 'isAjax'=>$isAjax]       
    );
  }
}
