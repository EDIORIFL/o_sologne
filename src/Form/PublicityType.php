<?php

namespace App\Form;

use App\Entity\Publicity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idprospect')
            ->add('filename')
            ->add('isactive')
            ->add('iseditable')
            ->add('createdat')
            ->add('updatedat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publicity::class,
        ]);
    }
}
