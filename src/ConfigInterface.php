<?php

declare(strict_types=1);

namespace Kaiseki\Config;

interface ConfigInterface
{
    public function string(string $key, string $default): string;

    public function int(string $key, int $default): int;

    public function float(string $key, float $default): float;

    public function bool(string $key, bool $default): bool;

    /**
     * @param string                  $key
     * @param array<array-key, mixed> $default
     *
     * @return array<array-key, mixed>
     */
    public function array(string $key, array $default): array;

    public function get(string $key, mixed $default, bool $nullable = true): mixed;

    public function softGet(string $key): mixed;

    public function has(string $key): bool;
}
