<?php

namespace App\Form;

use App\Entity\Hopital;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class HopitalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom ne peut pas être vide',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/\d/',
                        'match' => false,
                        'message' => 'Le nom ne peut pas contenir de chiffres',
                    ]),
                ],
            ])
            ->add('Localisation', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La localisation ne peut pas être vide',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'La localisation doit contenir au moins {{ limit }} caractères',
                    ]),
                ],
            ])

            ->add('images', FileType::class, [
                'label' => 'Images',
                'multiple' => true,
                'mapped' => false, // This field is not mapped to any entity property
                'required' => false, // Allow form submission without selecting files
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hopital::class,
        ]);
    }
}
