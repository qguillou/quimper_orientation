<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cartes
 *
 * @ORM\Table(name="cartes")
 * @ORM\Entity(repositoryClass="Repository\CartesRepository")
 */
class Cartes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="datetime")
     */
    private $dateModification;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_telechargement", type="integer")
     */
    private $nbTelechargement;

    /**
     * @var bool
     *
     * @ORM\Column(name="alert", type="boolean")
     */
    private $alert;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Cartes
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     *
     * @return Cartes
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set nbTelechargement
     *
     * @param integer $nbTelechargement
     *
     * @return Cartes
     */
    public function setNbTelechargement($nbTelechargement)
    {
        $this->nbTelechargement = $nbTelechargement;

        return $this;
    }

    /**
     * Get nbTelechargement
     *
     * @return int
     */
    public function getNbTelechargement()
    {
        return $this->nbTelechargement;
    }

    /**
     * Set alert
     *
     * @param boolean $alert
     *
     * @return Cartes
     */
    public function setAlert($alert)
    {
        $this->alert = $alert;

        return $this;
    }

    /**
     * Get alert
     *
     * @return bool
     */
    public function getAlert()
    {
        return $this->alert;
    }
}
