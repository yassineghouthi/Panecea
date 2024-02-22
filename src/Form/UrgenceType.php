<?php

namespace App\Form;

use App\Entity\Urgence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class UrgenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Description', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description ne peut pas être vide',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'La description doit contenir au moins {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('NombreLit', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nombre de lits ne peut pas être vide',
                    ]),
                    new Type([
                        'type' => 'integer',
                        'message' => 'Le nombre de lits doit être un entier',
                    ]),
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Le nombre de lits doit être supérieur à zéro',
                    ]),
                ],
            ])
            ->add('Specialite', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La Specialite ne peut pas être vide',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'La Specialite doit contenir au moins {{ limit }} caractères',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Urgence::class,
        ]);
    }
}
