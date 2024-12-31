<?php

namespace App\DataFixtures\Factory;

use App\Entity\Preference;
use App\Repository\PreferenceRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends ProxyRepositoryDecorator<Preference>
 *
 * @method        Preference|Proxy create(array|callable $attributes = [])
 * @method static Preference|Proxy createOne(array $attributes = [])
 * @method static Preference|Proxy find(object|array|mixed $criteria)
 * @method static Preference|Proxy findOrCreate(array $attributes)
 * @method static Preference|Proxy first(string $sortedField = 'id')
 * @method static Preference|Proxy last(string $sortedField = 'id')
 * @method static Preference|Proxy random(array $attributes = [])
 * @method static Preference|Proxy randomOrCreate(array $attributes = [])
 * @method static PreferenceRepository|ProxyRepositoryDecorator repository()
 * @method static Preference[]|Proxy[] all()
 * @method static Preference[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Preference[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Preference[]|Proxy[] findBy(array $attributes)
 * @method static Preference[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Preference[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 */
final class PreferenceFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Preference::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->text(),
            'value' => self::faker()->randomNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Preference $preference): void {})
        ;
    }
}
