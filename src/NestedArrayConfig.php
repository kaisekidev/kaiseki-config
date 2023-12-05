<?php

declare(strict_types=1);

namespace Kaiseki\Config;

use Kaiseki\Config\Exception\InvalidValueException;
use Kaiseki\Config\Exception\UnknownKeyException;

use function array_key_exists;
use function explode;
use function is_array;
use function is_bool;
use function is_callable;
use function is_float;
use function is_int;
use function is_string;

final class NestedArrayConfig implements ConfigInterface
{
    /** @var non-empty-string */
    private string $delimiter;

    public const DEFAULT_DELIMITER = '.';

    /**
     * @param array<array-key, mixed> $config
     * @param string|null             $delimiter
     */
    public function __construct(
        private readonly array $config,
        ?string $delimiter = null
    ) {
        if ($delimiter !== null && $delimiter !== '') {
            $this->delimiter = $delimiter;
            return;
        }

        if (
            isset($config['config_delimiter'])
            && is_string($config['config_delimiter'])
            && $config['config_delimiter'] !== ''
        ) {
            $this->delimiter = $config['config_delimiter'];
            return;
        }

        $this->delimiter = self::DEFAULT_DELIMITER;
    }

    /**
     * @param string      $key
     * @param string|null $default
     *
     * @return string
     */
    public function string(string $key, ?string $default = null): string
    {
        $value = $this->get($key, $default);
        if (!is_string($value)) {
            throw InvalidValueException::expectedStringFromKey($key, $value);
        }
        return $value;
    }

    /**
     * @param string   $key
     * @param int|null $default
     *
     * @return int
     */
    public function int(string $key, ?int $default = null): int
    {
        $value = $this->get($key, $default);
        if (!is_int($value)) {
            throw InvalidValueException::expectedIntegerFromKey($key, $value);
        }
        return $value;
    }

    /**
     * @param string     $key
     * @param float|null $default
     *
     * @return float
     */
    public function float(string $key, ?float $default = null): float
    {
        $value = $this->get($key, $default);
        if (!is_float($value)) {
            throw InvalidValueException::expectedFloatFromKey($key, $value);
        }
        return $value;
    }

    /**
     * @param string    $key
     * @param bool|null $default
     *
     * @return bool
     */
    public function bool(string $key, ?bool $default = null): bool
    {
        $value = $this->get($key, $default);
        if (!is_bool($value)) {
            throw InvalidValueException::expectedBooleanFromKey($key, $value);
        }
        return $value;
    }

    /**
     * @param string                       $key
     * @param array<array-key, mixed>|null $default
     *
     * @return array<array-key, mixed>
     */
    public function array(string $key, ?array $default = null): array
    {
        $value = $this->get($key, $default);
        if (!is_array($value)) {
            throw InvalidValueException::expectedArrayFromKey($key, $value);
        }
        return $value;
    }

    /**
     * @param string        $key
     * @param callable|null $default
     *
     * @return callable
     */
    public function callable(string $key, ?callable $default = null): callable
    {
        $value = $this->get($key, $default);
        if (!is_callable($value)) {
            throw InvalidValueException::expectedCallableFromKey($key, $value);
        }
        return $value;
    }

    /**
     * @param string $key
     * @param mixed  $default
     * @param bool   $nullable
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null, bool $nullable = false): mixed
    {
        $value = $this->softGet($key);
        if ($value === null) {
            if ($default !== null || $nullable) {
                return $default;
            }
            throw UnknownKeyException::fromKey($key);
        }
        return $value;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function softGet(string $key): mixed
    {
        $paths = explode($this->delimiter, $key);
        $current = $this->config;
        foreach ($paths as $index) {
            if (!is_array($current) || !array_key_exists($index, $current)) {
                return null;
            }
            $current = $current[$index];
        }
        return $current;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->softGet($key) !== null;
    }
}
