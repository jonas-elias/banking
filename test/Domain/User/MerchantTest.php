<?php

declare(strict_types=1);

namespace HyperfTest\Domain\User;

use App\Domain\User\Exception\UserDebitException;
use App\Domain\User\Merchant;
use App\Domain\User\UserType;
use PHPUnit\Framework\TestCase;

class MerchantTest extends TestCase
{
    public function testMerchantHasCorrectType()
    {
        $merchant = new Merchant();

        $this->assertSame(UserType::Merchant->value, $merchant->type);
    }

    public function testMerchantDebitThrowsUserDebitException()
    {
        $this->expectException(UserDebitException::class);

        $merchant = new Merchant();
        $merchant->debit(1000);
    }
}
