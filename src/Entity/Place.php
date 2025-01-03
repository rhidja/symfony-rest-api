<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'app_place')]
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

    #[Groups(['place', 'price', 'theme'])]
    #[ORM\Column]
    protected ?string $city = null;

    #[Groups(['place', 'price', 'theme'])]
    #[ORM\Column]
    protected ?string $country = null;

    #[Groups(['place'])]
    #[ORM\OneToMany(mappedBy: 'place', targetEntity: Price::class, cascade: ['all'], orphanRemoval: true)]
    protected Collection $prices;

    #[Groups(['place'])]
    #[ORM\ManyToMany(targetEntity: Theme::class, cascade: ['all'], orphanRemoval: true)]
    #[ORM\JoinTable(name: 'app_place_theme')]
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Price[]|Collection
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices->add($price);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
        }

        return $this;
    }

    /**
     * @return Theme[]
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes->add($theme);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        if ($this->themes->contains($theme)) {
            $this->themes->removeElement($theme);
        }

        return $this;
    }
}
