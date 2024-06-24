<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Contract;

use App\Domain\Transaction\DTO\TransactionDTO;

/**
 * Interface bind authorization Gateway class injection in service transaction.
 */
interface GatewayInterface
{
    /**
     * Verify authorization transaction based gateway.
     *
     * @param TransactionDTO    $transactionDTO
     *
     * @return void
     */
    public function authorize(TransactionDTO $transactionDTO): void;
}
