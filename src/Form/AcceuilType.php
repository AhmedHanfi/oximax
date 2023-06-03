<?php

namespace App\Form;

use App\Entity\Acceuil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcceuilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('mail')
            ->add('telephone')
            ->add('Adress')
            ->add('user', UserType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Acceuil::class,
        ]);
    }
}
