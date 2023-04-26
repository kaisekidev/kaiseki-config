<?php

declare(strict_types=1);

namespace Kaiseki\Config;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;

use function is_array;

final class NestedArrayConfigFactory
{
    public function __invoke(ContainerInterface $container): NestedArrayConfig
    {
        $config = $container->get('config');
        if (!is_array($config)) {
            throw new InvalidArgumentException('Config must be an array');
        }
        return new NestedArrayConfig($config);
    }
}
