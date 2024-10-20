<?php

namespace App\Form;

use App\Entity\Societes;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SocieteType extends AbstractType
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
                'label' => 'Dénomination sociale',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'required' => false,
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('cp', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '5',
                    'maxlenght' => '5',
                ],
                'required' => false,
                'label' => 'Code postal',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'required' => false,
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    // 'maxlenght' => '10',
                ],
                'required' => false,
                'label' => 'Télèphone',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
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
            ->add('siret', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '20',
                ],
                'required' => false,
                'label' => 'Numéro de siret',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 20])
                ]
            ])
            ->add('isNewsletter', CheckboxType::class, [
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-check-input ',
                ],
                'label' => "S'inscrire à la newsletter ?",
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
            ])
            ->add('imageFile', VichFileType::class,[
                'required'  => false,
                'mapped'    => false,
                'label' =>' Déposer votre cv ',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])   
            ->add('nomContact',TextType::class, [
                'attr' => [
                    'class' => 'form-control ',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'label' => 'Nom du contact',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('phoneContact', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                ],
                'required' => false,
                'label' => 'Télèphone du contact',
                'label_attr' => [
                    'class' => 'form-label mt-4 mb-4'
                ],
            ])
            ->add('secteurActivite', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'required' => false,
                'label' => "Secteur d'activité",
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
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
