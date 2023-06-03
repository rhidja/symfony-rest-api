<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Factory\PlaceFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlaceFixtures extends Fixture implements OrderedFixtureInterface
{
    public function getOrder(): int
    {
        return 2;
    }

    public function load(ObjectManager $manager): void
    {
        PlaceFactory::createSequence($this->getSequence());
        $manager->flush();
    }

    private function getSequence()
    {
        return [
            ['name' => 'Empire State Bilding', 'city' => 'New York', 'country' => 'USA'],
            ['name' => 'Freedom Tower', 'city' => 'New York', 'country' => 'USA'],
            ['name' => 'CN Tower', 'city' => 'Toronto', 'country' => 'Canada'],
            ['name' => 'Arc de Triomphe', 'city' => 'Paris', 'country' => 'France'],
            ['name' => 'Tour Eiffel', 'city' => 'Paris', 'country' => 'France'],
            ['name' => 'Le Louvre', 'city' => 'Paris', 'country' => 'France'],
            ['name' => 'Burj Khalifa', 'city' => 'Dubaï', 'country' => 'Emirats Arabes Unis'],
            ['name' => 'Disneyland', 'city' => 'Californie', 'country' => 'USA'],
            ['name' => 'Buckingham Palace', 'city' => 'Londres', 'country' => 'Angleterre'],
            ['name' => 'Golden Gate Bridge', 'city' => 'San Francisco', 'country' => 'USA'],
            ['name' => 'Opéra de Sydney', 'city' => 'Sydney', 'country' => 'Australie'],
            ['name' => 'Le Mur de Berlin', 'city' => 'Berlin', 'country' => 'Allemagne'],
            ['name' => 'La Mosquée Bleue', 'city' => 'Istanbul', 'country' => 'Turquie'],
            ['name' => 'Le Vatican', 'city' => 'Le Vatican', 'country' => 'Le Vatican'],
            ['name' => ' La grande pyramide de Gizeh', 'city' => 'Gizeh', 'country' => 'Egypte']
        ];
    }
}
