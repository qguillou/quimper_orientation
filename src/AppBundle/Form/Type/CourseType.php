<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use AppBundle\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Type\CircuitType;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('label' => 'Nom de la course', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('date', DateTimeType::class, array('label' => 'Date de la course', 'widget' => 'single_text', 'format' => 'yyyy-MM-dd\'T\'hh:mm', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('lieu', TextType::class, array('label' => 'Lieu', 'required' => false, 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('organisateur', TextType::class, array('label' => 'Organisateur', 'required' => false, 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('type', EntityType::class, array('label' => 'Type', 'class' => 'AppBundle\Entity\Type', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label'), 'choice_label' => 'nom', 'required' => false, 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                  ->orderBy('t.nom', 'ASC');
                  },))
            ->add('circuits', CollectionType::class, array(
              'entry_type' => CircuitType::class,
              'allow_delete'  => true,
              'allow_add'     => true,
              'allow_delete'  => true,
              'by_reference' => false,
              'prototype' => true))

            ->add('gps', TextType::class, array('label' => 'Coordonnées GPS', 'required' => false, 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('inscription', CheckboxType::class, array('label' => 'Activer le système d\'inscription', 'required' => false, 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('modification', DateTimeType::class, array('label' => 'Date limite d\'inscription', 'widget' => 'single_text', 'required' => false, 'format' => 'yyyy-MM-dd\'T\'hh:mm', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('annonce', FileType::class, array('mapped' => false, 'label' => 'Annonce de course', 'required' => false, 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('files', FileType::class, array('mapped' => false, 'label' => 'Autres fichiers', 'required' => false, 'multiple' => true, 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer les modifications', 'attr' => array('class' => 'btn btn-success')))
            ->add('delete', SubmitType::class, array('label' => 'Supprimer la course', 'attr' => array('class' => 'btn btn-danger')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Course',
            'course' => null,
        ));
    }
}
