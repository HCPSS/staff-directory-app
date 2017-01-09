<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Staff;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DeptOptionsController extends Controller
{

  public function deptOptListAction()
  {

    $em = $this->getDoctrine()->getManager();
    $depts = $em->getRepository('AppBundle:Staff')
      ->findDeptOrderedByNameOnce();

    return $this->render(
      'default/dept-options.html.twig',
      array('staff' => $depts)
    );
  }
}
