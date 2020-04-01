<?php

namespace App\Model;

use PiWeb\PiCRUD\Annotation as PiCRUD;

Trait LabelTrait
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @PiCRUD\Property(
     *      label="Libellé",
     *      admin={"class": "font-weight-bold"},
     *      form={"class": "order-1"}
     * )
     */
    protected $label;

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getLabel();
    }
}
