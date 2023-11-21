<?php

declare(strict_types=1);

namespace Kaiseki\Config;

interface ConfigInterface
{
    public function string(string $key, ?string $default = null, bool $nullable = false): string;

    public function int(string $key, ?int $default = null, bool $nullable = false): int;

    public function float(string $key, ?float $default = null, bool $nullable = false): float;

    public function bool(string $key, ?bool $default = null, bool $nullable = false): bool;

    /**
     * @param array<array-key, mixed> $default
     *
     * @return array<array-key, mixed>
     */
    public function array(string $key, ?array $default = null, bool $nullable = false): array;

    /**
     * @param string        $key
     * @param callable|null $default
     *
     * @return callable
     */
    public function callable(string $key, ?callable $default = null, bool $nullable = false): callable;

    public function get(string $key, mixed $default = null, bool $nullable = false): mixed;

    public function softGet(string $key): mixed;

    public function has(string $key): bool;
}
