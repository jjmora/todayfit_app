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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerType extends AbstractType
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
      ->add('Name', null, [
        'label' => 'Nom',
        'required' => false
      ])
      ->add('Email', null, [
        'label' => 'Adresse E-mail personnelle',
        'required' => false
      ])
      ->add('Address', null, [
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
      ->add('franchise', EntityType::class, [
        'class' => Franchise::class,
        'choice_label' => 'name',
        'multiple' => false,
        'placeholder' => '',
        'required' => false,
      ])
      // TO DO dynamic user selection by franchise
      ->add('user', EntityType::class, [
        'class' => User::class,
        'placeholder' => 'Utilisateurs disponibles',
        'choice_label' => 'email',
        'label' => 'Utilisateur',
        'required' => false,
        'query_builder' => function (EntityRepository $er) {
          return $er->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%"' . 'ROLE_PARTNER' . '"%')
            ->leftJoin(Partner::class, 'p', 'WITH', 'u = p.user')
            ->andwhere('p.user is NULL');;
        },
        'multiple' => false,
        'expanded' => false,
      ])
      ->add('date', DateType::class, [
        'widget' => 'choice',
        'label' => 'Inscrit depuis',
        'format' => 'dd-MM-yyyy',
        'years' => range(date('2010'), date('Y') + 2),
      ])
      ->add('permissions', EntityType::class, [
        'class' => Permission::class,
        'choice_label' => 'name',
        'multiple' => true,
        'expanded' => true,
        'disabled' => !$options['data']->getId() //true or false
      ]);

    $formModifier = function (FormInterface $form, Franchise $franchise = null) {

      //$allPermissions = $this->permissionRepository->findAll();
      if (isset($franchiseId)) {
        $franchiseId = $franchise->getId();
      } else {
        $franchiseId = 1;
      }
      $selectedFranchise = $this->franchiseRepository->find($franchiseId);
      $preFranchisePermissions = $selectedFranchise->getPermissions()->toArray();

      $selectedPermissions = [];

      foreach ($preFranchisePermissions as $permission) {
        $selectedPermissions[$permission->getId() - 1] = ['checked' => true];
      }

      $form
        ->add('permissions', EntityType::class, [
          'class' => Permission::class,
          'choice_label' => 'name',
          'multiple' => true,
          'expanded' => true,
          'choice_attr' => $selectedPermissions,
        ]);
    };

    $builder->get('franchise')->addEventListener(
      FormEvents::POST_SUBMIT,
      function (FormEvent $event) use ($formModifier) {
        $franchise = $event->getForm()->getData();
        $formModifier($event->getForm()->getParent(), $franchise);
      }
    );
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Partner::class,
    ]);
  }
}
