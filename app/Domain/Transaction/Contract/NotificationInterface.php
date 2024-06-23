<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Contract;

use App\Domain\Transaction\Notification\NotificationType;

/**
 * Interface bind Notification class injection in service transaction.
 */
interface NotificationInterface
{
    /**
     * Send notification type with type.
     *
     * @param NotificationType $type
     * @param string           $recipient
     * @param string           $message
     *
     * @return void
     */
    public function send(NotificationType $type, string $recipient, string $message): void;
}
