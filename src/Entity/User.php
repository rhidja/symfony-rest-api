<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * Identifiant unique d'un utilisateur
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"users", "auth-token"})
     */
    protected $id;

    /**
     * Le nom d'un utilisateur
     *
	 * @var string
	 *
	 * @ORM\Column(name="firstname", type="string", length=32, nullable=true)
     * @Groups({"users", "auth-token"})
	 */
	protected $firstname;

	/**
     * Le prénom d'un utilisateur
     *
	 * @var string
	 *
	 * @ORM\Column(name="lastname", type="string", length=32, nullable=true)
     * @Groups({"users", "auth-token"})
	 */
	protected $lastname;

	/**
     * Le numéro de téléphone d'un utilisateur
     *
	 * @var string
	 *
	 * @ORM\Column(name="mobile", type="string", length=16, nullable=true)
     * @Groups({"users", "auth-token"})
	 */
	protected $mobile;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }
}
