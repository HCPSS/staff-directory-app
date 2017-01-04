<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
  /**
   * @Route("/blog/{page}", name="blog_list", requirements={"page": "\d+"})
   */
  public function listAction($page = 1)
  {
      $url = $this->generateUrl(
        'blog_list',
        array('page' => '1')
      );
      return new Response('<html><body><h1>You found a page!</h1></body></html>');
  } 

  /**
   * @Route("/blog/{slug}", name="blog_show")
   */
  public function showAction($slug)
    {
      $url = $this->generateUrl(
        'blog_show',
        array('slug' => 'my-blog-post')
      );
      return new Response('<html><body><h1>You found me!</h1></body></html>');
    } 
}
