<?php

namespace Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('nom', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('date', DateTimeType::class, array('label' => 'Date', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('lieu', TextType::class, array('label' => 'Lieu', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('gps', TextType::class, array('label' => 'Coordonnées GPS', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('organisateur', TextType::class, array('label' => 'Organisateur', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('type', EntityType::class, array('auto_initialize' => false, 'required' => false, 'label' => 'Type', 'class' => 'Entity\Type', 'choice_label' => 'nom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('inscription', CheckboxType::class, array('label' => 'Activer le système d\'inscription', 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('modification', DateTimeType::class, array('label' => 'Date limite d\'inscription', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('site', TextType::class, array('label' => 'Site Internet', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))

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
            'data_class' => 'Entity\Course',
        ));
    }
}
