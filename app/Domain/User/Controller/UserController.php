<?php

declare(strict_types=1);

namespace App\Domain\User\Controller;

use App\Domain\User\Document\Exception\DocumentException;
use App\Domain\User\DTO\UserDTO;
use App\Domain\User\Exception\UserExistsException;
use App\Domain\User\Service\UserService;
use App\Exception\ValidationException;
use App\Request\RequestInterface;
use App\Response\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

/**
 * Controller class to received requests user register/show.
 */
class UserController
{
    /**
     * Method constructor.
     *
     * @param UserService $userService
     *
     * @return void
     */
    public function __construct(
        protected UserService $userService,
    ) {}

    /**
     * Method to register user in banking backend app.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param UserDTO           $userDTO
     *
     * @return ResponseInterface
     */
    public function register(RequestInterface $request, ResponseInterface $response, UserDTO $userDTO): Psr7ResponseInterface
    {
        try {
            $dto = $userDTO::fromRequest($request);

            $data = $this->userService->register($dto);

            return $response
                ->json($data)
                ->withStatus(201);
        } catch (ValidationException $th) {
            return $response->json($th->errors())
                ->withStatus(422);
        } catch (DocumentException $de) {
            return $response->json(['errors' => $de->getMessage()])
                ->withStatus(422);
        } catch (UserExistsException $ue) {
            return $response->json(['errors' => 'Duplicated user.'])
                ->withStatus(409);
        } catch (Throwable $th) {
            return $response->json(['errors' => 'Internal error.'])
                ->withStatus(500);
        }
    }
}
