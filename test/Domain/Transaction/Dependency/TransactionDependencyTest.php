<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Dependency;

use App\Domain\Transaction\Contract\TransactionDTOInterface;
use App\Domain\Transaction\Contract\TransactionRepositoryInterface;
use App\Domain\Transaction\Contract\TransactionServiceInterface;
use App\Domain\Transaction\Dependency\TransactionDependency;
use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Repository\TransactionRepository;
use App\Domain\Transaction\Service\TransactionService;
use PHPUnit\Framework\TestCase;

class TransactionDependencyTest extends TestCase
{
    public function testTransactionDependencyBindings()
    {
        $bindings = TransactionDependency::getBindings();

        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(TransactionDTOInterface::class, $bindings);
        $this->assertSame(TransactionDTO::class, $bindings[TransactionDTOInterface::class]);

        $this->assertArrayHasKey(TransactionServiceInterface::class, $bindings);
        $this->assertSame(TransactionService::class, $bindings[TransactionServiceInterface::class]);

        $this->assertArrayHasKey(TransactionRepositoryInterface::class, $bindings);
        $this->assertSame(TransactionRepository::class, $bindings[TransactionRepositoryInterface::class]);
    }
}
