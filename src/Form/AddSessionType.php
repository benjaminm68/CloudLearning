<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AddSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut')
            ->add('DateFin')
            ->add('nbPlaces', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
            ])

            ->add('Nom',TextType::class)
            ->add('dateDebut', DateType::class)
            ->add('DateFin', DateType::class)
            ->add('nbPlaces', IntegerType::class)

            ->add('participer',EntityType::class, [
                'class' => Stagiaire::class,
                'attr' => ['class' => 'form-control selectpicker',
                        ],
                'required' => false,
              
                'choice_label' => 'nom',
                'multiple' => true
                
            ])
            ->add('contenir',EntityType::class, [
                'class' => Formation::class,
                'attr' => ['class' => 'form-control selectpicker',
                        ],
                
                'choice_label' => 'nom'
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
       ; 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
