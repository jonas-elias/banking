<?php

declare(strict_types=1);

namespace App\Domain\User;

/**
 * Model to represent user type merchant.
 */
class Merchant extends User
{
    /**
     * @var $attributes
     * Default values.
     */
    protected array $attributes = [
        'type' => UserType::Merchant->value,
    ];
}
