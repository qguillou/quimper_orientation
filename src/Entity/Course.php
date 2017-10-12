<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Entity\DefaultEntity;

/**
 * Course
 *
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="Repository\CourseRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Course extends DefaultEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=8, nullable=true)
     */
    protected $latitude;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=8, nullable=true)
     */
    protected $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     */
    private $site;


     /**
      * @ORM\ManyToOne(targetEntity="Entity\Type")
      * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
      */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="inscription", type="boolean", nullable=true)
     */
    private $inscription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modification", type="datetime", nullable=true)
     */
    private $modification;

    /**
     * @var string
     *
     * @ORM\Column(name="gps", type="string", length=255, nullable=true)
     */
    private $gps;

    /**
     * @var string
     *
     * @ORM\Column(name="organisateur", type="string", length=255, nullable=true)
     */
    private $organisateur;

    /**
    * @ORM\OneToMany(targetEntity="Entity\Inscrit", mappedBy="course")
    */
    private $inscrits;

    /**
    * @ORM\OneToMany(targetEntity="Entity\Circuit", mappedBy="course")
    */
    private $circuits;

    public function __construct() {
        $this->inscrits = new ArrayCollection();
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Course
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
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Course
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Course
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Course
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set site
     *
     * @param string $site
     *
     * @return Course
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Course
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Course
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set inscription
     *
     * @param boolean $inscription
     *
     * @return Course
     */
    public function setInscription($inscription)
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * Get inscription
     *
     * @return bool
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * Set modification
     *
     * @param \DateTime $modification
     *
     * @return Course
     */
    public function setModification($modification)
    {
        $this->modification = $modification;

        return $this;
    }

    /**
     * Get modification
     *
     * @return \DateTime
     */
    public function getModification()
    {
        return $this->modification;
    }

    /**
     * Set gps
     *
     * @param string $gps
     *
     * @return Course
     */
    public function setGps($gps)
    {
        $this->gps = $gps;

        return $this;
    }

    /**
     * Get gps
     *
     * @return string
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     * Set organisateur
     *
     * @param string $organisateur
     *
     * @return Course
     */
    public function setOrganisateur($organisateur)
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    /**
     * Get organisateur
     *
     * @return string
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
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

    /**
     * Set circuits
     *
     * @param string $circuits
     *
     * @return Circuit
     */
    public function setCircuits($circuits)
    {
        $this->circuits = $circuits;

        return $this;
    }

    /**
     * Get circuits
     *
     * @return array Circuit
     */
    public function getCircuits()
    {
        return $this->circuits;
    }

    public function __toString()
    {
        return (string) $this->getNom();
    }
}
