<?php

declare(strict_types=1);

namespace App\Domain\User\Contract;

/**
 * Interface UserDTO define necessary methods.
 */
interface UserDTOInterface
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
