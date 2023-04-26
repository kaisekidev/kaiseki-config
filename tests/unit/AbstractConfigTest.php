<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\Config;

use Kaiseki\Config\ConfigInterface;
use Kaiseki\Config\Exception\InvalidValueException;
use Kaiseki\Config\Exception\UnknownKeyException;
use PHPUnit\Framework\TestCase;

abstract class AbstractConfigTest extends TestCase
{
    /**
     * @dataProvider configCases
     * @param array<array-key, mixed> $config
     * @param mixed $expected
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
        $config = [
            'a' => [
                'a' => [
                    'a' => 'Foo',
                    'b' => 23,
                    'c' => 23.42,
                    'd' => true,
                    'e' => ['foo', 'bar'],
                ],
            ],
            'b' => [
                'a' => 'Bar',
            ],
            'c' => 'Baz',
        ];
        yield [$config, 'a/a/a', 'string', 'Foo'];
        yield [$config, 'a/a/b', 'int', 23];
        yield [$config, 'a/a/c', 'float', 23.42];
        yield [$config, 'a/a/d', 'bool', true];
        yield [$config, 'b/a', 'string', 'Bar'];
        yield [$config, 'c', 'string', 'Baz'];
        yield [$config, 'b', 'array', ['a' => 'Bar']];
        yield [$config, 'a/a/e', 'array', ['foo', 'bar']];
        yield [$config, 'a/a/a', 'has', true];
        yield [$config, 'a/a/f', 'has', false];
    }

    public function testUnknownKey(): void
    {
        $key = 'does/not/exist';

        $this->expectException(UnknownKeyException::class);
        $this->expectExceptionMessage(\Safe\sprintf('Unknown config key "%s".', $key));

        $this->createConfig([])->string($key);
    }

    /**
     * @dataProvider invalidValueCases
     * @param mixed $value
     */
    public function testInvalidValue($value, string $method): void
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
        yield [123, 'string'];
        yield ['foo', 'float'];
        yield ['foo', 'bool'];
        yield ['foo', 'array'];
    }

    /**
     * @param array<array-key, mixed> $config
     */
    abstract protected function createConfig(array $config): ConfigInterface;
}
