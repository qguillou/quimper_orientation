<?php

namespace Bundle\InscriptionBundle\Form\Course;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class CourseSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', EntityType::class,
                array('auto_initialize' => false,
                'required' => false,
                'label' => 'Sélection de la course',
                'class' => 'Entity\Course',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.inscription = 1')
                        ->andWhere('c.date >= :date')
                        ->setParameter('date', new \DateTime())
                        ->orderBy('c.date', 'ASC');
                },
                'choice_label' => function ($course) {
                    return $course->getDate()->format('d/m/Y à H:i') . ' - ' . $course->getNom();
                },
                'required' => false,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-sm-4 control-label')
              ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Entity\Course',
        ));
    }
}
