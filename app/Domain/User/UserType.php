<?php

namespace App\Domain\User;

/**
 * Enum to define types user.
 */
enum UserType: string
{
    /**
     * @case Merchant
     */
    case Merchant = 'merchant';

    /**
     * @case Common
     */
    case Common = 'common';
}
