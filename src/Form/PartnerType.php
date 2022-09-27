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
            ->add('name')
            ->add('email', null, [
              'label' => 'Adresse E-mail personnelle'
            ])
            ->add('address', null, [
              'label' => 'Adresse'
            ])
            ->add('user', EntityType::class, [
              'class' => User::class,
              'placeholder' => 'Utilisateurs disponibles',
              'choice_label' => 'email',
              'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                  ->where('u.roles LIKE :role')
                  ->setParameter('role', '%"'.'ROLE_PARTNER'.'"%')
                  ->leftJoin(Partner::class, 'p', 'WITH', 'u = p.user' )
                  ->andwhere('p.user is NULL');
                ;
              },
              'multiple' => false,
              'expanded' => false
            ])
            ->add('Active')
            ->add('franchise', EntityType::class, [
              'class' => Franchise::class,
              'choice_label' => 'name',
              'multiple' => false,
              'placeholder' => ''
            ])
            ->add('permissions', EntityType::class, [
              'class' => Permission::class,
              'choice_label' => 'name',
              'multiple' => true,
              'expanded' => true,
              'disabled' => !$options['data']->getId()
            ])
        ;

        $formModifier = function (FormInterface $form, Franchise $franchise = null){

          //$allPermissions = $this->permissionRepository->findAll();
          $franchiseId = $franchise->getId();

          $selectedFranchise = $this->franchiseRepository->find($franchiseId);
          $preFranchisePermissions = $selectedFranchise->getPermissions()->toArray();

          $selectedPermissions = [];

          foreach($preFranchisePermissions as $permission){
            $selectedPermissions[$permission->getId()-1] = ['checked' => true];
          }

          $form->add('permissions', EntityType::class, [
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
