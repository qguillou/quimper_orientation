<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Format;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Model\IdTrait;
use App\Model\TitleTrait;
use App\Model\ContentTrait;
use App\Model\AuthorTrait;
use App\Model\PrivateTrait;
use App\Model\ImageTrait;
use App\Model\DocumentTrait;
use App\Model\EventLocationTrait;
use App\Model\EventEntryTrait;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use PiWeb\PiCRUD\Annotation as PiCRUD;

/**
 * @PiCRUD\Entity(
 *      name="event",
 *      show={}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Event
{
    use IdTrait;
    use TitleTrait;
    use ContentTrait;
    use AuthorTrait;
    use PrivateTrait;
    use ImageTrait;
    use DocumentTrait;
    use EventLocationTrait;
    use EventEntryTrait;

    /**
     * @ORM\Column(type="datetime")
     * @PiCRUD\Property(
     *      label="Date de début",
     *      type="datetime",
     *      admin={"options": {"date": "short", "time": "short"}},
     *      form={}
     * )
     */
    protected $dateBegin;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @PiCRUD\Property(
     *      label="Date de fin",
     *      type="datetime",
     *      form={}
     * )
     */
    protected $dateEnd;

    /**
     * @ORM\ManyToOne(targetEntity="Format")
     * @PiCRUD\Property(
     *      label="Type d'évènements",
     *      form={}
     * )
     */
    protected $format;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @PiCRUD\Property(
     *      label="Organisateur",
     *      form={}
     * )
     */
    protected $organizer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @PiCRUD\Property(
     *      label="Site web",
     *      form={}
     * )
     */
    protected $website;

    /**
     * @ORM\OneToMany(targetEntity="Circuit", cascade={"persist", "remove"}, orphanRemoval=true, mappedBy="event")
     * @PiCRUD\Property(
     *      label="Circuits",
     *      type="circuits",
     *      form={}
     * )
     */
    protected $circuits;

    public function __construct()
    {
        $this->circuits = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->numberPeopleByEntries = 1;
        $this->image = new EmbeddedFile();
    }

    public function getOrganizer()
    {
        return $this->organizer;
    }

    public function setOrganizer(string $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getLinkEvents()
    {
        return $this->linkEvents;
    }

    public function setLinkEvents($linkEvents): self
    {
        $this->linkEvents = $linkEvents;

        return $this;
    }

    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    public function setDateBegin(\DateTime $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    public function setDateEnd($dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getFormat(): ?Format
    {
        return $this->format;
    }

    public function setFormat(Format $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getCircuits()
    {
        return $this->circuits;
    }

    public function setCircuits($circuits): self
    {
        $this->circuits = $circuits;

        return $this;
    }

    public function addCircuit($circuit)
    {
        $circuit->setEvent($this);
        $this->circuits->add($circuit);

        return $this;
    }

    public function removeCircuit($circuit)
    {
        $this->circuits->remove($circuit);

        return $this;
    }
}
