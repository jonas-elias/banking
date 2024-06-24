<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\Contract\UserRepositoryInterface;
use App\Domain\User\Contract\UserServiceInterface;
use App\Domain\User\Document\CNPJ;
use App\Domain\User\Document\CPF;
use App\Domain\User\DTO\UserDTO;
use App\Domain\User\Exception\UserExistsException;
use App\Domain\User\UserType;

/**
 * User service class to call repository class and manage business rule.
 */
class UserService implements UserServiceInterface
{
    /**
     * Method constructor.
     *
     * @param UserRepositoryInterface $userRepository
     *
     * @return void
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * Method to call register function repository and manage business rule.
     *
     * @param UserDTO $userDTO
     *
     * @return array
     */
    public function register(UserDTO $userDTO): array
    {
        $this->userConditions($userDTO);

        $userDTO->password = $userDTO->hashPassword();
        $user = $this->userRepository->create($userDTO);

        return $user;
    }

    /**
     * Define user conditions validate type and duplication.
     *
     * @param UserDTO $userDTO
     *
     * @return void
     */
    protected function userConditions(UserDTO $userDTO): void
    {
        match ($userDTO->type) {
            UserType::Common->value   => new CPF($userDTO->document),
            UserType::Merchant->value => new CNPJ($userDTO->document),
        };

        $validation = $this->userRepository->checkUserDuplication($userDTO);

        if ($validation['document'] || $validation['email']) {
            throw new UserExistsException();
        }
    }
}
