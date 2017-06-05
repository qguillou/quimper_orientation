<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cartes
 *
 * @ORM\Table(name="actualite")
 * @ORM\Entity(repositoryClass="Repository\ActualiteRepository")
 */
class Actualite
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="datetime")
     */
    private $dateModification;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
      * @var int
      * @ORM\ManyToOne(targetEntity="Entity\User")
      * @ORM\JoinColumn(name="userModification_id", referencedColumnName="id")
      */
    private $userModification;

    /**
      * @var int
      * @ORM\ManyToOne(targetEntity="Entity\User")
      * @ORM\JoinColumn(name="userCreation_id", referencedColumnName="id")
      */
    private $userCreation;


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
     * Set id
     *
     * @param string $id
     *
     * @return Actualite
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Actualite
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Actualite
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
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
     * Set dateModification
     *
     * @param \DateTime $dateModification
     *
     * @return Cartes
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set userCreation
     *
     * @param integer $userCreation
     *
     * @return Inscrit
     */
    public function setUserCreation($userCreation)
    {
        $this->userCreation = $userCreation;

        return $this;
    }

    /**
     * Get userCreation
     *
     * @return int
     */
    public function getUserCreation()
    {
        return $this->userCreation;
    }

    /**
     * Set userModification
     *
     * @param integer $userModification
     *
     * @return Inscrit
     */
    public function setUserModification($userModification)
    {
        $this->userModification = $userModification;

        return $this;
    }

    /**
     * Get userModification
     *
     * @return int
     */
    public function getUserModification()
    {
        return $this->userModification;
    }
}
