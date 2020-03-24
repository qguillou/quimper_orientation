<?php

namespace App\Model;

Trait LabelTrait
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
