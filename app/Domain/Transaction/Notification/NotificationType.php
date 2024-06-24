<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Notification;

/**
 * Enum types notification.
 */
enum NotificationType: string
{
    /**
     * @case EMAIL
     */
    case EMAIL = 'email';

    /**
     * @case EMAIL
     */
    case SMS = 'sms';
}
