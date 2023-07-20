<?php

declare(strict_types=1);

namespace App\Core\Helper;

class ArrayHelper
{
    public static function isEmpty(mixed $value): bool
    {
        return $value === '' || $value === null || $value === [];
    }
}
