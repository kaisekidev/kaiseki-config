<?php

declare(strict_types=1);

namespace Kaiseki\Config;

final class ConfigProvider
{
    /**
     * @return array<array-key, mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'aliases' => [
                    ConfigInterface::class => StrictArrayReader::class,
                ],
                'factories' => [
                    StrictArrayReader::class => StrictArrayReaderFactory::class,
                ],
            ],
        ];
    }
}
