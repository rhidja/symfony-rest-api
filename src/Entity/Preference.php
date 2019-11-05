<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="preferences", uniqueConstraints={@ORM\UniqueConstraint(name="preferences_name_user_unique", columns={"name", "user_id"})} )
 */
class Preference
{
    /**
     * Identifiant unique d'une préférence
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @Groups({"user", "preference"})
     */
    protected $id;

    /**
     * Nom d'une préférence
     *
     * @ORM\Column(type="string")
     * @Groups({"user", "preference"})
     */
    protected $name;

    /**
     * Valeur d'une préférence
     *
     * @ORM\Column(type="integer")
     * @Groups({"user", "preference"})
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @var User
     * @Groups({"preference"})
     */
    protected $user;

    public function match(Theme $theme)
    {
        return $this->name === $theme->getName();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Preference
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Preference
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     *
     * @return Preference
     */
    public function setUser(\App\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
