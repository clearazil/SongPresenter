<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST')
            ->add('username', TextType::class, ['label' => 'LABEL_USER_USERNAME'])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'first_options' => ['label' => 'LABEL_USER_PASSWORD'],
                'second_options' => ['label' => 'LABEL_USER_PASSWORD_REPEAT'],
            ])
            ->add('email', TextType::class, ['label' => 'LABEL_USER_EMAIL'])
            ->add('create', SubmitType::class, ['label' => 'BUTTON_USER_CREATE'])
        ;

        if($options['register']) {
            $builder->add('recaptcha', EWZRecaptchaType::class, [
                'mapped'        => false,
                'constraints'   => [
                    new RecaptchaTrue()
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'translation_domain' => 'forms',
            'register'              => true,
        ]);
    }
}