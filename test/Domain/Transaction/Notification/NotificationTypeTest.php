<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Notification;

use App\Domain\Transaction\Notification\NotificationType;
use PHPUnit\Framework\TestCase;

class NotificationTypeTest extends TestCase
{
    public function testNotificationTypeEnumValues()
    {
        $this->assertEquals('email', NotificationType::EMAIL->value);
        $this->assertEquals('sms', NotificationType::SMS->value);
    }

    public function testNotificationTypeEnumInstance()
    {
        $emailType = NotificationType::EMAIL;
        $smsType = NotificationType::SMS;

        $this->assertInstanceOf(NotificationType::class, $emailType);
        $this->assertInstanceOf(NotificationType::class, $smsType);

        $this->assertNotSame($emailType, $smsType);
    }

    public function testNotificationTypeInvalidEnumValue()
    {
        $this->expectException(\Error::class);
        NotificationType::INVALID;
    }
}
