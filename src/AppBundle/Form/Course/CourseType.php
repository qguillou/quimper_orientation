<?php

namespace AppBundle\Form\Course;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('label' => 'Nom de la course'))
            ->add('date', DateTimeType::class, array('label' => 'Date de la course'))
            ->add('lieu', TextType::class, array('label' => 'Lieu'))
            ->add('organisateur', TextType::class, array('label' => 'Organisateur'))
            ->add('type', EntityType::class, array('label' => 'Type', 'class' => 'AppBundle\Entity\Type', 'choice_label' => 'nom', 'required' => false))
            ->add('gps', TextType::class, array('label' => 'Coordonnées GPS'))
            ->add('inscription', CheckboxType::class, array('label' => 'Activer le système d\'inscription'))
            ->add('modification', DateTimeType::class, array('label' => 'Date limite d\'inscription'))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer les modifications'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Course',
        ));
    }
}
