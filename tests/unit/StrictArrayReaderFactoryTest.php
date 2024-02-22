<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\Config;

use InvalidArgumentException;
use Kaiseki\Config\StrictArrayReaderFactory;
use Kaiseki\Test\Unit\Config\TestDouble\FakeContainer;
use PHPUnit\Framework\TestCase;

final class StrictArrayReaderFactoryTest extends TestCase
{
    private StrictArrayReaderFactory $factory;

    public function setUp(): void
    {
        parent::setUp();
        $this->factory = new StrictArrayReaderFactory();
    }

    public function testCreateInstance(): void
    {
        $config = ['parent' => ['child' => 'foo']];
        $container = new FakeContainer(['config' => $config]);

        $instance = ($this->factory)($container);

        self::assertSame('foo', $instance->string('parent.child'));
    }

    public function testThrowsExceptionWhenConfigIsNotArray(): void
    {
        $container = new FakeContainer(['config' => 'invalid']);

        $this->expectException(InvalidArgumentException::class);

        ($this->factory)($container);
    }
}
