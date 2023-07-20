<?php

declare(strict_types=1);

namespace App\Core\DTO;

trait ArrayToObject
{
    public static function createFromArray(array $data): static
    {
        $object = new static();

        foreach ($data as $key => $value) {
            if (property_exists($object, $key)) {
                $object->{$key} = $value;
            }
        }

        return $object;
    }
}
