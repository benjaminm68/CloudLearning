<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddStagiaireSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('prenom',TextType::class, [
            
            // 'attr' => ['class' => 'form-control selectpicker',
            //         ],
            // 'required' => false,
          
            
            // 'multiple' => true
            
        ])

        ->add('sessions',EntityType::class, [
            'class' => Session::class,
            'attr' => ['class' => 'form-control selectpicker',
                    ],
            'required' => false,
          
            'choice_label' => 'nom',
            'multiple' => true
            
        ])

        // ->add('sessions',EntityType::class, [
        //     'class' => Session::class,
        //     'attr' => ['class' => 'form-control selectpicker',
        //             ],
        //     'required' => false,
          
            
        //     'multiple' => true
            
        // ])
            

            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
