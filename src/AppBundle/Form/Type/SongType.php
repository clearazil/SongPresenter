<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SongType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST')
            ->add('song_group', EntityType::class, [
                'class' => 'AppBundle:SongGroup',
                'choice_label' => 'name',
                'label' => 'LABEL_SONG_GROUP_SONG_BUNDLE',
            ])
            ->add('song_no', IntegerType::class, ['label' => 'LABEL_SONG_NUMBER'])
            ->add('title', TextType::class, ['label' => 'LABEL_SONG_TITLE'])
            ->add('lang', TextType::class, ['label' => 'LABEL_SONG_LANGUAGE'])
            ->add('verses', CollectionType::class, [
                'entry_type' => SongVerseType::class,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('add_verse', SubmitType::class, ['label' => 'BUTTON_SONG_ADD_VERSE'])
            ->add('submit', SubmitType::class, ['label' => 'BUTTON_SONG_CREATE'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Song',
            'translation_domain' => 'forms',
        ]);
    }
}