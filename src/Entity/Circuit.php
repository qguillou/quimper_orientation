<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\IdTrait;
use App\Model\LabelTrait;
use App\Model\AuthorTrait;
use App\Model\EventReferenceTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Circuit
{
    use IdTrait;
    use LabelTrait;
    use AuthorTrait;
    use EventReferenceTrait;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="circuits")
    */
    protected $event;

    /**
     * @ORM\OneToMany(targetEntity="People", cascade={"persist", "remove"}, orphanRemoval=true, mappedBy="circuit")
     */
    protected $peoples;
}
