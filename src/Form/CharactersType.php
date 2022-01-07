<?php

namespace App\Form;

use App\Entity\Characters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharactersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('image')
            // ->add('hp_max')
            // ->add('hp')
            ->add('str')
            ->add('con')
            ->add('dex')
            ->add('intel')
            // ->add('level')
            // ->add('status')
            // ->add('user')
            ->add('profession')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Characters::class,
        ]);
    }
}
