<?php

namespace App\Form;

use App\Entity\ActivityArea;
use App\Entity\ProspectStatus;
use App\Entity\Support;
use App\Form\ActivityAreaSelectorType;
use App\Form\SupportSelectorType;
use App\Form\ProspectStatusSelectorType;
use App\Repository\ActivityAreaRepository;
use App\Repository\ProspectStatusRepository;
use App\Repository\SupportRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'entreprise',
                'label_attr' => [
                    'class' => 'position-absolute'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de l\'entreprise'
                ],
                'required' => false,
            ])
            ->add('postal_code', TextType::class, [
                'label' => 'Zone géographique',
                'label_attr' => [
                    'class' => 'position-absolute'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Zone géographique'
                ],
                'required' => false,
            ])
            ->add('activity_area', ActivityAreaSelectorType::class, [
                'class' => ActivityArea::class,
                'query_builder' => function (ActivityAreaRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.label', 'ASC');
                },
                'choice_label' => 'label',
                'choice_value' => 'id',
                'label' => 'Secteur d\'activité',
                'label_attr' => [
                    'class' => 'position-absolute'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Secteur d\'activité'
                ],
                'required' => false,
            ])
            ->add('date_created', DateType::class, [
                'label' => 'Date de création',
                'label_attr' => [
                    'class' => 'position-absolute'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Date de création'
                ],
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('status', ProspectStatusSelectorType::class, [
                'class' => ProspectStatus::class,
                'query_builder' => function (ProspectStatusRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.label', 'ASC');
                },
                'choice_label' => 'label',
                'choice_value' => 'id',
                'label' => 'Statut',
                'label_attr' => [
                    'class' => 'position-absolute'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom du contact'
                ],
                'required' => false,
            ])
            ->add('support', SupportSelectorType::class, [
                'class' => Support::class,
                'query_builder' => function (SupportRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.label', 'ASC');
                },
                'choice_label' => 'label',
                'choice_value' => 'id',
                'label' => 'Support',
                'label_attr' => [
                    'class' => 'position-absolute'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Support'
                ],
                'required' => false,
            ])
            ->add('display', ChoiceType::class, [
                'label' => 'Par page',
                'label_attr' => [
                    'class' => 'position-absolute'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices' => [
                    10 => 10,
                    20 => 20,
                    50 => 50,
                    100 => 100
                ]
            ])
            ->setMethod('GET');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
