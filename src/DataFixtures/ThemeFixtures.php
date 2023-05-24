<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ThemeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $theme = new Theme();
        $theme->setName('Architecture');
        $theme->setValue(7);
        $manager->persist($theme);
        $this->addReference('architecture', $theme);

        $theme = new Theme();
        $theme->setName('History');
        $theme->setValue(6);
        $manager->persist($theme);
        $this->addReference('history', $theme);


        $theme = new Theme();
        $theme->setName('Art');
        $theme->setValue(3);
        $manager->persist($theme);
        $this->addReference('art', $theme);

        $manager->flush();
    }
}
