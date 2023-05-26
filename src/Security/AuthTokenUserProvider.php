<?php

namespace App\Security;

use App\Entity\AuthToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthTokenUserProvider implements UserProviderInterface
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAuthToken($authTokenHeader)
    {
        return $this->em->getRepository(AuthToken::class)->findOneByValue($authTokenHeader);
    }

    public function loadUserByUsername($email)
    {
        return $this->em->getRepository(User::class)->findByEmail($email);
    }

    public function refreshUser(UserInterface $user): \Symfony\Component\Security\Core\User\UserInterface
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class): bool
    {
        return User::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        /** @var UserInterface $user */
        $user = $this->em->getRepository(User::class)->findBy(['email' => $identifier]);

        return $user;
    }
}
