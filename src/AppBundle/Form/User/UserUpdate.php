<?php

namespace AppBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserUpdate extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('label' => 'Adresse mail'))
            ->add('username', TextType::class, array('label' => 'Login'))
            ->add('plainPassword', RepeatedType::class, array(
                'required' => false,
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe', 'required' => false),
                'second_options' => array('label' => 'Confirmation du mot de passe', 'required' => false)))
            ->add('license', NumberType::class, array('label' => 'N° de licence', 'required' => false))
            ->add('nom', TextType::class, array('label' => 'Nom'))
            ->add('prenom', TextType::class, array('label' => 'Prénom'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }
}
