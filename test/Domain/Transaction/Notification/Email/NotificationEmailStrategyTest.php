<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Notification\Email;

use App\Domain\Transaction\Notification\Email\NotificationEmailStrategy;
use App\Service\NotificationEmailQueue;
use Mockery;
use PHPUnit\Framework\TestCase;

class NotificationEmailStrategyTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testNotificationEmailStrategySend()
    {
        $recipient = 'test@example.com';
        $message = 'This is a test message.';

        $emailQueueMock = Mockery::mock(NotificationEmailQueue::class);
        $emailQueueMock->shouldReceive('push')
            ->once()
            ->with($recipient, $message);

        $strategy = new NotificationEmailStrategy($emailQueueMock);
        $strategy->send($recipient, $message);

        $this->assertTrue(true);
    }
}
