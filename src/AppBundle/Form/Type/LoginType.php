<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST')
            ->add('username', TextType::class, ['label' => 'LABEL_LOGIN_USERNAME'])
            ->add('password', PasswordType::class, ['label' => 'LABEL_LOGIN_PASSWORD'])
            ->add('remember_me', CheckboxType::class, ['label' => 'LABEL_LOGIN_REMEMBER_ME'])
            ->add('login', SubmitType::class, ['label' => 'BUTTON_LOGIN_LOGIN'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_token_id' => 'authenticate',
            'translation_domain' => 'forms',
        ]);
    }
}