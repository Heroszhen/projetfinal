<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom',
                    TextType::class,
                [
                    'label' => 'Prenom'
                ]
                )
            ->add('nom',
                    TextType::class,
                [
                    'label' => 'Nom'
                ]
                )
            ->add('email',
                EmailType::class,
                [
                    'label' => 'Email'
                ])
            ->add('plainPassword',
                    RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'Mot de Passe'
                    ],
                  'second_options' => [
                      'label' => 'Confirmation de mot de passe'
                  ]
                ]
                )
            ->add('date_de_naissance',
                DateType::class,
                [
                    'label' => 'Date De Naissance',
                    'years' => range( date('Y') - 18, 1920)
                ]
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
