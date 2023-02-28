<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Permission;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FranchiseEditType extends AbstractType
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
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Franchise::class,
    ]);
  }
}
