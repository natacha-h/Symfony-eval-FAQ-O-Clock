<?php

namespace App\Form;

use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Le nom du tag ne peut pas faire plus de 50 caractères',
                    ]),
                ],
            ])
            // ->add('questions')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ] 
        ]);
    }
}
