<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 *
 * @document https://hyperf.wiki
 *
 * @contact  group@hyperf.io
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'http' => [
        FriendsOfHyperf\Http\Logger\Middleware\HttpLogger::class,
        Hyperf\Tracer\Middleware\TraceMiddleware::class,
        Hyperf\Metric\Middleware\MetricMiddleware::class,
    ],
];
