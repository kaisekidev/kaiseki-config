<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\Config;

use Kaiseki\Config\ConfigInterface;
use Kaiseki\Config\NestedArrayConfig;

class NestedArrayConfigTest extends AbstractConfigTest
{
    /**
     * @param array<array-key, mixed> $config
     */
    protected function createConfig(array $config, string $delimiter = '.'): ConfigInterface
    {
        return new NestedArrayConfig($config, '.');
    }
}
