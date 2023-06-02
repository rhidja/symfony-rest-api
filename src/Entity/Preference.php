<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PreferenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'preference')]
#[ORM\UniqueConstraint(name: 'preferences_name_user_unique', columns: ['name', 'user_id'])]
#[ORM\Entity(repositoryClass: PreferenceRepository::class)]
class Preference
{
    #[Groups(['user', 'preference'])]
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    /**
     * Nom d'une préférence.
     */
    #[Groups(['user', 'preference'])]
    #[ORM\Column]
    protected ?string $name = null;

    /**
     * Valeur d'une préférence.
     */
    #[Groups(['user', 'preference'])]
    #[ORM\Column]
    protected ?int $value = null;

    #[Groups(['preference'])]
    #[ORM\ManyToOne]
    protected ?UserInterface $user = null;

    public function match(Theme $theme): bool
    {
        return $this->name === $theme->getName();
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

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function setUser(UserInterface $user = null): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }
}
