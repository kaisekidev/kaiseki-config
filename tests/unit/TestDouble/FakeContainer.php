<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\Config\TestDouble;

use Psr\Container\ContainerInterface;

use function array_key_exists;

final class FakeContainer implements ContainerInterface
{
    /** @var array<array-key, mixed> */
    private array $config;

    /**
     * @param array<array-key, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function get(string $id)
    {
        return $this->config[$id] ?? null;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->config);
    }
}
