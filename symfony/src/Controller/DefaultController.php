<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;
use FOS\ElasticaBundle\Finder\FinderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Elastica\Query\Wildcard;
use Elastica\Search;
use Elastica\Query\Term;
use Elastica\Query\MultiMatch;

class DefaultController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var FinderInterface
     */
    private $finder;

    public function __construct(EntityManagerInterface $em, FinderInterface $finder)
    {
        $this->em = $em;
        $this->finder = $finder;
    }

    /**
     * @Route("/", name="home")
     */
    public function home(Request $request)
    {
        $results = null;
        $search = new \stdClass();
        $search->query = '';

        $form = $this->createFormBuilder($search, [
            'csrf_protection' => false,
            'attr' => ['class' => 'contents dir-search smtb-mg']
        ])
            ->setMethod('GET')
            ->add('query', TextType::class, [
                'attr' => ['placeholder', 'Search our directory'],
                'label' => 'Search:',
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Search',
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $results = $this->finder->find('*'.$search->query.'*');
        }

        return $this->render('home.html.twig', [
            'form' => $form->createView(),
            'results' => $results,
        ]);
    }

    /**
     * @Route("/department", name="department_list")
     */
    public function listDepartments()
    {
        $departments = $this->em
            ->getRepository(Department::class)
            ->findBy([], ['name' => 'ASC']);

        return $this->render('department/list.html.twig', [
            'departments' => $departments,
        ]);
    }

    /**
     * @Route("/department/{slug}", name="department_show")
     */
    public function showDepartment(Department $department)
    {
        return $this->render('department/show.html.twig', [
            'department' => $department,
        ]);
    }
}
