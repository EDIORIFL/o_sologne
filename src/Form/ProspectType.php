<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\ActivityArea;
use App\Entity\Prospect;
use App\Entity\ProspectStatus;
use App\Repository\ActivityAreaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\ActivityAreaSelectorType;
use App\Repository\ProspectStatusRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProspectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', UserSelectorType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label' => 'Responsable au sein de l\'agence',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('activityarea', ActivityAreaSelectorType::class, [
                'class' => ActivityArea::class,
                'query_builder' => function (ActivityAreaRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.label', 'ASC');
                },
                'choice_label' => 'label',
                'choice_value' => 'id',
                'label' => 'Secteur d\'activité',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('prospectstatus', ProspectStatusSelectorType::class, [
                'class' => ProspectStatus::class,
                'query_builder' => function (ProspectStatusRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.label', 'ASC');
                },
                'choice_label' => 'label',
                'choice_value' => 'id',
                'label' => 'Statut',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('manager', TextType::class, [
                'label' => 'Manager',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Adresse',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('siret', TextType::class, [
                'label' => 'N° SIRET',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false
            ])
            ->add('mobile', TextType::class, [
                'label' => 'Mobile',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false
            ])
            ->add('comment', TextAreaType::class, [
                'label' => 'Commentaire',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ], 
                'required' => false
            ])
            ->add('iscustomer', CheckboxType::class, [
                'label' => 'Est client ?',
                'label_attr' => [
                    'class' => 'd-inline-block'
                ],
                'attr' => [
                    'class' => 'form-check d-inline-block'
                ], 
                'required' => false
            ])
            ->add('isrefused', CheckboxType::class, [
                'label' => 'Est refusé ?',
                'label_attr' => [
                    'class' => 'd-inline-block'
                ],
                'attr' => [
                    'class' => 'form-check d-inline-block'
                ], 
                'required' => false
            ])
            ->add('datecreated', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de création',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false
            ])
            ->add('datestatus', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de mise à jour',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false
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
            'data_class' => Prospect::class,
        ]);
    }
}
