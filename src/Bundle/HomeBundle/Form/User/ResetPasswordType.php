<?php

namespace Bundle\HomeBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class ResetPasswordType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('email', EmailType::class, array('label' => 'Adresse mail', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
      ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-outlined btn-default')))
      ->add('save', SubmitType::class, array('label' => 'Ré-initialiser le mot de passe', 'attr' => array('class' => 'btn btn-outlined btn-success')));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Entity\User',
    ));
  }
}
