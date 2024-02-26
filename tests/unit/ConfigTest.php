<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\Config;

use Kaiseki\Config\Config;
use Kaiseki\Config\ConfigInterface;
use Kaiseki\Config\NestedArrayConfig;
use Kaiseki\Test\Unit\Config\TestDouble\FakeContainer;
use PHPUnit\Framework\TestCase;
use stdClass;

final class ConfigTest extends TestCase
{
    public function testFromContainer(): void
    {
        $container = new FakeContainer(['config' => ['foo' => 'bar']]);

        $config = Config::fromContainer($container);

        self::assertSame('bar', $config->string('foo'));
    }

    public function testInitClassMap(): void
    {
        $expected = new stdClass();
        $container = new FakeContainer([stdClass::class => $expected]);

        $classMap = Config::initClassMap($container, ['foo' => stdClass::class]);

        self::assertSame(['foo' => $expected], $classMap);
    }

    public function testInitClassMapReturnsCompleteArray(): void
    {
        $expected = new stdClass();
        $container = new FakeContainer([stdClass::class => $expected]);

        $classMap = Config::initClassMap($container, ['foo' => stdClass::class, 'bar' => stdClass::class]);

        self::assertSame(['foo' => $expected, 'bar' => $expected], $classMap);
    }

    public function testBuild(): void
    {
        $container = new FakeContainer(['config' => ['foo' => 'bar']]);
        $config = Config::fromContainer($container);

        self::assertSame('bar', $config->string('foo'));
    }
}
