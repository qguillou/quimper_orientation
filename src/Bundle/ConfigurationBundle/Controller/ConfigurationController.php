<?php

namespace Bundle\ConfigurationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class ConfigurationController extends Controller
{
    public function indexAction(Request $request)
    {
        $defaultValues = array(
            'site_name' => $this->container->get('twig')->getGlobals()['site_name'],
            'nVersion' => $this->container->get('twig')->getGlobals()['nVersion'],
            'dVersion' => $this->container->get('twig')->getGlobals()['dVersion'],
            'author' => $this->container->get('twig')->getGlobals()['author'],

            'database_host' => $this->container->getParameter('database_host'),
            'database_port' => $this->container->getParameter('database_port'),
            'database_name' => $this->container->getParameter('database_name'),
            'database_user' => $this->container->getParameter('database_user'),
            'database_password' => $this->container->getParameter('database_password'),

            'mailer_transport' => $this->container->getParameter('mailer_transport'),
            'mailer_host' => $this->container->getParameter('mailer_host'),
            'mailer_user' => $this->container->getParameter('mailer_user'),
            'mailer_password' => $this->container->getParameter('mailer_password'),

            'module_club' => $this->container->get('twig')->getGlobals()['module_club'],
            'module_calendrier' => $this->container->get('twig')->getGlobals()['module_calendrier'],
            'module_inscription' => $this->container->get('twig')->getGlobals()['module_inscription'],
            'module_resultat' => $this->container->get('twig')->getGlobals()['module_resultat'],
            'module_carte' => $this->container->get('twig')->getGlobals()['module_carte'],
        );

        $form = $this->createFormBuilder($defaultValues)
            ->add('site_name', TextType::class, array('label' => 'Nom du site', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('color_primary', TextType::class, array('label' => 'Couleur principale', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('logo', FileType::class, array('label' => 'Logo du pied de page', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false, 'multiple' => true))

            ->add('nVersion', TextType::class, array('label' => 'N° de version', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('dVersion', TextType::class, array('label' => 'Date de version', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('author', TextType::class, array('label' => 'Auteur', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))

            ->add('database_host', TextType::class, array('label' => 'Host', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('database_port', TextType::class, array('label' => 'N° de port', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))
            ->add('database_name', TextType::class, array('label' => 'Nom de la base', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('database_user', TextType::class, array('label' => 'Nom de l\'utilisateur', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('database_password', TextType::class, array('label' => 'Mot de passe', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))

            ->add('mailer_transport', TextType::class, array('label' => 'Protocole', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('mailer_host', TextType::class, array('label' => 'Host', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('mailer_user', TextType::class, array('label' => 'Nom de l\'utilisateur', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))
            ->add('mailer_password', TextType::class, array('label' => 'Mot de passe', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => 'col-sm-3 control-label')))

            ->add('module_club', CheckboxType::class, array('label' => 'Activer le module', 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))

            ->add('module_calendrier', CheckboxType::class, array('label' => 'Activer le module', 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))

            ->add('module_inscription', CheckboxType::class, array('label' => 'Activer le module', 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))

            ->add('module_resultat', CheckboxType::class, array('label' => 'Activer le module', 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))

            ->add('module_carte', CheckboxType::class, array('label' => 'Activer le module', 'label_attr' => array('class' => 'col-sm-3 control-label'), 'required' => false))

            ->add('reset', ResetType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-default')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer', 'attr' => array('class' => 'btn btn-success')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $logo = array();
            foreach ($data['logo'] as $file) {
                // Move the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('logo'),
                    $file->getClientOriginalName()
                );

                $logo[] = '/images/logo/' . $fileName;
            }

            $ymlDump = array(
                'twig' => array(
                    'globals' => array(
                        'nVersion' => $data['nVersion'],
                        'dVersion' => $data['dVersion'],
                        'author' => $data['author'],
                        'site_name' => $data['site_name'],
                        'logo' => $logo,
                        'module_club' => $data['module_club'],
                        'module_calendrier' => $data['module_calendrier'],
                        'module_inscription' => $data['module_inscription'],
                        'module_resultat' => $data['module_resultat'],
                        'module_carte' => $data['module_carte'],
                    )
                ),
                'parameters' => array(
                    'database_host' => $data['database_host'],
                    'database_port' => $data['database_port'],
                    'database_name' => $data['database_name'],
                    'database_user' => $data['database_user'],
                    'database_password' => $data['database_password'],
                    'mailer_transport' => 'smtp',
                    'mailer_host' => '127.0.0.1',
                    'mailer_user' => 'null',
                    'mailer_password' => 'null',
                    'secret' => $this->container->getParameter('secret')
                )
            );

            $dumper = new Dumper();
            $yaml = $dumper->dump($ymlDump);
            $path = $this->get('kernel')->getRootDir() . '/../app/config/parameters.yml';
            file_put_contents($path, $yaml);

            $this->get('session')->getFlashBag()->add(
              'success',
              'Mise à jour effectuée, actualisez la page pour visualiser les modifications.'
            );
        }

        return $this->render('ConfigurationBundle:Configuration:index.html.twig',
            array('form' => $form->createView()));
    }
}
