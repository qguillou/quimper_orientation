<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * user_attached
 *
 * @ORM\Table(name="user_attached")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\user_attachedRepository")
 */
class User_attached
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", cascade={"persist"}, inversedBy="users")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Base", cascade={"persist"})
     * @ORM\JoinColumn(name="base_id", referencedColumnName="id")
     */
    private $license;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

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
