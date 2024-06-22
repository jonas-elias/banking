<?php

declare(strict_types=1);

namespace HyperfTest\Database;

use PHPUnit\Framework\TestCase;
use App\Database\DatabaseTransaction;
use Exception;
use Hyperf\DbConnection\Db;
use Mockery;

class DatabaseTransactionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testExecuteDatabaseTransactionSuccess()
    {
        $mockFunction = function () {
            return 'Execute operation.';
        };

        $mock = Mockery::mock(Db::class);
        $mock->shouldReceive('transaction')
            ->with($mockFunction)
            ->andReturnUsing($mockFunction);

        $transaction = new DatabaseTransaction($mock);

        $transaction->executeTransaction($mockFunction);
        $this->assertTrue(true);
    }

    public function testExecuteDatabaseTransactionFail()
    {
        $mockFunction = function () {
            throw new Exception();
        };

        $mock = Mockery::mock(Db::class);
        $mock->shouldReceive('transaction')
            ->with($mockFunction)
            ->andReturnUsing($mockFunction);

        $transaction = new DatabaseTransaction($mock);

        $this->expectException(Exception::class);
        $transaction->executeTransaction($mockFunction);
    }
}
