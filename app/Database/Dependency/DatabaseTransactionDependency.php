<?php

declare(strict_types=1);

namespace App\Database\Dependency;

use App\Database\DatabaseTransaction;
use App\Database\DatabaseTransactionInterface;

/**
 * Class to binding database transaction interface -> request concret class.
 */
class DatabaseTransactionDependency
{
    /**
     * Method to be called static and get bindings.
     *
     * @return array
     */
    public static function getBindings(): array
    {
        return [
            DatabaseTransactionInterface::class => DatabaseTransaction::class,
        ];
    }
}
