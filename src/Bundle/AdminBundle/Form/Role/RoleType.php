<?php

namespace Bundle\AdminBundle\Form\Role;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('user', EntityType::class,
                array('auto_initialize' => false,
                    'required' => false,
                    'label' => 'Utilisateur',
                    'class' => 'Entity\User',
                    'choice_label' => 'username',
                    'attr' => array('class' => 'form-control'),
                    'label_attr' => array('class' => 'col-sm-3 control-label')
                ))
            ->add('role', ChoiceType::class, array(
                'choices'  => array(
                    'Webmaster' => 'ROLE_WEBMASTER',
                ),
                'label' => 'Role',
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-sm-3 control-label')
            ))
            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer', 'attr' => array('class' => 'btn btn-success')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Entity\Role',
        ));
    }
}