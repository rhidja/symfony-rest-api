<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Place;
use App\Entity\Price;
use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlaceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Theme $architecture */
        $architecture = $this->getReference('architecture');
        /** @var Theme $history */
        $history = $this->getReference('history');
        /** @var Theme $art */
        $art = $this->getReference('art');

        $place = new Place();
        $place->setName('Tour Eiffel');
        $place->setAddress('5 Avenue Anatole France, 75007 Paris');
        $place->addTheme($architecture);
        $place->addTheme($history);
        $manager->persist($place);
        $this->addReference('tour_eiffel', $place);

        $price = new Price();
        $price->setType('Less than 12');
        $price->setValue(5.7);
        $price->setPlace($place);
        $manager->persist($price);

        $place = new Place();
        $place->setName('Mont-Saint-Michel');
        $place->setAddress('50170 Le Mont-Saint-Michel');
        $place->addTheme($history);
        $place->addTheme($art);
        $manager->persist($place);

        $this->addReference('mont_saint_michel', $place);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ThemeFixtures::class,
        ];
    }
}
