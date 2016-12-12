<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserView extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('label' => 'Adresse mail', 'disabled' => true))
            ->add('username', TextType::class, array('label' => 'Login', 'disabled' => true))
            ->add('license', EntityType::class, array('label' => 'N° de licence', 'class' => 'AppBundle\Entity\Base', 'choice_label' => 'id', 'required' => false, 'disabled' => 'disabled'))
            ->add('nom', TextType::class, array('label' => 'Nom', 'disabled' => true))
            ->add('prenom', TextType::class, array('label' => 'Prénom', 'disabled' => true))
            ->add('delete', SubmitType::class, array('label' => 'Supprimer l\'utilisateur'));;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }
}
