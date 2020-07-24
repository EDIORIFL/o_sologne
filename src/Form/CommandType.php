<?php

namespace App\Form;

use App\Entity\Command;
use App\Entity\Prospect;
use App\Entity\Support;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prospect', ProspectSelectorType::class, [
                'class' => Prospect::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label' => 'Prospect',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('support', SupportSelectorType::class, [
                'class' => Support::class,
                'choice_label' => 'label',
                'choice_value' => 'id',
                'label' => 'Support',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('datesigned', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de signature',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('turnover', TextType::class, [
                'label' => 'Turn over',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('rib', TextType::class, [
                'label' => 'RIB',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('paymentmode', TextType::class, [
                'label' => 'Mode de paiement',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('payment', TextType::class, [
                'label' => 'Paiement',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('ismockfile', CheckboxType::class, [
                'label' => 'Est un fichier mock ?',
                'label_attr' => [
                    'class' => 'd-inline-block'
                ],
                'attr' => [
                    'class' => 'form-check d-inline-block'
                ], 
                'required' => false
            ])
            ->add('insertsize', TextType::class, [
                'label' => 'Insérez la taille',
                'label_attr' => [],
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}
