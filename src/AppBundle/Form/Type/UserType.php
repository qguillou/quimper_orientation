<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('email', EmailType::class, array('label' => 'Adresse mail', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
    ->add('username', TextType::class, array('required' => false, 'label' => 'Pseudo', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
    ->add('plainPassword', RepeatedType::class, array(
      'required' => false,
      'type' => PasswordType::class,
      'first_options'  => array('required' => false, 'label' => 'Mot de passe', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')),
      'second_options' => array('required' => false, 'label' => 'Confirmation du mot de passe', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label'))))
      ->add('license', EntityType::class, array('auto_initialize' => false, 'required' => false, 'label' => 'N° de licence FFCO', 'class' => 'AppBundle\Entity\Base', 'choice_label' => 'id', 'required' => false, 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
      ->add('nom', TextType::class, array('required' => false, 'label' => 'Nom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
      ->add('newsletter', CheckboxType::class, array('label' => 'Recevoir la newsletter', 'required' => false))
      ->add('prenom', TextType::class, array('required' => false, 'label' => 'Prénom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
      ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
      ->add('save', SubmitType::class, array('label' => 'Enregistrer le compte', 'attr' => array('class' => 'btn btn-success')))
      ->add('delete', SubmitType::class, array('label' => 'Supprimer le compte', 'attr' => array('class' => 'btn btn-danger')));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\User',
    ));
  }
}
