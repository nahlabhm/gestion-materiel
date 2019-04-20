<?php

namespace App\Form;

use App\Entity\Emplacement;
use App\Entity\Materiel;
use App\Entity\Service;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('num_id')
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Desktop' => 'DESKTOP',
                    'Ecran' => 'ECRAN',
                    'Imprimante' => 'IMPRIMANTE',
                    'Scanner' => 'SCANNER',
                    'Telephone' => 'TELEPHONE',
                    'Pistoller code a barre' => 'PISTOLLER CODE A BARRE',
                    'Lecture code a barre' => 'LECTUER CODE A BARRE',
                    'Pc' => 'PC',
                ),
                'placeholder' => 'Choisir type'
            ))
            ->add('marque')
            ->add('modele')
            ->add('serie')
            ->add('sys_expl')
            ->add('ram')
            ->add('type_proc')
            ->add('hdd')
            ->add('ad_ip')
            ->add('ad_wifi')
            ->add('service', EntityType::class, array(
                'class' => Service::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir service'
            ))
            ->add('emplacement', EntityType::class, array(
                'class' => Emplacement::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir emplacement'
            ))
            ->add('utilisteurs', EntityType::class, array(
                'class' => Utilisateur::class,
                'choice_label' => 'matricule',
                'placeholder' => 'Choisir utilisateus',
                'multiple'=> true,
                'expanded'=> true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
