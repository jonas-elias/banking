<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Contract;

use App\Domain\Transaction\Authorization\Gateway\GatewayType;
use App\Domain\Transaction\DTO\TransactionDTO;

/**
 * Interface bind authorization Gateway class injection in service transaction.
 */
interface AuthorizationInterface
{
    /**
     * Verify authorization payment with type.
     *
     * @param GatewayType       $type
     * @param TransactionDTO    $transactionDTO
     *
     * @return void
     */
    public function authorize(GatewayType $type, TransactionDTO $transactionDTO): void;
}
