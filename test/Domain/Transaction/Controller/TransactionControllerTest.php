<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Controller;

use App\Domain\Transaction\Controller\TransactionController;
use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Exception\AuthorizationException;
use App\Domain\Transaction\Exception\PayerException;
use App\Domain\Transaction\Service\TransactionService;
use App\Domain\User\Exception\UserDebitException;
use App\Request\RequestInterface;
use App\Response\ResponseInterface;
use Exception;
use Hyperf\Validation\ValidationException;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

class TransactionControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testTransactionControllerTransferSuccessful(): void
    {
        $transactionService = $this->createTransactionServiceMock();
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        $transactionDTO = $this->createTransactionDTOMock();

        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $transactionDTO->shouldReceive('fromRequest')->with($request)->andReturnSelf();
        $transactionService->shouldReceive('transfer')->with($transactionDTO)->andReturn(['success' => true]);

        $response->shouldReceive('withStatus')->with(204)->andReturnSelf();

        $controller = new TransactionController($transactionService);
        $result = $controller->transfer($request, $response, $transactionDTO);

        $this->assertInstanceOf(Psr7ResponseInterface::class, $result);
    }

    public function testTransactionControllerTransferValidationException(): void
    {
        $transactionService = $this->createTransactionServiceMock();
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        $transactionDTO = $this->createTransactionDTOMock();

        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $exception = Mockery::mock(ValidationException::class);
        $exception->shouldReceive('errors')->andReturn(['error' => 'Validation error']);

        $transactionDTO->shouldReceive('fromRequest')->with($request)->andThrow($exception);

        $response->shouldReceive('json')->with(['error' => 'Validation error'])->andReturnSelf();
        $response->shouldReceive('withStatus')->with(422)->andReturnSelf();

        $controller = new TransactionController($transactionService);
        $result = $controller->transfer($request, $response, $transactionDTO);

        $this->assertInstanceOf(Psr7ResponseInterface::class, $result);
    }

    public function testTransactionControllerTransferPayerOrPayeeException(): void
    {
        $transactionService = $this->createTransactionServiceMock();
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        $transactionDTO = $this->createTransactionDTOMock();

        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $transactionDTO->shouldReceive('fromRequest')->with($request)->andReturn($transactionDTO);
        $transactionService->shouldReceive('transfer')->with($transactionDTO)->andThrow(PayerException::class);

        $response->shouldReceive('json')->with(['errors' => 'User(s) invalid identification.'])->andReturnSelf();
        $response->shouldReceive('withStatus')->with(422)->andReturnSelf();

        $controller = new TransactionController($transactionService);
        $result = $controller->transfer($request, $response, $transactionDTO);

        $this->assertInstanceOf(Psr7ResponseInterface::class, $result);
    }

    public function testTransactionControllerTransferAuthorizationException(): void
    {
        $transactionService = $this->createTransactionServiceMock();
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        $transactionDTO = $this->createTransactionDTOMock();

        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $transactionDTO->shouldReceive('fromRequest')->with($request)->andReturnSelf();
        $transactionService->shouldReceive('transfer')->with($transactionDTO)->andThrow(new AuthorizationException('Authorization exception.'));

        $response->shouldReceive('json')->with(['errors' => 'Authorization denied.'])->andReturnSelf();
        $response->shouldReceive('withStatus')->with(403)->andReturnSelf();

        $controller = new TransactionController($transactionService);
        $result = $controller->transfer($request, $response, $transactionDTO);

        $this->assertInstanceOf(Psr7ResponseInterface::class, $result);
    }

    public function testTransactionControllerTransferUserDebitException(): void
    {
        $transactionService = $this->createTransactionServiceMock();
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        $transactionDTO = $this->createTransactionDTOMock();

        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $transactionDTO->shouldReceive('fromRequest')->with($request)->andReturnSelf();
        $transactionService->shouldReceive('transfer')->with($transactionDTO)->andThrow(new UserDebitException());

        $response->shouldReceive('json')->with(['errors' => 'Insufficient balance.'])->andReturnSelf();
        $response->shouldReceive('withStatus')->with(422)->andReturnSelf();

        $controller = new TransactionController($transactionService);
        $result = $controller->transfer($request, $response, $transactionDTO);

        $this->assertInstanceOf(Psr7ResponseInterface::class, $result);
    }

    public function testTransactionControllerTransferGeneralException(): void
    {
        $transactionService = $this->createTransactionServiceMock();
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        $transactionDTO = $this->createTransactionDTOMock();

        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $transactionDTO->shouldReceive('fromRequest')->with($request)->andReturnSelf();
        $transactionService->shouldReceive('transfer')->with($transactionDTO)->andThrow(new Exception('General error'));

        $response->shouldReceive('json')->with(['errors' => 'Internal error.'])->andReturnSelf();
        $response->shouldReceive('withStatus')->with(500)->andReturnSelf();

        $controller = new TransactionController($transactionService);
        $result = $controller->transfer($request, $response, $transactionDTO);

        $this->assertInstanceOf(Psr7ResponseInterface::class, $result);
    }

    protected function createTransactionServiceMock(): TransactionService|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(TransactionService::class);
    }

    protected function createRequestMock(): RequestInterface|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(RequestInterface::class);
    }

    protected function createResponseMock(): ResponseInterface|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(ResponseInterface::class, Psr7ResponseInterface::class);
    }

    protected function createTransactionDTOMock(): TransactionDTO|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(TransactionDTO::class);
    }
}
