<?php

namespace UserBundle\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use UserBundle\Entity\User;

class AuthTokenUserProvider implements UserProviderInterface
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAuthToken($authTokenHeader)
    {
        return $this->em->getRepository('UserBundle:AuthToken')->findOneByValue($authTokenHeader);
    }

    public function loadUserByUsername($email)
    {
        return $this->em->getRepository('UserBundle:User')->findByEmail($email);
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
