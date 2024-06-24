<?php

declare(strict_types=1);

namespace HyperfTest\HttpLogger;

use App\HttpLogger\LogWriter;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Logger\LoggerFactory;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class LogWriterTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testLogWriterRequest(): void
    {
        $loggerFactoryMock = Mockery::mock(LoggerFactory::class);
        $configMock = Mockery::mock(ConfigInterface::class);
        $loggerMock = Mockery::mock(LoggerInterface::class);
        $requestMock = Mockery::mock(ServerRequestInterface::class);
        $responseMock = Mockery::mock(ResponseInterface::class);

        $configMock->shouldReceive('get')
            ->with('http_logger.log_group', 'http-logger')
            ->andReturn('http-logger');
        $configMock->shouldReceive('get')
            ->with('http_logger.log_name', 'http')
            ->andReturn('http');
        $configMock->shouldReceive('get')
            ->with('http_logger.log_level', 'debug')
            ->andReturn('debug');
        $configMock->shouldReceive('get')
            ->with('http_logger.log_format', '')
            ->andReturn('%host% - %remote_addr% [%time_local%] "%request%" %status% %body_bytes_sent% "%http_referer%" "%http_user_agent%"');
        $configMock->shouldReceive('get')
            ->with('http_logger.log_time_format', 'd/M/Y:H:i:s O')
            ->andReturn('d/M/Y:H:i:s O');

        $loggerFactoryMock->shouldReceive('get')
            ->with('http', 'http-logger')
            ->andReturn($loggerMock);

        $requestMock->shouldReceive('getServerParams')
            ->andReturn([
                'host' => 'localhost',
                'remote_addr' => '127.0.0.1',
                'server_protocol' => 'HTTP/1.1',
                'request_time_float' => microtime(true),
            ]);
        $requestMock->shouldReceive('getHeaderLine')
            ->with('x-real-ip')
            ->andReturn('');
        $requestMock->shouldReceive('getHeaderLine')
            ->with('referer')
            ->andReturn('');
        $requestMock->shouldReceive('getHeaderLine')
            ->with('user-agent')
            ->andReturn('');
        $requestMock->shouldReceive('getHeaderLine')
            ->with('x-forwarded-for')
            ->andReturn('');
        $requestMock->shouldReceive('getMethod')
            ->andReturn('GET');
        $requestMock->shouldReceive('getUri->getPath')
            ->andReturn('/');
        $requestMock->shouldReceive('getUri->getQuery')
            ->andReturn('');

        $responseMock->shouldReceive('getStatusCode')
            ->andReturn(200);
        $responseMock->shouldReceive('getBody->getSize')
            ->andReturn(0);
        $responseMock->shouldReceive('getHeaderLine')
            ->with('trace-id')
            ->andReturn('');

        $expectedPattern = '/localhost - 127.0.0.1 \[\d{2}\/\w{3}\/\d{4}:\d{2}:\d{2}:\d{2} [+-]\d{4}\] "GET \/ HTTP\/1.1" Status: 200 Size: 0 "Referer: " "UserAgent: "/';

        $loggerMock->shouldReceive('log')
            ->once()
            ->with('debug', Mockery::on(function ($message) use ($expectedPattern) {
                return preg_match($expectedPattern, $message) === 1;
            }));

        $logWriter = new LogWriter($loggerFactoryMock, $configMock);
        $logWriter->logRequest($requestMock, $responseMock);

        $this->assertTrue(true);
    }
}
