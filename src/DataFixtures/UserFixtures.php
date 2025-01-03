<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Factory\UserFactory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function getOrder(): int
    {
        return 1;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('ram@hidja.fr');
        $user->setFirstname('Ramtane');
        $user->setLastname('Hidja');

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'password'
        );
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();

        UserFactory::createMany(10);
    }
}
