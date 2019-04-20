<?php

namespace App\Form;

use App\Entity\Employe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('utilisateur', UtilisateurType::class, array(
                'label'=> false
            ))
            ->add('role', ChoiceType::class, array(
                'mapped'=> false,
                'label'=> 'Role',
                'choices'=> array(
                    'Employe'=> 'ROLE_EMPLOYE',
                    'Technicien'=> 'ROLE_TECHNICIEN',
                ),
                'placeholder'=> 'Choisir role'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
