<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class InscritType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class, array('required' => false, 'label' => 'Nom', 'attr' => array('class' => 'form-control')))
            ->add('nom', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control')))
            ->add('prenom', TextType::class, array('label' => 'Prénom', 'attr' => array('class' => 'form-control')))
            ->add('circuit',
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
                          'attr' => array('class' => 'form-control')
                          )
                  )
            ->add('commentaire', TextType::class, array('label' => 'Commentaire', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('puce', NumberType::class, array('label' => 'N° de Puce', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer les modifications', 'attr' => array('class' => 'btn btn-success')))
            ->add('delete', SubmitType::class, array('label' => 'Supprimer l\'inscrit', 'attr' => array('class' => 'btn btn-danger')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Inscrit',
            'course' => 1,
        ));
    }
}
