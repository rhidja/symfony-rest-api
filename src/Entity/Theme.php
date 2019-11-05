<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="themes",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="themes_name_place_unique", columns={"name", "place_id"})}
 * )
 */
class Theme
{
    /**
     * L'identifiant unique d'un thème
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @Groups({"place", "theme"})
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * Le nom d'un thème
     *
     * @ORM\Column(type="string")
     * @Groups({"place", "theme"})
     */
    protected $name;

    /**
     * La valeur d'un thème
     *
     * @ORM\Column(type="integer")
     * @Groups({"place", "theme"})
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="themes")
     * @Groups({"theme"})
     * @var Place
     */
    protected $place;

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

    public function getPlace()
    {
        return $this->place;
    }

    public function setPlace(Place $place)
    {
        $this->place = $place;
    }
}
