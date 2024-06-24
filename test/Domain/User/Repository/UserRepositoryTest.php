<?php

declare(strict_types=1);

namespace HyperfTest\Domain\User\Repository;

use App\Domain\User\DTO\UserDTO;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\User;
use App\Domain\User\Common;
use App\Domain\User\Merchant;
use App\Domain\User\UserType;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

use function Hyperf\Collection\collect;

class UserRepositoryTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testCreateUserCommon()
    {
        $user = $this->createUserMock();
        $common = $this->createCommonMock();
        $merchant = $this->createMerchantMock();
        $userDTO = $this->createUserDTO(['type' => UserType::Common->value]);

        $repository = $this->createRepositoryWithMocks($user, $common, $merchant);

        $user->shouldReceive('newUniqueId')->andReturn('some-ulid');
        $common->shouldReceive('create')
            ->once()
            ->andReturn((object)['id' => 'some-ulid']);

        $result = $repository->create($userDTO);

        $this->assertEquals(['user' => 'some-ulid'], $result);
    }

    public function testCreateUserMerchant()
    {
        $user = $this->createUserMock();
        $common = $this->createCommonMock();
        $merchant = $this->createMerchantMock();
        $userDTO = $this->createUserDTO([
            'name' => 'Jane Doe',
            'document' => '12345678901',
            'email' => 'jane.doe@example.com',
            'balance' => 2000,
            'type' => UserType::Merchant->value,
        ]);

        $repository = $this->createRepositoryWithMocks($user, $common, $merchant);

        $user->shouldReceive('newUniqueId')->andReturn('some-ulid');
        $merchant->shouldReceive('create')
            ->once()
            ->andReturn((object)['id' => 'another-ulid']);

        $result = $repository->create($userDTO);

        $this->assertEquals(['user' => 'another-ulid'], $result);
    }

    public function testSaveUser()
    {
        $user = $this->createUserMock();
        $common = $this->createCommonMock();
        $merchant = $this->createMerchantMock();

        $user->shouldReceive('save')->once();

        $repository = new UserRepository($user, $common, $merchant);
        $repository->save($user);
        $this->assertTrue(true);
    }

    public function testFindUsersByIds()
    {
        $user = $this->createUserMock();
        $common = $this->createCommonMock();
        $merchant = $this->createMerchantMock();

        $user->shouldReceive('query->whereIn->sharedLock->get')
            ->once()
            ->andReturn(collect([
                (object)['id' => 'id1', 'name' => 'John Doe'],
                (object)['id' => 'id2', 'name' => 'Jane Doe'],
            ]));

        $repository = new UserRepository($user, $common, $merchant);
        $result = $repository->findUsersByIds(['id1', 'id2']);

        $this->assertArrayHasKey('id1', $result);
        $this->assertArrayHasKey('id2', $result);
        $this->assertEquals('John Doe', $result['id1']->name);
        $this->assertEquals('Jane Doe', $result['id2']->name);
    }

    public function testCheckUserDuplication()
    {
        $user = $this->createUserMock();
        $common = $this->createCommonMock();
        $merchant = $this->createMerchantMock();
        $userDTO = $this->createUserDTO();

        $user->shouldReceive('where->orWhere->first')
            ->once()
            ->andReturn((object)['document' => '12345678900', 'email' => 'john.doe@example.com']);

        $repository = new UserRepository($user, $common, $merchant);
        $result = $repository->checkUserDuplication($userDTO);

        $this->assertTrue($result['document']);
        $this->assertTrue($result['email']);
    }

    public function testCheckUserDuplicationNoMatch()
    {
        $user = $this->createUserMock();
        $common = $this->createCommonMock();
        $merchant = $this->createMerchantMock();
        $userDTO = $this->createUserDTO();

        $user->shouldReceive('where->orWhere->first')
            ->once()
            ->andReturn(null);

        $repository = new UserRepository($user, $common, $merchant);
        $result = $repository->checkUserDuplication($userDTO);

        $this->assertFalse($result['document']);
        $this->assertFalse($result['email']);
    }

    protected function createUserMock(): User|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(User::class);
    }

    protected function createCommonMock(): Common|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(Common::class);
    }

    protected function createMerchantMock(): Merchant|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(Merchant::class);
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

    protected function createRepositoryWithMocks(User $user, Common $common, Merchant $merchant): UserRepository|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(UserRepository::class, [$user, $common, $merchant])->makePartial();
    }
}
