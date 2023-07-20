<?php

declare(strict_types=1);

/**
 * Get the value of the environment variables.
 */
function env(string $key, mixed $default = null): mixed
{
    $value = (getenv($key) ?? $_ENV[$key] ?? $_SERVER[$key]);

    if ($value === false) {
        return $default;
    }

    return match (mb_strtolower($value)) {
        'true', '(true)' => true,
        'false', '(false)' => false,
        default => $value,
    };
}
