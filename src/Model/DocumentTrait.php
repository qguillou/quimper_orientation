<?php

namespace App\Model;

Trait DocumentTrait
{
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Document", cascade={"persist"})
     */
    protected $files;

    public function getFiles()
    {
        return $this->files;
    }

    public function setFiles($files): self
    {
        $this->files = $files;

        return $this;
    }

    public function addFile($file): self
    {
        $this->files->add($file);

        return $this;
    }

    public function removeFile($file): self
    {
        $this->files->remove($file);

        return $this;
    }
}
