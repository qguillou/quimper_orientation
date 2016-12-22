<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class CircuitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('label' => 'Nom du circuit', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('information', TextType::class, array('label' => 'Informations', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer les modifications', 'attr' => array('class' => 'btn btn-success')))
            ->add('delete', SubmitType::class, array('label' => 'Supprimer le circuit', 'attr' => array('class' => 'btn btn-danger')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Circuit',
        ));
    }
}
