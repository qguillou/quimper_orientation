<?php

namespace Bundle\CalendarBundle\Form\Inscrit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Bundle\CalendarBundle\Form\Inscrit\InscritType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Entity\Inscrit;

class CollectionInscritType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inscrits', CollectionType::class, array('entry_options' => array('course' => $options['course']), 'entry_type' => InscritType::class))
            ->add('reset', ResetType::class, array('label' => 'cancel', 'attr' => array('class' => 'btn btn-outlined btn-default')))
            ->add('save', SubmitType::class, array('label' => 'save', 'attr' => array('class' => 'btn btn-outlined btn-success')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults(array(
          'inscrits' => array(new Inscrit()),
          'course' => 1
      ));
    }
}
