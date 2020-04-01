<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use App\Model\IdTrait;
use App\Model\TitleTrait;
use App\Model\ContentTrait;
use App\Model\AuthorTrait;
use App\Model\PrivateTrait;
use App\Model\ImageTrait;
use PiWeb\PiCRUD\Annotation as PiCRUD;

/**
 * @PiCRUD\Entity(
 *      name="map"
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Map
{
    use IdTrait;
    use TitleTrait;
    use AuthorTrait;
    use PrivateTrait;
    use ImageTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Document", cascade={"persist"})
     * @PiCRUD\Property(
     *      label="Fichier",
     *      type="file",
     *      form={},
     *      options={"entry_type": "App\Form\DocumentFormType"}
     * )
     */
    protected $file;

    public function __construct()
    {
        $this->image = new EmbeddedFile();
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }
}
