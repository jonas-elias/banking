<?php

declare(strict_types=1);

namespace App\Domain\User\Dependency;

use App\Domain\User\Contract\UserDTOInterface;
use App\Domain\User\Contract\UserRepositoryInterface;
use App\Domain\User\Contract\UserServiceInterface;
use App\Domain\User\DTO\UserDTO;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Service\UserService;

/**
 * Class to binding interfaces -> concret class in user module.
 */
class UserDependency
{
    /**
     * Method to be called static and get bindings.
     *
     * @return array
     */
    public static function getBindings(): array
    {
        return [
            UserDTOInterface::class => UserDTO::class,
            UserServiceInterface::class => UserService::class,
            UserRepositoryInterface::class => UserRepository::class,
        ];
    }
}
