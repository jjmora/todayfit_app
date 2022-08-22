<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Partner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('Email')
            ->add('Address')
            ->add('Active')
            ->add('franchise', EntityType::class, [
              'class' => Franchise::class,
              'choice_label' => 'name',
              'multiple' => false,
              'placeholder' => ''
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
