<?php

namespace App\Form;

use App\Entity\Societes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationSocieteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'label' => "Raison sociale",
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('secteurActivite', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'label' => "Secteur d'activité",
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('imageFile', FileType::class,[
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
                'label' => 'Logo',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '180',
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180])
                ]
            ])
            ->add('adresse', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('cp', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '5',
                    'maxlenght' => '5',
                ],
                'label' => 'Code postal',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 5, 'max' => 5])
                ]
            ])
            ->add('ville', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('phone', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '10',
                ],
                'label' => 'Télèphone',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 10])
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 5,
                    'rows'=> 6
                ],
                'label' => 'Description de la société',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('nomContact', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'label' => 'Nom du contact',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('numContact', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '10',
                ],
                'label' => "Numéro du contact",
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 10])
                ]
            ])
            ->add('siret', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '10',
                ],
                'label' => 'Numéro de siret',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 10])
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'form-label  mt-4'
                    ]
                ],
                'second_options' => [
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'form-label  mt-4'
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Societes::class,
        ]);
    }
}
