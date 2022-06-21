<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class,[
            'label'=>"Nom",
            'constraints'=>[
                new NotBlank([
                    'message'=>'Ce champs est obligatoire'
                ])
            ]
        ])
            ->add('firstname', TextType::class,[
                'label'=>"Prénom",
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Ce champs est obligatoire'
                    ])
                ]
            ])
            ->add('email', EmailType::class,[
                'label'=>'Adresse email',
                'constraints'=>[
                    new Email(
                        ['message'=>'Cet email est invalide']
                    ),
                    new NotBlank([
                        'message'=>'Ce champs est obligatoire'
                    ])
                ]
            ])
            ->add('telephone', TelType::class,[
                'label'=>"Téléphone",
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Ce champs est obligatoire'
                    ])
                ]
            ]
            )
            ->add('save', SubmitType::class,[
                'label'=>'Réserver'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
