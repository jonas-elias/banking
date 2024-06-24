<?php

declare(strict_types=1);

namespace App\Database;

/**
 * Database transaction interface to connect in domain.
 */
interface DatabaseTransactionInterface
{
    /**
     * Execute callable function passed like param.
     *
     * @param callable $function
     *
     * @return void
     */
    public function executeTransaction(callable $function): void;
}
