<?php

namespace App\Form;

use App\Entity\Clients;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ClientType extends AbstractType
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
                'label' => 'Nom / Prénom',
                'label_attr' => [
                    'class' => 'form-label'
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
                    'class' => 'form-label'
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
                    'class' => 'form-label'
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
                    'class' => 'form-label'
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
                    'class' => 'form-label'
                ],
            ])
            ->add('tjm', MoneyType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'max' => 2000,
                    'type' => 'number',
                    'placeholder' => ''
                ],
                'currency' => 'EUR',
                'label' => 'Taux journalier :',
                'label_attr' => [
                    'class' => 'form-label'
                ],
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
                    'class' => 'form-label'
                ],
            ]) 
            ->add('cvFile', VichFileType::class,[
                'required'  => false,
                'mapped'    => false,
                'label' =>' Déposer votre cv ',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ],
            ])        
            ->add('dispo', CheckboxType::class, [
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-check-input ',
                ],
                'label' => 'Disponible pour une mission ?',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
            ])
            ->add('isNewsletter', CheckboxType::class, [
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-check-input ',
                ],
                'label' => "S'inscrire à la newsletter ?",
                'label_attr' => [
                    'class' => 'form-check-label '
                ],
            ])
            // ->add('dateDispoAt', null, [
            //     'required' => false,
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],
            //     'label' => 'Date de début de mission :',
            //     'widget' => 'single_text',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
        ]);
    }
}
