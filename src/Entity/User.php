<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'user')]
#[ORM\Entity]
class User extends BaseUser
{
    #[Groups(['users', 'auth-token'])]
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected $id;

    /**
     * Le nom d'un utilisateur.
     */
    #[Groups(['users', 'auth-token'])]
    #[ORM\Column(length: 32, nullable: true)]
    protected ?string $firstname = null;

    /**
     * Le prénom d'un utilisateur.
     */
    #[Groups(['users', 'auth-token'])]
    #[ORM\Column(length: 32, nullable: true)]
    protected ?string $lastname = null;

    /**
     * Le numéro de téléphone d'un utilisateur.
     */
    #[Groups(['users', 'auth-token'])]
    #[ORM\Column(length: 16, nullable: true)]
    protected ?string $mobile = null;

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }
}
