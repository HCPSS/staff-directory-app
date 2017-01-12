<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Staff;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RouteCollection;

class DeptPageController extends Controller
{

  public function getDepartmentPageAction()
  {
    $routes = new RouteCollection();
    $routes->add('department_page', new Route('/departments/{slug}'));

    $context = new RequestContext('/');

    $generator = new UrlGenerator($routes, $context);

    $url = $generator->generate('department_page', array(
        'slug' => 'assessment',
    ));
  }

}
