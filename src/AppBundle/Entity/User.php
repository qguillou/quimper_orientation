<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @ORM\Table(name="user")
* @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
*/
class User implements UserInterface, \Serializable
{
  /**
  * @ORM\Column(type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
  * @ORM\Column(type="string", length=100, unique=true)
  */
  private $username;

  /**
  * @ORM\Column(type="string", length=64)
  */
  private $password;

  /**
  * @Assert\Length(max=64)
  */
  private $plainPassword;

  /**
  * @ORM\Column(type="string", length=250, unique=true)
  */
  private $email;

  /**
  * @ORM\Column(name="is_active", type="boolean")
  */
  private $isActive;

  /**
  * @ORM\Column(name="newsletter", type="boolean", nullable=true)
  */
  private $newsletter;

  /**
  * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Base")
  * @ORM\JoinColumn(name="base_id", referencedColumnName="id", unique=true, nullable=true)
  */
  private $license;

  /**
  * @ORM\Column(name="nom", length=100, type="string")
  */
  private $nom;

  /**
  * @ORM\Column(name="prenom", length=100, type="string")
  */
  private $prenom;

  /**
  * @ORM\OneToOne(targetEntity="AppBundle\Entity\Role", mappedBy="user")
  */
  private $role;

  public function __construct()
  {
    $this->isActive = true;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function getSalt()
  {
    // you *may* need a real salt depending on your encoder
    // see section on salt below
    return null;
  }

  public function getPlainPassword()
  {
    return $this->plainPassword;
  }

  public function setPlainPassword($password)
  {
    $this->plainPassword = $password;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getRoles()
  {
    return array($this->getRole()->getRole());
  }

  public function eraseCredentials()
  {
  }

  public function isAccountNonExpired()
  {
    return true;
  }

  public function isAccountNonLocked()
  {
    return true;
  }

  public function isCredentialsNonExpired()
  {
    return true;
  }

  public function isEnabled()
  {
    return $this->isActive;
  }

  /** @see \Serializable::serialize() */
  public function serialize()
  {
    return serialize(array(
      $this->id,
      $this->username,
      $this->password,
      $this->isActive,
      // see section on salt below
      // $this->salt,
    ));
  }

  /** @see \Serializable::unserialize() */
  public function unserialize($serialized)
  {
    list (
      $this->id,
      $this->username,
      $this->password,
      $this->isActive,
      // see section on salt below
      // $this->salt
      ) = unserialize($serialized);
    }

    /**
    * Get id
    *
    * @return integer
    */
    public function getId()
    {
      return $this->id;
    }

    /**
    * Set username
    *
    * @param string $username
    *
    * @return User
    */
    public function setUsername($username)
    {
      $this->username = $username;

      return $this;
    }

    /**
    * Set password
    *
    * @param string $password
    *
    * @return User
    */
    public function setPassword($password)
    {
      $this->password = $password;

      return $this;
    }

    /**
    * Set email
    *
    * @param string $email
    *
    * @return User
    */
    public function setEmail($email)
    {
      $this->email = $email;

      return $this;
    }

    /**
    * Get email
    *
    * @return string
    */
    public function getEmail()
    {
      return $this->email;
    }

    /**
    * Set isActive
    *
    * @param boolean $isActive
    *
    * @return User
    */
    public function setActive($isActive)
    {
      $this->isActive = $isActive;

      return $this;
    }

    /**
    * Get isActive
    *
    * @return boolean
    */
    public function isActive()
    {
      return $this->isActive;
    }

    /**
    * Set newsletter
    *
    * @param boolean $newsletter
    *
    * @return User
    */
    public function setNewsletter($newsletter)
    {
      $this->newsletter = $newsletter;

      return $this;
    }

    /**
    * Get newsletter
    *
    * @return boolean
    */
    public function getNewsletter()
    {
      return $this->newsletter;
    }

    /**
    * Set license
    *
    * @param integer $license
    *
    * @return user
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

    /**
    * Set nom
    *
    * @param integer $nom
    *
    * @return user
    */
    public function setNom($nom)
    {
      $this->nom = $nom;

      return $this;
    }

    /**
    * Get prenom
    *
    * @return int
    */
    public function getPrenom()
    {
      return $this->prenom;
    }

    /**
    * Set prenom
    *
    * @param integer $prenom
    *
    * @return user
    */
    public function setPrenom($prenom)
    {
      $this->prenom = $prenom;

      return $this;
    }

    /**
    * Get nom
    *
    * @return int
    */
    public function getNom()
    {
      return $this->nom;
    }

    /**
    * Set role
    *
    * @param integer $role
    *
    * @return user
    */
    public function setRole($role)
    {
      $this->role = $role;

      return $this;
    }

    /**
    * Get role
    *
    * @return int
    */
    public function getRole()
    {
      return $this->role;
    }
  }
