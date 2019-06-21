<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

final class LocationAdmin extends AbstractAdmin
{
    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureFormFields()
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class)
            ->add('addressStreet1', TextType::class)
            ->add('city', TextType::class)
            ->add('state', TextType::class)
            ->add('zip', TextType::class)
            ->add('latitude', TextType::class)
            ->add('longitude', TextType::class);
    }
    
    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureDatagridFilters()
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');        
    }
    
    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureListFields()
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
    }
}
