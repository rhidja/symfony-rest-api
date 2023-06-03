<?php

namespace App\DataFixtures\Factory;

use App\Entity\Price;
use App\Repository\PriceRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Price>
 *
 * @method        Price|Proxy create(array|callable $attributes = [])
 * @method static Price|Proxy createOne(array $attributes = [])
 * @method static Price|Proxy find(object|array|mixed $criteria)
 * @method static Price|Proxy findOrCreate(array $attributes)
 * @method static Price|Proxy first(string $sortedField = 'id')
 * @method static Price|Proxy last(string $sortedField = 'id')
 * @method static Price|Proxy random(array $attributes = [])
 * @method static Price|Proxy randomOrCreate(array $attributes = [])
 * @method static PriceRepository|RepositoryProxy repository()
 * @method static Price[]|Proxy[] all()
 * @method static Price[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Price[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Price[]|Proxy[] findBy(array $attributes)
 * @method static Price[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Price[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 */
final class PriceFactory extends ModelFactory
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
            'type' => self::faker()->randomElement(['enfant', 'adulte', 'senior']),
            'value' => self::faker()->randomFloat(2),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Price $price): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Price::class;
    }
}
