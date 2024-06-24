<?php

declare(strict_types=1);

namespace HyperfTest\Domain\User\Dependency;

use App\Domain\User\Contract\UserDTOInterface;
use App\Domain\User\Contract\UserRepositoryInterface;
use App\Domain\User\Contract\UserServiceInterface;
use App\Domain\User\Dependency\UserDependency;
use App\Domain\User\DTO\UserDTO;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Service\UserService;
use PHPUnit\Framework\TestCase;

class UserDependencyTest extends TestCase
{
    public function testUserDependencyBindings()
    {
        $bindings = UserDependency::getBindings();

        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(UserDTOInterface::class, $bindings);
        $this->assertSame(UserDTO::class, $bindings[UserDTOInterface::class]);

        $this->assertArrayHasKey(UserServiceInterface::class, $bindings);
        $this->assertSame(UserService::class, $bindings[UserServiceInterface::class]);

        $this->assertArrayHasKey(UserRepositoryInterface::class, $bindings);
        $this->assertSame(UserRepository::class, $bindings[UserRepositoryInterface::class]);
    }
}
