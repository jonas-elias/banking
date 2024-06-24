<?php

declare(strict_types=1);

namespace App\Job;

use App\Constants\HttpStatus;
use Hyperf\AsyncQueue\Job;
use Hyperf\Context\ApplicationContext;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Retry\Retry;
use Psr\Log\LoggerInterface;

use function Hyperf\Config\config;

/**
 * Notification email job.
 */
class NotificationEmailJob extends Job
{
    /**
     * @var int $maxAttemps
     */
    protected int $maxAttemps = 3;

    /**
     * Method constructor.
     *
     * @param string $recipient
     * @param string $message
     *
     * @return void
     */
    public function __construct(
        protected string $recipient,
        protected string $message,
        protected ApplicationContext $app,
    ) {
    }

    /**
     * Handle message notification email.
     *
     * @return void
     */
    public function handle()
    {
        Retry::whenReturns(false)
            ->max($this->maxAttemps)
            ->inSeconds(5)
            ->sleep(1)
            ->fallback(function () {
                return true;
            })
            ->call(function () {
                $uri = config('notification.email.uri');

                $container = $this->app->getContainer();

                $clientHttp = $container->get(ClientFactory::class);
                $logger = $container->get(LoggerInterface::class);

                $request = $clientHttp->create();
                $response = $request->post($uri, [
                    'json' => [
                        'recipient' => $this->recipient,
                        'message' => $this->message,
                    ],
                    'http_errors' => false,
                ]);

                if ($response->getStatusCode() !== HttpStatus::NO_CONTENT) {
                    $logger->error($response->getBody()->getContents());
                    return false;
                }
            });
    }
}
