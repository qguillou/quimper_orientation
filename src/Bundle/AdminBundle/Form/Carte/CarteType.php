<?php

namespace Bundle\AdminBundle\Form\Carte;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class CarteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('display', CheckboxType::class, array('label' => 'Afficher la carte', 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('nom', TextType::class, array('label' => 'Nom de la carte', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('alert', CheckboxType::class, array('label' => 'Mise à jour en cours', 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer', 'attr' => array('class' => 'btn btn-success')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Entity\Carte',
        ));
    }
}
