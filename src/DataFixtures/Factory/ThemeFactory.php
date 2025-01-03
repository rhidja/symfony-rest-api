<?php

namespace App\DataFixtures\Factory;

use App\Entity\Theme;
use App\Repository\ThemeRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends ProxyRepositoryDecorator<Theme>
 *
 * @method        Theme|Proxy create(array|callable $attributes = [])
 * @method static Theme|Proxy createOne(array $attributes = [])
 * @method static Theme|Proxy find(object|array|mixed $criteria)
 * @method static Theme|Proxy findOrCreate(array $attributes)
 * @method static Theme|Proxy first(string $sortedField = 'id')
 * @method static Theme|Proxy last(string $sortedField = 'id')
 * @method static Theme|Proxy random(array $attributes = [])
 * @method static Theme|Proxy randomOrCreate(array $attributes = [])
 * @method static ThemeRepository|ProxyRepositoryDecorator repository()
 * @method static Theme[]|Proxy[] all()
 * @method static Theme[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Theme[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Theme[]|Proxy[] findBy(array $attributes)
 * @method static Theme[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Theme[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 */
final class ThemeFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Theme::class;
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
            'value' => random_int(0, 10),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Theme $theme): void {})
        ;
    }
}
