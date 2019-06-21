<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use App\Entity\Department;
use Sonata\AdminBundle\Form\Type\ModelType;

final class StaffAdmin extends AbstractAdmin
{
    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureFormFields()
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('employeeId', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('displayName', TextType::class, ['required' => false])
            ->add('position', TextType::class)
            ->add('phone', TextType::class, ['required' => false])
            ->add('email', EmailType::class, ['required' => false])
            ->add('location', ModelListType::class)
            ->add('departments', ModelType::class, [
                'multiple' => true,
            ]);
    }
    
    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureDatagridFilters()
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('employeeId')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('phone')
            ->add('position');
    }

    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureListFields()
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('employeeId')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('phone')
            ->add('position');
    }
}
