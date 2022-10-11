<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchPartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('input_data', SearchType::class, [
          'label' => false,
          'attr' => [
            'class' => 'form-control',
            'placeholder' => 'Entrez un ou plusieurs mot-clés'
          ],
          'required' => false
        ])
        ->add('Chercher', SubmitType::class, [
          'label' => 'Chercher',
          'attr' => [
            'class' => 'btn btn-warning search-icon'
          ]
        ])
  ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
