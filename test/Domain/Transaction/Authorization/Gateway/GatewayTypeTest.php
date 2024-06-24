<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Authorization\Gateway;

use App\Domain\Transaction\Authorization\Gateway\GatewayType;
use PHPUnit\Framework\TestCase;

class GatewayTypeTest extends TestCase
{
    public function testGatewayTypeEnumValues(): void
    {
        $this->assertSame('picpay', GatewayType::PICPAY->value);
        $this->assertSame('itau', GatewayType::ITAU->value);
    }

    public function testGatewayTypeEnumKeys(): void
    {
        $this->assertSame('PICPAY', GatewayType::PICPAY->name);
        $this->assertSame('ITAU', GatewayType::ITAU->name);
    }

    public function testGatewayTypeEnumInstances(): void
    {
        $this->assertInstanceOf(GatewayType::class, GatewayType::PICPAY);
        $this->assertInstanceOf(GatewayType::class, GatewayType::ITAU);
    }

    public function testGatewayTypeEnumFromValue(): void
    {
        $this->assertSame(GatewayType::PICPAY, GatewayType::from('picpay'));
        $this->assertSame(GatewayType::ITAU, GatewayType::from('itau'));
    }

    public function testGatewayTypeEnumTryFromValue(): void
    {
        $this->assertSame(GatewayType::PICPAY, GatewayType::tryFrom('picpay'));
        $this->assertSame(GatewayType::ITAU, GatewayType::tryFrom('itau'));
        $this->assertNull(GatewayType::tryFrom('nonexistent'));
    }
}
