<?php

namespace App\Form;

use App\Entity\Responsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('Prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('Mail', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('telephone', TelType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('adress', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('user', UserType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Responsable::class,
        ]);
    }
}
