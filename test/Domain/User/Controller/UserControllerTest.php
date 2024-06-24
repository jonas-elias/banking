<?php

declare(strict_types=1);

namespace HyperfTest\Domain\User\Controller;

use App\Domain\User\Controller\UserController;
use App\Domain\User\Document\Exception\DocumentException;
use App\Domain\User\DTO\UserDTO;
use App\Domain\User\Exception\UserExistsException;
use App\Domain\User\Service\UserService;
use App\Request\RequestInterface;
use App\Response\ResponseInterface;
use App\Exception\ValidationException;
use Exception;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

class UserControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testUserControllerRegisterSuccess()
    {
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        $userDTO = $this->createUserDTOMock();
        $userService = $this->createUserServiceMock();

        $requestData = ['username' => 'testuser'];
        $userDTO->shouldReceive('fromRequest')->with($request)->andReturnSelf();

        $userService->shouldReceive('register')->andReturn($requestData);
        $response->shouldReceive('json')->andReturnSelf();
        $response->shouldReceive('withStatus')->with(201)->andReturnSelf();

        $controller = new UserController($userService);
        $result = $controller->register($request, $response, $userDTO);

        $this->assertInstanceOf(Psr7ResponseInterface::class, $result);
    }

    public function testUserControllerRegisterDocumentException()
    {
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        $userDTO = $this->createUserDTOMock();
        $userService = $this->createUserServiceMock();

        $exception = Mockery::mock(ValidationException::class);
        $exception->shouldReceive('errors')->andReturn(['error' => 'Validation error']);

        $requestData = ['username' => 'testuser'];

        $userDTO->shouldReceive('fromRequest')->with($request)->andReturnSelf();
        $userService->shouldReceive('register')->andThrow(new DocumentException());

        $response->shouldReceive('json')->with(['errors' => ''])->andReturnSelf();
        $response->shouldReceive('withStatus')->with(422)->andReturnSelf();

        $controller = new UserController($userService);
        $result = $controller->register($request, $response, $userDTO);

        $this->assertInstanceOf(Psr7ResponseInterface::class, $result);
    }

    public function testUserControllerRegisterUserExistsException()
    {
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        $userDTO = $this->createUserDTOMock();
        $userService = $this->createUserServiceMock();

        $exception = Mockery::mock(ValidationException::class);
        $exception->shouldReceive('errors')->andReturn(['error' => 'Validation error']);

        $requestData = ['username' => 'testuser'];

        $userDTO->shouldReceive('fromRequest')->with($request)->andReturnSelf();
        $userService->shouldReceive('register')->andThrow(new UserExistsException());

        $response->shouldReceive('json')->with(['errors' => 'Duplicated user.'])->andReturnSelf();
        $response->shouldReceive('withStatus')->with(409)->andReturnSelf();

        $controller = new UserController($userService);
        $result = $controller->register($request, $response, $userDTO);

        $this->assertInstanceOf(Psr7ResponseInterface::class, $result);
    }

    public function testUserControllerRegisterValidationException()
    {
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        $userDTO = $this->createUserDTOMock();
        $userService = $this->createUserServiceMock();

        $exception = Mockery::mock(ValidationException::class);
        $exception->shouldReceive('errors')->andReturn(['error' => 'Validation error']);

        $userDTO->shouldReceive('fromRequest')->with($request)->andThrow($exception);

        $response->shouldReceive('json')->with(['error' => 'Validation error'])->andReturnSelf();
        $response->shouldReceive('withStatus')->with(422)->andReturnSelf();

        $controller = new UserController($userService);
        $result = $controller->register($request, $response, $userDTO);

        $this->assertInstanceOf(Psr7ResponseInterface::class, $result);
    }

    public function testUserControllerRegisterThrowableException()
    {
        $request = $this->createRequestMock();
        $response = $this->createResponseMock();
        $userDTO = $this->createUserDTOMock();
        $userService = $this->createUserServiceMock();

        $exception = Mockery::mock(ValidationException::class);
        $exception->shouldReceive('errors')->andReturn(['error' => 'Validation error']);

        $requestData = ['username' => 'testuser'];

        $userDTO->shouldReceive('fromRequest')->with($request)->andReturnSelf();
        $userService->shouldReceive('register')->andThrow(new Exception());

        $response->shouldReceive('json')->with(['errors' => 'Internal error.'])->andReturnSelf();
        $response->shouldReceive('withStatus')->with(500)->andReturnSelf();

        $controller = new UserController($userService);
        $result = $controller->register($request, $response, $userDTO);

        $this->assertInstanceOf(Psr7ResponseInterface::class, $result);
    }

    protected function createRequestMock(): RequestInterface|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(RequestInterface::class);
    }

    protected function createResponseMock(): ResponseInterface|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(ResponseInterface::class, Psr7ResponseInterface::class);
    }

    protected function createUserDTOMock(): UserDTO|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(UserDTO::class);
    }

    protected function createUserServiceMock(): UserService|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(UserService::class);
    }
}
