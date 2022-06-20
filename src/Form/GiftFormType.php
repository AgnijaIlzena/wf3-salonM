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
                'label' => "Sender Name and Lastname",
                'required' => false
            ])
            ->add('receiver', TextType::class, [
                'label' => "Receiver Name and Lastname",
                'required' => false
            ])
            ->add('sender_email', EmailType::class, [
                'label' => "Sender email",
                'constraints' => [
                    new Email([
                        'message' => 'this Email is invalid'
                    ]),
                    new NotBlank([
                        'message' => 'this field is obligatory'
                    ])
                ]
            ])

        
            ->add('receiver_email', EmailType::class, [
                'label' => "Receiver email",
                'constraints' => [
                    new Email([
                        'message' => 'this Email is invalid'
                    ]),
                    new NotBlank([
                        'message' => 'this field is obligatory'
                    ])
                ]
            ])
            ->add('message', TextareaType::class)
            
            ->add('save', SubmitType::class, [
                'label' => 'Next',
                'attr' => [
                    'class' => 'btn btn-outline-primary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gift::class,
        ]);
    }
}
