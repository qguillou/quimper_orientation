<?php

namespace App\Model;

use App\Entity\User;
use PiWeb\PiCRUD\Annotation as PiCRUD;

Trait AuthorTrait
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     * @PiCRUD\Property(
     *      label="Créé par",
     *      admin={"class": "d-none d-lg-table-cell"}
     * )
     */
    protected $createBy;

    /**
    * @ORM\Column(type="datetime", nullable=true)
    * @PiCRUD\Property(
    *      label="Créé le",
    *      type="datetime",
    *      admin={"class": "d-none d-lg-table-cell", "options": {"date": "short", "time": "short"}}
    * )
    */
    protected $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     * @PiCRUD\Property(
     *      label="Modifié par",
     *      admin={"class": "d-none d-lg-table-cell"}
     * )
     */
    protected $updateBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @PiCRUD\Property(
     *      label="Modifié le",
     *      type="datetime",
     *      admin={"class": "d-none d-lg-table-cell", "options": {"date": "short", "time": "short"}}
     * )
     */
    protected $updateAt;

    public function getCreateBy(): ?User
    {
        return $this->createBy;
    }

    public function setCreateBy(User $user): self
    {
        $this->createBy = $user;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreateAt(): self
    {
        $this->createAt = new \DateTime();

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdateAt(): self
    {
        $this->updateAt = new \DateTime();

        return $this;
    }

    public function getUpdateBy(): ?User
    {
        return $this->updateBy;
    }

    public function setUpdateBy(User $user): self
    {
        $this->updateBy = $user;

        return $this;
    }
}
