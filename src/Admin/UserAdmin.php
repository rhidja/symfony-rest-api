<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->tab('Général')
                ->with('details', ['label' => 'Details'])
                    ->add('firstname', TextType::class, [
                        'label' => 'admin.label.firstname',
                    ])
                    ->add('lastname', TextType::class, [
                        'label' => 'admin.label.lastname',
                    ])
                    ->add('email', EmailType::class, [
                        'label' => 'admin.label.email',
                    ])
                    ->add('mobile', TelType::class, [
                        'label' => 'admin.label.mobile',
                    ])
                ->end()
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('email')
            ->add('firstname')
            ->add('lastname')
            ->add('mobile')
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
            ->add('firstname')
            ->add('lastname')
            ->add('mobile')
            ->add('email')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->tab('Général')
                ->with('details', ['label' => 'Details'])
                    ->add('firstname', null, [
                        'label' => 'admin.label.firstname',
                    ])
                    ->add('lastname', null, [
                        'label' => 'admin.label.lastname',
                    ])
                    ->add('email', null, [
                        'label' => 'admin.label.email',
                    ])
                    ->add('mobile', null, [
                        'label' => 'admin.label.mobile',
                    ])
                ->end()
            ->end()
        ;
    }

    public function toString(object $object): string
    {
        return 'User';
    }
}
