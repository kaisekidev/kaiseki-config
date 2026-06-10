<?php

declare(strict_types=1);

namespace Kaiseki\Config;

interface ConfigInterface
{
    /**
     * @param string      $key
     * @param string|null $default
     *
     * @return string
     */
    public function string(string $key, ?string $default = null): string;

    /**
     * @param string   $key
     * @param int|null $default
     *
     * @return int
     */
    public function int(string $key, ?int $default = null): int;

    /**
     * @param string     $key
     * @param float|null $default
     *
     * @return float
     */
    public function float(string $key, ?float $default = null): float;

    /**
     * @param string    $key
     * @param bool|null $default
     *
     * @return bool
     */
    public function bool(string $key, ?bool $default = null): bool;

    /**
     * @param string                       $key
     * @param array<array-key, mixed>|null $default
     *
     * @return array<array-key, mixed>
     */
    public function array(string $key, ?array $default = null): array;

    /**
     * Read the value at $key as a list of strings, dropping any non-string elements.
     *
     * @param string            $key
     * @param list<string>|null $default
     *
     * @return list<string>
     */
    public function stringList(string $key, ?array $default = null): array;

    /**
     * Read the value at $key as a list of integers, dropping any non-integer elements.
     *
     * @param string         $key
     * @param list<int>|null $default
     *
     * @return list<int>
     */
    public function intList(string $key, ?array $default = null): array;

    /**
     * Read the value at $key as a list of floats, dropping any non-float elements.
     *
     * @param string           $key
     * @param list<float>|null $default
     *
     * @return list<float>
     */
    public function floatList(string $key, ?array $default = null): array;

    /**
     * @param string $key
     * @param mixed  $default
     * @param bool   $nullable
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null, bool $nullable = false): mixed;

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function softGet(string $key): mixed;
}
