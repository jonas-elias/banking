<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Dependency;

use App\Domain\Transaction\Authorization\Authorization;
use App\Domain\Transaction\Contract\AuthorizationInterface;
use App\Domain\Transaction\Contract\NotificationInterface;
use App\Domain\Transaction\Contract\TransactionDTOInterface;
use App\Domain\Transaction\Contract\TransactionRepositoryInterface;
use App\Domain\Transaction\Contract\TransactionServiceInterface;
use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Notification\Notification;
use App\Domain\Transaction\Repository\TransactionRepository;
use App\Domain\Transaction\Service\TransactionService;

/**
 * Class to binding interfaces -> concret class in transaction module.
 */
class TransactionDependency
{
    /**
     * Method to be called static and get bindings.
     *
     * @return array
     */
    public static function getBindings(): array
    {
        return [
            TransactionDTOInterface::class => TransactionDTO::class,
            TransactionServiceInterface::class => TransactionService::class,
            AuthorizationInterface::class => Authorization::class,
            TransactionRepositoryInterface::class => TransactionRepository::class,
            NotificationInterface::class => Notification::class,
        ];
    }
}
