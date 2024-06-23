<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use Exception;

/**
 * Exception class to throw when balance < value.
 */
class BalanceException extends Exception
{
}
