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
    $em = $this->getDoctrine()->getManager();
    $staff_list = $em->getRepository('AppBundle:Staff')
      ->findAllOrderedByName();

    return $this->render('default/test.html.twig', array('staff'=>$staff_list));
  }
}
