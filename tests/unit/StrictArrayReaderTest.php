<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\Config;

use Kaiseki\Config\ConfigInterface;
use Kaiseki\Config\StrictArrayReader;

class StrictArrayReaderTest extends AbstractConfigTest
{
    /**
     * @param array<array-key, mixed> $config
     * @param string                  $delimiter
     */
    protected function createConfig(array $config, string $delimiter = '.'): ConfigInterface
    {
        return new StrictArrayReader($config, '.');
    }
}
