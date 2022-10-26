<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Entity\Partner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
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
              'class' => '',
              'placeholder' => 'Entrez un ou plusieurs mot-clés'
            ],
            'required' => false
          ])
          ->add('active', CheckboxType::class, [
            'label'    => 'Actives',
            'required' => false,
            'attr' => [
              'class' => ''
            ]
          ])
          ->add('Chercher', SubmitType::class, [
            'label' => 'Chercher',
            'attr' => [
              'class' => 'btn btn-warning search-icon ms-3'
            ]
          ])
          // ->add('Reset', ResetType::class, [
          //   'attr' => [
          //     'class' => 'btn btn-outline-danger ms-2'
          //   ]
          // ])
  ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
