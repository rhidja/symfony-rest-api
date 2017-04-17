<?php
# src/AppBundle/Entity/Preference.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="preferences",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="preferences_name_user_unique", columns={"name", "user_id"})}
 * )
 */
class Preference
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="preferences")
     * @var User
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Preference", mappedBy="user")
     * @var Preference[]
     */
    protected $preferences;

    public function __construct()
    {
        $this->preferences = new ArrayCollection();
    }


    public function match(Theme $theme)
    {
        return $this->name === $theme->getName();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
