<?php

namespace Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class ActualiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('titre', TextType::class, array('label' => 'Titre de l\'actualité', 'attr' => array('class' => 'form-control col-sm-9'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('contenu', TextareaType::class, array('label' => 'Contenu', 'attr' => array('class' => 'form-control col-sm-9', 'rows' => '10'), 'label_attr' => array('class' => 'col-sm-3 control-label')))

            ->add('dateModification', DateTimeType::class, array('required' => false))
            ->add('dateCreation', DateTimeType::class, array('required' => false))
            ->add('userModification', EntityType::class, array('auto_initialize' => false, 'required' => false, 'class' => 'Entity\User', 'choice_label' => 'username'))
            ->add('userCreation', EntityType::class, array('auto_initialize' => false, 'required' => false, 'class' => 'Entity\User', 'choice_label' => 'username'))

            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer', 'attr' => array('class' => 'btn btn-success')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Entity\Actualite',
        ));
    }
}