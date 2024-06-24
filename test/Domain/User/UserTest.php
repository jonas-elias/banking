<?php

declare(strict_types=1);

namespace HyperfTest\Domain\User;

use App\Domain\User\Exception\BalanceException;
use App\Domain\User\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCreditIncreasesBalance()
    {
        $user = new User();
        $user->balance = 1000;

        $user->credit(500);

        $this->assertSame(1500, $user->balance);
    }

    public function testUserDebitDecreasesBalance()
    {
        $user = new User();
        $user->balance = 1000;

        $user->debit(500);

        $this->assertSame(500, $user->balance);
    }

    public function testUserDebitThrowsBalanceExceptionWhenInsufficientFunds()
    {
        $this->expectException(BalanceException::class);

        $user = new User();
        $user->balance = 500;

        $user->debit(1000);
    }

    public function testUserAttributesAreFillable()
    {
        $user = new User();
        $attributes = [
            'id' => 'some-id',
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'secret',
            'document' => '12345678900',
            'balance' => 1000,
        ];

        $user->fill($attributes);

        $this->assertSame($attributes['id'], $user->id);
        $this->assertSame($attributes['name'], $user->name);
        $this->assertSame($attributes['email'], $user->email);
        $this->assertSame($attributes['password'], $user->password);
        $this->assertSame($attributes['document'], $user->document);
        $this->assertSame($attributes['balance'], $user->balance);
    }

    public function testUserCastsAttributes()
    {
        $user = new User();
        $user->created_at = '2024-06-24 03:00:00';
        $user->updated_at = '2024-06-24 03:00:00';

        $this->assertInstanceOf(DateTime::class, $user->created_at);
        $this->assertInstanceOf(DateTime::class, $user->updated_at);
    }
}
