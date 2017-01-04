<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Staff;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FromDatabaseController extends Controller
{
  /**
   * @Route("/test/assessment")
   */
  public function getStaffAction()
  {
    $repo = $this->getDoctrine()->getRepository('AppBundle:Staff');

    // dynamic method names to find a staff member(s) based on a column value
    $staff_list = $repo->findAll();

    return $this->render('default/test.html.twig', array('staff'=>$staff_list));
  }
}
