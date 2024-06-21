<?php

declare(strict_types=1);

namespace App\Domain\User\Document\Enum;

/**
 * Enum to return number of digits document
 */
enum DocumentType: int
{
    /**
     * @case CPF
     */
    case CPF = 11;

    /**
     * @case CNPJ
     */
    case CNPJ = 14;
}
