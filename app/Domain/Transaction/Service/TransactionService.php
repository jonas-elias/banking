<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service;

use App\Database\DatabaseTransaction;
use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Exception\PayeeException;
use App\Domain\Transaction\Exception\PayerException;
use App\Domain\Transaction\Repository\TransactionRepository;
use App\Domain\User\Repository\UserRepository;

/**
 * Transaction service class to call repository transaction class and manage business rule.
 */
class TransactionService
{
    /**
     * Method constructor.
     *
     * @param DatabaseTransaction   $databaseTransaction
     * @param TransactionRepository $transRepository
     * @param UserRepository        $userRepository
     *
     * @return void
     */
    public function __construct(
        protected DatabaseTransaction $databaseTransaction,
        protected TransactionRepository $transRepository,
        protected UserRepository $userRepository,
    ) {
    }

    /**
     * Method to manage business rule of transference money.
     *
     * @param TransactionDTO $transactionDTO
     *
     * @return void
     */
    public function transfer(TransactionDTO $transactionDTO): void
    {
        $this->databaseTransaction->executeTransaction(function () use ($transactionDTO) {
            $data = $this->userRepository->findUsersByIds([$transactionDTO->payer, $transactionDTO->payee]);

            $payer = $data[$transactionDTO->payer] ?? throw new PayerException();
            $payee = $data[$transactionDTO->payee] ?? throw new PayeeException();

            $payer->debit($transactionDTO->value);
            $payee->credit($transactionDTO->value);

            $this->userRepository->save($payer);
            $this->userRepository->save($payee);
            $this->transRepository->create($transactionDTO);
        });
    }
}
