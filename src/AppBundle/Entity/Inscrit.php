<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Inscrit
 *
 * @ORM\Table(name="inscrit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InscritRepository")
 * @UniqueEntity(fields={"course","licence","nom","prenom"})
 */
class Inscrit
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Base", cascade={"persist"})
     * @ORM\JoinColumn(name="base_id", referencedColumnName="id", nullable=true)
     */
    private $licence;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Course", inversedBy="inscrits", cascade={"persist"})
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;

    /**
     * @var int
     *
     * @ORM\Column(name="puce", type="integer", nullable=true)
     */
    private $puce;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Circuit", inversedBy="inscrits", cascade={"persist"})
     * @ORM\JoinColumn(name="circuit_id", referencedColumnName="id")
     */
    private $circuit;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="inscrits", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
   private $user;


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
     * @return Inscrit
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Inscrit
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set licence
     *
     * @param integer $licence
     *
     * @return Inscrit
     */
    public function setLicence($licence)
    {
        $this->licence = $licence;

        return $this;
    }

    /**
     * Get licence
     *
     * @return int
     */
    public function getLicence()
    {
        return $this->licence;
    }

    /**
     * Set course
     *
     * @param integer $course
     *
     * @return Inscrit
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
     * Set puce
     *
     * @param integer $puce
     *
     * @return Inscrit
     */
    public function setPuce($puce)
    {
        $this->puce = $puce;

        return $this;
    }

    /**
     * Get puce
     *
     * @return int
     */
    public function getPuce()
    {
        return $this->puce;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Inscrit
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set circuit
     *
     * @param integer $circuit
     *
     * @return Inscrit
     */
    public function setCircuit($circuit)
    {
        $this->circuit = $circuit;

        return $this;
    }

    /**
     * Get circuit
     *
     * @return int
     */
    public function getCircuit()
    {
        return $this->circuit;
    }

    /**
     * Set user
     *
     * @param string user
     *
     * @return Course
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
}
