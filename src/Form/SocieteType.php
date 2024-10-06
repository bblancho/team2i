<?php

namespace App\Form;

use App\Entity\Societes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('nom')
            ->add('adresse')
            ->add('cp')
            ->add('ville')
            ->add('phone')
            ->add('typeUser')
            ->add('dateInscriptionAt', null, [
                'widget' => 'single_text',
            ])
            ->add('siret')
            ->add('isVerified')
            ->add('isNewsletter')
            ->add('lastLonginAt', null, [
                'widget' => 'single_text',
            ])
            ->add('nomContact')
            ->add('numContact')
            ->add('imageName')
            ->add('description')
            ->add('secteurActivite')
            ->add('phoneContact')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Societes::class,
        ]);
    }
}
