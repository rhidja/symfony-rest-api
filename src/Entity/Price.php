<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PriceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'app_price')]
#[ORM\UniqueConstraint(name: 'prices_type_place_unique', columns: ['type', 'place_id'])]
#[ORM\Entity(repositoryClass: PriceRepository::class)]
class Price
{
    #[Groups(['place', 'price'])]
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    /**
     * Le type d'un prix.
     */
    #[Groups(['place', 'price'])]
    #[ORM\Column]
    protected ?string $type = null;

    /**
     * La valeur d'un prix.
     */
    #[Groups(['place', 'price'])]
    #[ORM\Column]
    protected ?float $value = null;

    #[Groups(['price'])]
    #[ORM\ManyToOne(inversedBy: 'prices')]
    protected ?Place $place = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setPlace(Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }
}
