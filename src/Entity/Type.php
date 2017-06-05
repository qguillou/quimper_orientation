<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="type")
 * @ORM\Entity(repositoryClass="Repository\TypeRepository")
 */
class Type
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
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Type
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
     * Set color
     *
     * @param string $color
     *
     * @return Type
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
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
