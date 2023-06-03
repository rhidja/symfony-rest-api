<?php

namespace App\DataFixtures\Factory;

use App\Entity\Preference;
use App\Repository\PreferenceRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Preference>
 *
 * @method        Preference|Proxy create(array|callable $attributes = [])
 * @method static Preference|Proxy createOne(array $attributes = [])
 * @method static Preference|Proxy find(object|array|mixed $criteria)
 * @method static Preference|Proxy findOrCreate(array $attributes)
 * @method static Preference|Proxy first(string $sortedField = 'id')
 * @method static Preference|Proxy last(string $sortedField = 'id')
 * @method static Preference|Proxy random(array $attributes = [])
 * @method static Preference|Proxy randomOrCreate(array $attributes = [])
 * @method static PreferenceRepository|RepositoryProxy repository()
 * @method static Preference[]|Proxy[] all()
 * @method static Preference[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Preference[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Preference[]|Proxy[] findBy(array $attributes)
 * @method static Preference[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Preference[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 */
final class PreferenceFactory extends ModelFactory
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
            'name' => self::faker()->text(),
            'value' => self::faker()->randomNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Preference $preference): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Preference::class;
    }
}
