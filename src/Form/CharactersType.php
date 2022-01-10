<?php

namespace App\Form;

use App\Entity\Characters;
use App\Entity\Profession;
use App\Entity\User;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class CharactersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de votre personnage."
            ])
            ->add('image', FileType::class, [
                'label' => 'image',
                'mapped' => false,
                'required' => false,

                'constraints' => [
                    new Image([
                        'maxSize' => '30000000',
                        'mimeTypes' => [
                            'image/*',

                        ],
                        // 'message' => 'Veuillez mettre un fichier png ou jpeg.'
                    ])
                ]

            ])
            // ->add('hp_max')
            // ->add('hp')
            ->add('str', TypeIntegerType::class, [
                'label' => "Force de votre personnage."
            ])
            ->add('con', TypeIntegerType::class, [
                'label' => "Force de votre personnage."
            ])
            ->add('dex', TypeIntegerType::class, [
                'label' => "Force de votre personnage."
            ])
            ->add('intel', TypeIntegerType::class, [
                'label' => "Force de votre personnage."
            ])
            // ->add('level')
            // ->add('status')
            ->add('profession', EntityType::class, [
                'class' => Profession::class,
                
                'choice_label' => 'profession_name',
                ])
                
            // test pour voir si ça va en db
            // ->add('user')
            ->add('user', EntityType::class, [
                'class' => User::class,

                'choice_label' => 'user_name',
                ])
            ;
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Characters::class,
        ]);
    }
}
