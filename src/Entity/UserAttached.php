<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Entity\DefaultEntity;

/**
 * user_attached
 *
 * @ORM\Table(name="user_attached")
 * @ORM\Entity(repositoryClass="Repository\UserAttachedRepository")
 */
class UserAttached extends DefaultEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\ManyToOne(targetEntity="Entity\User", cascade={"persist"}, inversedBy="users")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

     /**
     * @ORM\ManyToOne(targetEntity="Entity\Base", cascade={"persist"})
     * @ORM\JoinColumn(name="base_id", referencedColumnName="id")
     */
    private $license;

    /**
     * Set user
     *
     * @param integer $user
     *
     * @return user_attached
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set license
     *
     * @param integer $license
     *
     * @return user_attached
     */
    public function setLicense($license)
    {
        $this->license = $license;

        return $this;
    }

    /**
     * Get license
     *
     * @return int
     */
    public function getLicense()
    {
        return $this->license;
    }
}
