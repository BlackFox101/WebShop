<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Почта',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                    ]),
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Имя',
                'constraints' => [
                    new Length([
                        'maxMessage' => 'This field is very long. Max 255 character',
                        'max' => 255
                    ]),
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Фамилия',
                'constraints' => [
                    new Length([
                        'maxMessage' => 'This field is very long. Max 255 character',
                        'max' => 255
                    ]),
                ]
            ])
            ->add('login', TextType::class, [
                'label' => 'Логин',
                'constraints' => [
                    new Length([
                        'maxMessage' => 'This field is very long. Max 255 character',
                        'max' => 180
                    ]),
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон',
                'constraints' => [
                    new Length([
                        'maxMessage' => 'This field is very long. Max 255 character',
                        'max' => 50
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'соглашаюсь с <a class="link" href="https://www.gosuslugi.ru/" target="_blank">условиями сайта</a>',
                'label_html' => true,
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Зарегистрироваться',
            ])
        ;
    }
}
