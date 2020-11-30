<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])

            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])

            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control'],
            ])

            ->add('avatar', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])

            ->add('roles', ChoiceType::class, [
                'attr' => ['class' => 'form-control selectpicker',],
                'choices' => [
                    'Formateur' => 'ROLE_USER',
                    'Secretaire' => 'ROLE_ADMIN',
                    'Direction' => 'ROLE_SUPER_ADMIN'
                ],
                'multiple' => true,
            ])

            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'attr' => ['class' => 'form-control selectpicker',],
                'multiple' => true,
                'choice_label' => 'nom',
                'required' => false

            ])

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer votre mot de passe'],
            ])

            ->add('Sincrire', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
