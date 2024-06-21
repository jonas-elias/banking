<?php

declare(strict_types=1);

namespace App\Domain\User\Document;

use App\Domain\User\Document\Enum\DocumentType;
use App\Domain\User\Document\Exception\DocumentException;

/**
 * Class to implement CPF methods abstract extends.
 */
class CPF extends Document
{
    /**
     * Method to validate length document value.
     *
     * @return void
     */
    protected function validate(): void
    {
        if (strlen($this->value) !== DocumentType::CPF->value) {
            throw new DocumentException('Invalid CPF. '.$this->value);
        }
    }
}
