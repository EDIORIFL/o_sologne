<?php

namespace App\Form;

use App\Entity\ActivityArea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('activity_area', ActivityAreaSelectorType::class, [
                'class' => ActivityArea::class,
                'choice_label' => 'label',
                'choice_value' => 'id',
                'label_attr' => [
                    'class' => 'd-none'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Secteur d\'activité'
                ],
                'required' => false,
            ])
            ->add('postal_code', TextType::class, [
                'label_attr' => [
                    'class' => 'd-none'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Code postal'
                ],
                'required' => false,
            ])
            ->add('name', TextType::class, [
                'label_attr' => [
                    'class' => 'd-none'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom du prospect'
                ],
                'required' => false,
            ])
            ->setMethod('GET')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}