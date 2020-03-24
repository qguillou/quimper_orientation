<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\UserNameTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BaseRepository")
 */
class Base
{
    use UserNameTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    protected $si;

    /**
     * @ORM\ManyToOne(targetEntity="Club")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $club;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getSi()
    {
        return $this->si;
    }

    public function setSi($si): self
    {
        $this->si = $si;

        return $this;
    }

    public function getClub(): Club
    {
        return $this->club;
    }

    public function setClub(Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function __toString()
    {
        return $this->getId() . ' - ' . $this->getLastName() . ' ' . $this->getFirstName();
    }
}
