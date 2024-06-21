<?php

declare(strict_types=1);

namespace App\Domain\User;

/**
 * Model to represent user type common.
 */
class Common extends User
{
    /**
     * @var
     * Default values.
     */
    protected array $attributes = [
        'type' => UserType::Common->value,
    ];
}
