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

    /**
    * @ORM\OneToMany(targetEntity="Base", cascade={"persist", "remove"}, mappedBy="club")
    */
    protected $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

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

    public function getMembers()
    {
        return $this->members;
    }

    public function setMembers($members): self
    {
        $this->members = $members;

        return $this;
    }

    public function addMember($member)
    {
        $this->members->add($member);

        return $this;
    }

    public function removeMember($member)
    {
        $this->members->remove($member);

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName() . ' - ' . $this->getLabel();
    }
}
