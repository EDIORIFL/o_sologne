<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, [
                'label' => 'Login',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'label_attr' => [
                    'class' => ''
                ] ,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('profil', TextType::class, [
                'label' => 'Profil',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('iseditable', CheckboxType::class, [
                'label' => 'Profil éditable ?',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-check'
                ]
            ])
            ->add('isactive', CheckboxType::class, [
                'label' => 'Profil actif ?',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-check'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
