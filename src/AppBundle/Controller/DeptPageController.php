<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Staff;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DeptPageController extends Controller
{
  /**
   * @Route("/directory/departments")
   */
  public function deptOptListAction()
  {

    $em = $this->getDoctrine()->getManager();
    $depts = $em->getRepository('AppBundle:Staff')
      ->findDeptOrderedByNameOnce();

    return $this->render(
      'default/dept-options.html.twig',
      ['staff' => $depts]
    );
  }
  /**
    * @Route("/directory/departments/{slug}", name="department")
    */
  public function getDepartmentPageAction($slug)
  {
    $repo = $this->getDoctrine()
    ->getRepository('AppBundle:Department')
    ->findOneBy(array('slug' => $slug));

    return $this->render(
      '::Department/department.html.twig',
      ['department' => $repo]
    );
  }
}