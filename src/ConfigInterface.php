<?php

declare(strict_types=1);

namespace Kaiseki\Config;

interface ConfigInterface
{
    public function string(string $key, ?string $default = null): string;

    public function int(string $key, ?int $default = null): int;

    public function float(string $key, ?float $default = null): float;

    public function bool(string $key, ?bool $default = null): bool;

    /**
     * @param string                  $key
     * @param array<array-key, mixed> $default = null
     *
     * @return array<array-key, mixed>
     */
    public function array(string $key, ?array $default = null): array;

    public function get(string $key, mixed $default, bool $nullable = true): mixed;

    public function softGet(string $key): mixed;

    public function has(string $key): bool;
}
