<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Model\LabelTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClubRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Club
{
    use LabelTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName() . ' - ' . $this->getLabel();
    }
}
