<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'label' => 'Mot de passe actuel',
                'label_attr' => ['class' => 'form-label mt-4'],
                'constraints' => [new Assert\NotBlank()]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' =>false,
                'required' => true,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => ' Nouveau mot de passe',
                    'label_attr' => [
                        'class' => 'form-label  mt-4'
                    ],
                    'constraints' => [new Assert\NotBlank()]
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'form-label  mt-4'
                    ],
                    'required' => true,
                    'constraints' => [
                        new Assert\NotBlank(),
                    ]
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => "Ce champ est obligatoire."]),
                    new Assert\Length([
                        'min' => 8,
                        'max' => 20,
                        'minMessage' => 'Le mot de passe doit comporter plus de {{ limit }} caractères.',
                        'maxMessage' => 'Le mot de passe doit comporter au maximum de {{ limit }} caractères.',
                    ]),
                ],
                'invalid_message' => 'Le mot de passe doit être identique.',
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Changer mon mot de passe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
