<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Entity\DefaultEntity;

/**
 * Cartes
 *
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="Repository\DocumentRepository")
 */
class Document extends DefaultEntity
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
     * @ORM\Column(name="uri", type="string", length=255)
     */
    private $uri;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;

    /**
     * Set uri
     *
     * @param string $uri
     *
     * @return Actualite
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Document
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
}
