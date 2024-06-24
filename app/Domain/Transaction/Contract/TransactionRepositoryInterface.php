<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Contract;

use App\Domain\Transaction\DTO\TransactionDTO;

/**
 * Transaction repository interface to create transaction of money in database.
 */
interface TransactionRepositoryInterface
{
    /**
     * Call database model of the transaction money.
     *
     * @param TransactionDTO $transactionDTO
     *
     * @return array
     */
    public function create(TransactionDTO $transactionDTO): array;
}
