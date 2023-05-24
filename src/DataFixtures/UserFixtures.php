<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('rahid');
        $user->setEmail('rhidja@gmail.com');
        $user->setPlainPassword('P@ssword');
        $user->setFirstname('Ramtane');
        $user->setLastname('Hidja');
        $user->setEnabled(true);
        $manager->persist($user);

        $manager->flush();
    }
}
