<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
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
            ->add('password');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'multiple' => true,
        ]);
    }
}
