<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\IdTrait;
use App\Model\TitleTrait;
use App\Model\ContentTrait;
use App\Model\ImageTrait;
use App\Model\DocumentTrait;
use App\Model\AuthorTrait;
use App\Model\PrivateTrait;
use App\Model\PromoteTrait;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class News
{
    use IdTrait;
    use TitleTrait;
    use ContentTrait;
    use ImageTrait;
    use DocumentTrait;
    use AuthorTrait;
    use PrivateTrait;
    use PromoteTrait;

    public function __construct()
    {
        $this->setPromote(true);
        $this->files = new ArrayCollection();
        $this->image = new EmbeddedFile();
    }
}
