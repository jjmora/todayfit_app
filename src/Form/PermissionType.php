<?php

namespace App\Form;

use App\Entity\Permission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
              'label' => 'Nom',
              'required' => false,
            //   'constraints' => [
            //     new NotBlank([
            //         'message' => 'Entrez un Nom svp',
            //     ]),
            //     new Length([
            //         'min' => 3,
            //         'minMessage' => 'Le Nom doit avoir au moins {{ limit }} caracterès',
            //         'max' => 50,
            //         'maxMessage' => 'Le Nom doit avoir au maximum {{ limit }} caracterès',
            //     ]),
            // ],
            ])
            ->add('image', null, [ // null make Symfony detect automatically the type
              'label' => 'Image URL',
              'empty_data' => 'https://www.svgrepo.com/show/340721/no-image.svg'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Permission::class,
        ]);
    }
}
