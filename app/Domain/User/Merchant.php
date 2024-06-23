<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\Exception\UserDebitException;

/**
 * Model to represent user type merchant.
 */
class Merchant extends User
{
    /**
     * @var
     * Default values.
     */
    protected array $attributes = [
        'type' => UserType::Merchant->value,
    ];

    /**
     * Method to increase value in balance.
     *
     * @param int $value
     *
     * @return User
     */
    public function debit(int $value): User
    {
        throw new UserDebitException();
    }
}
