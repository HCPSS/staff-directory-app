<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Staff;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends Controller
{
  /**
   * @Route("/test/book")
   */
  public function staffAction()
  {

    $staff = new Staff();
    $name = $staff->setName('John Adams');
    $deparmtment = $staff->setDepartment('Assessment');
    $position = $staff->setPosition('Director');
    $phone = $staff->setPhone('410-313-1257');
    $email = $staff->setEmail(null);
    $location = $staff->setLocation('Central Office');

    $em = $this->get('doctrine')->getManager();
    $em->persist($staff);
    $em->flush();

    return new Response('Saved new product with id '.$staff->getId());
  }
}
