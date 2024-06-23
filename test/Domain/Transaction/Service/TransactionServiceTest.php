<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Service;

use App\Database\DatabaseTransaction;
use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Exception\PayeeException;
use App\Domain\Transaction\Exception\PayerException;
use App\Domain\Transaction\Repository\TransactionRepository;
use App\Domain\Transaction\Service\TransactionService;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\User;
use Exception;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class TransactionServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testTransactionServiceTransferSuccessful(): void
    {
        $databaseTransaction = $this->createDatabaseTransactionMock();
        $userRepository = $this->createUserRepositoryMock();
        $transRepository = $this->createTransactionRepositoryMock();
        $transactionDTO = $this->createTransactionDTOMock();
        $user = $this->createUserMock();

        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $databaseTransaction->shouldReceive('executeTransaction')->andReturnUsing(function ($callable) {
            $callable();
        });
        $userRepository->shouldReceive('findUsersByIds')
            ->with([$transactionDTO->payer, $transactionDTO->payee])
            ->andReturn([$transactionDTO->payer => $user, $transactionDTO->payee => $user]);
        $user->shouldReceive('debit')->andReturnSelf();
        $user->shouldReceive('credit')->andReturnSelf();
        $userRepository->shouldReceive('save')->andReturnSelf();
        $transRepository->shouldReceive('create')->andReturn([
            'transaction' => 'transaction-id',
        ]);

        $service = new TransactionService($databaseTransaction, $transRepository, $userRepository);

        $service->transfer($transactionDTO);
        $this->assertTrue(true);
    }

    public function testTransactionServiceTransferPayerException(): void
    {
        $databaseTransaction = $this->createDatabaseTransactionMock();
        $userRepository = $this->createUserRepositoryMock();
        $transRepository = $this->createTransactionRepositoryMock();
        $transactionDTO = $this->createTransactionDTOMock();
        $user = $this->createUserMock();

        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $databaseTransaction->shouldReceive('executeTransaction')->andReturnUsing(function ($callable) {
            $callable();
        });
        $userRepository->shouldReceive('findUsersByIds')
            ->with([$transactionDTO->payer, $transactionDTO->payee])
            ->andReturn([$transactionDTO->payee => $user]);
        $user->shouldReceive('debit')->andReturnSelf();
        $user->shouldReceive('credit')->andReturnSelf();
        $userRepository->shouldReceive('save')->andReturnSelf();
        $transRepository->shouldReceive('create')->andReturn([
            'transaction' => 'transaction-id',
        ]);

        $service = new TransactionService($databaseTransaction, $transRepository, $userRepository);

        $this->expectException(PayerException::class);
        $service->transfer($transactionDTO);
    }

    public function testTransactionServiceTransferPayeeException(): void
    {
        $databaseTransaction = $this->createDatabaseTransactionMock();
        $userRepository = $this->createUserRepositoryMock();
        $transRepository = $this->createTransactionRepositoryMock();
        $transactionDTO = $this->createTransactionDTOMock();
        $user = $this->createUserMock();

        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $databaseTransaction->shouldReceive('executeTransaction')->andReturnUsing(function ($callable) {
            $callable();
        });
        $userRepository->shouldReceive('findUsersByIds')
            ->with([$transactionDTO->payer, $transactionDTO->payee])
            ->andReturn([$transactionDTO->payer => $user]);
        $user->shouldReceive('debit')->andReturnSelf();
        $user->shouldReceive('credit')->andReturnSelf();
        $userRepository->shouldReceive('save')->andReturnSelf();
        $transRepository->shouldReceive('create')->andReturn([
            'transaction' => 'transaction-id',
        ]);

        $service = new TransactionService($databaseTransaction, $transRepository, $userRepository);

        $this->expectException(PayeeException::class);
        $service->transfer($transactionDTO);
    }

    public function testTransactionServiceTransferGeneralException(): void
    {
        $databaseTransaction = $this->createDatabaseTransactionMock();
        $userRepository = $this->createUserRepositoryMock();
        $transRepository = $this->createTransactionRepositoryMock();
        $transactionDTO = $this->createTransactionDTOMock();
        $user = $this->createUserMock();

        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $databaseTransaction->shouldReceive('executeTransaction')->andReturnUsing(function ($callable) {
            $callable();
        });
        $userRepository->shouldReceive('findUsersByIds')
            ->with([$transactionDTO->payer, $transactionDTO->payee])
            ->andReturn([$transactionDTO->payer => $user, $transactionDTO->payee => $user]);
        $user->shouldReceive('debit')->andReturnSelf();
        $user->shouldReceive('credit')->andReturnSelf();
        $userRepository->shouldReceive('save')->andReturnSelf();
        $transRepository->shouldReceive('create')->andReturnUsing(function () {
            throw new Exception();
        });

        $service = new TransactionService($databaseTransaction, $transRepository, $userRepository);

        $this->expectException(Exception::class);
        $service->transfer($transactionDTO);
    }

    protected function createDatabaseTransactionMock(): DatabaseTransaction|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(DatabaseTransaction::class);
    }

    protected function createTransactionRepositoryMock(): TransactionRepository|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(TransactionRepository::class);
    }

    protected function createUserRepositoryMock(): UserRepository|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(UserRepository::class);
    }

    protected function createTransactionDTOMock(): TransactionDTO|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(TransactionDTO::class);
    }

    protected function createUserMock(): User|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(User::class);
    }
}
