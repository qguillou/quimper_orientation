<?php

namespace App\Model;

Trait EventLocationTrait
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @PiCRUD\Property(
     *      label="Localisation",
     *      form={"class": "order-4"}
     * )
     */
    protected $locationTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @PiCRUD\Property(
     *      label="Détail de la localisation",
     *      form={"class": "order-4"}
     * )
     */
    protected $locationInformation;

    /**
     * @ORM\Column(type="decimal", nullable=true, precision=8, scale=6)
     * @PiCRUD\Property(
     *      label="Latitude",
     *      form={"class": "order-4"}
     * )
     */
    protected $latitude;

    /**
     * @ORM\Column(type="decimal", nullable=true, precision=8, scale=6)
     * @PiCRUD\Property(
     *      label="Longitude",
     *      form={"class": "order-4"}
     * )
     */
    protected $longitude;

    public function getLocationTitle(): ?string
    {
        return $this->locationTitle;
    }

    public function setLocationTitle(string $locationTitle): self
    {
        $this->locationTitle = $locationTitle;

        return $this;
    }

    public function getLocationInformation(): ?string
    {
        return $this->locationInformation;
    }

    public function setLocationInformation($locationInformation): self
    {
        $this->locationInformation = $locationInformation;

        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
}
