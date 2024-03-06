<?php

namespace App\Form;

use App\Entity\Hopital;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
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
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter an email address.']),
                    new Email(['message' => 'The email address "{{ value }}" is not valid.']),
                ],
            ])
            ->add('num', IntegerType::class, [ // Change null to IntegerType
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a number.']),
                    new Regex([
                        'pattern' => '/^(2|5|9|4)[0-9]{6,7}$/',
                        'message' => 'The number "{{ value }}" is not valid. It should start with 2, 5, 9, or 4 and be between 1000000 and 99999999.',
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
            'validation_groups' => ['Default'], // Apply default validation groups
        ]);
    }
}
