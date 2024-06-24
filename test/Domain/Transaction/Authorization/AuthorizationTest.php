<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Authorization;

use App\Domain\Transaction\Authorization\Authorization;
use App\Domain\Transaction\Authorization\Gateway\GatewayType;
use App\Domain\Transaction\Authorization\Gateway\PicPay\PicPayGateway;
use App\Domain\Transaction\DTO\TransactionDTO;
use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\TestCase;

class AuthorizationTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testAuthorizationWithValidGatewayType(): void
    {
        $picPayGatewayMock = Mockery::mock(PicPayGateway::class);
        $transactionDTO = Mockery::mock(TransactionDTO::class);

        $picPayGatewayMock->shouldReceive('authorize')
            ->once()
            ->with($transactionDTO);

        $authorization = new Authorization($picPayGatewayMock);

        $authorization->authorize(GatewayType::PICPAY, $transactionDTO);
        $this->assertTrue(true);
    }

    public function testAuthorizationWithInvalidGatewayType(): void
    {
        $picPayGatewayMock = Mockery::mock(PicPayGateway::class);
        $transactionDTO = Mockery::mock(TransactionDTO::class);

        $authorization = new Authorization($picPayGatewayMock);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported gateway authorization type.');

        $authorization->authorize(GatewayType::ITAU, $transactionDTO);
    }
}
