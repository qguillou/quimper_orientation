<?php

namespace Bundle\CalendarBundle\Form\Inscrit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class InscritType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('add', CheckBoxType::class, array('required' => false, 'mapped' => false))
            ->add('id', IntegerType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add('nom', TextType::class, array('label' => 'lastName', 'attr' => array('class' => 'form-control')))
            ->add('prenom', TextType::class, array('label' => 'firstName', 'attr' => array('class' => 'form-control')))
            ->add('circuit',
                    EntityType::class,
                    array(
                          'label' => 'track',
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
                          'attr' => array('class' => 'form-control')
                          )
                  )
            ->add('commentaire', TextType::class, array('label' => 'Commentaire', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('puce', NumberType::class, array('label' => 'N° de Puce', 'required' => false, 'attr' => array('class' => 'form-control')));
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
