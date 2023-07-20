<?php

declare(strict_types=1);

namespace App\Core\Config;

class Config
{
    public function __construct(private array $config)
    {
    }

    public function get(string $name, mixed $default = null): mixed
    {
        return $this->config[$name] ?? $default;
    }

    public function getAppName(): string
    {
        return $this->get('name');
    }

    public static function marge(array ...$configs): array
    {
        $mergeConfig = [];
        foreach ($configs as $config) {
            if (\array_key_exists('containers', $config)) {
                $containers = $config['containers'];

                if (empty($mergeConfig['containers']) === false) {
                    $containers['definitions'] = [
                        ...($mergeConfig['containers']['definitions'] ?? []),
                        ...($containers['definitions'] ?? []),
                    ];
                    $containers['singletons'] = [
                        ...($mergeConfig['containers']['singletons'] ?? []),
                        ...($containers['singletons'] ?? []),
                    ];
                }

                unset($config['containers']);
                $mergeConfig['containers'] = $containers;
            }

            $mergeConfig = array_merge_recursive($mergeConfig, $config);
        }

        return $mergeConfig;
    }
}
