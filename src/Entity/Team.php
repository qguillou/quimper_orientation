<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Model\IdTrait;
use App\Model\LabelTrait;
use App\Model\AuthorTrait;
use App\Model\EventReferenceTrait;
use App\Entity\Base;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Team
{
    use IdTrait;
    use LabelTrait;
    use AuthorTrait;
    use EventReferenceTrait;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="teams")
    */
    protected $event;

    /**
     * @ORM\OneToMany(targetEntity="People", mappedBy="team", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $peoples;

    public function __construct()
    {
        $this->peoples = new ArrayCollection();
    }

    public function getPeoples()
    {
        return $this->peoples;
    }

    public function setPeoples(ArrayCollection $peoples): self
    {
        $this->peoples = $peoples;

        return $this;
    }

    public function addPeople(People $people): self
    {
        $this->peoples->add($people);
        $people->setTeam($this);
        $people->setEvent($this->getEvent());

        return $this;
    }

    public function removePeople(People $people): self
    {
        $this->peoples->remove($people);

        return $this;
    }

    public function contains(Base $base)
    {
        if (!empty($base)) {
            return false;
        }

        $this->peoples->rewind();

        while ($this->peoples->valid()) {
            if($this->peoples->current()->getBase() === $base) {
                return true;
            }

            $this->peoples->next();
        }

        return false;
    }
}
