<?php

declare(strict_types=1);

namespace App\Domain\User\Contract;

use App\Domain\User\DTO\UserDTO;
use App\Domain\User\User;

/**
 * User repository interface to make transactions to database.
 */
interface UserRepositoryInterface
{
    /**
     * Call database model of the type user (common or merchant).
     *
     * @param UserDTO $userDTO
     *
     * @return array
     */
    public function create(UserDTO $userDTO): array;

    /**
     * Save user model based in change values received in param.
     *
     * @param User $user
     *
     * @return void
     */
    public function save(User $user): void;

    /**
     * Find users by ids.
     *
     * @param array $ids
     *
     * @return array<User>
     */
    public function findUsersByIds(array $ids): array;

    /**
     * Check duplication in user email or document.
     *
     * @param UserDTO $userDTO
     *
     * @return array
     */
    public function checkUserDuplication(UserDTO $userDTO): array;
}
