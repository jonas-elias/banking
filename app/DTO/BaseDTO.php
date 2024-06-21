<?php

declare(strict_types=1);

namespace App\DTO;

use App\DTO\Contract\BaseDTOInterface;
use App\Exception\ValidationException;
use FriendsOfHyperf\ValidatedDTO\ValidatedDTO;

/**
 * Base DTO extend lib hyperf validationDTO.
 */
abstract class BaseDTO extends ValidatedDTO implements BaseDTOInterface
{
    /**
     * Handles a failed validation attempt.
     *
     * @throws ValidationException
     */
    protected function failedValidation(): void
    {
        throw new ValidationException($this->validator);
    }
}
