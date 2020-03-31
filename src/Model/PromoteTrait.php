<?php

namespace App\Model;

Trait PromoteTrait
{
    /**
     * @ORM\Column(name="promote", type="boolean", nullable=true)
     * @PiCRUD\Property(
     *      label="Promu",
     *      type="checkbox",
     *      form={}
     * )
     */
    protected $promote;

    public function isPromote(): ?bool
    {
        return $this->promote;
    }

    public function setPromote(bool $promote): self
    {
        $this->promote = $promote;

        return $this;
    }
}
