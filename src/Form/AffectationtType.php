<?php

namespace App\Form;

use App\Entity\AffectationTicket;
use App\Entity\Employe;
use App\Repository\EmployeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffectationtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'rows' => 10
                )
            ))
            ->add('technicien', EntityType::class, array(
                'class' => Employe::class,
                'choice_label' => 'nomPrenom',
                'placeholder' => '---------------------',
                'query_builder' => function (EmployeRepository $repository) {
                    return $repository->createQueryBuilder('e')
                        ->leftJoin('e.utilisateur', 'u')
                        ->where('u.roles LIKE :role')
                        ->setParameter('role', '%ROLE_TECHNICIEN%')
                        ;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AffectationTicket::class,
        ]);
    }
}
