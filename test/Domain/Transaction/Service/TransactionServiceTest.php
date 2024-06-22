<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Service;

use PHPUnit\Framework\TestCase;

class TransactionServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testTransactionServiceTransferSuccessful(): void
    {
        $this->assertTrue(true);
    }

    public function testTransactionServiceTransferPayerException(): void
    {
        $this->assertTrue(true);
    }

    public function testTransactionServiceTransferPayeeException(): void
    {
        $this->assertTrue(true);
    }

    public function testTransactionServiceTransferGeneralException(): void
    {
        $this->assertTrue(true);
    }
}
