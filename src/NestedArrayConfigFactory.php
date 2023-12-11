<?php

declare(strict_types=1);

namespace Kaiseki\Config;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;

use function is_array;
use function is_string;

final class NestedArrayConfigFactory
{
    public const DEFAULT_DELIMITER = '/';

    public function __invoke(ContainerInterface $container): NestedArrayConfig
    {
        $config = $container->get('config');
        if (!is_array($config)) {
            throw new InvalidArgumentException('Config must be an array');
        }
        return new NestedArrayConfig($config, $this->getDelimiter($config));
    }

    /**
     * @param array<array-key, mixed> $config
     *
     * @return non-empty-string
     */
    private function getDelimiter(array $config): string
    {
        if (
            isset($config['config_delimiter'])
            && is_string($config['config_delimiter'])
            && $config['config_delimiter'] !== ''
        ) {
            return $config['config_delimiter'];
        }

        return self::DEFAULT_DELIMITER;
    }
}
