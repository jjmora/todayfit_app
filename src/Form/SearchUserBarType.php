<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchUserBarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          ->add('input_data', SearchType::class, [
            'label' => false,
            'attr' => [
              'class' => '',
              'placeholder' => 'Entrez le(s) mot-clés (au moins 3 caractères)'
            ],
            'required' => false
          ])

          // // Comment this for Dynamic Search Form
          ->add('type', ChoiceType::class,[
            'required' => false,
            'multiple' => false,
            'expanded' => false,
            'attr' => [
              'class' => '',
              'placeholder' => 'Role'
            ],
            'choices' => [
              'Franchise' => 'ROLE_FRANCHISE',
              'Structure' => 'ROLE_PARTNER',
              'Admin' => 'ROLE_ADMIN',
            ],
          ])
          ->add('Chercher', SubmitType::class, [
            'label' => 'Chercher',
            'attr' => [
              'class' => 'btn btn-warning search-icon'
            ]
          ])
          // // Comment this for Dynamic Search Form

          ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
