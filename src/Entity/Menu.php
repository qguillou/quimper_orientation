<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\IdTrait;
use App\Model\LabelTrait;
use App\Model\AuthorTrait;
use App\Model\PrivateTrait;
use PiWeb\PiCRUD\Annotation as PiCRUD;

/**
 * @PiCRUD\Entity(
 *      name="menu"
 * )
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
     * @PiCRUD\Property(
     *      label="URL",
     *      form={}
     * )
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
