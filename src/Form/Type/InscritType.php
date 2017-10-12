<?php

namespace Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class InscritType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('nom', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('prenom', TextType::class, array('label' => 'Prénom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('licence', EntityType::class, array('auto_initialize' => false, 'required' => false, 'label' => 'Licence', 'class' => 'Entity\Base', 'choice_label' => 'id', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('course', EntityType::class, array('auto_initialize' => false, 'required' => false, 'label' => 'Course', 'class' => 'Entity\Course', 'choice_label' => 'nom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('puce', IntegerType::class, array('label' => 'Puce', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('commentaire', TextType::class, array('label' => 'Commentaire', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))

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
            'data_class' => 'Entity\Inscrit',
            'course' => 1,
            'allow_extra_fields' => true
        ));
    }
}
