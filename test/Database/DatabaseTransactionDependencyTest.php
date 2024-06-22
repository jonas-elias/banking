<?php

declare(strict_types=1);

namespace HyperfTest\Database;

use PHPUnit\Framework\TestCase;
use App\Database\DatabaseTransaction;
use App\Database\DatabaseTransactionInterface;
use App\Database\Dependency\DatabaseTransactionDependency;

class DatabaseTransactionDependencyTest extends TestCase
{
    public function testDatabaseTransactionDependencyGetBindings()
    {
        $bindings = DatabaseTransactionDependency::getBindings();

        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(DatabaseTransactionInterface::class, $bindings);
        $this->assertEquals(DatabaseTransaction::class, $bindings[DatabaseTransactionInterface::class]);
    }
}
