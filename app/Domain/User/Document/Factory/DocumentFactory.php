<?php

declare(strict_types=1);

namespace App\Domain\User\Document\Factory;

use App\Domain\User\Document\CNPJ;
use App\Domain\User\Document\CPF;
use App\Domain\User\Document\Document;
use InvalidArgumentException;

/**
 * Factory class to make object document
 */
class DocumentFactory
{
    /**
     * Factory method to create classes of documents
     *
     * @param string $type
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return Document
     */
    public function createDocument(string $type, string $value): Document
    {
        switch (strtolower($type)) {
            case 'cpf':
                return new CPF($value);
            case 'cnpj':
                return new CNPJ($value);
            default:
                throw new InvalidArgumentException('Invalid document type');
        }
    }
}
