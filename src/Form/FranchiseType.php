<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Permission;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime as ConstraintsDateTime;

class FranchiseType extends AbstractType
{
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
            ->add('image')
            ->add('description')
            ->add('user', EntityType::class, [
              'class' => User::class,
              'placeholder' => 'Utilisateurs disponibles',
              'choice_label' => 'email',
              'required' => false,
              'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                  ->where('u.roles LIKE :role')
                  ->setParameter('role', '%"'.'ROLE_FRANCHISE'.'"%')
                  ->leftJoin(Franchise::class, 'f', 'WITH', 'u = f.user' )
                  ->andwhere('f.user is NULL');
                ;
              },
              'multiple' => false,
              'expanded' => false
            ])
            ->add('Active', null, [
              'label' => 'Active',
              'label_attr' => [
                'class' => 'custom-active-check'
              ]
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
              'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Franchise::class,
        ]);
    }
}
