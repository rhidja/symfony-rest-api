<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class PlaceAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->tab('Général')
                ->with('details', ['label' => 'Details'])
                    ->add('name', TextType::class, [
                        'label' => 'admin.label.name',
                    ])
                    ->add('address', TextType::class, [
                        'label' => 'admin.label.address',
                    ])
                    ->add('city', TextType::class, [
                        'label' => 'admin.label.city',
                    ])
                    ->add('country', TextType::class, [
                        'label' => 'admin.label.country',
                        'required' => true,
                    ])
                ->end()
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('name', null, [
                'label' => 'admin.label.name',
            ])
            ->add('address', null, [
                'label' => 'admin.label.address',
            ])
            ->add('city', null, [
                'label' => 'admin.label.city',
            ])
            ->add('country', null, [
                'label' => 'admin.label.country',
            ])
            ->add(ListMapper::NAME_ACTIONS, ListMapper::TYPE_ACTIONS, [
                'translation_domain' => 'SonataAdminBundle',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('name')
            ->add('city')
            ->add('country')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->tab('Général')
                ->with('details', ['label' => 'Details'])
                    ->add('name', null, [
                        'label' => 'admin.label.name',
                    ])
                    ->add('address', null, [
                        'label' => 'admin.label.address',
                    ])
                    ->add('city', null, [
                        'label' => 'admin.label.city',
                    ])
                    ->add('country', null, [
                        'label' => 'admin.label.country',
                    ])
                    ->add('themes', null, [
                        'label' => 'admin.label.themes',
                    ])
                    ->add('prices', null, [
                        'label' => 'admin.label.prices',
                    ])
                ->end()
            ->end()
        ;
    }

    public function toString(object $object): string
    {
        return 'Place';
    }
}
