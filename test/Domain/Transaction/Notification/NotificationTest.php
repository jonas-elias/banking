<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Notification;

use App\Domain\Transaction\Notification\Notification;
use App\Domain\Transaction\Notification\Email\NotificationEmailStrategy;
use App\Domain\Transaction\Notification\NotificationType;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Mockery;

class NotificationTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testNotificationSendEmailNotification()
    {
        $recipient = 'test@example.com';
        $message = 'This is a test message.';

        $emailStrategyMock = Mockery::mock(NotificationEmailStrategy::class);
        $emailStrategyMock->shouldReceive('send')
            ->once()
            ->with($recipient, $message);

        $notification = new Notification($emailStrategyMock);
        $notification->send(NotificationType::EMAIL, $recipient, $message);

        $this->assertTrue(true);
    }

    public function testNotificationUnsupportedNotificationType()
    {
        $notification = new Notification(Mockery::mock(NotificationEmailStrategy::class));

        $this->expectException(InvalidArgumentException::class);
        $notification->send(NotificationType::SMS, 'test@example.com', 'Test message');
    }
}
