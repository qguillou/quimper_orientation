<?php

namespace Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('username', TextType::class, array('required' => true, 'label' => 'Pseudo', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('nom', TextType::class, array('required' => false, 'label' => 'Nom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('prenom', TextType::class, array('required' => false, 'label' => 'Prénom', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('email', EmailType::class, array('label' => 'Adresse mail', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('license', EntityType::class,
                array('auto_initialize' => false,
                'required' => false,
                'label' => 'N° de licence FFCO',
                'class' => 'Entity\Base',
                'choice_label' => 'id',
                'required' => false,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-sm-3 control-label')
            ))
            ->add('newsletter', CheckboxType::class, array('label' => 'Recevoir la newsletter', 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))

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
            'data_class' => 'Entity\User',
        ));
    }
}
