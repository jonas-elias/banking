<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\DTO;

use App\Domain\Transaction\DTO\TransactionDTO;
use App\DTO\Cast\IntegerConversionCast;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class TransactionDTOTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testTransactionDTOValidationRules(): void
    {
        $dto = new TransactionDTO([
            'payer' => 'test_payer',
            'payee' => 'test_payee',
            'value' => 100,
        ]);

        $rulesMethod = $this->getProtectedMethod($dto, 'rules');
        $rules = $rulesMethod->invoke($dto);

        $this->assertSame([
            'payer' => ['required', 'string'],
            'payee' => ['required', 'string'],
            'value' => ['required', 'integer', 'min:1'],
        ], $rules);
    }

    public function testTransactionDTOValidationMessages(): void
    {
        $dto = new TransactionDTO([
            'payer' => 'test_payer',
            'payee' => 'test_payee',
            'value' => 100,
        ]);

        $messages = $dto->messages();

        $this->assertSame([
            'payer.required' => 'The payer field is required.',
            'payer.string' => 'The payer field must be a string.',
            'payee.required' => 'The payee field is required.',
            'payee.string' => 'The payee field must be a string.',
            'value.required' => 'The value field is required.',
            'value.integer' => 'The value field must be an integer.',
            'value.min' => 'The value field must be at least 1 cent.',
        ], $messages);
    }

    public function testTransactionDTOCastTypes(): void
    {
        $dto = new TransactionDTO([
            'payer' => 'test_payer',
            'payee' => 'test_payee',
            'value' => 100,
        ]);

        $castsMethod = $this->getProtectedMethod($dto, 'casts');
        $casts = $castsMethod->invoke($dto);

        $this->assertInstanceOf(IntegerConversionCast::class, $casts['value']);
    }

    public function testTransactionDTODefaults(): void
    {
        $dto = new TransactionDTO([
            'payer' => 'test_payer',
            'payee' => 'test_payee',
            'value' => 100,
        ]);

        $defaults = $dto->defaults();

        $this->assertSame([], $defaults);
    }

    private function getProtectedMethod(TransactionDTO $dto, string $methodName)
    {
        $reflector = new ReflectionClass($dto);
        $method = $reflector->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }
}
