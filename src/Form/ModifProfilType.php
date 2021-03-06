<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, ['label' => 'Prénom', 'required' => false, 'data_class' => null])
            ->add('nom', TextType::class, ['label' => 'Nom', 'required' => false, 'data_class' => null])
            ->add('plainPassword', RepeatedType::class,['type' => PasswordType::class,'required' => false, 'first_options' =>['label' => 'Mot de passe'], 'second_options' => ['label' => 'Confirmation du mot de passe'],'required' => false, 'data_class' => null])
            ->add('photo', FileType::class, ['label' => 'Photo de profil', 'required' => false, 'data_class' => null])
            ->add('date_de_naissance', DateType::class, ['label' => 'Date de naissance', 'years' => range(date('Y')-18, 1920), 'data_class' => null])
            ->add('bio', TextareaType::class, ['label' => 'Bio', 'required' => false, 'data_class' => null])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
