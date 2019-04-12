<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Model\Search;
use AppBundle\Form\SearchForm;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StaffCardRenderController extends Controller
{
    /**
     * @Route("/")
     */
    public function getDepartmentStaffAction(request $request)
    {
        $search = new Search();
        $form = $this->createForm(SearchForm::class, $search, [
            'method' => 'get',
        ]);
        $form->handleRequest($request);

        $staff = [];
        $departments = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            switch ($search->getDomain()) {
                case 'staff':
                    $staff = $em
                        ->getRepository('AppBundle:Staff')
                        ->findAllOrderedByName($search->getTerm());
                    break;
                case 'department':
                    $departments = $em
                        ->getRepository('AppBundle:Department')
                        ->findByName($search->getTerm());
                    break;
                case 'phone':
                    $staff = $em
                        ->getRepository('AppBundle:Staff')
                        ->findStaffPhone($search->getTerm());
                    break;
            }
        }

        return $this->render('default/home.html.twig', [
            'form' => $form->createView(),
            'staff' => $staff,
            'departments' => $departments,
            'isAjax' => $request->isXmlHttpRequest(),
        ]);
    }
}
