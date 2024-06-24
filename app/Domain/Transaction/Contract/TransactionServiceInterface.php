<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Contract;

use App\Domain\Transaction\DTO\TransactionDTO;

/**
 * Transaction service interface.
 */
interface TransactionServiceInterface
{
    /**
     * Method to manage business rule of transference money.
     *
     * @param TransactionDTO $transactionDTO
     *
     * @return void
     */
    public function transfer(TransactionDTO $transactionDTO): void;
}
