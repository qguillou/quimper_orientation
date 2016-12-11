<?php

namespace AppBundle\Form\Course;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Entity\Circuit;
use AppBundle\Form\Circuit\CircuitType;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('label' => 'Nom de la course'))
            ->add('date', DateTimeType::class, array('label' => 'Date de la course'))
            ->add('lieu', TextType::class, array('label' => 'Lieu', 'required' => false))
            ->add('organisateur', TextType::class, array('label' => 'Organisateur', 'required' => false))
            ->add('type', EntityType::class, array('label' => 'Type', 'class' => 'AppBundle\Entity\Type', 'choice_label' => 'nom', 'required' => false, 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                  ->orderBy('t.nom', 'ASC');
                  },))
            //->add('circuits', CircuitType::class, array('mapped' => false))

            ->add('gps', TextType::class, array('label' => 'Coordonnées GPS', 'required' => false))
            ->add('inscription', CheckboxType::class, array('label' => 'Activer le système d\'inscription', 'required' => false))
            ->add('modification', DateTimeType::class, array('label' => 'Date limite d\'inscription'))
            ->add('annonce', FileType::class, array('mapped' => false, 'label' => 'Annonce de course', 'required' => false))
            ->add('files', FileType::class, array('mapped' => false, 'label' => 'Autres fichiers', 'required' => false, 'multiple' => true))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer les modifications'));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Course',
            'course' => null,
        ));
    }
}
