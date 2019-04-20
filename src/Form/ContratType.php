<?php

namespace App\Form;

use App\Entity\Contrat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('nbheure')
            ->add('nbjour')
            ->add('joursemaine')
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
            'data_class' => Contrat::class,
        ]);
    }
}
