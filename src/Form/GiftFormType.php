<?php

namespace App\Form;

use App\Entity\Gift;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class GiftFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sender', TextType::class, [
                'label' => "Nom et prenom de l'expéditeur",
                'required' => false
            ])
            ->add('receiver', TextType::class, [
                'label' => "Nom et prenom du destinataire",
                'required' => false
            ])
            ->add('sender_email', EmailType::class, [
                'label' => "E-mail de l'expéditeur",
                'constraints' => [
                    new Email([
                        'message' => 'Cette adresse email est invalide'
                    ]),
                    new NotBlank([
                        'message' => 'ce champ est obligatoire
                        '
                    ])
                ]
            ])
            ->add('receiver_email', EmailType::class, [
                'label' => "E-mail du destinataire",
                'constraints' => [
                    new Email([
                        'message' => 'Cette adresse email est invalide'
                    ]),
                    new NotBlank([
                        'message' => 'ce champ est obligatoire'
                    ])
                ]
            ])
            ->add('message', TextareaType::class)            
            ->add('save', SubmitType::class, [
                'label' => 'suivant',
                'attr' => [
                    'class' => 'btn btn-outline-primary'
                ]
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gift::class,
            "allow_extra_fields" => true
        ]);
    }
}
