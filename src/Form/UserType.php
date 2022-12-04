<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname',TextType::class, [
                'required' => true,
                'constraints'=> [
                    new NotBlank([
                        'message'=>'Le champ est requis'
                    ]),
                    new Length([
                        'min'=>2,
                        'max'=>15,
                    ])
                    ],
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-control'],

            ])
            ->add('lastname',TextType::class, [
                'required' => true,
                'constraints'=> [
                    new NotBlank([
                        'message'=>'Le champ est requis'
                    ]),
                    new Length([
                        'min'=>2,
                        'max'=>15,
                    ])
                    ],
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email',EmailType::class,[
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('password',RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field form-control'],'label_attr' => ['class' => 'form-label']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'constraints'=>[
                        new Length([
                            'min'=>5,
                        ])
                    ]
                ],
                'second_options' => [
                    'label' => 'Validez votre mot de passe',
                    'constraints'=>[
                        new Length([
                            'min'=>5,
                        ])
                    ]
                ],
            ])
            ->add('add', SubmitType::class,[
                'attr'=>['class'=>'btn btn-submit mt-3'],
                'label' => "S'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
