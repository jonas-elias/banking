<?php

declare(strict_types=1);

namespace App\HttpLogger;

use Carbon\Carbon;
use Hyperf\Contract\ConfigInterface;
use Hyperf\HttpMessage\Base\Response;
use Hyperf\Logger\LoggerFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function Hyperf\Support\env;

/**
 * Log writer class to create log based in http requests.
 */
class LogWriter implements LogWriterInterface
{
    /**
     * Method constructor.
     *
     * @param LoggerFactory   $loggerFactory
     * @param ConfigInterface $config
     *
     * @return void
     */
    public function __construct(private LoggerFactory $loggerFactory, private ConfigInterface $config)
    {
    }

    /**
     * Create log request.
     *
     * @param ServerRequestInterface     $request
     * @param ResponseInterface|Response $response
     *
     * @return void
     */
    public function logRequest(ServerRequestInterface $request, ResponseInterface|Response $response): void
    {
        $group = (string) $this->config->get('http_logger.log_group', 'http-logger');
        $name = (string) $this->config->get('http_logger.log_name', 'http');
        $level = (string) $this->config->get('http_logger.log_level', 'debug');
        $message = $this->formatMessage($request, $response);

        $this->loggerFactory->get($name, $group)->log($level, $message);
    }

    /**
     * Method to format message log.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return string
     */
    public function formatMessage(ServerRequestInterface $request, ResponseInterface $response): string
    {
        $context = $this->getContext($request, $response);

        return preg_replace_callback('/%(\w+)%/', fn ($matches) => $context[$matches[1]] ?? '-', (string) $this->config->get('http_logger.log_format', ''));
    }

    /**
     * Get context message.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return array
     */
    protected function getContext(ServerRequestInterface $request, ResponseInterface $response): array
    {
        $serverParams = $request->getServerParams();
        $requestPathQuery = $request->getUri()->getQuery() ? $request->getUri()->getPath() . '?' . $request->getUri()->getQuery() : $request->getUri()->getPath();

        return [
            'host' => $serverParams['host'] ?? env('APP_NAME', 'hyperf'),
            'remote_addr' => $request->getHeaderLine('x-real-ip') ?: $serverParams['remote_addr'] ?? '',
            'time_local' => Carbon::now()->format($this->config->get('http_logger.log_time_format', 'd/M/Y:H:i:s O')),
            'request' => sprintf(
                '%s %s %s',
                $request->getMethod(),
                $requestPathQuery,
                $serverParams['server_protocol'] ?? ''
            ),
            'status' => 'Status: ' . $response->getStatusCode(),
            'body_bytes_sent' => 'Size: ' . $response->getBody()->getSize(),
            'trace_id' => 'TraceId: ' . $response->getHeaderLine('trace-id') ?: '-',
            'http_referer' => 'Referer: ' . $request->getHeaderLine('referer') ?: '-',
            'http_user_agent' => 'UserAgent: ' . $request->getHeaderLine('user-agent') ?: '-',
            'http_x_forwarded_for' => 'ForwardedFor: ' . $request->getHeaderLine('x-forwarded-for') ?: '-',
            'request_time' => 'RequestTime: ' . number_format(microtime(true) - ($serverParams['request_time_float'] ?? microtime(true)), 3, '.', ''),
        ];
    }
}
