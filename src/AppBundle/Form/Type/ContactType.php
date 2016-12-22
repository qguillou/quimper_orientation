<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fonction', TextType::class, array('label' => 'Fonction', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('nom', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('prenom', TextType::class, array('label' => 'Prénom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('adresse', TextType::class, array('label' => 'Adresse', 'required' => false, 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('mail', EmailType::class, array('label' => 'Adresse E-mail', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('portable', TextType::class, array('label' => 'N° de Portable', 'required' => false, 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('telephone', TextType::class, array('label' => 'N° de Téléphone', 'required' => false, 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-4 control-label')))
            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer les modifications', 'attr' => array('class' => 'btn btn-success')))
            ->add('delete', SubmitType::class, array('label' => 'Supprimer le contact', 'attr' => array('class' => 'btn btn-danger')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact',
        ));
    }
}
