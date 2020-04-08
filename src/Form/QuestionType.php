<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Tag;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min'=>20,
                        'max'=>255,
                        'minMessage'=>'Le titre doit faire au moins 20 caractères',
                        'maxMessage'=>'Le titre ne peut pas faire plus de 255 caractères'
                    ]),
                ],
            ])
            ->add('content', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),                   
                ],
            ])
            // ->add('status')
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('author')
            ->add('tags', EntityType::class, [
                // dans quelle Entité je vais chercher mes choix =>
                'class' => Tag::class,
                // quel champ de l'entité j'utilise pour afficher mes choix
                'choice_label' => 'name',
                // plusieurs choix sont possible
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
