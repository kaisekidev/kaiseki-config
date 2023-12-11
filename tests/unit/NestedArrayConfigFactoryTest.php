<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\Config;

use InvalidArgumentException;
use Kaiseki\Config\NestedArrayConfigFactory;
use Kaiseki\Test\Unit\Config\TestDouble\FakeContainer;
use PHPUnit\Framework\TestCase;

final class NestedArrayConfigFactoryTest extends TestCase
{
    private NestedArrayConfigFactory $factory;

    public function setUp(): void
    {
        parent::setUp();
        $this->factory = new NestedArrayConfigFactory();
    }

    public function testCreateInstance(): void
    {
        $config = ['parent' => ['child' => 'foo']];
        $container = new FakeContainer(['config' => $config]);

        $instance = ($this->factory)($container);

        self::assertSame('foo', $instance->string('parent/child'));
    }

    public function testThrowsExceptionWhenConfigIsNotArray(): void
    {
        $container = new FakeContainer(['config' => 'invalid']);

        $this->expectException(InvalidArgumentException::class);

        ($this->factory)($container);
    }
}
