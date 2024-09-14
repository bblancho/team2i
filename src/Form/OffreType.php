<?php

namespace App\Form;

use App\Entity\Offres;
use App\Entity\Societes;
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

class OffreType extends AbstractType
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
                'label' => 'Titre de la mission :',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
            ])
            ->add('refMission', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'label' => 'Ref annonce :',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'rows' => 9
                ],
                'label' => 'Description de la mission :',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('tarif', MoneyType::class, [
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control',
                    'max' => 2000,
                    'type' => 'number',
                    'placeholder' => '0.00'
                ],
                'currency' => 'EUR',
                'label' => 'Budget de la mission :',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('isActive', CheckboxType::class, [
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label' => 'Publier ?',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
            ])
            ->add('lieuMission', TextType::class, [
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'label' => 'Localisation :',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
            ])
            ->add('duree', IntegerType::class, [
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 48
                ],
                'label' => 'Durée de la mission en mois :',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('contraintes', TextareaType::class, [
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 6
                ],
                'label' => "Contraintes de la mission  :",
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('profil', TextareaType::class, [
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 6
                ],
                'label' => 'Profil recherché :',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('experience', IntegerType::class, [
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 15
                ],
                'label' => "Nombre d'année d'expérience minimum :",
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('startDateAT', null, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Date de début de mission :',
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offres::class,
        ]);
    }
}
