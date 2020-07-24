<?php

namespace App\Form;

use App\Form\DataTransformer\ProspectStatusToNumberTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProspectStatusSelectorType extends AbstractType
{
    private $transformer;

    public function __construct(ProspectStatusToNumberTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'The selected status does not exist',
        ]);
    }

    public function getParent()
    {
        return EntityType::class;
    }
}
