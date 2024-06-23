<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Repository;

use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Transaction;

/**
 * Transaction repository class to create transaction of money in database.
 */
class TransactionRepository
{
    /**
     * Method constructor.
     *
     * @param Transaction $transaction
     *
     * @return void
     */
    public function __construct(
        protected Transaction $transaction,
    ) {
    }

    /**
     * Call database model of the transaction money.
     *
     * @param TransactionDTO $transactionDTO
     *
     * @return array
     */
    public function create(TransactionDTO $transactionDTO): array
    {
        $ulid = $this->transaction->newUniqueId();

        $data = $this->transaction::create([
            'id'       => $ulid,
            'payer_id'     => $transactionDTO->payer,
            'payee_id'    => $transactionDTO->payee,
            'value'    => $transactionDTO->value,
        ]);

        return [
            'transaction' => $data->id,
        ];
    }
}
