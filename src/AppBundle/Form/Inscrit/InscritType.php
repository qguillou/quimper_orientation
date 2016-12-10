<?php

namespace AppBundle\Form\Inscrit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Course;

class InscritType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $course = 1;
        $builder
            ->add('nom', TextType::class, array('label' => 'Nom', 'disabled' => 'disabled'))
            ->add('prenom', TextType::class, array('label' => 'Prénom', 'disabled' => 'disabled'))
            ->add(  'circuit',
                    EntityType::class,
                    array(
                          'label' => 'Circuit',
                          'class' => 'AppBundle\Entity\Circuit',
                          'choice_label' => 'nom',
                          'required' => false,
                          'query_builder' => function(EntityRepository $er) use ($options)
                            {
                                return $er->createQueryBuilder('c')
                                    ->select('c')
                                    ->where('c.course = :id')
                                    ->setParameter('id', $options['course']);
                            },
                          )
                  )
            ->add('commentaire', TextType::class, array('label' => 'Commentaire', 'required' => false))
            ->add('puce', NumberType::class, array('label' => 'N° de Puce', 'required' => false))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer les modifications'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Inscrit',
            'course' => 1,
        ));
    }
}
