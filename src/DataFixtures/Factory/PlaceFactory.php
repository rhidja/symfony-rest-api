<?php

namespace App\DataFixtures\Factory;

use App\Entity\Place;
use App\Entity\Price;
use App\Repository\PlaceRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Place>
 *
 * @method        Place|Proxy create(array|callable $attributes = [])
 * @method static Place|Proxy createOne(array $attributes = [])
 * @method static Place|Proxy find(object|array|mixed $criteria)
 * @method static Place|Proxy findOrCreate(array $attributes)
 * @method static Place|Proxy first(string $sortedField = 'id')
 * @method static Place|Proxy last(string $sortedField = 'id')
 * @method static Place|Proxy random(array $attributes = [])
 * @method static Place|Proxy randomOrCreate(array $attributes = [])
 * @method static PlaceRepository|RepositoryProxy repository()
 * @method static Place[]|Proxy[] all()
 * @method static Place[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Place[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Place[]|Proxy[] findBy(array $attributes)
 * @method static Place[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Place[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 */
final class PlaceFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'address' => self::faker()->address(),
            'name' => self::faker()->domainName(),
            'themes' => ThemeFactory::randomRange(1,2),
            'prices' => [
                PriceFactory::new(['type' => 'enfant'])->withoutPersisting(),
                PriceFactory::new(['type' => 'adulte'])->withoutPersisting(),
                PriceFactory::new(['type' => 'senior'])->withoutPersisting(),
            ]
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Place $place): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Place::class;
    }
}
