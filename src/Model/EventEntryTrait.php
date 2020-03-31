<?php

namespace App\Model;

use App\Entity\Team;
use App\Entity\People;

Trait EventEntryTrait
{
    /**
     * @ORM\Column(type="boolean")
     * @PiCRUD\Property(
     *      label="Activé les inscriptions",
     *      type="checkbox",
     *      form={}
     * )
     */
    protected $allowEntries;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @PiCRUD\Property(
     *      label="Date de clôture des inscriptions",
     *      type="datetime",
     *      form={}
     * )
     */
    protected $dateEntries;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @PiCRUD\Property(
     *      label="DONT USE",
     *      form={}
     * )
     */
    protected $numberPeopleByEntries;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", cascade={"persist", "remove"}, mappedBy="event")
     */
    protected $teams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\People", cascade={"persist", "remove"}, mappedBy="event")
     */
    protected $peoples;

    public function getAllowEntries(): ?bool
    {
        return $this->allowEntries;
    }

    public function setAllowEntries(bool $allowEntries): self
    {
        $this->allowEntries = $allowEntries;

        return $this;
    }

    public function getDateEntries(): ?\DateTimeInterface
    {
        return $this->dateEntries;
    }

    public function setDateEntries($dateEntries): self
    {
        $this->dateEntries = $dateEntries;

        return $this;
    }

    public function getNumberPeopleByEntries(): ?int
    {
        return $this->numberPeopleByEntries;
    }

    public function setNumberPeopleByEntries($numberPeopleByEntries): self
    {
        $this->numberPeopleByEntries = $numberPeopleByEntries;

        return $this;
    }

    public function getTeams()
    {
        return $this->teams;
    }

    public function getPeoples()
    {
        return $this->peoples;
    }
}
