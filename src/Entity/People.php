<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\IdTrait;
use App\Model\UserNameTrait;
use App\Model\AuthorTrait;
use App\Model\EventReferenceTrait;
use App\Entity\Base;
use App\Entity\Circuit;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class People
{
    use IdTrait;
    use UserNameTrait;
    use AuthorTrait;
    use EventReferenceTrait;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="peoples")
    */
    protected $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Base")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $base;

    /**
     * @ORM\ManyToOne(targetEntity="Team", cascade={"persist"}, inversedBy="peoples")
     */
    protected $team;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $club;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $si;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $comment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $position;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Circuit", inversedBy="peoples")
    */
    protected $circuit;

    public function getBase(): ?Base
    {
        return $this->base;
    }

    public function setBase(Base $base): self
    {
        $this->base = $base;
        $this->setFirstName($base->getFirstName());
        $this->setLastName($base->getLastName());
        $this->setClub($base->getClub());

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getClub(): ?string
    {
        return $this->club;
    }

    public function setClub($club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getSi(): ?string
    {
        return $this->si;
    }

    public function setSi($si): self
    {
        $this->si = $si;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment($comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getCircuit(): ?Circuit
    {
        return $this->circuit;
    }

    public function setCircuit(?Circuit $circuit): self
    {
        $this->circuit = $circuit;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) (!empty($this->getBase())) ? $this->getBase()->__toString() : $this->getFirstName() . ' ' . $this->getLastName();
    }
}
