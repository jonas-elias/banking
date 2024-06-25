<?php

declare(strict_types=1);

namespace HyperfTest\DTO;

use App\DTO\Cast\IntegerConversionCast;
use FriendsOfHyperf\ValidatedDTO\Exception\CastException;
use PHPUnit\Framework\TestCase;

class IntegerConversionCastTest extends TestCase
{
    private IntegerConversionCast $caster;

    protected function setUp(): void
    {
        $this->caster = new IntegerConversionCast();
    }

    public function testCastWithInteger()
    {
        $value = 123;
        $result = $this->caster->cast('testProperty', $value);
        $this->assertSame(123, $result);
    }

    public function testCastWithFloat()
    {
        $value = 12.34;
        $result = $this->caster->cast('testProperty', $value);
        $this->assertSame(1234, $result);
    }

    public function testCastWithStringNumeric()
    {
        $value = '12.34';
        $result = $this->caster->cast('testProperty', $value);
        $this->assertSame(1234, $result);
    }

    public function testCastWithStringEmpty()
    {
        $value = '0';
        $result = $this->caster->cast('testProperty', $value);
        $this->assertSame(0, $result);
    }

    public function testCastWithNonNumericString()
    {
        $this->expectException(CastException::class);
        $this->caster->cast('testProperty', 'non-numeric');
    }

    public function testCastWithNull()
    {
        $this->expectException(CastException::class);
        $this->caster->cast('testProperty', null);
    }

    public function testCastWithArray()
    {
        $this->expectException(CastException::class);
        $this->caster->cast('testProperty', []);
    }

    public function testCastWithObject()
    {
        $this->expectException(CastException::class);
        $this->caster->cast('testProperty', new \stdClass());
    }
}
