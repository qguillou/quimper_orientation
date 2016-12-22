<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class UserSelect extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('users', EntityType::class,
      array('label' => 'Licencié rattaché au compte',
            'class' => 'AppBundle\Entity\Base',
            'attr' => array('class' => 'form-control'),
            'label_attr' => array('class' => 'col-sm-4 control-label'),
            'choice_label' => 'id',
            'required' => false,
            'multiple' => true,
            'query_builder' => function (EntityRepository $er) {
              return $er->createQueryBuilder('b')
                ->orderBy('b.id', 'ASC');
                },))
      ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
      ->add('save', SubmitType::class, array('label' => 'Enregistrer le compte', 'attr' => array('class' => 'btn btn-success')));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\User',
    ));
  }
}
