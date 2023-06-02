<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'place')]
#[ORM\UniqueConstraint(name: 'places_name_unique', columns: ['name'])]
#[ORM\Entity(repositoryClass: PlaceRepository::class)]
class Place
{
    #[Groups(['place', 'price', 'theme'])]
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    /**
     * Le nom d'un lieu.
     */
    #[Groups(['place', 'price', 'theme'])]
    #[ORM\Column]
    protected ?string $name = null;

    /**
     * L'adresse d'un lieu.
     */
    #[Groups(['place', 'price', 'theme'])]
    #[ORM\Column]
    protected ?string $address = null;

    /**
     * La liste des prix d'un lieu.
     */
    #[Groups(['place'])]
    #[ORM\OneToMany(mappedBy: 'place', targetEntity: 'Price', cascade: ['persist'])]
    protected Collection $prices;

    /**
     * La liste des thèmes d'un lieu.
     */
    #[Groups(['place'])]
    #[ORM\OneToMany(mappedBy: 'place', targetEntity: 'Theme', cascade: ['persist'])]
    protected Collection $themes;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
        $this->themes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Add price.
     */
    public function addPrice(Price $price): self
    {
        $this->prices[] = $price;

        return $this;
    }

    /**
     * Remove price.
     */
    public function removePrice(Price $price): self
    {
        $this->prices->removeElement($price);

        return $this;
    }

    /**
     * Get prices.
     *
     * @return Price[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    /**
     * Add theme.
     */
    public function addTheme(Theme $theme): self
    {
        $this->themes[] = $theme;

        return $this;
    }

    /**
     * Remove theme.
     */
    public function removeTheme(Theme $theme): self
    {
        $this->themes->removeElement($theme);

        return $this;
    }

    /**
     * Get themes.
     *
     * @return Theme[]
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }
}
