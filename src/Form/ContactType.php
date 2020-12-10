<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Nom'
            ])
            ->add('phone', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Téléphone'
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            
            ->add('session', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Session souhaitée'
            ])
            ->add('message', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
