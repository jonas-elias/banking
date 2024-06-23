<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Notification;

use App\Domain\Transaction\Contract\NotificationInterface;
use App\Domain\Transaction\Notification\Email\NotificationEmailStrategy;
use InvalidArgumentException;

/**
 * Notification class to injection strategy types.
 */
class Notification implements NotificationInterface
{
    /**
     * @var array $strategies
     */
    protected array $strategies;

    /**
     * Method constructor.
     *
     * @param NotificationEmailStrategy
     *
     * @return void
     */
    public function __construct(
        protected NotificationEmailStrategy $emailStrategy,
    ) {
        $this->strategies = [
            NotificationType::EMAIL->value => $emailStrategy,
        ];
    }

    /**
     * Send notification type with type.
     *
     * @param NotificationType $type
     * @param string           $recipient
     * @param string           $message
     *
     * @return void
     */
    public function send(NotificationType $type, string $recipient, string $message): void
    {
        if (!isset($this->strategies[$type->value])) {
            throw new InvalidArgumentException('Unsupported notification type.');
        }

        $this->strategies[$type->value]->send($recipient, $message);
    }
}
