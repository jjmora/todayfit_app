<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
              'constraints' => [
                new Email([
                  'message' => "L'adresse e-mail n'est pas valide"
                ])
              ]
            ])
            ->add('roles', ChoiceType::class,[
              'required' => true,
              'multiple' => true,
              'expanded' => true,
              'constraints' => [ 
                new NotBlank([
                  'message' => 'Selectionnez au moins un role',
                ])
              ],
              'choices' => [
                'Admin' => 'ROLE_ADMIN',
                // 'Super Admin' => 'ROLE_SUPER_ADMIN',
                'Franchise' => 'ROLE_FRANCHISE',
                'Structure' => 'ROLE_PARTNER'
              ],
            ])
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mote de passe doit avoir au moins {{ limit }} caracterès',
                        // max length allowed by Symfony for security reasons
                        'max' => 20,
                    ]),
                    new NotCompromisedPassword([
                      'message'=> "Ce mot de passe a été declaré comme volé dans le site https://haveibeenpwned.com/, il ne doit pas être utilisé. Veuillez utiliser un autre mot de passe",
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
