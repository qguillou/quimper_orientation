<?php

namespace App\Model;

use PiWeb\PiCRUD\Annotation as PiCRUD;

Trait DocumentTrait
{
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Document", cascade={"persist"})
     * @PiCRUD\Property(
     *      label="Fichiers",
     *      type="files",
     *      form={"class": "order-6"},
     *      options={"entry_type": "App\Form\DocumentFormType"}
     * )
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
