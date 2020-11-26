<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class, [
                'attr' => ['class' => 'form-control'],
                ])
            ->add('lastname',TextType::class, [
                'attr' => ['class' => 'form-control'],
                ])
            ->add('phone',TextType::class, [
                'attr' => ['class' => 'form-control'],
                ])
            ->add('email',EmailType::class, [
                'attr' => ['class' => 'form-control'],
                ])
            ->add('message',TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                ])
            ;
        
         
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            
        ]);
    }
}
