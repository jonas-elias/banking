<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Contract;

/**
 * Interface DTO to transaction get params and basic validations.
 */
interface TransactionDTOInterface
{
    /**
     * Define the validation messages for each field.
     *
     * @return array
     */
    public function messages(): array;

    /**
     * Define the default values for each field.
     *
     * @return array
     */
    public function defaults(): array;
}
