<?php

namespace AppBundle\Form\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fonction', TextType::class, array('label' => 'Fonction'))
            ->add('nom', TextType::class, array('label' => 'Nom'))
            ->add('prenom', TextType::class, array('label' => 'Prénom'))
            ->add('adresse', TextType::class, array('label' => 'Adresse', 'required' => false))
            ->add('mail', EmailType::class, array('label' => 'Adresse E-mail'))
            ->add('portable', TextType::class, array('label' => 'Portable', 'required' => false))
            ->add('telephone', TextType::class, array('label' => 'Téléphone', 'required' => false))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer les modifications'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact',
        ));
    }
}
