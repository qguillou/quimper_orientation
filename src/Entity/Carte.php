<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Entity\DefaultEntity;

/**
 * Carte
 *
 * @ORM\Table(name="carte")
 * @ORM\Entity(repositoryClass="Repository\CarteRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Carte extends DefaultEntity
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
     * @var bool
     *
     * @ORM\Column(name="display", type="boolean")
     */
    private $display;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_telechargement", type="integer")
     */
    private $nbTelechargement = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="alert", type="boolean")
     */
    private $alert;

    /**
      * @var int
      * @ORM\OneToOne(targetEntity="Entity\Document")
      * @ORM\JoinColumn(name="file", referencedColumnName="id")
      */
    private $file;

    private $fileUpload;

    /**
     * Set display
     *
     * @param boolean $display
     *
     * @return Carte
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return bool
     */
    public function getDisplay()
    {
        return $this->display;
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Carte
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
     * Set nbTelechargement
     *
     * @param integer $nbTelechargement
     *
     * @return Carte
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
     * @return Carte
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

    /**
     * Set file
     *
     * @param integer $file
     *
     * @return Circuit
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return int
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set fileUpload
     *
     * @param integer $fileUpload
     *
     * @return Circuit
     */
    public function setFileUpload($fileUpload)
    {
        var_dump($fileUpldoad);
        $this->fileUpload = $fileUpload;

        return $this;
    }

    /**
     * Get fileUpload
     *
     * @return int
     */
    public function getFileUpload()
    {
        return $this->fileUpload;
    }

    /**
    * @ORM\PostPersist()
    * @ORM\PreUpdate()
    */
    public function uploadImage() {
        if (null === $this->fileUpload) {
            return;
        }

        $this->fileUpload->move($this->getParameter('cartes'), $this->image->getClientOriginalName());

        //$this->setImage($this->imageUpload->getClientOriginalName());
    }
}
