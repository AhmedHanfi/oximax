<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            // ->add('roles', ChoiceType::class, [
            //     'label' => 'Roles',
            //     'choices' => [
            //         'Admin' => 'ROLE_ADMIN',
            //         'User' => 'ROLE_USER',
            //     ],
            //     'expanded' => true,
            //     'multiple' => $options['multiple'],
            //     'constraints' => [
            //         new NotBlank(),
            //         new Choice(['choices' => ['ROLE_ADMIN', 'ROLE_USER'], 'multiple' => $options['multiple']]),
            //     ],
            // ])
            ->add('password', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'multiple' => true,
        ]);
    }
}
