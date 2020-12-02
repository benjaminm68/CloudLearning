<?php

namespace App\Form;

use App\Entity\Duree;
use App\Entity\Module;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DureeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modules', EntityType::class, [
                'attr' => ['class' => 'form-control'],
                'class' => Module::class,
                'label' => false,
                'query_builder' => function(EntityRepository $er){
                
                $er->createQueryBuilder('m')
                ->orderBy('m.nom', 'ASC');
                }
            ])
             
            ->add('nbJour', IntegerType::class,[
                'label' => 'Nombre de jour(s)',
                'attr' => ['class' => 'form-control']
                ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Duree::class,
        ]);
    }
}
