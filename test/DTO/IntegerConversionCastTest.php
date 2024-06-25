<?php

declare(strict_types=1);

namespace HyperfTest\DTO;

use App\DTO\Cast\IntegerConversionCast;
use FriendsOfHyperf\ValidatedDTO\Exception\CastException;
use PHPUnit\Framework\TestCase;
use stdClass;

class IntegerConversionCastTest extends TestCase
{
    private IntegerConversionCast $caster;

    protected function setUp(): void
    {
        $this->caster = new IntegerConversionCast();
    }

    public function testIntegerConversionCastWithInteger()
    {
        $value = 123;
        $result = $this->caster->cast('testProperty', $value);
        $this->assertSame(123, $result);
    }

    public function testIntegerConversionCastWithFloat()
    {
        $value = 12.34;
        $result = $this->caster->cast('testProperty', $value);
        $this->assertSame(1234, $result);
    }

    public function testIntegerConversionCastWithStringNumeric()
    {
        $value = '12.34';
        $result = $this->caster->cast('testProperty', $value);
        $this->assertSame(1234, $result);
    }

    public function testIntegerConversionCastWithStringEmpty()
    {
        $value = '0';
        $result = $this->caster->cast('testProperty', $value);
        $this->assertSame(0, $result);
    }

    public function testIntegerConversionCastWithNonNumericString()
    {
        $this->expectException(CastException::class);
        $this->caster->cast('testProperty', 'non-numeric');
    }

    public function testIntegerConversionCastWithNull()
    {
        $this->expectException(CastException::class);
        $this->caster->cast('testProperty', null);
    }

    public function testIntegerConversionCastWithArray()
    {
        $this->expectException(CastException::class);
        $this->caster->cast('testProperty', []);
    }

    public function testIntegerConversionCastWithObject()
    {
        $this->expectException(CastException::class);
        $this->caster->cast('testProperty', new stdClass());
    }
}
