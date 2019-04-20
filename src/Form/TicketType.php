<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextareaType::class, array(
                'attr'=> array(

                )
            ))
            ->add('description', TextareaType::class, array(
                'attr'=> array(
                    'rows'=> 10
                )
            ))

            ->add('urgence', ChoiceType::class, array(
                'choices'=> array(
                    'Trés haute'=> 'Trés haute',
                    'haute'=>'Haute',
                    'Moyenne'=>'Moyenne',
                    'Basse'=>'Basse',
                    'Tres basse'=>'Tres basse',
                ),
                'placeholder'=> '----------'
            ))
            ->add('statut', ChoiceType::class, array(
                'choices'=> array(
                    'En cours'=>'En cours',
                    'Nouveau'=>'Nouveau',
                ),
                'placeholder'=> '----------'
            ))
            ->add('impact', ChoiceType::class, array(
                'choices'=> array(
                    'Trés haut'=> 'Trés haut',
                    'haut'=>'Haut',
                    'Moyen'=>'Moyen',
                    'Bas'=>'Bas',
                    'Tres bas'=>'Tres bas',
                ),
                'placeholder'=> '----------'
            ))
            ->add('matricule', TextType::class, array(
                'mapped'=> false,
                'label'=> 'Matricule materiel',
                'required'=> false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
