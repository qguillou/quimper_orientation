<?php

namespace App\Model;

use PiWeb\PiCRUD\Annotation as PiCRUD;

Trait ContentTrait
{
    /**
     * @ORM\Column(type="text", nullable=true)
     * @PiCRUD\Property(
     *      label="Contenu",
     *      form={}
     * )
     */
    protected $content;

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }
}
