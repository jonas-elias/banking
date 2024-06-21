<?php

declare(strict_types=1);

namespace HyperfTest\Domain\User\Document;

use App\Domain\User\Document\CNPJ;
use App\Domain\User\Document\CPF;
use App\Domain\User\Document\Exception\DocumentException;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function testConstructorAndGetValueCPF()
    {
        $cpf = str_repeat('1', 11);
        $document = new CPF($cpf);

        $this->assertSame($cpf, $document->getValue());
    }

    public function testConstructorAndGetValueCNPJ()
    {
        $cnpj = str_repeat('1', 14);
        $document = new CNPJ($cnpj);

        $this->assertSame($cnpj, $document->getValue());
    }

    public function testEmptyValueCPFThrowsException()
    {
        $cpfInvalid = str_repeat('1', 5);

        $this->expectException(DocumentException::class);
        $this->expectExceptionMessage('Invalid CPF. ' . $cpfInvalid);

        new CPF($cpfInvalid);
    }

    public function testEmptyValueCNPJThrowsException()
    {
        $cnpjInvalid = str_repeat('1', 5);

        $this->expectException(DocumentException::class);
        $this->expectExceptionMessage('Invalid CNPJ. ' . $cnpjInvalid);

        new CNPJ($cnpjInvalid);
    }
}
