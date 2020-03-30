<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content', CKEditorType::class, [
                'config_name' => 'default'
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer l\'image',
                'download_uri' => false,
                'image_uri' => true,
                'imagine_pattern' => 'thumbnail',
                'asset_helper' => true,
            ])
            ->add('dateBegin')
            ->add('dateEnd')
            ->add('organizer')
            ->add('website')
            ->add('private')
            ->add('locationTitle')
            ->add('locationInformation')
            ->add('latitude')
            ->add('longitude')
            ->add('allowEntries')
            ->add('dateEntries')
            ->add('numberPeopleByEntries')
            ->add('format')
            ->add('files', CollectionType::class, [
                'entry_type' => DocumentFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('circuits', CollectionType::class, [
                'entry_type' => CircuitFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
