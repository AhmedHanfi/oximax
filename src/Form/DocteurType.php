<?php

namespace App\Form;

use App\Entity\Docteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('specialite')
            ->add('telephone')
            ->add('mail')
            ->add('adress')
            ->add('cabinet')
            ->add('user', UserType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Docteur::class,
        ]);
    }
}
