<?php

declare(strict_types=1);

namespace App\Service;

use App\Job\NotificationEmailJob;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;
use Hyperf\Context\ApplicationContext;

/**
 * Notification email queue.
 */
class NotificationEmailQueue
{
    /**
     * @var DriverInterface
     */
    protected DriverInterface $driver;

    /**
     * Method constructor.
     *
     * @param DriverFactory      $driverFactory
     * @param ApplicationContext $driverFactory
     *
     * @return void
     */
    public function __construct(
        protected DriverFactory $driverFactory,
        protected ApplicationContext $applicationContext,
    ) {
        $this->driver = $driverFactory->get('default');
    }

    /**
     * Publish the message.
     *
     * @param string $recipient
     * @param string $message
     *
     * @return bool
     */
    public function push(
        string $recipient,
        string $message,
        int $delay = 0
    ): bool {
        return $this->driver->push(new NotificationEmailJob($recipient, $message, $this->applicationContext), $delay);
    }
}
