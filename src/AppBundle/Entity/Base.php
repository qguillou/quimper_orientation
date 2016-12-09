<?php

namespace AppBundle\Entity;

/**
 * Base
 */
class Base
{
    /**
     * @var integer
     */
    private $puce;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     */
    private $ne;

    /**
     * @var string
     */
    private $sexe;

    /**
     * @var string
     */
    private $nomclub;

    /**
     * @var string
     */
    private $ville;

    /**
     * @var string
     */
    private $categorie;

    /**
     * @var integer
     */
    private $id;


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
}

