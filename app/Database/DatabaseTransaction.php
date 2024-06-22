<?php

declare(strict_types=1);

namespace App\Database;

use Hyperf\DbConnection\Db;

/**
 * Database transaction class to connect in domain.
 */
class DatabaseTransaction
{
    /**
     * Method constructor.
     *
     * @param Db $db
     *
     * @return void
     */
    public function __construct(
        protected Db $db
    ) {
    }

    /**
     * Execute callable function passed like param.
     *
     * @param callable $function
     *
     * @return void
     */
    public function executeTransaction(callable $function): void
    {
        $this->db::transaction($function);
    }
}
