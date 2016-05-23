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
                'choice_label' => 'name'
            ])
            ->add('song_no', IntegerType::class, ['label' => 'Song number'])
            ->add('title', TextType::class)
            ->add('lang', TextType::class)
            ->add('verses', CollectionType::class, [
                'entry_type' => SongVerseType::class,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Create'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Song',
        ]);
    }
}