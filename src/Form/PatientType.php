<?php

namespace App\Form;

use App\Entity\Docteur;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_naissance')
            ->add('telephone')
            ->add('Nom')
            ->add('Prenom')
            ->add('Genre')
            ->add('Numidentite')
            ->add('Adress')
            ->add('Mail')
            ->add('etat_patient', TextType::class)
            ->add('docteurs', EntityType::class, [
                'class' => Docteur::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
