<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Base
 *
 * @ORM\Table(name="base")
 * @ORM\Entity(repositoryClass="Repository\BaseRepository")
 */
class Base
{
  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="NONE")
   */
   private $id;

   /**
    * @var int
    *
    * @ORM\Column(name="puce", type="integer", nullable=true)
    */
    private $puce;

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
     * @var string
     *
     * @ORM\Column(name="ne", type="string", length=5, nullable=true)
     */
    private $ne;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_club", type="string", length=255, nullable=true)
     */
    private $nomclub;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=true)
     */
    private $categorie;


    /**
     * Set puce
     *
     * @param integer $puce
     *
     * @return Base
     */
    public function setPuce($puce)
    {
        $this->puce = $puce;

        return $this;
    }

    /**
     * Get puce
     *
     * @return integer
     */
    public function getPuce()
    {
        return $this->puce;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Base
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
     * @return Base
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
     * Set ne
     *
     * @param string $ne
     *
     * @return Base
     */
    public function setNe($ne)
    {
        $this->ne = $ne;

        return $this;
    }

    /**
     * Get ne
     *
     * @return string
     */
    public function getNe()
    {
        return $this->ne;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Base
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set nomclub
     *
     * @param string $nomclub
     *
     * @return Base
     */
    public function setNomclub($nomclub)
    {
        $this->nomclub = $nomclub;

        return $this;
    }

    /**
     * Get nomclub
     *
     * @return string
     */
    public function getNomclub()
    {
        return $this->nomclub;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Base
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     *
     * @return Base
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Get id
     *
     * @return integer
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
     * @return Base
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
