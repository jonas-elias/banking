<?php

declare(strict_types=1);

namespace App\DTO\Cast;

use FriendsOfHyperf\ValidatedDTO\Casting\Castable;
use FriendsOfHyperf\ValidatedDTO\Exception\CastException;

class IntegerConversionCast implements Castable
{
    /**
     * Cast and conversion to cents.
     *
     * @param string $property
     * @param mixed $value
     *
     * @return int
     */
    public function cast(string $property, mixed $value): int
    {
        if (!is_numeric($value) && $value !== '') {
            throw new CastException($property);
        }

        return is_int($value) ? $value : (int) $value * 100;
    }
}
