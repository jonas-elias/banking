<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service;

use App\Database\DatabaseTransaction;
use App\Domain\Transaction\Authorization\Authorization;
use App\Domain\Transaction\Authorization\Gateway\GatewayType;
use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Exception\PayeeException;
use App\Domain\Transaction\Exception\PayerException;
use App\Domain\Transaction\Notification\Notification;
use App\Domain\Transaction\Notification\NotificationType;
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
     * @param UserRepository        $userRepository
     * @param Authorization         $authorization
     * @param TransactionRepository $transRepository
     * @param Notification          $notification
     *
     * @return void
     */
    public function __construct(
        protected DatabaseTransaction $databaseTransaction,
        protected UserRepository $userRepository,
        protected Authorization $authorization,
        protected TransactionRepository $transRepository,
        protected Notification $notification,
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

            $this->authorization->authorize(GatewayType::PICPAY, $transactionDTO);

            $this->userRepository->save($payer);
            $this->userRepository->save($payee);
            $this->transRepository->create($transactionDTO);

            $this->notification->send(NotificationType::EMAIL, $payee->email, 'Transaction received.');
        });
    }
}
