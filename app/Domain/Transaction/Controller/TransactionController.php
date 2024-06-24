<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Controller;

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
    public function transfer(RequestInterface $request, ResponseInterface $response, TransactionDTO $transactionDTO): Psr7ResponseInterface
    {
        try {
            $dto = $transactionDTO::fromRequest($request);

            $data = $this->transactionService->transfer($dto);

            return $response
                ->json($data)
                ->withStatus(200);
        } catch (ValidationException $th) {
            return $response->json($th->errors())
                ->withStatus(422);
        } catch (PayerException | PayeeException $pe) {
            return $response->json(['errors' => 'User(s) invalid identification.'])
                ->withStatus(422);
        } catch (UserDebitException $ue) {
            return $response->json(['errors' => 'Insufficient balance.'])
                ->withStatus(422);
        } catch (AuthorizationException $ae) {
            return $response->json(['errors' => 'Authorization denied.'])
                ->withStatus(403);
        } catch (Throwable $th) {
            return $response->json(['errors' => $th->getMessage()])
                ->withStatus(500);
        }
    }
}
