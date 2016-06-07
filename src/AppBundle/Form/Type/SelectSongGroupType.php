<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SongType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('GET')
            ->add('song_group', EntityType::class, [
                'class' => 'AppBundle:SongGroup',
                'choice_label' => 'name',
                'label' => 'LABEL_SONG_GROUP_SONG_BUNDLE',
            ])
            ->add('submit', SubmitType::class, ['label' => 'LABEL_SONG_GROUP_SELECT'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Song',
        ]);
    }
}