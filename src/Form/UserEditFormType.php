<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserEditFormType extends AbstractType
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
            ->add('password', PasswordType::class, [
                'label' => 'Новый пароль',
                'required'  => false,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
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
            ->add('send', SubmitType::class, [
                'label' => 'Изменить',
            ])
        ;
    }
}
