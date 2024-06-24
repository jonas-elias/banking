<?php

declare(strict_types=1);

namespace HyperfTest\Service;

use App\Job\NotificationEmailJob;
use App\Service\NotificationEmailQueue;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;
use Hyperf\Context\ApplicationContext;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class NotificationEmailQueueTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testEmailNotificationQueuePush()
    {
        $driverMock = $this->createDriverInterfaceMock();
        $driverFactoryMock = $this->createDriverFactoryMock();
        $applicationContext = $this->createApplicationContextMock();

        $driverMock->shouldReceive('push')
            ->once()
            ->withArgs(function ($job, $delay) {
                return $job instanceof NotificationEmailJob && $delay === 0;
            })
            ->andReturn(true);
        $driverFactoryMock->shouldReceive('get')
            ->once()
            ->with('default')
            ->andReturn($driverMock);

        $queue = new NotificationEmailQueue($driverFactoryMock, $applicationContext);

        $result = $queue->push('recipient@example.com', 'Test message');
        $this->assertTrue($result);
    }

    protected function createDriverInterfaceMock(): DriverInterface|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(DriverInterface::class);
    }

    protected function createDriverFactoryMock(): DriverFactory|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(DriverFactory::class);
    }

    protected function createApplicationContextMock(): ApplicationContext|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(ApplicationContext::class);
    }
}
