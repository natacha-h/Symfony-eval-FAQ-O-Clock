<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' =>3,
                        'max' => 50
                    ])
                ]
            ])
            ->add('password', RepeatedType::class, [
                
                'type' => PasswordType::class,
                'invalid_message' => 'les deux champs doivent être identiques',
                'options' => [
                    'attr' => [
                        'class' => 'password-field'
                    ]
                ],
                'empty_data' => '',
                'required' => true,
                'first_options'  => [
                    'label' => 'Password',
                    'empty_data' => '',
                ],
                'second_options' => [
                    'label' => 'Repeat Password', 
                    'empty_data' => '',
                ],
                'empty_data' => array(),
            ])
            ->add('email')
            // ->add('role')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ] 
        ]);
    }
}
