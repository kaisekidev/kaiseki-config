<?php

declare(strict_types=1);

namespace Kaiseki\Config;

use Psr\Container\ContainerInterface;

final class Config
{
    public static function get(ContainerInterface $container): ConfigInterface
    {
        return $container->get(ConfigInterface::class);
    }

    /**
     * @template T of object
     * @phpstan-param array<array-key, class-string<T>> $map
     * @phpstan-return array<array-key, T>
     */
    public static function initClassMap(ContainerInterface $container, array $map): array
    {
        $init = [];
        foreach ($map as $key => $className) {
            /** @phpstan-var T $object */
            $object = $container->get($className);
            $init[$key] = $object;
        }
        return $init;
    }

    /**
     * @param array<array-key, mixed> $config
     */
    public static function build(array $config): ConfigInterface
    {
        return new NestedArrayConfig($config);
    }
}
