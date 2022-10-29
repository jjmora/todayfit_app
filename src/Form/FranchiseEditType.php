<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Permission;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FranchiseEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('Email', null, [
              'label' => 'Adresse E-mail personnelle'
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
              'label' => 'Inscrit depuis'
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
