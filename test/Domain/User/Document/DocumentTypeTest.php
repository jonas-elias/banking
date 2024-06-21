<?php

declare(strict_types=1);

namespace HyperfTest\Domain\User\Document;

use App\Domain\User\Document\Enum\DocumentType;
use PHPUnit\Framework\TestCase;

class DocumentTypeTest extends TestCase
{
    public function testCpfEnumValue()
    {
        $this->assertSame(11, DocumentType::CPF->value);
        $this->assertSame('CPF', DocumentType::CPF->name);
    }

    public function testCnpjEnumValue()
    {
        $this->assertSame(14, DocumentType::CNPJ->value);
        $this->assertSame('CNPJ', DocumentType::CNPJ->name);
    }

    public function testEnumCases()
    {
        $expectedCases = [
            'CPF' => 11,
            'CNPJ' => 14,
        ];

        foreach (DocumentType::cases() as $case) {
            $this->assertSame($expectedCases[$case->name], $case->value);
        }
    }
}
