<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Common;
use App\Domain\User\DTO\UserDTO;
use App\Domain\User\Merchant;
use App\Domain\User\User;

/**
 * User repository class to make transactions to database.
 */
class UserRepository
{
    /**
     * Method constructor.
     *
     * @param User $user
     * @param Common $common
     * @param Merchant $merchant
     *
     * @return void
     */
    public function __construct(
        protected User $user,
        protected Common $common,
        protected Merchant $merchant,
    ) {}

    /**
     * Method to call register function repository and manage business rule.
     *
     * @param UserDTO $userDTO
     *
     * @return void
     */
    public function create(UserDTO $userDTO): void {}

    /**
     * Method to find users by id
     *
     * @param array $ids
     *
     * @return User<>
     */
    public function findUsersById(array $ids)
    {
        return $this->user::query()->whereIn($ids)->sharedLock()->get();
    }
}
