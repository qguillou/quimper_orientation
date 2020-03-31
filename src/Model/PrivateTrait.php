<?php

namespace App\Model;

use PiWeb\PiCRUD\Annotation as PiCRUD;

Trait PrivateTrait
{
    /**
     * @ORM\Column(name="private", type="boolean", nullable=true)
     * @PiCRUD\Property(
     *      label="Privé",
     *      type="checkbox",
     *      admin={"class": "d-none d-md-table-cell"},
     *      form={}
     * )
     */
    protected $private;

    public function isPrivate(): ?bool
    {
        return $this->private;
    }

    public function setPrivate(bool $private): self
    {
        $this->private = $private;

        return $this;
    }
}
