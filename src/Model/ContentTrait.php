<?php

namespace App\Model;

Trait ContentTrait
{
    /**
     * @ORM\Column(type="text", nullable=true)
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
