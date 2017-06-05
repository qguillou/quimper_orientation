<?php

namespace Bundle\AdminBundle\Form\TypeCourse;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class TypeCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('nom', TextType::class, array('label' => 'Nom du type de course', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('color', TextType::class, array('label' => 'Couleur d\'affichage', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer', 'attr' => array('class' => 'btn btn-success')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Entity\Type',
        ));
    }
}
