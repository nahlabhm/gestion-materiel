<?php

namespace App\Form;

use App\Entity\Conge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CongeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('description', TextareaType::class, array(
                'attr'=> array(
                    'rows'=> 10
                )))
            ->add('type',TextType::class, array(
                'label'=> 'Type de Congé',
            ))
            ->add('nbjour',TextType::class, array(
                'label'=> 'Nombre de Jour',
              ))
            ->add('dated')
            ->add('datef')
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
            'data_class' => Conge::class,
        ]);
    }
}
