<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AuthTokenRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'auth_token')]
#[ORM\UniqueConstraint(name: 'auth_token_value_unique', columns: ['value'])]
#[ORM\Entity(repositoryClass: AuthTokenRepository::class)]
class AuthToken
{
    #[Groups(['auth-token'])]
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    #[Groups(['auth-token'])]
    #[ORM\Column]
    protected ?string $value = null;

    #[Groups(['auth-token'])]
    #[ORM\Column]
    protected \DateTimeImmutable $createdAt;

    #[Groups(['auth-token'])]
    #[ORM\ManyToOne]
    protected ?UserInterface $user = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }
}
