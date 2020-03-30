<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use App\Model\IdTrait;
use App\Model\LabelTrait;
use App\Model\AuthorTrait;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Document
{
    use IdTrait;
    use LabelTrait;
    use AuthorTrait;

    /**
     * @Vich\UploadableField(mapping="content_file", fileNameProperty="filename")
     *
     * @var File|null
     */
    protected $documentFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $filename;

    public function setDocumentFile(?File $documentFile = null)
    {
        $this->documentFile = $documentFile;
    }

    public function getDocumentFile(): ?File
    {
        return $this->documentFile;
    }

    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }
}
