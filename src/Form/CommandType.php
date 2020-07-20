<?php

namespace App\Form;

use App\Entity\Command;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idprospect')
            ->add('idsupport')
            ->add('datesigned')
            ->add('turnover')
            ->add('rib')
            ->add('paymentmode')
            ->add('payment')
            ->add('ismockfile')
            ->add('insertsize')
            ->add('isactive')
            ->add('iseditable')
            ->add('createdat')
            ->add('updatedat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}
