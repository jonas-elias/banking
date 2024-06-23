<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction;

use App\Domain\Transaction\Transaction;
use Mockery;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
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

    public function testTransactionTableName(): void
    {
        $transaction = $this->createTransactionMock();
        $transaction->shouldReceive('getTable')->andReturn('transaction');

        $this->assertEquals('transaction', $transaction->getTable());
    }

    public function testTransactionFillableAttributes(): void
    {
        $transaction = $this->createTransactionMock();
        $transaction->shouldReceive('getFillable')->andReturn(['id', 'payer_id', 'payee_id', 'value']);

        $this->assertEquals(['id', 'payer_id', 'payee_id', 'value'], $transaction->getFillable());
    }

    public function testTransactionCasts(): void
    {
        $transaction = $this->createTransactionMock();
        $transaction->shouldReceive('getCasts')->andReturn(['created_at' => 'datetime', 'updated_at' => 'datetime']);

        $this->assertEquals(['created_at' => 'datetime', 'updated_at' => 'datetime'], $transaction->getCasts());
    }

    protected function createTransactionMock()
    {
        return Mockery::mock(Transaction::class)->makePartial();
    }
}
