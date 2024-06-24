<?php

declare(strict_types=1);

namespace HyperfTest\Domain\User\Service;

use App\Domain\User\Document\CNPJ;
use App\Domain\User\Document\CPF;
use App\Domain\User\DTO\UserDTO;
use App\Domain\User\Exception\UserExistsException;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Service\UserService;
use App\Domain\User\UserType;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testUserServiceRegisterUserSuccessfully()
    {
        $userRepository = $this->createUserRepositoryMock();
        $userDTO = $this->createUserDTO();

        $userService = new UserService($userRepository);

        $userRepository->shouldReceive('checkUserDuplication')
            ->once()
            ->with($userDTO)
            ->andReturn(['document' => false, 'email' => false]);

        $userRepository->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($userDTO) {
                return password_verify('password123', $userDTO->password);
            }))
            ->andReturn(['user' => 'some-ulid']);

        $result = $userService->register($userDTO);

        $this->assertEquals(['user' => 'some-ulid'], $result);
    }

    public function testUserServiceRegisterUserWithDuplicateDocumentThrowsException()
    {
        $this->expectException(UserExistsException::class);

        $userRepository = $this->createUserRepositoryMock();
        $userDTO = $this->createUserDTO();

        $userService = new UserService($userRepository);

        $userRepository->shouldReceive('checkUserDuplication')
            ->once()
            ->with($userDTO)
            ->andReturn(['document' => true, 'email' => false]);

        $userService->register($userDTO);
    }

    public function testUserServiceRegisterUserWithDuplicateEmailThrowsException()
    {
        $this->expectException(UserExistsException::class);

        $userRepository = $this->createUserRepositoryMock();
        $userDTO = $this->createUserDTO();

        $userService = new UserService($userRepository);

        $userRepository->shouldReceive('checkUserDuplication')
            ->once()
            ->with($userDTO)
            ->andReturn(['document' => false, 'email' => true]);

        $userService->register($userDTO);
    }

    public function testUserServiceRegisterMerchantUserSuccessfully()
    {
        $userRepository = $this->createUserRepositoryMock();
        $userDTO = $this->createUserDTO([
            'type' => UserType::Merchant->value,
            'document' => '12345678000199',
        ]);

        $userService = new UserService($userRepository);

        $userRepository->shouldReceive('checkUserDuplication')
            ->once()
            ->with($userDTO)
            ->andReturn(['document' => false, 'email' => false]);

        $userRepository->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($userDTO) {
                return password_verify('password123', $userDTO->password);
            }))
            ->andReturn(['user' => 'another-ulid']);

        $result = $userService->register($userDTO);

        $this->assertEquals(['user' => 'another-ulid'], $result);
    }

    protected function createUserRepositoryMock(): UserRepository|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(UserRepository::class);
    }

    protected function createUserDTO(array $overrides = []): UserDTO
    {
        $defaultValues = [
            'name' => 'John Doe',
            'document' => '12345678900',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'balance' => 1000,
            'type' => UserType::Common->value,
        ];

        return new UserDTO(array_merge($defaultValues, $overrides));
    }
}
