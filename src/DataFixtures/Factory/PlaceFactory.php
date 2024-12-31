<?php

namespace App\DataFixtures\Factory;

use App\Entity\Place;
use App\Repository\PlaceRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Place>
 *
 * @method        Place|Proxy create(array|callable $attributes = [])
 * @method static Place|Proxy createOne(array $attributes = [])
 * @method static Place|Proxy find(object|array|mixed $criteria)
 * @method static Place|Proxy findOrCreate(array $attributes)
 * @method static Place|Proxy first(string $sortedField = 'id')
 * @method static Place|Proxy last(string $sortedField = 'id')
 * @method static Place|Proxy random(array $attributes = [])
 * @method static Place|Proxy randomOrCreate(array $attributes = [])
 * @method static PlaceRepository|ProxyRepositoryDecorator repository()
 * @method static Place[]|Proxy[] all()
 * @method static Place[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Place[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Place[]|Proxy[] findBy(array $attributes)
 * @method static Place[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Place[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 */
final class PlaceFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Place::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
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
    public function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Place $place): void {})
        ;
    }
}
