<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class InscritUpdate extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inscrits', CollectionType::class, array(
              'entry_type' => InscritType::class,
              'allow_delete'  => true,
              'allow_add'     => true,
              'allow_delete'  => true,
              'by_reference' => false,
              'prototype' => true))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer les modifications'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'course' => null,
        ));
    }
}
