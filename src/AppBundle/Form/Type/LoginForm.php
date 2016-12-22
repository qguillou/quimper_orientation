<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array('label' => 'Pseudo', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('plainPassword', PasswordType::class, array('label' => 'Mot de passe', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
            ->add('save', SubmitType::class, array('label' => 'Se connecter', 'attr' => array('class' => 'btn btn-success')))
            ->add('password', ButtonType::class, array('label' => 'Mot de passe oublié ?', 'attr' => array('class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#ModalPasswordLost')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }
}
