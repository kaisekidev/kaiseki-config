<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\Config;

use Kaiseki\Config\ConfigInterface;
use Kaiseki\Config\ConfigProvider;
use Kaiseki\Config\StrictArrayReader;
use Kaiseki\Config\StrictArrayReaderFactory;
use PHPUnit\Framework\TestCase;

final class ConfigProviderTest extends TestCase
{
    public function testConfig(): void
    {
        self::assertSame(
            [
                'dependencies' => [
                    'aliases' => [
                        ConfigInterface::class => StrictArrayReader::class,
                    ],
                    'factories' => [
                        StrictArrayReader::class => StrictArrayReaderFactory::class,
                    ],
                ],
            ],
            (new ConfigProvider())()
        );
    }
}
