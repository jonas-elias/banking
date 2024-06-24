<?php

declare(strict_types=1);

namespace HyperfTest\Job;

use App\Job\NotificationEmailJob;
use GuzzleHttp\Client;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Guzzle\ClientFactory;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class NotificationEmailJobTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testEmailNotificationJobHandle()
    {
        $recipient = 'test@example.com';
        $message = 'This is a test message.';
        $uri = 'https://util.devi.tools/api/v1/notify';

        $clientFactoryMock = $this->createClientFactoryMock();
        $httpClientMock = $this->createHttpClientMock();
        $applicationContext = $this->createApplicationContextMock();
        $container = $this->createContainerMock();

        $applicationContext->shouldReceive('getContainer')->andReturn($container);
        $clientFactoryMock->shouldReceive('create')->andReturn($httpClientMock);
        $httpClientMock->shouldReceive('request')
            ->once()
            ->with('POST', $uri, [
                'json' => [
                    'recipient' => $recipient,
                    'message' => $message,
                ],
            ]);
        $container->shouldReceive('has')->with('Hyperf\Contract\ConfigInterface')->andReturnUsing(function () {
            return true;
        });
        $container->shouldReceive('get')->andReturn($clientFactoryMock);

        $job = new NotificationEmailJob($recipient, $message, $applicationContext);
        $job->handle();
    }

    protected function createClientFactoryMock(): ClientFactory|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(ClientFactory::class);
    }

    protected function createHttpClientMock(): Client|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(Client::class);
    }

    protected function createContainerMock(): ContainerInterface|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(ContainerInterface::class);
    }

    protected function createApplicationContextMock(): ApplicationContext|LegacyMockInterface|MockInterface
    {
        return Mockery::mock(ApplicationContext::class);
    }
}
