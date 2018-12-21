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
   * @Route("/")
   */
  public function getDepartmentStaffAction(request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $staff_list = $em->getRepository('AppBundle:Staff');
    $dept_list = $em->getRepository('AppBundle:Department');

    $searchTerm = $request->query->get('given-name');
    $searchDeptTerm = $request->query->get('given-dept');
    $searchPhone = $request->query->get('given-phone');

    if ($searchTerm != null) {
      $name = $staff_list->findAllOrderedByName($searchTerm);
      $deptName = null;
      $phone = null;
    } elseif ($searchDeptTerm != null) {
      $deptName = $dept_list->findByName($searchDeptTerm);
      $name = null;
      $phone = null;
    } elseif ($searchPhone != null) {
      $phone = $staff_list->findStaffPhone($searchPhone);
      $name = null;
      $deptName = null;
    } else {
      $name = null;
      $deptName = null;
      $phone = null;
    }

    $isAjax = $request->isXmlHttpRequest();

    if ($name != null) {
      $b = array();
      foreach ($name as $staff) {
        if (in_array($staff->getEmail(), array_keys($b))) {
          $b[$staff->getEmail()]['departments'][] = $staff->getDepartment();
        } else {
          $b[$staff->getEmail()] = array(
            'firstName'=>$staff->getFirstName(),
            'lastName'=>$staff->getLastName(),
            'position'=>$staff->getPosition(),
            'email'=>$staff->getEmail(),
            'phone'=>$staff->getPhone(),
            'location'=>$staff->getLocation(),
            'departments'=>array($staff->getDepartment()),
          );
        }
      }
      $name = $b;
    }

    if ($phone != null) {
      $b = array();
      foreach ($phone as $staff) {
        if (in_array($staff->getEmail(), array_keys($b))) {
          $b[$staff->getEmail()]['departments'][] = $staff->getDepartment();
        } else {
          $b[$staff->getEmail()] = array(
            'firstName'=>$staff->getFirstName(),
            'lastName'=>$staff->getLastName(),
            'position'=>$staff->getPosition(),
            'email'=>$staff->getEmail(),
            'phone'=>$staff->getPhone(),
            'location'=>$staff->getLocation(),
            'departments'=>array($staff->getDepartment()),
          );
        }
      }
      $phone = $b;
    }

    return $this->render(
      'default/staff-name-render.html.twig', 
        ['staff'=>$name, 'dept'=>$deptName, 'phone'=>$phone, 'isAjax'=>$isAjax]       
    );
  }
}
