<?php

namespace App\Form;

use App\Entity\Missions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '50',
            ],
            'required' => true,
            'label' => 'Titre de la mission',
            'label_attr' => [
                'class' => 'form-label  mt-4'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' => 50])
            ]
        ])
        ->add('description', TextareaType::class, [
            'attr' => [
                'class' => 'form-control',
                'min' => 1,
                'max' => 5,
                'rows'=> 6
            ],
            'required' => true,
            'label' => 'Description de la mission',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\NotBlank()
            ]
        ])
        ->add('lieuMission', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '50',
            ],
            'label' => 'Localisation:',
            'label_attr' => [
                'class' => 'form-label  mt-4'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' => 50])
            ]
        ])
        ->add('tarif', MoneyType::class, [
            'attr' => [
                'class' => 'form-control',
                'max' => 2000,
                'type' => 'number',
                'placeholder' => '0.00'
            ],
            'currency' => 'EUR',
            'required' => true,
            'label' => 'Budget de la mission',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Positive(),
                new Assert\LessThan(2000)
            ]
        ])
        ->add('duree', IntegerType::class, [
            'attr' => [
                'class' => 'form-control',
                'min' => 1,
                'max' => 24
            ],
            'required' => false,
            'label' => 'Durée de la mission en mois',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Positive(),
                new Assert\LessThan(24)
            ]
        ])
        ->add('contraintes', TextareaType::class, [
            'attr' => [
                'class' => 'form-control',
                'min' => 1,
                'max' => 5,
                'rows'=> 6
            ],
            'required' => false,
            'label' => "Contraintes de la mission",
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
        ])
        ->add('profil', TextareaType::class, [
            'attr' => [
                'class' => 'form-control',
                'min' => 1,
                'max' => 5,
                'rows'=> 6
            ],
            'required' => false,
            'label' => 'Profil recherché',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\NotBlank()
            ]
        ])
        ->add('experience', IntegerType::class, [
            'attr' => [
                'class' => 'form-control',
                'min' => 1,
                'max' => 15
            ],
            'required' => false,
            'label' => "nombre d'année d'expérience minimum :",
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Positive(),
                new Assert\LessThan(15)
            ]
        ])
        ->add('nbPersonnes', IntegerType::class, [
            'attr' => [
                'class' => 'form-control',
                'min' => 1,
                'max' => 2000
            ],
            'required' => true,
            'label' => 'Nombre de poste(s) à pourvoir :',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Positive(),
                new Assert\LessThan(2000)
            ]
        ])
        ->add('startDateAT', null, [
            'attr' => [
                'class' => 'form-control',
            ],
            'required' => true,
            'label' => 'Date de début de mission',
            'widget' => 'single_text',
        ])
        ->add('isActive', CheckboxType::class, [
            'attr' => [
                'class' => 'form-check-input',
            ],
            'required' => false,
            'label' => 'Publier ? ',
            'label_attr' => [
                'class' => 'form-check-label'
            ],
            'constraints' => [
                new Assert\NotNull()
            ]
        ])
            // ->add('iSteletravail')
            // ->add('skills', EntityType::class, [
            //     'class' => skills::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
