<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\Config;

use Kaiseki\Config\Exception\InvalidValueException;
use Kaiseki\Config\Exception\UnknownKeyException;
use Kaiseki\Config\NestedArrayConfig;
use PHPUnit\Framework\TestCase;

abstract class AbstractConfigTest extends TestCase
{
    /**
     * @dataProvider configCases
     *
     * @param array<array-key, mixed> $config
     * @param string                  $path
     * @param string                  $method
     * @param mixed                   $expected
     */
    public function testGet(array $config, string $path, string $method, $expected): void
    {
        /* @phpstan-ignore-next-line */
        self::assertSame($expected, $this->createConfig($config)->$method($path));
    }

    /**
     * @return iterable<array{0: array<array-key, mixed>, 1: string, 2: string, 3: mixed}>
     */
    public function configCases(): iterable
    {
        $callable = fn() => 'foo';
        $config = [
            'a' => [
                'a' => [
                    'a' => 'Foo',
                    'b' => 23,
                    'c' => 23.42,
                    'd' => true,
                    'e' => ['foo', 'bar'],
                    'f' => $callable,
                ],
            ],
            'b' => [
                'a' => 'Bar',
            ],
            'c' => 'Baz',
        ];
        yield [$config, 'a.a.a', 'string', 'Foo'];
        yield [$config, 'a.a.b', 'int', 23];
        yield [$config, 'a.a.c', 'float', 23.42];
        yield [$config, 'a.a.d', 'bool', true];
        yield [$config, 'a.a.e', 'array', ['foo', 'bar']];
        yield [$config, 'a.a.f', 'callable', $callable];
        yield [$config, 'b.a', 'string', 'Bar'];
        yield [$config, 'b', 'array', ['a' => 'Bar']];
        yield [$config, 'c', 'string', 'Baz'];
        yield [$config, 'a.a.a', 'has', true];
        yield [$config, 'a.a.foobar', 'has', false];
    }

    /**
     * @dataProvider unkonwnKeyCases
     *
     * @param string $method
     */
    public function testUnknownKey(string $method): void
    {
        $this->expectException(UnknownKeyException::class);

        /* @phpstan-ignore-next-line */
        $this->createConfig([])->$method('foo', null);
    }

    /**
     * @return iterable<array{0: string}>
     */
    public function unkonwnKeyCases(): iterable
    {
        yield ['get'];
        yield ['int'];
        yield ['string'];
        yield ['float'];
        yield ['bool'];
        yield ['array'];
        yield ['callable'];
    }

    /**
     * @dataProvider invalidValueCases
     *
     * @param mixed  $value
     * @param string $method
     */
    public function testInvalidValue(mixed $value, string $method): void
    {
        $this->expectException(InvalidValueException::class);

        /* @phpstan-ignore-next-line */
        $this->createConfig(['key' => $value])->$method('key');
    }

    /**
     * @return iterable<array{0: mixed, 1: string}>
     */
    public function invalidValueCases(): iterable
    {
        yield ['foo', 'int'];
        yield [12345, 'string'];
        yield ['foo', 'float'];
        yield ['foo', 'bool'];
        yield ['foo', 'array'];
        yield ['foo', 'callable'];
    }

    /**
     * @dataProvider defaultValueCases
     *
     * @param mixed  $defaultValue
     * @param string $method
     */
    public function testDefaultValue(mixed $defaultValue, string $method): void
    {
        /* @phpstan-ignore-next-line */
        self::assertSame($defaultValue, $this->createConfig([])->$method('foo', $defaultValue));
    }

    /**
     * @return iterable<array{0: mixed, 1: string}>
     */
    public function defaultValueCases(): iterable
    {
        yield ['foo', 'string'];
        yield [42, 'int'];
        yield [23.45, 'float'];
        yield [false, 'bool'];
        yield [['foo' => 'bar'], 'array'];
        yield [fn() => 'foo', 'callable'];
    }

    public function testNullableGet(): void
    {
        $config = $this->createConfig(['key' => null]);

        self::assertNull($config->get('key', null, true));
    }

    /**
     * @param array<array-key, mixed> $config
     */
    abstract protected function createConfig(array $config): NestedArrayConfig;
}
