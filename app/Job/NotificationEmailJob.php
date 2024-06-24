<?php

declare(strict_types=1);

namespace App\Job;

use Hyperf\AsyncQueue\Job;
use Hyperf\Context\ApplicationContext;
use Hyperf\Guzzle\ClientFactory;

use function Hyperf\Config\config;

/**
 * Notification email job.
 */
class NotificationEmailJob extends Job
{
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
        $uri = config('notification.email.uri');

        $container = $this->app->getContainer();
        $clientHttp = $container->get(ClientFactory::class);

        $request = $clientHttp->create();
        $request->request('POST', $uri, [
            'json' => [
                'recipient' => $this->recipient,
                'message' => $this->message,
            ]
        ]);
    }
}
