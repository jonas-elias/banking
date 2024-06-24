<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Contract;

/**
 * Notification strategy interface.
 */
interface NotificationStrategy
{
    /**
     * Send method received with params recipient and message to user.
     *
     * @param string $recipient
     * @param string $message
     *
     * @return void
     */
    public function send(string $recipient, string $message): void;
}
