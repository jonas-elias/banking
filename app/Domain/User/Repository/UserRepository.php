<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Common;
use App\Domain\User\DTO\UserDTO;
use App\Domain\User\Merchant;
use App\Domain\User\User;
use App\Domain\User\UserType;

/**
 * User repository class to make transactions to database.
 */
class UserRepository
{
    /**
     * Method constructor.
     *
     * @param User     $user
     * @param Common   $common
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
     * Call database model of the type user (common or merchant).
     *
     * @param UserDTO $userDTO
     *
     * @return array
     */
    public function create(UserDTO $userDTO): array
    {
        $model = match ($userDTO->type) {
            UserType::Common->value => $this->common,
            UserType::Merchant->value => $this->merchant,
        };

        $ulid = $this->generateUlid();

        $data = $model::create([
            'id' => $ulid,
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'password' => $userDTO->password,
            'document' => $userDTO->document,
            'balance' => $userDTO->balance,
            'type' => $userDTO->type,
        ]);

        return [
            'user' => $data->id
        ];
    }

    /**
     * Find users by ids.
     *
     * @param array $ids
     *
     * @return User
     */
    public function findUsersByIds(array $ids): User
    {
        return $this->user::query()->whereIn($ids)->sharedLock()->get();
    }

    /**
     * Check duplication in user email or document.
     *
     * @param UserDTO $userDTO
     *
     * @return array
     */
    public function checkUserDuplication(UserDTO $userDTO): array
    {
        $user = $this->user::where('document', $userDTO->document)
            ->orWhere('email', $userDTO->email)
            ->first();

        $documentExists = $user && $user->document === $userDTO->document;
        $emailExists = $user && $user->email === $userDTO->email;

        return [
            'document' => $documentExists,
            'email' => $emailExists
        ];
    }

    /**
     * Method to generate ulid.
     *
     * @return string
     */
    protected function generateUlid(): string
    {
        return $this->user->newUniqueId();
    }
}
