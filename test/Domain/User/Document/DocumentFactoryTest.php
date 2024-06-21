<?php

declare(strict_types=1);

namespace HyperfTest\Domain\User\Document;

use App\Domain\User\Document\CNPJ;
use App\Domain\User\Document\CPF;
use App\Domain\User\Document\Exception\DocumentException;
use App\Domain\User\Document\Factory\DocumentFactory;
use PHPUnit\Framework\TestCase;

class DocumentFactoryTest extends TestCase
{
    public function testCreateCPFDocument()
    {
        $factory = new DocumentFactory();
        $document = $factory->createDocument('cpf', '12345678901');

        $this->assertInstanceOf(CPF::class, $document);
        $this->assertSame('12345678901', $document->getValue());
    }

    public function testCreateCNPJDocument()
    {
        $factory = new DocumentFactory();
        $document = $factory->createDocument('cnpj', '12345678901234');

        $this->assertInstanceOf(CNPJ::class, $document);
        $this->assertSame('12345678901234', $document->getValue());
    }

    public function testInvalidDocumentTypeThrowsException()
    {
        $this->expectException(DocumentException::class);
        $this->expectExceptionMessage('Invalid document type');

        $factory = new DocumentFactory();
        $factory->createDocument('invalid', '12345678901');
    }
}
