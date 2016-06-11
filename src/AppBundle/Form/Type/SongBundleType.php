<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SongBundleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST')
            ->add('abbreviation', TextType::class, ['label' => 'LABEL_SONG_BUNDLE_ABBR'])
            ->add('name', TextType::class, ['label' => 'LABEL_SONG_BUNDLE_NAME'])
            ->add('submit', SubmitType::class, ['label' => 'BUTTON_SONG_BUNDLE_CREATE'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\SongGroup',
            'translation_domain' => 'forms',
        ]);
    }
}