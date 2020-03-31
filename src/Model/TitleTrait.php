<?php

namespace App\Model;

use PiWeb\PiCRUD\Annotation as PiCRUD;

Trait TitleTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     * @PiCRUD\Property(
     *      label="Titre",
     *      admin={"class": "font-weight-bold"},
     *      form={}
     * )
     */
    protected $title;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getTitle();
    }
}
