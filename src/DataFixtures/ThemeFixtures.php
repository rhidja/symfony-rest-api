<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Factory\ThemeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ThemeFixtures extends Fixture implements OrderedFixtureInterface
{
    public function getOrder(): int
    {
        return 1;
    }

    public function load(ObjectManager $manager): void
    {
        ThemeFactory::createSequence([
            ['name' => 'Architecture'],
            ['name' => 'History'],
            ['name' => 'Art'],
            ['name' => 'Nature'],
        ]);

        $manager->flush();
    }
}
