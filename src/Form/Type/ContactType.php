<?php

namespace Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('display', CheckboxType::class, array('label' => 'Afficher la carte', 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('fonction', TextType::class, array('label' => 'Fonction', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('nom', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('prenom', TextType::class, array('label' => 'Prénom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('adresse', TextType::class, array('label' => 'Adresse', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('mail', TextType::class, array('label' => 'E-mail', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('telephone', TextType::class, array('label' => 'Téléphone', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('portable', TextType::class, array('label' => 'Portable', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))

            ->add('dateModification', DateTimeType::class, array('required' => false))
            ->add('dateCreation', DateTimeType::class, array('required' => false))
            ->add('userModification', EntityType::class, array('auto_initialize' => false, 'required' => false, 'class' => 'Entity\User', 'choice_label' => 'username'))
            ->add('userCreation', EntityType::class, array('auto_initialize' => false, 'required' => false, 'class' => 'Entity\User', 'choice_label' => 'username'))

            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer', 'attr' => array('class' => 'btn btn-success')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Entity\Carte',
        ));
    }
}
