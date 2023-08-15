<?php

namespace App\Form;

use App\Entity\Docteur;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_naissance', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            
            ->add('Nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('Prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('telephone', TelType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('Genre', ChoiceType::class, [
                'choices'  => [
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                ],
                'attr' => [
                    'class' => 'form-control mb-2',
                    'style' => 'appearance: menulist;',
                ],
            ])
            ->add('Numidentite', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('Adress', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('Mail', EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('etat_patient', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
