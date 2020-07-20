<?php

namespace App\Form;

use App\Entity\Prospect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProspectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idaccount')
            ->add('idactivityarea')
            ->add('idprospectstatus')
            ->add('name')
            ->add('manager')
            ->add('address')
            ->add('siret')
            ->add('telephone')
            ->add('mobile')
            ->add('email')
            ->add('comment')
            ->add('iscustomer')
            ->add('isrefused')
            ->add('datecreated')
            ->add('datestatus')
            ->add('isactive')
            ->add('iseditable')
            ->add('createdat')
            ->add('updatedat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prospect::class,
        ]);
    }
}
