<?php

declare(strict_types=1);

namespace App\Domain\User\Document;

use App\Domain\User\Document\Enum\DocumentType;
use App\Domain\User\Document\Exception\DocumentException;

/**
 * Class to implement CNPJ methods abstract extends.
 */
class CNPJ extends Document
{
    /**
     * Method to validate length document value.
     *
     * @return void
     */
    protected function validate(): void
    {
        if (strlen($this->value) !== DocumentType::CNPJ->value) {
            throw new DocumentException('Invalid CNPJ. ' . $this->value);
        }
    }
}
