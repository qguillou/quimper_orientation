<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class InscritUpdate extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inscrits', CollectionType::class, array(
              'entry_type' => InscritType::class,
              'entry_options' => array('course' => 263),
              'allow_delete'  => true,
              'allow_add'     => true,
              'allow_delete'  => true,
              'by_reference' => false,
              'prototype' => true))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer les modifications', 'attr' => array('class' => 'btn btn-success')))
            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}
