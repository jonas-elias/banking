<?php

declare(strict_types=1);

namespace HyperfTest\Database;

use App\Database\DatabaseTransaction;
use App\Database\DatabaseTransactionInterface;
use App\Database\Dependency\DatabaseTransactionDependency;
use PHPUnit\Framework\TestCase;

class DatabaseTransactionDependencyTest extends TestCase
{
    public function testDatabaseTransactionDependencyGetBindings()
    {
        $bindings = DatabaseTransactionDependency::getBindings();

        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(DatabaseTransactionInterface::class, $bindings);
        $this->assertSame(DatabaseTransaction::class, $bindings[DatabaseTransactionInterface::class]);
    }
}
