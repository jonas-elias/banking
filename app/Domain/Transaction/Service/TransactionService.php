<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service;

use App\Database\DatabaseTransactionInterface;
use App\Domain\Transaction\Authorization\Gateway\GatewayType;
use App\Domain\Transaction\Contract\AuthorizationInterface;
use App\Domain\Transaction\Contract\NotificationInterface;
use App\Domain\Transaction\Contract\TransactionRepositoryInterface;
use App\Domain\Transaction\Contract\TransactionServiceInterface;
use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Exception\PayeeException;
use App\Domain\Transaction\Exception\PayerException;
use App\Domain\Transaction\Notification\NotificationType;
use App\Domain\User\Contract\UserRepositoryInterface;

/**
 * Transaction service class to call repository transaction class and manage business rule.
 */
class TransactionService implements TransactionServiceInterface
{
    /**
     * Method constructor.
     *
     * @param DatabaseTransactionInterface   $databaseTransaction
     * @param UserRepositoryInterface        $userRepository
     * @param AuthorizationInterface         $authorization
     * @param TransactionRepositoryInterface $transRepository
     * @param NotificationInterface          $notification
     *
     * @return void
     */
    public function __construct(
        protected DatabaseTransactionInterface $databaseTransaction,
        protected UserRepositoryInterface $userRepository,
        protected AuthorizationInterface $authorization,
        protected TransactionRepositoryInterface $transRepository,
        protected NotificationInterface $notification,
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
