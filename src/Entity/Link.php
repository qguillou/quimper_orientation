<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\IdTrait;
use App\Model\LabelTrait;
use App\Model\AuthorTrait;
use App\Model\PrivateTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinkRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Link
{
    use IdTrait;
    use LabelTrait;
    use AuthorTrait;
    use PrivateTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $link;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
