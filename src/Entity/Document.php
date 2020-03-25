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
     * @Vich\UploadableField(mapping="content_file", fileNameProperty="document")
     *
     * @var File|null
     */
    protected $documentFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    protected $document;

    public function __construct()
    {
        $this->document = new EmbeddedFile();
    }

    public function setDocumentFile(?File $documentFile = null)
    {
        $this->documentFile = $documentFile;
    }

    public function getDocumentFile(): ?File
    {
        return $this->documentFile;
    }

    public function setDocument(EmbeddedFile $document): void
    {
        $this->document = $document;
    }

    public function getDocument(): ?EmbeddedFile
    {
        return $this->document;
    }
}
