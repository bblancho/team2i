<?php

namespace App\Form;

use App\Entity\Missions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Validator\Constraints as Assert;

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
            'label' => 'Description de la mission',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\NotBlank()
            ]
        ])
        ->add('tarif', IntegerType::class, [
            'attr' => [
                'class' => 'form-control',
                'min' => 1,
                'max' => 2000
            ],
            'required' => false,
            'label' => 'Budget de la mission',
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
            'label' => 'Date de début de mission',
            'widget' => 'single_text',
        ])
        ->add('endDateat', null, [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'Date de fin de mission',
            'widget' => 'single_text',
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
            // ->add('isPourvue')
            // ->add('iSteletravail')
            // ->add('lieuMission')
            // ->add('isActive')
            // ->add('experience')
            // ->add('users', EntityType::class, [
            //     'class' => users::class,
            //     'choice_label' => 'id',
            // ])
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
