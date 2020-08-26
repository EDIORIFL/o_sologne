<?php

namespace App\Form;

use App\Entity\Publicity;
use App\Entity\Prospect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\ProspectSelectorType;
use App\Repository\ProspectRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class PublicityType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prospect', ProspectSelectorType::class, [
                'class' => Prospect::class,
                'query_builder' => function (ProspectRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label' => 'Prospect',
                'label_attr' => [],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('file', FileType::class, [
                'label' => 'Ajouter un fichier',
                'attr' => [
                    'class' => 'form-control-file'
                ]
            ])
            ->add('isactive', CheckboxType::class, [
                'label' => 'Est actif ?',
                'label_attr' => [
                    'class' => 'd-inline-block'
                ],
                'attr' => [
                    'class' => 'form-check d-inline-block'
                ]
            ])
            ->add('iseditable', CheckboxType::class, [
                'label' => 'Est éditable ?',
                'label_attr' => [
                    'class' => 'd-inline-block'
                ],
                'attr' => [
                    'class' => 'form-check d-inline-block'
                ]
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
                $data = $event->getData();
            
                if (isset($data['idprospect'])) {
                    $prospect = $data['idprospect'];
                    $data['idprospect'] = $prospect;
                    $event->setData($data); 
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publicity::class,
        ]);
    }
}
