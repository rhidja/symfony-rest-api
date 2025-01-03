<?php

namespace App\DataFixtures\Factory;

use App\Entity\Price;
use App\Repository\PriceRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends ProxyRepositoryDecorator<Price>
 *
 * @method        Price|Proxy create(array|callable $attributes = [])
 * @method static Price|Proxy createOne(array $attributes = [])
 * @method static Price|Proxy find(object|array|mixed $criteria)
 * @method static Price|Proxy findOrCreate(array $attributes)
 * @method static Price|Proxy first(string $sortedField = 'id')
 * @method static Price|Proxy last(string $sortedField = 'id')
 * @method static Price|Proxy random(array $attributes = [])
 * @method static Price|Proxy randomOrCreate(array $attributes = [])
 * @method static PriceRepository|ProxyRepositoryDecorator repository()
 * @method static Price[]|Proxy[] all()
 * @method static Price[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Price[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Price[]|Proxy[] findBy(array $attributes)
 * @method static Price[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Price[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 */
final class PriceFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Price::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array
    {
        return [
            'type' => self::faker()->randomElement(Price::PRICES_TYPES),
            'value' => self::faker()->randomFloat(2),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Price $price): void {})
        ;
    }
}
