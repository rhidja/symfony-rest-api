<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ThemeAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->tab('Général')
                ->with('details', ['label' => 'Details'])
                    ->add('name', TextType::class, [
                        'label' => 'admin.label.name',
                    ])
                    ->add('value', TextType::class, [
                        'label' => 'admin.label.value',
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
            ->add('value', null, [
                'label' => 'admin.label.value',
            ])
            ->add(ListMapper::NAME_ACTIONS, ListMapper::TYPE_ACTIONS, [
                'translation_domain' => 'SonataAdminBundle',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('name')
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
                    ->add('value', null, [
                        'label' => 'admin.label.value',
                    ])
                ->end()
            ->end()
        ;
    }

    public function toString(object $object): string
    {
        return 'Theme';
    }
}
