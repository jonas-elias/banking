<?php

namespace App\Domain\Transaction\Authorization\Gateway\PicPay;

use App\Constants\HttpStatus;
use App\Domain\Transaction\Contract\GatewayInterface;
use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Exception\AuthorizationException;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Guzzle\ClientFactory;

/**
 * PicPay gateway class to authorize transaction.
 */
class PicPayGateway implements GatewayInterface
{
    /**
     * Method constructor.
     *
     * @param ConfigInterface   $config
     * @param ClientFactory     $clientHttp
     *
     * @return void
     */
    public function __construct(
        protected ConfigInterface $config,
        protected ClientFactory $clientHttp,
    ) {
    }

    /**
     * Authorize transaction based in webhook picpay.
     *
     * @param TransactionDTO    $transactionDTO
     *
     * @return void
     *
     * @throws AuthorizationException
     */
    public function authorize(TransactionDTO $transactionDTO): void
    {
        $uri = $this->config->get('authorization.gateway.picpay.uri');

        $request = $this->clientHttp->create();
        $response = $request->get($uri, [
            'json' => [
                'payer_id'  => $transactionDTO->payer,
                'payee_id'  => $transactionDTO->payee,
                'value'     => $transactionDTO->value,
            ],
            'http_errors' => false,
        ]);

        if ($response->getStatusCode() !== HttpStatus::OK) {
            throw new AuthorizationException();
        }
    }
}
