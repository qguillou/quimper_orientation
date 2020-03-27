<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\IdTrait;
use App\Model\LabelTrait;
use App\Model\AuthorTrait;
use App\Model\PrivateTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Menu
{
    use IdTrait;
    use LabelTrait;
    use AuthorTrait;
    use PrivateTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $link;

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
