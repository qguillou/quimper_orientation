<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Circuit
 *
 * @ORM\Table(name="circuit")
 * @ORM\Entity(repositoryClass="Repository\CircuitRepository")
 */
class Circuit
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
     * @var string
     *
     * @ORM\Column(name="information", type="string", length=255, nullable=true)
     */
    private $information;

    /**
      * @var int
      * @ORM\ManyToOne(targetEntity="Entity\Course", inversedBy="circuits")
      * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
      */
    private $course;

    /**
    * @ORM\OneToMany(targetEntity="Entity\Inscrit", mappedBy="circuit")
    */
    private $inscrits;


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
     * @return Circuit
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
     * Set information
     *
     * @param string $information
     *
     * @return Circuit
     */
    public function setInformation($information)
    {
        $this->information = $information;

        return $this;
    }

    /**
     * Get information
     *
     * @return string
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Set course
     *
     * @param integer $course
     *
     * @return Circuit
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return int
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set inscrits
     *
     * @param string $inscrits
     *
     * @return Course
     */
    public function setInscrits($inscrits)
    {
        $this->inscrits = $inscrits;

        return $this;
    }

    /**
     * Get inscrits
     *
     * @return array Inscrit
     */
    public function getInscrits()
    {
        return $this->inscrits;
    }
}
