<?php

namespace App\Model;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use PiWeb\PiCRUD\Annotation as PiCRUD;

Trait ImageTrait
{
    /**
     * @Vich\UploadableField(mapping="content_image", fileNameProperty="image.name", size="image.size", mimeType="image.mimeType", originalName="image.originalName", dimensions="image.dimensions")
     * @PiCRUD\Property(
     *      label="Image",
     *      type="image",
     *      form={"class": "order-1"}
     * )
     * @var File|null
     */
    protected $imageFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    protected $image;

    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(EmbeddedFile $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?EmbeddedFile
    {
        return $this->image;
    }
}
