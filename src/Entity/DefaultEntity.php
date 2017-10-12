<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DefaultEntity
 */
abstract class DefaultEntity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="datetime")
     */
    protected $dateModification;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    protected $dateCreation;

    /**
      * @var int
      * @ORM\ManyToOne(targetEntity="Entity\User")
      * @ORM\JoinColumn(name="userModification_id", referencedColumnName="id")
      */
    protected $userModification;

    /**
      * @var int
      * @ORM\ManyToOne(targetEntity="Entity\User")
      * @ORM\JoinColumn(name="userCreation_id", referencedColumnName="id")
      */
    protected $userCreation;


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
     * Set dateModification
     *
     * @param \DateTime $dateModification
     *
     * @return Carte
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
     * @return Carte
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

    /**
    * @ORM\PreUpdate()
    * @ORM\PrePersist()
    */
    public function update() {
        $this->dateModification = new \DateTime('now');
    }

    /**
    * @ORM\PrePersist()
    */
    public function create() {
        $this->dateCreation = new \DateTime('now');
    }
}
