<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="places", uniqueConstraints={@ORM\UniqueConstraint(name="places_name_unique",columns={"name"})} )
 */
class Place
{
    /**
     * Identifiant unique du lieu
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @Groups({"place", "price", "theme"})
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * Le nom d'un lieu
     *
     * @ORM\Column(type="string")
     * @Groups({"place", "price", "theme"})
     */
    protected $name;

    /**
     * L'adresse d'un lieu
     *
     * @ORM\Column(type="string")
     * @Groups({"place", "price", "theme"})
     */
    protected $address;

    /**
     * La liste des prix d'un lieu
     *
     * @ORM\OneToMany(targetEntity="Price", mappedBy="place", cascade={"persist"})
     * @Groups({"place"})
     * @var Price[]
     */
    protected $prices;

    /**
     * La liste des thèmes d'un lieu
     *
     * @ORM\OneToMany(targetEntity="Theme", mappedBy="place", cascade={"persist"})
     * @Groups({"place"})
     * @var Theme[]
     */
    protected $themes;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
        $this->themes = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Add price
     *
     * @param \App\Entity\Price $price
     *
     * @return Place
     */
    public function addPrice(\App\Entity\Price $price)
    {
        $this->prices[] = $price;

        return $this;
    }

    /**
     * Remove price
     *
     * @param \App\Entity\Price $price
     */
    public function removePrice(\App\Entity\Price $price)
    {
        $this->prices->removeElement($price);
    }

    /**
     * Get prices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * Add theme
     *
     * @param \App\Entity\Theme $theme
     *
     * @return Place
     */
    public function addTheme(\App\Entity\Theme $theme)
    {
        $this->themes[] = $theme;

        return $this;
    }

    /**
     * Remove theme
     *
     * @param \App\Entity\Theme $theme
     */
    public function removeTheme(\App\Entity\Theme $theme)
    {
        $this->themes->removeElement($theme);
    }

    /**
     * Get themes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThemes()
    {
        return $this->themes;
    }
}
