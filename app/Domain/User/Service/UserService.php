<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\DTO\UserDTO;
use App\Domain\User\Repository\UserRepository;

/**
 * User service class to call repository class and manage business rule.
 */
class UserService
{
    /**
     * Method constructor.
     *
     * @return void
     */
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    /**
     * Method to call register function repository and manage business rule.
     *
     * @param UserDTO $userDTO
     *
     * @return void
     */
    public function register(UserDTO $userDTO): void
    {
        $userDTO->password = $userDTO->hashPassword();

        $this->userRepository->create($userDTO);
    }
}
