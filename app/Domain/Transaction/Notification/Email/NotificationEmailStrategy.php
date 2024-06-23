<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Notification\Email;

use App\Domain\Transaction\Contract\NotificationStrategy;
use App\Service\NotificationEmailQueue;

/**
 * Strategy pattern to send email.
 */
class NotificationEmailStrategy implements NotificationStrategy
{
    /**
     * Method constructor.
     *
     * @param NotificationEmailQueue $emailQueue
     *
     * @return void
     */
    public function __construct(
        protected NotificationEmailQueue $emailQueue,
    ) {
    }

    /**
     * Call queue send email notification.
     *
     * @param string $recipient
     * @param string $message
     *
     * @return void
     */
    public function send(string $recipient, string $message): void
    {
        $this->emailQueue->push($recipient, $message);
    }
}
