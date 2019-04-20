<?php

namespace App\Form;

use App\Entity\Personnel;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class PersonnelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('noms',TextType::class, array(
                'label'=> 'Nom',
            ))
            ->add('prenoms',TextType::class, array(
                'label'=> 'Prenom',
            ))
            ->add('datenaiss')
            ->add('nationalite')
            ->add('nombreenfant',TextType::class, array(
        'label'=> 'Nombre des enfants',
            ))
            ->add('codepostale',TextType::class, array(
                'label'=> 'Code Postale',
            ))
            ->add('ville')
            ->add('pays')
            ->add('email')
            ->add('permis')
            ->add('numeropasseport',TextType::class, array(
                'label'=> 'Numéro de passeport',
            ))

            ->add('lieunaiss',TextType::class, array(
                'label'=> 'Lieu Naissance',
            ))
            ->add('situationfamiliale',TextType::class, array(
                'label'=> 'Situation Familiaire',
            ))
            ->add('adresse')
            ->add('sexe',ChoiceType::class, array(
                'choices'=> array(
                    'Femme'=>'FEMME',
                    'Homme'=>'Homme',
                ),
                'placeholder'=> '----------'
            ))
            ->add('service', EntityType::class, array(
                'class' => Service::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir service'
            ))
            ->add('contrat')
            ->add('telephone')
            ->add('fonction')
            ->add('cartenational',TextType::class, array(
                'label'=> 'carte National',
                'constraints' => [
                    new Length([
                        'min' =>8,
                        'minMessage' => '8 caractére ',
                        'max' => 4096,
                    ])]
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personnel::class,
        ]);
    }
}
