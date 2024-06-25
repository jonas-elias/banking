<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Controller;

use App\Constants\HttpStatus;
use App\Domain\Transaction\Contract\TransactionServiceInterface;
use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Exception\AuthorizationException;
use App\Domain\Transaction\Exception\PayeeException;
use App\Domain\Transaction\Exception\PayerException;
use App\Domain\User\Exception\UserDebitException;
use App\Request\RequestInterface;
use App\Response\ResponseInterface;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

/**
 * Class transaction controller to call service transaction.
 */
class TransactionController
{
    /**
     * Method constructor.
     *
     * @param TransactionServiceInterface $transactionService
     *
     * @return void
     */
    public function __construct(
        protected TransactionServiceInterface $transactionService
    ) {
    }

    /**
     * Transfer controller method call service.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param TransactionDTO    $transactionDTO
     *
     * @return Psr7ResponseInterface
     */
    public function transfer(RequestInterface $request, ResponseInterface|Psr7ResponseInterface $response, TransactionDTO $transactionDTO): Psr7ResponseInterface
    {
        try {
            $dto = $transactionDTO::fromRequest($request);

            $this->transactionService->transfer($dto);

            return $response
                ->withStatus(HttpStatus::NO_CONTENT);
        } catch (ValidationException $th) {
            return $response->json($th->errors())
                ->withStatus(HttpStatus::UNPROCESSABLE_ENTITY);
        } catch (PayerException | PayeeException $pe) {
            return $response->json(['errors' => 'User(s) invalid identification.'])
                ->withStatus(HttpStatus::UNPROCESSABLE_ENTITY);
        } catch (UserDebitException $ue) {
            return $response->json(['errors' => 'Insufficient balance.'])
                ->withStatus(HttpStatus::UNPROCESSABLE_ENTITY);
        } catch (AuthorizationException $ae) {
            return $response->json(['errors' => 'Authorization denied.'])
                ->withStatus(HttpStatus::FORBIDDEN);
        } catch (Throwable $th) {
            return $response->json(['errors' => 'Internal error.'])
                ->withStatus(HttpStatus::INTERNAL_SERVER_ERROR);
        }
    }
}
