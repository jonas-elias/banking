<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Repository;

use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Repository\TransactionRepository;
use App\Domain\Transaction\Transaction;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class TransactionRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testTransactionRepositoryCreate(): void
    {
        $transactionDTO = $this->createTransactionDTOMock();

        $transactionMock = $this->createTransactionMock();
        $transactionRepository = new TransactionRepository($transactionMock);

        $transactionMock->shouldReceive('newUniqueId')
            ->andReturn('unique-id');
        $transactionMock->shouldReceive('create')
            ->with([
                'id' => 'unique-id',
                'payer_id' => 'payer_id',
                'payee_id' => 'payee_id',
                'value' => 100,
            ])
            ->andReturn((object) ['id' => 'unique-id']);

        $result = $transactionRepository->create($transactionDTO);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('transaction', $result);
        $this->assertEquals('unique-id', $result['transaction']);
    }

    protected function createTransactionDTOMock(): TransactionDTO|LegacyMockInterface|MockInterface
    {
        $transactionDTO = Mockery::mock(TransactionDTO::class);
        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        return $transactionDTO;
    }

    protected function createTransactionMock(): Transaction|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(Transaction::class);
    }
}
