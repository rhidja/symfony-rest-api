<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('rhidja@gmail.com');
        $user->setFirstname('Ramtane');
        $user->setLastname('Hidja');

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'P@ssword'
        );
        $user->setPassword($hashedPassword);

        $manager->persist($user);

        $manager->flush();
    }
}
