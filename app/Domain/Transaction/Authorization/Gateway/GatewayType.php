<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Authorization\Gateway;

/**
 * Enum types gateway authorization.
 */
enum GatewayType: string
{
    /**
     * @case PICPAY
     */
    case PICPAY = 'picpay';

    /**
     * @case ITAU
     */
    case ITAU = 'itau';
}
