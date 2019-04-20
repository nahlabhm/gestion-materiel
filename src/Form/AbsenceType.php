<?php

namespace App\Form;

use App\Entity\Absence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('remarque',TextareaType::class, array(
                'attr'=> array(
                    'rows'=> 10
                )))
            ->add('motif',TextType::class, array(
                'label'=> 'Motifs absence',
            ))
            ->add('nbjour',TextType::class, array(
                'label'=> 'Nombre de Jour',
            ))
            ->add('datede')
            ->add('datefin')
            ->add('noms', TextType::class, array(
                'mapped'=> false,
                'label'=> 'Nom',
            ))
            ->add('prenoms', TextType::class, array(
                'mapped'=> false,
                'label'=> 'Prenom',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Absence::class,
        ]);
    }
}
