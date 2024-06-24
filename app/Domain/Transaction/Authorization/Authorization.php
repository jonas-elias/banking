<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Authorization;

use App\Domain\Transaction\Authorization\Gateway\GatewayType;
use App\Domain\Transaction\Authorization\Gateway\PicPay\PicPayGateway;
use App\Domain\Transaction\Contract\AuthorizationInterface;
use App\Domain\Transaction\DTO\TransactionDTO;
use InvalidArgumentException;

/**
 * Authorization class to injection strategy types.
 */
class Authorization implements AuthorizationInterface
{
    /**
     * @var array $strategies
     */
    protected array $strategies;

    /**
     * Method constructor.
     *
     * @param PicPayGateway
     *
     * @return void
     */
    public function __construct(
        protected PicPayGateway $picPayGateway,
    ) {
        $this->strategies = [
            GatewayType::PICPAY->value => $picPayGateway,
        ];
    }

    /**
     * Authorization based in gateway type.
     *
     * @param GatewayType    $type
     * @param TransactionDTO $transactionDTO
     *
     * @return void
     */
    public function authorize(GatewayType $type, TransactionDTO $transactionDTO): void
    {
        if (!isset($this->strategies[$type->value])) {
            throw new InvalidArgumentException('Unsupported gateway authorization type.');
        }

        $this->strategies[$type->value]->authorize($transactionDTO);
    }
}
