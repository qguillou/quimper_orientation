<?php

namespace Bundle\AdminBundle\Form\Inscrit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Doctrine\ORM\EntityRepository;

class InscritType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('id', IntegerType::class)
        ->add('nom', TextType::class, array('label' => 'lastName', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
        ->add('prenom', TextType::class, array('label' => 'firstName', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
        ->add('circuit',
                EntityType::class,
                array(
                      'label' => 'Circuit',
                      'class' => 'Entity\Circuit',
                      'choice_label' => 'nom',
                      'required' => false,
                      'query_builder' => function(EntityRepository $er) use ($options)
                        {
                            return $er->createQueryBuilder('c')
                                ->select('c')
                                ->where('c.course = :id')
                                ->setParameter('id', $options['course']);
                        },
                      'attr' => array('class' => 'form-control'),
                      'label_attr' => array('class' => 'col-sm-3 control-label')
                      )
              )
        ->add('commentaire', TextType::class, array('label' => 'Commentaire', 'required' => false, 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
        ->add('puce', NumberType::class, array('label' => 'N° de Puce', 'required' => false, 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
        ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
        ->add('save', SubmitType::class, array('label' => 'Enregistrer', 'attr' => array('class' => 'btn btn-success')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Entity\Inscrit',
            'course' => 1,
            'allow_extra_fields' => true
        ));
    }
}
