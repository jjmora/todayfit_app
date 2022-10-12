<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Partner;
use App\Entity\Permission;
use App\Entity\User;
use App\Repository\FranchiseRepository;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerEditType extends AbstractType
{
    private $permissionRepository;
    private $franchiseRepository;

    public function __construct(PermissionRepository $permissionRepository, FranchiseRepository $franchiseRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->franchiseRepository = $franchiseRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('email', null, [
              'label' => 'Adresse E-mail personnelle'
            ])
            ->add('address', null, [
              'label' => 'Adresse'
            ])
            ->add('image')
            ->add('description')
            ->add('Active', null, [
              'label' => 'Active',
              'label_attr' => [
                'class' => 'custom-active-check'
              ]
            ])
            ->add('permissions', EntityType::class, [
              'class' => Permission::class,
              'choice_label' => 'name',
              'multiple' => true,
              'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}
