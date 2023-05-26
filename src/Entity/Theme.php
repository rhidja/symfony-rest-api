<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'theme')]
#[ORM\UniqueConstraint(name: 'themes_name_place_unique', columns: ['name', 'place_id'])]
#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[Groups(['place', 'theme'])]
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    /**
     * Le nom d'un thème.
     */
    #[Groups(['place', 'theme'])]
    #[ORM\Column]
    protected ?string $name = null;

    /**
     * La valeur d'un thème.
     */
    #[Groups(['place', 'theme'])]
    #[ORM\Column]
    protected ?int $value = null;

    #[Groups(['theme'])]
    #[ORM\ManyToOne(inversedBy: 'themes')]
    protected ?Place $place = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(Place $place): self
    {
        $this->place = $place;

        return $this;
    }
}
