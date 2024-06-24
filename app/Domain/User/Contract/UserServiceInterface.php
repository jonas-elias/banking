<?php

declare(strict_types=1);

namespace App\Domain\User\Contract;

use App\Domain\User\DTO\UserDTO;

/**
 * User service interface to call repository class and manage business rule.
 */
interface UserServiceInterface
{
    /**
     * Method to call register function repository and manage business rule.
     *
     * @param UserDTO $userDTO
     *
     * @return array
     */
    public function register(UserDTO $userDTO): array;
}
