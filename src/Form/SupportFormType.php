<?php

namespace App\Form;

use App\Entity\Support;
use App\Entity\SupportType;
use App\Repository\SupportTypeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('supporttype', SupportTypeSelectorType::class, [
                'class' => SupportType::class,
                'query_builder' => function (SupportTypeRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.label', 'ASC');
                },
                'choice_label' => 'label',
                'choice_value' => 'id',
                'label' => 'Type de support',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('label', TextType::class, [
                'label' => 'Label',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dateedited', DateType::class, [
                'label' => 'Date de la dernière édition',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('isactive', CheckboxType::class, [
                'label' => 'Est actif ?',
                'label_attr' => [
                    'class' => 'd-inline-block'
                ],
                'attr' => [
                    'class' => 'form-check d-inline-block'
                ], 
                'required' => false
            ])
            ->add('iseditable', CheckboxType::class, [
                'label' => 'Est éditable ?',
                'label_attr' => [
                    'class' => 'd-inline-block'
                ],
                'attr' => [
                    'class' => 'form-check d-inline-block'
                ], 
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Support::class,
        ]);
    }
}
