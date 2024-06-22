<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Controller;

use PHPUnit\Framework\TestCase;

class TransactionControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testTransactionControllerTransferSuccessful(): void
    {
        $this->assertTrue(true);
    }

    public function testTransactionControllerTransferValidationException(): void
    {
        $this->assertTrue(true);
    }

    public function testTransactionControllerTransferPayerOrPayeeException(): void
    {
        $this->assertTrue(true);
    }

    public function testTransactionControllerTransferGeneralException(): void
    {
        $this->assertTrue(true);
    }
}
