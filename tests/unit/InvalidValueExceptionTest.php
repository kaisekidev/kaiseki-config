<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\Config;

use Kaiseki\Config\Exception\InvalidValueException;
use PHPUnit\Framework\TestCase;

final class InvalidValueExceptionTest extends TestCase
{
    public function testExpectedCallableFromKey(): void
    {
        $exception = InvalidValueException::expectedCallableFromKey('foo', 123);

        self::assertSame('Expected callable value for "foo" but found "integer".', $exception->getMessage());
    }
}
