<?php

namespace App\Form;

use App\Entity\Diagnostic;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiagnosticType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maladie', TextType::class, [
                'label' => 'Maladie',
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('prescription', TextType::class, [
                'label' => 'Prescription',
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('etat', ChoiceType::class, [
                'label' => 'Etat',
                'choices'  => [
                    'En amélioration' => 'amélioration',
                    'En déterioration' => 'déterioration',
                ],
                'expanded' => true, // Display as radio buttons
                'multiple' => false, // Only one choice can be selected
                'attr' => [
                    'class' => 'mb-2',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Diagnostic::class,
        ]);
    }
}
