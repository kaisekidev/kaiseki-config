<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\Config;

use Kaiseki\Config\ConfigInterface;
use Kaiseki\Config\ConfigProvider;
use Kaiseki\Config\NestedArrayConfig;
use Kaiseki\Config\NestedArrayConfigFactory;
use PHPUnit\Framework\TestCase;

final class ConfigProviderTest extends TestCase
{
    public function testConfig(): void
    {
        self::assertSame(
            [
                'dependencies' => [
                    'aliases' => [
                        ConfigInterface::class => NestedArrayConfig::class,
                    ],
                    'factories' => [
                        NestedArrayConfig::class => NestedArrayConfigFactory::class,
                    ],
                ],
            ],
            (new ConfigProvider())()
        );
    }
}
